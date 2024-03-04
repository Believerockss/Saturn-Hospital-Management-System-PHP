<?php echo form_open('expenses/update/' . $param2, array('id' => 'update_expense', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$expense_details = $this->security->xss_clean($this->db->get_where('expense', array('expense_id' => $param2))->result_array());
foreach ($expense_details as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Name *</label>
		<div class="col-md-12">
			<input value="<?php echo $row['name']; ?>" name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the expense" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Year *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" name="year" data-parsley-required="true">
				<option value="">Select year of the expense</option>
				<option <?php if ($row['year'] == date('Y') - 4) echo 'selected'; ?> value="<?php echo date('Y') - 4; ?>"><?php echo date('Y') - 4; ?></option>
				<option <?php if ($row['year'] == date('Y') - 3) echo 'selected'; ?> value="<?php echo date('Y') - 3; ?>"><?php echo date('Y') - 3; ?></option>
				<option <?php if ($row['year'] == date('Y') - 2) echo 'selected'; ?> value="<?php echo date('Y') - 2; ?>"><?php echo date('Y') - 2; ?></option>
				<option <?php if ($row['year'] == date('Y') - 1) echo 'selected'; ?> value="<?php echo date('Y') - 1; ?>"><?php echo date('Y') - 1; ?></option>
				<option <?php if ($row['year'] == date('Y')) echo 'selected'; ?> value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
				<option <?php if ($row['year'] == date('Y') + 1) echo 'selected'; ?> value="<?php echo date('Y') + 1; ?>"><?php echo date('Y') + 1; ?></option>
				<option <?php if ($row['year'] == date('Y') + 2) echo 'selected'; ?> value="<?php echo date('Y') + 2; ?>"><?php echo date('Y') + 2; ?></option>
				<option <?php if ($row['year'] == date('Y') + 3) echo 'selected'; ?> value="<?php echo date('Y') + 3; ?>"><?php echo date('Y') + 3; ?></option>
				<option <?php if ($row['year'] == date('Y') + 4) echo 'selected'; ?> value="<?php echo date('Y') + 4; ?>"><?php echo date('Y') + 4; ?></option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Month *</label>
		<div class="col-md-12">
			<select style="width: 100%" class="form-control default-select2" name="month" data-parsley-required="true">
				<option value="">Select month of the expense</option>
				<option <?php if ($row['month'] == 'January') echo 'selected'; ?> value="January">January</option>
				<option <?php if ($row['month'] == 'February') echo 'selected'; ?> value="February">February</option>
				<option <?php if ($row['month'] == 'March') echo 'selected'; ?> value="March">March</option>
				<option <?php if ($row['month'] == 'April') echo 'selected'; ?> value="April">April</option>
				<option <?php if ($row['month'] == 'May') echo 'selected'; ?> value="May">May</option>
				<option <?php if ($row['month'] == 'June') echo 'selected'; ?> value="June">June</option>
				<option <?php if ($row['month'] == 'July') echo 'selected'; ?> value="July">July</option>
				<option <?php if ($row['month'] == 'August') echo 'selected'; ?> value="August">August</option>
				<option <?php if ($row['month'] == 'September') echo 'selected'; ?> value="September">September</option>
				<option <?php if ($row['month'] == 'October') echo 'selected'; ?> value="October">October</option>
				<option <?php if ($row['month'] == 'November') echo 'selected'; ?> value="November">November</option>
				<option <?php if ($row['month'] == 'December') echo 'selected'; ?> value="December">December</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Amount (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
		<div class="col-md-12">
			<input value="<?php echo html_escape($row['amount']); ?>" name="amount" class="form-control" placeholder="Type amount of the expense" data-parsley-required="true" data-parsley-min="0" data-parsley-type="number" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Description *</label>
		<div class="col-md-12">
			<textarea data-parsley-required="true" name="description" class="form-control" placeholder="Type description of the expense" rows="5"><?php echo html_escape($row['description']); ?></textarea>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-12 col-form-label"></label>
		<div class="col-md-12">
			<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
			<button type="submit" class="btn btn-yellow pull-right">Update</button>
		</div>
	</div>
<?php endforeach; ?>
<?php echo form_close(); ?>

<script>
	"use strict";
	
	$('#update_expense').parsley();
	FormPlugins.init();
</script>