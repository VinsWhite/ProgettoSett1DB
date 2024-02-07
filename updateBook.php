<!-- DESCRIZIONE PAGINA
In questa pagina gestiamo l'aggiunta di un libro con il suo autore -->
<?php 
    require_once "config/config.php";
    include_once('partials/header.php');
    include_once('partials/nav.php'); 

    if(!isset($_SESSION['email']) && !isset($_SESSION['password'])){
        exit(header('Location: http://localhost/progetti%20settimanali/ProgettoSett1DB/index.php'));
    }
?>

<main>
    <div class="container mt-4">
         <!-- UPDATE DI UN LIBRO -->
        <h3 class="text-warning fw-semibold">Aggiorna informazioni libro</h3>
        <div> <!-- N.B. questa sezione sarà disponibile solo se l'utente è loggato -->
            <form  method="POST" action="./crud/update.php" enctype="multipart/form-data"> <!-- Percorso corretto per il file insert.php -->
                <div class="row mb-3">
                    <label for="inputTitle" class="col-sm-2 col-form-label">Titolo <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="titleBook" class="form-control" id="inputTitle">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPubblicationYear" class="col-sm-2 col-form-label">Anno Pubblicazione <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="yearBook" class="form-control" id="inputPubblicationYear">
                    </div>
                </div>
                <div class="row mb-3 pb-2 border-bottom border-secondary">
                    <label for="inputGenre" class="col-sm-2 col-form-label">Genere <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="genreBook" class="form-control" id="inputGenre">
                    </div>
                </div>
                <h5>Informazioni autore libro</h5>
                <div class="row mb-2">
                    <label for="inputAuthor" class="col-sm-2 col-form-label">Nome autore <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="authorBook" class="form-control" id="inputAuthor">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputAuthorSurname" class="col-sm-2 col-form-label">Cognome autore <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="authorBookSurname" class="form-control" id="inputAuthorSurname">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPseudonimo" class="col-sm-2 col-form-label">Pseudonimo <span class="text-primary">(facoltativo)</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="authorPseudonimo" class="form-control" id="inputPseudonimo">
                    </div>
                </div>
                <button type="submit" class="btn btn-warning">Aggiorna</button>
            </form>
        </div>

    </div>
</main>

<?php include_once('partials/footer.php'); ?>
