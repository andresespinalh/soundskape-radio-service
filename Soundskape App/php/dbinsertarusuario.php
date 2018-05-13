<?php 
include('dbconexion.php'); 
$conexion = conectar(); //establece conexion con la base

$data = json_decode(file_get_contents("php://input"));

//Se recibe toda la data del formulario
$namesurname = utf8_decode($data->namesurname);
$password = utf8_decode($data->password);
$email = utf8_decode($data->email);
$borndate = $data->borndate;
$city = utf8_decode($data->city);
$firstname = utf8_decode($data->firstname);
$secondname = utf8_decode($data->secondname);
$firstlastname = utf8_decode($data->firstlastname);
$secondlastname = utf8_decode($data->secondlastname);
$password=base64_encode($password); //Encriptacion de la contraseña
$now = date('Y-m-d'); //Fecha de hoy


//Insercion en la tabla persona
$conexion->query( "INSERT INTO persona (primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,correo_electronico,fecha_nacimiento,id_ciudad
)VALUES (				'$firstname', 
						'$secondname', 
						'$firstlastname', 
						'$secondlastname',
						'$email',
						'$borndate',
						(select c.id_ciudad
						 from ciudad c 
						 where c.ciudad='$city')
);");


$conexion = conectar();//reinicia la conexión

//obtencion del id persona recien insertado
$sql_idpersona = $conexion->query('SELECT id_persona FROM persona ORDER BY id_persona DESC LIMIT 1');


$row_id_persona = mysqli_fetch_array($sql_idpersona)  or die(mysqli_error());

$personid=$row_id_persona[0];


//obtencion del tipo de usuario
$sql_id_tipo= $conexion->query('SELECT id_tipo_usuario FROM tipo_usuario ORDER BY id_tipo_usuario DESC LIMIT 1');


$row_id_tipo = mysqli_fetch_array($sql_id_tipo)  or die(mysqli_error());

$id_tipo=$row_id_tipo[0];

//Insercion del usuario
$conexion->query("INSERT INTO usuario( id_usuario,alias,contrasenia, fecha_ingreso, id_tipo_usuario, id_persona) VALUES ('$namesurname','$namesurname','$password','$now','$id_tipo','$personid')");

$conexion->Close();//Cierre de la conexion

?>
