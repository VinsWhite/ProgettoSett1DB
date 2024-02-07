<!-- DESCRIZIONE PAGINA
In questa pagina gestiamo la cancellazione di un libro con il suo autore -->
<?php
    include_once('../partials/header.php');

    if(isset($_SESSION['email']) && isset($_SESSION['password'])){
        exit(header('Location: http://localhost/progetti%20settimanali/ProgettoSett1DB/index.php'));
    }

    if(isset($_GET["id"])) {
        $idToDelete = $_GET['id'];

        require_once '../config/config.php';
        $mysqli = new mysqli($config['hostname'], $config['username'], $config['password'], "gestione_libreria");

        // Verifica la connessione al database
        if ($mysqli->connect_error) {
            die("Errore durante la connessione al database " . $mysqli->connect_error);
        }

        // Delete dalla tabella author 
        $sqlAuthor = "DELETE FROM author WHERE id_libro = ?";
        $stmtAuthor = $mysqli->prepare($sqlAuthor);
        $stmtAuthor->bind_param("i", $idToDelete);
        
        // Se l'autore è stato cancellato correttamente
        if ($stmtAuthor->execute()) {
            // Dopo aver eliminato i record correlati dalla tabella author, procedi con l'eliminazione dalla tabella book
            $sqlBook = "DELETE FROM book WHERE id_libro = ?";
            $stmtBook = $mysqli->prepare($sqlBook);
            $stmtBook->bind_param("i", $idToDelete);
            if ($stmtBook->execute()) {
                echo "Record cancellato con successo! <br>";
                echo "<a href='../index.php' class='btn btn-warning'> Torna indietro </a>";
            } else {
                echo "Errore durante la cancellazione del libro: " . $stmtBook->error;
            }
            $stmtBook->close();
        } else {
            echo "Errore durante la cancellazione degli autori: " . $stmtAuthor->error;
        }
    
        $stmtAuthor->close();
        $mysqli->close();
    }
    
?>

<main>
</main>

<?php include_once('../partials/footer.php'); ?>
