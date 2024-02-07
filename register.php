<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/autoload.php';

    if(isset($_SESSION['email']) && isset($_SESSION['password'])){
        exit(header('Location: http://localhost/progetti%20settimanali/ProgettoSett1DB/index.php'));
    }
    

    include_once('partials/header.php');
    include_once('partials/nav.php');
    include_once('partials/validationForm.php');

    //INSERIMENTO DATI IN TABELLA
    if (isset($_POST['email']) && isset($_POST['age']) && isset($_POST['city']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $age = $_POST['age'];
        $city = $_POST['city'];
        $password = $_POST['password'];

        $hashPassword =  password_hash($password, PASSWORD_DEFAULT);

        // Verifica dei campi
        $errors = [];
        if (!isValidEmail($email)) {
            $errors[] = "L'email inserita non è valida.";
        }
        if (!isValidPassword($password)) {
            $errors[] = "La password deve contenere almeno 8 caratteri.";
        }
        if (!isValidAge($age)) {
            $errors[] = "L'età inserita non è valida.";
        }
        if (!isValidCity($city)) {
            $errors[] = "La città inserita non è valida.";
        }

        if (empty($errors)) {
            require_once './config/config.php';

            $mysqli = new mysqli($config['hostname'], $config['username'], $config['password'], "gestione_libreria");

            // Verifica la connessione al database
            if ($mysqli->connect_error) {
                die("Error connection to the database: " . $mysqli->connect_error);
            }

            // Preparazione della query SQL con i dati ottenuti dalla richiesta POST
            $sql = "INSERT INTO user (email, age, city, passW) VALUES (?, ?, ?, ?)";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("siss", $email, $age, $city, $hashPassword);

            // Eseguiamo la query
            if ($stmt->execute()) {
                echo "Registrazione completata! Puoi eseguire l'accesso ora";

                // Invio dell'email in caso di registrazione completata
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'USERNAME';                    
                    $mail->Password   = 'PASS';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 2525;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('admin@example.com', 'Mailer');
                    $mail->addAddress('$email', 'Utente');    
                    $mail->addReplyTo('admin@example.com', 'Information');


                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Grazie per aver effettuato la registrazione!';
                    $mail->Body    = 'Ti aspettiamo nel nostro sito di libreria più famoso al mondo!';

                    $mail->send();
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

            } else {
                echo "Errore durante la registrazione. Riprova per favore " . $stmt->error;
            }

            // Chiusura della connessione e dell'istruzione
            $stmt->close();
            $mysqli->close();
        } else {
            // Mostra gli errori
            foreach ($errors as $error) {
                echo "<p class='text-danger'>$error</p>";
            }
        }
}
?>
 
    <main>
        <div class="container mt-5">
            <h1 class="text-warning mb-2">Registrazione!</h1>
            <form method="POST" action="./register.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputAge" class="form-label">Age <span class="text-danger">*</span></label>
                    <input type="number" name="age" min="0" max="120" class="form-control" id="exampleInputAge" aria-describedby="exampleInputAge" required>
                </div>
                <!-- controlli fatti sia sull'html che sul php -->
                <div class="mb-3">
                    <label for="exampleInputCity" class="form-label">City <span class="text-danger">*</span></label>
                    <input type="text" name="city" class="form-control" id="exampleInputCity" aria-describedby="exampleInputCity" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" required>
                    <label class="form-label text-secondary">Inserisci almeno 8 caratteri </label>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-warning">Registrati ora</button>
                    <a href="./index.php" class="btn btn-secondary mt-2 ms-3">Continua senza effettuare l'accesso</a>
                </div>
                <p class="mt-4">Already have an account? <a href="login.php">Sign in!</a></p>
            </form>
        </div>
    </main>

<?php include_once('partials/footer.php') ?>