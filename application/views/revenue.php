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
		<?php
		$total_revenue = 0;
		foreach ($revenue_details as $revenue_details_row) {
			$total_revenue += $revenue_details_row['amount'];
		}
		?>
		Total revenue: <?php echo $total_revenue; ?>
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
								<th>Source</th>
								<th>Amount (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
								<th>Patient/Customer</th>
								<th>Mobile Number</th>
								<th>Month</th>
								<th>Year</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 1;
							foreach ($revenue_details as $row) :
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo $row['source']; ?></td>
									<td><?php echo $row['amount']; ?></td>
									<td><?php echo $row['consumer']; ?></td>
									<td><?php echo $row['consumer_mobile']; ?></td>
									<td><?php echo $row['month']; ?></td>
									<td><?php echo $row['year']; ?></td>
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
					<?php echo form_open('revenue', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
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