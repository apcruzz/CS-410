<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>template</title>
</head>
<body>
    <header>My Cool Site</header>
    <nav>
        <a href = "#"> Link 1</a>
        <a href="#"> Link 2</a>
    </nav>
    <main role="main">
        <h1>
            My First PHP Page
        </h1>
        <!-- this is a comment in HTML -->
        <p>
        <?php
            //THIS IS A COMMENT
            /*THIS IS ALSO A COMMENT
            BUT IN MULTIPLE LINE
            */
            #This is another comment.

            $myString = "Hi Class";
            $myString = $myString."<br/>This is php!";
            echo "$myString Even More";

            echo "</br>This is my value ";

            $mynumber = 5;
            $mynumber = 10 + $mynumber;

            echo "<span>$mynumber</span>";
        ?>
        </p>
        <h2>User Input</h2>
        <p><?php
        echo "Your name is ".$_GET['name']."!";
        echo "Your age is ".$_GET['age']."!";
        ?></p>
    </main>
    <footer>
        &copy; 2025 Andre Cruz
    </footer>
</body>
</html>