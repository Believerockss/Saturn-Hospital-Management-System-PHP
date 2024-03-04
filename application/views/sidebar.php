<!-- begin #sidebar -->
<div id="sidebar" class="sidebar" data-disable-slide-animation="true">
	<!-- begin sidebar scrollbar -->
	<div data-scrollbar="true" data-height="100%">
		<!-- begin sidebar user -->
		<ul class="nav">
			<li class="nav-profile">
				<?php
				if ($this->session->userdata('user_type') == 'staff') :
				$sidebar_staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->staff_id);
				$sidebar_staff_category_id =  $this->security->xss_clean($this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->staff_category_id);
				$sidebar_is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->is_doctor);
				?>
				<div class="text-center">
					<div class="cover with-shadow"></div>
					<div class="image">
						<?php if ($sidebar_is_doctor) : ?>
							<img align="middle" src="<?php echo base_url(); ?>uploads/<?php echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $sidebar_staff_id))->row()->image_link) ? 'doctor/' . $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $sidebar_staff_id))->row()->image_link) : 'website/default_user.png'; ?>" alt="t1m9m" />
						<?php else : ?>
							<img align="middle" src="<?php echo base_url(); ?>uploads/<?php echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $sidebar_staff_id))->row()->image_link) ? 'staff/' . $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $sidebar_staff_id))->row()->image_link) : 'website/default_user.png'; ?>" alt="t1m9m" />
						<?php endif; ?>
					</div>
					<div class="info">
						<?php
						if ($sidebar_is_doctor) {
							echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $sidebar_staff_id))->row()->name);
							echo '<small>' . $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $sidebar_staff_category_id))->row()->name) . '</small>';
						} else {
							echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $sidebar_staff_id))->row()->name);
							echo '<small>' . $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $sidebar_staff_category_id))->row()->name) . '</small>';
						}
						?>
					</div>
				</div>
				<?php else: ?>
				<div class="text-center">
					<div class="cover with-shadow"></div>
					<div class="image">
						<img align="middle" src="<?php echo base_url(); ?>uploads/website/default_user.png" alt="t1m9m" />
					</div>
					<div class="info">
						<?php
							echo $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $this->session->userdata('user_id')))->row()->name);
							echo '<small>Patient</small>';
						?>
					</div>
				</div>
				<?php endif; ?>
			</li>
		</ul>
		<!-- end sidebar user -->
		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="nav-header">Navigation</li>
			<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'dashboard'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
				<li class="<?php if ($page_name == 'dashboard') echo 'active'; ?>">
					<a href="<?php echo base_url(); ?>">
						<i class="fa fa-home"></i>
						<span>Dashboard</span>
					</a>
				</li>
			<?php endif; ?>
			<?php
			if (!in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'occupancies'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'treatments'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'discharges'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'patient_meals'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'transport_services'
			))->row()->module_id), $this->session->userdata('permissions'))) :
			?>

			<?php else : ?>
				<li class="has-sub <?php if ($page_name == 'occupancies' || $page_name == 'treatments' || $page_name == 'discharges' || $page_name == 'patient_meals' || $page_name == 'transport_services') echo 'active'; ?>">
					<a href="javascript:;">
						<b class="caret pull-right"></b>
						<i class="fa fa-bed"></i>
						<span>In-Patient Department</span>
					</a>
					<ul class="sub-menu">
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'occupancies'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'occupancies') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>occupancies">Occupancies</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'treatments'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'treatments') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>treatments">Treatments</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'discharges'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'discharges') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>discharges">Discharges</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'patient_meals'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'patient_meals') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>patient_meals">Patient Meals</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'transport_services'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'transport_services') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>transport_services">Transport Services</a>
							</li>
						<?php endif; ?>
					</ul>
				</li>
			<?php endif; ?>
			<?php
			if (!in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'appointments'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'patients'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'prescriptions'
			))->row()->module_id), $this->session->userdata('permissions'))) :
			?>

			<?php else : ?>
				<li class="has-sub <?php if ($page_name == 'appointments' || $page_name == 'patients' || $page_name == 'prescriptions') echo 'active'; ?>">
					<a href="javascript:;">
						<b class="caret pull-right"></b>
						<i class="fa fa-stethoscope"></i>
						<span>Out-Patient Department</span>
					</a>
					<ul class="sub-menu">
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'appointments'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'appointments') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>appointments">Appointments</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'patients'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'patients') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>patients">Patients</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'prescriptions'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'prescriptions') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>prescriptions">Prescriptions</a>
							</li>
						<?php endif; ?>
					</ul>
				</li>
			<?php endif; ?>
			<?php
			if (!in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'emergency_rosters'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'emergency_patients'
			))->row()->module_id), $this->session->userdata('permissions'))) :
			?>

			<?php else : ?>
				<li class="has-sub <?php if ($page_name == 'emergency_rosters' || $page_name == 'emergency_patients') echo 'active'; ?>">
					<a href="javascript:;">
						<b class="caret pull-right"></b>
						<i class="fa fa-wheelchair"></i>
						<span>Emergency</span>
					</a>
					<ul class="sub-menu">
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'emergency_rosters'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'emergency_rosters') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>emergency_rosters">Rosters</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'emergency_patients'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'emergency_patients') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>emergency_patients">Patients</a>
							</li>
						<?php endif; ?>
					</ul>
				</li>
			<?php endif; ?>
			<?php
			if (!in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'pharmacy_inventory'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'pharmacy_invoice'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'pharmacy_pos'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'pharmacy_sales'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'pharmacy_sale_returns'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'pharmacy_units'
			))->row()->module_id), $this->session->userdata('permissions'))) :
			?>

			<?php else : ?>
				<li class="has-sub <?php if ($page_name == 'pharmacy_inventory' || $page_name == 'pharmacy_invoice' || $page_name == 'pharmacy_pos' || $page_name == 'pharmacy_sales' || $page_name == 'pharmacy_sale_returns' || $page_name == 'pharmacy_units') echo 'active'; ?>">
					<a href="javascript:;">
						<b class="caret pull-right"></b>
						<i class="fa fa-medkit"></i>
						<span>Pharmacy</span>
					</a>
					<ul class="sub-menu">
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'pharmacy_inventory'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'pharmacy_inventory') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>pharmacy_inventory">Inventory</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'pharmacy_pos'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'pharmacy_pos') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>pharmacy_pos">POS</a>
							</li>
						<?php endif; ?>
						<?php
						if (
							in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'pharmacy_sales'))->row()->module_id), $this->session->userdata('permissions')) ||
							in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'pharmacy_invoice'))->row()->module_id), $this->session->userdata('permissions'))
						) :
						?>
							<li class="<?php if ($page_name == 'pharmacy_sales' || $page_name == 'pharmacy_invoice') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>pharmacy_sales">Sales Reports</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'pharmacy_sale_returns'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'pharmacy_sale_returns') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>pharmacy_sale_returns">Sales Returns</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'pharmacy_units'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'pharmacy_units') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>pharmacy_units">Units</a>
							</li>
						<?php endif; ?>
					</ul>
				</li>
			<?php endif; ?>
			<?php
			if (!in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'cafeteria_inventory'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'cafeteria_pos'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'cafeteria_invoice'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'cafeteria_sales'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'cafeteria_units'
			))->row()->module_id), $this->session->userdata('permissions'))) :
			?>

			<?php else : ?>
				<li class="has-sub <?php if ($page_name == 'cafeteria_inventory' || $page_name == 'cafeteria_pos' || $page_name == 'cafeteria_invoice' || $page_name == 'cafeteria_sales' || $page_name == 'cafeteria_units') echo 'active'; ?>">
					<a href="javascript:;">
						<b class="caret pull-right"></b>
						<i class="fa fa-utensils"></i>
						<span>Cafeteria</span>
					</a>
					<ul class="sub-menu">
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'cafeteria_inventory'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'cafeteria_inventory') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>cafeteria_inventory">Inventory</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'cafeteria_pos'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'cafeteria_pos') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>cafeteria_pos">POS</a>
							</li>
						<?php endif; ?>
						<?php
						if (
							in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'cafeteria_sales'))->row()->module_id), $this->session->userdata('permissions')) ||
							in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'cafeteria_invoice'))->row()->module_id), $this->session->userdata('permissions'))
						) :
						?>
							<li class="<?php if ($page_name == 'cafeteria_sales' || $page_name == 'cafeteria_invoice') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>cafeteria_sales">Sales Reports</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'cafeteria_units'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'cafeteria_units') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>cafeteria_units">Units</a>
							</li>
						<?php endif; ?>
					</ul>
				</li>
			<?php endif; ?>
			<?php
			if (!in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'staff_categories'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'staff'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'accommodation_categories'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'accommodations'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'transport_categories'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'transports'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'custom_invoice_items'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'departments'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'settings'
			))->row()->module_id), $this->session->userdata('permissions'))) :
			?>

			<?php else : ?>
				<li class="has-sub <?php if ($page_name == 'staff_categories' || $page_name == 'staff' || $page_name == 'accommodation_categories' || $page_name == 'accommodations' || $page_name == 'transport_categories' || $page_name == 'transports' || $page_name == 'custom_invoice_items' || $page_name == 'departments' || $page_name == 'settings') echo 'active'; ?>">
					<a href="javascript:;">
						<b class="caret pull-right"></b>
						<i class="fa fa-user"></i>
						<span>Admin Tools</span>
					</a>
					<ul class="sub-menu">
						<?php
						if (
							in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'staff_categories'))->row()->module_id), $this->session->userdata('permissions')) ||
							in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'staff'))->row()->module_id), $this->session->userdata('permissions'))
						) :
						?>
							<li class="<?php if ($page_name == 'staff_categories' || $page_name == 'staff') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>staff_categories">Staff</a>
							</li>
						<?php endif; ?>
						<?php
						if (
							in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'accommodation_categories'))->row()->module_id), $this->session->userdata('permissions')) ||
							in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'accommodations'))->row()->module_id), $this->session->userdata('permissions'))
						) :
						?>
							<li class="<?php if ($page_name == 'accommodation_categories' || $page_name == 'accommodations') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>accommodation_categories">Accommodations</a>
							</li>
						<?php endif; ?>
						<?php
						if (
							in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'transport_categories'))->row()->module_id), $this->session->userdata('permissions')) ||
							in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'transports'))->row()->module_id), $this->session->userdata('permissions'))
						) :
						?>
							<li class="<?php if ($page_name == 'transport_categories' || $page_name == 'transports') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>transport_categories">Transports</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'custom_invoice_items'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'custom_invoice_items') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>custom_invoice_items">Custom Invoice Items</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'departments'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'departments') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>departments">Departments</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'settings'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'settings') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>settings">Settings</a>
							</li>
						<?php endif; ?>
					</ul>
				</li>
			<?php endif; ?>
			<?php
			if (!in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'payroll'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'revenue'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'inventory'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'expenses'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'income_statement'
			))->row()->module_id), $this->session->userdata('permissions'))) :
			?>

			<?php else : ?>
				<li class="has-sub <?php if ($page_name == 'payroll' || $page_name == 'revenue' || $page_name == 'inventory' || $page_name == 'expenses' || $page_name == 'income_statement') echo 'active'; ?>">
					<a href="javascript:;">
						<b class="caret pull-right"></b>
						<i class="fa fa-list-ol"></i>
						<span>Accounting</span>
					</a>
					<ul class="sub-menu">
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'payroll'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'payroll') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>payroll">Payroll</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'revenue'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'revenue') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>revenue">Revenue</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'inventory'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'inventory') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>inventory">Inventory</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'expenses'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'expenses') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>expenses">Expenses</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'income_statement'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'income_statement') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>income_statement">Income Statement</a>
							</li>
						<?php endif; ?>
					</ul>
				</li>
			<?php endif; ?>
			<?php
			if (!in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'blood_requests'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'blood_inventory'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'blood_donors'
			))->row()->module_id), $this->session->userdata('permissions'))) :
			?>

			<?php else : ?>
				<li class="has-sub <?php if ($page_name == 'blood_requests' || $page_name == 'blood_inventory' || $page_name == 'blood_donors') echo 'active'; ?>">
					<a href="javascript:;">
						<b class="caret pull-right"></b>
						<i class="fa fa-hospital"></i>
						<span>Blood bank Management</span>
					</a>
					<ul class="sub-menu">
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'blood_requests'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'blood_requests') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>blood_requests">Blood Requests</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'blood_inventory'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'blood_inventory') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>blood_inventory">Inventory</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'blood_donors'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'blood_donors') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>blood_donors">Donor List</a>
							</li>
						<?php endif; ?>
					</ul>
				</li>
			<?php endif; ?>
			<?php
			if (!in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'reports'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'report_categories'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'laboratories'
			))->row()->module_id), $this->session->userdata('permissions'))) :
			?>

			<?php else : ?>
				<li class="has-sub <?php if ($page_name == 'reports' || $page_name == 'add_report_patient' || $page_name == 'add_report_customer' || $page_name == 'report_categories' || $page_name == 'laboratories') echo 'active'; ?>">
					<a href="javascript:;">
						<b class="caret pull-right"></b>
						<i class="fa fa-heartbeat"></i>
						<span>Lab Management</span>
					</a>
					<ul class="sub-menu">
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'reports'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'reports' || $page_name == 'add_report_patient' || $page_name == 'add_report_customer') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>reports">Reports</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'report_categories'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'report_categories') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>report_categories">Report Categories</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'laboratories'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'laboratories') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>laboratories">Laboratories</a>
							</li>
						<?php endif; ?>
					</ul>
				</li>
			<?php endif; ?>
			<?php
			if (!in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'notices'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'feedback_and_ratings'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'certificates'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'medicines'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'diseases'
			))->row()->module_id), $this->session->userdata('permissions'))) :
			?>

			<?php else : ?>
				<li class="has-sub <?php if ($page_name == 'notices' || $page_name == 'feedback_and_ratings' || $page_name == 'certificates' || $page_name == 'medicines' || $page_name == 'diseases') echo 'active'; ?>">
					<a href="javascript:;">
						<b class="caret pull-right"></b>
						<i class="fa fa-user-md"></i>
						<span>Miscellaneous</span>
					</a>
					<ul class="sub-menu">
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'notices'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'notices') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>notices">Notices</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'feedback_and_ratings'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'feedback_and_ratings') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>feedback_and_ratings">Feedback &amp; Ratings</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'certificates'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'certificates') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>certificates">Certificates</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'medicines'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'medicines') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>medicines">Medicines</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'diseases'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'diseases') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>diseases">Diseases</a>
							</li>
						<?php endif; ?>
					</ul>
				</li>
			<?php endif; ?>
			<?php
			if (!in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'rosters'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'individual_workload'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'shift_categories'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'shifts'
			))->row()->module_id), $this->session->userdata('permissions'))) :
			?>

			<?php else : ?>
				<li class="has-sub <?php if ($page_name == 'rosters' || $page_name == 'individual_workload' || $page_name == 'shift_categories' || $page_name == 'shifts') echo 'active'; ?>">
					<a href="javascript:;">
						<b class="caret pull-right"></b>
						<i class="fa fa-calendar"></i>
						<span>Resource Scheduling</span>
					</a>
					<ul class="sub-menu">
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'rosters'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'rosters') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>rosters">Rosters</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'individual_workload'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'individual_workload') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>individual_workload">Individual Workload</a>
							</li>
						<?php endif; ?>
						<?php
						if (
							in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'shift_categories'))->row()->module_id), $this->session->userdata('permissions')) ||
							in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'shifts'))->row()->module_id), $this->session->userdata('permissions'))
						) :
						?>
							<li class="<?php if ($page_name == 'shift_categories' || $page_name == 'shifts') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>shift_categories">Shifts</a>
							</li>
						<?php endif; ?>
					</ul>
				</li>
			<?php endif; ?>
			<?php
			if (!in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'invoice_requests'
			))->row()->module_id), $this->session->userdata('permissions')) && !in_array($this->security->xss_clean($this->db->get_where('module', array(
				'name' => 'invoices'
			))->row()->module_id), $this->session->userdata('permissions'))) :
			?>

			<?php else : ?>
				<li class="has-sub <?php if ($page_name == 'invoice_requests' || $page_name == 'invoices' || $page_name == 'invoice') echo 'active'; ?>">
					<a href="javascript:;">
						<b class="caret pull-right"></b>
						<i class="fa fa-money-bill-alt"></i>
						<span>Cash Counter</span>
					</a>
					<ul class="sub-menu">
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'invoice_requests'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'invoice_requests') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>invoice_requests">Invoice Requests</a>
							</li>
						<?php endif; ?>
						<?php if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'invoices'))->row()->module_id), $this->session->userdata('permissions'))) : ?>
							<li class="<?php if ($page_name == 'invoices' || $page_name == 'invoice') echo 'active'; ?>">
								<a href="<?php echo base_url(); ?>invoices">Invoices</a>
							</li>
						<?php endif; ?>
					</ul>
				</li>
			<?php endif; ?>

			<!-- begin sidebar minify button -->
			<li>
				<a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify">
					<i class="fa fa-angle-double-left"></i>
				</a>
			</li>
			<!-- end sidebar minify button -->
		</ul>
		<!-- end sidebar nav -->
	</div>
	<!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->