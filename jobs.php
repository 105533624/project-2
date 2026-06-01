<!-- Generative AI tool (e.g., ChatGPT) was used for suggestions, code improvement,adding comments and image generation.All AI-generated code was reviewed and modified by the author before use. -->
 <!DOCTYPE html>
<html lang="en">
<head>
    <!-- =========================
         META DATA + PAGE INFO
    ========================== -->
    <meta charset="UTF-8"><!-- Character encoding (supports all text characters) -->
    <meta name="description" content="about.html"> <!-- Page description -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="HTML, Doctype, Head, Body, Meta, Paragraph, Headings, Strong, Emphasis"><!-- SEO keywords -->
    <meta name="author" content="Rafay"><!-- Author of the page -->
    <title>NextGen Web Works - About Us</title> <!-- Browser tab title -->
    <link rel="stylesheet" href="styles/styles.css"> <!-- External CSS file -->
     <!-- =========================
         HEADER (LOGO + NAVIGATION)
    ========================== -->
    <header>
        <div class="logo">
            <!-- Company logo -->
            <img src="images/logo.png" alt="NextGen Web Works Logo" width="100"><!-- Logo generated using CHATGPT (OpenAI, Free version).-->
            <div class="logo-text">
            <!--Website name-->
                <h1>NextGen Web Works</h1>
            </div>
        </div>
        <!-- Navigation menu -->
        <nav>
            <ul>
                <li><a href="index.php" title="Home Page">Home</a></li>
                <li><a href="jobs.php" title="Browse Careers">Jobs</a></li>
                <li><a href="apply.php" title="Submit Application">Apply</a></li>
                <li><a href="about.php" title="About the Team">About Us</a></li>
            </ul>
        </nav>
    </header>
    <?php
require_once("settings.php");

/* =========================
   DATABASE CONNECTION
========================= */
$conn = mysqli_connect($db_host, $db_user, $db_pwd, $sql_db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

/* =========================
   SEARCH + SORT
========================= */
$search = "";
$sort = "id ASC";

$sql = "SELECT * FROM jobs";

$params = [];
$types = "";

/* SEARCH */
if (isset($_GET["search"]) && !empty(trim($_GET["search"]))) {

    $search = trim($_GET["search"]);

    $sql .= " WHERE title LIKE ? OR description LIKE ? OR job_reference LIKE ?";

    $search_term = "%$search%";

    $params[] = $search_term;
    $params[] = $search_term;
    $params[] = $search_term;

    $types .= "sss";
}

/* SORT */
if (isset($_GET["sort"])) {

    switch ($_GET["sort"]) {

        case "salary":

            // extract first number from salary string for sorting
            $sort = "CAST(REPLACE(SUBSTRING_INDEX(salary, '-', 1), '$', '') AS UNSIGNED) ASC";
            break;

        case "closing":
            $sort = "closing_date ASC";
            break;

        default:
            $sort = "id ASC";
    }
}

$sql .= " ORDER BY $sort";

$stmt = mysqli_prepare($conn, $sql);

if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

include("includes/header.inc");
include("includes/nav.inc");
?>

<main class="jobs-container">

    <!-- LEFT SIDE -->
    <div class="jobs-main">

        <div class="jobs-intro">
            <p>
                Browse our current openings below.
                Applications are reviewed within 5 business days.
            </p>
        </div>

        <!-- SEARCH + SORT -->
        <form method="get" action="jobs.php" class="search-form">

            <input
                type="text"
                name="search"
                placeholder="Search jobs..."
                value="<?php echo htmlspecialchars($search); ?>"
            >

            <select name="sort">

                <option value="">Sort Jobs</option>

                <option value="salary"
                    <?php
                    if (isset($_GET['sort']) && $_GET['sort'] == 'salary') {
                        echo 'selected';
                    }
                    ?>>
                    Sort by Salary
                </option>

                <option value="closing"
                    <?php
                    if (isset($_GET['sort']) && $_GET['sort'] == 'closing') {
                        echo 'selected';
                    }
                    ?>>
                    Sort by Closing Date
                </option>

            </select>

            <button type="submit">Search</button>

        </form>

        <?php
        if (mysqli_num_rows($result) == 0) {
            echo "<p class='no-results'>No jobs found.</p>";
        }

        while ($row = mysqli_fetch_assoc($result)) {
        ?>

        <section class="job-listing">

            <h2>
                <?php echo htmlspecialchars($row["title"]); ?>

                <span class="ref-number">
                    <?php echo htmlspecialchars($row["job_reference"]); ?>
                </span>
            </h2>

            <p>
                <span class="salary-tag">
                    <?php echo htmlspecialchars($row["salary"]); ?>
                </span>

                | <strong>Reports to:</strong>

                <?php echo htmlspecialchars($row["reports_to"]); ?>
            </p>

            <p>
                <?php echo htmlspecialchars($row["description"]); ?>
            </p>

            <!-- RESPONSIBILITIES -->
            <h3>Key Responsibilities</h3>

            <ul>
                <?php
                foreach (explode("\n", $row["responsibilities"]) as $item) {

                    if (trim($item) != "") {
                        echo "<li>" . htmlspecialchars(trim($item)) . "</li>";
                    }
                }
                ?>
            </ul>

            <!-- ESSENTIAL -->
            <h3>Essential Requirements</h3>

            <ul>
                <?php
                foreach (explode("\n", $row["essential_requirements"]) as $item) {

                    if (trim($item) != "") {
                        echo "<li>" . htmlspecialchars(trim($item)) . "</li>";
                    }
                }
                ?>
            </ul>

            <!-- PREFERRED -->
            <h3>Preferred Requirements</h3>

            <ul>
                <?php
                foreach (explode("\n", $row["preferred_requirements"]) as $item) {

                    if (trim($item) != "") {
                        echo "<li>" . htmlspecialchars(trim($item)) . "</li>";
                    }
                }
                ?>
            </ul>

            <p class="closing-date">
                <em>
                    Applications close on
                    <?php echo htmlspecialchars($row["closing_date"]); ?>
                </em>
            </p>

            <a
                class="cta"
                href="apply.php?jobref=<?php echo urlencode($row["job_reference"]); ?>"
            >
                Apply Now
            </a>

        </section>

        <?php } ?>

    </div>

    <!-- RIGHT SIDE -->
    <aside class="benefits-sidebar">

        <h2>Why Join Us?</h2>

        <p>
            We offer flexible working hours,
            remote options, and a dedicated creative environment.
        </p>

        <p>
            We prioritise inclusive design and accessibility.
        </p>

    </aside>

</main>

<?php
include("includes/footer.inc");
mysqli_close($conn);
?>