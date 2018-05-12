(function(angular) {
  'use strict';
  angular.module('app', ['ngCookies'])
  .controller('appController', ['$cookies', '$timeout', function($cookies, $timeout) {
    
    var vm = this;
    
    vm.message = '';
    
    vm.getCookies = getCookies;
    vm.setCookies = setCookies;
    vm.clearCookies = clearCookies;
    
    getCookies();
    
    function getCookies()
    {
      vm.var1 = $cookies.get('var1');
      vm.var2 = $cookies.get('var2');
    }
    
    function setCookies()
    {
      $cookies.put('var1', vm.var1);
      $cookies.put('var2', vm.var2);
      
      if (vm.var1 && vm.var2)
        showMessage('Cookies set successefully!');
      else
        showMessage('Please enter some value.');
    }
    
    function clearCookies()
    {
      $cookies.remove('var1');
      $cookies.remove('var2');
      
      getCookies();
      
      showMessage('Cookies cleared successefully!');
    }
    
    function showMessage(msg)
    {
      vm.message = msg;
      $timeout(function() {
        vm.message = '';
      }, 2000);
    }
    
  }]);
})(window.angular);