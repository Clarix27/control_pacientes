<?php
    require_once 'conexion.php';
    

    // Consulta para mostrar información del titular
    function info_titilar(){
        $pdo = Conexion::getPDO();
        $sql = $pdo->query("SELECT ti.pk_titular, ti.nombre, ti.a_paterno, ti.a_materno, d.calle, tar.puesto, tar.direccion, ti.categoria FROM titular ti INNER JOIN tarjeton tar ON ti.pk_titular=tar.fk_titular INNER JOIN direccion d ON ti.pk_titular=d.fk_titular ORDER BY ti.pk_titular DESC");
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // Consulta para mostar la informacion del paciente
    function datos_beneficiarios($id, $estatus){
        $pdo = Conexion::getPDO();
        $stmt = $pdo->prepare("SELECT b.pk_beneficiario, b.nombre, b.a_paterno, b.a_materno, b.edad, b.sexo, b.parentesco FROM tarjeton tar INNER JOIN beneficiarios b ON tar.pk_tarjeton=b.fk_tarjeton WHERE tar.fk_titular=:id AND estatus=:estatus");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':estatus', $estatus, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Consulta para mostrar información del titular pasandole un id
    function titular_id($id){
        $pdo = Conexion::getPDO();
        $stmt = $pdo->prepare("SELECT 
            ti.pk_titular, 
            ti.nombre, 
            ti.a_paterno, 
            ti.a_materno, 
            ti.categoria, 
            tar.puesto, 
            tar.direccion, 
            d.calle, 
            d.num_casa, 
            d.colonia, 
            d.municipio
        FROM titular ti
        INNER JOIN tarjeton tar ON ti.pk_titular = tar.fk_titular
        INNER JOIN direccion d ON ti.pk_titular = d.fk_titular
        WHERE ti.pk_titular = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Función para editar el beneficiario
    function beneficiario_id($id) {
        $pdo = Conexion::getPDO();
        $stmt = $pdo->prepare("SELECT 
            b.pk_beneficiario, b.nombre, b.a_paterno, b.a_materno, 
            b.edad, b.sexo, b.parentesco, b.fk_tarjeton
        FROM beneficiarios b 
        WHERE b.pk_beneficiario=:id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    

    function info_beneficiario($id) {
        $pdo = Conexion::getPDO();
        $stmt = $pdo->prepare("SELECT b.pk_beneficiario, b.nombre, b.a_paterno, b.a_materno FROM beneficiarios b WHERE b.pk_beneficiario=:id");
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