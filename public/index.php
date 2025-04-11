<?php
session_start();
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Segno - App Note</title>
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(323deg, #e0f7fa, #c2e9fb, #7AFFEF);
            background-size: 180% 180%;
            animation: gradient-animation 15s ease infinite;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content {
            flex: 1;
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
            padding: 20px;
            margin: 0 5%;
        }

        .content h1 {
            font-size: 4rem;
            margin-bottom: 10px;
            color: #4a4a4a;
        }

        .content p {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            text-align: center;
        }

        #features {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            margin: 0 5%;
        }

        #features-list {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-start;
            width: 100%;
            max-width: 800px;
            margin: 20px 0;
            padding: 20px;

        }

        #features-list ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .feature {
            background-color: rgba(255, 255, 255, 0.54);
            padding: 10px;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-size: 1.2rem;
            color: #333;
            text-align: center;
            flex: 1;
            margin: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;

        }

        #cta {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-start;
            margin: 20px 0;
            padding: 20px;
            width: 100%;
            max-width: 800px;
            text-align: center;
        }
        #cta-area{
            display:flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
            padding: 20px;
            width: 100%;
            max-width: 800px;
            text-align: center;

        }
        .btn{
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1.2rem;
            transition: background-color 0.3s, transform 0.3s;
            margin-top: 10px;
        }

        #logo {
            border-radius: 50px;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background-color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            color: #777;
        }

        #logo-area {
            background-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 50px;
        }

        @media (max-width: 491px) {
            .content {
                flex-direction: column;
                justify-content: center;
                align-items: center;
                margin: 0;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <?php include "./navbar.php" ?>

    <div class="content">
        <div>
            <h1>Benvenuto in Segno</h1>
            <p>Segno è una semplice app per prendere appunti. Puoi usarla per annotare idee o scrivere promemoria. Per iniziare, registrati o accedi.</p>
        </div>
        <div id="logo-area">
            <img id="logo" src="images/segno.png">
        </div>
    </div>
    <div id="features">
        <div>
            <h1>Caratteristiche</h1>
        </div>
        <div id="features-list">
            <div class="feature">Interfaccia semplice e intuitiva</div>
            <div class="feature">Salva i tuoi appunti in modo sicuro</div>
            <div class="feature">Accesso da qualsiasi dispositivo</div>
            <div class="feature">Cerca facilmente tra i tuoi appunti</div>
        </div>

        <?php if(isset($_SESSION['user'])): ?>
        <div id="cta">
            <h1>Inizia ora!</h1>
            <div id="cta-area">
                <p>Registrati o accedi per iniziare a utilizzare Segno.</p>
                <a href="login.php" class="btn">Accedi</a>
            </div>
        </div>
        <?php else: ?>
            <a href="notes.php" class="btn">Vai alle note</a>
        <?php endif; ?>
    </div>

    <?php include "./footer.php" ?>
</body>

</html>