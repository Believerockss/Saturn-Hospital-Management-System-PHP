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
		<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_discharge');" href="javascript:;" class="btn btn-inverse m-r-5">
			<i class="fa fa-plus"></i> Add Discharge
		</a>
	</h1>
	<!-- end page-header -->
	<?php else: ?>
	<!-- begin page-header -->
	<h1 class="page-header">
		Your Discharge Details
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
								<th>Occupancy</th>
								<th>Doctor</th>
								<th>Next Appoinment</th>
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
								$discharges = $this->security->xss_clean($this->db->get('discharge')->result_array());
							} else {
								$query = $this->db->get_where('occupancy', array('patient_id' => $this->session->userdata('user_id')));
								if ($query->num_rows() > 0) {
									$discharges = $this->security->xss_clean($this->db->get_where('discharge', array('occupancy_id' => $query->row()->occupancy_id))->result_array());
								} else {
									$discharges = [];
								}								
							}
							foreach ($discharges as $row) :
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td>
										<?php
										if ($this->db->get_where('occupancy', array('occupancy_id' => $row['occupancy_id']))->num_rows() > 0) {
											$patient_id = $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $row['occupancy_id']))->row()->patient_id);
											echo $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->name);
										} else {
											'Patient not found.';
										}
										?>
									</td>
									<td>
										<?php
										if ($this->db->get_where('occupancy', array('occupancy_id' => $row['occupancy_id']))->num_rows() > 0) {
											$accommodation_category_id = $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $row['occupancy_id']))->row()->accommodation_category_id);
											if ($this->db->get_where('occupancy', array('occupancy_id' => $row['occupancy_id']))->num_rows() > 0) {
												$accommodation_id = $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $row['occupancy_id']))->row()->accommodation_id);
												if ($this->db->get_where('accommodation_category', array('accommodation_category_id' => $accommodation_category_id))->num_rows() > 0) {
													$accommodation_type	= $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $accommodation_category_id))->row()->accommodation_type);
													if ($accommodation_type == 1) {
														if ($this->db->get_where('bed', array('bed_id' => $accommodation_id))->num_rows() > 0) {
															$bed_accommodation_id = $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $accommodation_id))->row()->accommodation_id);
															if ($this->db->get_where('accommodation', array('accommodation_id' => $bed_accommodation_id))->num_rows() > 0)
																echo 'Bed ' . $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $accommodation_id))->row()->bed_number) . ' of Room ' . $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $bed_accommodation_id))->row()->room_number);
															else
																echo 'Bed ' . $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $accommodation_id))->row()->bed_number);
														} else {
															echo 'Bed not found.';
														}
													} else {
														if ($this->db->get_where('accommodation', array('accommodation_id' => $accommodation_id))->num_rows() > 0)
															echo 'Room ' . $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $accommodation_id))->row()->room_number);
														else
															echo 'Room Number not found.';
													}
												} else {
													echo 'Accommodotaion type not found.';
												}
											} else {
												echo 'Accommodation not found.';
											}
										} else {
											echo 'Accommodation Category not found.';
										}
										?>
									</td>
									<td>
										<?php 
											if ($this->db->get_where('doctor', array('doctor_id' => $row['doctor_id']))->num_rows() > 0)
												echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $row['doctor_id']))->row()->name); 
											else
												echo 'Doctor not found.';										?>
									</td>
									<td>
										<?php
										if ($row['next_appointment'])
											echo date('d M, Y', $row['next_appointment']);
										else
											echo 'N/A';
										?>
									</td>
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
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_view_discharge_details/<?php echo $row['discharge_id']; ?>');" href="javascript:;">Show Details</a>
												<?php if ($this->session->userdata('user_type') == 'staff'): ?>
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_discharge_details/<?php echo $row['discharge_id']; ?>');" href="javascript:;">Edit Details</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" onclick="confirm_modal('<?php echo base_url(); ?>discharges/delete/<?php echo $row['discharge_id']; ?>');" href="javascript:;">Remove</a>
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