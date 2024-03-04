<?php echo form_open('payroll/create', array('id' => 'create_payroll', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Year *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="year">
			<option value="">Select Year</option>
			<option value="<?php echo date('Y') - 4; ?>"><?php echo date('Y') - 4; ?></option>
			<option value="<?php echo date('Y') - 3; ?>"><?php echo date('Y') - 3; ?></option>
			<option value="<?php echo date('Y') - 2; ?>"><?php echo date('Y') - 2; ?></option>
			<option value="<?php echo date('Y') - 1; ?>"><?php echo date('Y') - 1; ?></option>
			<option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
			<option value="<?php echo date('Y') + 1; ?>"><?php echo date('Y') + 1; ?></option>
			<option value="<?php echo date('Y') + 2; ?>"><?php echo date('Y') + 2; ?></option>
			<option value="<?php echo date('Y') + 3; ?>"><?php echo date('Y') + 3; ?></option>
			<option value="<?php echo date('Y') + 4; ?>"><?php echo date('Y') + 4; ?></option>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Month *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="month">
			<option value="">Select Month</option>
			<option value="January">January</option>
			<option value="February">February</option>
			<option value="March">March</option>
			<option value="April">April</option>
			<option value="May">May</option>
			<option value="June">June</option>
			<option value="July">July</option>
			<option value="August">August</option>
			<option value="September">September</option>
			<option value="October">October</option>
			<option value="November">November</option>
			<option value="December">December</option>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-12 col-form-label"></label>
	<div class="col-md-12">
		<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
		<button type="submit" class="btn btn-yellow pull-right">Generate</button>
	</div>
</div>
<?php echo form_close(); ?>

<script>
	"use strict";
	
	$('#create_payroll').parsley();
	FormPlugins.init();
</script>