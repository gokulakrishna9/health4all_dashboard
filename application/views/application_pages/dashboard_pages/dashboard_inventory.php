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
     tab_text = tab_text + $('#bloodbanks_detailed_inventory').html(); 
     tab_text = tab_text + '</table></body></html>'; 
     var data_type = 'data:application/vnd.ms-excel'; 
     $('#test').attr('href', data_type + ', ' + encodeURIComponent(tab_text)); 
     //downloaded excel sheet name is given here 
     $('#test').attr('download', '<?php echo "bloodbank";?>_detailed_inventory.xls');
 }
</script>
    
    <?php 
    $group_total = array();
    
    $sub_group_total = array();
    
    $total_component =  array();
    $total = array();
    $total_by_bank = array();
    $inventory_by_type_subtype = array(); // Array to hold the inventory object with type and subtype keys.
    
    $total["a_positive"] = 0;
    $total["b_positive"] = 0;
    $total["o_positive"] = 0;
    $total["a_negative"] = 0;
    $total["b_negative"] = 0;
    $total["o_negative"] = 0;
    $total["ab_positive"] = 0;
    $total["ab_negative"] = 0;
    $total['total'] = 0;
    $types_in_db = array();
    $subtypes_in_db = array();
    $combination_types_in_db = array();
    foreach($bloodbank_types as $bloodbank_type){        
        $group_total["$bloodbank_type->bloodbank_type_id"]["a_positive"] = 0;
        $group_total["$bloodbank_type->bloodbank_type_id"]["b_positive"] = 0;
        $group_total["$bloodbank_type->bloodbank_type_id"]["o_positive"] = 0;
        $group_total["$bloodbank_type->bloodbank_type_id"]["a_negative"] = 0;
        $group_total["$bloodbank_type->bloodbank_type_id"]["b_negative"] = 0;
        $group_total["$bloodbank_type->bloodbank_type_id"]["o_negative"] = 0;
        $group_total["$bloodbank_type->bloodbank_type_id"]["ab_positive"] = 0;
        $group_total["$bloodbank_type->bloodbank_type_id"]["ab_negative"] = 0;
        $group_total["$bloodbank_type->bloodbank_type_id"]["total"] = 0;
    }
    foreach($bloodbank_sub_types as $bloodbank_subtype){
        
        $sub_group_total["$bloodbank_subtype->bloodbank_subtype"]["a_positive"] = 0;
        $sub_group_total["$bloodbank_subtype->bloodbank_subtype"]["b_positive"] = 0;
        $sub_group_total["$bloodbank_subtype->bloodbank_subtype"]["o_positive"] = 0;
        $sub_group_total["$bloodbank_subtype->bloodbank_subtype"]["a_negative"] = 0;
        $sub_group_total["$bloodbank_subtype->bloodbank_subtype"]["b_negative"] = 0;
        $sub_group_total["$bloodbank_subtype->bloodbank_subtype"]["o_negative"] = 0;
        $sub_group_total["$bloodbank_subtype->bloodbank_subtype"]["ab_positive"] = 0;
        $sub_group_total["$bloodbank_subtype->bloodbank_subtype"]["ab_negative"] = 0;
        $sub_group_total["$bloodbank_subtype->bloodbank_subtype"]["total"] = 0;
        
    }
    
    
    foreach($inventory_detailed as $inventory){
        $group_total["$inventory->bloodbank_type"]["a_positive"] += $inventory->a_positive;
        $group_total["$inventory->bloodbank_type"]["b_positive"] += $inventory->b_positive;
        $group_total["$inventory->bloodbank_type"]["o_positive"] += $inventory->o_positive;
        $group_total["$inventory->bloodbank_type"]["a_negative"] += $inventory->a_negative;
        $group_total["$inventory->bloodbank_type"]["b_negative"] += $inventory->b_negative;
        $group_total["$inventory->bloodbank_type"]["o_negative"] += $inventory->o_negative;
        $group_total["$inventory->bloodbank_type"]["ab_positive"] += $inventory->ab_positive;
        $group_total["$inventory->bloodbank_type"]["ab_negative"] += $inventory->ab_negative;
        $group_total["$inventory->bloodbank_type"]["total"] += $inventory->a_positive + $inventory->b_positive + $inventory->o_positive + $inventory->a_negative 
            + $inventory->b_negative + $inventory->o_negative + $inventory->ab_positive + $inventory->ab_negative;
        
        $sub_group_total["$inventory->bloodbank_subtype"]["a_positive"] += $inventory->a_positive;
        $sub_group_total["$inventory->bloodbank_subtype"]["b_positive"] += $inventory->b_positive;
        $sub_group_total["$inventory->bloodbank_subtype"]["o_positive"] += $inventory->o_positive;
        $sub_group_total["$inventory->bloodbank_subtype"]["a_negative"] += $inventory->a_negative;
        $sub_group_total["$inventory->bloodbank_subtype"]["b_negative"] += $inventory->b_negative;
        $sub_group_total["$inventory->bloodbank_subtype"]["o_negative"] += $inventory->o_negative;
        $sub_group_total["$inventory->bloodbank_subtype"]["ab_positive"] += $inventory->ab_positive;
        $sub_group_total["$inventory->bloodbank_subtype"]["ab_negative"] += $inventory->ab_negative;
        $sub_group_total["$inventory->bloodbank_subtype"]["total"] += $inventory->a_positive + $inventory->b_positive + $inventory->o_positive + $inventory->a_negative 
            + $inventory->b_negative + $inventory->o_negative + $inventory->ab_positive + $inventory->ab_negative;
        
        $total["a_positive"] += $inventory->a_positive;
        $total["b_positive"] += $inventory->b_positive;
        $total["o_positive"] += $inventory->o_positive;
        $total["a_negative"] += $inventory->a_negative;
        $total["b_negative"] += $inventory->b_negative;
        $total["o_negative"] += $inventory->o_negative;
        $total["ab_positive"] += $inventory->ab_positive;
        $total["ab_negative"] += $inventory->ab_negative;
        $total['total'] += $inventory->a_positive + $inventory->b_positive + $inventory->o_positive + $inventory->a_negative 
            + $inventory->b_negative + $inventory->o_negative + $inventory->ab_positive + $inventory->ab_negative;
        
        $total_component["$inventory->bloodbank_id"]['pc'] = $inventory->a_positive_pc + $inventory->b_positive_pc +$inventory->o_positive_pc +
            $inventory->a_negative_pc +$inventory->b_negative_pc +$inventory->o_negative_pc + $inventory->ab_positive_pc + $inventory->ab_negative_pc;        
        $total_component["$inventory->bloodbank_id"]['platelet_concentrate'] = $inventory->a_positive_platelet_concentrate + $inventory->b_positive_platelet_concentrate +$inventory->o_positive_platelet_concentrate +
            $inventory->a_negative_platelet_concentrate +$inventory->b_negative_platelet_concentrate +$inventory->o_negative_platelet_concentrate + $inventory->ab_positive_platelet_concentrate + $inventory->ab_negative_platelet_concentrate;        
        $total_component["$inventory->bloodbank_id"]['wb'] = $inventory->a_positive_wb + $inventory->b_positive_wb +$inventory->o_positive_wb +
            $inventory->a_negative_wb +$inventory->b_negative_wb +$inventory->o_negative_wb + $inventory->ab_positive_wb + $inventory->ab_negative_wb;
        $total_component["$inventory->bloodbank_id"]['cryo'] = $inventory->a_positive_cryo + $inventory->b_positive_cryo +$inventory->o_positive_cryo +
            $inventory->a_negative_cryo +$inventory->b_negative_cryo +$inventory->o_negative_cryo + $inventory->ab_positive_cryo + $inventory->ab_negative_cryo;
        $total_component["$inventory->bloodbank_id"]['fp'] = $inventory->a_positive_fp + $inventory->b_positive_fp +$inventory->o_positive_fp +
            $inventory->a_negative_fp +$inventory->b_negative_fp + $inventory->o_negative_fp + $inventory->ab_positive_fp + $inventory->ab_negative_fp;
        $total_component["$inventory->bloodbank_id"]['ffp'] = $inventory->a_positive_ffp + $inventory->b_positive_ffp +$inventory->o_positive_ffp +
            $inventory->a_negative_ffp +$inventory->b_negative_ffp +$inventory->o_negative_ffp + $inventory->ab_positive_ffp + $inventory->ab_negative_ffp;
        $total_component["$inventory->bloodbank_id"]['prp'] = $inventory->a_positive_prp + $inventory->b_positive_prp +$inventory->o_positive_prp +
            $inventory->a_negative_prp +$inventory->b_negative_prp +$inventory->o_negative_prp + $inventory->ab_positive_prp + $inventory->ab_negative_prp;
        
        //Building the inventory array.
        $inventory_by_type_subtype["$inventory->bloodbank_type"]["$inventory->bloodbank_subtype"][] = $inventory;
        $total_by_bank["$inventory->bloodbank_id"]['total'] = $inventory->a_positive + $inventory->b_positive +$inventory->o_positive +
            $inventory->a_negative +$inventory->b_negative +$inventory->o_negative + $inventory->ab_positive + $inventory->ab_negative;
        
        if(array_key_exists("$inventory->bloodbank_type"."$inventory->bloodbank_subtype", $combination_types_in_db)){
            
        }else{
            $combination_types_in_db["$inventory->bloodbank_type"."$inventory->bloodbank_subtype"] = 1;
        }
        if(array_key_exists("$inventory->bloodbank_type", $types_in_db)){
            
        }else{
            $types_in_db["$inventory->bloodbank_type"] = 1;
        }
        if(array_key_exists("$inventory->bloodbank_subtype", $subtypes_in_db)){
            continue;
        }else{
          $subtypes_in_db["$inventory->bloodbank_subtype"] = 1;
        }
        
    } ?>
    <div id="page-wrapper" style="overflow-y: scroll;">
        <div class="row">&nbsp;</div>
    <div class="panel panel-green">
                                               
                        <div class="panel-heading">
                            Inventory Detailed
                            <a href="#" id="test" onClick="javascript:fnExcelReport();"><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span></a>                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table" id="bloodbanks_detailed_inventory">
                                    <thead>
                                        <tr>
                                            <th>Blood Banks</th>
                                            <th>A+</th>
                                            <th>A-</th>
                                            <th>AB+</th>
                                            <th>AB-</th>
                                            <th>B+</th>
                                            <th>B-</th>
                                            <th>O+</th>
                                            <th>O-</th>
                                            <th>Last update</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <?php foreach($bloodbank_types as $bloodbank_type){                                            
                                            if(array_key_exists("$bloodbank_type->bloodbank_type_id", $types_in_db)){
                                                
                                            }else{                                                
                                                continue;
                                            }
                                            
                                        ?>
                                        <tr class="warning"> <!-- Inventory total by First Level Grouping  -->
                                            <td><?php echo $bloodbank_type->bloodbank_type; ?></td>
                                            <td><?php echo $group_total["$bloodbank_type->bloodbank_type_id"]["a_positive"]; ?></td>
                                            <td><?php echo $group_total["$bloodbank_type->bloodbank_type_id"]["a_negative"]; ?></td>
                                            <td><?php echo $group_total["$bloodbank_type->bloodbank_type_id"]["ab_positive"]; ?></td>
                                            <td><?php echo $group_total["$bloodbank_type->bloodbank_type_id"]["ab_negative"]; ?></td>
                                            <td><?php echo $group_total["$bloodbank_type->bloodbank_type_id"]["b_positive"]; ?></td>
                                            <td><?php echo $group_total["$bloodbank_type->bloodbank_type_id"]["b_negative"]; ?></td>
                                            <td><?php echo $group_total["$bloodbank_type->bloodbank_type_id"]["o_positive"]; ?></td>
                                            <td><?php echo $group_total["$bloodbank_type->bloodbank_type_id"]["o_negative"]; ?></td>
                                            <td></td>
                                            <td><?php echo $group_total["$bloodbank_type->bloodbank_type_id"]["total"]; ?></td>                                        
                                        </tr>
                                        <?php
                                            foreach($bloodbank_sub_types as $bloodbank_sub_type){                                                
                                                if(array_key_exists("$bloodbank_sub_type->bloodbank_subtype", $subtypes_in_db) && array_key_exists("$bloodbank_type->bloodbank_type_id"."$bloodbank_sub_type->bloodbank_subtype", $combination_types_in_db)){

                                                }else{
                                                    continue;
                                                }
                                                ?>
                                        <tr class="info">  <!-- Inventory total by Second Level Grouping  -->
                                            <td><?php echo $bloodbank_sub_type->bloodbank_subtype_desc; ?></td>
                                            <td><?php echo $sub_group_total["$bloodbank_sub_type->bloodbank_subtype"]["a_positive"]; ?></td>
                                            <td><?php echo $sub_group_total["$bloodbank_sub_type->bloodbank_subtype"]["a_negative"]; ?></td>
                                            <td><?php echo $sub_group_total["$bloodbank_sub_type->bloodbank_subtype"]["ab_positive"]; ?></td>
                                            <td><?php echo $sub_group_total["$bloodbank_sub_type->bloodbank_subtype"]["ab_negative"]; ?></td>
                                            <td><?php echo $sub_group_total["$bloodbank_sub_type->bloodbank_subtype"]["b_positive"]; ?></td>
                                            <td><?php echo $sub_group_total["$bloodbank_sub_type->bloodbank_subtype"]["b_negative"]; ?></td>
                                            <td><?php echo $sub_group_total["$bloodbank_sub_type->bloodbank_subtype"]["o_positive"]; ?></td>
                                            <td><?php echo $sub_group_total["$bloodbank_sub_type->bloodbank_subtype"]["o_negative"]; ?></td>
                                            <td></td>
                                            <td><?php echo $sub_group_total["$bloodbank_sub_type->bloodbank_subtype"]["total"]; ?></td>                                        
                                        </tr>    
                                                <?php
                                                if(array_key_exists("$bloodbank_type->bloodbank_type_id"."$bloodbank_sub_type->bloodbank_subtype", $combination_types_in_db)){
            
                                                }else{
                                                    continue;
                                                }
                                                foreach($inventory_by_type_subtype["$bloodbank_type->bloodbank_type_id"]["$bloodbank_sub_type->bloodbank_subtype"] as $inventory){
                                                    $date = date("d-M-Y g:ia", strtotime($inventory->last_modified_time));
                                                    $date_updated = date_create($inventory->last_modified_time); 
                                                    $today = date_create(date("Y-m-d"));
                                                    $date_diff = date_diff($date_updated, $today);
                                                    
                                                    $last_updated_days = (int)$date_diff->format("%d");                                            
                                                    $last_updated_years = (int)$date_diff->format("%y");
                                                    
                                                    if($last_updated_days >= 20 || $last_updated_years > 0 || $total_by_bank["$inventory->bloodbank_id"]['total'] == 0){
                                                        $date = 'Not Available';
                                                    }
                                                    $last_updated_days = (int)$date_diff->format("%d");                                            
                                                    $last_updated_years = (int)$date_diff->format("%y");
                                                    $color = "style='background-color: #99ff99'";
                                                    if($last_updated_days >= 3 || $last_updated_years >0 || $total_by_bank["$inventory->bloodbank_id"]['total'] == 0){
                                                        $color = "style='background-color: #ff6666; color:white;'";
                                                    }else if($last_updated_days >= 2){
                                                        $color = "style='background-color: #ffc04c'";
                                                    }   
                                                    
                                                    ?>
                                        <tr class="success"> <!-- Inventory total by BloodBank Level Grouping  -->
                                            <td><?php echo $inventory->bloodbank_name; ?></td>
                                            <td><?php echo $inventory->a_positive; ?></td>
                                            <td><?php echo $inventory->a_negative; ?></td>
                                            <td><?php echo $inventory->ab_positive; ?></td>
                                            <td><?php echo $inventory->ab_negative; ?></td>
                                            <td><?php echo $inventory->b_positive; ?></td>
                                            <td><?php echo $inventory->b_negative; ?></td>
                                            <td><?php echo $inventory->o_positive; ?></td>
                                            <td><?php echo $inventory->o_negative; ?></td>
                                            <td><div class="img-rounded" <?php echo $color;?> ><small style="font-size:xx-small">&nbsp;&nbsp;<?php echo $date; ?></small></div></td>
                                            <td><?php echo $total_by_bank["$inventory->bloodbank_id"]['total']; ?></td>                                        
                                        </tr>                                                    
                                        <tr> <!-- Inventory total by Components  -->
                                            <!-- a_positive_prp, a_positive_platelet_concentrate, a_positive_pc, a_positive_wb, a_positive_cryo, a_positive_fp, a_positive_ffp --> 
                                            <td><?php echo 'PC'; ?></td>
                                            <td><?php echo $inventory->a_positive_pc; ?></td>
                                            <td><?php echo $inventory->a_negative_pc; ?></td>
                                            <td><?php echo $inventory->ab_positive_pc; ?></td>
                                            <td><?php echo $inventory->ab_negative_pc; ?></td>
                                            <td><?php echo $inventory->b_positive_pc; ?></td>
                                            <td><?php echo $inventory->b_negative_pc; ?></td>
                                            <td><?php echo $inventory->o_positive_pc; ?></td>
                                            <td><?php echo $inventory->o_negative_pc; ?></td>
                                            <td></td>
                                            <td><?php echo $total_component["$inventory->bloodbank_id"]['pc']; ?></td>                                        
                                        </tr>
                                        <tr> <!-- Inventory total by Components  -->
                                            <!-- a_positive_prp, a_positive_platelet_concentrate, a_positive_pc, a_positive_wb, a_positive_cryo, a_positive_fp, a_positive_ffp --> 
                                            <td><?php echo 'Platelet Concentrate'; ?></td>
                                            <td><?php echo $inventory->a_positive_platelet_concentrate; ?></td>
                                            <td><?php echo $inventory->a_negative_platelet_concentrate; ?></td>
                                            <td><?php echo $inventory->ab_positive_platelet_concentrate; ?></td>
                                            <td><?php echo $inventory->ab_negative_platelet_concentrate; ?></td>
                                            <td><?php echo $inventory->b_positive_platelet_concentrate; ?></td>
                                            <td><?php echo $inventory->b_negative_platelet_concentrate; ?></td>
                                            <td><?php echo $inventory->o_positive_platelet_concentrate; ?></td>
                                            <td><?php echo $inventory->o_negative_platelet_concentrate; ?></td>
                                            <td></td>
                                            <td><?php echo $total_component["$inventory->bloodbank_id"]['platelet_concentrate']; ?></td>                                        
                                        </tr>
                                        <tr> <!-- Inventory total by Components  -->
                                            <!-- a_positive_prp, a_positive_platelet_concentrate, a_positive_pc, a_positive_wb, a_positive_cryo, a_positive_fp, a_positive_ffp --> 
                                            <td><?php echo 'WB'; ?></td>
                                            <td><?php echo $inventory->a_positive_wb; ?></td>
                                            <td><?php echo $inventory->a_negative_wb; ?></td>
                                            <td><?php echo $inventory->ab_positive_wb; ?></td>
                                            <td><?php echo $inventory->ab_negative_wb; ?></td>
                                            <td><?php echo $inventory->b_positive_wb; ?></td>
                                            <td><?php echo $inventory->b_negative_wb; ?></td>
                                            <td><?php echo $inventory->o_positive_wb; ?></td>
                                            <td><?php echo $inventory->o_negative_wb; ?></td>
                                            <td></td>
                                            <td><?php echo $total_component["$inventory->bloodbank_id"]['wb']; ?></td>                                        
                                        </tr>
                                        <tr> <!-- Inventory total by Components  -->
                                            <!-- a_positive_prp, a_positive_platelet_concentrate, a_positive_pc, a_positive_wb, a_positive_cryo, a_positive_fp, a_positive_ffp --> 
                                            <td><?php echo 'Cryo'; ?></td>
                                            <td><?php echo $inventory->a_positive_cryo; ?></td>
                                            <td><?php echo $inventory->a_negative_cryo; ?></td>
                                            <td><?php echo $inventory->ab_positive_cryo; ?></td>
                                            <td><?php echo $inventory->ab_negative_cryo; ?></td>
                                            <td><?php echo $inventory->b_positive_cryo; ?></td>
                                            <td><?php echo $inventory->b_negative_cryo; ?></td>
                                            <td><?php echo $inventory->o_positive_cryo; ?></td>
                                            <td><?php echo $inventory->o_negative_cryo; ?></td>
                                            <td></td>
                                            <td><?php echo $total_component["$inventory->bloodbank_id"]['cryo']; ?></td>                                        
                                        </tr>
                                        <tr> <!-- Inventory total by Components  -->
                                            <!-- a_positive_prp, a_positive_platelet_concentrate, a_positive_pc, a_positive_wb, a_positive_cryo, a_positive_fp, a_positive_ffp --> 
                                            <td><?php echo 'FP'; ?></td>
                                            <td><?php echo $inventory->a_positive_fp; ?></td>
                                            <td><?php echo $inventory->a_negative_fp; ?></td>
                                            <td><?php echo $inventory->ab_positive_fp; ?></td>
                                            <td><?php echo $inventory->ab_negative_fp; ?></td>
                                            <td><?php echo $inventory->b_positive_fp; ?></td>
                                            <td><?php echo $inventory->b_negative_fp; ?></td>
                                            <td><?php echo $inventory->o_positive_fp; ?></td>
                                            <td><?php echo $inventory->o_negative_fp; ?></td>
                                            <td></td>
                                            <td><?php echo $total_component["$inventory->bloodbank_id"]['fp']; ?></td>                                        
                                        </tr>
                                        <tr> <!-- Inventory total by Components  -->
                                            <!-- a_positive_prp, a_positive_platelet_concentrate, a_positive_pc, a_positive_wb, a_positive_cryo, a_positive_fp, a_positive_ffp --> 
                                            <td><?php echo 'FFP'; ?></td>
                                            <td><?php echo $inventory->a_positive_ffp; ?></td>
                                            <td><?php echo $inventory->a_negative_ffp; ?></td>
                                            <td><?php echo $inventory->ab_positive_ffp; ?></td>
                                            <td><?php echo $inventory->ab_negative_ffp; ?></td>
                                            <td><?php echo $inventory->b_positive_ffp; ?></td>
                                            <td><?php echo $inventory->b_negative_ffp; ?></td>
                                            <td><?php echo $inventory->o_positive_ffp; ?></td>
                                            <td><?php echo $inventory->o_negative_ffp; ?></td>
                                            <td></td>
                                            <td><?php echo $total_component["$inventory->bloodbank_id"]['ffp']; ?></td>                                        
                                        </tr>
                                        <tr> <!-- Inventory total by Components  -->
                                            <!-- a_positive_prp, a_positive_platelet_concentrate, a_positive_pc, a_positive_wb, a_positive_cryo, a_positive_fp, a_positive_ffp --> 
                                            <td><?php echo 'PRP'; ?></td>
                                            <td><?php echo $inventory->a_positive_prp; ?></td>
                                            <td><?php echo $inventory->a_negative_prp; ?></td>
                                            <td><?php echo $inventory->ab_positive_prp; ?></td>
                                            <td><?php echo $inventory->ab_negative_prp; ?></td>
                                            <td><?php echo $inventory->b_positive_prp; ?></td>
                                            <td><?php echo $inventory->b_negative_prp; ?></td>
                                            <td><?php echo $inventory->o_positive_prp; ?></td>
                                            <td><?php echo $inventory->o_negative_prp; ?></td>
                                            <td></td>
                                            <td><?php echo $total_component["$inventory->bloodbank_id"]['prp']; ?></td>                                        
                                        </tr>
                                            
                                            <?php
                                                    
                                                } 
                                                
                                            }
                                            
                                        }?>
                                        <tr> <!-- Inventory total by Components  -->
                                            <!-- a_positive_prp, a_positive_platelet_concentrate, a_positive_pc, a_positive_wb, a_positive_cryo, a_positive_fp, a_positive_ffp --> 
                                            <td><?php echo "Total"; ?></td>
                                            <td><?php echo $total["a_positive"]; ?></td>
                                            <td><?php echo $total["a_negative"]; ?></td>
                                            <td><?php echo $total["ab_positive"]; ?></td>
                                            <td><?php echo $total["ab_negative"]; ?></td>
                                            <td><?php echo $total["b_positive"]; ?></td>
                                            <td><?php echo $total["b_negative"]; ?></td>
                                            <td><?php echo $total["o_positive"]; ?></td>
                                            <td><?php echo $total["o_negative"]; ?></td>
                                            <td></td>
                                            <td><?php echo $total["total"]; ?></td>                                        
              
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
    
</div>