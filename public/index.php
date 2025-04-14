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
    <link rel="stylesheet" href="../style/style.css">
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

        <?php if(!isset($_SESSION['user'])): ?>
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