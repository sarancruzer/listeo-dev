app.controller('addListingController',function ($scope, $auth, $state, $http, $rootScope) {
console.log("success");
$scope.success = function () {
           alert('haiyooooo');
}


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
               
            }, function errorCallback(response) {
                $scope.SError=response.data.error;
                if(response.status == 404){
                    $scope.CPError = response.statusText;
                }
            });

        }

        $scope.getMasterDetails();
        

});