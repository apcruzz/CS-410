<?php include("header.php"); ?>
    <h1 id="name">Andre Paul <br>Cruz</h1>
    <h2 id="major">Computer Science Major | Arts and <br>Organizational Leadership Minor</h2>
    <img id="my-image" src="images/andreC.png" alt="images/andrebg">
    <p id="overview">Determined Computer Science major, passionate about technology to solve real-world problems. 
        I am dedicated to continuous learning and innovation. My goal is to contribute to impactful projects and advance in the tech industry.</p>

    <?php
    $name = $_GET['visitor'];
    if ($name == "Andre"){ ?>
        <p id="greeting">Welcome back, Andre!</p>
    <?php } else { ?>
        <p id="greeting">Hello, visitor!</p>
    <?php

    } ?>
    <!-- <div id='button-box'>
        <a class='resume' href="https://docs.google.com/document/d/1kUvVT5RSt-xTULViBrudsblfUSjlOWfD0fDGfQ2ExGM/edit" target="_blank">Download my Resume</a>
    </div> -->
<?php include("footer.php"); ?>