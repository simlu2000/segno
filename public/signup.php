<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/signup_style.css">
    <title>Login / Registrazione</title>
</head>

<body>
    <div class="form-container">
        <h2 id="formTitle">Accesso</h2>
        <form id="loginForm" method="POST" action="login.php">
            <input type="email" name="loginEmail" placeholder="Email" required>
            <input type="password" name="loginPassword" placeholder="Password" required>
            <input type="submit" value="Accedi">
        </form>
        <form id="registrationForm" method="POST" action="register.php">
            <input type="text" name="registerUsername" placeholder="Username" required>
            <input type="email" name="registerEmail" placeholder="Email" required>
            <input type="password" name="registerPassword" placeholder="Password" required>
            <input type="submit" value="Registrati">
        </form>
        <div class="form-switch">
            <a href="#" onclick="toggleForm()">Clicca qui per registrarti</a>
        </div>
    </div>

    <script>
        function toggleForm() {
            const loginForm = document.getElementById('loginForm');
            const registrationForm = document.getElementById('registrationForm');
            const formTitle = document.getElementById('formTitle');
            const switchLink = document.querySelector('.form-switch a');

            if (loginForm.style.display === 'none') {
                loginForm.style.display = 'block';
                registrationForm.style.display = 'none';
                formTitle.textContent = 'Accesso';
                switchLink.textContent = 'Clicca qui per registrarti';
            } else {
                loginForm.style.display = 'none';
                registrationForm.style.display = 'block';
                formTitle.textContent = 'Registrazione';
                switchLink.textContent = 'Clicca qui per accedere';
            }
        }
    </script>
</body>

</html>
