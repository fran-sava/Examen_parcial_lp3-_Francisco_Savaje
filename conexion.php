<?php
// conexion.php - Examen LP3 (MySQLi con WampServer)
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "examen_parcial_lp3";

$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conexion->connect_errno) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");

// (opcional mostrar ok)
// echo "Conexión exitosa";
