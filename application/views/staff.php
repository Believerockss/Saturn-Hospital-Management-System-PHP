<!-- begin #content -->
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>staff_categories">Staff Categories</a></li>
		<li class="breadcrumb-item active"><?php echo $page_title; ?></li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<?php if ($is_doctor) : ?>
		<h1 class="page-header">
			<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_doctor/<?php echo $staff_category_id; ?>');" href="javascript:;" class="btn btn-inverse m-r-5">
				<i class="fa fa-plus"></i> Add <?php echo $this->db->get_where('staff_category', array('staff_category_id' => $staff_category_id))->row()->name; ?>
			</a>
		</h1>
	<?php else : ?>
		<h1 class="page-header">
			<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_staff/<?php echo $staff_category_id; ?>');" href="javascript:;" class="btn btn-inverse m-r-5">
				<i class="fa fa-plus"></i> Add <?php echo $this->db->get_where('staff_category', array('staff_category_id' => $staff_category_id))->row()->name; ?>
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
					<?php if ($is_doctor) : ?>
						<table id="data-table-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Image</th>
									<th>Designation</th>
									<th>Name</th>
									<th>Email</th>
									<th>Mobile Number</th>
									<th>Status</th>
									<th>Degrees</th>
									<th>Department</th>
									<th>Sex</th>
									<th>Age</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$count = 1;
								$this->db->order_by('timestamp', 'desc');
								$doctors = $this->db->get_where('doctor', array('staff_category_id' => $staff_category_id))->result_array();
								foreach ($doctors as $doctor) :
								?>
									<tr>
										<td><?php echo $count++; ?></td>
										<td><img width="55" src="<?php echo base_url(); ?>uploads/<?php echo $doctor['image_link'] ? 'doctor/' . $doctor['image_link'] : 'website/default_user.png'; ?>" alt="<?php echo $doctor['name']; ?>" /></td>
										<td><?php echo $doctor['designation']; ?></td>
										<td><?php echo $doctor['name']; ?></td>
										<td><?php echo $doctor['email']; ?></td>
										<td><?php echo $doctor['mobile_number']; ?></td>
										<td>
											<?php
											if ($doctor['status'] == 0)
												echo '<span class="badge badge-warning">Inactive</span>';
											elseif ($doctor['status'] == 1)
												echo '<span class="badge badge-success">Active</span>';
											?>
										</td>
										<td><?php if ($doctor['degrees']) echo $doctor['degrees'];
											else echo 'N/A'; ?></td>
										<td>
											<?php
											if ($doctor['department_id']) {
												if ($this->db->get_where('department', array('department_id' => $doctor['department_id']))->num_rows() > 0)
													echo $this->db->get_where('department', array('department_id' => $doctor['department_id']))->row()->name;
												else
													echo 'Department not found.';
											}
											else {
												echo 'N/A';
											}
											?>
										</td>
										<td>
											<?php
											if ($doctor['sex_id'] == 1)
												echo 'Male';
											elseif ($doctor['sex_id'] == 2)
												echo 'Female';
											else
												echo 'Other';
											?>
										</td>
										<td><?php if ($doctor['age']) echo $doctor['age'];
											else echo 'N/A'; ?></td>
										<td>
											<div class="btn-group">
												<button type="button" class="btn btn-white btn-xs">Action</button>
												<button type="button" class="btn btn-white btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_view_doctor_details/<?php echo $doctor['doctor_id']; ?>');" href="javascript:;">Show Details</a>
													<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_doctor_details/<?php echo $doctor['staff_category_id']; ?>/<?php echo $doctor['doctor_id']; ?>');" href="javascript:;">Edit Details</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_doctor_status/<?php echo $doctor['staff_category_id']; ?>/<?php echo $doctor['doctor_id']; ?>');" href="javascript:;">Edit Status</a>
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
									<th>Image</th>
									<th>Name</th>
									<th>Email</th>
									<th>Mobile Number</th>
									<th>Status</th>
									<th>Sex</th>
									<th>Blood Group</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$count = 1;
								$this->db->order_by('timestamp', 'desc');
								$staff = $this->db->get_where('staff', array('staff_category_id' => $staff_category_id))->result_array();
								foreach ($staff as $row) :
								?>
									<tr>
										<td><?php echo $count++; ?></td>
										<td><img width="55" src="<?php echo base_url(); ?>uploads/<?php echo $row['image_link'] ? 'staff/' . $row['image_link'] : 'website/default_user.png'; ?>" alt="<?php echo $row['name']; ?>" /></td>
										<td><?php echo $row['name']; ?></td>
										<td><?php echo $row['email']; ?></td>
										<td><?php echo $row['mobile_number']; ?></td>
										<td>
											<?php
											if ($row['status'] == 0)
												echo '<span class="badge badge-warning">Inactive</span>';
											elseif ($row['status'] == 1)
												echo '<span class="badge badge-success">Active</span>';
											?>
										</td>
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
										<td><?php if ($row['blood_inventory_id']) echo $this->db->get_where('blood_inventory', array('blood_inventory_id' => $row['blood_inventory_id']))->row()->blood_group_name;
											else echo 'N/A'; ?></td>
										<td>
											<div class="btn-group">
												<button type="button" class="btn btn-white btn-xs">Action</button>
												<button type="button" class="btn btn-white btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_view_staff_details/<?php echo $row['staff_category_id']; ?>/<?php echo $row['staff_id']; ?>');" href="javascript:;">Show Details</a>
													<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_staff_details/<?php echo $row['staff_category_id']; ?>/<?php echo $row['staff_id']; ?>');" href="javascript:;">Edit Details</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_staff_status/<?php echo $row['staff_category_id']; ?>/<?php echo $row['staff_id']; ?>');" href="javascript:;">Edit Status</a>
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