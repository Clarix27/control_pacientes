<?php
  require_once 'controladores/conexion.php';
  $pdo = Conexion::getPDO();
  $sql = $pdo->query("SELECT ti.nombre AS t_nombre, ti.a_paterno AS t_paterno, ti.a_materno AS t_materno, p.nombre, p.a_paterno, p.a_materno, tar.folio, c.tipo_consulta, ti.dependencia, c.pago FROM titular ti INNER JOIN paciente p ON ti.pk_titular=p.fk_titular LEFT JOIN tarjeton tar ON ti.pk_titular=tar.fk_titular INNER JOIN consulta c ON ti.pk_titular=c.fk_titular WHERE c.fecha = CURDATE() ORDER BY c.pk_consulta DESC");
  $pacientes = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Control de Pacientes</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/alerta_controlP.css">
</head>
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: Arial, sans-serif;
    background: #fff;
  }

  .registro-container {
    background-color: #D9D9D9;
    border-radius: 10px;
    padding: 15px 20px;
    margin: 20px;
  }

  .registro-fila {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    gap: 20px;
    flex-wrap: wrap;
  }

  .registro-fila label {
    font-weight: bold;
    margin-right: 10px;
  }

  .registro-fila select {
    padding: 6px 10px;
    border-radius: 6px;
    border: 1px solid #aaa;
    min-width: 180px;
  }

  .boton-registrar {
    background-color: #a4e0e6;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  .boton-registrar:hover {
    background-color: #89cfd6;
  }

  .tabla-pacientes {
    width: 90%;
    margin: 30px auto;
    border-collapse: collapse;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
    font-size: 15px;
  }

  .tabla-pacientes th {
    background-color: #BCB8B8;
    padding: 12px;
    text-align: center;
    color: #333;
  }

  .tabla-pacientes td {
    background-color: #D9D9D9;
    padding: 10px;
    text-align: center;
  }

  h2 {
    text-align: center;
    font-size: 22px;
    margin-top: 40px;
    color: #2c3e50;
  }

  .boton-rojo {
    display: block;
    margin: 25px auto;
    padding: 10px 25px;
    background-color: #cc1a1a;
    color: white;
    font-weight: bold;
    font-size: 16px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  .boton-rojo:hover {
    background-color: #b01212;
  }

  .titulo-pagina {
    font-size: 28px;
    font-weight: bold;
    color: #333;
  }

  .titulo-container-subtle {
    background: #9CD8D9;
    border-left: 8px solid #CC1A1A;
    padding: 2px 5px;
    margin: 20px 0 10px 0;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
  }

  .titulo-container-subtle h2 {
    margin: 0;
    font-size: 21px;
    font-weight: 600;
    text-align: center;
    color: #2c3e50;
  }

  .titulo-registro {
    font-size: 20px;
    font-weight: 600;
    color: #2c3e50;
    text-align: left;
    margin: 0;
    padding: 0 0 10px 0;
  }

  #modalFormulario {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4);
  z-index: 1000;
  justify-content: center;
  align-items: center;
  overflow: auto;
  padding: 20px;
}

  #modalFormulario .modal-contenido {
  background-color: #fff5f5;
  padding: 30px;
  border-radius: 14px;
  width: 100%;
  max-width: 750px;
  max-height: 90vh;
  overflow-y: auto;
  border: 3px solid #a90000;
  box-shadow: 0 6px 20px rgba(0,0,0,0.25);
  font-family: 'Poppins', sans-serif;
  color: #333;
  position: relative;
}

  #modalFormulario .modal-contenido form {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  #modalFormulario input {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
  }

  #modalFormulario label {
    font-weight: 600;
    margin-top: 10px;
    font-size: 14px;
  }

  #modalFormulario .cerrar {
    position: absolute;
    top: 15px;
    right: 15px;
    background: transparent;
    border: none;
    font-size: 22px;
    color: #a90000;
    cursor: pointer;
  }

  #modalFormulario .cerrar:hover {
    color: #7a0000;
  }

  #modalFormulario .enviar-modal {
    background-color: #28a745;
    color: white;
    font-weight: bold;
    border: none;
    padding: 12px;
    border-radius: 8px;
    font-size: 16px;
    margin-top: 15px;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  #modalFormulario .enviar-modal:hover {
    background-color: #218838;
  }
</style>
<body>
  <?php include 'menu.php'?>

  <?php include 'regresar.php'?>

  <div class="titulo-container-subtle">
    <h2 style="text-align: center; margin-top: 20px;" class="titulo-pagina">CONTROL DE PACIENTES</h2>
  </div>

  <div class="registro-container">
    <h2 class="titulo-registro">Registro De Pacientes:</h2>
    <div class="registro-fila">
      <div>
        <label for="filtro_area">Filtrar por área:</label>
        <select name="filtro_area" id="filtro_area">
          <option value="">Todas</option>
          <option value="DENTAL">DENTAL</option>
          <option value="MEDICA">MÉDICA</option>
          <option value="PSICOLOGICA">PSICOLÓGICA</option>
        </select>
      </div>
      <button class="boton-registrar" onclick="mostrarModal()">REGISTRAR</button>
    </div>
  </div>

  <h2>Tabla de pacientes</h2>
  <table class="tabla-pacientes">
    <thead>
      <tr>
        <th>Nombre Titular:</th>
        <th>Nombre Paciente:</th>
        <th>Tarjeton:</th>
        <th>Área:</th>
        <th>Dependencia:</th>
        <th>Apoyo/Pago:</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Jose Guadalupe Llamas Padilla</td>
        <td>Jose Guadalupe Llamas Padilla</td>
        <td class="resaltado">231–C</td>
        <td><span class="resaltado-azul">DENTAL</span></td>
        <td>DIF</td>
        <td>Apoyo DIF</td>
      </tr>
    </tbody>
  </table>
  
  <div id="modalFormulario">
  <div class="modal-contenido">
    <!-- Botón de cerrar con ícono de X -->
    <button class="cerrar" onclick="cerrarModal()" title="Cerrar">
      <i class="fas fa-times"></i>
    </button>

    <form>
      <label>Nombre Titular:</label>
      <input type="text" name="nombre_titular" placeholder="Nombre">
      <input type="text" name="ap_paterno_titular" placeholder="Apellido paterno">
      <input type="text" name="ap_materno_titular" placeholder="Apellido materno">

          <label>Dependencia:</label>
          <input type="text" name="dependencia" placeholder="Dependencia">
        </div>

      <label>Dependencia:</label>
      <input type="text" name="dependencia" placeholder="Dependencia">

      <label>Nombre Paciente:</label>
      <input type="text" name="nombre_paciente" placeholder="Nombre">
      <input type="text" name="ap_paterno_paciente" placeholder="Apellido paterno">
      <input type="text" name="ap_materno_paciente" placeholder="Apellido materno">

      <label>Área:</label>
      <input type="text" name="area" class="resaltado-azul" placeholder="Área">

      <label>Apoyo/Pago:</label>
      <input type="text" name="apoyo" placeholder="Apoyo">

      <!-- Botón enviar agregado debajo del formulario -->
      <button type="submit" class="enviar-modal">Enviar Datos</button>
    </form>
  </div>

  <script>
    function mostrarModal() {
      document.getElementById('modalFormulario').style.display = 'flex';
    }
    function cerrarModal() {
      document.getElementById('modalFormulario').style.display = 'none';
    }
  </script>
</body>
</html>
