<!-- begin #content -->
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb hidden-print pull-right">
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>cafeteria_sales">Cafeteria Sales</a></li>
		<li class="breadcrumb-item active"><?php echo $this->security->xss_clean($page_title); ?></li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header hidden-print">
		Invoice #<?php echo $this->security->xss_clean($this->db->get_where('cafeteria_sale', array('cafeteria_sale_id' => $cafeteria_sale_id))->row()->invoice_number); ?>
	</h1>
	<!-- end page-header -->

	<!-- begin invoice -->
	<div class="invoice">
		<div class="invoice-company text-inverse">
			<span class="pull-right hidden-print">
				<a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-primary m-b-10"><i class="material-icons pull-left f-s-18 m-r-5">print</i> Print</a>
			</span>
			<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_name'))->row()->content); ?> | Cafeteria Invoice
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
				<address class="m-t-5 m-b-5">
					<strong><?php echo $this->security->xss_clean($this->db->get_where('cafeteria_sale', array('cafeteria_sale_id' => $cafeteria_sale_id))->row()->customer_name); ?></strong><br>
					Phone: <?php echo $this->security->xss_clean($this->db->get_where('cafeteria_sale', array('cafeteria_sale_id' => $cafeteria_sale_id))->row()->customer_mobile); ?>
				</address>
			</div>
			<div class="invoice-date">
				<small>Date / Invoice</small>
				<div class="date m-t-5"><?php echo date('d M, Y', $this->security->xss_clean($this->db->get_where('cafeteria_sale', array('cafeteria_sale_id' => $cafeteria_sale_id))->row()->timestamp)); ?></div>
				<div class="invoice-detail">
					#<?php echo $this->security->xss_clean($this->db->get_where('cafeteria_sale', array('cafeteria_sale_id' => $cafeteria_sale_id))->row()->invoice_number); ?><br>
					<?php
					$invoice_status = $this->security->xss_clean($this->db->get_where('cafeteria_sale', array('cafeteria_sale_id' => $cafeteria_sale_id))->row()->status);
					if ($invoice_status == 0)
						echo 'Due';
					elseif ($invoice_status == 1)
						echo 'Paid';
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
							<th>Quantity</th>
							<th>Unit Price (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
							<th>Row Total (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$cafeteria_sale_details	=	$this->security->xss_clean($this->db->get_where('cafeteria_sale_details', array('cafeteria_sale_id' => $cafeteria_sale_id))->result_array());
						foreach ($cafeteria_sale_details as $cafeteria_sale_detail) :
						?>
							<tr>
								<td>
									<?php 
										if ($this->db->get_where('cafeteria_inventory', array('cafeteria_inventory_id' => $cafeteria_sale_detail['cafeteria_inventory_id']))->num_rows() > 0)
											echo $this->security->xss_clean($this->db->get_where('cafeteria_inventory', array('cafeteria_inventory_id' => $cafeteria_sale_detail['cafeteria_inventory_id']))->row()->name); 
										else
											echo 'Product not found.';
									?>
								</td>
								<td><?php echo $cafeteria_sale_detail['quantity']; ?></td>
								<td>
									<?php 
										if ($this->db->get_where('cafeteria_inventory', array('cafeteria_inventory_id' => $cafeteria_sale_detail['cafeteria_inventory_id']))->num_rows() > 0)
											echo $unit_price = $this->security->xss_clean($this->db->get_where('cafeteria_inventory', array('cafeteria_inventory_id' => $cafeteria_sale_detail['cafeteria_inventory_id']))->row()->price); 
										else
											echo 'Unit Price not found.';
									?>
								</td>
								<td><?php echo $unit_price * $cafeteria_sale_detail['quantity']; ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div class="invoice-price">
				<div class="invoice-price-left">
					<div class="invoice-price-row">
						<div class="sub-price">
							<small>SUBTOTAL (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</small>
							<?php echo $subtotal = $this->security->xss_clean($this->db->get_where('cafeteria_sale', array('cafeteria_sale_id' => $cafeteria_sale_id))->row()->grand_total); ?>
						</div>
						<div class="sub-price">
							<i class="fa fa-minus"></i>
						</div>
						<div class="sub-price">
							<small>Discount (<?php echo $discount = $this->security->xss_clean($this->db->get_where('cafeteria_sale', array('cafeteria_sale_id' => $cafeteria_sale_id))->row()->discount); ?>%)</small>
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