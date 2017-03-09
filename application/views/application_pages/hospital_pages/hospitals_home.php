<!DOCTYPE html>

<div ng-app ="hosptialLogin" id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Hospitals</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
            <div class="panel-heading">
                    Hospital Names
            </div>
            <!-- /.panel-heading -->
            <div ng-controller ="HosptialCtrl as hospitalCtrl" class="panel-body">
                <div class="table-responsive table-striped">
                    <table class="table" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Hospital Name</th>
                                <th>District</th>
                                <th>Address</th>
                                <th>Land Line/Mobile</th>
                                <th>Staff Login</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="hospital in hospitalCtrl.hospitals">
                                <td></td>
                                <td>{{ hospital.hospital_name }}</td>
                                <td>{{ hospital.district }}</td>
                                <td>{{ hospital.address }}</td>
                                <td>{{ hospital.land_line }} / {{ hospital.mobile }}</td>
                                <td> <a class="btn btn-default" target="_blank" href="{{ hospital.application_url; }}" role="button">Login</a> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</div>
    <script  src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.11/angular.js"></script>
<script>
    angular.module('hosptialLogin', [])
    .controller('HosptialCtrl', ['$http', function($http) {
        var self = this;
        self.hospitals = [];
        console.log('In angular');
        var getHospitals = function() {
          return $http.get('<?php echo base_url(); ?>hospital/get_hospitals').then(
            function(response) {
            self.hospitals = response.data;
            console.log(self.hospitals);
          }, function(errResponse) {
            console.error(errResponse.data.msg);
          });
        };
        getHospitals();
    }]);
</script>

</div>  <!-- Page wrapper end -->

