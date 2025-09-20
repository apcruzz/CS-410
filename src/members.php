<?php 
include 'header.php'; 

$connection = mysqli_init();
$connection->real_connect(
    $_ENV["DATABASE_HOST"],
    $_ENV["DATABASE_USER"],
    $_ENV["DATABASE_PASSWORD"],
    $_ENV["DATABASE_DB"]
);

$sql_query = "SELECT * FROM guestbook ORDER BY created_at DESC";
$result_guestbook = mysqli_query($connection, $sql_query);

if (!$result_guestbook) {
    print "Database query failed: " . mysqli_error($connection);
    exit();
}

$result_members = mysqli_query($connection, "SELECT * FROM guestbook ORDER BY id ASC");

?>

<h2>Members Area</h2>
<p>This is a private area for our members.</p>

<table>
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Name</th>       
    </tr>
    <?php
    while ($member = mysqli_fetch_assoc($result_members)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($member["id"]); ?></td>
            <td>
                <a href="member.php?id=<?php echo htmlspecialchars($member["id"]); ?>">
                <?php echo htmlspecialchars($member["note"]); ?>
                </a>
            </td>
            <td><?php echo htmlspecialchars($member["visitor_name"]); ?></td>
        </tr>
    <?php } ?>
</table>

<?php 
$connection->close();
include 'footer.php'; 
?>
