<?php
    // Inventory by bank.
    $inventory_string = "";
    foreach ($bloodbanks_status as $inventory){
        $inventory_string .= "$inventory->total_inventory, ";
    }


    // Last update time by Bank.
    
    foreach ($bloodbanks_status as $bloodbank_status){
        $not_available_string = "";
        $date_updated = date_create($bloodbank_status->last_modified_time); 
        $today = date_create(date("Y-m-d"));
        $date_diff = date_diff($date_updated, $today);

        $last_updated_days = (int)$date_diff->format("%d");                                            
        $last_updated_years = (int)$date_diff->format("%y");
        $not_available_string = 1;
        $updated_before_2_days = 1;
        $updated_last_24_hrs = 1;
        if($last_updated_days >= 20 || $last_updated_years > 0 || $bloodbank_status->total_inventory == 0){
            $not_available_string += 1;
        }else if($last_updated_days >= 2){
            $updated_before_2_days += 1;
        }else{
            $updated_last_24_hrs += 1;
        }
        
    }
?>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script>
$(document).ready(function(){
    var dataset = {
  inventory: [<?php echo $inventory_string; ?>],
  last_update: [<?php echo $not_available_string; ?>, <?php echo $updated_before_2_days; ?>, <?php echo $updated_last_24_hrs; ?>] // previously 5 values, now only 4
};

var width = 300,
  height = 300,
  radius = Math.min(width, height) / 2;

var enterAntiClockwise = {
  startAngle: Math.PI * 2,
  endAngle: Math.PI * 2
};

var color = d3.scale.category20();

var pie = d3.layout.pie()
  .sort(null);

var arc = d3.svg.arc()
  .innerRadius(radius - 100)
  .outerRadius(radius - 20);

var svg = d3.select("#bloodbank_status").append("svg")
  .attr("width", width)
  .attr("height", height)
  .append("g")
  .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

var path = svg.selectAll("path")
  .data(pie(dataset.inventory))
  .enter().append("path")
  .attr("fill", function(d, i) { return color(i); })
  .attr("d", arc)
  .each(function(d) { this._current = d; }); // store the initial values

d3.selectAll("input").on("change", change);

var timeout = setTimeout(function() {
  d3.select("input[value=\"last_update\"]").property("checked", true).each(change);
}, 2000);

function change() {
  clearTimeout(timeout);
  path = path.data(pie(dataset[this.value])); // update the data
  // set the start and end angles to Math.PI * 2 so we can transition
  // anticlockwise to the actual values later
  path.enter().append("path")
      .attr("fill", function (d, i) {
        return color(i);
      })
      .attr("d", arc(enterAntiClockwise))
      .each(function (d) {
        this._current = {
          data: d.data,
          value: d.value,
          startAngle: enterAntiClockwise.startAngle,
          endAngle: enterAntiClockwise.endAngle
        };
      }); // store the initial values

  path.exit()
      .transition()
      .duration(750)
      .attrTween('d', arcTweenOut)
      .remove() // now remove the exiting arcs

  path.transition().duration(750).attrTween("d", arcTween); // redraw the arcs
}

// Store the displayed angles in _current.
// Then, interpolate from _current to the new angles.
// During the transition, _current is updated in-place by d3.interpolate.
function arcTween(a) {
  var i = d3.interpolate(this._current, a);
  this._current = i(0);
  return function(t) {
  return arc(i(t));
  };
}
// Interpolate exiting arcs start and end angles to Math.PI * 2
// so that they 'exit' at the end of the data
function arcTweenOut(a) {
  var i = d3.interpolate(this._current, {startAngle: Math.PI * 2, endAngle: Math.PI * 2, value: 0});
  this._current = i(0);
  return function (t) {
    return arc(i(t));
  };
}
});


</script>



        

<div id="page-wrapper">
    
    <div class="row">
        <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            BloodBanks Status
        </div>            
        </div>            
    </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            BloodBank Status
                            <form id="bloodBank_status">
                                <label><input type="radio" name="dataset" value="inventory" checked> Inventory</label>
                                <label><input type="radio" name="dataset" value="last_update"> Last Update</label>    
                            </form>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="bloodbank_status"></div>
                        </div>

                    </div>
                    <!-- /.panel -->
                </div>
            </div>
</div>