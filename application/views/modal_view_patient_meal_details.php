<div class="table-responsive">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Time</th>
				<th>Menu</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 1;
			$patient_meals = $this->security->xss_clean($this->db->get_where('patient_meal', array('patient_meal_id' => $param2))->result_array());
			foreach ($patient_meals as $row) :
			?>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Breakfast</td>
					<td><?php if ($row['breakfast']) echo $row['breakfast'];
						else 'N/A'; ?></td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Milk Break</td>
					<td><?php if ($row['milk_break']) echo $row['milk_break'];
						else 'N/A'; ?></td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Lunch</td>
					<td><?php if ($row['lunch']) echo $row['lunch'];
						else 'N/A'; ?></td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Tea Break</td>
					<td><?php if ($row['tea_break']) echo $row['tea_break'];
						else 'N/A'; ?></td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Dinner</td>
					<td><?php if ($row['dinner']) echo $row['dinner'];
						else 'N/A'; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php
	$extra_note = $this->security->xss_clean($this->db->get_where('patient_meal', array('patient_meal_id' => $param2))->row()->extra_note);
	if ($extra_note) :
	?>
		<div class="note note-info">
			<h4>Extra Note</h4>
			<p><?php echo $extra_note; ?></p>
		</div>
	<?php endif; ?>

	<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Close</button>
</div>