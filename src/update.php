<?php 
include 'header.php'; 

$valid_post = false;
$error_string = "";
$password_match_error = false;
$name_error = false;
$email_error = false;

$connection = mysqli_init();
$connection->real_connect(
    $_ENV["DATABASE_HOST"],
    $_ENV["DATABASE_USER"],
    $_ENV["DATABASE_PASSWORD"],
    $_ENV["DATABASE_DB"]
);

$id = intval($_GET['id'] ?? $_POST['id'] ?? 0);

// Load user data for prefilling form
$member = null;
if ($id > 0) {
    $sql_query = "SELECT * FROM guestbook WHERE id = $id";
    $result = mysqli_query($connection, $sql_query);
    if ($result && mysqli_num_rows($result) === 1) {
        $member = mysqli_fetch_assoc($result);
    } else {
        echo "User not found.";
        include 'footer.php';
        exit();
    }
}

// --- Handle form submission ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid_post = true;

    $username = trim($_POST['username'] ?? "");
    $email = trim($_POST['email'] ?? "");
    $password = $_POST['password'] ?? "";
    $confirm_password = $_POST['confirm_password'] ?? "";

    // --- Validation ---
    if (strlen($username) < 3) {
        $valid_post = false;
        $error_string .= "Username must be at least 3 characters long.<br>";
        $name_error = true;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $valid_post = false;
        $error_string .= "Invalid email address.<br>";
        $email_error = true;
    }

    // Only validate password if entered
    if (!empty($password) || !empty($confirm_password)) {
        if ($password !== $confirm_password) {
            $valid_post = false;
            $error_string .= "Passwords do not match.<br>";
            $password_match_error = true;
        }
        if (strlen($password) < 8) {
            $valid_post = false;
            $error_string .= "Password must be at least 8 characters long.<br>";
            $password_match_error = true;
        }
    }

    // --- Check for duplicate username ---
    if ($valid_post) {
        $check = $connection->prepare("SELECT * FROM guestbook WHERE visitor_name = ? AND id != ?");
        $check->bind_param("si", $username, $id);
        $check->execute();
        $check_result = $check->get_result();

        if ($check_result->num_rows > 0) {
            $valid_post = false;
            $error_string .= "Username already in use.<br>";
            $name_error = true;
        }
        $check->close();
    }

    // --- Check for duplicate email (stored in note field) ---
    if ($valid_post) {
        $check = $connection->prepare("SELECT * FROM guestbook WHERE note = ? AND id != ?");
        $check->bind_param("si", $email, $id);
        $check->execute();
        $check_result = $check->get_result();

        if ($check_result->num_rows > 0) {
            $valid_post = false;
            $error_string .= "Email already in use.<br>";
            $email_error = true;
        }
        $check->close();
    }

    // --- Perform UPDATE ---
    if ($valid_post) {
        if (!empty($password)) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $connection->prepare("UPDATE guestbook SET visitor_name=?, note=?, password=? WHERE id=?");
            $stmt->bind_param("sssi", $username, $email, $hashed, $id);
        } else {
            $stmt = $connection->prepare("UPDATE guestbook SET visitor_name=?, note=? WHERE id=?");
            $stmt->bind_param("ssi", $username, $email, $id);
        }

        if (!$stmt->execute()) {
            $error_string .= "Database error: " . $stmt->error . "<br>";
            $valid_post = false;
        } else {
            $member['visitor_name'] = $username;
            $member['note'] = $email;
        }
        $stmt->close();
    }
}

?>

<?php if ($valid_post) { ?>
    <h2 id="success-message">Information Updated</h2>
    <p id="success-text">Thank you for updating your information, <?php echo htmlspecialchars($member['visitor_name']); ?>.</p>

<?php } else { ?>
    <h1 id="page-title">Update Information</h1>
    <?php if ($error_string) { ?>
        <p id="error-message"><?php echo $error_string; ?></p>
    <?php } ?>

    <form action="database.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($member['id'] ?? $id); ?>">

        <label for="username" <?php echo ($name_error) ? 'class="label-error"' : ''; ?>>Username:</label>
        <input type="text" id="username" name="username" 
            value="<?php echo htmlspecialchars($member['visitor_name'] ?? ''); ?>"
            <?php echo ($name_error) ? 'class="input-error"' : ''; ?> required><br><br>

        <label for="email" <?php echo ($email_error) ? 'class="label-error"' : ''; ?>>Email:</label>
        <input type="email" id="email" name="email" 
            value="<?php echo htmlspecialchars($member['note'] ?? ''); ?>"
            <?php echo ($email_error) ? 'class="input-error"' : ''; ?> required><br><br>

        <p id="password-help">Leave password blank if you don't want to change it.</p>

        <label for="password" <?php echo ($password_match_error) ? 'class="label-error"' : ''; ?>>Password:</label>
        <input type="password" id="password" name="password" 
            <?php echo ($password_match_error) ? 'class="input-error"' : ''; ?>><br><br>

        <label for="confirm_password" <?php echo ($password_match_error) ? 'class="label-error"' : ''; ?>>Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" 
            <?php echo ($password_match_error) ? 'class="input-error"' : ''; ?>><br><br>

        <input type="submit" value="Update">
    </form>
<?php } ?>

<?php 
$connection->close();
include 'footer.php'; 
?>
