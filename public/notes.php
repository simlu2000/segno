<?php
session_start();
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Segno - App Note</title>
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
        }

        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            margin-top: -20%;
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

        .add-note-btn {
            background-color: #006f8c;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 20px 0;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .note-dialog {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .note-dialog-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
        }

        .note-dialog-content label,
        .note-dialog-content input,
        .note-dialog-content textarea {
            display: block;
            margin-bottom: 10px;
            width: calc(100% - 22px);
        }

        .note-dialog-content button {
            background-color: #008CBA;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .note-dialog-content button:hover {
            background-color: #006f8c;
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .message{
            background-color: #006f8c;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            border-radius: 8px;
            display: block;
            height:25px;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <?php include "./navbar.php" ?>

    <div class="content">
        <h1>Le tue note</h1>
        <button class="add-note-btn" onclick="openNoteDialog()">Aggiungi Nota</button>
        <?php if (isset($_SESSION["message"])) { ?>
            <div class="message">
                <p><?php echo $_SESSION["message"]; ?></p>
            </div>
            <?php unset($_SESSION["message"]); ?>
        <?php } ?>
    </div>

    <div id="noteDialog" class="note-dialog">
        <div class="note-dialog-content">
            <span class="close-btn" onclick="closeNoteDialog()">&times;</span>
            <h2>Aggiungi una nuova nota</h2>
            <form id="addNoteForm" action="addNewNote.php" method="post">
                <label for="title">Titolo:</label>
                <input type="text" id="title" name="title" required>

                <label for="body">Testo:</label>
                <textarea id="body" name="body" rows="4" required></textarea>

                <label for="category">Categoria:</label>
                <input type="text" id="category" name="category">

                <button type="submit">Salva Nota</button>
            </form>
        </div>
    </div>

    <?php include "./footer.php" ?>

    <script>
        function openNoteDialog() {
            document.getElementById('noteDialog').style.display = "block";
        }

        function closeNoteDialog() {
            document.getElementById('noteDialog').style.display = "none";
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
    </script>
</body>

</html>