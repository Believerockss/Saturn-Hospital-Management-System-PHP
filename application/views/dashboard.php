<!-- begin #content -->
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item active">Dashboard</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Welcome to <?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_name'))->row()->content); ?> <small><?php echo date('d F, Y'); ?></small></h1>
	<!-- end page-header -->

	<!-- begin row -->
	<div class="row">
		<!-- begin col-3 -->
		<div class="col-lg-2 col-md-6">
			<div class="widget widget-stats bg-yellow ">
				<div class="stats-icon"><i class="fa fa-user-md"></i></div>
				<div class="stats-info">
					<h4 class="text-black"><b>Doctors</b></h4>
					<p class="text-black"><?php echo html_escape($this->security->xss_clean($this->db->get('doctor')->num_rows())); ?></p>
				</div>
				<div class="stats-link">
					<a href="<?php echo base_url(); ?>staff_categories">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-lg-2 col-md-6">
			<div class="widget widget-stats bg-yellow">
				<div class="stats-icon"><i class="fa fa-user"></i></div>
				<div class="stats-info">
					<h4 class="text-black"><b>Staff</b></h4>
					<p class="text-black"><?php echo html_escape($this->security->xss_clean($this->db->get('staff')->num_rows())); ?></p>
				</div>
				<div class="stats-link">
					<a href="<?php echo base_url(); ?>staff_categories">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-lg-2 col-md-6">
			<div class="widget widget-stats bg-yellow">
				<div class="stats-icon"><i class="fa fa-users"></i></div>
				<div class="stats-info">
					<h4 class="text-black"><b>Patients</b></h4>
					<p class="text-black"><?php echo html_escape($this->security->xss_clean($this->db->get('patient')->num_rows())); ?></p>
				</div>
				<div class="stats-link">
					<a href="<?php echo base_url(); ?>patients">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-lg-2 col-md-6">
			<div class="widget widget-stats bg-yellow">
				<div class="stats-icon"><i class="fa fa-building"></i></div>
				<div class="stats-info">
					<h4 class="text-black"><b>Accommodations</b></h4>
					<p class="text-black"><?php echo html_escape($this->security->xss_clean($this->db->get('accommodation')->num_rows()) + $this->security->xss_clean($this->db->get('bed')->num_rows())); ?></p>
				</div>
				<div class="stats-link">
					<a href="<?php echo base_url(); ?>accommodation_categories">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->

		<!-- begin col-3 -->
		<div class="col-lg-2 col-md-6">
			<div class="widget widget-stats bg-yellow">
				<div class="stats-icon"><i class="fa fa-heartbeat"></i></div>
				<div class="stats-info">
					<h4 class="text-black"><b>Laboratories</b></h4>
					<p class="text-black"><?php echo html_escape($this->security->xss_clean($this->db->get('laboratory')->num_rows())); ?></p>
				</div>
				<div class="stats-link">
					<a href="<?php echo base_url(); ?>laboratories">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-lg-2 col-md-6">
			<div class="widget widget-stats bg-yellow">
				<div class="stats-icon"><i class="fa fa-file"></i></div>
				<div class="stats-info">
					<h4 class="text-black"><b>Reports</b></h4>
					<p class="text-black"><?php echo html_escape($this->security->xss_clean($this->db->get('report')->num_rows())); ?></p>
				</div>
				<div class="stats-link">
					<a href="<?php echo base_url(); ?>reports">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-lg-2 col-md-6">
			<div class="widget widget-stats bg-yellow">
				<div class="stats-icon"><i class="fa fa-life-ring"></i></div>
				<div class="stats-info">
					<h4 class="text-black"><b>Blood Donors</b></h4>
					<p class="text-black"><?php echo html_escape($this->security->xss_clean($this->db->get('blood_donor')->num_rows())); ?></p>
				</div>
				<div class="stats-link">
					<a href="<?php echo base_url(); ?>blood_donors">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-lg-2 col-md-6">
			<div class="widget widget-stats bg-yellow">
				<div class="stats-icon"><i class="fa fa-hospital"></i></div>
				<div class="stats-info">
					<h4 class="text-black"><b>Blood Requests</b></h4>
					<p class="text-black"><?php echo html_escape($this->security->xss_clean($this->db->get('blood_request')->num_rows())); ?></p>
				</div>
				<div class="stats-link">
					<a href="<?php echo base_url(); ?>blood_requests">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-lg-2 col-md-6">
			<div class="widget widget-stats bg-yellow">
				<div class="stats-icon"><i class="fa fa-bed"></i></div>
				<div class="stats-info">
					<h4 class="text-black"><b>Occupancies</b></h4>
					<p class="text-black"><?php echo html_escape($this->security->xss_clean($this->db->get('occupancy')->num_rows())); ?></p>
				</div>
				<div class="stats-link">
					<a href="<?php echo base_url(); ?>occupancies">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-lg-2 col-md-6">
			<div class="widget widget-stats bg-yellow">
				<div class="stats-icon"><i class="fa fa-home"></i></div>
				<div class="stats-info">
					<h4 class="text-black"><b>Discharges</b></h4>
					<p class="text-black"><?php echo html_escape($this->security->xss_clean($this->db->get('discharge')->num_rows())); ?></p>
				</div>
				<div class="stats-link">
					<a href="<?php echo base_url(); ?>discharges">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-lg-2 col-md-6">
			<div class="widget widget-stats bg-yellow">
				<div class="stats-icon"><i class="fa fa-address-book"></i></div>
				<div class="stats-info">
					<h4 class="text-black"><b>Appointments</b></h4>
					<p class="text-black"><?php echo html_escape($this->security->xss_clean($this->db->get('appointment')->num_rows())); ?></p>
				</div>
				<div class="stats-link">
					<a href="<?php echo base_url(); ?>appointments">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-lg-2 col-md-6">
			<div class="widget widget-stats bg-yellow">
				<div class="stats-icon"><i class="fa fa-credit-card"></i></div>
				<div class="stats-info">
					<h4 class="text-black"><b>Invoices</b></h4>
					<p class="text-black"><?php echo html_escape($this->security->xss_clean($this->db->get('invoice')->num_rows())); ?></p>
				</div>
				<div class="stats-link">
					<a href="<?php echo base_url(); ?>invoices">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-lg-2 col-md-6">
			<div class="widget widget-stats bg-yellow">
				<div class="stats-icon"><i class="fa fa-ambulance"></i></div>
				<div class="stats-info">
					<h4 class="text-black"><b>Transports</b></h4>
					<p class="text-black"><?php echo html_escape($this->security->xss_clean($this->db->get('transport')->num_rows())); ?></p>
				</div>
				<div class="stats-link">
					<a href="<?php echo base_url(); ?>transport_categories">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-lg-2 col-md-6">
			<div class="widget widget-stats bg-yellow">
				<div class="stats-icon"><i class="fa fa-id-badge"></i></div>
				<div class="stats-info">
					<h4 class="text-black"><b>Certificates</b></h4>
					<p class="text-black"><?php echo html_escape($this->security->xss_clean($this->db->get('certificate')->num_rows())); ?></p>
				</div>
				<div class="stats-link">
					<a href="<?php echo base_url(); ?>certificates">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-lg-2 col-md-6">
			<div class="widget widget-stats bg-yellow">
				<div class="stats-icon"><i class="fa fa-podcast"></i></div>
				<div class="stats-info">
					<h4 class="text-black"><b>Notices</b></h4>
					<p class="text-black"><?php echo html_escape($this->security->xss_clean($this->db->get('notice')->num_rows())); ?></p>
				</div>
				<div class="stats-link">
					<a href="<?php echo base_url(); ?>notices">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-lg-2 col-md-6">
			<div class="widget widget-stats bg-yellow">
				<div class="stats-icon"><i class="fa fa-comments"></i></div>
				<div class="stats-info">
					<h4 class="text-black"><b>Feedback & Ratings</b></h4>
					<p class="text-black"><?php echo html_escape($this->security->xss_clean($this->db->get('feedback')->num_rows()) + $this->security->xss_clean($this->db->get('rating')->num_rows())); ?></p>
				</div>
				<div class="stats-link">
					<a href="<?php echo base_url(); ?>feedback_and_ratings">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
		<!-- begin col-3 -->
		<div class="col-lg-2 col-md-6">
			<div class="widget widget-stats bg-yellow">
				<div class="stats-icon"><i class="fa fa-life-ring"></i></div>
				<div class="stats-info">
					<h4 class="text-black"><b>Tickets</b></h4>
					<p class="text-black"><?php echo html_escape($this->security->xss_clean($this->db->get('ticket')->num_rows())); ?></p>
				</div>
				<div class="stats-link">
					<a href="<?php echo base_url('tickets'); ?>">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- end col-3 -->
	</div>
	<!-- end row -->
</div>
<!-- end #content -->