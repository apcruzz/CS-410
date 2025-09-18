<?php 
include("header1.php");
require_once('functions.php');
$db = connectDB();

$valid_post = true;
$error_string = "";
$password_match_error = false;
$name_error = false;   
$email_error = false;  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['password'] != $_POST["confirm_password"]) {
        $valid_post = false;
        $error_string .= "Passwords do not match.<br>";
        $password_match_error = true;
    }
    if (strlen($_POST['password']) < 8) {
        $valid_post = false;
        $error_string .= "Password must be at least 8 characters long.<br>";
        $password_match_error = true; 
    }
    if (strlen($_POST['username']) < 3) {
        $valid_post = false;
        $error_string .= "Username must be at least 3 characters long.<br>";
        $name_error = true;
    }
    if (!$valid_post){
        $error_string .= "Please correct the errors and try again.";
    }
} else {
    $valid_post = false;
}

?>
<?php if ($valid_post) { ?>
    <h2 id="success-message">Registration Successful!</h2>
    <p id="success-text">Thank you for registering, <?php echo htmlspecialchars($_POST['username'] ?? ''); ?>. You can now log in with your credentials.</p>
<?php } else { ?>
    <h1 id="page-title">Welcome Please Register</h1>
    <?php if ($error_string) { ?>
        <p id="error-message"><?php echo $error_string; ?></p>
    <?php } ?>
    <form action="database.php" method="post">
        <label for="username" <?php echo ($name_error) ? 'class="label-error"' : ''; ?>>Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
        <?php echo ($name_error) ? 'class="input-error"' : ''; ?> required><br><br>

        <label for="email" <?php echo ($email_error) ? 'class="label-error"' : ''; ?>>Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
        <?php echo ($email_error) ? 'class="input-error"' : ''; ?> required><br><br>

        <label for="password" <?php echo ($password_match_error) ? 'class="label-error"' : ''; ?>>Password:</label>
        <input type="password" id="password" name="password" <?php echo ($password_match_error) ? 'class="input-error"' : ''; ?> required><br><br>

        <label for="confirm_password" <?php echo ($password_match_error) ? 'class="label-error"' : ''; ?>>Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" <?php echo ($password_match_error) ? 'class="input-error"' : ''; ?> required><br><br>

        <input type="submit" value="Register">
    </form> 
<?php } ?>
<?php include("footer.php"); ?>
