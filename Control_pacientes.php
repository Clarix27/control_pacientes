<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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

  .titulo-containerr-subtlee {
    background:rgba(156, 216, 217, 0.54);
   
    padding: 2px 5px;
    margin: 20px 0 10px 0;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
  }

  .titulo-containerr-subtlee h2 {
    margin: 0;
    font-size: 21px;
    font-weight: 600;
    text-align: center;
    color: #2c3e50;
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
    font-size: 15px;
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
    width: 50%;
    justify-self: center;
    align-self: center;
  }

  #modalFormulario .enviar-modal:hover {
    background-color: #218838;
  }

   .back-button {
  color: #333;
  font-size: 18px;
  font-weight: bold;
  text-decoration: none;
  text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
  transition: color 0.3s ease;
}

.back-button:hover {
  color: #cc1a1a;
  text-shadow: 1px 1px 3px rgba(204, 26, 26, 0.6);
}

.back-text {
  font-size: 18px;  
  font-weight: normal;
}

.filter-right {
  display: flex;
  align-items: center;
  margin-top: 10px;
}

.search-box {
  display: flex;
  align-items: center;
  background: white;
  border-radius: 30px;
  padding: 5px 10px;
  border: 1px solid #ccc;
}

.search-box input {
  border: none;
  outline: none;
  padding: 5px 10px;
  font-size: 14px;
  border-radius: 30px;
  width: 200px;
}

.search-box i {
  color: #666;
  margin-right: 5px;
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

  <div class="titulo-container-subtle">
    <h2 style="text-align: center; margin-top: 20px;" class="titulo-pagina">CONTROL DE PACIENTES</h2>
  </div>

  <div class="registro-container">
  <h2 class="titulo-registro">Buscador de pacientes:</h2>
  <div class="registro-fila">
    <div class="search-box">
      <i class="fas fa-search"></i>
      <input type="text" id="buscador" placeholder="Buscar paciente...">

    </div>
    <div style="margin-left: auto;">
      <button class="boton-registrar" onclick="mostrarModal()">REGISTRAR</button>
    </div>
  </div>
</div>
<div class="titulo-containerr-subtlee">
    <h2 style="text-align: center; margin-top: 20px;" class="titulo-pagina">LISTA DE PACIENTES</h2>
  </div>


  <table class="tabla-pacientes" id="tablaPacientes">

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

      <label>Tarjeton:</label>
      <input type="text" name="tarjeton" class="resaltado" placeholder="Tarjeton">

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
</div>

  <script>
    function mostrarModal() {
      document.getElementById('modalFormulario').style.display = 'flex';
    }
    function cerrarModal() {
      document.getElementById('modalFormulario').style.display = 'none';
    }
  </script>
  <script>
  // Mostrar y cerrar modal
  function mostrarModal() {
    document.getElementById('modalFormulario').style.display = 'flex';
  }

  function cerrarModal() {
    document.getElementById('modalFormulario').style.display = 'none';
  }

  // Buscador dinámico
  document.getElementById('buscador').addEventListener('keyup', function () {
    const filtro = this.value.toLowerCase();
    const filas = document.querySelectorAll('#tablaPacientes tbody tr');

    filas.forEach(fila => {
      const nombreTitular = fila.cells[0].textContent.toLowerCase();
      const nombrePaciente = fila.cells[1].textContent.toLowerCase();
      const tarjeton = fila.cells[2].textContent.toLowerCase();

      const coincide = nombreTitular.includes(filtro) || nombrePaciente.includes(filtro) || tarjeton.includes(filtro);

      fila.style.display = coincide ? '' : 'none';
    });
  });
</script>

</body>
</html>