<!-- begin #content -->
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>accommodation_categories">Accommodation Categories</a></li>
		<li class="breadcrumb-item active"><?php echo $this->security->xss_clean($page_title); ?></li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<?php if ($accommodation_type == 1) : ?>
		<h1 class="page-header">
			<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_bed/<?php echo $accommodation_category_id; ?>');" href="javascript:;" class="btn btn-inverse m-r-5">
				<i class="fa fa-plus"></i> Add <?php echo $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $accommodation_category_id))->row()->name); ?>
			</a>
		</h1>
	<?php else : ?>
		<h1 class="page-header">
			<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_accommodation/<?php echo $accommodation_category_id; ?>');" href="javascript:;" class="btn btn-inverse m-r-5">
				<i class="fa fa-plus"></i> Add <?php echo $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $accommodation_category_id))->row()->name); ?>
			</a>
		</h1>
	<?php endif; ?>
	<!-- end page-header -->

	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-md-12">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<div class="panel-body">
					<?php if ($accommodation_type == 1) : ?>
						<table id="data-table-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Bed Number</th>
									<th>Room Number</th>
									<th>Accommodation Category</th>
									<th>Rent (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
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
								$this->db->order_by('timestamp', 'desc');
								$beds = $this->security->xss_clean($this->db->get_where('bed', array('accommodation_category_id' => $accommodation_category_id))->result_array());
								foreach ($beds as $row) :
								?>
									<tr>
										<td><?php echo $count++; ?></td>
										<td><?php echo $row['bed_number']; ?></td>
										<td>
											<?php
												if ($this->db->get_where('accommodation', array('accommodation_id' => $row['accommodation_id']))->num_rows() > 0) 
													echo $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $row['accommodation_id']))->row()->room_number);
												else 
													echo 'Room Number not found.';
											?>
										</td>
										<td>
											<?php
												if ($this->db->get_where('accommodation_category', array('accommodation_category_id' => $row['root_accommodation_category_id']))->num_rows() > 0) 
													echo $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $row['root_accommodation_category_id']))->row()->name);
												else
													echo 'Accommodation Category not found.';
											?>
										</td>
										<td><?php echo $row['rent']; ?></td>
										<td>
											<?php
											if ($row['status'] == 0) {
												echo '<span class="badge badge-warning">Unoccupied</span>';
											} elseif ($row['status'] == 1) {
												echo '<span class="badge badge-success">Occupied</span>';
											}
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
													<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_bed_details/<?php echo $row['accommodation_category_id']; ?>/<?php echo $row['bed_id']; ?>');" href="javascript:;">Edit Details</a>
													<?php if (!$row['status']) : ?>
														<div class="dropdown-divider"></div>
														<a class="dropdown-item" onclick="confirm_modal('<?php echo base_url(); ?>accommodations/delete/<?php echo $row['accommodation_category_id']; ?>/<?php echo $row['bed_id']; ?>');" href="javascript:;">Remove</a>
													<?php endif; ?>
												</div>
											</div>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php else : ?>
						<table id="data-table-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Room Number</th>
									<th>Rent (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
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
								$this->db->order_by('timestamp', 'desc');
								$accommodations = $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_category_id' => $accommodation_category_id))->result_array());
								foreach ($accommodations as $accommodation) :
								?>
									<tr>
										<td><?php echo $count++; ?></td>
										<td><?php echo $accommodation['room_number']; ?></td>
										<td>
											<?php
											if ($accommodation['rent']) {
												echo $accommodation['rent'];
											} else {
												echo 'N/A';
											}
											?>
										</td>
										<td>
											<?php
											if ($accommodation['status'] == 0) {
												echo '<span class="badge badge-warning">Unoccupied</span>';
											} elseif ($accommodation['status'] == 1) {
												echo '<span class="badge badge-success">Occupied</span>';
											}
											?>
										</td>
										<td><?php echo date('d M, Y', $accommodation['created_on']); ?></td>
										<td>
											<?php
											if ($this->db->get_where('user', array('user_id' => $accommodation['created_by']))->num_rows() > 0) {
												$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $accommodation['created_by']))->row()->staff_id);
												$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $accommodation['created_by']))->row()->is_doctor);

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
										<td><?php echo date('d M, Y', $accommodation['timestamp']); ?></td>
										<td>
											<?php
											if ($this->db->get_where('user', array('user_id' => $accommodation['updated_by']))->num_rows() > 0) {
												$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $accommodation['updated_by']))->row()->staff_id);
												$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $accommodation['updated_by']))->row()->is_doctor);

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
											<?php
											$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $accommodation['updated_by']))->row()->staff_id);
											$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $accommodation['updated_by']))->row()->is_doctor);
											if ($is_doctor) {
												echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $staff_id))->row()->name);
											} else {
												echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $staff_id))->row()->name);
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
													<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_accommodation_details/<?php echo $accommodation['accommodation_category_id']; ?>/<?php echo $accommodation['accommodation_id']; ?>');" href="javascript:;">Edit Details</a>
													<?php if (!$accommodation['status']) : ?>
														<div class="dropdown-divider"></div>
														<a class="dropdown-item" onclick="confirm_modal('<?php echo base_url(); ?>accommodations/delete/<?php echo $accommodation['accommodation_category_id']; ?>/<?php echo $accommodation['accommodation_id']; ?>');" href="javascript:;">Remove</a>
													<?php endif; ?>
												</div>
											</div>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
				</div>
			</div>
			<!-- end panel -->
		</div>
		<!-- end col-12 -->
	</div>
	<!-- end row -->
</div>
<!-- end #content -->