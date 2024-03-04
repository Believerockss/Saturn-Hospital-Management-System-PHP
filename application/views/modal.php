<script type="text/javascript">
	"use strict";

	function showAjaxModal(url) {
		// Loading the ajax modal
		jQuery('#modal_ajax').modal('show');

		//Show ajax response on request success
		$.ajax({
			url: url,
			success: function(response) {
				jQuery('#modal_ajax .modal-body').html(response);
			}
		});
	}
</script>

<!-- Ajax modal -->
<div class="modal fade" id="modal_ajax" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body"></div>
		</div>
	</div>
</div>


<script type="text/javascript">
	"use strict";

	function confirm_modal(delete_url) {
		jQuery('#modal_delete').modal('show');
		document.getElementById('delete_link').setAttribute('href', delete_url);
	}

	function confirm_close_modal(close_url) {
		jQuery('#modal_close').modal('show', {
			backdrop: 'static'
		});
		document.getElementById('close_link').setAttribute('href', close_url);
	}
</script>

<!-- Delete modal -->
<div class="modal fade" id="modal_delete" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Are you sure you want to remove this?</h4>
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-danger" id="delete_link">Yes</a>
				<a href="javascript:;" class="btn btn-info" data-dismiss="modal">Cancel</a>
			</div>
		</div>
	</div>
</div>

<!-- CLose modal -->
<div class="modal fade" id="modal_close" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Are you sure you want to close this ticket?</h4>
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-danger" id="close_link">Close</a>
				<a href="javascript:;" class="btn btn-info" data-dismiss="modal">Cancel</a>
			</div>
		</div>
	</div>
</div>