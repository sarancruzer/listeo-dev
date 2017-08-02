app.controller('categoryController',function ($scope, $auth, $state, $http, $rootScope,$timeout) {

   $scope.master = {};

		$scope.totalPages   = 0;
	    $scope.currentPage  = 0;
		$scope.range = 0;
			
		$scope.q = "";

		$scope.init = function(page){
           
           var request = {
				method:"post",
				url:"/api/getCategory?page="+page,
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
					$scope.mError = "";
            }, function errorCallback(response) {
			   $scope.mError=response.data.error;
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

		$scope.submitMaster = function(form){
		if(form.masterForm.$valid){
			var request = {
				method:"POST",
				url:"/api/submitMasterCategory",
				data:{"info":$scope.master},
				headers : {'Content-Type' : 'application/json'},
			}
			$http(request).then(function successCallback(response) {
				var res = response.data.result;
				
	            $scope.mSuccess=res.msg;
				$scope.mError="";
				$scope.master = {};
				form.masterForm.$submitted=false;
				$(".mfp-close").click();
						//10 seconds delay
				$timeout( function(){
					$scope.mSuccess = false;
					$scope.mError=false;
				}, $rootScope.showTime );
		
				$scope.init(1);

			}, function errorCallback(response) {
				$scope.mError=response.data.error;
			    if(response.status == 404){
			    	$scope.mfError = response.statusText;
			    }
			});
		}
			
		}

		
		$scope.editMaster = function(data){
			
			$scope.master.id = data.id;
			$scope.master.name = data.name;
		
		}

		$scope.delModal = function(data){
			$scope.delId = data.id;
		}

		$scope.deleteMaster = function(){
			var request = {
				method:"POST",
				url:"/api/deleteMaster/"+$scope.delId,
				headers : {'Content-Type' : 'application/json'},
			}
			$http(request).then(function successCallback(response) {
				var res = response.data.result;
				
	            $scope.mSuccess=res;
				$scope.mError="";
								
				$timeout( function(){
					$scope.mSuccess = false;
					$scope.mError=false;
				}, $rootScope.showTime );
		
				$scope.init(1);

			}, function errorCallback(response) {
				$scope.mError=response.data.error;
			    if(response.status == 404){
			    	$scope.mfError = response.statusText;
			    }
			});
	
		}

		       

});