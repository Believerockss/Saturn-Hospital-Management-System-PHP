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
			$discharge_details	=	$this->security->xss_clean($this->db->get_where('discharge_details', array('discharge_id' => $param2))->result_array());
			foreach ($discharge_details as $discharge_detail) :
			?>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>
						<?php 
							if ($this->db->get_where('medicine', array('medicine_id' => $discharge_detail['medicine_id']))->num_rows() > 0)
								echo $this->security->xss_clean($this->db->get_where('medicine', array('medicine_id' => $discharge_detail['medicine_id']))->row()->name); 
							else
								echo 'Medicine not found.';
						?>
					</td>
					<td><?php echo $discharge_detail['dose']; ?></td>
					<td><?php echo $discharge_detail['medication_time']; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php
	$conditions 	= $this->security->xss_clean($this->db->get_where('discharge', array('discharge_id' => $param2))->row()->conditions);
	$instructions 	= $this->security->xss_clean($this->db->get_where('discharge', array('discharge_id' => $param2))->row()->instructions);
	if ($conditions) :
	?>
		<div class="note note-info">
			<h4>Conditions</h4>
			<p><?php echo $conditions; ?></p>
		</div>
	<?php
	endif;
	if ($instructions) :
	?>
		<div class="note note-success">
			<h4>Instructions</h4>
			<p><?php echo $instructions; ?></p>
		</div>
	<?php endif; ?>

	<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Close</button>
</div>