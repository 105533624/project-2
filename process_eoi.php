<?php
// ============================================================
// process_eoi.php – Handles EOI form submission + file upload
// ============================================================

// Block direct URL access (no POST data = redirect away)
if ($_SERVER["REQUEST_METHOD"] !== "POST" || empty($_POST)) {
    header("Location: apply.php");
    exit();
}

// ── DB connection ────────────────────────────────────────────
require_once "settings.php";

$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// ── Create EOI table if it doesn't exist ────────────────────
$createTable = "CREATE TABLE IF NOT EXISTS eoi (
    EOInumber     INT AUTO_INCREMENT PRIMARY KEY,
    jobref        VARCHAR(5)   NOT NULL,
    firstname     VARCHAR(20)  NOT NULL,
    lastname      VARCHAR(20)  NOT NULL,
    dob           DATE         NOT NULL,
    gender        VARCHAR(10)  NOT NULL,
    street        VARCHAR(40)  NOT NULL,
    suburb        VARCHAR(40)  NOT NULL,
    state         VARCHAR(3)   NOT NULL,
    postcode      CHAR(4)      NOT NULL,
    email         VARCHAR(100) NOT NULL,
    phone         VARCHAR(12)  NOT NULL,
    skills        VARCHAR(255),
    otherskills   TEXT,
    resume_path   VARCHAR(255),
    status        ENUM('New','Current','Final') DEFAULT 'New',
    submitted_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $createTable);

// ── Helper: sanitise a single field ─────────────────────────
function clean($conn, $value) {
    return mysqli_real_escape_string($conn, htmlspecialchars(stripslashes(trim($value))));
}

// ── Validate & sanitise POST fields ─────────────────────────
$errors = [];

$jobref    = clean($conn, $_POST["jobref"]    ?? "");
$firstname = clean($conn, $_POST["firstname"] ?? "");
$lastname  = clean($conn, $_POST["lastname"]  ?? "");
$dob       = clean($conn, $_POST["date"]      ?? "");
$gender    = clean($conn, $_POST["gender"]    ?? "");
$street    = clean($conn, $_POST["street"]    ?? "");
$suburb    = clean($conn, $_POST["suburb"]    ?? "");
$state     = clean($conn, $_POST["state"]     ?? "");
$postcode  = clean($conn, $_POST["postcode"]  ?? "");
$email     = clean($conn, $_POST["email"]     ?? "");
$phone     = clean($conn, $_POST["phone"]     ?? "");
$otherskills = clean($conn, $_POST["otherskills"] ?? "");

// Skills checkboxes → comma-separated string
$skillsArr = $_POST["skills"] ?? [];
$skills    = clean($conn, implode(", ", $skillsArr));

// Field-level validation
if (!preg_match('/^[a-zA-Z0-9]{5}$/', $jobref))
    $errors[] = "Job reference must be exactly 5 alphanumeric characters.";

if (!preg_match('/^[a-zA-Z]{1,20}$/', $firstname))
    $errors[] = "First name must be letters only, max 20 characters.";

if (!preg_match('/^[a-zA-Z]{1,20}$/', $lastname))
    $errors[] = "Last name must be letters only, max 20 characters.";

if (empty($dob))
    $errors[] = "Date of birth is required.";

if (!in_array($gender, ["male", "female", "other"]))
    $errors[] = "Please select a valid gender.";

if (!preg_match('/^[a-zA-Z0-9 ]{1,40}$/', $street))
    $errors[] = "Street address is invalid.";

if (!preg_match('/^[a-zA-Z ]{1,40}$/', $suburb))
    $errors[] = "Suburb is invalid.";

$validStates = ["VIC","NSW","QLD","NT","WA","SA","TAS","ACT"];
if (!in_array($state, $validStates))
    $errors[] = "Please select a valid state.";

if (!preg_match('/^[0-9]{4}$/', $postcode))
    $errors[] = "Postcode must be exactly 4 digits.";

if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    $errors[] = "Please enter a valid email address.";

if (!preg_match('/^[0-9]{8,12}$/', $phone))
    $errors[] = "Phone number must be 8–12 digits.";

// ── File upload handling ─────────────────────────────────────
$resume_path = null; // will be stored in DB

if (isset($_FILES["resume"]) && $_FILES["resume"]["error"] !== UPLOAD_ERR_NO_FILE) {

    $file      = $_FILES["resume"];
    $fileError = $file["error"];
    $fileName  = basename($file["name"]);
    $fileSize  = $file["size"];
    $fileTmp   = $file["tmp_name"];
    $fileExt   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Allowed types
    $allowedExts  = ["pdf", "doc", "docx"];
    $allowedMimes = ["application/pdf",
                     "application/msword",
                     "application/vnd.openxmlformats-officedocument.wordprocessingml.document"];

    // Detect real MIME type (more secure than trusting the browser)
    $finfo    = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $fileTmp);
    finfo_close($finfo);

    if ($fileError !== UPLOAD_ERR_OK) {
        $errors[] = "File upload error (code $fileError). Please try again.";
    } elseif (!in_array($fileExt, $allowedExts) || !in_array($mimeType, $allowedMimes)) {
        $errors[] = "Only PDF, DOC, or DOCX files are allowed.";
    } elseif ($fileSize > 2 * 1024 * 1024) {  // 2 MB limit
        $errors[] = "File must be under 2MB.";
    } else {
        // Create uploads folder if it doesn't exist
        $uploadDir = "uploads/resumes/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Rename file to avoid collisions and path traversal attacks
        // Format: firstname_lastname_timestamp.ext
        $safeName    = preg_replace('/[^a-zA-Z0-9]/', '_', $firstname . "_" . $lastname);
        $newFileName = $safeName . "_" . time() . "." . $fileExt;
        $destination = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmp, $destination)) {
            $resume_path = $destination; // save path for DB
        } else {
            $errors[] = "Failed to save the uploaded file. Please try again.";
        }
    }
}

// ── If any errors, show them and stop ───────────────────────
if (!empty($errors)) {
    echo "<h2>Please fix the following errors:</h2><ul>";
    foreach ($errors as $e) {
        echo "<li>" . htmlspecialchars($e) . "</li>";
    }
    echo "</ul>";
    echo "<a href='apply.php'>Go back</a>";
    mysqli_close($conn);
    exit();
}

// ── Insert into EOI table (prepared statement) ───────────────
$stmt = mysqli_prepare($conn,
    "INSERT INTO eoi
        (jobref, firstname, lastname, dob, gender,
         street, suburb, state, postcode,
         email, phone, skills, otherskills, resume_path)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

mysqli_stmt_bind_param($stmt, "ssssssssssssss",
    $jobref, $firstname, $lastname, $dob, $gender,
    $street, $suburb, $state, $postcode,
    $email, $phone, $skills, $otherskills, $resume_path
);

if (mysqli_stmt_execute($stmt)) {
    $eoiNumber = mysqli_insert_id($conn);
    // ── Success page ─────────────────────────────────────────
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Application Submitted</title>
        <link rel="stylesheet" href="styles/styles.css">
        <style>
            .success-box {
                max-width: 600px;
                margin: 80px auto;
                background: #fff;
                border: 2px solid #084887;
                border-radius: 10px;
                padding: 2.5em;
                text-align: center;
                font-family: Arial, sans-serif;
            }
            .success-box h2 { color: #084887; }
            .eoi-number {
                font-size: 2em;
                font-weight: bold;
                color: #F5C518;
                background: #084887;
                display: inline-block;
                padding: 0.3em 0.8em;
                border-radius: 8px;
                margin: 1em 0;
            }
            .success-box a {
                display: inline-block;
                margin-top: 1.5em;
                background: #084887;
                color: #fff;
                padding: 0.6em 1.4em;
                border-radius: 6px;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="success-box">
            <h2>✅ Application Submitted Successfully!</h2>
            <p>Thank you, <strong><?= htmlspecialchars($firstname) ?></strong>. Your application has been received.</p>
            <p>Your EOI reference number is:</p>
            <div class="eoi-number">#<?= $eoiNumber ?></div>
            <p style="color:#555; font-size:0.9em;">Please keep this number for your records.</p>
            <?php if ($resume_path): ?>
                <p style="color: green;">✔ Resume uploaded successfully.</p>
            <?php endif; ?>
            <a href="index.php">Return to Home</a>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "<p>Error saving application: " . mysqli_stmt_error($stmt) . "</p>";
    echo "<a href='apply.php'>Go back</a>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>