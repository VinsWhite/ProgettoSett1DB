<!-- DESCRIZIONE PAGINA
In questa pagina gestiamo la nav bar -->

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand text-warning fw-bold" href="index.php"> LIBRERIA </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <?php 
            session_start();
            if(isset($_SESSION["email"]) && isset($_SESSION['password'])) {
                echo "<li class='nav-item'>
                      <a class='nav-link' href='./login.php'>Log Out</a>
                    </li>";
                echo "<li class='nav-item'>
                      <a class='nav-link' href='addBook.php'>Inserisci libro<i class='bi bi-book ps-2'></i></a>
                    </li>";
              } else {
                echo "<li class='nav-item'>
                        <a class='nav-link' href='./login.php'>Accedi</a>
                      </li>";
                echo "<li class='nav-item'>
                        <a class='nav-link' href='./register.php'>Registrati</a>
                      </li>";
              }
        ?>
      </ul>
    </div>
  </div>
</nav>