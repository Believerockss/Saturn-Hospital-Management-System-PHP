<!-- begin #content -->
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb hidden-print pull-right">
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>pharmacy_sales">Pharmacy Sales</a></li>
		<li class="breadcrumb-item active"><?php echo $this->security->xss_clean($page_title); ?></li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header hidden-print">
		Invoice #<?php echo $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $pharmacy_sale_id))->row()->invoice_number); ?>
	</h1>
	<!-- end page-header -->

	<!-- begin invoice -->
	<div class="invoice">
		<div class="invoice-company text-inverse">
			<span class="pull-right hidden-print">
				<a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-primary m-b-10"><i class="material-icons pull-left f-s-18 m-r-5">print</i> Print</a>
			</span>
			<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_name'))->row()->content); ?> | Pharmacy Invoice
		</div>
		<div class="invoice-header">
			<div class="invoice-from">
				<small>from</small>
				<address class="m-t-5 m-b-5">
					<strong><?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_name'))->row()->content); ?></strong><br>
					<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_address'))->row()->content); ?><br>
					Phone: <?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_phone'))->row()->content); ?>
				</address>
			</div>
			<div class="invoice-to">
				<small>to</small>
				<?php 
					if ($this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $pharmacy_sale_id))->row()->is_patient)):
						$patient_id = $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $pharmacy_sale_id))->row()->patient_id);
						if ($this->db->get_where('patient', array('patient_id' => $patient_id))->num_rows() > 0):
				?>
					<address class="m-t-5 m-b-5">
						<strong>
							<?php echo $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->name); ?>
						</strong><br>
						<?php echo $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->address); ?><br>
						Phone: <?php echo $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->mobile_number); ?>
					</address>
				<?php 
						else: echo '<br>Patient not found.';
						endif;
					else: 
				?>
				<address class="m-t-5 m-b-5">
					<strong><?php echo $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $pharmacy_sale_id))->row()->customer_name); ?></strong><br>
					Phone: <?php echo $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $pharmacy_sale_id))->row()->customer_mobile); ?>
				</address>
				<?php 
					endif; 
				?>
			</div>
			<div class="invoice-date">
				<small>Date / Invoice</small>
				<div class="date m-t-5"><?php echo date('d M, Y', $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $pharmacy_sale_id))->row()->timestamp)); ?></div>
				<div class="invoice-detail">
					#<?php echo $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $pharmacy_sale_id))->row()->invoice_number); ?><br>
					<?php
					$invoice_status = $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $pharmacy_sale_id))->row()->status);
					if ($invoice_status == 0)
						echo 'Status: Due';
					elseif ($invoice_status == 1)
						echo 'Status: Paid';
					?>
				</div>
			</div>
		</div>
		<div class="invoice-content">
			<div class="table-responsive">
				<table class="table table-invoice">
					<thead>
						<tr>
							<th>Product</th>
							<th>Sold Quantity</th>
							<th>Unit Price (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
							<th>Row Total (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
							<th>Type</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$pharmacy_sales = $this->security->xss_clean($this->db->get_where('pharmacy_sale_details', array('pharmacy_sale_id' => $pharmacy_sale_id))->result_array());
						foreach ($pharmacy_sales as $pharmacy_sale) :
						?>
							<tr>
								<td>
									<?php 
										if ($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $pharmacy_sale['pharmacy_inventory_id']))->num_rows() > 0)
											echo $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $pharmacy_sale['pharmacy_inventory_id']))->row()->name); 
										else
											echo 'Product not found.';
									?>
								</td>
								<td><?php echo $pharmacy_sale['quantity']; ?></td>
								<td>
									<?php 
										if ($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $pharmacy_sale['pharmacy_inventory_id']))->num_rows() > 0)
											echo $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $pharmacy_sale['pharmacy_inventory_id']))->row()->price); 
										else
											echo 'Unit Price not found.';
									?>
								</td>
								<td><?php echo $pharmacy_sale['total']; ?></td>
								<td>Sales</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php
			$number_of_rows = $this->security->xss_clean($this->db->get_where('pharmacy_sale_return', array('pharmacy_sale_id' => $pharmacy_sale_id))->num_rows());
			if ($number_of_rows > 0) :
				foreach ($this->security->xss_clean($this->db->get_where('pharmacy_sale_return', array('pharmacy_sale_id' => $pharmacy_sale_id))->result_array()) as $sale_returns) :
			?>
					<div class="table-responsive">
						<table class="table table-invoice">
							<thead>
								<tr>
									<th>Product</th>
									<th>Returned Quantity</th>
									<th>Unit Price (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
									<th>Row Total (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
									<th>Type</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sale_return_details	=	$this->security->xss_clean($this->db->get_where('pharmacy_sale_return_details', array('pharmacy_sale_return_id' => $sale_returns['pharmacy_sale_return_id']))->result_array());
								foreach ($sale_return_details as $sale_return_detail) :
								?>
									<tr>
										<td>
											<?php 
												if ($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $sale_return_detail['pharmacy_inventory_id']))->num_rows() > 0)
													echo $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $sale_return_detail['pharmacy_inventory_id']))->row()->name); 
												else
													echo 'Product not found.';
											?>
										</td>
										<td><?php echo $sale_return_detail['quantity']; ?></td>
										<td>
											<?php 
												if ($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $sale_return_detail['pharmacy_inventory_id']))->num_rows() > 0)
													echo $return_unit_price = $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $sale_return_detail['pharmacy_inventory_id']))->row()->price); 
												else
													echo 'Unit Price not found.';
											?>
										</td>
										<td><?php echo $return_unit_price * $sale_return_detail['quantity']; ?></td>
										<td>Return</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
			<?php
				endforeach;
			endif;
			?>
			<div class="invoice-price">
				<div class="invoice-price-left">
					<div class="invoice-price-row">
						<div class="sub-price">
							<small>SUBTOTAL (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</small>
							<?php
							$return_subtotal = 0;

							if ($number_of_rows > 0) {
								foreach ($this->security->xss_clean($this->db->get_where('pharmacy_sale_return', array('pharmacy_sale_id' => $pharmacy_sale_id))->result_array()) as $sale_returns) {
									$return_subtotal += $this->security->xss_clean($this->db->get_where('pharmacy_sale_return', array('pharmacy_sale_return_id' => $sale_returns['pharmacy_sale_return_id']))->row()->grand_total);
								}

								echo $subtotal = $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $pharmacy_sale_id))->row()->grand_total - $return_subtotal);
							} else {
								echo $subtotal = $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $pharmacy_sale_id))->row()->grand_total);
							}
							?>
						</div>
						<div class="sub-price">
							<i class="fa fa-minus"></i>
						</div>
						<div class="sub-price">
							<small>Discount (<?php echo $discount = $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $pharmacy_sale_id))->row()->discount); ?>%)</small>
							<?php echo $subtotal * $discount / 100; ?>
						</div>
					</div>
				</div>
				<div class="invoice-price-right">
					<small>GRAND TOTAL (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</small> <?php echo $subtotal - ($subtotal * $discount / 100); ?>
				</div>
			</div>
		</div>
		<div class="invoice-footer text-muted">
			<p class="text-center m-b-5">
				THANK YOU FOR YOUR BUSINESS
			</p>
			<p class="text-center">
				<span class="m-r-10"><i class="fa fa-globe"></i> <?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_website'))->row()->content); ?></span>
				<span class="m-r-10"><i class="fa fa-phone"></i> T:<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_phone'))->row()->content); ?></span>
				<span class="m-r-10"><i class="fa fa-envelope"></i> <?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_email'))->row()->content); ?></span>
			</p>
		</div>
	</div>
	<!-- end invoice -->
</div>
<!-- end #content -->