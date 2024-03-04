<?php echo form_open('notices/update/' . $param2, array('id' => 'update_notice_details', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$notice_details = $this->security->xss_clean($this->db->get_where('notice', array('notice_id' => $param2))->result_array());
foreach ($notice_details as $row) :
?>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Title *</label>
		<div class="col-md-12">
			<input value="<?php echo $row['title']; ?>" name="title" type="text" data-parsley-required="true" class="form-control" placeholder="Type title of the notice" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12 col-form-label">Notice *</label>
		<div class="col-md-12">
			<textarea class="ckeditor" id="editor2" name="notice"><?php echo $row['notice']; ?></textarea>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-12 col-form-label"></label>
		<div class="col-md-12">
			<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
			<button type="submit" class="btn btn-yellow pull-right">Update</button>
		</div>
	</div>
<?php endforeach; ?>
<?php echo form_close(); ?>

<script>
	"use strict";
	
	$('#update_notice_details').parsley();
	CKEDITOR.replace('editor2');
</script>