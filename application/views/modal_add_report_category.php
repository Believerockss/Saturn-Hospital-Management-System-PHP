<?php echo form_open('report_categories/create', array('id' => 'create_report_category', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Name *</label>
	<div class="col-md-12">
		<input name="name" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the report category" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Cost (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
	<div class="col-md-12">
		<input name="cost" data-parsley-type="number" data-parsley-min="0" data-parsley-required="true" class="form-control" placeholder="Type cost for the report category" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Laboratory *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="laboratory_id">
			<option value="">Select Laboratory for the report category</option>
			<?php
			$laboratories = $this->security->xss_clean($this->db->get('laboratory')->result_array());
			foreach ($laboratories as $laboratory) :
			?>
				<option value="<?php echo html_escape($laboratory['laboratory_id']); ?>"><?php echo $laboratory['name']; ?></option>
			<?php endforeach; ?>
		</select>
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
	
	$('#create_report_category').parsley();
	FormPlugins.init();
</script>