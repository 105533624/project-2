<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["jobref"])) {
    header("Location: apply.php");
    exit();
}

require_once("settings.php");

$table_query = "CREATE TABLE IF NOT EXISTS eoi (
    eoi_id INT AUTO_INCREMENT PRIMARY KEY,
    jobref VARCHAR(5) NOT NULL,
    firstname VARCHAR(20) NOT NULL,
    lastname VARCHAR(20) NOT NULL,
    dob DATE NOT NULL,
    gender VARCHAR(10) NOT NULL,
    street VARCHAR(40) NOT NULL,
    suburb VARCHAR(40) NOT NULL,
    state VARCHAR(3) NOT NULL,
    postcode VARCHAR(4) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(12) NOT NULL,
    skills TEXT,
    otherskills TEXT,
    status ENUM('New', 'Current', 'Final') DEFAULT 'New' NOT NULL
)";

if (!mysqli_query($conn, $table_query)) {
    die("Table creation failed: " . mysqli_error($conn));
}

function sanitise($data) {
    return trim(stripslashes($data));
}

$jobref        = sanitise($_POST["jobref"]);
$firstname     = sanitise($_POST["firstname"]);
$lastname      = sanitise($_POST["lastname"]);
$dob           = sanitise($_POST["date"]);
$gender        = isset($_POST["gender"]) ? sanitise($_POST["gender"]) : "";
$street        = sanitise($_POST["street"]);
$suburb        = sanitise($_POST["suburb"]);
$state         = isset($_POST["state"]) ? sanitise($_POST["state"]) : "";
$postcode      = sanitise($_POST["postcode"]);
$email         = sanitise($_POST["email"]);
$phone         = sanitise($_POST["phone"]);
$otherskills   = isset($_POST["otherskills"]) ? sanitise($_POST["otherskills"]) : "";
$skills_array  = isset($_POST["skills"]) ? $_POST["skills"] : [];
$skills_string = implode(", ", array_map('sanitise', $skills_array));

$errors = [];

if (!preg_match("/^[a-zA-Z0-9]{5}$/", $jobref)) {
    $errors[] = "Job reference number must be exactly 5 alphanumeric characters.";
}

if (empty($firstname) || !preg_match("/^[a-zA-Z]{1,20}$/", $firstname)) {
    $errors[] = "First name is required and can only contain up to 20 letters.";
}

if (empty($lastname) || !preg_match("/^[a-zA-Z]{1,20}$/", $lastname)) {
    $errors[] = "Last name is required and can only contain up to 20 letters.";
}

if (empty($dob)) {
    $errors[] = "Date of birth is required.";
} else {
    $birthDate = DateTime::createFromFormat('d/m/Y', $dob);
    if (!$birthDate) {
        $errors[] = "Date of birth must be in DD/MM/YYYY format.";
    } else {
        $age = (new DateTime())->diff($birthDate)->y;
        if ($age < 15 || $age > 80) {
            $errors[] = "Applicant must be between 15 and 80 years old.";
        }
        $dob = $birthDate->format('Y-m-d');
    }
}

if (empty($gender)) {
    $errors[] = "Gender selection is required.";
}

if (empty($street) || strlen($street) > 40) {
    $errors[] = "Street address is required and cannot exceed 40 characters.";
}

if (empty($suburb) || strlen($suburb) > 40) {
    $errors[] = "Suburb/Town is required and cannot exceed 40 characters.";
}

if (empty($state)) {
    $errors[] = "Please select a valid Australian state.";
}

if (!preg_match("/^[0-9]{4}$/", $postcode)) {
    $errors[] = "Postcode must be exactly 4 digits.";
} else {
    $first_digit = $postcode[0];
    if ($state === "VIC" && $first_digit !== '3' && $first_digit !== '8') $errors[] = "VIC postcodes must start with 3 or 8.";
    if ($state === "NSW" && $first_digit !== '1' && $first_digit !== '2') $errors[] = "NSW postcodes must start with 1 or 2.";
    if ($state === "QLD" && $first_digit !== '4' && $first_digit !== '9') $errors[] = "QLD postcodes must start with 4 or 9.";
    if ($state === "NT"  && $first_digit !== '0') $errors[] = "NT postcodes must start with 0.";
    if ($state === "WA"  && $first_digit !== '6') $errors[] = "WA postcodes must start with 6.";
    if ($state === "SA"  && $first_digit !== '5') $errors[] = "SA postcodes must start with 5.";
    if ($state === "TAS" && $first_digit !== '7') $errors[] = "TAS postcodes must start with 7.";
    if ($state === "ACT" && $first_digit !== '0') $errors[] = "ACT postcodes must start with 0.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
}

if (!preg_match("/^[0-9]{8,12}$/", $phone)) {
    $errors[] = "Phone number must be between 8 and 12 digits.";
}

if (count($errors) > 0) {
    echo "<!DOCTYPE html><html lang='en'>";
    echo "<head><title>Validation Errors</title><link rel='stylesheet' href='/project-2/styles/styles.css'></head>";
    echo "<body>";
    include_once("inc/header.inc");
    
    // Clean: No more inline style rules here!
    echo "<main class='msg-container'>";
    echo "<h2 class='error-heading'>Application Submission Failed</h2>";
    echo "<p>Please fix the following errors:</p>";
    echo "<ul class='error-list'>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
    echo "<p><a href='apply.php' class='cta'>Return to Form</a></p>";
    echo "</main>";
    
    include_once("inc/footer.inc");
    echo "</body></html>";
} else {
    $stmt = mysqli_prepare($conn, "INSERT INTO eoi (jobref, firstname, lastname, dob, gender, street, suburb, state, postcode, email, phone, skills, otherskills, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'New')");

    mysqli_stmt_bind_param($stmt, "sssssssssssss", $jobref, $firstname, $lastname, $dob, $gender, $street, $suburb, $state, $postcode, $email, $phone, $skills_string, $otherskills);

    if (mysqli_stmt_execute($stmt)) {
        $generated_id = mysqli_insert_id($conn);
        echo "<!DOCTYPE html><html lang='en'>";
        echo "<head><title>Application Successful</title><link rel='stylesheet' href='/project-2/styles/styles.css'></head>";
        echo "<body>";
        include_once("inc/header.inc");
        
        // Clean: Replaced raw HTML style strings with css class targets
        echo "<main class='success-container'>";
        echo "<h2 class='success-heading'>Application Submitted Successfully!</h2>";
        echo "<p class='success-id-text'>Your EOI Reference Number: <strong>" . $generated_id . "</strong></p>";
        echo "<p>Thank you for applying. Our HR team will be in touch shortly.</p>";
        echo "</main>";
        
        include_once("inc/footer.inc");
        echo "</body></html>";
    } else {
        die("Insertion failed: " . mysqli_error($conn));
    }
}

mysqli_close($conn);
?>
