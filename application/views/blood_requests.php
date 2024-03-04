<!-- begin #content -->
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
		<li class="breadcrumb-item active"><?php echo $this->security->xss_clean($page_title); ?></li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">
		<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_blood_request');" href="javascript:;" class="btn btn-inverse m-r-5">
			<i class="fa fa-plus"></i> Request Blood
		</a>
	</h1>
	<!-- end page-header -->

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
								<th>Blood Group</th>
								<th>Blood Donor</th>
								<th>Status</th>
								<th>Doctor of Reference</th>
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
							$blood_requests = $this->security->xss_clean($this->db->get('blood_request')->result_array());
							foreach ($blood_requests as $row) :
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td>
										<a data-toggle="tooltip" data-placement="bottom" title="<?php echo $row['purpose']; ?>">
											<?php echo $this->security->xss_clean($this->db->get_where('blood_inventory', array('blood_inventory_id' => $row['blood_inventory_id']))->row()->blood_group_name); ?>
										</a>
									</td>
									<td>
										<?php 
											if ($this->db->get_where('blood_donor', array('blood_donor_id' => $row['blood_donor_id']))->num_rows() > 0)
												echo $this->security->xss_clean($this->db->get_where('blood_donor', array('blood_donor_id' => $row['blood_donor_id']))->row()->name); 
											else 
												echo 'Blood Donor not found.'
										?>
									</td>
									<td>
										<?php
										if ($row['status'] == 0)
											echo '<span class="badge badge-danger">Pending</span>';
										elseif ($row['status'] == 1)
											echo '<span class="badge badge-success">Accepted</span>';
										else
											echo '<span class="badge badge-warning">Rejected</span>';
										?>
									</td>
									<td>
										<?php 
											if ($this->db->get_where('doctor', array('doctor_id' => $row['doctor_id']))->num_rows() > 0)
												echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $row['doctor_id']))->row()->name); 
											else
												echo 'Doctor not found.';										?>
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
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_blood_request_details/<?php echo $row['blood_request_id']; ?>');" href="javascript:;">Edit Request</a>
												<?php if ($row['status'] == 0) : ?>
													<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_blood_request_status/<?php echo $row['blood_request_id']; ?>');" href="javascript:;">Edit Status</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" onclick="confirm_modal('<?php echo base_url(); ?>blood_requests/delete/<?php echo $row['blood_request_id']; ?>');" href="javascript:;">Remove</a>
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