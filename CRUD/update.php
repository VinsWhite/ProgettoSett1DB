<!-- DESCRIZIONE PAGINA
In questa pagina gestiamo la cancellazione di un libro con il suo autore -->
<?php
    include_once('../partials/header.php');

    if(!isset($_SESSION['email']) && !isset($_SESSION['password'])){
        exit(header('Location: http://localhost/progetti%20settimanali/ProgettoSett1DB/index.php'));
    }

    if(isset($_GET["id"])) {
        $idToUpdate = $_GET['id'];

        require_once '../config/config.php';
        $mysqli = new mysqli($config['hostname'], $config['username'], $config['password'], "gestione_libreria");

        // Verifica la connessione al database
        if ($mysqli->connect_error) {
            die("Errore durante la connessione al database " . $mysqli->connect_error);
        }

        if(isset($_POST['titleBook']) && isset($_POST['yearBook']) && isset($_POST['genreBook']) && isset($_POST['authorBook']) && isset($_POST['authorBookSurname'])) {
            // Recupera i dati del libro e dell'autore dall'input del form
            $title = $_POST['titleBook'];
            $year = $_POST['yearBook'];
            $genre = $_POST['genreBook'];
            $authorName = $_POST['authorBook'];
            $authorSurname = $_POST['authorBookSurname'];
            $pseudonimo = isset($_POST['authorPseudonimo']) ? $_POST['authorPseudonimo'] : NULL;
    
            // Update del libro
            $sqlBook = "UPDATE book SET titolo = ?, anno_pubblicazione = ?, genere = ? WHERE id_libro = ?";
            $stmtBook = $mysqli->prepare($sqlBook);
            $stmtBook->bind_param("sisi", $title, $year, $genre, $idToUpdate);
    
            // Esegui la query per l'aggiornamento del libro
            if ($stmtBook->execute()) {
                // Update dell'autore
                $sqlAuthor = "UPDATE author SET nome = ?, cognome = ?, pseudonimo = ? WHERE id_libro = ?";
                $stmtAuthor = $mysqli->prepare($sqlAuthor);
                $stmtAuthor->bind_param("sssi", $authorName, $authorSurname, $pseudonimo, $idToUpdate);
    
                // Esegui la query per l'aggiornamento dell'autore
                if ($stmtAuthor->execute()) {
                    echo "Libro e autore aggiornati con successo!";
                    echo "<a href='../index.php' class='btn btn-warning'> Torna indietro </a>";
                } else {
                    echo "Errore durante l'aggiornamento dell'autore: " . $stmtAuthor->error;
                }
    
                // Chiudi la dichiarazione
                $stmtAuthor->close();
            } else {
                echo "Errore durante l'aggiornamento del libro: " . $stmtBook->error;
            }
    
            // Chiudi la dichiarazione e la connessione
            $stmtBook->close();
            $mysqli->close();
        } else {
            echo "Tutti i campi del form devono essere compilati!";
        }

    }
    
?>



<?php include_once('../partials/footer.php'); ?>
