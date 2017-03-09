<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Tables</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">                        
                    <div class="panel-heading">
                            Context Classes
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Blood Bank Name</th>
                                            <th>District</th>
                                            <th>Address</th>
                                            <th>Land Line/Mobile</th>                                            
                                            <th>Staff Login</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; 
                                            foreach($bloodbanks as $bloodbank){
                                        ?>
                                        <tr class="<?php if($i%2 == 0){ echo "success"; }else{ echo "info"; }?>">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $bloodbank->bloodbank_name; ?></td>
                                            <td><?php echo $bloodbank->district; ?></td>
                                            <td><?php echo $bloodbank->address; ?></td>
                                            <td><?php echo $bloodbank->land_line.'/'.$bloodbank->mobile; ?></td>
                                            <td><a class="btn btn-default" target="_blank" href="<?php echo $bloodbank->application_url; ?>" role="button">Login</a></td>
                                        </tr>
                                            <?php 
                                            $i++;
                                        }?>                                       
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                </div>
            </div>
</div>



                        
</div>  <!-- Page wrapper end -->
