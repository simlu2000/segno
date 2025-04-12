<?php
session_start();
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Segno - App Note</title>
    <link rel="stylesheet" href="../style/notes_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        .search-form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .search-form input {
            margin-right: 10px;
            width: 250px;
            height: 30px;
            border-radius: 25px;
            padding: 10px;
            border: none;
        }

        .search-form button {
            background-color: #29dbc6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
        }

        .search-form button:hover {
            background-color: #006f8c;
        }
    </style>
</head>

<body>
    <?php include "./navbar.php" ?>
    <?php if (isset($_SESSION["email"])) { ?>

        <div class="content">
            <h1 class="your">Le tue note</h1>
            <?php if (isset($_SESSION["message"])) { ?>
                <div class="message">
                    <p><?php echo $_SESSION["message"]; ?></p>
                </div>
                <?php unset($_SESSION["message"]); ?>
            <?php } ?>
        </div>

        <div id="noteDialog" class="dialog">
            <div class="note-dialog-content">
                <span class="close-btn" onclick="closeNoteDialog('noteDialog')">&times;</span>
                <h2>Aggiungi una nuova nota</h2>
                <form id="addNoteForm" action="addNewNote.php" method="post">
                    <label for="title">Titolo:</label>
                    <input type="text" id="title" name="title" required>

                    <label for="body">Testo:</label>
                    <textarea id="body" name="body" rows="4" required></textarea>

                    <label for="category">Categoria:</label>

                    <!-- Carico le categorie dal database -->
                    <?php include "./printCategory.php" ?>
                    <br>
                    <button type="submit">Salva</button>
                </form>
            </div>
        </div>

        <div id="catDialog" class="dialog">
            <div class="cat-dialog-content">
                <span class="close-btn" onclick="closeNoteDialog('catDialog')">&times;</span>
                <h2>Aggiungi una nuova categoria</h2>
                <form id="addNoteForm" action="addNewCat.php" method="post">
                    <label for="category">Nome:</label>
                    <input type="text" id="category" name="category" required>
                    <button type="submit">Salva</button>
                </form>
            </div>
        </div>

        <form method="GET" action="" class="search-form">
            <input
                type="text"
                style="width: 250px; height: 20px; border-radius: 25px; border:none; padding: 10px; margin-right: 10px;"
                name="search"
                placeholder="Cerca note..." />
            <button type="submit">Cerca</button>
        </form>

        <div class="note-content">
            <?php include "./printNotes.php" ?>
        </div>

    <?php } else { ?>
        <div class="content">
            <h1 classs="welcome">Benvenuto su Segno</h1>
            <p>Per iniziare a salvare le tue note, effettua il <a href="signup.php">login</a> o <a href="signup.php">registrati</a> se non hai ancora un account.</p>
        </div>
    <?php } ?>

    <script>
        function openNoteDialog($dialog) {
            if ($dialog === "catDialog") {
                document.getElementById('catDialog').style.display = "block";
            } else {
                document.getElementById('noteDialog').style.display = "block";
            }
        }

        function closeNoteDialog($dialog) {
            if ($dialog === "catDialog") {
                document.getElementById('catDialog').style.display = "none";
            } else {
                document.getElementById('noteDialog').style.display = "none";
            }
        }

        function searchNotes() {
            /*variabili di sessione per la ricerca*/
            var input = document.getElementById('searchInput');
            $_SESSION['search'] = input.value.toLowerCase();
        }

        //se utente clicca fuori dal dialog, chiudo
        window.onclick = function(event) {
            if (event.target == document.getElementById('noteDialog')) {
                document.getElementById('noteDialog').style.display = "none";
            }
        }

        setTimeout(function() {
            document.querySelector('.message').style.display = 'none';
        }, 3000);

        // Svuota il campo di ricerca al caricamento della pagina
        window.onload = function() {
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.value = "";
            }
        };
    </script>
</body>

</html>