<h3>
    <?php echo $this->security->xss_clean($this->db->get_where('ticket', array('ticket_id' => $param2))->row()->subject); ?>
    &nbsp;
    <?php if ($this->db->get_where('ticket', array('ticket_id' => $param2))->row()->status == 0) : ?>
        <span class="badge badge-warning">Open</span>
    <?php endif; ?>
    <?php if ($this->db->get_where('ticket', array('ticket_id' => $param2))->row()->status == 1) : ?>
        <span class="badge badge-primary">Closed</span>
    <?php endif; ?>
</h3>
<p>Created On: <?php echo date('d M, Y', $this->db->get_where('ticket', array('ticket_id' => $param2))->row()->created_on); ?> &nbsp;&nbsp;&nbsp; Updated On: <?php echo date('d M, Y', $this->db->get_where('ticket', array('ticket_id' => $param2))->row()->timestamp); ?></p>
<hr>
<?php
$ticket_details = $this->db->get_where('ticket_details', array('ticket_id' => $param2))->result_array();
foreach ($ticket_details as $row) :
?>
    <?php if ($row['created_by'] == $this->session->userdata('user_id')) : ?>
        <div class="note note-info">
            <p><?php echo $row['content']; ?></p>
            <p><?php echo date('d M, Y', $row['created_on']); ?></p>
            <p>
            <?php
                if ($this->db->get_where('user', array('user_id' => $row['created_by']))->num_rows() > 0) {
                    $staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['created_by']))->row()->staff_id);
                    $is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['created_by']))->row()->is_doctor);

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
                } elseif ($this->db->get_where('patient', array('patient_id' => $row['created_by']))->num_rows() > 0) {
                    echo $this->db->get_where('patient', array('patient_id' => $row['created_by']))->row()->name;
                } else {
                    echo 'Created By not found.';
                }
            ?>
            </p>
        </div>
    <?php else : ?>
        <div class="note note-success note-with-right-icon">
            <p><?php echo $row['content']; ?></p>
            <p><?php echo date('d M, Y', $row['created_on']); ?></p>
            <p>
            <?php
                if ($this->db->get_where('user', array('user_id' => $row['created_by']))->num_rows() > 0) {
                    $staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['created_by']))->row()->staff_id);
                    $is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $row['created_by']))->row()->is_doctor);

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
                } elseif ($this->db->get_where('patient', array('patient_id' => $row['created_by']))->num_rows() > 0) {
                    echo $this->db->get_where('patient', array('patient_id' => $row['created_by']))->row()->name;
                } else {
                    echo 'Created By not found.';
                }
            ?>
            </p>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<div class="form-group">
	<label class="col-md-12 col-form-label"></label>
	<div class="col-md-12">
		<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
	</div>
</div>

<script>
    $('.modal-dialog').css('max-height', '250px', 'overflow-y', 'auto');
</script>