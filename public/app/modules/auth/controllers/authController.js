app.controller('authController',function ($scope, $auth, $state, $http, $rootScope,$timeout) {

    $scope.submitLogin = function (form) {
           
        
            var credentials = {
                email: $scope.user.email,
                password: $scope.user.password
            }


        if(form.loginForm.$valid){
            $auth.login(credentials).then(function(data) {

                $rootScope.user = data.data.details;
                $rootScope.curUser = data.data.details.name;
                $rootScope.userId = data.data.details.userid;
                $rootScope.userType = data.data.details.user_type;
                $rootScope.avatar = data.data.details.avatar;
                
                 localStorage.setItem('email',data.data.details.avatar);
                localStorage.setItem('username',data.data.details.name);
                localStorage.setItem('userId',data.data.details.id);
                localStorage.setItem('userType',data.data.details.user_type);
                localStorage.setItem('avatar',data.data.details.avatar);
                $rootScope.authenticated = true;

                form.loginForm.$submitted=false;
                $(".mfp-close").click();

                $timeout( function(){
					$scope.mSuccess = false;
					$scope.mError=false;
                }, $rootScope.showTime );
                
                $scope.user = data.data.details;
                var token = data.data.token;
                $rootScope.authenticated = true;
                $state.go('layout.profile',{});
                
            }, function(error) {
                $scope.loginError = true;
                $scope.loginErrorText = error.data.error;
            });        

        }

    }
        
   
    
    $scope.isActive = false;
  $scope.activeButton = function() {
    $scope.isActive = !$scope.isActive;
  }  

});