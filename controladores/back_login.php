<?php 
    require_once('conexion.php');

    $user = $_POST['user'] ?? 'Sec-0';
    $contra = $_POST['contrasena'] ?? 'secretari';

    // Consulta
    $sql = $pdo->prepare("SELECT * FROM usuario WHERE nom_usuario = :usuario AND contraseña = :contra");
    $sql->bindParam(':usuario', $user, PDO::PARAM_STR);
    $sql->bindParam(':contra', $contra, PDO::PARAM_STR);
    $sql->execute();
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        echo("<script>window.location.assign('index.php');</script>");
        exit; // Asegúrate de llamar exit después de redirigir para detener el código posterior
    }else{
        echo("<script>alert('contrasena incorrecta')</script>;");
    }
?>