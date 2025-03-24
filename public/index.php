<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Segno</title>
</head>

<body>
    <?php
    include "navbar.php";
    ?>
    <?php
    if (isset($_SESSION["email"]) && isset($_SESSION["username"])) { 
        ?>
    <h1>Hi <?php echo($_SESSION["username"]) ?></h1>
    <?php } else { ?>
    <h1>Welcome to Segno</h1>
    <p>Segno is a simple note-taking app. You can use it to take notes, make lists, or write down ideas. To get started, sign up or log in.</p>
    <?php } ?>
</body>

</html>