<?php echo form_open('pharmacy_sales/create/1', array('id' => 'create_pharmacy_sale_patient', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Patient *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="patient_id">
			<option value="">Select patient</option>
			<?php
			$patients = $this->security->xss_clean($this->db->get('patient')->result_array());
			foreach ($patients as $patient) :
			?>
				<option value="<?php echo html_escape($patient['patient_id']); ?>"><?php echo $patient['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Discount (In percentage)</label>
	<div class="col-md-12">
		<input class="form-control" placeholder="Type discount on the whole sale" data-parsley-type="number" data-parsley-min="0" name="discount">
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Status *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="status">
			<option value="">Select status</option>
			<option value="0">Due</option>
			<option value="1">Paid</option>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-12 col-form-label"></label>
	<div class="col-md-12">
		<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
		<?php if ($this->cart->contents()) : ?>
			<button type="submit" class="btn btn-yellow pull-right">Submit</button>
		<?php else: ?>
			<p class="pull-right">Nothing in the cart</p>
		<?php endif; ?>
	</div>
</div>
<?php echo form_close(); ?>

<script>
	"use strict";
	
	$('#create_pharmacy_sale_patient').parsley();
	FormPlugins.init();
</script>