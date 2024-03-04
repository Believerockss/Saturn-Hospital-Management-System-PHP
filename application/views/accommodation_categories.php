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
		<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_accommodation_category');" href="javascript:;" class="btn btn-inverse m-r-5">
			<i class="fa fa-plus"></i> Add Accommodation Category
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
								<th>Category Name</th>
								<th>Number of Accommodations</th>
								<th>Type</th>
								<th>Description</th>
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
							$accommodation_categories = $this->security->xss_clean($this->db->get('accommodation_category')->result_array());
							foreach ($accommodation_categories as $accommodation_category) :
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td>
										<a href="<?php echo base_url(); ?>accommodations/<?php echo $accommodation_category['accommodation_category_id']; ?>">
											<?php echo $accommodation_category['name']; ?>
										</a>
									</td>
									<td>
										<?php
										if ($accommodation_category['accommodation_type'] == 1)
											echo $this->security->xss_clean($this->db->get_where('bed', array('accommodation_category_id' => $accommodation_category['accommodation_category_id']))->num_rows());
										else
											echo $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_category_id' => $accommodation_category['accommodation_category_id']))->num_rows());
										?>
									</td>
									<td>
										<?php
										if ($accommodation_category['accommodation_type'] == 0)
											echo 'Single Room';
										elseif ($accommodation_category['accommodation_type'] == 1)
											echo 'Is Bed';
										else
											echo 'Has Beds';
										?>
									</td>
									<td><?php echo $accommodation_category['description']; ?></td>
									<td><?php echo date('d M, Y', $accommodation_category['created_on']); ?></td>
									<td>
										<?php
										if ($this->db->get_where('user', array('user_id' => $accommodation_category['created_by']))->num_rows() > 0) {
											$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $accommodation_category['created_by']))->row()->staff_id);
											$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $accommodation_category['created_by']))->row()->is_doctor);

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
									<td><?php echo date('d M, Y', $accommodation_category['timestamp']); ?></td>
									<td>
									<?php
										if ($this->db->get_where('user', array('user_id' => $accommodation_category['updated_by']))->num_rows() > 0) {
											$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $accommodation_category['updated_by']))->row()->staff_id);
											$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $accommodation_category['updated_by']))->row()->is_doctor);

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
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_accommodation_category/<?php echo $accommodation_category['accommodation_category_id']; ?>');" href="javascript:;">Edit Category</a>
												<?php
												$show_delete = true;
												$accommodation_type = $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $accommodation_category['accommodation_category_id']))->row()->accommodation_type);
												if ($accommodation_type == 1 && $this->security->xss_clean($this->db->get_where('bed', array('status' => 1, 'accommodation_category_id' => $accommodation_category['accommodation_category_id']))->num_rows()) > 0) {
													$show_delete = false;
												} elseif ($accommodation_type != 1 && $this->security->xss_clean($this->db->get_where('accommodation', array('status' => 1, 'accommodation_category_id' => $accommodation_category['accommodation_category_id']))->num_rows()) > 0) {
													$show_delete = false;
												} elseif ($accommodation_type == 2 && $this->security->xss_clean($this->db->get_where('bed', array('root_accommodation_category_id' => $accommodation_category['accommodation_category_id']))->num_rows()) > 0) {
													$show_delete = false;
												}
												if ($show_delete) :
												?>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" onclick="confirm_modal('<?php echo base_url(); ?>accommodation_categories/delete/<?php echo $accommodation_category['accommodation_category_id']; ?>');" href="javascript:;">Remove</a>
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