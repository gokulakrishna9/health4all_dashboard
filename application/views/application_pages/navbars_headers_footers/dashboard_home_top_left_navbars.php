<style>
    background {
        color: blue;
    }
</style>

<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">   <!--  Inside Level Zero. Header and leftnav wrapper Wrapper Header and Sidebar -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html">Telangana Vaidya Vidhana Parishad</a>
    </div>
    <!-- /.navbar-header -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li <?php if(preg_match("^/$^",current_url())) echo 'style="background-color: orange"'; ?> >
                    <a href="<?php echo base_url();?>"><i class="fa fa-dashboard fa-fw"></i>Dashboard</a>
                </li>
                <li <?php if(preg_match("^welcome/hospital_login$^",current_url())) echo 'style="background-color: orange"'; ?> >
                    <a href="<?php echo base_url();?>welcome/hospital_login"><i class="fa fa-edit fa-fw"></i>Hospital Login</a>
                </li>
                <li <?php if(preg_match("^welcome/get_department_charts^",current_url())) echo 'style="background-color: orange"';?> >
                    <a href="<?php echo base_url();?>welcome/get_department_charts"><i class="fa fa-bar-chart-o fa-fw"></i>Hospital Summary Reports<span class="fa arrow"></span></a>
                </li>
                <li>
                    <a href="http://dmetelangana.in/" target="_blank">DME Telangana</a>
                </li>
                <li>
                    <a href="http://tsbloodcell.in/" target="_blank">TS Blood Cell</a>
                </li>
            </ul>
        </div>
             <!-- /.sidebar-collapse -->
    </div>
             <!-- /.navbar-static-side -->
</nav>       <!--  End Inside Level Zero. Header and leftnav wrapper Wrapper Header and Sidebar -->


<script>
    /* angular.module('h4aDashboardNavbar', [])
        .controller('LeftNavCtrl', ['$http', function($http) {
    }]); */
</script>