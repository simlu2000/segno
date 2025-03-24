<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        nav {
            background-color: #80ed99;
            overflow: hidden;
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
    </style>
</head>

<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php if (isset($_SESSION["email"])) { ?>
                <li><a href="logout.php">Logout</a></li>
            <?php } else { ?>
                <li><a href="signup.php">Login</a></li>
            <?php } ?>
        </ul>
    </nav>
</body>

</html>
