<div class="table-responsive">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Medicine</th>
				<th>Dose</th>
				<th>Medication Time</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 1;
			$treatment_details	=	$this->security->xss_clean($this->db->get_where('treatment_details', array('treatment_id' => $param2))->result_array());
			foreach ($treatment_details as $treatment_detail) :
			?>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>
						<?php 
							if ($this->db->get_where('medicine', array('medicine_id' => $treatment_detail['medicine_id']))->num_rows() > 0)
								echo $this->security->xss_clean($this->db->get_where('medicine', array('medicine_id' => $treatment_detail['medicine_id']))->row()->name); 
							else
								echo 'Medicine not found.';
						?>
					</td>
					<td><?php echo $treatment_detail['dose']; ?></td>
					<td><?php echo $treatment_detail['medication_time']; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php
	$symptoms 	= $this->security->xss_clean($this->db->get_where('treatment', array('treatment_id' => $param2))->row()->symptoms);
	$extra_note = $this->security->xss_clean($this->db->get_where('treatment', array('treatment_id' => $param2))->row()->extra_note);
	if ($symptoms) :
	?>
		<div class="note note-info">
			<h4>Symptoms</h4>
			<p><?php echo $symptoms; ?></p>
		</div>
	<?php
	endif;
	if ($extra_note) :
	?>
		<div class="note note-success">
			<h4>Extra Note</h4>
			<p><?php echo $extra_note; ?></p>
		</div>
	<?php endif; ?>

	<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Close</button>
</div>