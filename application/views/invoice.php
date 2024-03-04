<!-- begin #content -->
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb hidden-print pull-right">
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>invoices">Invoices</a></li>
		<li class="breadcrumb-item active"><?php echo $this->security->xss_clean($page_title); ?></li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header hidden-print">
		Invoice #<?php echo $this->security->xss_clean($this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->invoice_number); ?>
	</h1>
	<!-- end page-header -->

	<!-- begin invoice -->
	<div class="invoice">
		<div class="invoice-company text-inverse">
			<span class="pull-right hidden-print">
				<a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-primary m-b-10"><i class="material-icons pull-left f-s-18 m-r-5">print</i> Print</a>
			</span>
			<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_name'))->row()->content); ?> | Invoice
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
				<?php if ($this->db->get_where('invoice', array('invoice_id' => $invoice_id))->num_rows() > 0): ?>
				<address class="m-t-5 m-b-5">
					<strong><?php echo  $this->security->xss_clean($this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->patient_name); ?></strong><br>
					<?php echo $this->security->xss_clean($this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->patient_address); ?><br>
					Phone: <?php echo $this->security->xss_clean($this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->patient_mobile); ?>
				</address>
				<?php else: echo 'Patient not found.'; ?>
				<?php endif; ?>
			</div>
			<div class="invoice-date">
				<small>Date / Invoice</small>
				<div class="date m-t-5"><?php echo date('d M, Y', $this->security->xss_clean($this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->timestamp)); ?></div>
				<div class="invoice-detail">
					#<?php echo $this->security->xss_clean($this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->invoice_number); ?><br>
					<?php echo 'Paid'; ?>
				</div>
			</div>
		</div>
		<div class="invoice-content">
			<div class="table-responsive">
				<table class="table table-invoice">
					<thead>
						<tr>
							<th>Item Name</th>
							<th>Occurance</th>
							<th>Cost (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
							<th>Row Total (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$subtotal = 0;
						$invoice_requests	=	$this->security->xss_clean($this->db->get_where('invoice_request', array('invoice_id' => $invoice_id))->result_array());
						foreach ($invoice_requests as $invoice_request) :
						?>
							<tr>
								<td><?php echo $invoice_request['item']; ?></td>
								<td><?php echo $invoice_request['quantity']; ?></td>
								<td><?php echo $invoice_request['amount']; ?></td>
								<td><?php echo $subtotal +=  $invoice_request['quantity'] * $invoice_request['amount']; ?></td>
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
							<?php echo $subtotal; ?>
						</div>
						<div class="sub-price">
							<i class="fa fa-minus"></i>
						</div>
						<div class="sub-price">
							<small>Discount (<?php echo $discount = $this->security->xss_clean($this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->discount); ?>%)</small>
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