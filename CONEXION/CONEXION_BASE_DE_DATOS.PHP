<?php

$usuario="root";
$contrasena="";
$servidor="localhost";
$base="tienda de ropa";
$conexion=mysqli_connect($servidor,$usuario,$contrasena)or die("Error de conexion");
$db=mysqli_select_db($conexion,$base)or die("Error de base de datos");



?>