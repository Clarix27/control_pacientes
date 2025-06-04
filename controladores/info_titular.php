<?php
    require_once 'conexion.php';
    

    // Consulta para mostrar información del titular
    function info_titilar(){
        $pdo = Conexion::getPDO();
        $sql = $pdo->query("SELECT ti.nombre, a_paterno, a_materno, d.calle, tar.puesto, tar.direccion, ti.categoria FROM titular ti INNER JOIN tarjeton tar ON ti.pk_titular=tar.fk_titular INNER JOIN direccion d ON ti.pk_titular=d.fk_titular");
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    $datos_titular = info_titilar();
    var_dump($datos_titular);
    /*
    Por si se necesita despues
    if ($respuesta['success']) {
        // Mostrar tabla, por ej.
        foreach ($respuesta['data'] as $usuario) {
            echo $usuario['nombre'] . "<br>";
        }
    } else {
        echo "Error: " . $respuesta['message'];
    }
    */
    
?>