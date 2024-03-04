<!-- begin #content -->
<div id="content" class="content content-full-width">
    <?php $patient_id = $this->uri->segment('2'); ?>
    <!-- begin profile -->
    <div class="profile">
        <div class="profile-header">
            <!-- BEGIN profile-header-cover -->
            <div class="profile-header-cover"></div>
            <!-- END profile-header-cover -->
            <!-- BEGIN profile-header-content -->
            <div class="profile-header-content">
                <!-- BEGIN profile-header-img -->
                <div class="profile-header-img">
                    <img src="<?php echo base_url(); ?>uploads/website/default_user.png" alt="">
                </div>
                <!-- END profile-header-img -->
                <!-- BEGIN profile-header-info -->
                <div class="profile-header-info">
                    <h4 class="m-t-10 m-b-5"><?php echo $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->name; ?></h4>
                    <p class="m-b-10"><?php echo $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->pid; ?></p>
                    <a href="<?php echo base_url('patients'); ?>" class="btn btn-xs btn-yellow">Go Back</a>
                </div>
                <!-- END profile-header-info -->
            </div>
            <!-- END profile-header-content -->
            <!-- BEGIN profile-header-tab -->
            <ul class="profile-header-tab nav nav-tabs">
                <li class="nav-item"><a href="#about" class="nav-link active" data-toggle="tab">ABOUT</a></li>
                <li class="nav-item"><a href="#reports" class="nav-link" data-toggle="tab">REPORTS</a></li>
                <li class="nav-item"><a href="#occupancies" class="nav-link" data-toggle="tab">OCCUPANCIES</a></li>
                <li class="nav-item"><a href="#treatments" class="nav-link" data-toggle="tab">TREATMENTS</a></li>
                <li class="nav-item"><a href="#discharges" class="nav-link" data-toggle="tab">DISCHARGES</a></li>
                <li class="nav-item"><a href="#meals" class="nav-link" data-toggle="tab">MEALS</a></li>
            </ul>
            <!-- END profile-header-tab -->
        </div>
    </div>
    <!-- end profile -->
    <!-- begin profile-content -->
    <div class="profile-content">
        <!-- begin tab-content -->
        <div class="tab-content p-0">
            <!-- begin #about tab -->
            <div class="tab-pane fade show active" id="about">
                <!-- begin table -->
                <div class="table-responsive">
                    <table class="table table-profile">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    <h4>
                                        <?php 
                                            if ($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->type)
                                                echo 'Emergency Patient';
                                            else
                                                echo 'Regular Patient';
                                        ?>
                                        <small>
                                            <?php 
                                                if ($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->status)
                                                    echo 'Admitted';
                                                else
                                                    echo 'Not Admitted';
                                            ?>
                                        </small>
                                    </h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="highlight">
                                <td class="field">Age</td>
                                <td><?php echo $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->age; ?></td>
                            </tr>
                            <tr>
                                <td class="field">Date of Birth</td>
                                <td><?php echo date('d M, Y', $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->dob); ?></td>
                            </tr>
                            <tr class="divider">
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td class="field">Gender</td>
                                <td>
                                    <?php
										if ($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->sex_id == 1)
											echo 'Male';
										elseif ($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->sex_id == 2)
											echo 'Female';
										else
											echo 'Other';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="field">Blood Type</td>
                                <td>
                                    <?php echo $this->db->get_where('blood_inventory', array('blood_inventory_id' => $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->blood_inventory_id))->row()->blood_group_name; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="field">Email</td>
                                <td><?php echo $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email; ?></td>
                            </tr>
                            <tr>
                                <td class="field">Mobile Number</td>
                                <td><?php echo $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->mobile_number; ?></td>
                            </tr>
                            <tr>
                                <td class="field">Profession</td>
                                <td>
                                    <?php 
                                        if ($this->db->get_where('profession', array('profession_id' => $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->profession_id))->num_rows() > 0)
                                            echo $this->db->get_where('profession', array('profession_id' => $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->profession_id))->row()->name; 
                                        else
                                            echo 'Profession not found.';
                                    ?>
                                </td>
                            </tr>
                            <tr class="divider">
                                <td colspan="2"></td>
                            </tr>
                            <tr class="highlight">
                                <td class="field">Address</td>
                                <td><?php echo $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->address; ?></td>
                            </tr>
                            <tr class="divider">
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td class="field">Father's Name</td>
                                <td><?php echo $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->father_name; ?></td>
                            </tr>
                            <tr>
                                <td class="field">Mother's Name</td>
                                <td><?php echo $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->mother_name; ?></td>
                            </tr>
                            <tr>
                                <td class="field">Emergency Contact</td>
                                <td><?php echo $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->emergency_contact; ?></td>
                            </tr>
                            <tr>
                                <td class="field">Emergency Contact Number</td>
                                <td><?php echo $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->emergency_contact_number; ?></td>
                            </tr>
                            <tr>
                                <td class="field">Emergency Contact Relation</td>
                                <td><?php echo $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->emergency_contact_relation; ?></td>
                            </tr>
                            <tr class="divider">
                                <td colspan="2"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- end table -->
            </div>
            <!-- end #about tab -->

            <!-- begin #reports tab -->
            <div class="tab-pane fade in" id="reports">
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-12 -->
                    <div class="col-md-12">
                        <!-- begin panel -->
                        <div class="panel panel-inverse">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Patient</th>
                                                <th>Mobile Number</th>
                                                <th>Cost (<?php echo $this->security->xss_clean($this->db->get_where('setting', array('item' => 'currency'))->row()->content); ?>)</th>
                                                <th>Status</th>
                                                <th>Discount</th>
                                                <th>Doctor</th>
                                                <th>Delivery Date</th>
                                                <th>Created On</th>
                                                <th>Created By</th>
                                                <th>Updated On</th>
                                                <th>Updated By</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            $this->db->order_by('timestamp', 'desc');
                                            $reports = $this->security->xss_clean($this->db->get_where('report', array('patient_id' => $patient_id))->result_array());
                                            foreach ($reports as $row) :
                                            ?>
                                                <tr>
                                                    <td><?php echo $count++; ?></td>
                                                    <?php if ($row['is_patient']) : ?>
                                                        <td><?php echo $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->name); ?></td>
                                                        <td><?php echo $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->mobile_number); ?></td>
                                                    <?php else : ?>
                                                        <td><?php echo $row['customer_name']; ?></td>
                                                        <td><?php echo $row['customer_mobile']; ?></td>
                                                    <?php endif; ?>
                                                    <td><?php echo $row['grand_total']; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($row['status'] == 0)
                                                            echo '<span class="badge badge-warning">Pending</span>';
                                                        elseif ($row['status'] == 1)
                                                            echo '<span class="badge badge-success">Completed</span>';
                                                        else
                                                            echo '<span class="badge badge-danger">Cancelled</span>';
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($row['discount'])
                                                            echo $row['discount'] . '%';
                                                        else
                                                            echo '-';
                                                        ?>
                                                    </td>
                                                    <td><?php echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $row['doctor_id']))->row()->name); ?></td>
                                                    <td><?php echo date('d M, Y', $row['delivery_date']); ?></td>
                                                    <td><?php echo date('d M, Y', $row['created_on']); ?></td>
                                                    <td>
                                                        <?php
                                                        $staff_id  = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['created_by']))->row()->staff_id);
                                                        $is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['created_by']))->row()->is_doctor);
                                                        if ($is_doctor)
                                                            echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $staff_id))->row()->name);
                                                        else
                                                            echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $staff_id))->row()->name);
                                                        ?>
                                                    </td>
                                                    <td><?php echo date('d M, Y', $row['timestamp']); ?></td>
                                                    <td>
                                                        <?php
                                                        $staff_id  = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['updated_by']))->row()->staff_id);
                                                        $is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['updated_by']))->row()->is_doctor);
                                                        if ($is_doctor)
                                                            echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $staff_id))->row()->name);
                                                        else
                                                            echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $staff_id))->row()->name);
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-white btn-xs">Action</button>
                                                            <button type="button" class="btn btn-white btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_view_report_details/<?php echo $row['report_id']; ?>');" href="javascript:;">Show Details</a>
                                                                <?php if ($this->session->userdata('user_type') == 'staff'): ?>
                                                                <a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_report_details/<?php echo $row['report_id']; ?>');" href="javascript:;">Edit Details</a>
                                                                <a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_report_status/<?php echo $row['report_id']; ?>');" href="javascript:;">Edit Status</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" onclick="confirm_modal('<?php echo base_url(); ?>reports/delete/<?php echo $row['report_id']; ?>');" href="javascript:;">Remove</a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end panel -->
                    </div>
                    <!-- end col-12 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end #reports tab -->
            
            <!-- begin #occupancies tab -->
            <div class="tab-pane fade in" id="occupancies">
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-12 -->
                    <div class="col-md-12">
                        <!-- begin panel -->
                        <div class="panel panel-inverse">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>PID</th>
                                                <th>Name</th>
                                                <th>Accommodation Category</th>
                                                <th>Accommodation</th>
                                                <th>Status</th>
                                                <th>Created On</th>
                                                <th>Created By</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            $this->db->order_by('timestamp', 'desc');
                                            $occupancies = $this->security->xss_clean($this->db->get_where('occupancy', array('patient_id' => $patient_id))->result_array());		
                                            foreach ($occupancies as $row) :
                                            ?>
                                                <tr>
                                                    <td><?php echo $count++; ?></td>
                                                    <td><?php echo $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->pid); ?></td>
                                                    <td><?php echo $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->name); ?></td>
                                                    <?php
                                                    $accommodation_type	=	$this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $row['accommodation_category_id']))->row()->accommodation_type);
                                                    if ($accommodation_type == 1) :
                                                    ?>
                                                        <td>
                                                            <?php
                                                            $root_accommodation_category_id = $this->security->xss_clean($this->db->get_where('bed', array('accommodation_category_id' => $row['accommodation_category_id']))->row()->root_accommodation_category_id);
                                                            echo $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $root_accommodation_category_id))->row()->name);
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $accommodation_id = $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $row['accommodation_id']))->row()->accommodation_id);
                                                            echo 'Bed ' . $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $row['accommodation_id']))->row()->bed_number) . ' of Room ' . $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $accommodation_id))->row()->room_number);
                                                            ?>
                                                        </td>
                                                    <?php else : ?>
                                                        <td><?php echo $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $row['accommodation_category_id']))->row()->name); ?></td>
                                                        <td><?php echo 'Room ' . $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $row['accommodation_id']))->row()->room_number); ?></td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <?php
                                                        if ($row['status'] == 0) {
                                                            echo '<span class="badge badge-warning">Discharged</span>';
                                                        } elseif ($row['status'] == 1) {
                                                            echo '<span class="badge badge-success">Admitted</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo date('d M, Y', $row['created_on']); ?></td>
                                                    <td>
                                                        <?php
                                                        $staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['created_by']))->row()->staff_id);
                                                        $is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['created_by']))->row()->is_doctor);
                                                        if ($is_doctor)
                                                            echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $staff_id))->row()->name);
                                                        else
                                                            echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $staff_id))->row()->name);
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-white btn-xs">Action</button>
                                                            <button type="button" class="btn btn-white btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_view_occupancy_details/<?php echo $row['occupancy_id']; ?>');" href="javascript:;">Show Details</a>
                                                                <?php if ($this->session->userdata('user_type') == 'staff'): ?>
                                                                <a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_occupancy_details/<?php echo $row['occupancy_id']; ?>');" href="javascript:;">Edit Details</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" onclick="confirm_modal('<?php echo base_url(); ?>occupancies/delete/<?php echo $row['occupancy_id']; ?>');" href="javascript:;">Remove</a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>                                
                            </div>
                        </div>
                        <!-- end panel -->
                    </div>
                    <!-- end col-12 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end #occupancies tab -->

            <!-- begin #treatments tab -->
            <div class="tab-pane fade in" id="treatments">
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-12 -->
                    <div class="col-md-12">
                        <!-- begin panel -->
                        <div class="panel panel-inverse">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Patient</th>
                                                <th>Occupancy</th>
                                                <th>Disease</th>
                                                <th>Next Checkup</th>
                                                <th>Created On</th>
                                                <th>Created By</th>
                                                <th>Updated On</th>
                                                <th>Updated By</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            $this->db->order_by('timestamp', 'desc');
                                            $treatments = $this->security->xss_clean($this->db->get_where('treatment', array('patient_id' => $patient_id))->result_array());
                                            foreach ($treatments as $row) :
                                            ?>
                                                <tr>
                                                    <td><?php echo $count++; ?></td>
                                                    <td><?php echo $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->name); ?></td>
                                                    <td>
                                                        <?php
                                                        $occupancy_id = $this->security->xss_clean($this->db->get_where('occupancy', array('patient_id' => $row['patient_id']))->row()->occupancy_id);
                                                        $accommodation_category_id = $this->security->xss_clean($this->db->get_where('occupancy', array('patient_id' => $row['patient_id']))->row()->accommodation_category_id);
                                                        $accommodation_id = $this->security->xss_clean($this->db->get_where('occupancy', array('patient_id' => $row['patient_id']))->row()->accommodation_id);
                                                        $accommodation_type	= $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $accommodation_category_id))->row()->accommodation_type);
                                                        if ($accommodation_type == 1) {
                                                            $bed_accommodation_id = $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $accommodation_id))->row()->accommodation_id);
                                                            echo 'Bed ' . $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $accommodation_id))->row()->bed_number) . ' of Room ' . $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $bed_accommodation_id))->row()->room_number);
                                                        } else {
                                                            echo 'Room ' . $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $accommodation_id))->row()->room_number);
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $this->security->xss_clean($this->db->get_where('disease', array('disease_id' => $row['disease_id']))->row()->name); ?></td>
                                                    <td>
                                                        <?php
                                                        if ($row['next_checkup'])
                                                            echo date('d M, Y', $row['next_checkup']);
                                                        else
                                                            echo 'N/A';
                                                        ?>
                                                    </td>
                                                    <td><?php echo date('d M, Y', $row['created_on']); ?></td>
                                                    <td>
                                                        <?php
                                                        $staff_id  = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['created_by']))->row()->staff_id);
                                                        $is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['created_by']))->row()->is_doctor);
                                                        if ($is_doctor)
                                                            echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $staff_id))->row()->name);
                                                        else
                                                            echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $staff_id))->row()->name);
                                                        ?>
                                                    </td>
                                                    <td><?php echo date('d M, Y', $row['timestamp']); ?></td>
                                                    <td>
                                                        <?php
                                                        $staff_id  = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['updated_by']))->row()->staff_id);
                                                        $is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['updated_by']))->row()->is_doctor);
                                                        if ($is_doctor)
                                                            echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $staff_id))->row()->name);
                                                        else
                                                            echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $staff_id))->row()->name);
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-white btn-xs">Action</button>
                                                            <button type="button" class="btn btn-white btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_view_treatment_details/<?php echo $row['treatment_id']; ?>');" href="javascript:;">Show Details</a>
                                                                <?php if ($this->session->userdata('user_type') == 'staff'): ?>
                                                                <a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_treatment_details/<?php echo $row['treatment_id']; ?>');" href="javascript:;">Edit Details</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" onclick="confirm_modal('<?php echo base_url(); ?>treatments/delete/<?php echo $row['treatment_id']; ?>');" href="javascript:;">Remove</a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end #treatments tab -->

            <!-- begin #discharges tab -->
            <div class="tab-pane fade in" id="discharges">
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-12 -->
                    <div class="col-md-12">
                        <!-- begin panel -->
                        <div class="panel panel-inverse">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Patient</th>
                                                <th>Occupancy</th>
                                                <th>Doctor</th>
                                                <th>Next Appoinment</th>
                                                <th>Created On</th>
                                                <th>Created By</th>
                                                <th>Updated On</th>
                                                <th>Updated By</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            $this->db->order_by('timestamp', 'desc');
                                            $query = $this->db->get_where('occupancy', array('patient_id' => $patient_id));
                                            if ($query->num_rows() > 0) {
                                                $discharges = $this->security->xss_clean($this->db->get_where('discharge', array('occupancy_id' => $query->row()->occupancy_id))->result_array());
                                            } else {
                                                $discharges = [];
                                            }
                                            foreach ($discharges as $row) :
                                            ?>
                                                <tr>
                                                    <td><?php echo $count++; ?></td>
                                                    <td>
                                                        <?php
                                                        $patient_id = $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $row['occupancy_id']))->row()->patient_id);
                                                        echo $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->name);
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $accommodation_category_id = $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $row['occupancy_id']))->row()->accommodation_category_id);
                                                        $accommodation_id = $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $row['occupancy_id']))->row()->accommodation_id);
                                                        $accommodation_type	= $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $accommodation_category_id))->row()->accommodation_type);
                                                        if ($accommodation_type == 1) {
                                                            $bed_accommodation_id = $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $accommodation_id))->row()->accommodation_id);
                                                            echo 'Bed ' . $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $accommodation_id))->row()->bed_number) . ' of Room ' . $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $bed_accommodation_id))->row()->room_number);
                                                        } else {
                                                            echo 'Room ' . $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $accommodation_id))->row()->room_number);
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $row['doctor_id']))->row()->name); ?></td>
                                                    <td>
                                                        <?php
                                                        if ($row['next_appointment'])
                                                            echo date('d M, Y', $row['next_appointment']);
                                                        else
                                                            echo 'N/A';
                                                        ?>
                                                    </td>
                                                    <td><?php echo date('d M, Y', $row['created_on']); ?></td>
                                                    <td>
                                                        <?php
                                                        $staff_id  = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['created_by']))->row()->staff_id);
                                                        $is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['created_by']))->row()->is_doctor);
                                                        if ($is_doctor)
                                                            echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $staff_id))->row()->name);
                                                        else
                                                            echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $staff_id))->row()->name);
                                                        ?>
                                                    </td>
                                                    <td><?php echo date('d M, Y', $row['timestamp']); ?></td>
                                                    <td>
                                                        <?php
                                                        $staff_id  = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['updated_by']))->row()->staff_id);
                                                        $is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['updated_by']))->row()->is_doctor);
                                                        if ($is_doctor)
                                                            echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $staff_id))->row()->name);
                                                        else
                                                            echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $staff_id))->row()->name);
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-white btn-xs">Action</button>
                                                            <button type="button" class="btn btn-white btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_view_discharge_details/<?php echo $row['discharge_id']; ?>');" href="javascript:;">Show Details</a>
                                                                <?php if ($this->session->userdata('user_type') == 'staff'): ?>
                                                                <a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_discharge_details/<?php echo $row['discharge_id']; ?>');" href="javascript:;">Edit Details</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" onclick="confirm_modal('<?php echo base_url(); ?>discharges/delete/<?php echo $row['discharge_id']; ?>');" href="javascript:;">Remove</a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end panel -->
                    </div>
                    <!-- end col-12 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end #discharges tab -->

            <!-- begin #meals tab -->
            <div class="tab-pane fade in" id="meals">
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-12 -->
                    <div class="col-md-12">
                        <!-- begin panel -->
                        <div class="panel panel-inverse">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Patient</th>
                                                <th>Occupancy</th>
                                                <th>Doctor</th>
                                                <th>Created On</th>
                                                <th>Created By</th>
                                                <th>Updated On</th>
                                                <th>Updated By</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            $this->db->order_by('timestamp', 'desc');
                                            $query = $this->db->get_where('occupancy', array('patient_id' => $patient_id));
                                            if ($query->num_rows() > 0) {
                                                $patient_meals = $this->security->xss_clean($this->db->get_where('patient_meal', array('occupancy_id' => $query->row()->occupancy_id))->result_array());
                                            } else {
                                                $patient_meals = [];
                                            }
                                            foreach ($patient_meals as $row) :
                                            ?>
                                                <tr>
                                                    <td><?php echo $count++; ?></td>
                                                    <td>
                                                        <?php
                                                        $patient_id = $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $row['occupancy_id']))->row()->patient_id);
                                                        echo $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->name);
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $accommodation_category_id = $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $row['occupancy_id']))->row()->accommodation_category_id);
                                                        $accommodation_id = $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $row['occupancy_id']))->row()->accommodation_id);
                                                        $accommodation_type	= $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $accommodation_category_id))->row()->accommodation_type);
                                                        if ($accommodation_type == 1) {
                                                            $bed_accommodation_id = $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $accommodation_id))->row()->accommodation_id);
                                                            echo 'Bed ' . $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $accommodation_id))->row()->bed_number) . ' of Room ' . $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $bed_accommodation_id))->row()->room_number);
                                                        } else {
                                                            echo 'Room ' . $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $accommodation_id))->row()->room_number);
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $row['doctor_id']))->row()->name); ?></td>
                                                    <td><?php echo date('d M, Y', $row['created_on']); ?></td>
                                                    <td>
                                                        <?php
                                                        $staff_id  = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['created_by']))->row()->staff_id);
                                                        $is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['created_by']))->row()->is_doctor);
                                                        if ($is_doctor)
                                                            echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $staff_id))->row()->name);
                                                        else
                                                            echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $staff_id))->row()->name);
                                                        ?>
                                                    </td>
                                                    <td><?php echo date('d M, Y', $row['timestamp']); ?></td>
                                                    <td>
                                                        <?php
                                                        $staff_id  = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['updated_by']))->row()->staff_id);
                                                        $is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['updated_by']))->row()->is_doctor);
                                                        if ($is_doctor)
                                                            echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $staff_id))->row()->name);
                                                        else
                                                            echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $staff_id))->row()->name);
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-white btn-xs">Action</button>
                                                            <button type="button" class="btn btn-white btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_view_patient_meal_details/<?php echo $row['patient_meal_id']; ?>');" href="javascript:;">Show Details</a>
                                                                <?php if ($this->session->userdata('user_type') == 'staff'): ?>
                                                                <a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_patient_meal_details/<?php echo $row['patient_meal_id']; ?>');" href="javascript:;">Edit Details</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" onclick="confirm_modal('<?php echo base_url(); ?>patient_meals/delete/<?php echo $row['patient_meal_id']; ?>');" href="javascript:;">Remove</a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end #meals tab -->
        </div>
        <!-- end tab-content -->
    </div>
    <!-- end profile-content -->
</div>
<!-- end #content -->