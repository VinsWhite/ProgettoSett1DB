<?php 
    require_once "./config/config.php";
    include_once('partials/header.php');
    include_once('partials/nav.php');

    $mysqli = new mysqli(
        $config['hostname'],
        $config['username'],
        $config['password']);

    //Controllo funzionamento connessione
    if($mysqli->connect_error) { die($mysqli->connect_error); } 

    //Creazione del database 
    $sql = 'CREATE DATABASE IF NOT EXISTS gestione_libreria;';
    if(!$mysqli->query($sql)) { die($mysqli->connect_error); }

    //Utilizzo il mio database gestione_libreria
    $sql = 'USE gestione_libreria;';
    $mysqli->query($sql);


    // P.S. nel file "modelloconcettuale.txt" è presente una spiegazione approfondita del progetto

    // Creo la prima tabella per inserire i dati del libro
    $sql = 'CREATE TABLE IF NOT EXISTS book (
        id_libro INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        titolo VARCHAR(255) NOT NULL UNIQUE,
        anno_pubblicazione INT NOT NULL,
        genere VARCHAR(255) NOT NULL
    )';

    if(!$mysqli->query($sql)) { die($mysqli->error); }

    // Creo la seconda tabella per inserire i dati dell'autore
    $sql = 'CREATE TABLE IF NOT EXISTS author (
        id_autore INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        nome VARCHAR(255) NOT NULL,
        cognome VARCHAR(255) NOT NULL,
        pseudonimo VARCHAR(255),
        id_libro INT NOT NULL,
        CONSTRAINT pubblicazione FOREIGN KEY (id_libro) REFERENCES book(id_libro)
        ON DELETE RESTRICT ON UPDATE RESTRICT
    )';

    if(!$mysqli->query($sql)) { die($mysqli->error); }

    //Creo la tabella per inserire i dati dell'utente
    $sql = 'CREATE TABLE IF NOT EXISTS user (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        age INT UNSIGNED NOT NULL, 
        city VARCHAR(255) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        passW TEXT NOT NULL
    )';

    if(!$mysqli->query($sql)) { die($mysqli->connect_error); }
?>

<main>
    <div class="container mt-4">
        <?php
            if(isset($_SESSION["email"]) && isset($_SESSION['password'])) {
                echo "<h2 class='fw-semibold'> Bentornato! </h2>";
            } else {
                echo "<p class='text-decoration-underline'> N.B. Accedi per poter inserire, modificare ed eliminare libri! </p>";
            }
        ?>
        <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Titolo</th>
                        <th scope="col">Anno di pubblicazione</th>
                        <th scope="col">Genere</th>
                        <th scope="col">Nome autore</th>
                        <th scope="col">Cognome autore</th>
                        <th scope="col">Pseudonimo</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    // Connessione al database
                    require_once './config/config.php';
                    $mysqli = new mysqli($config['hostname'], $config['username'], $config['password'], "gestione_libreria");

                    // Verifica la connessione al database
                    if ($mysqli->connect_error) {
                        die("Error connection to the database: " . $mysqli->connect_error);
                    }

                    // Query per recuperare i dati dalla tabella "contacts"
                    $result = $mysqli->query("SELECT * FROM book INNER JOIN author ON book.id_libro = author.id_autore");

                    // Itera attraverso i risultati e stampa ogni riga nella tabella HTML
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='fw-semibold'>" . $row['titolo'] . "</td>";
                        echo "<td class='text-center'>" . $row['anno_pubblicazione'] . "</td>";
                        echo "<td>" . $row['genere'] . "</td>";
                        echo "<td>" . $row['nome'] . "</td>";
                        echo "<td>" . $row['cognome'] . "</td>";
                        echo "<td>" . $row['pseudonimo'] . "</td>";

                        if(isset($_SESSION["email"]) && isset($_SESSION['password'])) {
                            // Iconcine per eliminare e/o modificare
                            echo "<td><a href='./crud/delete.php?id=" . $row['id_libro'] . 
                            "'><i class='bi bi-trash text-danger'></i></a> <a href='./updateBook.php?id=" . 
                            $row['id_libro'] . "'><i class='bi bi-pencil-square text-secondary'></i></a></td>";
                        } 
                        
                        echo "</tr>";
                    } 

                    // Chiusura della connessione
                    $mysqli->close();
                    ?>
                </tbody>
            </table>
    </div>
</main>

<?php include_once('partials/footer.php'); ?>