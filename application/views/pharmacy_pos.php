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
				<i class="fa fa-plus"></i> Add Pharmacy Sale
			</a>
			<ul class="dropdown-menu pull-right">
				<li>
					<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_pharmacy_sale_patient');" href="javascript:;">Existing Patient</a>
				</li>
				<li>
					<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_add_pharmacy_sale_cusotmer');" href="javascript:;">New Customer</a>
				</li>
			</ul>
		</div>
	</h1>
	<!-- end page-header -->

	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-md-4">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<div class="panel-body">
					<?php echo form_open('pharmacy_sales/add', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
					<div class="form-group">
						<label class="control-label">Product *</label>
						<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="pharmacy_inventory_id">
							<option value="">Select product</option>
							<?php
							$products = $this->security->xss_clean($this->db->get('pharmacy_inventory')->result_array());
							foreach ($products as $product) :
							?>
								<option value="<?php echo html_escape($product['pharmacy_inventory_id']); ?>"><?php echo $product['name'] . ' (' . $product['code'] . ')'; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label>Quantity</label>
						<input value="1" class="form-control" placeholder="Type quantity" data-parsley-type="number" data-parsley-min="0" name="quantity">
					</div>
					<button type="submit" class="btn btn-yellow m-r-5 m-t-9">Add to Cart</button>
					<?php echo form_close(); ?>
				</div>
			</div>
			<!-- end panel -->
		</div>
		<div class="col-md-8">
			<div class="panel panel-inverse">
				<div class="panel-body">
					<table id="data-table-buttons" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Product Code</th>
								<th>Quantity</th>
								<th>Price (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 1;
							foreach ($this->cart->contents() as $item) :
								if ($item['sold_from'] == 'pharmacy') :
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo $item['name']; ?></td>
									<td>
										<?php 
											if ($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $item['id']))->num_rows() > 0)
												echo $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $item['id']))->row()->code); 
											else
												echo 'Product Code not found.';
										?>
									</td>
									<td>
										<?php 
											if ($this->db->get_where('unit', array('unit_id' => $item['unit_id']))->num_rows() > 0)
												echo $item['qty'] . ' ' . $this->security->xss_clean($this->db->get_where('unit', array('unit_id' => $item['unit_id']))->row()->name); 
											else 
												echo $item['qty'];
										?>
									</td>
									<td><?php echo $item['qty'] . ' X ' . $item['price'] . ' = ' . $item['qty'] * $item['price']; ?></td>
									<td>
										<div class="btn-group">
											<a class="btn btn-xs btn-white" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_pharmacy_sales/<?php echo $item['rowid']; ?>/<?php echo $item['qty']; ?>');" href="javascript:;">
												<i class="fa fa-cog"></i> Edit item
											</a>
											<a class="btn btn-xs btn-white" onclick="confirm_modal('<?php echo base_url(); ?>pharmacy_sales/remove/<?php echo $item['rowid']; ?>');" href="javascript:;">
												<i class="fa fa-trash"></i> Remove item
											</a>
										</div>
									</td>
								</tr>
							<?php
								endif;
							endforeach;
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- end col-12 -->
	</div>
	<!-- end row -->
</div>
<!-- end #content -->