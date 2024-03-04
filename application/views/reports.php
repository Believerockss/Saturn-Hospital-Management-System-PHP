<!-- begin #content -->
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
		<li class="breadcrumb-item active"><?php echo $this->security->xss_clean($page_title); ?></li>
	</ol>
	<!-- end breadcrumb -->
	<?php if ($this->session->userdata('user_type') == 'staff'): ?>
	<!-- begin page-header -->
	<h1 class="page-header">
		<div class="btn-group">
			<a href="javascript:;" data-toggle="dropdown" class="btn btn-inverse dropdown-toggle" aria-expanded="false">
				<i class="fa fa-plus"></i> Add Report
			</a>
			<ul class="dropdown-menu pull-right">
				<li>
					<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_report_patient');" href="javascript:;">Existing Patient</a>
				</li>
				<li>
					<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_report_customer');" href="javascript:;">New Customer</a>
				</li>
			</ul>
		</div>
	</h1>
	<!-- end page-header -->
	<?php else: ?>
	<!-- begin page-header -->
	<h1 class="page-header">
		Your Report Details
	</h1>
	<!-- end page-header -->
	<?php endif; ?>

	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-md-12">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<div class="panel-body">
					<table id="data-table-buttons" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Patient</th>
								<th>Mobile Number</th>
								<th>Cost (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
								<th>Status</th>
								<th>Discount</th>
								<th>Doctor</th>
								<th>Delivery Date</th>
								<th>Created On</th>
								<th>Created By</th>
								<th>Updated On</th>
								<th>Updated By</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 1;
							$this->db->order_by('timestamp', 'desc');
							if ($this->session->userdata('user_type') == 'staff') {
								$reports = $this->db->get('report')->result_array();
							} else {
								$reports = $this->db->get_where('report', array('patient_id' => $this->session->userdata('user_id')))->result_array();
							}
							foreach ($reports as $row) :
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<?php if ($row['is_patient']) : ?>
										<td>
											<?php
												if ($this->db->get_where('patient', array('patient_id' => $row['patient_id']))->num_rows() > 0)
													echo $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->name);
												else
													echo 'Patient not found.';
											?>
										</td>
										<td>
											<?php 
												if ($this->db->get_where('patient', array('patient_id' => $row['patient_id']))->num_rows() > 0)
													echo $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->mobile_number);
												else
													echo 'Mobile Number not found.';
											?>
										</td>
									<?php else : ?>
										<td><?php echo $row['customer_name']; ?></td>
										<td><?php echo $row['customer_mobile']; ?></td>
									<?php endif; ?>
									<td><?php echo $row['grand_total']; ?></td>
									<td>
										<?php
										if ($row['status'] == 0)
											echo '<span class="badge badge-warning">Pending</span>';
										elseif ($row['status'] == 1)
											echo '<span class="badge badge-success">Completed</span>';
										else
											echo '<span class="badge badge-danger">Cancelled</span>';
										?>
									</td>
									<td>
										<?php
										if ($row['discount'])
											echo $row['discount'] . '%';
										else
											echo '-';
										?>
									</td>
									<td>
										<?php
											if ($this->db->get_where('doctor', array('doctor_id' => $row['doctor_id']))->num_rows() > 0)
												echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $row['doctor_id']))->row()->name); 
											else 
												echo 'Doctor not found.';
										?>
									</td>
									<td><?php echo date('d M, Y', $row['delivery_date']); ?></td>
									<td><?php echo date('d M, Y', $row['created_on']); ?></td>
									<td>
										<?php
										if ($this->db->get_where('user', array('user_id' => $row['created_by']))->num_rows() > 0) {
											$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['created_by']))->row()->staff_id);
											$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['created_by']))->row()->is_doctor);

											if ($is_doctor) {
												if ($this->db->get_where('doctor', array('doctor_id' => $staff_id))->num_rows() > 0)
													echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $staff_id))->row()->name);
												else 
													echo 'Doctor not found.';
											} else {
												if ($this->db->get_where('staff', array('staff_id' => $staff_id))->num_rows() > 0)
													echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $staff_id))->row()->name);
												else
													echo 'Staff not found.';
											}											
										} else {
											echo 'Created By not found.';
										}
										?>
									</td>
									<td><?php echo date('d M, Y', $row['timestamp']); ?></td>
									<td>
										<?php
										if ($this->db->get_where('user', array('user_id' => $row['updated_by']))->num_rows() > 0) {
											$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['updated_by']))->row()->staff_id);
											$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['updated_by']))->row()->is_doctor);

											if ($is_doctor) {
												if ($this->db->get_where('doctor', array('doctor_id' => $staff_id))->num_rows() > 0)
													echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $staff_id))->row()->name);
												else 
													echo 'Doctor not found.';
											} else {
												if ($this->db->get_where('staff', array('staff_id' => $staff_id))->num_rows() > 0)
													echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $staff_id))->row()->name);
												else
													echo 'Staff not found.';
											}											
										} else {
											echo 'Updated By not found.';
										}
										?>
									</td>
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-white btn-xs">Action</button>
											<button type="button" class="btn btn-white btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_view_report_details/<?php echo $row['report_id']; ?>');" href="javascript:;">Show Details</a>
												<?php if ($this->session->userdata('user_type') == 'staff'): ?>
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_report_details/<?php echo $row['report_id']; ?>');" href="javascript:;">Edit Details</a>
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_report_status/<?php echo $row['report_id']; ?>');" href="javascript:;">Edit Status</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" onclick="confirm_modal('<?php echo base_url(); ?>reports/delete/<?php echo $row['report_id']; ?>');" href="javascript:;">Remove</a>
												<?php endif; ?>
											</div>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- end panel -->
		</div>
		<!-- end col-12 -->
	</div>
	<!-- end row -->
</div>
<!-- end #content -->