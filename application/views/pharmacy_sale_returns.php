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
		<a href="<?php echo base_url(); ?>pharmacy_sales" class="btn btn-inverse m-r-5">
			<i class="fa fa-plus"></i> Add Pharmacy Sale Return
		</a>
	</h1>
	<!-- end page-header -->
	<?php else: ?>
	<!-- begin page-header -->
	<h1 class="page-header">
		Your Pharmacy Return Details
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
							if ($this->session->userdata('user_type') == 'staff') {
								$pharmacy_sale_returns = $this->security->xss_clean($this->db->get('pharmacy_sale_return')->result_array());
							} else {
								$query = $this->db->get_where('pharmacy_sale', array('patient_id' => $this->session->userdata('user_id')));
								if ($query->num_rows() > 0) {
									$pharmacy_sale_returns = $this->security->xss_clean($this->db->get_where('pharmacy_sale_return', array('pharmacy_sale_id' => $query->row()->pharmacy_sale_id))->result_array());
								} else {
									$pharmacy_sale_returns = [];
								}								
							}
							foreach ($pharmacy_sale_returns as $row) :
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td>
										<a href="<?php echo base_url(); ?>pharmacy_invoice/<?php echo $row['pharmacy_sale_id']; ?>">
											<?php echo '#' . $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $row['pharmacy_sale_id']))->row()->invoice_number); ?>
										</a>
									</td>
									<td>
										<?php
										if ($this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $row['pharmacy_sale_id']))->row()->is_patient)) {
											if ($this->db->get_where('patient', array('patient_id' => $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $row['pharmacy_sale_id']))->row()->patient_id)))->num_rows() > 0)
												echo $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $row['pharmacy_sale_id']))->row()->patient_id)))->row()->name);
											else
												echo 'Patient not found.';
										} else {
											echo $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $row['pharmacy_sale_id']))->row()->customer_name);
										}
										?>
									</td>
									<td><?php echo $row['grand_total'] ?></td>
									<td>
										<?php
										if ($this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $row['pharmacy_sale_id']))->row()->discount))
											echo $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $row['pharmacy_sale_id']))->row()->discount) . '%';
										else
											echo '0';
										?>
									</td>
									<td><?php echo $row['grand_total'] - ($row['grand_total'] * $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $row['pharmacy_sale_id']))->row()->discount) / 100); ?></td>
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
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_view_pharmacy_sale_return_details/<?php echo $row['pharmacy_sale_return_id']; ?>');" href="javascript:;">Show Details</a>
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