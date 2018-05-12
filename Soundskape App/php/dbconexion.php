<?php
  function conectar(){
	$conexion = new mysqli('localhost','root','','radio');
	
	if ($conexion->connect_errno) {
		 die("Connection failed: " . $conexion->connect_error);
	}
  
	return $conexion;
  }
?> 