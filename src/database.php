<?php
include("header.php");

// Initialize flags
$valid_post = false;
$error_string = "";
$password_match_error = false;
$name_error = false;
$email_error = false;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid_post = true;
    $username = trim($_POST['username'] ?? "");
    $email = trim($_POST['email'] ?? "");
    $password = $_POST['password'] ?? "";
    $confirm_password = $_POST['confirm_password'] ?? "";

    // --- Validation ---
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
    
    // --- Insert into DB if valid ---
    if ($valid_post) {
        $connection = mysqli_init();
        $connection->real_connect(
            $_ENV["DATABASE_HOST"],
            $_ENV["DATABASE_USER"],
            $_ENV["DATABASE_PASSWORD"],
            $_ENV["DATABASE_DB"]
        );

        if ($connection->connect_errno) {
            $valid_post = false;
            $error_string .= "Database connection failed: " . $connection->connect_error . "<br>";
        } else {
            // --- Check for duplicate username ---
            $check = $connection->prepare("SELECT * FROM guestbook WHERE visitor_name = ?");
            $check->bind_param("s", $username);
            $check->execute();
            $check_result = $check->get_result();

            if ($check_result->num_rows > 0) {
                $valid_post = false;
                $error_string .= "Username already in use.<br>";
                $name_error = true;
            }
            $check->close();

            // --- Check for duplicate email ---
            if ($valid_post) {
                $check = $connection->prepare("SELECT * FROM guestbook WHERE note = ?");
                $check->bind_param("s", $email);
                $check->execute();
                $check_result = $check->get_result();

                if ($check_result->num_rows > 0) {
                    $valid_post = false;
                    $error_string .= "Email already in use.<br>";
                    $email_error = true;
                }
                $check->close();
            }

            // --- Insert into guestbook if still valid ---
            if ($valid_post) {
                $stmt = $connection->prepare("INSERT INTO guestbook (visitor_name, note) VALUES (?, ?)");
                $note = $email;
                $stmt->bind_param("ss", $username, $note);

                if (!$stmt->execute()) {
                    $valid_post = false;
                    $error_string .= "Database error: " . $stmt->error;
                }

                $stmt->close();
            }

            $connection->close();
        }
    }
}
?>

<?php if ($valid_post) { ?>
    <h2 id="success-message">Registration Successful!</h2>
    <p id="success-text">Thank you for registering, <?php echo htmlspecialchars($username); ?>. 
    You can now log in with your credentials.</p>

<?php } else { ?>
    <div class="form-container">
    <h1 id="page-title">Welcome Please Register</h1>
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

        <label for="password" <?php echo ($password_match_error) ? 'class="label-error"' : ''; ?>>Password:</label>
        <input type="password" id="password" name="password" 
            <?php echo ($password_match_error) ? 'class="input-error"' : ''; ?> required><br><br>

        <label for="confirm_password" <?php echo ($password_match_error) ? 'class="label-error"' : ''; ?>>Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" 
            <?php echo ($password_match_error) ? 'class="input-error"' : ''; ?> required><br><br>

        <input type="submit" value="Register">
    </form>
    </div>
<?php } ?>

<!-- <h2>Guestbook</h2>
<table cellspacing="8">
    <tr>
        <th>Name</th>
        <th>Visited</th>
        <th>Note</th>
    </tr> -->

<?php
$connection = mysqli_init();
$connection->real_connect(
    $_ENV["DATABASE_HOST"],
    $_ENV["DATABASE_USER"],
    $_ENV["DATABASE_PASSWORD"],
    $_ENV["DATABASE_DB"]
);

// $result = mysqli_query($connection, "SELECT * FROM guestbook ORDER BY created_at DESC");
// while($row = mysqli_fetch_array($result)) {
//     print "<tr>";
//     print "<td>" . htmlspecialchars($row["visitor_name"]) . "</td>";
//     print "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
//     print "<td>" . htmlspecialchars($row["note"]) . "</td>";
//     print "</tr>";
// }
$connection->close();
?>
<!-- </table> -->
<?php include("footer.php"); ?>
