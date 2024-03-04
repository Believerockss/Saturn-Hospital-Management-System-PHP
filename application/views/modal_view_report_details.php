<div class="table-responsive">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Report Category</th>
				<th>Laboratory</th>
				<th>Report Cost (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
				<th>Date</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 1;
			$report_details = $this->db->get_where('report_details', array('report_id' => $param2))->result_array();
			foreach ($report_details as $row) :
			?>
				<tr>
					<td><?php echo $count++; ?></td>
					<td>
						<?php 
							if ($this->db->get_where('report_category', array('report_category_id' => $row['report_category_id']))->num_rows() > 0)
								echo $this->security->xss_clean($this->db->get_where('report_category', array('report_category_id' => $row['report_category_id']))->row()->name); 
							else
								echo 'Report Category not found.';
						?>
					</td>
					<td>
						<?php 
							if ($this->db->get_where('report_category', array('report_category_id' => $row['report_category_id']))->num_rows() > 0) {
								$laboratory_id = $this->db->get_where('report_category', array('report_category_id' => $row['report_category_id']))->row()->laboratory_id;
								if ($this->db->get_where('laboratory', array('laboratory_id' => $laboratory_id))->num_rows() > 0) {
									echo $this->db->get_where('laboratory', array('laboratory_id' => $laboratory_id))->row()->name . '(' . $this->db->get_where('laboratory', array('laboratory_id' => $laboratory_id))->row()->room_number . ')';
								} else {
									echo 'Laboratory not found.';
								}
							} else {
								echo 'Report Category not found.';
							}								
						?>
					</td>
					<td><?php echo $row['total']; ?></td>
					<td><?php echo date('d M, Y', $row['timestamp']); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Close</button>
</div>