<!-- funzioni per la validazione del form di registrazione  -->
<?php
    // Funzione per verificare se un'email è valida
    function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    // Funzione per verificare se la password è abbastanza lunga
    function isValidPassword($password) {
        return strlen($password) >= 8;
    }

    // Funzione per verificare se l'età è compresa tra 0 e 120
    function isValidAge($age) {
        return $age >= 0 && $age <= 120;
    }

    // Funzione per verificare se la città ha almeno 2 caratteri
    function isValidCity($city) {
        return strlen($city) >= 2;
    }
?>