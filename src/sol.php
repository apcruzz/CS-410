<?php include("header.php"); ?>    
    <h1 id="name">Andre Paul <br>Cruz</h1>
    <h2 id="major">Computer Science Major | Arts and <br>Organizational Leadership Minor</h2>
    <img id="my-image" src="images/andreC.png" alt="images/andrebg">
    <p id="overview">Determined Computer Science major, passionate about technology to solve real-world problems. 
        I am dedicated to continuous learning and innovation. My goal is to contribute to impactful projects and advance in the tech industry.</p>

    <?php
    $name = $_GET['visitor'];
    if ($name == "Andre"){ ?>
        <p id="php">Welcome back, Andre!</p>
    <?php } else { ?>
        <p id="php">Hello, visitor!</p>
    <?php

    } ?>
    
<?php include("footer.php"); ?>