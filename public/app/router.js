
app.config(function($stateProvider, $urlRouterProvider, $authProvider) {
            // Satellizer configuration that specifies which API
            // route the JWT should be retrieved from
            $authProvider.loginUrl = '/api/authenticate';
            // Redirect to the auth state if any other states
            // are requested other than users
            $urlRouterProvider.otherwise('/auth');
              $stateProvider
                .state('layout', {
                    templateUrl: '/app/shared/template.html',
                })
                .state('adminLayout', {
                    templateUrl: '/app/shared/adminTemplate.html',
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
               .state('adminLayout.addListing',{
                  url : '/addListing',
                  templateUrl:'/app/modules/listing/views/_addListing.html',
                  controller : 'addListingController as addListing'
                })
                .state('adminLayout.message',{
                  url : '/message',
                  templateUrl : '/app/modules/message/views/_message.html',
                  controller : 'messageController as message',
                  pageTitile : 'Message'
                })                
                .state('adminLayout.mylisting',{
                  url : '/mylisting',
                  templateUrl : '/app/modules/listing/views/_myListing.html',
                  controller: 'mylistingController as mylisting',
                  pageTitle : 'My Listing'
                })  
                   .state('adminLayout.reviews',{
                  url : '/reviews',
                  templateUrl : '/app/modules/reviews/views/_reviews.html',
                  controller: 'reviewsController as reviews',
                  pageTitle : 'My Listing'
                })                
                .state('adminLayout.bookmarks',{
                  url : '/bookmarks',
                  templateUrl : '/app/modules/bookmarks/views/_bookmarks.html',
                  controller: 'bookmarksController as bookmarks',
                  pageTitle : 'bookmarks'
                }) 
                .state('adminLayout.myprofile',{
                  url : '/myprofile',
                  templateUrl : '/app/modules/myprofile/views/_myprofile.html',
                  controller: 'myprofileController as myprofile',
                  pageTitle : 'myprofile'
                })
                .state('adminLayout.dashboard',{
                  url : '/dashboard',
                  templateUrl : '/app/modules/dashboard/views/_dashboard.html',
                  controller: 'dashboardController as dashboard',
                  pageTitle : 'dashboard'
                })               
                 .state('layout.supplierEdit',{
                  url:'/supplierEdit/:id',
                  templateUrl:'/app/modules/supplier/views/_supplierEdit.html',
                  controller:'supplierEditController as supplierEdit',
                  pageTitle:'Edit Supplier'
                });
                

        });

app.run(['$rootScope', '$location','$auth','$state', function ($rootScope, $location, $auth, $state, $templateCache) {

     $rootScope.$on('$stateChangeSuccess',function(event, toState, toParams, fromState, fromParams){
        $rootScope.pageTitle = toState.pageTitle;
        $rootScope.url = toState.url;
  });

    $rootScope.$on( "$locationChangeStart", function(event, next, current) {
      if (!$auth.isAuthenticated()) {
        if($location.path() == "/auth"){
           $location.path("/auth");
        }       
        $rootScope.authenticated = false;
        $rootScope.userType = "admin";
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


  $rootScope.userType = "admin";  
  $rootScope.userType = localStorage.getItem('userType');
  $rootScope.userId = localStorage.getItem('userId');
  $rootScope.usename = localStorage.getItem('usename');
  $rootScope.userTypeId = localStorage.getItem('userTypeId');
  $rootScope.paginate = localStorage.getItem('paginate');
  $rootScope.avatar = localStorage.getItem('avatar');

}]);