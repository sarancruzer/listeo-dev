app.controller('addListingController',function ($scope, $auth, $state, $http, $rootScope) {

    $scope.getMasterDetails = function(){
            var data = ["m_amenities","m_category","m_city","m_state","m_time","m_weekdays"]
            var request = {
                method:"POST",
                url:"/api/getMasterDetails",
                data:data,
                headers : {'Content-Type' : 'application/json'},
            };
            $http(request).then(function successCallback(response) {
                var res = response.data.result.info;
                $scope.amenitiesList=res.m_amenities;
                $scope.categoryList=res.m_category;
                $scope.cityList=res.m_city;
                $scope.stateList=res.m_state;
                $scope.timeList=res.m_time;
                $scope.weekdaysList=res.m_weekdays;

                console.log("---------  -------------");
                console.log(res);
               $scope.LError = "";
            }, function errorCallback(response) {
                $scope.LError=response.data.error;
                if(response.status == 404){
                    $scope.CPError = response.statusText;
                }
            });

        }

        $scope.getMasterDetails();

        $scope.addListing = function(form){
		if(form.validate()){
			var request = {
				method:"POST",
				url:"/api/addListing",
				data:{"info":$scope.listing},
				headers : {'Content-Type' : 'application/json'},
			}
			$http(request).then(function successCallback(response) {
				var res = response.data.result;
				
	            $scope.mSuccess=res.msg;
				$scope.mError="";
						//10 seconds delay
				$timeout( function(){
					$scope.LSuccess = false;
					$scope.LError=false;
				}, $rootScope.showTime );
		
				$scope.init(1);

			}, function errorCallback(response) {
				$scope.LError=response.data.error;
			    if(response.status == 404){
			    	$scope.mfError = response.statusText;
			    }
			});
		}
			
    }


        

});

app.directive('chosen', function($timeout) {

  var linker = function(scope, element, attr) {

    scope.$watch('categoryList', function() {
      $timeout(function() {
        element.trigger('chosen:updated');
      }, 0, false);
    }, true);

    $timeout(function() {
      element.chosen();
    }, 0, false);
  };

  return {
    restrict: 'A',
    link: linker
  };
});


