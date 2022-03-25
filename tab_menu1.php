
<!--chart -->
<link rel="icon" type="image/x-icon" href="<?php echo $siteURL; ?>assets/img/favicon.ico"/>
<link href="<?php echo $siteURL; ?>assets/css/loader.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $siteURL; ?>assets/js/loader.js"></script>

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
<link href="<?php echo $siteURL; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $siteURL; ?>assets/css/plugins.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->
<link href="<?php echo $siteURL; ?>assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/styling/uniform.min.js"></script>
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/styling/switchery.min.js"></script>
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/components_dropdowns.js"></script>
<!--  BEGIN NAVBAR  -->
<?php
$path = '';
if(!empty($is_cell_login) && $is_cell_login == 1){
    $path = "../cell_line_dashboard.php";
}else{
    if(!empty($i) && ($is_tab_login != null)){
        $path = "../line_tab_dashboard.php";
    }else{
        $path = "../line_status_grp_dashboard.php";
    }
}
?>

<!--  END NAVBAR  -->
<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">


    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN TOPBAR  -->
        <div class="topbar-nav header navbar" role="banner">
            <nav id="topbar">
                <ul class="navbar-nav theme-brand flex-row  text-center">
                    <li class="nav-item theme-logo">
                        <a href="<?php echo $path?>">
                            <img src="<?php echo $siteURL; ?>assets/img/SGG_logo.png" class="navbar-logo" alt="logo">
                        </a>
                    </li>

                </ul>

                <ul class="list-unstyled menu-categories" id="topAccordion">

                    <li class="menu single-menu active">
                        <a href="#dashboard" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle autodroprown">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>Dashboard</span>
                            </div>
                        </a>
                        <?php
					$msg = $_SESSION["side_menu"];
					$msg = explode(',', $msg); ?>
                        <ul class="collapse submenu list-unstyled" id="dashboard" data-parent="#topAccordion">
                            <?php if($_SESSION['is_tab_user'] || $is_tab_login){?>
                            <li><a href="<?php echo $siteURL; ?>line_tab_dashboard.php"> Station Overview1 </a> </li>
                            <?php }else if($_SESSION['is_cell_login']){ ?>
                            <li><a href="<?php echo $siteURL; ?>cell_line_dashboard.php">Cell Station Overview </a> </li>
                            <?php }?>
                        </ul>
                    </li>

                    <li class="menu single-menu">
                        <a href="#app" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                                <span>Forms</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </a>
                        <?php
                        if (in_array('23', $msg)) {
                            ?>
                            <ul class="collapse submenu list-unstyled" id="app" data-parent="#topAccordion">
                                <?php
                                if (in_array('42', $msg)) {
                                    ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>form_module/form_settings.php"> Add/Create Form </a>
                                    </li>
                                    <?php
                                }
                                if (in_array('50', $msg)) {
                                    ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>form_module/edit_form_options.php"> Edit Form </a>
                                    </li>
                                    <?php
                                }
                                if (in_array('38', $msg)) {
                                    ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>form_module/options.php"> Submit Form </a>
                                    </li>
                                    <?php
                                }
                                if (in_array('44', $msg)) {
                                    ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>form_module/form_search.php">View Form</a>
                                    </li>
                                    <?php
                                }
                                if (in_array('60', $msg)) {
                                    ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>form_module/forms_recycle_bin.php">Restore Form</a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        <?php } ?>
                    </li>

                    <li class="menu single-menu">
                        <a href="#tables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span>Station Events</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </a><?php
                        if (in_array('45', $msg)) {
                            ?>
                            <ul class="collapse submenu list-unstyled" id="tables"  data-parent="#topAccordion">
                                <?php if (in_array('46', $msg)) { ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>events_module/station_events.php"> Add/Update Events </a>
                                    </li>
                                <?php } ?>

                            </ul>
                        <?php } ?>
                    </li>
                    <!--
                                        <li class="menu single-menu">
                                            <a href="#forms" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                                                    <span>Order</span>
                                                </div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                            </a>
                                            <ul class="collapse submenu list-unstyled" id="forms"  data-parent="#topAccordion">
                                                <li>
                                                    <a href="form_bootstrap_basic.html"> Create Order </a>
                                                </li>
                                                <li>
                                                    <a href="form_input_group_basic.html"> Historical Order </a>
                                                </li>

                                            </ul>
                                        </li> -->



                </ul>
            </nav>
        </div>
        <!--  END TOPBAR  -->


    </div>
    <!-- END MAIN CONTAINER -->
    <!--  BEGIN CONTENT PART  -->
    <!--    <div id="content" class="main-content">-->
    <!--        <div class="layout-px-spacing">-->
    <!--            <div class="page-header">-->
    <!--                <nav class="breadcrumb-one" aria-label="breadcrumb">-->
    <!--                    <ol class="breadcrumb">-->
    <!--                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboad</a></li>-->
    <!--                        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Analytics</a></li>-->
    <!--                    </ol>-->
    <!--                </nav>-->
    <!--                <div class="dropdown filter custom-dropdown-icon">-->
    <!--                    <a class="dropdown-toggle btn" href="#" role="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text"><span>Show</span> : Daily Analytics</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>-->
    <!---->
    <!--                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="filterDropdown">-->
    <!--                        <a class="dropdown-item" data-value="<span>Show</span> : Daily Analytics" href="javascript:void(0);">Daily Analytics</a>-->
    <!--                        <a class="dropdown-item" data-value="<span>Show</span> : Weekly Analytics" href="javascript:void(0);">Weekly Analytics</a>-->
    <!--                        <a class="dropdown-item" data-value="<span>Show</span> : Monthly Analytics" href="javascript:void(0);">Monthly Analytics</a>-->
    <!--                        <a class="dropdown-item" data-value="Download All" href="javascript:void(0);">Download All</a>-->
    <!--                        <a class="dropdown-item" data-value="Share Statistics" href="javascript:void(0);">Share Statistics</a>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <script>
        $(document).on("click", ".custom_switch", function () {
            var available_var = '<?php echo $available_var; ?>';
            $.ajax({
                url: "available.php",
                type: "post",
                data: {available_var: available_var},
                success: function (response) {
                    //alert(response);
                    console.log(response);
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });

        $(document).on("click", ".custom_switch_db", function () {
            var is_cust_dash = '<?php echo $is_cust_dash; ?>';
            $.ajax({
                url: "switch_cust_db.php",
                type: "post",
                data: {is_cust_dash: is_cust_dash},
                success: function (response) {
                    //alert(response);
                    console.log(response);
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
        //redirect ti chat page

        $( ".use1_namelist" ).click(function( event ) {
            $(".chat-list").html(" ");
            var user_id = $(this).data("id");
            var chat_id = $(this).attr("value");
            //alert(chat_id);
            $.ajax({
                type : 'POST',
                url : 'chatbot/chat_div.php',
                data : {
                    user_id : user_id,
                    chat_id : chat_id,
                },
                success : function(data) {
                    window.setTimeout(function(){
                        window.location.href = "chatbot/chat.php";

                    }, 10);

                }
            });
        });

        //notification status checking
        var data_interval = setInterval(function() {
            var id =  $("#login_id").val();
            //alert(data);
            $.ajax({
                url:"chatbot/status_count.php",
                method:"POST",
                data:{id:id},
                dataType : 'json',
                encode   : true,
                success:function(res)

                {

                    if(res > 0){
                        //alert(res);
                        $("#bell_icon").css('color','red');
                        //$("#bell_icon").css('margin-top','0px');
                        $("#bell_count").text(res);

                    }else{

                    }

                }
            });
        }, 1000);
    </script>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo $siteURL; ?>bootstrap/js/popper.min.js"></script>
    <script src="<?php echo $siteURL; ?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $siteURL; ?>plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo $siteURL; ?>assets/js/app.js"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="<?php echo $siteURL; ?>assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo $siteURL; ?>assets/js/dashboard/dash_2.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
