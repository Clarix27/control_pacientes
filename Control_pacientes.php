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
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 10px;
    gap: 10px;
  }

  .registro-fila label {
    font-weight: bold;
  }

  .registro-fila span {
    background: white;
    padding: 4px 8px;
    border-radius: 4px;
    min-width: 150px;
    text-align: center;
  }

  .registro-fila input {
    padding: 4px 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
    min-width: 150px;
  }

  .resaltado {
    font-weight: bold;
    color: #c80000;
  }

  .resaltado-azul {
    font-weight: bold;
    background-color: #bde4eb;
  }


  .boton-registrar {
    background-color: #a4e0e6;
    border: none;
    padding: 6px 12px;
    margin-left: auto;
    border-radius: 4px;
    font-weight: bold;
    cursor: pointer;
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


  .back-button {
    color: #333;
    font-size: 30px; 
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: color 0.3s ease;
  }

  .back-button:hover {
    color: #000;
  }

  .back-text {
    font-size: 18px;  
    font-weight: normal;
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
</style>
<body>
  <?php include 'menu.php'?>

  <div style="margin: 15px 0 0 20px;">
    <a href="Inicio.html" class="back-button" title="Regresar">
      <i class="fas fa-arrow-left"></i>
      <span class="back-text">Regresar</span>
    </a>
  </div>

  <div  class="titulo-container-subtle">
    <h2 style= "text-align: center; margin-top: 20px;" class="titulo-pagina">CONTROL DE PACIENTES</h2>
  </div>

  <div class="registro-container">
    <h2 class="titulo-registro">Registro De Pacientes:</h2>
    <div class="registro-formulario">

      <form id="formControlP">
        <!-- Datos Titular -->
        <div class="registro-fila">
          <label>Nombre Titular:</label>
          <input type="text" name="nombre_t" placeholder="Nombre" >
          <input type="text" name="paterno_t" placeholder="Apellido paterno">
          <input type="text" name="materno_t" placeholder="Apellido materno">

          <label>Tarjeton:</label>
          <input type="text" name="tarjeton" class="resaltado" placeholder="Tarjeton">

          <label>Dependencia:</label>
          <input type="text" name="dependencia" placeholder="Dependencia">
        </div>

        <!-- Datos Paciente -->
        <div class="registro-fila">
          <label>Nombre Paciente:</label>
          <input type="text" name="nombre_p" placeholder="Nombre">
          <input type="text" name="paterno_p" placeholder="Apellido paterno">
          <input type="text" name="materno_p" placeholder="Apellido materno">

          <label>Área:</label>
          <input type="text" name="area" class="resaltado-azul" placeholder="Area:">

          <label>Apoyo/Pago:</label>
          <input type="number" min="0" name="apoyo" placeholder="Apoyo:">

          <label>Fecha:</label>
          <input type="date" name="fecha">

          <label>Parentesco:</label>
          <select id="opciones" name="parentesco">
            <option value="">-- Selecciona el Parentesco --</option>
            <option value="Esposo">Esposo</option>
            <option value="Hija">Hija</option>
            <option value="Hijo">Hijo</option>
            <option value="Misma persona">Misma persona</option>
          </select>

          <button type="submit" class="boton-registrar">REGISTRAR</button>
        </div>
      </form>
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

  <script src="js/control_pacientes.js"></script>
</body>
</html>


