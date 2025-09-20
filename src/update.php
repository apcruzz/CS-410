<?php 
include 'header.php'; 

$connection = mysqli_init();
$connection->real_connect(
    $_ENV["DATABASE_HOST"],
    $_ENV["DATABASE_USER"],
    $_ENV["DATABASE_PASSWORD"],
    $_ENV["DATABASE_DB"]
);

$sql_query = "SELECT * FROM guestbook WHERE id = " . intval($_GET['id']);
//echo $sql_query;
$result = mysqli_query($connection, $sql_query);
if (!$result) {
    print "Database query failed: " . mysqli_error($connection);
    exit();
}
if(mysqli_num_rows($result) != 1) {
    echo "User not found <br>Rows" .mysqli_num_rows($result);
    exit();
}

$valid_post = false;
$error_string = "";
$password_match_error = false;
$name_error = false;
$email_error = false;

// NOTE TO SELF WE CAN MAKE THIS CODE ON TOP A FUNCTION
$member = mysqli_fetch_assoc($result);


?>
<?php if ($valid_post) { ?>
    <h2 id="success-message">Information Updated</h2>
    <p id="success-text">Thank you for updating your information, <?php echo htmlspecialchars($username); ?>.</p>

<?php } else { ?>
    <h1 id="page-title">Updated Information</h1>
    <?php if ($error_string) { ?>
        <p id="error-message"><?php echo $error_string; ?></p>
    <?php } ?>

    <form action="database.php" method="post">
        <label for="username" <?php echo ($name_error) ? 'class="label-error"' : ''; ?>>Username:</label>
        <input type="text" id="username" name="username" 
            value="<?php echo htmlspecialchars($username ?? ''); ?>"
            <?php echo ($name_error) ? 'class="input-error"' : ''; ?> required><br><br>

        <label for="email" <?php echo ($email_error) ? 'class="label-error"' : ''; ?>>Email:</label>
        <input type="email" id="email" name="email" 
            value="<?php echo htmlspecialchars($email ?? ''); ?>"
            <?php echo ($email_error) ? 'class="input-error"' : ''; ?> required><br><br>
        <p id="password-help">Leave password blank if you don't want to change it.</p>

        <label for="password" <?php echo ($password_match_error) ? 'class="label-error"' : ''; ?>>Password:</label>
        <input type="password" id="password" name="password" 
            <?php echo ($password_match_error) ? 'class="input-error"' : ''; ?> required><br><br>

        <label for="confirm_password" <?php echo ($password_match_error) ? 'class="label-error"' : ''; ?>>Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" 
            <?php echo ($password_match_error) ? 'class="input-error"' : ''; ?> required><br><br>

        <input type="submit" value="Update">
    </form>
<?php } ?>
<?php include 'footer.php'; ?>
