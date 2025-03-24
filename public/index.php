<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        nav {
            background-color: #80ed99;
            overflow: hidden;
            border-radius: 25px;
            font-family: 'Quicksand', sans-serif;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            font-size: 1.2rem;
        }

        nav ul li {
            float: left;
        }

        nav ul li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        nav ul li a:hover {
            background-color: #111;
        }

        .material-icons {
            vertical-align: middle;
            margin-right: 8px;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            margin: 0;
            padding: 0;
        }

        h1,
        p {
            text-align: center;
        }

        h1 {
            margin-top: 15%;
            font-size: 4rem;
        }
    </style>
    <!-- Google Font Quicksand -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Material Icons CDN -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>


<body>
    <nav>
        <ul>
            <li><a href="index.php"><span class="material-icons">home</span>Home</a></li>
            <?php if (isset($_SESSION["email"])) { ?>
                <li><a href="logout.php"><span class="material-icons">logout</span>Logout</a></li>
            <?php } else { ?>
                <li><a href="signup.php"><span class="material-icons">login</span>Login</a></li>
            <?php } ?>
        </ul>
    </nav>
    <h1>Welcome to Segno</h1>
    <p>Segno is a simple note-taking app. You can use it to take notes or write down ideas. To get started, sign up or log in.</p>
</body>

</html>