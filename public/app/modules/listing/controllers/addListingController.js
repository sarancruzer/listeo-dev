app.controller('addListingController',function ($scope, $auth, $state, $http, $rootScope) {
console.log("success");
$scope.success = function () {
           alert('haiyooooo');
}


    $scope.getMasterDetails = function(){
            var data = ["individual_category","organisation_category","service_provider_category"]
            var request = {
                method:"POST",
                url:"/api/getMasterDetails",
                data:data,
                headers : {'Content-Type' : 'application/json'},
            };
            $http(request).then(function successCallback(response) {
                
                $scope.ind_details=response.data.result.info.individual_category;
                $scope.org_details=response.data.result.info.organisation_category;
                $scope.service_provider_details=response.data.result.info.service_provider_category;
                console.log("---------  -------------");
                console.log($scope.ind_details);
                $scope.company = {};
            }, function errorCallback(response) {
                $scope.SError=response.data.error;
                if(response.status == 404){
                    $scope.CPError = response.statusText;
                }
            });

        }

        $scope.getMasterDetails();
        

});