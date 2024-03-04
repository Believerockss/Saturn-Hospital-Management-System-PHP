<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Profile Settings</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">
        Update your profile information
    </h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-lg-4 offset-lg-4">
            <?php if ($this->session->userdata('user_type') == 'staff'): ?>
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <!-- begin panel-body -->
                <div class="panel-body">
                    <?php echo form_open_multipart('profile_settings/update_image/' . $this->session->userdata('user_id'), array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
                    <?php
                    $user_info = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->result_array());
                    foreach ($user_info as $row) :
                    ?>
                        <?php
                        $staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->staff_id);
                        $is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->is_doctor);
                        if ($is_doctor) :
                        ?>
                            <img width="100%" src="<?php echo base_url(); ?>uploads/<?php echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $staff_id))->row()->image_link) ? 'doctor/' . $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $sidebar_staff_id))->row()->image_link) : 'website/default_user.png'; ?>" alt="<?php echo $staff_id; ?>" />
                        <?php else : ?>
                            <img width="100%" src="<?php echo base_url(); ?>uploads/<?php echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $staff_id))->row()->image_link) ? 'staff/' . $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $sidebar_staff_id))->row()->image_link) : 'website/default_user.png'; ?>" alt="<?php echo $staff_id; ?>" />
                        <?php endif; ?>
                        <hr>
                        <div class="form-group">
                            <label>Profile Picture *</label>
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
                    <?php endforeach; ?>
                    <?php echo form_close(); ?>
                    <!-- end panel-body -->
                </div>
            </div>
            <!-- end panel -->
            <?php endif; ?>
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <!-- begin panel-body -->
                <div class="panel-body">
                    <?php
                        if ($this->session->userdata('user_type') == 'staff') {
                            $current_email = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->email);
                        } else {
                            $current_email = $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $this->session->userdata('user_id')))->row()->email);
                        }                        
                    ?>
                    <?php echo form_open('profile_settings/update/' . $this->session->userdata('user_type') . '/' . $this->session->userdata('user_id'), array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
                    <div class="form-group">
                        <label>Email *</label>
                        <input value="<?php echo html_escape($current_email); ?>" type="email" name="email" placeholder="Enter email" class="form-control" data-parsley-required="true">
                    </div>
                    <div class="form-group">
                        <label>Current Password *</label>
                        <input autocomplete="off" type="password" name="old_password" placeholder="Enter your current password" class="form-control" data-parsley-required="true">
                    </div>
                    <div class="form-group">
                        <label>New Password *</label>
                        <input autocomplete="off" type="password" name="new_password" placeholder="Enter new password" class="form-control" data-parsley-required="true">
                    </div>

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