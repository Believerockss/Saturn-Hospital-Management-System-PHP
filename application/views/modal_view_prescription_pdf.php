<?php // echo form_open('email_invoice/' . $param2, array('id' => 'show_invoice', 'method' => 'post')); ?>
<div class="form-group">
	<label>Prescription preview</label>
	<br>
	<embed src="<?php echo base_url(); ?>uploads/prescriptions/<?php echo html_escape($param2 . '.pdf'); ?>" width="100%" height="640px">
</div>

<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Close</button>

<!-- <button type="submit" class="mb-sm btn btn-primary"><?php //echo $this->lang->line('send_email'); ?></button> -->
<?php // echo form_close(); ?>

<script>
	$('.modal-dialog').css('max-width', '720px');
</script>