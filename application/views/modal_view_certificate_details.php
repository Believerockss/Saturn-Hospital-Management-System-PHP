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
			$certificate_details = $this->db->get_where('certificate', array('certificate_id' => $param2))->result_array();
			foreach ($certificate_details as $row) :
			?>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Father's Name</td>
					<td><?php if ($row['father_name']) echo $row['father_name'];
						else echo 'N/A'; ?></td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Mother's Name</td>
					<td><?php if ($row['mother_name']) echo $row['mother_name'];
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
					<td>Address</td>
					<td><?php if ($row['address']) echo $row['address'];
						else echo 'N/A'; ?></td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Place</td>
					<td><?php if ($row['place']) echo $row['place'];
						else echo 'N/A'; ?></td>
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
				<?php if (!$row['certificate_type']) : ?>
					<tr>
						<td><?php echo $count++; ?></td>
						<td>Date of Death</td>
						<td><?php if ($row['dod']) echo date('d M, Y', $row['dod']);
							else echo 'N/A'; ?></td>
					</tr>
				<?php endif; ?>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Reason</td>
					<td><?php if ($row['reason']) echo $row['reason'];
						else echo 'N/A'; ?></td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Email</td>
					<td><?php if ($row['email']) echo $row['email'];
						else echo 'N/A'; ?></td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Mobile Number</td>
					<td><?php if ($row['mobile_number']) echo $row['mobile_number'];
						else echo 'N/A'; ?></td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Extra Note</td>
					<td><?php if ($row['extra_note']) echo $row['extra_note'];
						else echo 'N/A'; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Close</button>
</div>