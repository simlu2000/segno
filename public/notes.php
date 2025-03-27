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
        }

        .content h1 {
            font-size: 4rem;
            margin-bottom: 10px;
            color: #4a4a4a;
        }

        .your {
            margin-top: -10%;
        }

        .welcome {
            margin-top: 20%;
        }

        .content p {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            text-align: center;
        }

        .btn-action {
            background-color: #006f8c;
            width: 200px;
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

        .dialog {
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            display: none;
        }

        .cat-dialog-content,
        .note-dialog-content {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #888;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(0);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: auto;
            margin: 10% auto;

        }

        .cat-dialog-content label,
        .cat-dialog-content input,
        .note-dialog-content label,
        .note-dialog-content input,
        .note-dialog-content textarea {
            margin-bottom: 10px;
            width: calc(100% - 22px);
        }

        .cat-dialog-content button,
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

        .cat-dialog-content button:hover,
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

        .message {
            background-color: #c2e9fb;
            color: #ffffff;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            border-radius: 8px;
            display: block;
            height: auto;
            width: auto;
            font-size: 0.8rem;
        }

        #category {
            width: 100px;
        }

        #category option {
            color: #000;
        }
        .note-content{
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-left:15%;
            margin-right:15%;
            width:auto;
            }
        #notebox{
            margin-bottom: 15%;
        }
      
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
                    <?php
                    $conn = new mysqli("localhost", "root", "", "segno");
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
                    $stmt->bind_param("s", $_SESSION["email"]);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $userId = $row['id'];

                        // Prendo le note dal database
                        $stmt = $conn->prepare("SELECT * FROM categories WHERE userId = ?");
                        $stmt->bind_param("i", $userId);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) { // Se ci sono categorie
                            echo "<select id='category' name='category' required>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                            }
                            echo "</select>";
                        } else {
                            echo "<p>Non ci sono categorie inserite
                                </p>";
                        }
                    } else {
                        echo "Utente non trovato";
                    }
                    ?>

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


        <!-- Visualizzazione delle note -->
        <div class="note-content">
            <?php
            $conn = new mysqli("localhost", "root", "", "segno");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $_SESSION["email"]);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $userId = $row['id'];

                // Prendo le note dal database
                $stmt = $conn->prepare("SELECT * FROM notes WHERE userId = ?");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) { // Se ci sono note
                    while ($row = $result->fetch_assoc()) {
                        echo "<div id='notebox'/>";
                        echo "<div style='border: 1px solid #ccc; border-radius: 8px; padding: 10px; margin: 10px 0;'>";
                        echo "<h2>" . $row['title'] . "</h2>";
                        echo "<p>" . $row['body'] . "</p>";
                        echo "<p><strong>Categoria:</strong> " . $row['category'] . "</p>";
                        echo "</div>";
                        echo "</div>";

                    }
                } else {
                    echo "<p>Non ci sono note
                    </p>";
                }
            } else {
                echo "Utente non trovato";
            }
            ?>

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