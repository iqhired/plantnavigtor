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
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="<?php echo $siteURL; ?>assets/css/menu.css" rel="stylesheet" type="text/css"/>
    <style>
        .navbar-brand > img {
            margin-top: 14px !important;
            height: 40px !important;
        }

        .navbar-nav > li {
            margin-left: 20px !important;
            float: left;
        }

        .show {
            display: grid !important;
        }

        /*.navbar{*/
        /*    z-index: 0!important;*/
        /*}*/
    </style>
</head>
<?php
$msg = $_SESSION["side_menu"];
$msg = explode(',', $msg); ?>
<!-- Mobile navigation -->
<nav class="d-block d-sm-none position-sticky top-0 z-index">
    <div class="w-100 bg-white shadow-sm text-light">
        <div class="btn-group d-flex justify-content-between p-2" role="group">
            <div>
                <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                        aria-controls="offcanvasRight">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                         class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                              d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </button>
            </div>


        </div>

    </div>
</nav>
<!-- Mobile navigation ends -->

<!-- Mobile navigation offcanvas menu -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-body">
        <?php if (in_array('23', $msg)) { ?>
            <div class="mobile-toggle">
                <a data-bs-toggle="collapse" href="#collapseC" role="button" aria-expanded="false"
                   aria-controls="collapseC">

                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                           stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                           class="lazyload blur-up mobile" style="float: left;">
                                        <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                        <polyline points="13 2 13 9 20 9"></polyline>
                                    </svg></span><span class="ms-2 fw-light">Dashboard</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="arrow">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </a>
                <div class="collapse my-2" id="collapseC">
                    <div class="ms-4">
                        <?php if($_SESSION['is_tab_user'] || $is_tab_login){?>
                            <div class="mt-3">
                                <a href="<?php echo $siteURL; ?>line_tab_dashboard.php"
                                   class="text-muted mobile">
                                    Station Overview1
                                </a>
                            </div>
                        <?php }else if($_SESSION['is_cell_login']){ ?>
                            <div class="mt-3">
                                <a href="<?php echo $siteURL; ?>cell_line_dashboard.php"
                                   class="text-muted mobile">
                                    Cell Station Overview
                                </a>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if (in_array('23', $msg)) { ?>
            <div class="mobile-toggle">
                <a data-bs-toggle="collapse" href="#collapseC" role="button" aria-expanded="false"
                   aria-controls="collapseC">

                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                           stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                           class="lazyload blur-up mobile" style="float: left;">
                                        <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                        <polyline points="13 2 13 9 20 9"></polyline>
                                    </svg></span><span class="ms-2 fw-light">Forms</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="arrow">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </a>
                <div class="collapse my-2" id="collapseC">
                    <div class="ms-4">
                        <?php if (in_array('42', $msg)) { ?>
                            <div class="mt-3">
                                <a href="<?php echo $siteURL; ?>form_module/form_settings.php"
                                   class="text-muted mobile">
                                    Add/Create Form
                                </a>
                            </div>
                        <?php }
                        if (in_array('50', $msg)) { ?>
                            <div class="mt-3">
                                <a href="<?php echo $siteURL; ?>form_module/edit_form_options.php"
                                   class="text-muted mobile">
                                    Edit Form
                                </a>
                            </div>
                        <?php }
                        if (in_array('38', $msg)) { ?>
                            <div class="mt-3">
                                <a href="<?php echo $siteURL; ?>form_module/options.php" class="text-muted mobile">
                                    Submit Form
                                </a>
                            </div>
                        <?php }
                        if (in_array('44', $msg)) { ?>
                            <div class="mt-3">
                                <a href="<?php echo $siteURL; ?>form_module/form_search.php" class="text-muted mobile">
                                    View Form
                                </a>
                            </div>
                        <?php }
                        if (in_array('60', $msg)) { ?>
                            <div class="mt-3">
                                <a href="<?php echo $siteURL; ?>form_module/forms_recycle_bin.php"
                                   class="text-muted mobile">
                                    Restore Form
                                </a>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if (in_array('45', $msg)) { ?>
            <div class="mobile-toggle">
                <a data-bs-toggle="collapse" href="#collapseCpp" role="button" aria-expanded="false"
                   aria-controls="collapseCpp">

                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                           stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                           class="lazyload blur-up mobile" style="float: left;">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="3" y1="9" x2="21" y2="9"></line>
                                        <line x1="9" y1="21" x2="9" y2="9"></line>
                                    </svg></span><span class="ms-2 fw-light">Station Events</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="arrow">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </a>
                <div class="collapse my-2" id="collapseCpp">
                    <div class="ms-4">
                        <?php if (in_array('46', $msg)) { ?>
                            <div class="mt-3">
                                <a href="<?php echo $siteURL; ?>events_module/station_events.php"
                                   class="text-muted mobile">
                                    Add/update Events
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>



    </div>

</div>
<!-- Mobile navigation offcanvas menu ends -->

<!-- Desktop navigation -->
<nav class="d-none d-sm-block navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if (in_array('23', $msg)) { ?>
                    <li class="nav-item" id="ic">
                        <a class="nav-link">Dashboard
                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow" viewBox="0 0 20 20"
                                 style="margin-left: 86px;">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </a>
                        <div class="menu ">
                            <ul>
                                <?php if($_SESSION['is_tab_user'] || $is_tab_login){ ?>
                                    <li><a href="<?php echo $siteURL; ?>line_tab_dashboard.php"> Station Overview1 </a> </li>
                                <?php }else if($_SESSION['is_cell_login']){ ?>
                                    <li><a href="<?php echo $siteURL; ?>cell_line_dashboard.php">Cell Station Overview </a> </li>
                                <?php }?>

                            </ul>
                        </div>
                    </li>
                <?php } ?>
                <!-- Forms Menu -->
                <?php if (in_array('23', $msg)) { ?>
                    <li class="nav-item" id="ic">
                        <a class="nav-link">Forms
                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow" viewBox="0 0 20 20"
                                 style="margin-left: 54px;">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </a>
                        <div class="menu ">
                            <ul>
                                <?php if (in_array('42', $msg)) { ?>
                                    <li><a href="<?php echo $siteURL; ?>form_module/form_settings.php">Add/Create
                                            Form</a></li>
                                <?php }
                                if (in_array('50', $msg)) { ?>
                                    <li><a href="<?php echo $siteURL; ?>form_module/edit_form_options.php">Edit Form</a>
                                    </li>
                                <?php }
                                if (in_array('38', $msg)) { ?>
                                    <li><a href="<?php echo $siteURL; ?>form_module/options.php">Submit Form</a></li>
                                <?php }
                                if (in_array('44', $msg)) { ?>
                                    <li><a href="<?php echo $siteURL; ?>form_module/form_search.php">View Form</a></li>
                                <?php }
                                if (in_array('60', $msg)) { ?>
                                    <li><a href="<?php echo $siteURL; ?>form_module/forms_recycle_bin.php">Restore
                                            Form</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                <?php } ?>

                <?php if (in_array('45', $msg)) { ?>
                    <li class="nav-item" id="ic">
                        <a class="nav-link" href="#">Station Events
                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow" viewBox="0 0 20 20"
                                 style="margin-left: 112px;">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </a>
                        <div class="menu ">
                            <ul>
                                <?php if (in_array('46', $msg)) { ?>
                                    <li><a href="<?php echo $siteURL; ?>events_module/station_events.php">Add/Update
                                            Events</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                <?php } ?>


        </div>

    </div>
    <!-- end mega nav bar-->
    </li>



    </ul>

    </div>
    </div>
</nav>
<script>

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

