<?php
    require_once 'conexion.php';
    

    // Consulta para mostrar información del titular
    function info_titilar(){
        $pdo = Conexion::getPDO();
        $sql = $pdo->query("SELECT ti.pk_titular, ti.nombre, ti.a_paterno, ti.a_materno, d.calle, tar.puesto, tar.direccion, ti.categoria FROM titular ti INNER JOIN tarjeton tar ON ti.pk_titular=tar.fk_titular INNER JOIN direccion d ON ti.pk_titular=d.fk_titular");
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // Consulta para mostar la informacion del paciente
    function datos_beneficiarios($id){
        $pdo = Conexion::getPDO();
        $stmt = $pdo->prepare("SELECT b.nombre, b.a_paterno, b.a_materno, b.edad, b.sexo, b.parentesco FROM tarjeton tar INNER JOIN beneficiarios b ON tar.pk_tarjeton=b.fk_tarjeton WHERE tar.fk_titular=:id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Consulta para mostrar información del titular pasandole un id
    function titular_id($id){
        $pdo = Conexion::getPDO();
        $stmt = $pdo->prepare("SELECT ti.pk_titular, ti.nombre, ti.a_paterno, ti.a_materno, d.calle, tar.puesto, tar.direccion, ti.categoria FROM titular ti INNER JOIN tarjeton tar ON ti.pk_titular=tar.fk_titular INNER JOIN direccion d ON ti.pk_titular=d.fk_titular WHERE ti.pk_titular=:id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

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