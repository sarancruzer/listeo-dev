<!doctype html>
<html ng-app="listeoApp">
    <head>
       
        <!-- Basic Page Needs
================================================== -->
<title>Listeo dev</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


<!-- CSS
================================================== -->
<link rel="stylesheet" href="assets/ui/css/style.css">
<link rel="stylesheet" href="assets/ui/css/colors/main.css" id="colors">
   
    </head>
    <body >

            <div ui-view></div>

    </body>


    
<!-- Scripts
================================================== -->
<script type="text/javascript" src="assets/ui/scripts/jquery-2.2.0.min.js"></script>
<script type="text/javascript" src="assets/ui/scripts/jpanelmenu.min.js"></script>
<script type="text/javascript" src="assets/ui/scripts/chosen.min.js"></script>
<script type="text/javascript" src="assets/ui/scripts/slick.min.js"></script>
<script type="text/javascript" src="assets/ui/scripts/rangeslider.min.js"></script>
<script type="text/javascript" src="assets/ui/scripts/magnific-popup.min.js"></script>
<script type="text/javascript" src="assets/ui/scripts/waypoints.min.js"></script>
<script type="text/javascript" src="assets/ui/scripts/counterup.min.js"></script>
<script type="text/javascript" src="assets/ui/scripts/jquery-ui.min.js"></script>
<script type="text/javascript" src="assets/ui/scripts/tooltips.min.js"></script>
<script type="text/javascript" src="assets/ui/scripts/custom.js"></script>



	<!-- jQuery -->
  
    
<script type="text/javascript" src="assets/js/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript" src="assets/js/jquery-validate/additional-methods.min.js"></script>



    <!-- Application Dependencies -->
    <script src="assets/lib/angular/angular.js"></script>
    <script src="assets/lib/angular-ui-router/release/angular-ui-router.js"></script>
    <script src="assets/lib/satellizer/dist/satellizer.js"></script>

	<script type="text/javascript" src="assets/js/jquery-validate/angular-validate.min.js"></script>


    <!-- Application Scripts -->
    <script src="app/app.js"></script>
    <script src="app/router.js"></script>
    <script src="app/modules/auth/controllers/authController.js"></script>
    <script src="app/modules/auth/controllers/logoutController.js"></script>

    <script src="app/modules/listing/controllers/addListingController.js"></script>
    <script src="app/modules/bookmarks/controllers/bookmarksController.js"></script>
    <script src="app/modules/listing/controllers/mylistingController.js"></script>
    
    <script src="app/modules/dashboard/controllers/dashboardController.js"></script>
    <script src="app/modules/message/controllers/messageController.js"></script>
    
    <script src="app/shared/commonController.js"></script>
    
    
    <script src="app/modules/masters/amenities/controllers/amenitiesController.js"></script>
    <script src="app/modules/masters/category/controllers/categoryController.js"></script>
    <script src="app/modules/masters/city/controllers/cityController.js"></script>
    <script src="app/modules/masters/state/controllers/stateController.js"></script>
    <script src="app/modules/masters/time/controllers/timeController.js"></script>
    <script src="app/modules/masters/weekdays/controllers/weekdaysController.js"></script>
   

        

</html>