<?php 
  session_start();
  // Verificar si el usuario ha iniciado sesión
  if (!isset($_SESSION['pk_usuario'])) {
    // Redirigir a la página de login si no está autenticado
    echo("<script>window.location.assign('Login.html');</script>");
    exit();
  }

  $pk_titular = $_GET['id_t'];
  $id_beneficiario = $_GET['id_b'];
  if (empty($pk_titular) && empty($id_beneficiario)) {
    echo "<script>alert('No se encontro el ID');</script>";
    echo("<script>window.location.assign('Inicio.php');</script>");
    exit;
  }

  require_once 'controladores/conexion.php';
  $pdo = Conexion::getPDO();
  $stmt = $pdo->prepare("SELECT b.nombre, b.a_paterno, b.a_materno, tar.folio FROM beneficiarios b INNER JOIN tarjeton tar ON b.fk_tarjeton=tar.pk_tarjeton WHERE b.pk_beneficiario = :idp");
  $stmt->bindParam(':idp', $id_beneficiario, PDO::PARAM_INT);
  $stmt->execute();
  $tarjeton = $stmt->fetch(PDO::FETCH_ASSOC);
  $folio = $tarjeton['folio'];
  $nombre = $tarjeton['nombre'];
  $paterno = $tarjeton['a_paterno'];
  $materno = $tarjeton['a_materno'];

  // Parte de la consulta
  $sql = $pdo->prepare("SELECT p.nombre, p.a_paterno, p.a_materno, c.tipo_consulta, c.fecha, r.texto_receta FROM consulta c INNER JOIN paciente p ON c.fk_paciente = p.pk_paciente INNER JOIN receta r ON c.fk_receta = r.pk_receta WHERE p.nombre=:nombre AND p.a_paterno=:paterno AND p.a_materno=:materno AND c.fk_titular = :idt AND p.fk_titular = :id ORDER BY c.fecha DESC, c.pk_consulta DESC;");
  $sql->bindParam(':nombre', $nombre, PDO::PARAM_INT);
  $sql->bindParam(':paterno', $paterno, PDO::PARAM_INT);
  $sql->bindParam(':materno', $materno, PDO::PARAM_INT);
  $sql->bindParam(':idt', $pk_titular, PDO::PARAM_INT);
  $sql->bindParam(':id', $pk_titular, PDO::PARAM_INT);
  $sql->execute();
  $consultas = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Consulta con Receta</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      font-family: Arial, sans-serif;
      background: #fff;
    }
    .back-button {
      color: #333; font-size: 18px; font-weight: bold;
      text-decoration: none; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
      transition: color 0.3s ease;
    }
    .back-button:hover {
      color: #cc1a1a;
      text-shadow: 1px 1px 3px rgba(204,26,26,0.6);
    }
    .back-text { font-size: 18px; font-weight: normal; }

    .tituloo_container-subtle h2 {
      text-align: center;
      margin: 20px 0;
      padding: 10px 5px;
      background: #008080;
      border-left: 8px solid #CC1A1A;
      color: #fff;
      font-weight: 600;
      font-size: 21px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.15);
    }

    .registro-container {
      background-color: #D9D9D9;
      border-radius: 10px;
      padding: 15px 20px;
      margin: 20px;
    }
    .registro-fila {
      display: flex;
      justify-content: flex-start; /* alineado a la izquierda */
      align-items: center;
      gap: 10px;
    }
    .search-box {
      display: flex;
      align-items: center;
      background: #fff;
      border-radius: 30px;
      padding: 5px 10px;
      border: 1px solid #ccc;
    }
    .search-box i {
      margin-right: 8px;
      color: #666;
      font-size: 16px;
    }
    .search-box input[type="date"] {
      border: none;
      outline: none;
      padding: 5px 10px;
      font-size: 14px;
      border-radius: 30px;
      width: 180px;
      cursor: pointer;
    }

    .contenedor-consultas-multicolumna {
      display: grid;
      /* 2 columnas, cada una al menos 600px y luego se reparten el espacio sobrante */
      grid-template-columns: repeat(2, minmax(600px, 1fr));
      gap: 30px 40px;
      max-width: 1300px;    /* 600 + 600 + gap ≈ 1300 */
      margin: 0 auto;
      padding: 40px 30px 60px;
    }

    .tarjeta-consulta {
      background-color: #eee;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      padding: 30px;
      position: relative;
      width: auto;          /* respeta el grid */
    }

    /* Opcional: en pantallas < 1200 baja a 1 columna */
    @media (max-width: 1200px) {
      .contenedor-consultas-multicolumna {
        grid-template-columns: 1fr;
        max-width: 600px;
      }
    }

    .fecha-etiqueta {
      position: absolute;
      top: -12px; left: 10px;
      background: #6ec1e4;
      color: #000;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 12px;
      font-weight: bold;
    }
    .tarjeton { color: #cc1a1a; font-weight: bold; }

    footer {
      margin-top: auto;
      text-align: center;
      font-size: 14px;
      padding: 20px 10px;
      background-color: #f8f8f8;
      color: #444;
      border-top: 1px solid #ccc;
    }
    footer a {
      color: #b1071e; font-weight: bold; text-decoration: none;
    }
    footer a:hover { text-decoration: underline; }
  </style>
</head>
<body>

  <?php include 'menu.php'; ?>

  <div style="margin: 15px 0 0 20px;">
    <a href="Historial_titular.php?id=<?=urlencode($pk_titular)?>" class="back-button">
      <i class="fas fa-arrow-left"></i>
      <span class="back-text">Regresar</span>
    </a>
  </div>

  <div class="tituloo_container-subtle">
    <h2>LISTA GENERAL DE CONSULTAS DEL BENEFICIARIO</h2>
  </div>

  <div class="registro-container">
    <div class="registro-fila">
      <label for="filtro-fecha">Filtro por fecha:</label>
      <div class="search-box">
        <i class="fas fa-calendar-alt"></i>
        <input id="filtro-fecha" type="date">
      </div>
    </div>
  </div>

  <div class="contenedor-consultas-multicolumna">
    <!-- Repite más tarjetas según datos -->
    <?php if (empty($consultas)): ?>
      <div class="sin-consultas">
        <p>No se encontraron consultas.</p>
      </div>
    <?php else: ?>
      <?php foreach ($consultas as $c): 
        // Escapa cada valor antes de usarlo
        $fecha    = htmlspecialchars($c['fecha'], ENT_QUOTES, 'UTF-8');
        $paciente = htmlspecialchars($c['nombre'] . ' ' .$c['a_paterno'] . ' ' .$c['a_materno'], ENT_QUOTES, 'UTF-8');
        $area     = htmlspecialchars($c['tipo_consulta'], ENT_QUOTES, 'UTF-8');
        $receta   = htmlspecialchars($c['texto_receta'], ENT_QUOTES, 'UTF-8');
      ?>
        <div class="tarjeta-consulta">
          <div class="fecha-etiqueta"><?= $fecha ?></div>
          <div style="display:flex; flex-direction:column; gap:10px; font-size:15px; color:#333;">
            <div><strong>Paciente:</strong> <?= $paciente ?></div>
            <div><strong>Tarjetón:</strong> <span class="tarjeton"><?= $folio ?></span></div>
            <div><strong>Área de Consulta:</strong> <?= $area ?></div>
            <div style="background:#fff; padding:10px; border-left:4px solid #129990; border-radius:6px;">
              <i class="fas fa-capsules" style="color:#129990; margin-right:8px;"></i>
              <span><strong>Receta:</strong> <?= $receta ?></span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <footer>
    Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo.
    <a href="#">Aviso de privacidad</a>
  </footer>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const filtro = document.getElementById("filtro-fecha");

      function parseDateString(str) {
        // str puede ser "DD/MM/YYYY" o "YYYY-MM-DD" o "YYYYMMDD"
        let y,m,d;
        if (str.includes("/")) {
          [d,m,y] = str.split("/");
        } else if (str.includes("-")) {
          [y,m,d] = str.split("-");
        } else if (/^\d{8}$/.test(str)) {
          y = str.slice(0,4);
          m = str.slice(4,6);
          d = str.slice(6,8);
        } else {
          return null;
        }
        // JavaScript Date constructor con "YYYY-MM-DD" es seguro
        return new Date(`${y}-${m}-${d}`).getTime();
      }

      filtro.addEventListener("input", () => {
        const selected = filtro.value;           // "YYYY-MM-DD" o ""
        const tsSelected = selected 
          ? parseDateString(selected) 
          : null;

        document.querySelectorAll(".tarjeta-consulta").forEach(t => {
          const txt = t.querySelector(".fecha-etiqueta")
                      .textContent.trim();
          const tsCard = parseDateString(txt);

          // Si no pudimos parsear la fecha de la tarjeta, la mostramos
          if (tsCard === null) {
            t.style.display = "";
            return;
          }

          // Si no hay filtro o coinciden timestamps, la mostramos
          t.style.display = (!tsSelected || tsCard === tsSelected)
            ? ""
            : "none";
        });
      });
    });
  </script>

</body>
</html>
