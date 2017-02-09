<?php
    $host_name  = "db668624024.db.1and1.com";
    $database   = "db668624024";
    $user_name  = "dbo668624024";
    $password   = "<Geben Sie hier Ihr Passwort ein. >";


    $connect = mysqli_connect($host_name, $user_name, $password, $database);
    
    if(mysqli_connect_errno())
    {
        throw new Exception('Verbindung zum MySQL Server fehlgeschlagen: '.mysqli_connect_error());
    }
?>
