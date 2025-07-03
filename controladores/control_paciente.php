<?php
    try {
        header('Content-Type: application/json');
        require_once 'conexion.php';

        // Validar campos obligatorios de titular/tarjetón
        $requiredTitular = ['nombre_t', 'paterno_t', 'nombre_p', 'paterno_p', 'area', 'fecha', 'dependencia', 'parentesco'];
        foreach ($requiredTitular as $campo) {
            if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
                switch ($campo) {
                    case 'nombre_t':
                        $campo = 'Nombre Titular';
                        break;
                    case 'paterno_t':
                        $campo = 'Apellido paterno del Titular';
                        break;
                    case 'nombre_p':
                        $campo = 'Nombre Paciente';
                        break;
                    case 'paterno_p':
                        $campo = 'Apellido Paterno del Paciente';
                        break;
                    case 'fecha':
                        $campo = 'Fecha';
                        break;
                    case 'parentesco':
                        $campo = 'Parentesco';
                        break;   
                    case 'dependencia':
                        $campo = 'Dependencia';
                        break;   
                    default:
                        // throw new Exception("Error en la estructura de validación.");
                        break;
                }
                echo json_encode([
                    'success' => false,
                    'message' => "Falta el campo obligatorio: $campo"
                ]);
                exit;
            }
        }
        // Lista de caracteres a eliminar
        $toRemove = ['-','@','#','$','%','&','*','+','/','=','.',',',';',':','!','?','\''];

        // Resiviendo datos.
        $nombre_t2 = isset($_POST['nombre_t']) ? trim($_POST['nombre_t']) : '';
        $nombre_t3 = str_replace($toRemove, '', $nombre_t2);
        $nombre_t = mb_strtoupper($nombre_t3, 'UTF-8');  
        //Quitanos caracteres.
        $paterno_t2 = isset($_POST['paterno_t']) ? trim($_POST['paterno_t']) : '';
        $paterno_t3 = str_replace($toRemove, '', $paterno_t2);
        $paterno_t = mb_strtoupper($paterno_t3, 'UTF-8');  
        //Quitanos caracteres.
        $materno_t2 = isset($_POST['materno_t']) ? trim($_POST['materno_t']) : '';
        $materno_t3 = str_replace($toRemove, '', $materno_t2);
        $materno_t = mb_strtoupper($materno_t3, 'UTF-8');  
        //Quitanos caracteres.
        $nombre_p2 = isset($_POST['nombre_p']) ? trim($_POST['nombre_p']) : '';
        $nombre_p3 = str_replace($toRemove, '', $nombre_p2);
        $nombre_p = mb_strtoupper($nombre_p3, 'UTF-8');  
        //Quitanos caracteres.
        $paterno_p2 = isset($_POST['paterno_p']) ? trim($_POST['paterno_p']) : '';
        $paterno_p3 = str_replace($toRemove, '', $paterno_p2);
        $paterno_p = mb_strtoupper($paterno_p3, 'UTF-8');  
        //Quitanos caracteres.
        $materno_p2 = isset($_POST['materno_p']) ? trim($_POST['materno_p']) : ''; 
        $materno_p3 = str_replace($toRemove, '', $materno_p2);
        $materno_p = mb_strtoupper($materno_p3, 'UTF-8');  

        //$tarjeton = isset($_POST['tarjeton']) ? trim($_POST['tarjeton']) : '';
        $parentesco = isset($_POST['parentesco']) ? trim($_POST['parentesco']) : ''; 
        $categoria = 'Normal';
        $var_area = isset($_POST['area']) ? trim($_POST['area']) : '';
        $area = mb_strtoupper($var_area);
        $fecha = $_POST['fecha'];
        $var_d = isset($_POST['dependencia']) ? trim($_POST['dependencia']) : '';
        $dependencia = mb_strtoupper($var_d);
        $apoyo = isset($_POST['apoyo']) ? intval(trim($_POST['apoyo'])) : 0;
        $turno = 'Sin turno';
        $fk_empleado = 1;
        $fk_receta = null;
        $paciente_id = 0;
        $consulta_id = 0;

        // Se crea la funcion para insertar el titular
        function insertar_titular($nombre_t, $paterno_t, $materno_t, $dependencia, $categoria): int {
            $pdo = Conexion::getPDO();
            $sql = $pdo->prepare("INSERT INTO titular(nombre, a_paterno, a_materno, dependencia, categoria) VALUES(:nombre, :a_paterno, :a_materno, :dependencia, :categoria)");
            $sql->bindParam(':nombre', $nombre_t, PDO::PARAM_STR);
            $sql->bindParam(':a_paterno', $paterno_t, PDO::PARAM_STR);
            $sql->bindParam(':a_materno', $materno_t, PDO::PARAM_STR);
            $sql->bindParam(':dependencia', $dependencia, PDO::PARAM_STR);
            $sql->bindParam(':categoria', $categoria, PDO::PARAM_STR);
            $sql->execute();
            return $pdo->lastInsertId();
        }

        // Función para insertar paciente.
        function insertar_paciente($nombre_p, $paterno_p, $materno_p, $parentesco , $fk): int {
            $pdo = Conexion::getPDO();
            $stmt = $pdo->prepare("INSERT INTO paciente(nombre, a_paterno, a_materno, parentesco, fk_titular) VALUES(:nombre, :apaterno, :amaterno, :parentesco, :fk)");
            $stmt->bindParam(':nombre', $nombre_p, PDO::PARAM_STR);
            $stmt->bindParam(':apaterno', $paterno_p, PDO::PARAM_STR);
            $stmt->bindParam(':amaterno', $materno_p, PDO::PARAM_STR);
            $stmt->bindParam(':parentesco', $parentesco, PDO::PARAM_STR);
            $stmt->bindParam(':fk', $fk, PDO::PARAM_INT);
            $stmt->execute();
            return $pdo->lastInsertId();
        }

        // Registrar consulta
        function registrar_consulta($fecha, $pago, $turno, $tipo_consulta, $fk_titular, $fk_paciente, $fk_receta, $fk_empleado) : int {
            $pdo = Conexion::getPDO();
            $stmt = $pdo->prepare("INSERT INTO consulta(fecha, pago, turno, tipo_consulta, fk_titular, fk_paciente, fk_receta, fk_empleado) VALUES(:fecha, :pago, :turno, :tipo_consulta, :fk_titular, :fk_paciente, :fk_receta, :fk_empleado)");
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':pago', $pago, PDO::PARAM_INT);
            $stmt->bindParam(':turno', $turno, PDO::PARAM_STR);
            $stmt->bindParam(':tipo_consulta', $tipo_consulta, PDO::PARAM_STR);
            $stmt->bindParam(':fk_titular', $fk_titular, PDO::PARAM_INT);
            $stmt->bindParam(':fk_paciente', $fk_paciente, PDO::PARAM_INT);
            $stmt->bindParam(':fk_receta', $fk_receta, PDO::PARAM_NULL);
            $stmt->bindParam(':fk_empleado', $fk_empleado, PDO::PARAM_INT);
            $stmt->execute();
            return $pdo->lastInsertId();
        }

        // Traer tarjeton
        // function traer_t($tarjeton, $nombre_t, $paterno_t) {
        //     $pdo = Conexion::getPDO();
        //     $stmt = $pdo->prepare("SELECT t.pk_titular, t.a_materno FROM titular t INNER JOIN tarjeton tar WHERE tar.folio = :folio && t.nombre = :nombre && t.a_paterno = :paterno");
        //     $stmt->bindParam(':folio', $tarjeton, PDO::PARAM_STR);
        //     $stmt->bindParam(':nombre', $nombre_t, PDO::PARAM_STR);
        //     $stmt->bindParam(':paterno', $paterno_t, PDO::PARAM_STR);
        //     $stmt->execute();
        //     return $stmt->fetch(PDO::FETCH_ASSOC);
        // }

        
        // Se empieza a registrar y validar registros.
        $titular_id = insertar_titular($nombre_t, $paterno_t, $materno_t, $dependencia, $categoria);
        if (empty($titular_id)) {
            throw new Exception("Ocurrio un problema al registrar el titular.");
        }

        $paciente_id = insertar_paciente($nombre_p, $paterno_p, $materno_p, $parentesco, $titular_id);
        if (empty($paciente_id)) {
            throw new Exception("Ocurrio un problema al registrar el paciente.");
        }

        $consulta_id = registrar_consulta($fecha, $apoyo, $turno, $area, $titular_id, $paciente_id, $fk_receta, $fk_empleado);
        if (empty($consulta_id)) {
            throw new Exception("Ocurrio un problema al registrar la consulta.");
        }

        // Devolver JSON de éxito
        echo json_encode([
            'success' => true,
            'message' => "Se Registro con Éxito al Paciente: $nombre_p $paterno_p $materno_p"
        ]);
        exit;

    } catch (Exception $e) {
        //Si hay un error throw $th;
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
        exit;
    }
?>