<?php
    session_start();
    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['pk_usuario'])) {
        // Redirigir a la página de login si no está autenticado
        echo("<script>window.location.assign('Login.html');</script>");
        exit();
    }
?>