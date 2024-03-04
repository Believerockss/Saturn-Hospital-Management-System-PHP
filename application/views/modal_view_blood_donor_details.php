<div class="table-responsive">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Content</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 1;
			$blood_donor_details = $this->db->get_where('blood_donor', array('blood_donor_id' => $param2))->result_array();
			foreach ($blood_donor_details as $row) :
			?>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Email</td>
					<td><?php if ($row['email']) echo $row['email'];
						else echo 'N/A'; ?></td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Address</td>
					<td><?php if ($row['address']) echo $row['address'];
						else echo 'N/A'; ?></td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Sex</td>
					<td>
						<?php
						if ($row['sex_id'] == 1)
							echo 'Male';
						elseif ($row['sex_id'] == 2)
							echo 'Female';
						else
							echo 'Other';
						?>
					</td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Date of Birth</td>
					<td><?php if ($row['dob']) echo date('d M, Y', $row['dob']);
						else echo 'N/A'; ?></td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Age</td>
					<td><?php if ($row['age']) echo $row['age'];
						else echo 'N/A'; ?></td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Profession</td>
					<td>
						<?php 
							if ($row['profession_id']) {
								if ($this->db->get_where('profession', array('profession_id' => $row['profession_id']))->num_rows() > 0)
									echo $this->security->xss_clean($this->db->get_where('profession', array('profession_id' => $row['profession_id']))->row()->name);
								else 
									echo 'Profession not found.';
							} else { echo 'N/A'; }
						?>
					</td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Purpose</td>
					<td><?php if ($row['purpose']) echo $row['purpose'];
						else echo 'N/A'; ?></td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Health Status</td>
					<td><?php if ($row['health_status']) echo $row['health_status'];
						else echo 'N/A'; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Close</button>
</div>