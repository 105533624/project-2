<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("Location: login.php");
    exit();
}

require_once("settings.php");

$status_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_btn"])) {
    $delete_ref = trim($_POST["delete_jobref"]);
    
    if ($delete_ref != "") {
        $stmt = mysqli_prepare($conn, "DELETE FROM eoi WHERE jobref = ?");
        mysqli_stmt_bind_param($stmt, "s", $delete_ref);
        mysqli_stmt_execute($stmt);
        $deleted_rows = mysqli_stmt_affected_rows($stmt);
        $status_message = "Successfully deleted " . $deleted_rows . " records for " . htmlspecialchars($delete_ref);
        mysqli_stmt_close($stmt);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_btn"])) {
    $eoi_id = (int)$_POST["eoi_id"];
    $new_status = trim($_POST["new_status"]);
    
    if ($new_status != "") {
        $stmt = mysqli_prepare($conn, "UPDATE eoi SET status = ? WHERE eoi_id = ?");
        mysqli_stmt_bind_param($stmt, "si", $new_status, $eoi_id);
        mysqli_stmt_execute($stmt);
        $status_message = "Status updated for application ID #" . $eoi_id;
        mysqli_stmt_close($stmt);
    }
}

$search_ref  = isset($_GET["search_ref"])  ? trim($_GET["search_ref"])  : "";
$search_name = isset($_GET["search_name"]) ? trim($_GET["search_name"]) : "";
$sort_field  = isset($_GET["sort_field"])  ? trim($_GET["sort_field"])  : "eoi_id";

if (!in_array($sort_field, ["eoi_id", "jobref", "firstname", "lastname", "status"])) {
    $sort_field = "eoi_id";
}

$sql_base   = "SELECT * FROM eoi";
$params     = [];
$types      = "";
$conditions = [];

if ($search_ref != "") {
    $conditions[] = "jobref = ?";
    $params[] = $search_ref;
    $types .= "s";
}

if ($search_name != "") {
    $conditions[] = "(firstname LIKE ? OR lastname LIKE ?)";
    $params[] = "%$search_name%";
    $params[] = "%$search_name%";
    $types .= "ss";
}

if (count($conditions) > 0) {
    $sql_base .= " WHERE " . implode(" AND ", $conditions);
}

$sql_base .= " ORDER BY $sort_field ASC";

$stmt = mysqli_prepare($conn, $sql_base);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$query_result = mysqli_stmt_get_result($stmt);

$page_title = "HR Dashboard";
require_once(__DIR__ . "/inc/header.inc");
?>

<main style="padding: 20px; max-width: 1200px; margin: auto;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>HR Admin Dashboard</h2>
        <p>Logged in as: <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b> | <a href="logout.php" style="color: red; font-weight: bold;">Logout</a></p>
    </div>

    <?php if ($status_message != ""): ?>
        <div class="status-msg"><?php echo htmlspecialchars($status_message); ?></div>
    <?php endif; ?>

    <div class="panel">
        <h3>Search and Filter Applications</h3>
        <form method="get" action="manage.php" style="display: flex; gap: 15px; flex-wrap: wrap;">
            <p style="margin:0;">
                <label for="search_ref">Job Reference:</label><br>
                <input type="text" id="search_ref" name="search_ref" value="<?php echo htmlspecialchars($search_ref); ?>" placeholder="e.g. WD123">
            </p>
            <p style="margin:0;">
                <label for="search_name">Applicant Name:</label><br>
                <input type="text" id="search_name" name="search_name" value="<?php echo htmlspecialchars($search_name); ?>" placeholder="First or last name">
            </p>
            <p style="margin:0; align-self: flex-end;">
                <input type="hidden" name="sort_field" value="<?php echo htmlspecialchars($sort_field); ?>">
                <button type="submit" class="cta" style="margin:0;">Apply Filters</button>
                <a href="manage.php" style="margin-left: 10px; font-size: 0.9em;">Reset All</a>
            </p>
        </form>
    </div>

    <div class="panel" style="border-left: 5px solid red;">
        <h3>Danger Zone: Delete Positions</h3>
        <form method="post" action="manage.php" onsubmit="return confirm('Are you sure you want to permanently delete all applications for this job reference?');">
            <p style="margin:0;">
                <label for="delete_jobref">Remove all records matching Job Reference: </label>
                <input type="text" id="delete_jobref" name="delete_jobref" placeholder="e.g. WD123">
                <button type="submit" name="delete_btn" style="background: red; color: white; border: none; padding: 6px 12px; cursor: pointer;">Delete Records</button>
            </p>
        </form>
    </div>

    <h3>Expressions of Interest Logs</h3>
    <p style="font-size: 0.85em; font-style: italic; color: #666;">Click any underlined column header to sort.</p>

    <table class="manage-table">
        <thead>
            <tr>
                <th><a href="manage.php?sort_field=eoi_id&search_ref=<?php echo urlencode($search_ref); ?>&search_name=<?php echo urlencode($search_name); ?>">ID</a></th>
                <th><a href="manage.php?sort_field=jobref&search_ref=<?php echo urlencode($search_ref); ?>&search_name=<?php echo urlencode($search_name); ?>">Job Ref</a></th>
                <th><a href="manage.php?sort_field=firstname&search_ref=<?php echo urlencode($search_ref); ?>&search_name=<?php echo urlencode($search_name); ?>">First Name</a></th>
                <th><a href="manage.php?sort_field=lastname&search_ref=<?php echo urlencode($search_ref); ?>&search_name=<?php echo urlencode($search_name); ?>">Last Name</a></th>
                <th>Email</th>
                <th>Phone</th>
                <th>State</th>
                <th>Skills</th>
                <th><a href="manage.php?sort_field=status&search_ref=<?php echo urlencode($search_ref); ?>&search_name=<?php echo urlencode($search_name); ?>">Status</a></th>
                <th>Modify Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($query_result && mysqli_num_rows($query_result) > 0) {
                while ($row = mysqli_fetch_assoc($query_result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['eoi_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['jobref']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['state']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['skills']) . "</td>";
                    echo "<td style='font-weight:bold;'>" . htmlspecialchars($row['status']) . "</td>";
                    echo "<td>
                            <form method='post' action='manage.php' style='margin:0; padding:0; display:inline;'>
                                <input type='hidden' name='eoi_id' value='" . $row['eoi_id'] . "'>
                                <select name='new_status' style='padding:2px;'>
                                    <option value='New'"    . ($row['status'] == 'New'     ? ' selected' : '') . ">New</option>
                                    <option value='Current'" . ($row['status'] == 'Current' ? ' selected' : '') . ">Current</option>
                                    <option value='Final'"  . ($row['status'] == 'Final'   ? ' selected' : '') . ">Final</option>
                                </select>
                                <button type='submit' name='update_btn' style='padding:2px 5px;'>Update</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10' style='text-align:center;'>No entries found matching your search.</td></tr>";
            }
            mysqli_free_result($query_result);
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</main>

<?php require_once(__DIR__ . "/inc/footer.inc"); ?>
