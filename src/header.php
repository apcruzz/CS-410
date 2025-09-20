<!DOCTYPE html>
<html lang="en">
<head>
    <title>BYUI</title>
    <link rel="stylesheet" href="styles/pracstyle.css">

</head>
<body>
    <header>
    <?php 
        $current_page = basename($_SERVER['PHP_SELF']); // to make the active link work
    ?>
    <nav> <!-- to highlight the active links -->
        <a class="<?php echo $current_page == 'myport.php' ? 'active' : ''; ?>" href="myport.php">Home</a> 
        <a class="<?php echo $current_page == 'members.php' ? 'active' : ''; ?>" href="members.php">Members</a>
        <a class="<?php echo $current_page == 'database.php' ? 'active' : ''; ?>" href="database.php">Sign Up</a>
        <a class="<?php echo $current_page == 'member.php' ? 'active' : ''; ?>" href="#">Member Profile</a>
        <a class="<?php echo $current_page == 'text.php' ? 'active' : ''; ?>" href="text.php">Text</a>
    </nav>
</header>
<main class="main-content">