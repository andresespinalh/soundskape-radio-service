'use strict'

angular.module('SoundskapeApp')

	.controller('InicioSesionController', ['$scope','$location','$http', function($scope, $location, $http, $sessionStorage){
	 	
	 	$scope.IniciarUsuario = function(){
	 	var user="";	
	 	var id_usuario="";
	 	$scope.msg=""; //mensaje de verificacion de contraseña

	 	$http.post("php/dbverificarusuario.php", {
		                                'namesurname':$scope.namesurname, //envio de nombre de usuario y contraseña para
		                                'password':$scope.password			//su verificacion	                                	                                
		                }).then(function successCallback(response) {  
		           
						
							              
						user = response.data.records; 
							
						
						if(typeof user !== "undefined"){ //si existe el usuario y contraseña 

							id_usuario = user[0].id_usuario;
							$location.path('/Principal').search({param: id_usuario}); //Redireccion al principal enviando el id user

						 }else{
						 	$scope.msg="Contraseña o usuario incorrecto";
						 }
								
						
						         
		         });
		                
		                
		 
		
	 	}

	


	 }]);
