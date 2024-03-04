<?php echo form_open('tickets/update/' . $param2, array('id' => 'edit_ticket', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Details *</label>
	<div class="col-md-12">
        <textarea rows="10" style="resize: none" data-parsley-required="true" type="text" name="content" placeholder="Type details of the ticket" class="form-control"></textarea>
	</div>
</div>

<div class="form-group">
	<label class="col-md-12 col-form-label"></label>
	<div class="col-md-12">
		<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
		<button type="submit" class="btn btn-yellow pull-right">Reply</button>
	</div>
</div>
<?php echo form_close(); ?>

<script>
	$('#edit_ticket').parsley();
</script>