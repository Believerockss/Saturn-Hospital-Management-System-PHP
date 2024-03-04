<?php echo form_open('payroll/update/' . $param2, array('id' => 'update_payroll', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$user_id	=	$this->security->xss_clean($this->db->get_where('payroll', array('payroll_id' => $param2))->row()->user_id);
$year 		= 	$this->security->xss_clean($this->db->get_where('payroll', array('payroll_id' => $param2))->row()->year);
$month 		=	$this->security->xss_clean($this->db->get_where('payroll', array('payroll_id' => $param2))->row()->month);
$amount 	=	$this->security->xss_clean($this->db->get_where('payroll', array('payroll_id' => $param2))->row()->amount);
?>
<div class="form-group">
	<label class="col-md-12 col-form-label">Staff *</label>
	<div class="col-md-12">
		<select disabled="true" style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="user_id">
			<option value="">Select staff</option>
			<?php
			$staff_categories = $this->security->xss_clean($this->db->get_where('staff_category', array('pay_scale >' => 0))->result_array());
			foreach ($staff_categories as $staff_category) :
			?>
				<optgroup label="<?php echo $staff_category['name']; ?>">
					<?php
					if ($staff_category['is_doctor']) :
						$doctors =  $this->security->xss_clean($this->db->get_where('doctor', array('staff_category_id' => $staff_category['staff_category_id']))->result_array());
						foreach ($doctors as $doctor) :
							$doctor_user_id = $this->security->xss_clean($this->db->get_where('user', array('staff_category_id' => $staff_category['staff_category_id'], 'staff_id' => $doctor['doctor_id']))->row()->user_id);
					?>
							<option <?php if ($user_id == $doctor_user_id) echo 'selected'; ?> value="<?php echo html_escape($doctor_user_id); ?>"><?php echo $doctor['name']; ?></option>
						<?php
						endforeach;
					else :
						$staff =  $this->security->xss_clean($this->db->get_where('staff', array('staff_category_id' => $staff_category['staff_category_id']))->result_array());
						foreach ($staff as $row) :
							$staff_user_id = $this->security->xss_clean($this->db->get_where('user', array('staff_category_id' => $staff_category['staff_category_id'], 'staff_id' => $row['staff_id']))->row()->user_id);
						?>
							<option <?php if ($user_id == $staff_user_id) echo 'selected'; ?> value="<?php echo html_escape($staff_user_id); ?>"><?php echo $row['name']; ?></option>
					<?php
						endforeach;
					endif;
					?>
				</optgroup>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Year *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="year">
			<option value="">Select Year</option>
			<option <?php if ($year == date('Y') - 4) echo 'selected'; ?> value="<?php echo date('Y') - 4; ?>"><?php echo date('Y') - 4; ?></option>
			<option <?php if ($year == date('Y') - 3) echo 'selected'; ?> value="<?php echo date('Y') - 3; ?>"><?php echo date('Y') - 3; ?></option>
			<option <?php if ($year == date('Y') - 2) echo 'selected'; ?> value="<?php echo date('Y') - 2; ?>"><?php echo date('Y') - 2; ?></option>
			<option <?php if ($year == date('Y') - 1) echo 'selected'; ?> value="<?php echo date('Y') - 1; ?>"><?php echo date('Y') - 1; ?></option>
			<option <?php if ($year == date('Y')) echo 'selected'; ?> value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
			<option <?php if ($year == date('Y') + 1) echo 'selected'; ?> value="<?php echo date('Y') + 1; ?>"><?php echo date('Y') + 1; ?></option>
			<option <?php if ($year == date('Y') + 2) echo 'selected'; ?> value="<?php echo date('Y') + 2; ?>"><?php echo date('Y') + 2; ?></option>
			<option <?php if ($year == date('Y') + 3) echo 'selected'; ?> value="<?php echo date('Y') + 3; ?>"><?php echo date('Y') + 3; ?></option>
			<option <?php if ($year == date('Y') + 4) echo 'selected'; ?> value="<?php echo date('Y') + 4; ?>"><?php echo date('Y') + 4; ?></option>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Month *</label>
	<div class="col-md-12">
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="month">
			<option value="">Select Month</option>
			<option <?php if ($month == 'January') echo 'selected'; ?> value="January">January</option>
			<option <?php if ($month == 'February') echo 'selected'; ?> value="February">February</option>
			<option <?php if ($month == 'March') echo 'selected'; ?> value="March">March</option>
			<option <?php if ($month == 'April') echo 'selected'; ?> value="April">April</option>
			<option <?php if ($month == 'May') echo 'selected'; ?> value="May">May</option>
			<option <?php if ($month == 'June') echo 'selected'; ?> value="June">June</option>
			<option <?php if ($month == 'July') echo 'selected'; ?> value="July">July</option>
			<option <?php if ($month == 'August') echo 'selected'; ?> value="August">August</option>
			<option <?php if ($month == 'September') echo 'selected'; ?> value="September">September</option>
			<option <?php if ($month == 'October') echo 'selected'; ?> value="October">October</option>
			<option <?php if ($month == 'November') echo 'selected'; ?> value="November">November</option>
			<option <?php if ($month == 'December') echo 'selected'; ?> value="December">December</option>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-md-12 col-form-label">Amount (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>) *</label>
	<div class="col-md-12">
		<input value="<?php echo $amount; ?>" class="form-control" placeholder="Type amount" name="amount" data-parsley-required="true" data-parsley-min="0" data-parsley-type="number">
	</div>
</div>

<div class="form-group">
	<label class="col-md-12 col-form-label"></label>
	<div class="col-md-12">
		<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
		<button type="submit" class="btn btn-yellow pull-right">Update</button>
	</div>
</div>
<?php echo form_close(); ?>

<script>
	"use strict";
	
	$('#update_payroll').parsley();
	FormPlugins.init();
</script>