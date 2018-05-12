<?php 
include('dbconexion.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8"); 
$conexion = conectar(); //establece conexion con la base

$data = json_decode(file_get_contents("php://input"));

//Se recibe toda la data del formulario

$id_lista_reproduccion = $data->id_lista_reproduccion;
$direccionMP3="mp3/";





$sql=$conexion->query("SELECT b.id_cancion,b.titulo,b.duracion,b.direccion,d.nombre_artistico,e.genero FROM cancion_por_lista_reproduccion a, cancion b,artista_por_cancion c, artista d, genero e WHERE (a.id_lista_reproduccion = '$id_lista_reproduccion') AND (a.id_cancion=b.id_cancion AND a.id_cancion=c.id_cancion) AND (c.id_artista=d.id_artista) AND (e.id_genero=b.id_genero)");

$outp = "";
while($rs = $sql->fetch_array(MYSQLI_ASSOC)) { //Guarda en rs cada resultado de la fila 

    if ($outp != "") {$outp .= ",";}
    $rs["nombre_artistico"] = preg_replace("/[^a-zA-Z0-9_.'()]/", '', $rs["nombre_artistico"]);// Eliminacion de caracteres especiales 
    $rs["titulo"] = preg_replace("/[^a-zA-Z0-9_.'()]/", '', $rs["titulo"]);
    

    $outp .= '{"id_cancion":"'  . $rs["id_cancion"] . '",';
    $outp .= '"titulo":"'  . $rs["titulo"] . '",';
    $outp .= '"duracion":"'  .$rs["duracion"] . '",';
    $outp .= '"direccion":"'  . $direccionMP3. $rs["direccion"] . '",';
    $outp .= '"genero":"'  . $rs["genero"] . '",';
    $outp .= '"nombre_artistico":"'   . $rs["nombre_artistico"]    . '"}'; //Se convierte toda la data recibida en fila en formato json
}

$outp ='{"records":['.$outp.']}';//Todos los datos de la cancion se almacenan en records para su recibimiento en el javascript
echo $outp; //Muestra para el envio



$conexion->Close();//Cierre de la conexion

?>