<!-- DESCRIZIONE PAGINA
In questa pagina gestiamo l'aggiunta di un libro con il suo autore con l'insert -->
<?php
    include_once('../partials/header.php');
    // Verifica se sono stati inviati i dati del libro
    if(isset($_POST['titleBook']) && isset($_POST['yearBook']) && isset($_POST['genreBook']) && isset($_POST['authorBook']) && isset($_POST['authorBookSurname'])) {
        // Recupera i dati del libro e dell'autore dall'input del form
        $title = $_POST['titleBook'];
        $year = $_POST['yearBook'];
        $genre = $_POST['genreBook'];
        $authorName = $_POST['authorBook'];
        $authorSurname = $_POST['authorBookSurname'];
        $pseudonimo = isset($_POST['authorPseudonimo']) ? $_POST['authorPseudonimo'] : NULL;

        // Connessione al database
        require_once '../config/config.php';
        $mysqli = new mysqli($config['hostname'], $config['username'], $config['password'], "gestione_libreria");

        // Verifica la connessione al database
        if ($mysqli->connect_error) {
            die("Errore di connessione al database: " . $mysqli->connect_error);
        }

        // Inserimento del libro
        $sqlBook = "INSERT INTO book (titolo, anno_pubblicazione, genere) VALUES (?, ?, ?)";
        $stmtBook = $mysqli->prepare($sqlBook);
        $stmtBook->bind_param("sis", $title, $year, $genre);

        // Esegui la query per l'inserimento del libro
        if ($stmtBook->execute()) {
            // Recupera l'ID del libro appena inserito
            $idLibro = $mysqli->insert_id;

            // Inserimento dell'autore
            $sqlAuthor = "INSERT INTO author (nome, cognome, pseudonimo, id_libro) VALUES (?, ?, ?, ?)";
            $stmtAuthor = $mysqli->prepare($sqlAuthor);
            $stmtAuthor->bind_param("sssi", $authorName, $authorSurname, $pseudonimo, $idLibro);

            // Esegui la query per l'inserimento dell'autore
            if ($stmtAuthor->execute()) {
                echo "Libro e autore inseriti con successo!";
            } else {
                echo "Errore durante l'inserimento dell'autore: " . $stmtAuthor->error;
            }

            // Chiudi la dichiarazione e la connessione
            $stmtAuthor->close();
        } else {
            echo "Errore durante l'inserimento del libro: " . $stmtBook->error;
        }

        // Chiudi la dichiarazione e la connessione
        $stmtBook->close();
        $mysqli->close();
    } else {
        echo "Tutti i campi del form devono essere compilati!";
    }
?>

<main>
    <a href="../addBook.php" class="btn btn-warning"> Torna indietro </a>
</main>

<?php include_once('../partials/footer.php'); ?>