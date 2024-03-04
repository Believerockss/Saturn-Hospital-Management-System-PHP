<!-- begin #content -->
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
		<li class="breadcrumb-item active"><?php echo $this->security->xss_clean($page_title); ?></li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">
		<div class="btn-group">
			<a href="javascript:;" data-toggle="dropdown" class="btn btn-inverse dropdown-toggle" aria-expanded="false">
				<i class="fa fa-plus"></i> Add Feedback &amp; Ratings
			</a>
			<ul class="dropdown-menu pull-right">
				<li>
					<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_feedback');" href="javascript:;">Feedback</a>
				</li>
				<li>
					<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_rating');" href="javascript:;">Rating</a>
				</li>
			</ul>
		</div>
	</h1>
	<!-- end page-header -->

	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-md-12">
			<!-- begin nav-tabs -->
			<ul class="nav nav-tabs">
				<li class="nav-items">
					<a href="#feedback-tab" data-toggle="tab" class="nav-link active">
						<span class="d-sm-none">Feedback</span>
						<span class="d-sm-block d-none">
							<i class="fa fa-comment"></i> Feedback
						</span>
					</a>
				</li>
				<li class="nav-items">
					<a href="#ratings-tab" data-toggle="tab" class="nav-link">
						<span class="d-sm-none">Ratings</span>
						<span class="d-sm-block d-none">
							<i class="fa fa-star"></i> Ratings
						</span>
					</a>
				</li>
			</ul>
			<!-- end nav-tabs -->
			<!-- begin tab-content -->
			<div class="tab-content">
				<!-- begin tab-pane -->
				<div class="tab-pane fade active show" id="feedback-tab">
					<div class="panel-body">
						<table id="data-table-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Staff</th>
									<th>Staff Category</th>
									<th>Feedback</th>
									<th>Created On</th>
									<th>Created By</th>
									<th>Updated On</th>
									<th>Updated By</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$feedback_count = 1;
								$this->db->order_by('timestamp', 'desc');
								$feedback_details = $this->security->xss_clean($this->db->get('feedback')->result_array());
								foreach ($feedback_details as $feedback) :
								?>
									<tr>
										<td><?php echo $feedback_count++; ?></td>
										<td>
											<?php
											if ($this->db->get_where('user', array('user_id' => $feedback['user_id']))->num_rows() > 0) {
												$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $feedback['user_id']))->row()->staff_id);
												$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $feedback['user_id']))->row()->is_doctor);

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
												echo 'User not found.';
											}
											?>
										</td>
										<td>
											<?php
												if ($this->db->get_where('user', array('user_id' => $feedback['user_id']))->num_rows() > 0) {
													$staff_category_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $feedback['user_id']))->row()->staff_category_id);
													if ($this->db->get_where('staff_category', array('staff_category_id' => $staff_category_id))->num_rows() > 0)
														echo $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $staff_category_id))->row()->name);
													else 
														echo 'Staff Category not found.';

												} else {
													echo 'User not found.';
												}
											?>
										</td>
										<td><?php echo $feedback['feedback']; ?></td>
										<td><?php echo date('d M, Y', $feedback['created_on']); ?></td>
										<td>
											<?php
											if ($this->db->get_where('user', array('user_id' => $feedback['created_by']))->num_rows() > 0) {
												$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $feedback['created_by']))->row()->staff_id);
												$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $feedback['created_by']))->row()->is_doctor);

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
										<td><?php echo date('d M, Y', $feedback['timestamp']); ?></td>
										<td>
											<?php
											if ($this->db->get_where('user', array('user_id' => $feedback['updated_by']))->num_rows() > 0) {
												$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $feedback['updated_by']))->row()->staff_id);
												$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $feedback['updated_by']))->row()->is_doctor);

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
										<td>
											<?php if ($this->session->userdata('user_id') == $feedback['created_by']) : ?>
												<div class="btn-group">
													<button type="button" class="btn btn-white btn-xs">Action</button>
													<button type="button" class="btn btn-white btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														<span class="sr-only">Toggle Dropdown</span>
													</button>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_feedback_details/<?php echo $feedback['feedback_id']; ?>');" href="javascript:;">Edit Details</a>
														<div class="dropdown-divider"></div>
														<a class="dropdown-item" onclick="confirm_modal('<?php echo base_url(); ?>feedback_and_ratings/feedback/delete/<?php echo $feedback['feedback_id']; ?>');" href="javascript:;">Remove</a>
													</div>
												</div>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- end tab-pane -->
				<!-- begin tab-pane -->
				<div class="tab-pane fade" id="ratings-tab">
					<div class="panel-body">
						<table id="data-table-responsive" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Staff</th>
									<th>Staff Category</th>
									<th>Rating</th>
									<th>Created On</th>
									<th>Created By</th>
									<th>Updated On</th>
									<th>Updated By</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$rating_count = 1;
								$this->db->order_by('timestamp', 'desc');
								$ratings = $this->security->xss_clean($this->db->get('rating')->result_array());
								foreach ($ratings as $rating) :
								?>
									<tr>
										<td><?php echo $rating_count++; ?></td>
										<td>
											<?php
											if ($this->db->get_where('user', array('user_id' => $rating['user_id']))->num_rows() > 0) {
												$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $rating['user_id']))->row()->staff_id);
												$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $rating['user_id']))->row()->is_doctor);

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
												echo 'User not found.';
											}
											?>
										</td>
										<td>
											<?php
												if ($this->db->get_where('user', array('user_id' => $rating['user_id']))->num_rows() > 0) {
													$staff_category_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $rating['user_id']))->row()->staff_category_id);
													if ($this->db->get_where('staff_category', array('staff_category_id' => $staff_category_id))->num_rows() > 0)
														echo $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $staff_category_id))->row()->name);
													else 
														echo 'Staff Category not found.';

												} else {
													echo 'User not found.';
												}
											?>
										</td>
										<td><?php echo $rating['rating']; ?></td>
										<td><?php echo date('d M, Y', $rating['created_on']); ?></td>
										<td>
											<?php
											if ($this->db->get_where('user', array('user_id' => $rating['created_by']))->num_rows() > 0) {
												$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $rating['created_by']))->row()->staff_id);
												$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $rating['created_by']))->row()->is_doctor);

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
										<td><?php echo date('d M, Y', $rating['timestamp']); ?></td>
										<td>
											<?php
											if ($this->db->get_where('user', array('user_id' => $rating['updated_by']))->num_rows() > 0) {
												$staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $rating['updated_by']))->row()->staff_id);
												$is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $rating['updated_by']))->row()->is_doctor);

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
										<td>
											<?php if ($this->session->userdata('user_id') == $rating['created_by']) : ?>
												<div class="btn-group">
													<button type="button" class="btn btn-white btn-xs">Action</button>
													<button type="button" class="btn btn-white btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														<span class="sr-only">Toggle Dropdown</span>
													</button>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_rating_details/<?php echo $rating['rating_id']; ?>');" href="javascript:;">Edit Details</a>
														<div class="dropdown-divider"></div>
														<a class="dropdown-item" onclick="confirm_modal('<?php echo base_url(); ?>feedback_and_ratings/ratings/delete/<?php echo $rating['rating_id']; ?>');" href="javascript:;">Remove</a>
													</div>
												</div>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- end tab-pane -->
			</div>
			<!-- end tab-content -->
		</div>
		<!-- end col-12 -->
	</div>
	<!-- end row -->
</div>
<!-- end #content -->