<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/navbar_style.css">

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
