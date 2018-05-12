<?php 
include('dbconexion.php'); 


$conexion = conectar(); //establece conexion con la base

$data = json_decode(file_get_contents("php://input"));

//Se recibe toda la data del formulario
$listname =utf8_decode( $data->listname);
$typelist = utf8_decode($data->typelist);
$idusuario = utf8_decode($data->idusuario);
$now = date('Y-m-d'); //Fecha de hoy



$sql_idtipo = $conexion->query("SELECT id_tipo_lista_reproduccion FROM tipo_lista_reproduccion WHERE tipo_lista_reproduccion='$typelist'");

$row_idtipo = mysqli_fetch_array($sql_idtipo)  or die(mysqli_error($conexion));
$idtipo=$row_idtipo[0];


$conexion->query("INSERT INTO lista_reproduccion(nombre, fecha_creacion, id_usuario, id_tipo_lista_reproduccion) VALUES ('$listname','$now','$idusuario','$idtipo')");


$conexion->Close();//Cierre de la conexion

?>