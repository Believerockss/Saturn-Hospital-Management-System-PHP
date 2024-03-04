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
			$staff_category_details = $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $param2))->result_array());
			foreach ($staff_category_details as $row) :
			?>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Duties</td>
					<td><?php if ($row['duties']) echo $row['duties'];
						else echo 'N/A'; ?></td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Created On</td>
					<td><?php echo date('d M, Y', $row['created_on']); ?></td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Created By</td>
					<td>
						<?php
						if ($this->db->get_where('user', array('user_id' => $row['created_by']))->num_rows() > 0) {
							$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['created_by']))->row()->staff_id);
							$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['created_by']))->row()->is_doctor);

							if ($is_doctor) {
								if ($this->db->get_where('doctor', array('doctor_id' => $staff_id))->num_rows() > 0)
									echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $staff_id))->row()->name);
								else 
									echo 'Doctor not found.';
							} else {
								if ($this->db->get_where('staff', array('staff_id' => $staff_id))->num_rows() > 0)
									echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $staff_id))->row()->name);
								else
									echo 'Staff not found.';
							}											
						} else {
							echo 'Created By not found.';
						}
						?>
					</td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Updated On</td>
					<td><?php echo date('d M, Y', $row['timestamp']); ?></td>
				</tr>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>Updated By</td>
					<td>
						<?php
						if ($this->db->get_where('user', array('user_id' => $row['updated_by']))->num_rows() > 0) {
							$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['updated_by']))->row()->staff_id);
							$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['updated_by']))->row()->is_doctor);

							if ($is_doctor) {
								if ($this->db->get_where('doctor', array('doctor_id' => $staff_id))->num_rows() > 0)
									echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $staff_id))->row()->name);
								else 
									echo 'Doctor not found.';
							} else {
								if ($this->db->get_where('staff', array('staff_id' => $staff_id))->num_rows() > 0)
									echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $staff_id))->row()->name);
								else
									echo 'Staff not found.';
							}											
						} else {
							echo 'Updated By not found.';
						}
						?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Close</button>
</div>