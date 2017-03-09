<script>
//create function for  for Excel report 
   function fnExcelReport() { 
       //created a variable named tab_text where  
     var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">'; 
     //row and columns arrangements 
     tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'; 
     tab_text = tab_text + '<x:Name>Excel Sheet</x:Name>'; 
  
     tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>'; 
     tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>'; 
  
     tab_text = tab_text + "<table border='100px'>"; 
     //id is given which calls the html table 
     tab_text = tab_text + $('#bloodbanks_summary').html(); 
     tab_text = tab_text + '</table></body></html>'; 
     var data_type = 'data:application/vnd.ms-excel'; 
     $('#test').attr('href', data_type + ', ' + encodeURIComponent(tab_text)); 
     //downloaded excel sheet name is given here 
     $('#test').attr('download', '<?php echo "bloodbank";?>_summary_report.xls');
 }
</script>

<style>

.chart div {
  font: 10px sans-serif;
  background-color: steelblue;
  text-align: right;
  padding: 3px;
  margin: 1px;
  color: white;
}

</style>

<div ng-app="dashboardHome"  id="page-wrapper">
            <div class="row">
                <div class="col-lg-4 col-md-6" align="center">
                    <img src="<?php echo base_url();?>assets/images/telangana_state_logo.png" width="100px" height="100px;" alt="Yousee logo"/>
                </div>
                <div class="col-lg-4 col-md-6" align="center">
                    <span>&nbsp;</span>
                </div>
                <div class="col-lg-4 col-md-6" align="center">
                    <a href="http://yousee.in/" target="_blank"><img src="<?php echo base_url();?>assets/images/uc-logo.png" width="100px" height="100px;" alt="Yousee logo"/></a>                     
                </div>
            </div>
            <!-- /.row -->
            <div class="row">&nbsp;</div>
           <!-- <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-2">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-10 text-right">
                                    <div><p><small>Yesterday:</small>&nbsp; <span class="huge"></span></p></div>    
                                    <div><p><small>This Month:</small>&nbsp;</p></div>                                    
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">OP Summary</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-2">
                                    <i class="fa fa-medkit fa-5x"></i>
                                </div>
                                <div class="col-xs-10 text-right">
                                    <div><p><small>Current:</small> <span class="huge"></span></p></div>  
                                    <div><p><small> </small>&nbsp;</p></div>
                                </div>
                            </div>
                        </div>
                        <a href="http://apbloodcell.in/welcome/inventory_detailed" target="_blank">
                            <div class="panel-footer">
                                <span class="pull-left">IP Summary</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user-plus fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">                                    
                                    <div><p><small>Thirty Day:</small> <span class="huge"></span></p></div>
                                    <div><p>&nbsp;<small></small></p></div>                                   
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Diagnostics</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-trash fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div><p><small>Next 3 Days: </small><span class="huge"></span></p></div>
                                    <div><p><small>Today: </small></p></div>                                    
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">BloodBank: </span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div> -->
            <!-- /.row -->
            <div class="row">
                <!-- /.col-lg-8 -->
                <div class="col-lg-6" ng-controller="DashboardCtrl as dashboardCtrl">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i>OP/IP registrations today: <span><font face="Modern, Arial" size="4">{{ dashboardCtrl.today | date: 'dd-MMM-yyyy, hh:mm:ss a' }}</font></span>
                        <!--    <a href="http://apbloodcell.in/welcome/bloodbanks_status" target="_blank"><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span></a> -->
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive" style="height: 500px; overflow-y: scroll;">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th><font face="Modern, Arial" size="4">#</font></th>
                                            <th><font face="Modern, Arial" size="4">Hospital</font></th>
                                            <th colspan="3" class="text-center"><font face="Modern, Arial" size="4">OP</font></th>
                                            <th class="text-right"><font face="Modern, Arial" size="4">IP</font></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th class="text-right"><font face="Modern, Arial" size="3">New</font></th>
                                            <th class="text-right"><font face="Modern, Arial" size="3">Repeat</font></th>
                                            <th class="text-right"><font face="Modern, Arial" size="3">OP Total</font></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td><font face="Modern, Arial" size="4">Total</font></td>
                                            <td class="text-right"><font face="Modern, Arial" size="4">{{ dashboardCtrl.totalNewOP ? dashboardCtrl.totalNewOP : 0 }}</font></td>
                                            <td class="text-right"><font face="Modern, Arial" size="4">{{ dashboardCtrl.totalRepeatOP ? dashboardCtrl.totalRepeatOP : 0 }}</font></td>
                                            <td class="text-right"><font face="Modern, Arial" size="4">{{ dashboardCtrl.totalOP }}</font></td>
                                            <td class="text-right"><font face="Modern, Arial" size="4">{{ dashboardCtrl.totalIP }}</font></td>
                                        </tr>
                                        <tr ng-repeat="opIpSummary in dashboardCtrl.opIpSummary track by $index">
                                            <td class="text-right"><font face="Modern, Arial" size="4">{{ $index + 1 }}</font></td>
                                            <td><font face="Modern, Arial" size="4">{{ opIpSummary.hospital_short_name }}</font></td>
                                            <td class="text-right"><font face="Modern, Arial" size="4">{{ opIpSummary.total_op_registrations_short_period - opIpSummary.repeat_visits_op ? opIpSummary.total_op_registrations_short_period - opIpSummary.repeat_visits_op : 0 }}</font></td>
                                            <td class="text-right"><font face="Modern, Arial" size="4">{{ opIpSummary.repeat_visits_op ? opIpSummary.repeat_visits_op : 0 }}</font></td>
                                            <td class="text-right"><font face="Modern, Arial" size="4">{{ opIpSummary.total_op_registrations_short_period ? opIpSummary.total_op_registrations_short_period : 0 }}</font></td>
                                            <td class="text-right"><font face="Modern, Arial" size="4">{{ opIpSummary.total_ip_registrations_short_period ? opIpSummary.total_ip_registrations_short_period : 0  }}</font></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                       <!--     <a href="#" id="test" onClick="javascript:fnExcelReport();">
                            <div class="panel-footer">
                                <span class="pull-left"><i class="fa fa-file-excel-o"></i>&nbsp; Export to Excel</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a> -->
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel .chat-panel -->
                </div>
                <!-- /.col-lg-4 -->
                <div class="col-lg-6" ng-controller="MapCtrl as mapCtrl">
                    <div class="panel panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-map-marker fa-fw"></i> Hospital Location
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="hospitals_locations_map" style="height: 500px;"></div>
                        </div>
                        <!-- /.panel-body -->
                    <!--    <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">More Details: </span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a> -->
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12" ng-controller="DiagnosticsCtrl as diagnosticsCtrl">
                    <div class="panel panel panel-warning">
                        <div class="panel-heading">
                            <i class="fa fa-medkit fa-fw"></i> Diagnostic Information
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           
                        <div class="table-responsive" style="height: 500px; overflow-y: scroll; overflow-x: scroll;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-right"><font face="Modern, Arial" size="4">#</font></th>
                                        <th><font face="Modern, Arial" size="4">Hospital</font></th>
                                        <th class="text-right" ng-repeat="labs in diagnosticsCtrl.diagnostics | unique: 'test_area'"><font face="Modern, Arial" size="4">{{ labs.test_area }}</font></th>
                                    </tr>
                                    <tr ng-repeat="diagnostic in diagnosticsCtrl.diagnostics_summary">
                                        <td class="text-right"><font face="Modern, Arial" size="4">{{ $index + 1 }}</font></td>
                                        <td class="text-centre"><font face="Modern, Arial" size="4">{{ diagnostic.hospital_name }}</font></td>
                                        <td ng-repeat="tests_done in diagnostic[0] track by $index" class="text-right"><font face="Modern, Arial" size="4">{{ tests_done }}</font></td>
                                    </tr>
                                </thead>
                            </table>
                    </div>
                        </div>
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->



<script  src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.11/angular.js"></script>

<script>
    angular.module('dashboardHome', [])
    .controller('DashboardCtrl', ['$http', function($http) {
        var self = this;
        self.opIpSummary = [];
        self.hospitals = [];
        self.today = new Date();
        self.totalOP = 0;
        self.totalIP = 0;
        self.totalNewOP = 0;
        self.totalRepeatOP = 0;
        var totalIPOP = function(){
            for (var i = 0; i < self.opIpSummary.length; i++){
                if(self.opIpSummary[i].total_op_registrations_short_period){
                    self.totalOP += parseInt(self.opIpSummary[i].total_op_registrations_short_period);
                    self.totalIP += parseInt(self.opIpSummary[i].total_ip_registrations_short_period);
                    self.totalNewOP += parseInt(self.opIpSummary[i].total_op_registrations_short_period) - parseInt(self.opIpSummary[i].repeat_visits_op);
                    self.totalRepeatOP += parseInt(self.opIpSummary[i].repeat_visits_op);
                }
            }
            self.totalOP = self.totalOP.toLocaleString();
            self.totalIP = self.totalIP.toLocaleString();
            self.totalNewOP = self.totalNewOP.toLocaleString();
            self.totalRepeatOP = self.totalRepeatOP.toLocaleString();
        };
        var getOpIpSummary = function() {
          return $http.get('<?php echo base_url(); ?>hospital/get_patients_summary_by_hospital').then(
            function(response) {
            self.opIpSummary = response.data;
            totalIPOP();
             getHospitals();
          }, function(errResponse) {
            console.error(errResponse.data.msg);
          })
        };
        getOpIpSummary();
        var getHospitals = function() {
          return $http.get('<?php echo base_url(); ?>hospital/get_hospitals').then(
            function(response) {
                self.hospitals = response.data;
                mergeHospitals();
                for (var i = 0; i < self.hospitals.length; i++){
                    createMarker(self.hospitals[i]);
                }
            }, function(errResponse) {
                console.error(errResponse.data.msg);
            });
        };
        
        var mergeHospitals = function(){
            for (var i = 0; i < self.hospitals.length; i++){
                var flag = 0;
                for(var j = 0; j < self.opIpSummary.length; j++){
                    if(self.opIpSummary[j].hospital_short_name.valueOf() == self.hospitals[i].hosptial_name.valueOf()){
                        flag = 1;
                        console.log(self.opIpSummary[j].hospital_short_name +" "+ self.hospitals[i].hosptial_name)
                        break;
                    }
                }
                if(flag == 0){
                    self.opIpSummary.push({'hospital_short_name' : self.hospitals[i].hospital_name});
                }
            }
            console.log('In Merge Hospitals');
        }
    }])
    .controller('MapCtrl',['$http','$scope', function($http, $scope){
        var self = this;
        self.hospitals = [];
        
        var createMarker = function (info){
            var marker = new google.maps.Marker({
                map: $scope.map,
                position: new google.maps.LatLng(info.latitude_n, info.longitude_e),
                title: info.hospital_short_name
            });
            marker.content = '<div class="infoWindowContent">' + info.address + '</div>';

            google.maps.event.addListener(marker, 'click', function(){
                infoWindow.setContent('<h2>' + marker.title + '</h2>' + marker.content);
                infoWindow.open($scope.map, marker);
            });

            $scope.markers.push(marker);
        }
        
        var getHospitals = function() {
          return $http.get('<?php echo base_url(); ?>hospital/get_hospitals').then(
            function(response) {
                self.hospitals = response.data;
                for (var i = 0; i < self.hospitals.length; i++){
                    createMarker(self.hospitals[i]);
                }
            }, function(errResponse) {
                console.error(errResponse.data.msg);
            });
        };
        getHospitals();
        var mapOptions = {
            zoom: 9,
            center: new google.maps.LatLng(17.3850, 78.4867),
            mapTypeId: google.maps.MapTypeId.TERRAIN
        }

        $scope.map = new google.maps.Map(document.getElementById('hospitals_locations_map'), mapOptions);

        $scope.markers = [];

        var infoWindow = new google.maps.InfoWindow();

        $scope.openInfoWindow = function(e, selectedMarker){
            e.preventDefault();
            google.maps.event.trigger(selectedMarker, 'click');
        }
    }]).filter('unique', function() {
   // we will return a function which will take in a collection
   // and a keyname
   return function(collection, keyname) {
      // we define our output and keys array;
      var output = [], 
          keys = [];
      
      // we utilize angular's foreach function
      // this takes in our original collection and an iterator function
      angular.forEach(collection, function(item) {
          // we check to see whether our object exists
          var key = item[keyname];
          // if it's not already part of our keys array
          if(keys.indexOf(key) === -1) {
              // add it to our keys array
              keys.push(key); 
              // push this item to our final output array
              output.push(item);
          }
      });
      // return our array which should be devoid of
      // any duplicates
      return output;
   };
    })
    .controller('DiagnosticsCtrl',['$http','$scope', '$filter', function($http, $scope, $filter){
        var self = this;
        self.diagnostics = [];
        self.lab = [];
        self.diagnostics_summary = [];
        self.hospitals = [];
        var getDiagnostics = function(){
            return $http.get('<?php echo base_url(); ?>hospital/get_lab_summary_by_hospital').then(
                function(response){
                    self.diagnostics = response.data;
                    self.lab = $filter('unique')( self.diagnostics, 'test_area');
                    self.hospitals = $filter('unique')( self.diagnostics, 'hospital_name');
                   
                    for(var i=0; i < self.hospitals.length; i++ ){                      // Unique hospitals loop
                        var hospital = [];
                        hospital['hospital_name'] = self.hospitals[i].hospital_name;
                        var test_counter = 0;
                        var tests = [];
                        
                        for(var j = 0; j < self.lab.length; j++){                              // Unique labs loop                            
                            var lab_exists = false;
                            for(var k = 0; k < self.diagnostics.length; k++){           // Hospital loop
                                if(self.diagnostics[k].hospital_name == self.hospitals[i].hospital_name && self.diagnostics[k].test_area == self.lab[j].test_area){                                    
                                    tests[test_counter] = self.diagnostics[k].tests;
                                    lab_exists = true;
                                    test_counter++;
                                }
                            }
                            if(!lab_exists){
                                tests[test_counter] = '0';
                                test_counter++;
                            }
                        }
                        hospital.push(tests);
                        Object.assign({}, hospital);
                        self.diagnostics_summary.push(hospital);
                    }
                    console.log(self.diagnostics_summary);
                },
                function(errResponse){
                    console.error(errResponse.data.msg);
                }
            );
        };
        
        getDiagnostics();
    }]);
    
</script>