<?php
// Conexión con el archivo que sube los documentos
include("cargar.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calidad - Paperless</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <section class="header">
    <div class="section-banner"></div>
    <nav>
        <a href="index.htmlimages/logoblanco.png"></a>
      <div class="nav-links">
        <ul>
          <li>index.htmlHome</a></li>
        </ul>
      </div>
    </nav>
  </section>

  <section class="content">
    <div class="table-container">
      <h3>Subir Formatos</h3>

      <!-- Formulario para subir archivos -->
      <form method="post" enctype="multipart/form-data">
        <label for="archivos">Seleccionar Archivos</label><br>
        <input type="file" name="archivos[]" id="archivos" accept=".doc,.docx,.xls,.xlsx,.pdf" multiple required><br><br>

        <label for="linea">Área:</label><br>
        <select name="linea" required>
          <option value=""></option>
          <option value="Calidad">Calidad</option>
          <option value="Mantenimiento">Mantenimiento</option>
          <option value="Manofactura">Manufactura</option>
          <option value="Logistica">Logistica</option>
          <option value="RH">RH</option>
          <option value="Digitalizacion">Digitalizacion</option>
          <option value="Finanzas">Finanzas</option>
          <option value="Prueba">Prueba</option>
        </select><br><br>

        <label>
          <input type="checkbox" name="activo" value="1"> Activo
        </label><br><br>

        <input type="submit" name="submit" value="Subir archivos">
      </form>

      <hr>
      <h3>Formatos Subidos</h3>

      <?php
      $sql_listar = "SELECT ID, Nombre, Linea, Activo FROM dmp_checklist_Documentos ORDER BY ID DESC";
      $stmt_listar = sqlsrv_query($conexion, $sql_listar);

      if ($stmt_listar && sqlsrv_has_rows($stmt_listar)) {
          echo "<table>
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Área</th>
                      <th>Activo</th>
                      <th>Acción</th>
                      <th>Descargar</th>
                    </tr>
                  </thead>
                  <tbody>";

          while ($fila = sqlsrv_fetch_array($stmt_listar, SQLSRV_FETCH_ASSOC)) {
              $estado = $fila['Activo'] ? "Sí" : "No";
              $nuevaAccion = $fila['Activo'] ? "Desactivar" : "Activar";
              $nuevoValor = $fila['Activo'] ? 0 : 1;

              echo "<tr>
                      <td>{$fila['Nombre']}</td>
                      <td>{$fila['Linea']}</td>
                      <td>$estado</td>
                      <td>
                        <form method='post' style='display:inline'>
                          <input type='hidden' name='cambiar_id' value='{$fila['ID']}'>
                          <input type='hidden' name='nuevo_estado' value='$nuevoValor'>
                          <input type='submit' name='cambiar_estado' value='$nuevaAccion'>
                        </form>
                      </td>
                      <td>";

              if ($fila['Activo']) {
                  echo "descargar.php?id={$fila[Descargar</a>";
              } else {
                  echo "No disponible";
              }

              echo "</td></tr>";
          }

          echo "</tbody></table>";
      } else {
          echo "<p>No hay archivos registrados.</p>";
      }
      ?>
    </div>
  </section>

</body>
</html>
