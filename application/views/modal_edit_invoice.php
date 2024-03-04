<?php echo form_open('invoices/update/' . $param2, array('id' => 'create_invoices', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Patient *</label>
	<div class="col-md-12">
		<select disabled="true" style="width: 100%" class="form-control default-select2" name="patient_id" data-parsley-required="true">
			<option value="">Select patient</option>
			<?php
			$patients = $this->security->xss_clean($this->db->get('patient')->result_array());
			foreach ($patients as $patient) :
			?>
				<option <?php if ($patient['patient_id'] == $this->security->xss_clean($this->db->get_where('invoice_request', array('invoice_id' => $param2))->row()->patient_id)) echo 'selected'; ?> value="<?php echo $patient['patient_id']; ?>"><?php echo $patient['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Choose items for the invoice *</label>
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-striped m-b-0">
				<thead>
					<tr>
						<th>#</th>
						<th>Item Name</th>
						<th>Cost (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
						<th>Occurance</th>
						<th>Total (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$added_invoice_requests = [];
					foreach ($this->security->xss_clean($this->db->get_where('invoice_request', array('invoice_id' => $param2))->result_array()) as $item) {
						array_push($added_invoice_requests, $item['invoice_request_id']);
					}

					$this->db->order_by('timestamp', 'desc');
					$invoice_requests = $this->security->xss_clean($this->db->get_where('invoice_request', array('patient_id' => $this->security->xss_clean($this->db->get_where('invoice_request', array('invoice_id' => $param2))->row()->patient_id)))->result_array());
					foreach ($invoice_requests as $row) :
					?>
						<tr>
							<td>
								<div class="checkbox checkbox-css">
									<input <?php if (isset($added_invoice_requests) && in_array($row['invoice_request_id'], $added_invoice_requests)) echo 'checked'; ?> type="checkbox" id="<?php echo $row['invoice_request_id']; ?>" value="<?php echo $row['invoice_request_id']; ?>" name="invoice_request_ids[]" data-parsley-required="true" />
									<label for="<?php echo $row['invoice_request_id']; ?>"></label>
								</div>
							</td>
							<td><?php echo $row['item']; ?></td>
							<td><?php echo $row['amount']; ?></td>
							<td><?php echo $row['quantity']; ?></td>
							<td><?php echo $row['amount'] * $row['quantity']; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Discount (In percentage)</label>
	<div class="col-md-12">
		<input value="<?php echo $this->security->xss_clean($this->db->get_where('invoice', array('invoice_id' => $param2))->row()->discount); ?>" class="form-control" placeholder="Type discount" data-parsley-type="number" data-parsley-min="0" name="discount">
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
	
	$('#create_invoices').parsley();
	FormPlugins.init();
</script>