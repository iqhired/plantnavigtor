<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
	.menu-bttn {
		background: none !important;
		border: none;
		padding: 0 !important;
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
		<div class="sidebar-category sidebar-category-visible">
			<div class="category-content no-padding">
				<ul class="navigation navigation-main navigation-accordion" style="padding:0px 0;">
					<br/>
					<!--                    <li><a href="../dashboard.php"><i class="icon-home4"></i> <span>Dashboard</span></a></li>-->
					<li>
						<a href="#"><i class="icon-home4"></i><span>Dashboards</span></a>
						<ul>
							<li>
                                <?php if($_SESSION['is_tab_user'] || $is_tab_login){?>
                                    <a href="../line_tab_dashboard.php"><span>Station Overview1</span></a>
								<?php }else if($_SESSION['is_cell_login']){ ?>
                                    <a href="../cell_line_dashboard.php"><span>Cell Station Overview</span></a>
								<?php }?>
							</li>
						</ul>
					</li>
					<?php
					$msg = $_SESSION["side_menu"];
					$msg = explode(',', $msg);
					/*Forms*/
					if (in_array('23', $msg)) {
						?>
						<li>
							<a href="#"><i class="icon-magazine"></i><span>Forms</span></a>
							<ul>
								<?php
								if (in_array('42', $msg)) {
									?>
									<li><a href="../form_module/form_settings.php"><span>Add / Create Form </span></a>
									</li>
									<?php
								}
								if (in_array('50', $msg)) {
									?>
									<li><a href="../form_module/edit_form_options.php"><span>Edit Form</span></a>
									</li>
									<?php
								}
								if (in_array('38', $msg)) {
									?>
									<li><a href="../form_module/options.php<?php if($is_tab_login){echo "?station=".$tab_line; }?>"><span>Submit Form</span></a>
									</li>
									<?php
								}
								if (in_array('44', $msg)) {
									?>
									<li><a href="../form_module/form_search.php"><span>View Form </span></a>
									</li>
									<?php
								}
								if (in_array('49', $msg)) {
									?>
									<li><a href="../form_module/pending_approval_list.php"><span>Pending Approval </span></a>
									</li>
									<?php
								}
								if (in_array('60', $msg)) {
									?>
									<li><a href="../form_module/forms_recycle_bin.php"><span>Restore Form</span></a>
									</li>
									<?php
								}
								?>
							</ul>
						</li>
						<?php
					}
					/*Station Events*/
					if (in_array('45', $msg)) {
						?>
						<li>
							<a href="#"><i class="icon-magazine"></i><span>Station Events</span></a>
							<ul>
								<?php
								if (in_array('46', $msg)) {
									?>
									<li><a href="../events_module/station_events.php"><span>Add / Update Events</span></a></li>
									<?php
								}
								?>
							</ul>
						</li>
						<?php
					}
					?>

					<!-- /main -->
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