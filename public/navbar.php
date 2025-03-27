<!DOCTYPE html>
<html lang="en">

<head>
    <style>
       
        nav {
            background-color: rgba(255, 255, 255, 0.8); 
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: #333;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
        }

        nav ul li a:hover {
            background-color: rgba(200, 200, 200, 0.5); 
        }

        .material-icons {
            margin-right: 8px;
        }

    </style>
</head>

<body>
<nav>
        <ul>
            <li><a href="index.php"><span class="material-icons">home</span>Home</a></li>
            <?php if (isset($_SESSION["email"])) { ?>
                <li><a href="notes.php"><span class="material-icons">note</span>Notes</a></li>
                <li><a href="logout.php"><span class="material-icons">logout</span>Logout</a></li>
            <?php } else { ?>
                <li><a href="signup.php"><span class="material-icons">login</span>Login</a></li>
            <?php } ?>
        </ul>
    </nav>
</body>

</html>
