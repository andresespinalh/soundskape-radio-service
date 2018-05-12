<?php 
include('dbconexion.php');


$conexion = conectar();
$data = json_decode(file_get_contents("php://input"));


//Recibimos datos del inicio de sesion
$namesurname = utf8_decode($data->namesurname);
$password = utf8_decode($data->password);


$result = $conexion->query( "SELECT * FROM usuario WHERE alias='$namesurname'"); //Recibe datos del usuario segun pass ingresada

while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
	$realpassword=$rs['contrasenia']; 	//Obtencion de los datos del usuario
	$id_usuario=$rs['id_usuario'];
}

$realpassword = base64_decode($realpassword); //Decodifica la contraseña obtenida de la base de datos



if($realpassword==$password){  //Si la contraseña ingresada en el inicio de sesion concuerda con la contraseña de la base se procede a 	
								//enviar los datos  
	$outp="";
 $outp .= '{"id_usuario":"'   . $id_usuario        . '"}';

 $outp =utf8_decode('{"records":['.$outp.']}');


echo $outp;

}



?>