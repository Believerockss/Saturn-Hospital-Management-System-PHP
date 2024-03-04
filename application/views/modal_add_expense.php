<?php echo form_open('expenses/create', array('id' => 'create_expense', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Name *</label>
	<div class="col-md-12">
		<input name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the expense" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Year *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" name="year" data-parsley-required="true">
			<option value="">Select year of the expense</option>
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
		<select style="width: 100%" class="form-control default-select2" name="month" data-parsley-required="true">
			<option value="">Select month of the expense</option>
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
	<label class="col-md-12 col-form-label">Amount (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
	<div class="col-md-12">
		<input name="amount" class="form-control" placeholder="Type amount of the expense" data-parsley-required="true" data-parsley-min="0" data-parsley-type="number" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Description *</label>
	<div class="col-md-12">
		<textarea data-parsley-required="true" name="description" class="form-control" placeholder="Type description of the expense" rows="5"></textarea>
	</div>
</div>

<div class="form-group">
	<label class="col-md-12 col-form-label"></label>
	<div class="col-md-12">
		<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
		<button type="submit" class="btn btn-yellow pull-right">Submit</button>
	</div>
</div>
<?php echo form_close(); ?>

<script>
	"use strict";
	
	$('#create_expense').parsley();
	FormPlugins.init();
</script>