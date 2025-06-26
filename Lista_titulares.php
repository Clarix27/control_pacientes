<?php
  session_start();
  // Verificar si el usuario ha iniciado sesión
  if (!isset($_SESSION['pk_usuario'])) {
    // Redirigir a la página de login si no está autenticado
    echo("<script>window.location.assign('Login.html');</script>");
    exit();
  }
  
  require_once 'controladores/info_titular.php';
  $pk_titular = true;
  $datos_titular = info_titilar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Listado de Pacientes - DIF Escuinapa</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/menu.css">
  <link rel="stylesheet" href="css/estilo_lista_titu.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<body>
<?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'actualizado'): ?>
  <div id="toast-exito" class="toast-exito">Titular actualizado con éxito</div>
  <script>
    setTimeout(() => {
      const toast = document.getElementById('toast-exito');
      if (toast) toast.style.display = 'none';
    }, 4000);
  </script>
<?php endif; ?>

<?php include 'menu.php'?>

<div style="margin: 15px 0 0 20px;">
  <a href="Inicio.php" class="back-button" title="Regresar">
    <i class="fas fa-arrow-left"></i>
    <span class="back-text">Regresar</span>
  </a>
</div>


<div class="titulo-container-subtle">
<<<<<<< HEAD
  <h2 style="text-align: center; margin-top: 20px; " class="titulo-pagina">LISTA DE TITULARES AFILIADOS AL DIF</h2>
=======
  <h2 style="text-align: center; margin-top: 20px;" class="titulo-pagina">LISTA DE TITULARES AFILIADOS AL DIF</h2>
>>>>>>> origin/Jose
</div>

<div class="content">
  <div class="filter">
    <div class="filter-left">
      <label for="categoria">Filtro de búsqueda - Categoría:</label>
      <select id="categoria">
        <option value="" selected>Ver todos</option>
        <option value="confianza">Confianza</option>
        <option value="sindicalizado">Sindicalizado</option>
        <option value="seguridad pública">Seguridad Pública</option>
      </select>
    </div>

    <div class="filter-right">
      <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="buscador" placeholder="Buscar paciente...">
      </div>
    </div>
  </div>

  <!-- Tabla -->
  <table id="tablaTitulares">
    <thead>
      <tr>
        <th>Nombre Titular</th>
        <th>Domicilio</th>
        <th>Puesto</th>
        <th>Dirección</th>
        <th>Dependencia</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($datos_titular)): ?>
        <tr>
          <td colspan="6">No se encontraron titulares.</td>
        </tr>
      <?php else: ?>
        <?php foreach ($datos_titular as $fila): ?>
          <tr>
            <td><?= htmlspecialchars($fila['nombre'].' '.$fila['a_paterno'].' '.$fila['a_materno'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($fila['calle'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><strong><?= htmlspecialchars($fila['puesto'], ENT_QUOTES, 'UTF-8') ?></strong></td>
            <td><?= htmlspecialchars($fila['direccion'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><span class="badge"><?= htmlspecialchars($fila['categoria'], ENT_QUOTES, 'UTF-8') ?></span></td>
            <td>
              <div class="acciones-container">
                <a href="editar_titular.php?id=<?= urlencode($fila['pk_titular']) ?>" class="btn-accion btn-editar" title="Editar">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="Historial_titular.php?id=<?= urlencode($fila['pk_titular']) ?>" class="btn-accion btn-historial" title="Historial">
                  <i class="fas fa-file-medical"></i>
                </a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Script de filtro y búsqueda -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const buscador = document.getElementById("buscador");
    const filtroCategoria = document.getElementById("categoria");
    const filas = document.querySelectorAll("#tablaTitulares tbody tr");

    function filtrar() {
      const texto = buscador.value.toLowerCase();
      const categoria = filtroCategoria.value.toLowerCase();

      filas.forEach(fila => {
        const nombre = fila.cells[0].textContent.toLowerCase();
        const cat = fila.cells[4].textContent.toLowerCase();

        const coincideNombre = nombre.includes(texto);
        const coincideCategoria = !categoria || cat.includes(categoria);

        fila.style.display = (coincideNombre && coincideCategoria) ? "" : "none";
      });
    }

    buscador.addEventListener("input", filtrar);
    filtroCategoria.addEventListener("change", filtrar);
  });
</script>

<footer>
  Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo. 
  <a href="aviso_privacidad.php">Aviso de privacidad</a>
</footer>



</body>
</html>