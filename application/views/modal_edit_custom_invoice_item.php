<?php echo form_open('custom_invoice_items/update/' . $param2, array('id' => 'update_custom_invoice_items', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Name *</label>
	<div class="col-md-12">
		<input value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('custom_invoice_item', array('custom_invoice_item_id' => $param2))->row()->item)); ?>" name="item" type="text" data-parsley-required="true" class="form-control" placeholder="Type name of the custom invoice item" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Description *</label>
	<div class="col-md-12">
		<textarea name="content" data-parsley-required="true" class="form-control" placeholder="Type description of the custom invoice item" rows="5"><?php echo html_escape($this->security->xss_clean($this->db->get_where('custom_invoice_item', array('custom_invoice_item_id' => $param2))->row()->content)); ?></textarea>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Cost (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
	<div class="col-md-12">
		<input value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('custom_invoice_item', array('custom_invoice_item_id' => $param2))->row()->cost)); ?>" name="cost" data-parsley-type="number" data-parsley-min="0" class="form-control" data-parsley-required="true" placeholder="Type cost of the custom invoice item" />
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
	
	$('#update_custom_invoice_items').parsley();
	FormPlugins.init();
</script>