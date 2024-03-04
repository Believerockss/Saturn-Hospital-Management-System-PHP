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
		<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_patient');" href="javascript:;" class="btn btn-inverse m-r-5">
			<i class="fa fa-plus"></i> Add Patient
		</a>
	</h1>
	<!-- end page-header -->
	<?php else: ?>
	<!-- begin page-header -->
	<h1 class="page-header">
		Your Own Details
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
								<th>PID</th>
								<th>Name</th>
								<th>Mobile Number</th>
								<th>Sex</th>
								<th>Age</th>
								<th>Blood Group</th>
								<th>Emergency Contact</th>
								<th>Emergency Contact Number</th>
								<th>Status</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 1;
							$this->db->order_by('timestamp', 'desc');
							if ($this->session->userdata('user_type') == 'staff') {
								$patients = $this->db->get('patient')->result_array();
							} else {
								$patients = $this->db->get_where('patient', array('patient_id' => $this->session->userdata('user_id')))->result_array();
							}
							foreach ($patients as $row) :
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><a href="<?php echo base_url('patient/'. $row['patient_id']); ?>"><?php echo $row['pid']; ?></a></td>
									<td><?php echo $row['name']; ?></td>
									<td><?php echo $row['mobile_number']; ?></td>
									<td>
										<?php
										if ($row['sex_id'] == 1)
											echo 'Male';
										elseif ($row['sex_id'] == 2)
											echo 'Female';
										else
											echo 'Other';
										?>
									</td>
									<td><?php if ($row['age']) echo $row['age'];
										else echo 'N/A'; ?></td>
									<td><?php if ($row['blood_inventory_id']) echo $this->security->xss_clean($this->db->get_where('blood_inventory', array('blood_inventory_id' => $row['blood_inventory_id']))->row()->blood_group_name);
										else echo 'N/A'; ?></td>
									<td><?php echo $row['emergency_contact']; ?></td>
									<td><?php echo $row['emergency_contact_number']; ?></td>
									<td>
										<?php
										if ($row['status'] == 0) {
											echo '<span class="badge badge-warning">Not Admitted</span>';
										} elseif ($row['status'] == 1) {
											echo '<span class="badge badge-success">Admitted</span>';
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
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_view_patient_details/<?php echo $row['patient_id']; ?>');" href="javascript:;">Show Details</a>
												<?php if ($this->session->userdata('user_type') == 'staff'): ?>
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_patient_details/<?php echo $row['patient_id']; ?>');" href="javascript:;">Edit Details</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" onclick="confirm_modal('<?php echo base_url(); ?>patients/delete/<?php echo $row['patient_id']; ?>');" href="javascript:;">Remove</a>
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