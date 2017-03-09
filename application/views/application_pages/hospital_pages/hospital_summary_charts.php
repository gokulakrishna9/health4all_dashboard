
<div ng-app ="hosptialSummaryCharts" id="page-wrapper">
    <div ng-controller ="OPIPSummaryCtrl as opIPSummaryCtrl" class="panel-body">
        <div class="row">  <!-- Row One -->
            <div class="col-lg-6 col-md-3" align="center">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Out Patients and In Patients Summary
                    </div>
                    <div class="panel-body" style="height: 500px; overflow-y: scroll;" >
                        <chart value="opIPSummary" type="Bar"></chart>
                    </div>
                    <div class="panel-footer">
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-3" align="center">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Lab Summary
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div ng-repeat="test_area in opIPSummaryCtrl.test_areas" class="col-lg-6 col-md-6" align="center">
                                <div class="panel-body" style="height: 100px; overflow-y: scroll;" >
                                    <chart  ng-value="{{test_area.test_area}}" type="Bar"></chart>
                                </div>
                                <div class="panel-footer">
                                    {{test_area.test_area}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        
                    </div>
                </div>
            </div>
        </div>  <!-- Row One -->
    </div>
    
<script  src="<?php echo base_url(); ?>css_js/js/angular/angular.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.1/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>css_js/js/angular/chartjs-directive.js"></script>
<script>
    angular.module('hosptialSummaryCharts', ['chartjs-directive'])
    .controller('OPIPSummaryCtrl', ['$http','$scope', function($http, $scope) {
        var self = this;
        self.op_summary = [];
        self.lab_summary = [];
        self.test_areas = [];
        console.log('In angular');
        var plotOPIPGraph = function(){
            var opSummaryLabels = self.op_summary.map(function(array){return array.hospital_short_name});
            var opSummaryValues = self.op_summary.map(function(array){return array.total_op_registrations_short_period});
            var ipSummaryValues = self.op_summary.map(function(array){return array.total_ip_registrations_short_period});
            
            var summaryData ={
                labels: opSummaryLabels,
                datasets : [
                {
                   fillColor : "rgba(220,220,220,0.5)",
                   strokeColor : "rgba(220,220,220,1)",
                   pointColor : "rgba(220,220,220,1)",
                   pointStrokeColor : "#fff",
                   data: opSummaryValues
                },
                {
                   fillColor : "rgba(151,187,205,0.5)",
                   strokeColor : "rgba(151,187,205,1)",
                   pointColor : "rgba(151,187,205,1)",
                   pointStrokeColor : "#fff",
                   data: ipSummaryValues
                }]
            }
            $scope.opIPSummary = {"data": summaryData, "options": {} };
        }
        
        var plotLabGraph = function(){
            var hospitalNameLabels = self.lab_summary.map(function(array){return array.hospital_short_name});
            for (var i = 0; i < self.test_areas.length; i++){
                for(var j = 0; i < self.lab_summary.length; j++){
                    var labSummaryValues = self.op_summary.map(function(array){return array.tests});
                    var summaryData ={
                        labels: opSummaryLabels,
                        datasets : [
                        {
                           fillColor : "rgba(220,220,220,0.5)",
                           strokeColor : "rgba(220,220,220,1)",
                           pointColor : "rgba(220,220,220,1)",
                           pointStrokeColor : "#fff",
                           data: labSummaryValues
                        }]
                    }
                    $scope.opIPSummary = {"data": summaryData, "options": {} };
                }
            }
        }
        
        var getOpSummary = function() {
          return $http.get('<?php echo base_url(); ?>hospital/get_patients_summary_by_hospital').then(
            function(response) {
            self.op_summary = response.data;
            plotOPIPGraph();
          }, function(errResponse) {
            console.error(errResponse.data.msg);
          });
        };
        
        var getTestAreas = function(){
            return $http.get('<?php echo base_url(); ?>hospital/get_test_areas').then(
            function(response) {
            self.test_areas = response.data;
            console.log(self.test_areas);
          }, function(errResponse) {
            console.error(errResponse.data.msg);
          });
        };
        
        var getLabSummary = function() {
          return $http.get('<?php echo base_url(); ?>hospital/get_lab_summary_by_hospital').then(
            function(response) {
            self.lab_summary = response.data;
            plotLabGraph();
          }, function(errResponse) {
            console.error(errResponse.data.msg);
          });
        };
        
        getOpSummary();
        getTestAreas();
        getLabSummary();
    }]);
</script>

</div>


