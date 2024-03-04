<?php echo form_open('staff_categories/update_permission/' . $param2, array('class' => 'form-horizontal', 'method' => 'post')); ?>
<?php
$permissions = $this->db->get_where('staff_category', array('staff_category_id' => $param2))->row()->permissions;
if (isset($permissions)) $permissions_no_comma = explode(",", $permissions);
?>
<div class="form-group">
    <label class="col-md-12 col-form-label">Modules</label>
    <div class="col-md-12">
        <div class="row">
            <?php
            $modules = $this->security->xss_clean($this->db->get('module')->result_array());
            foreach ($modules as $module) :
            ?>
                <div class="col-md-3">
                    <ul class="todolist">
                        <li>
                            <div class="todolist-input">
                                <input <?php if (isset($permissions_no_comma) && in_array($module['module_id'], $permissions_no_comma)) echo 'checked'; ?> type="checkbox" id="<?php echo $module['title']; ?>" value="<?php echo $module['module_id']; ?>" name="permission[]" />
                            </div>
                            <div class="todolist-title">
                                <label style="margin-bottom: 0" for="<?php echo $module['title']; ?>"><?php echo $module['title']; ?></label>
                            </div>                
                        </li>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-md-12 col-form-label"></label>
    <div class="col-md-12">
        <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
        <button type="submit" class="btn btn-yellow pull-right">Edit Permission</button>
    </div>
</div>
<?php echo form_close(); ?>

<script>
    "use strict";

    $('.modal-dialog').css('max-width', '960px');
    
    FormPlugins.init();
</script>