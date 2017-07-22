
app.config(function($stateProvider, $urlRouterProvider, $authProvider) {
            // Satellizer configuration that specifies which API
            // route the JWT should be retrieved from
            $authProvider.loginUrl = '/api/authenticate';
            // Redirect to the auth state if any other states
            // are requested other than users
            $urlRouterProvider.otherwise('/auth');
            $stateProvider
            .state('layout', {
                    templateUrl: '/app/modules/shared/template.html',
                })
                .state('auth', {
                    url: '/auth',
                    templateUrl: '/app/modules/auth/views/_landingPage.html',
                    controller: 'authController as auth'
                })
                .state('logout',{
                    url:'/logout',
                    controller:'logoutController as logout',
                })
               
                .state('layout.profile',{
                  url : '/profile',
                  templateUrl:'/app/modules/profile/views/_profile.html',
                  controller : 'profileController as profile'
                })
                .state('layout.supplierList',{
                  url : '/supplierList',
                  templateUrl : '/app/modules/supplier/views/_supplierList.html',
                  controller : 'manageSupplierController as manageSupplier',
                  pageTitile : 'Suppliers'
                })
                .state('layout.supplierAdd',{
                  url : '/supplierAdd',
                  templateUrl : '/app/modules/supplier/views/_supplierAdd.html',
                  controller: 'supplierAddController as addSupplier',
                  pageTitle : 'Add Supplier'
                })
                .state('layout.supplierEdit',{
                  url:'/supplierEdit/:id',
                  templateUrl:'/app/modules/supplier/views/_supplierEdit.html',
                  controller:'supplierEditController as supplierEdit',
                  pageTitle:'Edit Supplier'
                })
                

        });

app.run(['$rootScope', '$location','$auth','$state', function ($rootScope, $location, $auth, $state, $templateCache) {

     $rootScope.$on('$stateChangeSuccess',function(event, toState, toParams, fromState, fromParams){
        $rootScope.pageTitle = toState.pageTitle;
        $rootScope.url = toState.url;
  });

    $rootScope.$on( "$locationChangeStart", function(event, next, current) {
      if (!$auth.isAuthenticated()) {
        if($location.path() != "/auth"){
           $location.path("/auth");
        }       
        $rootScope.authenticated = false;
      }
      else
      { 
        $rootScope.authenticated = true;
        $rootScope.userId = localStorage.getItem('userId');
        $rootScope.usename = localStorage.getItem('usename');
        
        if($location.path() == "/auth" || $location.path() == "/")
        {
            if ($auth.isAuthenticated()) {          
                $location.path("/profile");
              }
        }
      }
  });



  $rootScope.userType = localStorage.getItem('userType');
  $rootScope.userId = localStorage.getItem('userId');
  $rootScope.usename = localStorage.getItem('usename');
  $rootScope.userTypeId = localStorage.getItem('userTypeId');
  $rootScope.paginate = localStorage.getItem('paginate');
  $rootScope.avatar = localStorage.getItem('avatar');

}]);