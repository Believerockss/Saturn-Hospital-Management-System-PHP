<!-- begin #content -->
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
		<li class="breadcrumb-item active"><?php echo $page_title; ?></li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">
		<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_staff_category');" href="javascript:;" class="btn btn-inverse m-r-5">
			<i class="fa fa-plus"></i> Add Staff Category
		</a>
	</h1>
	<!-- end page-header -->

	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-md-12">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<div class="panel-body">
					<table id="data-table-buttons" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Category Name</th>
								<th>Number of Staff</th>
								<th>Employment Type</th>
								<th>Payment Type</th>
								<th>Pay Scale</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 1;
							$this->db->order_by('timestamp', 'desc');
							$staff_categories = $this->db->get('staff_category')->result_array();
							foreach ($staff_categories as $staff_category) :
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td>
										<a href="<?php echo base_url(); ?>staff/<?php echo $staff_category['staff_category_id']; ?>">
											<?php echo $staff_category['name']; ?>
										</a>
									</td>
									<td>
										<?php
										if ($staff_category['is_doctor'])
											echo $this->db->get_where('doctor', array('staff_category_id' => $staff_category['staff_category_id']))->num_rows();
										else
											echo $this->db->get_where('staff', array('staff_category_id' => $staff_category['staff_category_id']))->num_rows();
										?>
									</td>
									<td>
										<?php
										if ($staff_category['is_doctor'] == 0)
											echo 'Not as a Doctor';
										elseif ($staff_category['is_doctor'] == 1)
											echo 'As a Doctor';
										?>
									</td>
									<td>
										<?php
										if ($staff_category['payment_type'] == 1)
											echo '<span class="badge badge-inverse">Monthly</span>';
										elseif ($staff_category['payment_type'] == 2)
											echo '<span class="badge badge-primary">Shiftwise</span>';
										?>
									</td>
									<td>
										<?php
										if ($staff_category['pay_scale'])
											echo $staff_category['pay_scale'];
										else
											echo 'N/A';
										?>
									</td>
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-white btn-xs">Action</button>
											<button type="button" class="btn btn-white btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_view_staff_category_details/<?php echo $staff_category['staff_category_id']; ?>');" href="javascript:;">Show Details</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_staff_category/<?php echo $staff_category['staff_category_id']; ?>');" href="javascript:;">Edit Category</a>
												<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_staff_permission/<?php echo $staff_category['staff_category_id']; ?>');" href="javascript:;">Edit Permission</a>
											</div>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- end panel -->
		</div>
		<!-- end col-12 -->
	</div>
	<!-- end row -->
</div>
<!-- end #content -->