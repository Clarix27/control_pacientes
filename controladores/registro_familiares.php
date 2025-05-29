<?php
    require_once('controladores/conexion.php');

    $nom_titular = $_POST['nom_titular'];
    $nom_paciente = $_POST['nom_paciente'];
    
    // Consulta
    $sql = $pdo->prepare("SELECT * FROM pacientes WHERE id = ?");
    $sql->execute();
    $paciente = $sql->fetch(PDO::FETCH_ASSOC);

    echo $paciente['nombre'];
?>