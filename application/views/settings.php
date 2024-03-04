<!-- begin #content -->
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
		<li class="breadcrumb-item active">Settings</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">
		Update system setting information
	</h1>
	<!-- end page-header -->

	<!-- begin row -->
	<div class="row">
		<div class="col-lg-6">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
					<h4 class="panel-title">Edit System Settings</h4>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body">
					<?php echo form_open('settings/system', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
					<div class="form-group">
						<label>System Name *</label>
						<input value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_name'))->row()->content)); ?>" name="system_name" placeholder="Type system name" class="form-control" type="text" data-parsley-required="true">
					</div>
					<div class="form-group">
						<label>System Tagline *</label>
						<input value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_tagline'))->row()->content)); ?>" name="system_tagline" placeholder="Type system tagline" class="form-control" type="text" data-parsley-required="true">
					</div>
					<div class="form-group">
						<label>Currency *</label>
						<select style="width: 100%" class="form-control default-select2" name="currency" data-parsley-required="true">
							<option value="">Select currency</option>
							<?php
							$currencies = $this->security->xss_clean($this->db->get('currency')->result_array());
							foreach ($currencies as $currency) :
							?>
								<option <?php if ($currency['code'] == $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content)) echo 'selected'; ?> value="<?php echo $currency['code']; ?>"><?php echo $currency['name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label>System Font *</label>
						<select style="width: 100%" class="form-control default-select2" name="font" data-parsley-required="true">
							<option value="">Select font</option>
							<option <?php if ('PT Sans Narrow' == $this->security->xss_clean($this->db->get_where('setting', array('item' => 'font_family'))->row()->content)) echo 'selected'; ?> value="PT Sans Narrow">PT Sans Narrow</option>
							<option <?php if ('Josefin Sans' == $this->security->xss_clean($this->db->get_where('setting', array('item' => 'font_family'))->row()->content)) echo 'selected'; ?> value="Josefin Sans">Josefin Sans</option>
							<option <?php if ('Titillium Web' == $this->security->xss_clean($this->db->get_where('setting', array('item' => 'font_family'))->row()->content)) echo 'selected'; ?> value="Titillium Web">Titillium Web</option>
							<option <?php if ('Mukta' == $this->security->xss_clean($this->db->get_where('setting', array('item' => 'font_family'))->row()->content)) echo 'selected'; ?> value="Mukta">Mukta</option>
							<option <?php if ('PT Sans' == $this->security->xss_clean($this->db->get_where('setting', array('item' => 'font_family'))->row()->content)) echo 'selected'; ?> value="PT Sans">PT Sans</option>
							<option <?php if ('Rubik' == $this->security->xss_clean($this->db->get_where('setting', array('item' => 'font_family'))->row()->content)) echo 'selected'; ?> value="Rubik">Rubik</option>
							<option <?php if ('Oswald' == $this->security->xss_clean($this->db->get_where('setting', array('item' => 'font_family'))->row()->content)) echo 'selected'; ?> value="Oswald">Oswald</option>
							<option <?php if ('Poppins' == $this->security->xss_clean($this->db->get_where('setting', array('item' => 'font_family'))->row()->content)) echo 'selected'; ?> value="Poppins">Poppins</option>
							<option <?php if ('Open Sans' == $this->security->xss_clean($this->db->get_where('setting', array('item' => 'font_family'))->row()->content)) echo 'selected'; ?> value="Open Sans">Open Sans</option>
							<option <?php if ('Cantarell' == $this->security->xss_clean($this->db->get_where('setting', array('item' => 'font_family'))->row()->content)) echo 'selected'; ?> value="Cantarell">Cantarell</option>
							<option <?php if ('Ubuntu' == $this->security->xss_clean($this->db->get_where('setting', array('item' => 'font_family'))->row()->content)) echo 'selected'; ?> value="Ubuntu">Ubuntu</option>
						</select>
					</div>
					<div class="form-group">
						<label>System Address *</label>
						<input value="<?php echo html_escape(explode('<br>', $this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_address'))->row()->content))[0]); ?>" name="system_address_1" placeholder="Type system address line 1" class="form-control" type="text" data-parsley-required="true">
					</div>
					<div class="form-group">
						<input value="<?php echo html_escape(explode('<br>', $this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_address'))->row()->content))[1]); ?>" name="system_address_2" placeholder="Type system address line 2" class="form-control" type="text" data-parsley-required="true">
					</div>
					<div class="form-group">
						<label>System Phone *</label>
						<input value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_phone'))->row()->content)); ?>" name="system_phone" placeholder="Type system phone" class="form-control" type="text" data-parsley-required="true">
					</div>
					<div class="form-group">
						<label>System Website *</label>
						<input value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_website'))->row()->content)); ?>" name="system_website" placeholder="Type system website" class="form-control" type="text" data-parsley-required="true">
					</div>
					<div class="form-group">
						<label>System Email *</label>
						<input value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_email'))->row()->content)); ?>" name="system_email" placeholder="Type system email" class="form-control" type="text" data-parsley-required="true">
					</div>

					<button type="submit" class="mb-sm btn btn-yellow">Update</button>
					<?php echo form_close(); ?>
					<!-- end panel-body -->
				</div>
			</div>
			<!-- end panel -->
		</div>
		<div class="col-lg-6">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
					<h4 class="panel-title">Edit Login Background</h4>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body">
					<?php echo form_open_multipart('settings/login_bg', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
					<p>Current Background</p>
					<img width="75%" src="<?php echo base_url(); ?>uploads/website/<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'login_bg'))->row()->content); ?>" />
					<hr>
					<div class="note note-secondary note-purple m-b-15">
						<span>Recommended dimension for the image is 1920 X 1280</span>
					</div>
					<hr>
					<div class="form-group">
						<label>Login Background *</label>
						<div>
							<span class="btn btn-sm btn-yellow fileinput-button">
								<i class="fa fa-plus"></i>
								<span>Add image</span>
								<input name="image_link" type="file" data-parsley-required="true">
							</span>
						</div>
					</div>
					<hr>

					<button type="submit" class="mb-sm btn btn-yellow">Update</button>
					<?php echo form_close(); ?>
					<!-- end panel-body -->
				</div>
			</div>
			<!-- end panel -->
		</div>
		<div class="col-lg-6">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
					<h4 class="panel-title">Edit Meal Plans Cost</h4>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body">
					<?php echo form_open('settings/meal', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
					<div class="form-group">
						<label>Breakfast (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
						<input value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('setting', array('item' => 'breakfast_price'))->row()->content)); ?>" name="breakfast_price" placeholder="Enter breakfast price" class="form-control" data-parsley-required="true" data-parsley-min="0" data-parsley-type="number">
					</div>
					<div class="form-group">
						<label>Milk Break (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
						<input data-parsley-min="0" value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('setting', array('item' => 'milk_break_price'))->row()->content)); ?>" name="milk_break_price" placeholder="Enter milk break price" class="form-control" data-parsley-required="true" data-parsley-min="0" data-parsley-type="number">
					</div>
					<div class="form-group">
						<label>Lunch (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
						<input data-parsley-min="0" value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('setting', array('item' => 'lunch_price'))->row()->content)); ?>" name="lunch_price" placeholder="Enter lunch price" class="form-control" data-parsley-required="true" data-parsley-min="0" data-parsley-type="number">
					</div>
					<div class="form-group">
						<label>Tea Break (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
						<input data-parsley-min="0" value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('setting', array('item' => 'tea_break_price'))->row()->content)); ?>" name="tea_break_price" placeholder="Enter tea break price" class="form-control" data-parsley-required="true" data-parsley-min="0" data-parsley-type="number">
					</div>
					<div class="form-group">
						<label>Dinner (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
						<input data-parsley-min="0" value="<?php echo html_escape($this->security->xss_clean($this->db->get_where('setting', array('item' => 'dinner_price'))->row()->content)); ?>" name="dinner_price" placeholder="Enter dinner price" class="form-control" data-parsley-required="true" data-parsley-min="0" data-parsley-type="number">
					</div>

					<button type="submit" class="mb-sm btn btn-yellow">Update</button>
					<?php echo form_close(); ?>
					<!-- end panel-body -->
				</div>
			</div>
			<!-- end panel -->	
		</div>
		<div class="col-lg-6">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
					<h4 class="panel-title">Edit Favicon</h4>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body">
					<?php echo form_open_multipart('settings/favicon', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
					<p>Current Favicon</p>
					<img width="80px" src="<?php echo base_url(); ?>uploads/website/<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'favicon'))->row()->content); ?>" />
					<hr>
					<div class="note note-secondary note-purple m-b-15">
						<span>Recommended dimension for the image is 64 X 64</span>
					</div>
					<hr>
					<div class="form-group">
						<label>Favicon *</label>
						<div>
							<span class="btn btn-sm btn-yellow fileinput-button">
								<i class="fa fa-plus"></i>
								<span>Add image</span>
								<input name="image_link" type="file" data-parsley-required="true">
							</span>
						</div>
					</div>
					<hr>

					<button type="submit" class="mb-sm btn btn-yellow">Update</button>
					<?php echo form_close(); ?>
					<!-- end panel-body -->
				</div>
			</div>
			<!-- end panel -->
		</div>
		<!-- end col-12 -->
	</div>
	<!-- end row -->
</div>
<!-- end #content -->