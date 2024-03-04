<?php echo form_open('invoice_requests/update/' . $param2, array('id' => 'update_invoice_requests', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Patient *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" name="patient_id" data-parsley-required="true">
			<option value="">Select patient</option>
			<?php
			$patients = $this->security->xss_clean($this->db->get('patient')->result_array());
			foreach ($patients as $patient) :
			?>
				<option <?php if ($patient['patient_id'] == $this->security->xss_clean($this->db->get_where('invoice_request', array('invoice_request_id' => $param2))->row()->patient_id)) echo 'selected'; ?> value="<?php echo $patient['patient_id']; ?>"><?php echo $patient['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Custom Invoice Item *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" name="custom_invoice_item_id" data-parsley-required="true">
			<option value="">Select Item</option>
			<?php
			$custom_invoice_items = $this->security->xss_clean($this->db->get('custom_invoice_item')->result_array());
			foreach ($custom_invoice_items as $custom_invoice_item) :
			?>
				<option <?php if ($custom_invoice_item['custom_invoice_item_id'] == $this->security->xss_clean($this->db->get_where('invoice_request', array('invoice_request_id' => $param2))->row()->table_row_id)) echo 'selected'; ?> value="<?php echo $custom_invoice_item['custom_invoice_item_id']; ?>"><?php echo $custom_invoice_item['item']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Times of occuring *</label>
	<div class="col-md-12">
		<input value="<?php echo $this->security->xss_clean($this->db->get_where('invoice_request', array('invoice_request_id' => $param2))->row()->quantity); ?>" name="quantity" data-parsley-type="number" data-parsley-min="0" class="form-control" data-parsley-required="true" placeholder="Type times of occuring" />
	</div>
</div>

<div class="form-group">
	<label class="col-md-12 col-form-label"></label>
	<div class="col-md-12">
		<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
		<button type="submit" class="btn btn-yellow pull-right">Update</button>
	</div>
</div>
<?php echo form_close(); ?>

<script>
	"use strict";
	
	$('#update_invoice_requests').parsley();
	FormPlugins.init();
</script>