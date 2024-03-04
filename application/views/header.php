<!-- begin #header -->
<div id="header" class="header navbar-default">
    <!-- begin navbar-header -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-click="top-menu-toggled">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="<?php echo base_url(); ?>" class="navbar-brand">
            <?php echo strtoupper($this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_name'))->row()->content)); ?>
        </a>
    </div>
    <!-- end navbar-header -->

    <!-- begin header-nav -->
    <ul class="navbar-nav navbar-right">
        <li class="dropdown navbar-user">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                <span class="d-md-inline">
                    Hi,
                    <?php
                    if ($this->session->userdata('user_type') == 'staff') {
                        $header_staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->staff_id);
                        $header_is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->is_doctor);
                        if ($header_is_doctor)
                            echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $header_staff_id))->row()->name);
                        else
                            echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $header_staff_id))->row()->name);
                    } else {
                        echo $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $this->session->userdata('user_id')))->row()->name);
                    }                    
                    ?>
                </span>
                <?php
                    if ($this->session->userdata('user_type') == 'staff'): 
                        if ($header_is_doctor) : 
                ?>
                    <img src="<?php echo base_url(); ?>uploads/<?php echo $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $header_staff_id))->row()->image_link) ? 'doctor/' . $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $header_staff_id))->row()->image_link) : 'website/default_user.png'; ?>" alt="" />
                <?php else : ?>
                    <img src="<?php echo base_url(); ?>uploads/<?php echo $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $header_staff_id))->row()->image_link) ? 'staff/' . $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $header_staff_id))->row()->image_link) : 'website/default_user.png'; ?>" alt="" />
                <?php 
                        endif;
                    else: 
                ?>
                    <img src="<?php echo base_url(); ?>uploads/website/default_user.png" alt="t1m9m" />
                <?php endif; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="<?php echo base_url(); ?>profile_settings" class="dropdown-item">Profile Settings</a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url(); ?>auth/logout" class="dropdown-item">Log Out</a>
            </div>
        </li>
    </ul>
    <!-- end header navigation right -->

    <div class="search-form">
        <button class="search-btn" type="submit"><i class="material-icons">search</i></button>
        <input type="text" class="form-control" placeholder="Search Something..." />
        <a href="#" class="close" data-dismiss="navbar-search"><i class="material-icons">close</i></a>
    </div>
</div>
<!-- end #header -->