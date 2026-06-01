<!-- Generative AI tool (e.g., ChatGPT) was used for suggestions, code improvement,adding comments and image generation.All AI-generated code was reviewed and modified by the author before use. -->

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("settings.php");

$search = "";
$sort = "id ASC";

$sql = "SELECT * FROM jobs";

$params = [];
$types = "";

if (isset($_GET["search"]) && !empty(trim($_GET["search"]))) {
    $search = trim($_GET["search"]);
    $sql .= " WHERE title LIKE ? OR description LIKE ? OR job_reference LIKE ?";
    $search_term = "%$search%";

    $params[] = $search_term;
    $params[] = $search_term;
    $params[] = $search_term;
    $types .= "sss";
}

if (isset($_GET["sort"])) {
    switch ($_GET["sort"]) {
        case "salary":
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

/* Error catcher to identify database table layout mismatches */
if (!$stmt) {
    die("<strong>SQL Preparation Error:</strong> " . mysqli_error($conn) . "<br><br><strong>Query Attempted:</strong> " . $sql);
}

if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$page_title = "Jobs & Careers";

require_once(__DIR__ . "/inc/header.inc");
?>

<main class="jobs-container">

    <div class="jobs-main">

        <div class="jobs-intro">
            <p>
                Browse our current openings below. 
                Applications are reviewed within 5 business days.
            </p>
        </div>

        <form method="get" action="jobs.php" class="search-form">
            <input
                type="text"
                name="search"
                placeholder="Search jobs..."
                value="<?php echo htmlspecialchars($search); ?>"
            >

            <select name="sort">
                <option value="">Sort Jobs</option>
                <option value="salary" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'salary') echo 'selected'; ?>>
                    Sort by Salary
                </option>
                <option value="closing" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'closing') echo 'selected'; ?>>
                    Sort by Closing Date
                </option>
            </select>

            <button type="submit" class="search-btn">Search</button>
        </form>

        <?php if ($search != ""): ?>
    <p style="font-style:italic; color:#084887;">
        Showing <?php echo mysqli_num_rows($result); ?> result(s) for "<?php echo htmlspecialchars($search); ?>"
    </p>
<?php endif; ?>

        <?php
        if (mysqli_num_rows($result) == 0) {
            echo "<p class='no-results'>No job vacancies match your criteria at this time.</p>";
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
                <span class="salary-tag"><?php echo htmlspecialchars($row["salary"]); ?></span> 
                | <strong>Reports to:</strong> <?php echo htmlspecialchars($row["reports_to"]); ?>
            </p>

            <p class="job-description-text">
                <?php echo htmlspecialchars($row["description"]); ?>
            </p>

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
                <em>Applications close on: <strong><?php echo htmlspecialchars($row["closing_date"]); ?></strong></em>
            </p>

            <a class="cta" href="apply.php?jobref=<?php echo urlencode($row["job_reference"]); ?>">
                Apply Now
            </a>
        </section>

        <?php } ?>

    </div>

    <aside class="benefits-sidebar">
        <h2>Why Join Us?</h2>
        <p>
            We offer flexible working hours, remote options, and a dedicated creative environment.
        </p>
        <p>
            We prioritise inclusive design and accessibility.
        </p>
    </aside>

</main>

<?php
require_once(__DIR__ . "/inc/footer.inc");
mysqli_close($conn);
?>
