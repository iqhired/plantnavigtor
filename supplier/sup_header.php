<?php
include("./../sup_config.php");
/*$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
		"https" : "http") . "://" . $_SERVER['HTTP_HOST'];
$iid = $_SESSION["id"];*/

?>
<script type="text/javascript" src = "<?php echo $link . "/assets/js/plugins/forms/styling/uniform.min.js"?>"></script>
<script type="text/javascript" src="<?php echo $link . "/assets/js/plugins/forms/styling/switchery.min.js"?>"></script>
<script type="text/javascript" src="<?php echo $link . "/assets/js/pages/components_dropdowns.js"?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
    .header {
        overflow: hidden;
        background-color: #060818;
        padding: 8px 25px;
    }

    .header a {
        /*float: left;*/
        color: #fff5f5;
        /*text-align: center;*/
        padding: 2px;
        text-decoration: none;
        font-size: 14px;
        line-height: 25px;
        border-radius: 4px;
    }

    .header a.logo {
        font-size: 25px;
        font-weight: bold;
    }

    /*.header a:hover {*/
    /*    background-color: #ddd;*/
    /*    color: black;*/
    /*}*/

    .header a.active {
        background-color: dodgerblue;
        color: white;
    }

    .header-right {
        float: right;
        margin-top: 5.5px;
    }

    @media screen and (max-width: 500px) {
        .header a {
            float: none;
            display: block;
            text-align: left;
        }

        .header-right {
            float: right;
            margin-top: -28px;
        }
        .logo_img {
            height: auto;
            width: 80px!important;
        }
        img.dropbtn_img {
            height: auto;
            width: 25px!important;
            border-radius: 4px;

        }
        .dropbtn{
            font-size: 12px!important;
        }
        svg.arrow.dropbtn {
            margin-left: 94px!important;
            margin-top: -18px!important;
        }

    }
    .dropbtn {
        background-color: #060818;
        color: white;
        /*padding: 16px;*/
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    /*.dropbtn:hover, .dropbtn:focus {*/
    /*    background-color: #2980B9;*/
    /*}*/

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: fixed;
        background-color: #191e3a;
        min-width: 160px;
        overflow: auto;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 9999;
        border-radius: 6px;
    }

    .dropdown-content a {
        color: #fff5f5;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        border-bottom: 1px solid #524d4d;
    }
    .logo_img{
        height: auto;
        width: 150px;
    }
    img.dropbtn_img {
        height: auto;
        width: 28px!important;
        border-radius: 4px;
    }


    /*.dropdown a:hover {background-color: #ddd;}*/

    .show {display: block;}
</style>
<script>
    /* When the user clicks on the button,
    toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>


<style>
	.sidebar-default .navigation li>a{color:#f5f5f5};
	<!--  a:hover {
			  background-color: #20a9cc;
		  } -->
	.sidebar-default .navigation li>a:focus, .sidebar-default .navigation li>a:hover {
		background-color: #20a9cc;
	}

	.avilable, .logout, .away ,.dot{
		height: 25px;
		width: 25px;
		border-radius: 50%;
		display: inline-block;
		float: right;
		margin-top: -4px;

	}
	.avilable{ background-color: green;}
	.dot{

		float: right;
		margin-top: 5px;
		margin-right: 21px;}

	.logout{ background-color: red;}
	.away{ background-color: orange;}
	.card{
		width: 19rem;
		float: right;
		margin-top: 0px;
		background: white;
		border-radius: 9px;
		height: 132px;
		font-size: 15px;
		float: right;
		display: none;
		border: 2px solid #1b67ab;
	}
	#status{
		width: auto;
		border-radius: 10px;
		margin-right: 10px;
		background: #1e73be;
	}
	.head{
		font-size: 17px;
		font-weight: 500;
		color: black;
		background: #bdbcbc;
		font-style: oblique;
	}
	a{
		color: black;


	}

	/* CSS used here will be applied after bootstrap.css */

	.dropdown {
		display:inline-block;
		margin-left:20px;
		padding:0px;
	}


	.glyphicon-bell {
		font-size: 19px;
		margin-top: 17px;
	}

	.notifications {
		min-width:420px;
	}

	.notifications-wrapper {
		overflow:auto;
		max-height:250px;
	}

	.menu-title {
		color:#ff7788;
		font-size:1.5rem;
		display:inline-block;
	}

	.glyphicon-circle-arrow-right {
		margin-left:10px;

	}


	.notification-heading, .notification-footer  {
		padding:2px 10px;
	}


	.dropdown-menu.divider {
		margin:5px 0;
	}

	.item-title {

		font-size:1.3rem;
		color:#000;

	}

	.notifications a.content1 {
		text-decoration:none;
		background:#ccc;

	}

	.notification-item {
		padding:10px;
		margin:5px;
		background:#ccc;
		border-radius:4px;
	}
	a.logo_a:hover {
		background-color: unset;
	}
    .logo_img{
        height: auto;
        width: 195px!important;
    }
</style>
<div class="navbar navbar-inverse " style="background-color:#191e3a;">
	<div class="navbar-header" style="background-color:#f7f7f7;">
        <a href="#" class="logo">
            <img src="<?php echo $link; ?>/assets/images/SGG_logo.png"  class = "logo_img" alt="logo">
        </a>
		<ul class="nav navbar-nav visible-xs-block">
			<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
		</ul>
	</div>
	<div class="navbar-collapse collapse" id="navbar-mobile">
		<!--			collaps code-->
		<!--			<ul class="nav navbar-nav nav-collapse">-->
		<!--				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>-->
		<!--			</ul>-->
		<div class="col-md-3"></div>
		<div class="navbar-center col-md-3">
			<h3 id="screen_header" style=""><span class="text-semibold"><?php echo $cam_page_header; ?></span></h3>
		</div>
		<div class="navbar-right">
			<ul class="nav navbar-nav">
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="user_images/<?php echo $_SESSION["uu_img"]; ?>" alt="">
						<span><?php echo $_SESSION['fullname']; ?></span>
						<i class="caret"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="javascript:void(0)"><i class="icon-user-plus"></i> My profile</a></li>
						<li><a href="javascript:void(0)"><i class="icon-cog5"></i> Change Password</a></li>
						<li><a href="../logout.php"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>