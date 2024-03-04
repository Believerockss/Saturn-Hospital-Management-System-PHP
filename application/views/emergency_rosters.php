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
		<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_emergency_roster');" href="javascript:;" class="btn btn-inverse m-r-5">
			<i class="fa fa-plus"></i> Add Emergency Roster
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
								<th>Duty On</th>
								<th>Shift</th>
								<th>Staff</th>
								<th>Status</th>
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
							$this->db->order_by('duty_on', 'desc');
							$rosters = $this->security->xss_clean($this->db->get_where('roster', array('type' => 1))->result_array());
							foreach ($rosters as $roster) :
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo date('d M, Y', $roster['duty_on']); ?></td>
									<td>
										<?php 
											if ($this->db->get_where('shift', array('shift_id' => $roster['shift_id']))->num_rows() > 0)
												echo $this->security->xss_clean($this->db->get_where('shift', array('shift_id' => $roster['shift_id']))->row()->shift_starts) . ' - ' . $this->security->xss_clean($this->db->get_where('shift', array('shift_id' => $roster['shift_id']))->row()->shift_ends);
											else
												echo 'Shift not found.';
										?>
									</td>
									<td>
										<a data-toggle="tooltip" data-placement="bottom" title="<?php echo 'Extra Note: ' . $roster['extra_note']; ?>">
											<?php
											if ($this->db->get_where('shift', array('shift_id' => $roster['shift_id']))->num_rows() > 0) {
												$is_doctor = $this->security->xss_clean($this->db->get_where('shift', array('shift_id' => $roster['shift_id']))->row()->is_doctor);
												if ($is_doctor) {
													if ($this->db->get_where('doctor', array('doctor_id' => $roster['staff_id']))->num_rows() > 0)
														echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $roster['staff_id']))->row()->name);
													else
														echo 'Doctor not found.';
												} else {
													if ($this->db->get_where('staff', array('staff_id' => $roster['staff_id']))->num_rows() > 0)
														echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $roster['staff_id']))->row()->name);
													else
														echo 'Staff not found.';
												}
											} else {
												echo 'Shift not found.';
											}
											?>
										</a>
									</td>
									<td>
										<?php
										if ($roster['status'] == 0)
											echo '<span class="badge badge-warning">Incoming</span>';
										elseif ($roster['status'] == 1)
											echo '<span class="badge badge-info">Ongoing</span>';
										elseif ($roster['status'] == 2)
											echo '<span class="badge badge-success">Done</span>';
										elseif ($roster['status'] == 3)
											echo '<span class="badge badge-danger">Incomplete</span>';
										?>
									</td>
									<td><?php echo date('d M, Y', $roster['created_on']); ?></td>
									<td>
										<?php
										if ($this->db->get_where('user', array('user_id' => $roster['created_by']))->num_rows() > 0) {
											$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $roster['created_by']))->row()->staff_id);
											$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $roster['created_by']))->row()->is_doctor);

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
									<td><?php echo date('d M, Y', $roster['timestamp']); ?></td>
									<td>
										<?php
										if ($this->db->get_where('user', array('user_id' => $roster['updated_by']))->num_rows() > 0) {
											$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $roster['updated_by']))->row()->staff_id);
											$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $roster['updated_by']))->row()->is_doctor);

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
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_emergency_roster_details/<?php echo $roster['roster_id']; ?>');" href="javascript:;">Edit Details</a>
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_emergency_roster_status/<?php echo $roster['roster_id']; ?>');" href="javascript:;">Edit Status</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" onclick="confirm_modal('<?php echo base_url(); ?>emergency_rosters/delete/<?php echo $roster['roster_id']; ?>');" href="javascript:;">Remove</a>
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