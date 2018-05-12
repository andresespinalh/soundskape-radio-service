//Aqui se inicializan los modulos con los [] diciendo que modulos usara

//MODULO DE PRINCIPAL
angular.module('SoundskapeApp', ['ngResource','ui.router'])
	
	.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
		$stateProvider
	
			/*Relacionados a INICIO SESION*/
			.state('InicioSesion', {
				url:'/InicioSesion',
				templateUrl: 'views/InicioSesion.html',
				controller: 'InicioSesionController'
			})
            .state('Registrarse', {
                url: '/Registrarse',
                templateUrl: 'views/Registrarse.html',
                controller: 'RegistrarseController'
            })
                
			/*Relacionados a PAGINA PRINCIPAL*/
			.state('Principal', {
				url:'/Principal',
				templateUrl: 'views/Principal.html',
				controller: 'PrincipalController'
            })
          
            
            /*Ejemplo añidado
				.state('Principal.LugaresFiltrados', {
					url: '/LugaresFiltrados',
					templateUrl: 'views/Principal/Lugares/LugaresFiltrados.html'

                })
        */

	}]);