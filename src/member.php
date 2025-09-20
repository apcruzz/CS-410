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
$member = mysqli_fetch_assoc($result);
?>

<!-- I will display the member with id=<?php echo $_GET['id']; ?> to get users ID -->

<div id="member-details">
    <h2>Member Details</h2>
    <p>ID: <?php echo htmlspecialchars($member["id"]); ?></p>
    <p>Name: <?php echo htmlspecialchars($member["visitor_name"]); ?></p>
    <p>Email: <?php echo htmlspecialchars($member["note"]); ?></p>
</div>
<a class="update-button" href="update.php?id=<?php echo $_GET['id']?>">Update</a>

<?php include 'footer.php'; ?>
