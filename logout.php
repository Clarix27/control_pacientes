<?php
    session_start();
    session_unset(); // Limpia todas las variables de sesión
    session_destroy(); // Destruye la sesión
    
    echo("<script>window.location.assign('Login.html');</script>");
    exit; // Detiene el código posterior
?>