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
		<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_payroll');" href="javascript:;" class="btn btn-inverse m-r-5">
			<i class="fa fa-plus"></i> Add Payroll
		</a>
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
								<th>Amount (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
								<th>Status</th>
								<th>Month</th>
								<th>Year</th>
								<th>Payroll Type</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 1;
							foreach ($payroll_details as $row) :
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td>
										<?php
										if ($this->db->get_where('user', array('user_id' => $row['user_id']))->num_rows() > 0) {
											$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['user_id']))->row()->staff_id);
											$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['user_id']))->row()->is_doctor);

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
									<td><?php echo $row['amount']; ?></td>
									<td>
										<?php
										if ($row['status'] == 0)
											echo '<span class="badge badge-warning">Due</span>';
										else
											echo '<span class="badge badge-success">Paid</span>';
										?>
									</td>
									<td><?php echo $row['month']; ?></td>
									<td><?php echo $row['year']; ?></td>
									<td>
										<?php
										if ($this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['user_id']))->row()->staff_category_id)))->row()->payment_type) == 1)
											echo '<span class="badge badge-inverse">Monthly</span>';
										elseif ($this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['user_id']))->row()->staff_category_id)))->row()->payment_type) == 2)
											echo '<span class="badge badge-primary">Shiftwise</span>';
										else
											echo 'Record not found.';
										?>
									</td>
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-white btn-xs">Action</button>
											<button type="button" class="btn btn-white btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_payroll/<?php echo $row['payroll_id']; ?>');" href="javascript:;">Edit Payroll</a>
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_payroll_status/<?php echo $row['payroll_id']; ?>');" href="javascript:;">Edit Status</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" onclick="confirm_modal('<?php echo base_url(); ?>payroll/delete/<?php echo $row['payroll_id']; ?>');" href="javascript:;">Remove</a>
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
		<!-- end col-9 -->
		<!-- begin col-3 -->
		<div class="col-md-3">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-body -->
				<div class="panel-body">
					<?php echo form_open('payroll', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
					<div class="form-group">
						<label class="col-form-label">Year *</label>
						<div>
							<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="year">
								<option value="">Select Year</option>
								<option <?php if ($year == date('Y') - 4) echo 'selected'; ?> value="<?php echo date('Y') - 4; ?>"><?php echo date('Y') - 4; ?></option>
								<option <?php if ($year == date('Y') - 3) echo 'selected'; ?> value="<?php echo date('Y') - 3; ?>"><?php echo date('Y') - 3; ?></option>
								<option <?php if ($year == date('Y') - 2) echo 'selected'; ?> value="<?php echo date('Y') - 2; ?>"><?php echo date('Y') - 2; ?></option>
								<option <?php if ($year == date('Y') - 1) echo 'selected'; ?> value="<?php echo date('Y') - 1; ?>"><?php echo date('Y') - 1; ?></option>
								<option <?php if ($year == date('Y')) echo 'selected'; ?> value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
								<option <?php if ($year == date('Y') + 1) echo 'selected'; ?> value="<?php echo date('Y') + 1; ?>"><?php echo date('Y') + 1; ?></option>
								<option <?php if ($year == date('Y') + 2) echo 'selected'; ?> value="<?php echo date('Y') + 2; ?>"><?php echo date('Y') + 2; ?></option>
								<option <?php if ($year == date('Y') + 3) echo 'selected'; ?> value="<?php echo date('Y') + 3; ?>"><?php echo date('Y') + 3; ?></option>
								<option <?php if ($year == date('Y') + 4) echo 'selected'; ?> value="<?php echo date('Y') + 4; ?>"><?php echo date('Y') + 4; ?></option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-form-label">Month *</label>
						<div>
							<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="month">
								<option value="">Select Month</option>
								<option <?php if ($month == 'January') echo 'selected'; ?> value="January">January</option>
								<option <?php if ($month == 'February') echo 'selected'; ?> value="February">February</option>
								<option <?php if ($month == 'March') echo 'selected'; ?> value="March">March</option>
								<option <?php if ($month == 'April') echo 'selected'; ?> value="April">April</option>
								<option <?php if ($month == 'May') echo 'selected'; ?> value="May">May</option>
								<option <?php if ($month == 'June') echo 'selected'; ?> value="June">June</option>
								<option <?php if ($month == 'July') echo 'selected'; ?> value="July">July</option>
								<option <?php if ($month == 'August') echo 'selected'; ?> value="August">August</option>
								<option <?php if ($month == 'September') echo 'selected'; ?> value="September">September</option>
								<option <?php if ($month == 'October') echo 'selected'; ?> value="October">October</option>
								<option <?php if ($month == 'November') echo 'selected'; ?> value="November">November</option>
								<option <?php if ($month == 'December') echo 'selected'; ?> value="December">December</option>
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