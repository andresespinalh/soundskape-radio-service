'use strict'
angular.module('SoundskapeApp')
	
	.controller('RegistrarseController', ['$scope','$location','$http', function($scope, $location, $http){
	 				              
				$http.get("php/dbobtenerciudad.php")
					 .then(function (response) {
					 $scope.cities = response.data.records;
					 	
					 }); //obtencion de los nombres de las ciudades
				
				$scope.insertuser=function(){
				
				var pass = document.getElementById('pass');

				if(($scope.password==$scope.confirm)&&$scope.terms &&(pass.value.length>=6)){ //Verificacion de la contraseña
					 	$http.post("php/dbinsertarusuario.php", { //envio de los datos del formulario al servidor
		                                'namesurname':$scope.namesurname,
		                                'email':$scope.email,
		                                'password':$scope.password,
		                                'city' :$scope.city,
		                                'borndate':$scope.borndate,
		                                'firstname':$scope.firstname,
		                                'secondname':$scope.secondname,
		                                'firstlastname':$scope.firstlastname,
		                                'secondlastname':$scope.secondlastname		                                	                                
		                }).then(function successCallback(response) {  
		           			  
						$location.path('/Principal');
		         
		         });
		          }else{ if(!$scope.terms){$scope.messageconfirm='Verificar terminos y condiciones';}else{$scope.messageconfirm='Confirmar Contraseña';}}
          }
          
				

          
	}]);
