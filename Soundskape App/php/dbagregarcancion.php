<?php 
include('dbconexion.php'); 
$conexion = conectar(); //establece conexion con la base

$data = json_decode(file_get_contents("php://input"));

//Se recibe toda la data del formulario

$id_cancion = $data->id_cancion;
$lista_reproduccion = utf8_decode($data->lista_reproduccion);




$sql=$conexion->query("SELECT id_lista_reproduccion FROM lista_reproduccion WHERE nombre='$lista_reproduccion'");

$row = mysqli_fetch_array($sql)  or die(mysqli_error($conexion));
$idlista=$row[0];


$conexion->query("INSERT INTO cancion_por_lista_reproduccion(id_cancion, id_lista_reproduccion) VALUES ('$id_cancion','$idlista')");





$conexion->Close();//Cierre de la conexion

?>