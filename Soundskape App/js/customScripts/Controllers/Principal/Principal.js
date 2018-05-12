'use strict'

angular.module('SoundskapeApp')

	.controller('PrincipalController', ['$scope','$location','$http', function($scope, $location, $http){
        $scope.viewlistageneros=true; //vista de la lista de generos
        $scope.viewcanciones=false; //vista de las canciones por genero
        $scope.visitante="Visitante"; // vista del label visitante
        


        var urlparam = $location.search(); //obtencion de los datos del inicio de sesion
        var idusuario;
        var id_lista;
        var id_lista_a_borrar;
        var id_lista_a_editar;
        var id_cancion_a_agregar;
        $scope.Escuchando="";
        $scope.usuario="";//declaracion de usuario
        $scope.listarep="";
        $scope.tipolista="";
        $scope.lista_a_editar="";
        $scope.Nombre_lista="";

        if(typeof urlparam.param === "undefined"){ //si no obtiene nada del inicio de sesion muestra los botones de registro y login
            $scope.MostrarBotones=true;
            $scope.MostrarPerfil=false; //vista del perfil
            
        }else{
            $scope.visitante="";
            idusuario=urlparam.param; //recibe el id usuario 
            $scope.MostrarBotones=false;
            $scope.MostrarPerfil=true;

            //Obtiene data del usuario
            $http.post("php/dbobtenerusuario.php", {
                                        'id_usuario':idusuario          //envio del id usuario para obtener todos sus datos                                                      
                        }).then(function successCallback(response) {  
                                      
                        $scope.usuario = response.data.records; 
                                
                 });

           ActualizarListasRep();

            $http.get("php/dbobtenertipolista.php")
                     .then(function (response) {$scope.tipolista = response.data.records;});

                                       

        }



        $http.get("php/dbcantidadgenero.php")
                     .then(function (response) {$scope.names = response.data.records;});  //obtiene los generos por cantidad de canciones      


        $scope.abrirgenero = function(id_genero,genero){ 
            $scope.viewlistageneros=false; //desaparece la vista de lista de generos
             $scope.Cancionesporlista=false;

            $scope.viewcanciones=true; //muestra la vista de canciones segun el genero seleccionado

            $scope.id_genero=id_genero; //obtiene el id genero para recibir canciones por genero
            $scope.genero=genero;

            $http.post("php/dbobtenercanciones.php", {
                                        'id_genero':id_genero                                                                        
                        }).then(function successCallback(response) {  
                   
                    $scope.songs = response.data.records;                  

                 
                 });

        }
        $scope.abrircanciones = function(){
            $scope.viewcanciones=false;
            $scope.Cancionesporlista=false;

            $scope.viewlistageneros=true; //muestra el view de lista por genero
              

        }

        $scope.stopsong = function(){ //detiene la cancion del modal
            $scope.Escuchando="";
            $('#EscuchandoIcon').removeClass('animated infinite pulse');
           var sound = document.getElementById("audio");
            sound.pause();
            sound.currentTime = 0;
           
            $scope.EscuchandoIcon="";
           
     /*       sound.src =""; 
            sound.load();*/
        }
        $scope.stopsong2 = function(){ //detiene la cancion del modal de lista de reproduccion
            $scope.Escuchando="";
           $('#EscuchandoIcon').removeClass('animated infinite pulse');
           var sound = document.getElementById("audio2");
            sound.pause();
            sound.currentTime = 0;
            
            
     /*       sound.src =""; 
            sound.load();*/
        }
        $scope.playsong = function(titulo,nombre_artistico,duracion,direccion){ //obtiene datos y reproduce la cancion del modal
           $('#EscuchandoIcon').addClass('animated infinite pulse');  
           var sound = document.getElementById("audio");
           $scope.titulo=titulo;
           $scope.nombre_artistico=nombre_artistico;
           $scope.duracion=duracion;
           
           sound.src=direccion;
           sound.play();

           $scope.Escuchando="Escuchando: "+titulo;
          


            sound.currentTime = 0;
        }
        $scope.playsong2 = function(titulo,nombre_artistico,duracion,direccion){ //obtiene datos y reproduce la cancion del modal de listas de reproduccion
           $('#EscuchandoIcon').addClass('animated infinite pulse');
           var sound = document.getElementById("audio2");
           $scope.titulo=titulo;
           $scope.nombre_artistico=nombre_artistico;
           $scope.duracion=duracion;
           
           sound.src=direccion;
           sound.play();
           $scope.Escuchando="Escuchando: "+titulo;
           

            sound.currentTime = 0;
        }
        $scope.CerrarSesion = function(){ //cierra la sesion y elimina todos los datos
               
               
               $scope.usuario="";
               $scope.visitante="Visitante";
               $scope.MostrarBotones=true;
               $scope.MostrarPerfil=false;
               $scope.viewcanciones=false; //vista de las canciones por genero
               $scope.Cancionesporlista=false;
               $scope.viewlistageneros=true; //vista de la lista de generos
              


               $location.path('/Principal');
               $location.search({});
           
              
              
        }
        $scope.CrearLista = function(){

            if(($scope.listname!="") || ($scope.typelist!="")){

             $http.post("php/dbcrearlistarep.php", {
                                        'listname':$scope.listname, 
                                        'typelist':$scope.typelist,
                                        'idusuario':idusuario                                                          
                        }).then(function successCallback(response) {                                       
                      
                        ActualizarListasRep(); 
                        $scope.listname="";
                        $scope.typelist="";      
            });  

            }
            


        }

        $scope.MostrarBorrarLista = function(nombre,id_lista_reproduccion){

            $scope.lista_a_borrar=nombre;
            id_lista_a_borrar=id_lista_reproduccion;

          
            

        }

        $scope.BorrarLista = function(){
              $http.post("php/dbborrarlistarep.php", {
                                        'id_lista_reproduccion':id_lista_a_borrar                                               
                        }).then(function successCallback(response) {  
                      ActualizarListasRep();
                      id_lista_a_borrar="";
                        
                 });
                $scope.viewlistageneros=true; //vista de la lista de generos
                $scope.viewcanciones=false; //vista de las canciones por genero
                $scope.Cancionesporlista=false;


        }

        function ActualizarListasRep() {
           $http.post("php/dbobtenerlistarep.php", {
                                        'id_usuario':idusuario          //envio del id usuario para obtener listas Reproduccion                                                      
                        }).then(function successCallback(response) {  
                                      
                        $scope.listarep = response.data.records; 
                                
                 });            
        }

        

        $scope.MostrarEditarLista = function(nombre,id_lista_reproduccion){
            $scope.lista_a_editar=nombre;
            id_lista_a_editar=id_lista_reproduccion;



        }

        $scope.EditarLista = function(){

             $http.post("php/dbeditarlistarep.php", {
                                        'id_lista_reproduccion':id_lista_a_editar,
                                        'nombre': $scope.nombre,
                                        'tipo': $scope.typelist
                        }).then(function successCallback(response) {  
                      ActualizarListasRep();
                      id_lista_a_editar="";
                        
                 });

        }

        $scope.MostrarAgregarCancion = function(id_cancion){
            id_cancion_a_agregar=id_cancion;
        }

        $scope.AgregarListaCancion = function(){
              $http.post("php/dbagregarcancion.php", {
                                        'id_cancion':id_cancion_a_agregar,
                                        'lista_reproduccion': $scope.list
                        }).then(function successCallback(response) {  
                      ActualizarListasRep();
                        id_cancion_a_agregar="";
                        
                 });
        }

        $scope.MostrarCancionesporLista = function (id_lista_reproduccion,nombre){
             $scope.viewlistageneros=false; //vista de la lista de generos
             $scope.viewcanciones=false; //vista de las canciones por genero
             $scope.Cancionesporlista=true;
             $scope.Nombre_lista=nombre;
             id_lista=id_lista_reproduccion;
              $http.post("php/dbmostrarlistacancion.php", {
                                        'id_lista_reproduccion':id_lista_reproduccion
                        }).then(function successCallback(response) {  
                      $scope.songslist = response.data.records;
                        
                 });

        }

        $scope.eliminarcancion = function(id_cancion){

            $http.post("php/dbeliminarcancion.php", {
                                        'id_cancion':id_cancion
                        }).then(function successCallback(response) {  
                
                  ActualizarCancionesporLista();
                 });

                           

        }

        function ActualizarCancionesporLista(){

            $http.post("php/dbmostrarlistacancion.php", {
                                        'id_lista_reproduccion':id_lista
                        }).then(function successCallback(response) {  
                      $scope.songslist = response.data.records;
                        
                 });
          
        }






















        $(function () {
            //Widgets count
            $('.count-to').countTo();
        
            //Sales count to
            $('.sales-count-to').countTo({
                formatter: function (value, options) {
                    return '$' + value.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, ' ').replace('.', ',');
                }
            });
        
            initRealTimeChart();
            initDonutChart();
            initSparkline();
        });
        
        var realtime = 'on';
        function initRealTimeChart() {
            //Real time ==========================================================================================
            var plot = $.plot('#real_time_chart', [getRandomData()], {
                series: {
                    shadowSize: 0,
                    color: 'rgb(0, 188, 212)'
                },
                grid: {
                    borderColor: '#f3f3f3',
                    borderWidth: 1,
                    tickColor: '#f3f3f3'
                },
                lines: {
                    fill: true
                },
                yaxis: {
                    min: 0,
                    max: 100
                },
                xaxis: {
                    min: 0,
                    max: 100
                }
            });
        
            function updateRealTime() {
                plot.setData([getRandomData()]);
                plot.draw();
        
                var timeout;
                if (realtime === 'on') {
                    timeout = setTimeout(updateRealTime, 320);
                } else {
                    clearTimeout(timeout);
                }
            }
        
            updateRealTime();
        
            $('#realtime').on('change', function () {
                realtime = this.checked ? 'on' : 'off';
                updateRealTime();
            });
            //====================================================================================================
        }
        
        function initSparkline() {
            $(".sparkline").each(function () {
                var $this = $(this);
                $this.sparkline('html', $this.data());
            });
        }
        
        function initDonutChart() {
            Morris.Donut({
                element: 'donut_chart',
                data: [{
                    label: 'Chrome',
                    value: 37
                }, {
                    label: 'Firefox',
                    value: 30
                }, {
                    label: 'Safari',
                    value: 18
                }, {
                    label: 'Opera',
                    value: 12
                },
                {
                    label: 'Other',
                    value: 3
                }],
                colors: ['rgb(233, 30, 99)', 'rgb(0, 188, 212)', 'rgb(255, 152, 0)', 'rgb(0, 150, 136)', 'rgb(96, 125, 139)'],
                formatter: function (y) {
                    return y + '%'
                }
            });
        }
        
        var data = [], totalPoints = 110;
        function getRandomData() {
            if (data.length > 0) data = data.slice(1);
        
            while (data.length < totalPoints) {
                var prev = data.length > 0 ? data[data.length - 1] : 50, y = prev + Math.random() * 10 - 5;
                if (y < 0) { y = 0; } else if (y > 100) { y = 100; }
        
                data.push(y);
            }
        
            var res = [];
            for (var i = 0; i < data.length; ++i) {
                res.push([i, data[i]]);
            }
        
            return res;
        }	 

	}]);
