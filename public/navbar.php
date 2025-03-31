<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        nav {
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
            position: relative;
            width:auto;
            margin-left:1%;
            margin-right:1%;
            margin-top:1%;
            border-radius:25px;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            margin: 0;
            padding: 0;
            z-index: 1000; 
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a,
        nav ul li button {
            color: #333;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
            border: none;
            background: none;
            cursor: pointer;
        }

        nav ul li a:hover,
        nav ul li button:hover {
            background-color: rgba(200, 200, 200, 0.5);
        }

        .material-icons {
            margin-right: 8px;
        }

        .menu-toggle {
            display: none;
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
        }

        .menu-toggle span {
            display: block;
            width: 25px;
            height: 3px;
            background-color: #333;
            margin: 5px 0;
        }

        @media (max-width: 768px) {
            nav ul {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background-color: rgba(255, 255, 255, 0.9);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                z-index: 1000;
            }

            nav ul.active {
                display: flex;
            }

            .menu-toggle {
                display: block;
            }
        }

        .dialog {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            z-index: 2000;
        }
    </style>
</head>

<body>
    <nav>
        <div class="menu-toggle" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul>
            <?php if (isset($_SESSION["email"])) { ?>
                <li><a href="notes.php"><span class="material-icons">note</span>Le tue note</a></li>
                <li><button onclick="openNoteDialog('noteDialog')"><span class="material-icons">add</span>Nota</button></li>
                <li><button onclick="openNoteDialog('catDialog')"><span class="material-icons">add</span>Categoria</button></li>
                <li><a href="logout.php"><span class="material-icons">logout</span>Logout</a></li>
            <?php } else { ?>
                <li><a href="index.php"><span class="material-icons">home</span>Home</a></li>
                <li><a href="signup.php"><span class="material-icons">login</span>Login</a></li>
            <?php } ?>
        </ul>
    </nav>

    <script>
        function toggleMenu() {
            const navUl = document.querySelector('nav ul');
            navUl.classList.toggle('active');
        }

        function closeMenu() {
            const navUl = document.querySelector('nav ul');
            if (navUl.classList.contains('active')) {
                navUl.classList.remove('active');
            }
        }

        document.querySelectorAll('nav ul li a, nav ul li button').forEach(item => {
            item.addEventListener('click', closeMenu);
        });
    </script>
</body>

</html>
