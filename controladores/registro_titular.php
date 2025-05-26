<?php
    require_once('conexion.php');

    $nombre = $_POST['nombre'] ?? 'jose';
    $a_paterno = $_POST['apaterno'] ?? 'perez';
    $a_materno = $_POST['amaterno'] ?? NULL;
    $domicilio = $_POST['domicilio'] ?? 'Francisco I Madero';
    $puesto = $_POST['puesto'] ?? 'Auxiliar de Despensas';
    $direccion = $_POST['direccion'] ?? 'Sistema Dif';
    $categoria = $_POST['categoria'] ?? 'Confianza';
    $folio = $_POST['folio'] ?? 'F-002';

    //Insertar el titular
    $sql = $pdo->prepare("INSERT INTO titular(nombre, a_paterno, a_materno, categoria) VALUES(:nombre, :a_paterno, :a_materno, :categoria)");
    $sql->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $sql->bindParam(':a_paterno', $a_paterno, PDO::PARAM_STR);
    $sql->bindParam(':a_materno', $a_materno, PDO::PARAM_STR);
    $sql->bindParam(':categoria', $categoria, PDO::PARAM_STR);
    $sql->execute();
    $titular_id = $pdo->lastInsertId();
    if($titular_id){
        echo 'si';
    }

    //Insertar los demas datos al tarjeton
    $sql2 = $pdo->prepare("INSERT INTO tarjeton(folio, puesto, direccion, fk_titular) VALUES(:folio, :puesto, :direccion, :fk_titular)");
    $sql2->bindParam(':folio', $folio, PDO::PARAM_STR);
    $sql2->bindParam(':puesto', $puesto, PDO::PARAM_STR);
    $sql2->bindParam(':direccion', $direccion, PDO::PARAM_STR);
    $sql2->bindParam(':fk_titular', $titular_id, PDO::PARAM_INT);
    $sql2->execute();

    var_dump($sql2);
?>