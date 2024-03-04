<!-- begin #content -->
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>shift_categories">Shift Categories</a></li>
		<li class="breadcrumb-item active"><?php echo $this->security->xss_clean($page_title); ?>'s Shifts</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">
		<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_shift/<?php echo $staff_category_id; ?>');" href="javascript:;" class="btn btn-inverse m-r-5">
			<i class="fa fa-plus"></i> Add <?php echo $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $staff_category_id))->row()->name); ?>'s Shift
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
								<th>Shift Starts</th>
								<th>Shift Ends</th>
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
							$shifts = $this->security->xss_clean($this->db->get_where('shift', array('staff_category_id' => $staff_category_id))->result_array());
							foreach ($shifts as $shift) :
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo $shift['shift_starts']; ?></td>
									<td><?php echo $shift['shift_ends']; ?></td>
									<td><?php echo date('d M, Y', $shift['created_on']); ?></td>
									<td>
										<?php
										if ($this->db->get_where('user', array('user_id' => $shift['created_by']))->num_rows() > 0) {
											$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $shift['created_by']))->row()->staff_id);
											$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $shift['created_by']))->row()->is_doctor);

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
									<td><?php echo date('d M, Y', $shift['timestamp']); ?></td>
									<td>
										<?php
										if ($this->db->get_where('user', array('user_id' => $shift['updated_by']))->num_rows() > 0) {
											$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $shift['updated_by']))->row()->staff_id);
											$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $shift['updated_by']))->row()->is_doctor);

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
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_shift_details/<?php echo $shift['shift_id']; ?>');" href="javascript:;">Edit Details</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" onclick="confirm_modal('<?php echo base_url(); ?>shifts/delete/<?php echo $shift['shift_id']; ?>');" href="javascript:;">Remove</a>
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