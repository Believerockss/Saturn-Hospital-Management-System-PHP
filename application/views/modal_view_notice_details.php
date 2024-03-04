<h3><?php echo $this->security->xss_clean($this->db->get_where('notice', array('notice_id' => $param2))->row()->title); ?></h3>
<hr>
<p><?php echo $this->security->xss_clean($this->db->get_where('notice', array('notice_id' => $param2))->row()->notice); ?></p>

<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Close</button>