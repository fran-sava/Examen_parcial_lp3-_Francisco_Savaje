<?php
// procesar.php – Examen LP3 (versión final corregida)
// Acciones: agregar, listar, modificar, eliminar datos
// Luego de cada acción, regresa al inicio automáticamente en 15 segundos

require 'conexion.php';

// Función: volver inmediatamente al inicio
function ir_inicio() {
  header("Location: index.html");
  exit;
}

// Función: volver al inicio luego de 15 segundos (para ver resultados)
function ir_inicio_15s() {
  echo '<meta http-equiv="refresh" content="15;url=index.html">';
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

// (A) AGREGAR (INSERT) – espera POST: nombre, mensaje, telefono
if ($action === 'agregar') {
  $nombre   = isset($_POST['nombre'])   ? trim($_POST['nombre'])   : '';
  $mensaje  = isset($_POST['mensaje'])  ? trim($_POST['mensaje'])  : '';
  $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';

  if ($nombre === '' || $mensaje === '' || $telefono === '') {
    ir_inicio();
  }

  $stmt = $conexion->prepare("INSERT INTO contactos (nombre, mensaje, telefono) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $nombre, $mensaje, $telefono);
  $stmt->execute();
  $stmt->close();

  ir_inicio();
}

// (B) LISTAR (SELECT) – muestra y vuelve al inicio en 15s
if ($action === 'listar') {
  $res = $conexion->query("SELECT id, nombre, mensaje, telefono, creado FROM contactos ORDER BY id DESC");

  echo "<!doctype html><meta charset='utf-8'><title>Listado</title>";
  echo "<h2>Listado de contactos</h2>";
  echo "<table border='1' cellpadding='6' cellspacing='0'>";
  echo "<tr><th>ID</th><th>Nombre</th><th>Mensaje</th><th>Teléfono</th><th>Creado</th><th>Acciones</th></tr>";

  while ($f = $res->fetch_assoc()) {
    $id = (int)$f['id'];
    echo "<tr>";
    echo "<td>{$id}</td>";
    echo "<td>" . htmlspecialchars($f['nombre']) . "</td>";
    echo "<td>" . htmlspecialchars($f['mensaje']) . "</td>";
    echo "<td>" . htmlspecialchars($f['telefono']) . "</td>";
    echo "<td>{$f['creado']}</td>";
    echo "<td>
            <a href='procesar.php?action=modificar&id={$id}'>Modificar</a> |
            <a href='procesar.php?action=eliminar&id={$id}' onclick='return confirm(\"¿Eliminar #{$id}?\")'>Eliminar</a>
          </td>";
    echo "</tr>";
  }
  echo "</table>";
  echo "<p>Volviendo al inicio en 15 segundos…</p>";

  ir_inicio_15s();
  exit;
}

// (C) MODIFICAR (UPDATE)
//   GET: muestra formulario simple
//   POST: guarda cambios y vuelve al inicio
if ($action === 'modificar') {
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($id <= 0) ir_inicio();

    $stmt = $conexion->prepare("SELECT nombre, mensaje, telefono FROM contactos WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nombre, $mensaje, $telefono);

    if ($stmt->fetch()) {
      echo "<!doctype html><meta charset='utf-8'><title>Modificar</title>";
      echo "<h2>Modificar contacto #{$id}</h2>";
      echo "<form method='post' action='procesar.php?action=modificar'>";
      echo "<input type='hidden' name='id' value='{$id}'>";
      echo "Nombre: <input type='text' name='nombre' value='" . htmlspecialchars($nombre, ENT_QUOTES) . "' required><br><br>";
      echo "Mensaje: <input type='text' name='mensaje' value='" . htmlspecialchars($mensaje, ENT_QUOTES) . "' required><br><br>";
      echo "Teléfono: <input type='text' name='telefono' value='" . htmlspecialchars($telefono, ENT_QUOTES) . "' required><br><br>";
      echo "<button type='submit'>Guardar</button>";
      echo "</form>";
      $stmt->close();
      exit;
    } else {
      $stmt->close();
      ir_inicio();
    }
  } else {
    // POST: guardar cambios
    $id       = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $nombre   = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $mensaje  = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';

    if ($id<=0 || $nombre==='' || $mensaje==='' || $telefono==='') ir_inicio();

    $stmt = $conexion->prepare("UPDATE contactos SET nombre=?, mensaje=?, telefono=? WHERE id=?");
    $stmt->bind_param("sssi", $nombre, $mensaje, $telefono, $id);
    $stmt->execute();
    $stmt->close();

    ir_inicio();
  }
}

// (D) ELIMINAR (DELETE) – por id en GET
if ($action === 'eliminar') {
  $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
  if ($id > 0) {
    $stmt = $conexion->prepare("DELETE FROM contactos WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
  }
  ir_inicio();
}

// Sin acción conocida → inicio
ir_inicio();
?>
