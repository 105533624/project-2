<!-- Generative AI tool (e.g., ChatGPT) was used for suggestions, code improvement,adding comments and image generation.All AI-generated code was reviewed and modified by the author before use. -->

<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("settings.php");

$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_input = trim($_POST["username"]);
    $pass_input = trim($_POST["password"]);

    if ($user_input != "" && $pass_input != "") {
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $user_input);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($pass_input, $row['password'])) {
                $_SESSION["authenticated"] = true;
                $_SESSION["username"] = $row['username'];
                header("Location: manage.php");
                exit();
            } else {
                $error_msg = "Wrong username or password.";
            }
        } else {
            $error_msg = "Wrong username or password.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $error_msg = "Both fields are required.";
    }
}

mysqli_close($conn);

$page_title = "Login";
require_once(__DIR__ . "/inc/header.inc");
?>

<main style="max-width: 400px; margin: 50px auto; padding: 20px;">
    <form class="form-container" method="post" action="login.php" style="padding: 20px; border: 1px solid #ccc;">
        <h2 style="text-align: center;">Staff Login</h2>

        <?php if ($error_msg != ""): ?>
            <p style="color: red; text-align: center;">
                <?php echo htmlspecialchars($error_msg); ?>
            </p>
        <?php endif; ?>

        <p>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" style="width:100%; padding:6px;">
        </p>

        <p>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" style="width:100%; padding:6px;">
        </p>

        <p style="text-align: center;">
            <button type="submit" class="cta" style="width: 100%;">Log In</button>
        </p>
    </form>
</main>

<?php require_once(__DIR__ . "/inc/footer.inc"); ?>
