<div ng-app ="hosptialLogin" id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Hospital Summary Reports</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
                <div class="col-lg-12" ng-controller="Patients_per_departmentCtrl as patients_per_departmentCtrl">
                    <div class="panel panel panel-warning">
                        <div class="panel-heading">
                            <i class="fa fa-medkit fa-fw"></i> Patient Visits by Department
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
    <script  src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.11/angular.js"></script>
<script>
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
        var getPatients_per_department = function(){
            return $http.get('<?php echo base_url(); ?>hospital/get_patients_by_department').then(
                function(response){
                    self.patients_per_department = response.data;
                    self.department = $filter('unique')( self.patients_per_department, 'department');
                    self.hospitals = $filter('unique')( self.patients_per_department, 'hospital_name');
                   
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
                                    patient_counter++;
                                }
                            }
                            if(!department_exists){
                                patients[patient_counter] = '0';
                                patient_counter++;
                            }
                        }
                        hospital.push(patients);
                        Object.assign({}, hospital);
                        self.patients_per_department_summary.push(hospital);
                    }
                    console.log(self.patients_per_department_summary);
                },
                function(errResponse){
                    console.error(errResponse.data.msg);
                }
            );
        };
        
        getPatients_per_department();
    }]);
</script>

</div>  <!-- Page wrapper end -->



