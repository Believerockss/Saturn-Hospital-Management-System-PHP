<?php echo form_open('invoice_requests/create', array('id' => 'create_invoice_requests', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Patient *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" name="patient_id" data-parsley-required="true">
			<option value="">Select patient</option>
			<?php
			$patients = $this->security->xss_clean($this->db->get('patient')->result_array());
			foreach ($patients as $patient) :
			?>
				<option value="<?php echo $patient['patient_id']; ?>"><?php echo $patient['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">
		Select Invoice Item *
		<span class="btn btn-sm btn-yellow pull-right mt-7" id="add-more">
			<i class="fa fa-plus"></i>
			<span>Add more</span>
		</span>
	</label>
	<div id="dynamic-field">
		<div class="form-inline m-b-15">
			<div class="col-md-6">
				<select style="width: 100%" class="form-control default-select2" name="custom_invoice_item_ids[]" data-parsley-required="true">
					<option value="">Select Item</option>
					<?php
					$custom_invoice_items = $this->security->xss_clean($this->db->get('custom_invoice_item')->result_array());
					foreach ($custom_invoice_items as $custom_invoice_item) :
					?>
						<option value="<?php echo $custom_invoice_item['custom_invoice_item_id']; ?>"><?php echo $custom_invoice_item['item']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-md-6">
				<input name="quantities[]" data-parsley-type="number" data-parsley-min="0" data-parsley-required="true" class="form-control inline-input wd-100" placeholder="Times of occuring" />
			</div>
		</div>
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
	
	$('#create_invoice_requests').parsley();
	FormPlugins.init();
</script>

<script type="text/javascript">
	$(document).ready(function() {
		"use strict"; 

		var i = 0;
		$('#add-more').on('click', function() {
			i++;
			$('#dynamic-field').append(`
			<div  id="row` + i + `">
				<div class="form-inline m-b-15">
					<div class="col-md-6">
						<select style="width: 100%" class="form-control default-select2" name="custom_invoice_item_ids[]" data-parsley-required="true">
							<option value="">Select Item</option>
							<?php
							$custom_invoice_items = $this->security->xss_clean($this->db->get('custom_invoice_item')->result_array());
							foreach ($custom_invoice_items as $custom_invoice_item) :
							?>
								<option value="<?php echo $custom_invoice_item['custom_invoice_item_id']; ?>"><?php echo $custom_invoice_item['item']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-md-5">
						<input name="quantities[]" data-parsley-type="number" data-parsley-min="0" data-parsley-required="true" class="form-control inline-input wd-100" placeholder="Times of occuring" />
					</div>
					<div class="col-md-1">
						<button type="button" name="remove" id="` + i + `" class="btn btn-sm btn-danger btn_remove pull-right">X</button>
					</div>
				</div>
			</div>
			`);

			FormPlugins.init();
		});

		$(document).on('click', '.btn_remove', function() {
			var button_id = $(this).attr("id");
			$('#row' + button_id).remove();
		});
	});
</script>