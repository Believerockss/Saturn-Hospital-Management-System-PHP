<!-- begin #content -->
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb hidden-print pull-right">
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
		<li class="breadcrumb-item active"><?php echo $this->security->xss_clean($page_title); ?></li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header hidden-print">
		<?php
		$total_revenue = 0;
		// $total_expense = 0;
		foreach ($revenue_details as $revenue_details_row) {
			$total_revenue += $revenue_details_row['amount'];
		}
		?>
		Revenue: <?php echo $total_revenue; ?> & Expense: <?php echo $total_expense; ?>
	</h1>
	<!-- end page-header -->
	<div class="row">
		<div class="col-md-9">
			<!-- begin invoice -->
			<div class="invoice">
				<div class="invoice-company text-inverse">
					<span class="pull-right hidden-print">
						<a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-primary m-b-10"><i class="material-icons pull-left f-s-18 m-r-5">print</i> Print</a>
					</span>
					<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_name'))->row()->content); ?> | Income Statement
				</div>
				<div class="invoice-content">
					<div class="table-responsive">
						<table class="table table-invoice">
							<thead>
								<tr>
									<th>Type</th>
									<th>Month</th>
									<th>Year</th>
									<th>Amount (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Revenue</td>
									<td><?php echo $month ? $month : 'All'; ?></td>
									<td><?php echo $year ? $year : 'All'; ?></td>
									<td><?php echo $total_revenue; ?></td>
								</tr>
								<tr>
									<td>Expense</td>
									<td><?php echo $month ? $month : 'All'; ?></td>
									<td><?php echo $year ? $year : 'All'; ?></td>
									<td><?php echo $total_expense; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="invoice-price">
						<div class="invoice-price-left">
							<div class="invoice-price-row">
								<div class="sub-price">
									<small>Revenue (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</small>
									<?php echo $total_revenue; ?>
								</div>
								<div class="sub-price">
									<i class="fa fa-minus"></i>
								</div>
								<div class="sub-price">
									<small>Expense (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</small>
									<?php echo $total_expense; ?>
								</div>
							</div>
						</div>
						<div class="invoice-price-right">
							<small>TOTAL (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</small> <?php echo $total_revenue - $total_expense; ?>
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
		<div class="col-md-3">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-body -->
				<div class="panel-body">
					<?php echo form_open('income_statement', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
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
	</div>
</div>
<!-- end #content -->