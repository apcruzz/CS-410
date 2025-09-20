<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Final Assignment Answers</title>
</head>
<body>

  <h1>Final Assignment: Database, Cookies, Sessions & Authentication</h1>

  <h2>1. Handling Incorrect Form Submissions</h2>
  <p>To prevent incorrect data from entering the database, use PHP validation to check that all fields are filled, the email is valid, and the password matches the confirmation. If there are errors, store the user's input in variables and repopulate the form so they don’t have to retype everything. Display error messages clearly to guide them in fixing the mistakes.</p>

  <h2>2. Editing User Account in PHP</h2>
  <p>Create a page like edit_account.php and use the session variable $_SESSION['user_id'] to identify the logged-in user. Query the database to get their current name, email, and password, then fill the form with that data. When they submit changes, update the database using their session ID to track which account is being edited.</p>

  <h2>3. Tools to Remember a Logged-In User</h2>
  <p>The primary tool used to remember if a user has logged in is PHP sessions. The session_start() function is called on every page that needs to access session data. A function called is_logged_in() is used to check if a user's ID is set in the session. This function can then be used to control what a user sees, such as showing a "logout" link instead of a "login" link, or to protect pages by redirecting unauthenticated users to the login page.</p>

  <h2>4. How the Videos Logged Someone In</h2>
  <p>The video demonstrates logging a user in using a login form. When a user submits their email and password, a POST request is sent to the server. The submitted password is hashed, and a SQL statement is used to find a user in the users database table with a matching email and hashed password. If a user is found, their user_ID and email are stored in a PHP session.</p>

</body>
</html>
