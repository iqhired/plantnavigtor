<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
	.menu-bttn {
		background: none!important;
		border: none;
		padding: 0!important;
		/*optional*/
		font-family: arial, sans-serif;
		/*input has OS specific font-family*/
		color: white;
		cursor: pointer;
	}
    .icon-home4{
        color: white;
    }
</style>
<?php
//session_start();
?>
<div class="sidebar sidebar-main sidebar-default" style="background-color:#191e3a;width:210px;">
	<div class="sidebar-content">
		<div class="sidebar-category sidebar-category-visible"  >
			<div class="category-content no-padding">
				<ul class="navigation navigation-main navigation-accordion" style="padding:0px 0;">
					<br/>
					<li><a href="<?php echo $link . "/supplier/supplier_home.php" ?>"><i class="icon-home4"></i> <span>Active Order(s)</span></a></li>
					<li><a href="<?php echo $link . "/supplier/orders/orders_history.php" ?>"><i class="icon-home4"></i> <span>Historical Order(s)</span></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<style>
	html, body {
		max-width: 100%;
		overflow-x: hidden;
	}
</style>
<style>
    body {
        margin: 0;
        font-family: "Lato", sans-serif;
    }

    .sidebar {
        margin: 0;
        padding: 0;
        width: 200px;
        background-color: #f1f1f1;
        position: fixed;
        height: 100%;
        overflow: auto;
    }

    .sidebar a {
        display: block;
        color: black;
        padding: 16px;
        text-decoration: none;
    }

    .sidebar a.active {
        background-color: #04AA6D;
        color: white;
    }

    .sidebar a:hover:not(.active) {
        background-color: #555;
        color: white;
    }

    div.content {
        margin-left: 200px;
        padding: 1px 16px;
        height: 1000px;
    }

    @media screen and (max-width: 700px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }
        .sidebar a {float: left;}
        div.content {margin-left: 0;}
    }

    @media screen and (max-width: 400px) {
        .sidebar a {
            text-align: center;
            float: none;
        }
    }
</style>