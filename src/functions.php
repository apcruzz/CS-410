<?php
function connectDB() {
    $db = mysqli_connect("localhost", "andreCruz", "password",);
    return $db;
}
function closeDB($db) {
    mysqli_close($db);
}
?>
