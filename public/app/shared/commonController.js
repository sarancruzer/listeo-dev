app.controller('commonController',function ($scope, $auth, $state, $http, $rootScope) {


    $scope.isActive = false;
  $scope.activeButton = function() {
    $scope.isActive = !$scope.isActive;
  }  

});