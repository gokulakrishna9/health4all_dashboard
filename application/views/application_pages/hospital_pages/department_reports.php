<div id="page-wrapper" ng-controller="Patients_per_departmentCtrl as patients_per_departmentCtrl">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Patient Visits by Department <span><font face="Modern, Arial" size="4"> at {{ patients_per_departmentCtrl.today | date: 'dd-MMM-yyyy, hh:mm:ss a' }}</font></span></h1> 
        </div>
        <!-- /.col-lg-12 -->
        <div class="col-lg-12" >
            <form ng-submit="patients_per_departmentCtrl.submit()">
                <input type="date" ng-model="patients_per_departmentCtrl.date.from_date">
                <input type="date" ng-model="patients_per_departmentCtrl.date.to_date">
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6" ng-repeat="(department, icon) in patients_per_departmentCtrl.departments">
                    <div class="panel panel panel-warning">
                        <div class="panel-heading">
                             <span><img src="<?php echo base_url(); ?>assets/icons/{{ icon }}.jpg" alt="{{ department }}" style="width:50px;height:40px;"><font face="Modern, Arial" size="5">&nbsp; {{ department }}</span>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive" style="height: 500px; overflow-x: scroll;">
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
                                    <tbody  style="overflow-y: scroll;">
                                        <tr ng-repeat="patients in patients_per_departmentCtrl.patients_per_department | filter:department : true">
                                            <td class="text-right"><font face="Modern, Arial" size="4">{{ $index + 1 }}</font></td>
                                            <td class="text-centre"><font face="Modern, Arial" size="4">{{ patients.hospital_name }}</font></td>
                                            <td class="text-right"><font face="Modern, Arial" size="4">{{ patients.department_visits_op_total -  patients.department_visits_repeat_op ? patients.department_visits_op_total -  patients.department_visits_repeat_op : 0}}</font></td>
                                            <td class="text-right"><font face="Modern, Arial" size="4">{{ patients.department_visits_repeat_op ? patients.department_visits_repeat_op : 0 }}</font></td>
                                            <td class="text-right"><font face="Modern, Arial" size="4">{{ patients.department_visits_op_total ? patients.department_visits_op_total : 0 }}</font></td>
                                            <td class="text-right"><font face="Modern, Arial" size="4">{{ patients.department_visits_ip_total ? patients.department_visits_ip_total: 0 }}</font></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel panel-warning">
                        <div class="panel-heading">
                            <i class="fa fa-medkit fa-fw"></i> Patient Visits by Department Summary
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           
                        <div class="table-responsive" style="height: 500px; overflow-y: scroll; overflow-x: scroll;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-right"><font face="Modern, Arial" size="4">#</font></th>
                                        <th><font face="Modern, Arial" size="4">Hospital</font></th>
                                        <th class="text-right" ng-repeat="departments in patients_per_departmentCtrl.patients_per_department | unique: 'department'"><font face="Modern, Arial" size="4">{{ departments.department }}</font></th>
                                    </tr>
                                    <tr ng-repeat="patients in patients_per_departmentCtrl.patients_per_department_summary">
                                        <td class="text-right"><font face="Modern, Arial" size="4">{{ $index + 1 }}</font></td>
                                        <td class="text-centre"><font face="Modern, Arial" size="4">{{ patients.hospital_name }}</font></td>
                                        <td ng-repeat="visits in patients[0] track by $index" class="text-right"><font face="Modern, Arial" size="4">{{ visits }}</font></td>
                                    </tr>
                                </thead>
                            </table>
                    </div>
                        </div>
                </div>
            </div>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.11/angular.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-google-chart/0.1.0/ng-google-chart.min.js" type="text/javascript"></script> -->
<script>
    google.load('visualization', '1', {
        packages: ['corechart']
    });
    
    google.setOnLoadCallback(function() {
        angular.bootstrap(document.body, ['hosptialLogin']);
    });
    
    angular.module('hosptialLogin', [])
    .filter('unique', function() {
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
    .controller('Patients_per_departmentCtrl',['$http','$scope', '$filter', function($http, $scope, $filter){
        var self = this;
        self.patients_per_department = [];
        self.lab = [];
        self.patients_per_department_summary = [];
        self.hospitals = [];
        self.departments ={
            'Obstetrics and Gynecology': 'Gynaecology', 'Pediatrics': 'Paediatrics', 'General Medicine': 'General Medicine', 'General Surgery': 'General Surgery',
            'Orthopedics':'Orthopedics', 'Ophthalmology': 'Opthalmology', 'ENT': 'ENT'
        };
        
        self.today = new Date();
        self.date= { 'from_date' : new Date, 'to_date' : new Date };
        $scope.departmentChartObject = {};
        
        var getPatients_per_department = function(){
            return $http.post('<?php echo base_url(); ?>hospital/get_patients_by_department', self.date).then(
                function(response){
                    self.patients_per_department = response.data;
                    
                    self.department = $filter('unique')( self.patients_per_department, 'department');
                    self.hospitals = $filter('unique')( self.patients_per_department, 'hospital_name');
                    self.getHospitals();
                    self.chart_array = [];
                    self.chart_id = 'barChartDiv';
                    self.chart_array.push(['Hospital Name', 'Department']);
                    for(var i=0; i < self.hospitals.length; i++ ){                      // Unique hospitals loop
                        var hospital = [];
                        hospital['hospital_name'] = self.hospitals[i].hospital_name;
                        var patient_counter = 0;
                        var patients = [];
                        
                        for(var j = 0; j < self.department.length; j++){                                   // Unique labs loop
                            var department_exists = false;
                            for(var k = 0; k < self.patients_per_department.length; k++){           // Hospital loop
                                if(self.patients_per_department[k].hospital_name == self.hospitals[i].hospital_name && self.patients_per_department[k].department == self.department[j].department){                                    
                                    patients[patient_counter] = self.patients_per_department[k].department_visits;
                                    department_exists = true;
                                    self.chart_array.push([self.patients_per_department[k].hospital_name, parseInt(patients[patient_counter])]);
                                    patient_counter++;
                                }
                            }
                            if(!department_exists){
                                patients[patient_counter] = '0';
                                self.chart_array.push([self.patients_per_department[i].hospital_name, 0]);
                                patient_counter++;
                            }
                        }
                        hospital.push(patients);
                        Object.assign({}, hospital);
                        self.patients_per_department_summary.push(hospital);
                    }
                   /*
                    var chart_data = google.visualization.arrayToDataTable(self.chart_array);
                    var chart_options = {
                        title: 'Departmentwise Patient Visits',
                        hAxis: {
                            title: 'Total Paitent Visits',
                            minValue: 0
                        },
                        vAxis: {
                            title: 'Hospitals'
                        }
                    };
                    /*
                    var bar_chart = new google.visualization.BarChart(document.getElementById(self.chart_id));
                    bar_chart.draw(chart_data, chart_options); */
                },
                function(errResponse){
                    console.error(errResponse.data.msg);
                }
            );
        };
        
        self.submit = function(){
            getPatients_per_department();
        };
        
        self.getHospitals = function() {
          return $http.get('<?php echo base_url(); ?>hospital/get_hospitals').then(
            function(response) {
                self.hospitals = response.data;
                self.mergeHospitals();
                for (var i = 0; i < self.hospitals.length; i++){
                    createMarker(self.hospitals[i]);
                }
            }, function(errResponse) {
                console.error(errResponse.data.msg);
            });
        };
        
        self.mergeHospitals = function(){
         /*   for(var k = 0; k < self.department.length; k++){
                for (var i = 0; i < self.hospitals.length; i++){
                    var flag = 0;
                    for(var j = 0; j < self.patients_per_department.length; j++){
                        if(self.patients_per_department[j].department.valueOf().trim() == self.department[k].department.valueOf().trim()){
                                if(self.patients_per_department[j].hospital_name.valueOf().trim() == self.hospitals[i].hospital_name.valueOf().trim()){
                                    flag = 1;
                                    break;
                                }
                        } // Department if condition.
                        if(flag == 0){
                            self.patients_per_department.push({'hospital_name' : self.hospitals[i].hospital_name, 'department' : self.patients_per_department[k].department});
                        }
                    } // Patient for loop.
                } // Middle for loop, hospital.
            } // Outter for loop, department. */
        };   // Function end. 
        getPatients_per_department();
    }]);
</script>

</div>  <!-- Page wrapper end -->



<!-- 
$scope.departmentChartObject.type = "BarChart";
                    $scope.departmentChartObject.data = {
                        "cols": [{id:"s", label: "Patient Visits", type: "number"}],
                        "rows": [ {c:[ 
                                    {v: self.patients_per_department_summary.hospital_name},
                                    {v: self.patients_per_department_summary.department_visits}
                        ]}]};
                        
                    $scope.departmentChartObject.options = {
                        'title': 'Department wise patients visit.'
                    };

-->