<?php

// credenciales de la base de datos  - Mamp

    $conn = new mysqli('localhost', 'root', 'root', 'sirius', '3306');

    if($conn->connect_error) {
        echo $error -> $conn->connect_error;
    }


//echo $conn->ping();

?>