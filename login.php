<?php 
    include_once('partials/header.php');
    include_once('partials/nav.php');

    // Se la sessione è attiva, distruggila quando ti trovi nella schermata di login
    if(isset($_SESSION["email"]) && isset($_SESSION['password'])) {
        session_destroy();
    }

    if(isset($_POST['email']) && isset($_POST['password'])){

        require_once('./config/config.php');
        $mysqli = new mysqli($config['hostname'], $config['username'], $config['password'], "gestione_libreria");

        // Verifica la connessione al database
        if ($mysqli->connect_error) {
            die("Connessione col database fallita " . $mysqli->connect_error);
        }
        
        // Recupera l'email e la password inviate dal modulo di accesso
        $email = $mysqli->real_escape_string($_POST['email']);
        $password = $mysqli->real_escape_string($_POST['password']);

        // Query per recuperare la password corrispondente all'email fornita
        $sql = "SELECT passW FROM user WHERE email = '$email'";
        $result = $mysqli->query($sql);

        if ($result && $result->num_rows > 0) {
            // Estrai la password dal risultato della query
            $row = $result->fetch_assoc();
            $storedHashedPassword = $row['passW'];

            // Verifica se la password fornita dall'utente corrisponde a quella nel database
            if (password_verify($password, $storedHashedPassword)) {
                // Password corretta, esegui l'accesso e impostala nella sessione
                session_start();
                $_SESSION["email"] = $email;
                $_SESSION["password"] = $password;
                header("Location: ./index.php");
                exit(); 
            } else {
                // Password non corretta
                echo '<script>alert("Login invalido. Riprova.");</script>';
            }
        } else {
            // Nessun utente trovato con l'email fornita
            echo '<script>alert("Login invalido. Riprova.");</script>';
        }

    }

?>

    <main>
        <div class="container mt-5">
            <h1 class="text-warning mb-2">Accesso!</h1>
            <form method="POST" action="login.php" enctype="multipart/form-data"> 
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-warning">Accedi ora!</button>
                    <a href="./index.php" class="btn btn-secondary mt-2 ms-3">Continua senza effettuare l'accesso</a>
                </div>
                <p class="mt-4">Nuovo utente? <a href="register.php">Registrati ora!</a></p>
            </form>
        </div>
    </main>

<?php include_once('partials/footer.php') ?>