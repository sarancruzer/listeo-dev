app.controller('mylistingController',function ($scope, $auth, $state, $http, $rootScope) {
    
        $scope.totalPages   = 0;
	    $scope.currentPage  = 0;
		$scope.range = 0;
		$scope.q = "";

		$scope.init = function(page){
           var request = {
				method:"post",
				url:"/api/getListing?page="+page,
				data:{"q":$scope.q},
				headers : {'Content-Type' : 'application/json'},
			}
            $http(request).then(function successCallback(response) {
                   $scope.details = response.data.result.info.data;
					$scope.totalPages   = response.data.result.info.last_page;
				    $scope.currentPage  = response.data.result.info.current_page;
					// Pagination Range
				    var pages = [];
				    for(var i=1;i<=response.data.result.info.last_page;i++) {          
				      pages.push(i);
				    }
					$scope.range = pages;
					$scope.LError = "";
            }, function errorCallback(response) {
			   $scope.LError=response.data.error;
			   $scope.details = [];
			    if(response.status == 404){
			    	$scope.mfError = response.statusText;
			    }
            });

        }

		$scope.init(1);
		
		$scope.searchFilter = function(){
			console.log($scope.q);
			$scope.init(1);
		}

		$scope.delModal = function(data){
			$scope.delId = data.id;
		}

		$scope.deleteMaster = function(){
			var request = {
				method:"POST",
				url:"/api/deleteListing/"+$scope.delId,
				headers : {'Content-Type' : 'application/json'},
			}
			$http(request).then(function successCallback(response) {
				var res = response.data.result;
				$scope.LSuccess=res;
				$scope.LError="";
							
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

        
        
});