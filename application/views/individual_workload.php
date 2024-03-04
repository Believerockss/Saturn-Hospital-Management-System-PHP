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
		<div class="btn-group">
			<a href="javascript:;" data-toggle="dropdown" class="btn btn-inverse dropdown-toggle" aria-expanded="false">
				<i class="fa fa-plus"></i> Add Roster &amp; Shift Category
			</a>
			<ul class="dropdown-menu pull-right">
				<li>
					<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_roster');" href="javascript:;">Roster</a>
				</li>
				<li>
					<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_shift_category');" href="javascript:;">Shift Category</a>
				</li>
			</ul>
		</div>
	</h1>
	<!-- end page-header -->

	<!-- begin row -->
	<div class="row">
		<!-- begin col-9 -->
		<div class="col-md-9">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<div class="panel-body">
					<table id="data-table-buttons" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Staff</th>
								<th>Duty On</th>
								<th>Shift</th>
								<th>Status</th>
								<th>Type</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 1;
							foreach ($staff_duties as $roster) :
							?>
								<tr>
									<td><?php echo $count++; ?></td>
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
									<td>
										<?php
										if ($roster['type'] == 0)
											echo 'Regular';
										elseif ($roster['type'] == 1)
											echo 'Emergency';
										?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- end panel -->
		</div>
		<!-- end col-9 -->
		<!-- begin col-3 -->
		<div class="col-md-3">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-body -->
				<div class="panel-body">
					<?php echo form_open('individual_workload', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
					<div class="form-group">
						<label class="col-form-label">Staff *</label>
						<div>
							<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="user_id">
								<option value="">Select staff</option>
								<?php
								$staff_categories = $this->security->xss_clean($this->db->get_where('staff_category', array('payment_type' => 2))->result_array());
								foreach ($staff_categories as $staff_category) :
								?>
									<optgroup label="<?php echo $staff_category['name']; ?>">
										<?php
										if ($staff_category['is_doctor']) :
											$doctors =  $this->security->xss_clean($this->db->get_where('doctor', array('staff_category_id' => $staff_category['staff_category_id']))->result_array());
											foreach ($doctors as $doctor) :
												$doctor_user_id = $this->security->xss_clean($this->db->get_where('user', array('staff_category_id' => $staff_category['staff_category_id'], 'staff_id' => $doctor['doctor_id']))->row()->user_id);
										?>
												<option <?php if ($user_id && $user_id == $doctor_user_id) echo 'selected'; ?> value="<?php echo html_escape($doctor_user_id); ?>"><?php echo $doctor['name']; ?></option>
											<?php
											endforeach;
										else :
											$staff =  $this->security->xss_clean($this->db->get_where('staff', array('staff_category_id' => $staff_category['staff_category_id']))->result_array());
											foreach ($staff as $row) :
												$staff_user_id = $this->security->xss_clean($this->db->get_where('user', array('staff_category_id' => $staff_category['staff_category_id'], 'staff_id' => $row['staff_id']))->row()->user_id);
											?>
												<option <?php if ($user_id && $user_id == $staff_user_id) echo 'selected'; ?> value="<?php echo html_escape($staff_user_id); ?>"><?php echo $row['name']; ?></option>
										<?php
											endforeach;
										endif;
										?>
									</optgroup>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<button type="submit" class="mb-sm btn btn-block btn-primary">Show</button>
					<?php echo form_close(); ?>
				</div>
				<!-- end panel-body -->
			</div>
			<!-- end panel -->
		</div>
		<!-- end col-3 -->
	</div>
	<!-- end row -->
</div>
<!-- end #content -->