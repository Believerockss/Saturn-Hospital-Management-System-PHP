<?php echo form_open('invoices/create', array('id' => 'create_invoices', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Patient *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" id="patient_id" name="patient_id" data-parsley-required="true">
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
	<label class="col-md-12 col-form-label">Choose items for the invoice</label>
	<div class="col-md-12" id="invoice_requests">
		<hr class="m-t-0 m-b-0-5">
		<p>Select a patient to view unpaid invoice items</p>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Discount (In percentage)</label>
	<div class="col-md-12">
		<input class="form-control" placeholder="Type discount" data-parsley-type="number" data-parsley-min="0" name="discount">
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

	$('#create_invoices').parsley();
	FormPlugins.init();
</script>

<script>
	"use strict";

	$('#patient_id').on('change', () => {
		$('#invoice_requests').empty();

		$.getJSON("<?php echo base_url(); ?>read_invoice_request/" + $('#patient_id').val(), function(response) {
			append_invoice_requests_data(response);
		});
	});

	var append_invoice_requests_data = function(invoice_request_data) {
		var html = '';
		if (invoice_request_data != '') {
			html = `<div class="table-responsive">
				<table class="table table-striped m-b-0">
					<thead>
						<tr>
							<th>#</th>
							<th>Item Name</th>
							<th>Cost (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
							<th>Occurance</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>`;
			invoice_request_data.forEach(function(row) {
				html += `<tr>
					<td>
						<div class="checkbox checkbox-css">
							<input type="checkbox" id="` + row.invoice_request_id + `" value="` + row.invoice_request_id + `" name="invoice_request_ids[]" data-parsley-required="true" />
							<label for="` + row.invoice_request_id + `"></label>
						</div>
					</td>
					<td>` + row.item + `</td>
					<td>` + row.amount + `</td>
					<td>` + row.quantity + `</td>
					<td>` + (row.amount * row.quantity) + `</td>
				</tr>`;
			});
			html += `</tbody>
				</table>
			</div>`;
		} else {
			html = `<hr class="m-t-0 m-b-0-5"><p>No unpaid invoice item found for selected patient</p>`;
		}

		$("#invoice_requests").append(html);
	}
</script>