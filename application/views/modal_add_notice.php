<?php echo form_open('notices/create', array('id' => 'create_notice', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Title *</label>
	<div class="col-md-12">
		<input name="title" type="text" data-parsley-required="true" class="form-control" placeholder="Type title of the notice" />
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Notice *</label>
	<div class="col-md-12">
		<textarea class="ckeditor" id="editor1" name="notice"></textarea>
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
	
	$('#create_notice').parsley();
	CKEDITOR.replace('editor1');
</script>