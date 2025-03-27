<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Registrazione</title>
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #e0f7fa, #c2e9fb); 
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            display:flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 25px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"],
        .form-container input[type="submit"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-container .form-switch {
            text-align: center;
            margin-top: 10px;
        }

        .form-container .form-switch a {
            text-decoration: none;
            color: #007bff;
        }

        .form-container .form-switch a:hover {
            text-decoration: underline;
        }

        #registrationForm {
            display: none;
        }
    </style>
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
