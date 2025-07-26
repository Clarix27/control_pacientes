<?php
  session_start();
  // Verificar si el usuario ha iniciado sesión
  if (!isset($_SESSION['pk_usuario'])) {
    // Redirigir a la página de login si no está autenticado
    echo("<script>window.location.assign('Login.html');</script>");
    exit();
  }
  
  require_once 'controladores/info_titular.php';
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
  <link rel="stylesheet" href="css/eliminar_a.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<body>
<style>
   .acciones-container {
    display: flex;
    gap: 8px;          /* Espacio entre botones */
    flex-wrap: nowrap; /* Evita que brinquen de línea */
    justify-content: flex-start; /* Alinea a la izquierda */
    align-items: center;
  }

  .boton {
    display: inline-block;       /* Asegura que sean pequeños y horizontales */
    white-space: nowrap;         /* No permita salto de línea en el texto */
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: bold;
    font-family: 'Poppins', sans-serif;
    color: white;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .boton-morado { background-color: #6C5CE7; }
  .boton-naranja { background-color: #E67E22; }
  .boton-rojo { background-color: #b1071e; }

  .boton:hover {
    opacity: 0.9;
  }
</style>
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
  <h2 style="text-align: center; margin-top: 20px;" class="titulo-pagina">LISTA DE TITULARES AFILIADOS AL DIF</h2>
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

      <div class="boton-bajas">
        <a class="boton boton-rojo" href="bajas_titulares.php">Ver Bajas</a>
      </div>
    </div>

    <div class="filter-right">
      <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="buscador" placeholder="Buscar paciente...">
      </div>
    </div>
  </div>

  <table id="tablaTitulares">
    <thead>
      <tr>
        <th>Nombre Titular</th>
        <th>Domicilio</th>
        <th>Puesto</th>
        <th>Dirección</th>
        <th>Categoria</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr class="no-results" style="display: none">
        <td colspan="7" style="text-align:center">Vacío</td>
      </tr>
      <?php if (empty($datos_titular)): ?>
        <tr>
          <td colspan="7">No se encontraron titulares.</td>
        </tr>
      <?php else: ?>
        <?php foreach ($datos_titular as $fila): ?>
          <tr class="data-row">
            <td><?= htmlspecialchars($fila['nombre'].' '.$fila['a_paterno'].' '.$fila['a_materno'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($fila['calle'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><strong><?= htmlspecialchars($fila['puesto'], ENT_QUOTES, 'UTF-8') ?></strong></td>
            <td><?= htmlspecialchars($fila['direccion'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><span class="badge"><?= htmlspecialchars($fila['categoria'], ENT_QUOTES, 'UTF-8') ?></span></td>
            <td>
              <div class="acciones-container">
                <a href="Historial_titular.php?id=<?= urlencode($fila['pk_titular']) ?>" class="boton boton-morado">Historial Clínico</a>
                <a href="editar_titular.php?id=<?= urlencode($fila['pk_titular']) ?>" class="boton boton-naranja">Editar Titular</a>
                <a href="bajas.php" class="boton boton-rojo delete-link" data-id="<?=urlencode($fila['pk_titular'])?>">Dar de Baja</a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script>
  (() => {
    const buscador        = document.getElementById("buscador");
    const filtroCategoria = document.getElementById("categoria");
    const tbody           = document.querySelector("#tablaTitulares tbody");
    const dataRows        = Array.from(tbody.querySelectorAll("tr.data-row"));
    const noResultsRow    = tbody.querySelector("tr.no-results");

    function filtrar() {
      const texto     = buscador.value.trim().toLowerCase();
      const categoria = filtroCategoria.value.trim().toLowerCase();
      let visibles    = 0;

      for (const row of dataRows) {
        const nombre      = row.cells[0].textContent.trim().toLowerCase();
        const cat         = row.cells[4].textContent.trim().toLowerCase();
        const okNombre    = !texto     || nombre.includes(texto);
        const okCategoria = !categoria || cat.includes(categoria);

        const show = okNombre && okCategoria;
        row.style.display = show ? "" : "none";
        if (show) visibles++;
      }

      noResultsRow.style.display = visibles === 0 ? "table-row" : "none";
    }

    // Filtrar al escribir
    buscador.addEventListener("input", filtrar, { passive: true });
    // Limpiar búsqueda si hace click fuera (blur)
    buscador.addEventListener("blur", () => {
      if (buscador.value !== "") {
        buscador.value = "";
        filtrar();
      }
    });

    // Filtrar al cambiar categoría
    filtroCategoria.addEventListener("change", filtrar);

    // Estado inicial
    filtrar();
  })();
</script>

<script src="js/bajas.js"></script>

<footer>
  Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo. 
  <a href="aviso_privacidad.php">Aviso de privacidad</a>
</footer>



</body>
</html>