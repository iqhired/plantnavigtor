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
</style>
<?php
//session_start();
?>
<div class="sidebar sidebar-main sidebar-default" style="background-color:#1a4a73;width:210px;">
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