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
		<a href="<?php echo base_url(); ?>pharmacy_pos" class="btn btn-inverse m-r-5">
			<i class="fa fa-plus"></i> Add Pharmacy Sale
		</a>
	</h1>
	<!-- end page-header -->
	<?php else: ?>
	<!-- begin page-header -->
	<h1 class="page-header">
		Your Pharmacy Shopping Details
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
								<th>Invoice</th>
								<th>Name</th>
								<th>Subtotal (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
								<th>Discount</th>
								<th>Grand Total (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
								<th>Status</th>
								<th>Created On</th>
								<th>Created By</th>
								<th>Updated On</th>
								<th>Updated By</th>
								<?php if ($this->session->userdata('user_type') == 'staff'): ?>
								<th></th>
								<?php endif; ?>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 1;
							$this->db->order_by('timestamp', 'desc');
							if ($this->session->userdata('user_type') == 'staff') {
								$pharmacy_sales = $this->db->get('pharmacy_sale')->result_array();
							} else {
								$pharmacy_sales = $this->db->get_where('pharmacy_sale', array('patient_id' => $this->session->userdata('user_id')))->result_array();
							}
							foreach ($pharmacy_sales as $row) :
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td>
										<a href="<?php echo base_url(); ?>pharmacy_invoice/<?php echo $row['pharmacy_sale_id']; ?>">
											<?php echo '#' . $row['invoice_number']; ?>
										</a>
									</td>
									<td>
										<?php
										if ($row['is_patient']) {
											if ($this->db->get_where('patient', array('patient_id' => $row['patient_id']))->num_rows() > 0)
												echo $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->name);
											else
												echo 'Patient not found.';
										} else {
											echo $row['customer_name'];
										}
										?>
									</td>
									<td>
										<?php
										$return_subtotal = 0;
										$num_of_row = $this->security->xss_clean($this->db->get_where('pharmacy_sale_return', array('pharmacy_sale_id' => $row['pharmacy_sale_id']))->num_rows());

										if ($num_of_row > 0) {
											foreach ($this->security->xss_clean($this->db->get_where('pharmacy_sale_return', array('pharmacy_sale_id' => $row['pharmacy_sale_id']))->result_array()) as $sale_returns) {
												$return_subtotal += $this->security->xss_clean($this->db->get_where('pharmacy_sale_return', array('pharmacy_sale_return_id' => $sale_returns['pharmacy_sale_return_id']))->row()->grand_total);
											}

											echo $subtotal = $row['grand_total'] - $return_subtotal;
										} else
											echo $subtotal = $row['grand_total'];
										?>
									</td>
									<td>
										<?php
										if ($row['discount'])
											echo $row['discount'] . '%';
										else
											echo '-';
										?>
									</td>
									<td><?php echo $subtotal - ($subtotal * $row['discount'] / 100); ?></td>
									<td>
										<?php
										if ($row['status'] == 0)
											echo '<span class="badge badge-warning">Due</span>';
										elseif ($row['status'] == 1)
											echo '<span class="badge badge-success">Paid</span>';
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
									<?php if ($this->session->userdata('user_type') == 'staff'): ?>
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-white btn-xs">Action</button>
											<button type="button" class="btn btn-white btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_pharmacy_sale_status/<?php echo $row['pharmacy_sale_id']; ?>');" href="javascript:;">Edit Status</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_pharmacy_sale_return/<?php echo $row['pharmacy_sale_id']; ?>');" href="javascript:;">Sale Return</a>
											</div>
										</div>
									</td>
									<?php endif; ?>
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