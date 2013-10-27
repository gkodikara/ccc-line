<div class="menu-topbar row-fluid">
	<div class="pull-left menu-logo">
		<a href="javascript:void(0);">
			<img src="<?= base_url(); ?>assets/img/internal/logo_mini.png"/>
		</a>
	</div>
<ul class="nav nav-pills pull-left">
	<li><a href="<?= base_url(); ?>index.php/referrers">Referrers</a></li>
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Calls <b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li><a href="<?= base_url(); ?>index.php/questions/new_call">Log New Call</a></li>
			<li><a href="<?= base_url(); ?>index.php/questions/show_questions">Show All Entries</a></li>
		</ul>
	</li>
	<li><a href="<?= base_url(); ?>index.php/averagecall">Reports</a></li>
</ul>
	<div class="account-box pull-right">
		<span>Welcome <?php echo $username; ?>!</span>
		<a class="btn" href="home/logout"><i class="icon-off"></i> Logout</a>
	</div>
</div>

