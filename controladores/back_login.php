<?php 
    session_start();
    header('Content-Type: application/json');
    require_once('conexion.php');

    // Validar que llegan los datos
    if (!isset($_POST['user']) || !isset($_POST['contrasena'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Faltan campos obligatorios'
        ]);
        exit;
    }

    $user = trim($_POST['user'] ?? 'Sec-0');
    $contra = trim($_POST['contrasena'] ?? 'secretari');

    // Validaciones básicas
    if ($user === '' || $contra === '') {
        echo json_encode([
            'success' => false,
            'message' => 'Todos los campos son obligatorios.'
        ]);
        exit;
    }

    // Consulta
    $sql = $pdo->prepare("SELECT * FROM usuario WHERE nom_usuario = :usuario AND `contraseña` = :contra");
    $sql->bindParam(':usuario', $user, PDO::PARAM_STR);
    $sql->bindParam(':contra', $contra, PDO::PARAM_STR);
    $sql->execute();
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $_SESSION['pk_usuario'] = $usuario['pk_usuario'];

        echo json_encode([
        'success' => true,
        'message' => 'Bienvenido!!!'
        ]);
    }else{
        echo json_encode([
            'success' => false,
            'message' => 'Usuario o contraseña incorrectos!!!'
        ]);
    }
?>