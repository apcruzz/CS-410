<!DOCTYPE html>
<html lang="en">
<head>
    <title>BYUI</title>
    <link rel="stylesheet" href="styles/pracstyle.css">

</head>
<body>
    <header>
        <nav>
            <a id="active" href="practice.html">Home</a>
            <a href="about.html">About</a>
            <a href="projects.html">Projects</a>
            <a href="contactme.html">Contact Me</a>
        </nav>
    </header>
    <main class="main-content">
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
            <p id="greeting">Hello, visitor! Feel free to explore my portfolio.</p>
        <?php

        } ?>
        <!-- <div id='button-box'>
            <a class='resume' href="https://docs.google.com/document/d/1kUvVT5RSt-xTULViBrudsblfUSjlOWfD0fDGfQ2ExGM/edit" target="_blank">Download my Resume</a>
        </div> -->
    </main>
    <footer>
        <p>My Portfolio 2024 &copy; </p>
        <div class="social">
            <a href="mailto:andrepaulcruz90@gmail.com" target="_blank">
                <img src="images/facebook1.png" alt="gmail">
            </a>
            <a href="https://www.facebook.com/andre.cruz.798?mibextid=LQQJ4d" target="_blank">
                <img src="images/facebook.png" alt="facebook icon">
            </a>
            <a href="https://github.com/apcruzz" target="_blank">
                <img src="images/github.png" alt="github">
            </a>
            <a href="https://www.linkedin.com/in/andre-paul-cruz-byuh" target="_blank">
                <img src="images/linkedin.png" alt="linkedin ">
            </a>
        </div>
    </footer>
</body>
</html>