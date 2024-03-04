<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('reports'); ?>">Reports</a></li>
        <li class="breadcrumb-item active">Add Report Customer</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">
        <a href="<?php echo base_url('reports'); ?>" class="btn btn-inverse m-r-5">
			<i class="fa fa-arrow-left"></i> Go back to Reports
		</a>
    </h1>
    <!-- end page-header -->
    <!-- begin form-file-upload -->
    <!-- <form id="fileupload" action="../assets/global/plugins/jquery-file-upload/server/php/" method="POST" enctype="multipart/form-data"> -->
    <?php echo form_open('reports/create/0', array('id' => 'fileupload', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true', 'enctype' => 'multipart/form-data')); ?>
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
                <h4 class="panel-title">Add Report Customer</h4>
            </div>
            <!-- end panel-heading -->
            <!-- begin panel-body -->
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-12 col-form-label">Report Category *</label>
                    <div class="col-lg-12">
                        <select id="report_cat" class="multiple-select2 form-control" multiple="multiple" data-parsley-required="true" name="report_category_id[]">
                            <?php
                            $report_categories = $this->security->xss_clean($this->db->get('report_category')->result_array());
                            foreach ($report_categories as $report_category) :
                            ?>
                                <option value="<?php echo html_escape($report_category['report_category_id']); ?>"><?php echo $report_category['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 col-form-label">Report File(s)</label>
                    <div class="col-md-12">
                        <div class="note note-yellow m-b-15">
                            <div class="note-icon f-s-20">
                                <i class="fa fa-lightbulb fa-2x"></i>
                            </div>
                            <div class="note-content">
                                <h4 class="m-t-5 m-b-5 p-b-2">Notes</h4>
                                <ul class="m-b-5 p-l-25">
                                    <li>The maximum file size for uploads in this demo is <strong>5 MB</strong> (default file size is unlimited).</li>
                                    <li>Only image files (<strong>JPG, GIF, PNG</strong>) are allowed in this demo (by default there is no file type restriction).</li>
                                    <li>Uploaded files will be deleted automatically after <strong>5 minutes</strong> (demo setting).</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row fileupload-buttonbar">
                            <div class="col-md-7">
                                <span class="btn btn-primary fileinput-button m-r-3">
                                    <i class="fa fa-plus"></i>
                                    <span>Add files...</span>
                                    <input type="file" name="files[]" multiple>
                                </span>
                                <button type="submit" class="btn btn-primary start m-r-3">
                                    <i class="fa fa-upload"></i>
                                    <span>Start upload</span>
                                </button>
                                <button type="reset" class="btn btn-default cancel m-r-3">
                                    <i class="fa fa-ban"></i>
                                    <span>Cancel upload</span>
                                </button>
                                <button type="button" class="btn btn-default delete m-r-3">
                                    <i class="glyphicon glyphicon-trash"></i>
                                    <span>Delete</span>
                                </button>
                                <!-- The global file processing state -->
                                <span class="fileupload-process"></span>
                            </div>
                            <!-- The global progress state -->
                            <div class="col-md-5 fileupload-progress fade">
                                <!-- The global progress bar -->
                                <div class="progress progress-striped active m-b-0">
                                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                </div>
                                <!-- The extended global progress state -->
                                <div class="progress-extended">&nbsp;</div>
                            </div>
                        </div>

                        <!-- begin table -->
                        <table class="table table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th width="10%">PREVIEW</th>
                                    <th>FILE INFO</th>
                                    <th>UPLOAD PROGRESS</th>
                                    <th width="1%"></th>
                                </tr>
                            </thead>
                            <tbody class="files">
                                <tr data-id="empty">
                                    <td colspan="4" class="text-center text-muted p-t-30 p-b-30">
                                        <div class="m-b-10"><i class="fa fa-file fa-3x"></i></div>
                                        <div>No file selected</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- end table -->
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 col-form-label">Description</label>
                    <div class="col-md-12">
                        <textarea name="description" class="form-control" placeholder="Type description of the report" rows="5"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 col-form-label">Customer Name *</label>
                    <div class="col-md-12">
                        <input class="form-control" data-parsley-required="true" placeholder="Type customer's name" type="text" name="customer_name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 col-form-label">Mobile Number *</label>
                    <div class="col-md-12">
                        <input class="form-control" data-parsley-required="true" placeholder="Type customer's mobile number" type="text" name="customer_mobile">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 col-form-label">Delivery Date</label>
                    <div class="col-md-12">
                        <input name="delivery_date" id="masked-input-date" type="text" class="form-control" placeholder="mm/dd/yyyy" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 col-form-label">Discount (In percentage)</label>
                    <div class="col-md-12">
                        <input class="form-control" placeholder="Type discount on the whole sale" data-parsley-type="number" data-parsley-min="0" name="discount">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 col-form-label">Doctor *</label>
                    <div class="col-md-12">
                        <select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="doctor_id">
                            <option value="">Select doctor of reference</option>
                            <?php
                            $doctor_categories = $this->security->xss_clean($this->db->get_where('staff_category', array('is_doctor' => 1))->result_array());
                            foreach ($doctor_categories as $doctor_category) :
                            ?>
                                <optgroup label="<?php echo $doctor_category['name']; ?>">
                                    <?php
                                    $doctors = $this->security->xss_clean($this->db->get_where('doctor', array('staff_category_id' => $doctor_category['staff_category_id']))->result_array());
                                    foreach ($doctors as $doctor) :
                                    ?>
                                        <option value="<?php echo $doctor['doctor_id']; ?>"><?php echo $doctor['name']; ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 col-form-label"></label>
                    <div class="col-md-12">
                        <a href="<?php echo base_url('reports'); ?>" class="btn btn-warning" aria-label="Close">Cancel</a>
                        <button type="submit" class="btn btn-yellow pull-right">Submit</button>
                    </div>
                </div>
            </div>
            <!-- end panel-body -->            
        </div>
        <!-- end panel -->
    <?php echo form_close(); ?>
    <!-- end form-file-upload -->
</div>
<!-- end #content -->

<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade show">
            <td>
                <span class="preview"></span>
            </td>
            <td>
                <div class="alert alert-secondary p-10 m-b-0">
                    <dl class="m-b-0">
                        <dt class="text-inverse">File Name:</dt>
                        <dd class="name">{%=file.name%}</dd>
                        <dt class="text-inverse m-t-10">File Size:</dt>
                        <dd class="size">Processing...</dd>
                    </dl>
                </div>
                <strong class="error text-danger"></strong>
            </td>
            <td>
                <dl>
                    <dt class="text-inverse m-t-3">Progress:</dt>
                    <dd class="m-t-5">
                        <div class="progress progress-sm progress-striped active rounded-corner"><div class="progress-bar progress-bar-primary" style="width:0%; min-width: 40px;">0%</div></div>
                    </dd>
                </dl>
            </td>
            <td nowrap>
                {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn btn-primary start width-100 p-r-20 m-r-3" disabled>
                        <i class="fa fa-upload fa-fw pull-left m-t-2 m-r-5 text-inverse"></i>
                        <span>Start</span>
                    </button>
                {% } %}
                {% if (!i) { %}
                    <button class="btn btn-default cancel width-100 p-r-20">
                        <i class="fa fa-trash fa-fw pull-left m-t-2 m-r-5 text-muted"></i>
                        <span>Cancel</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-download fade show">
            <td width="1%">
                <span class="preview">
                    {% if (file.thumbnailUrl) { %}
                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                    {% } else { %}
                        <div class="bg-silver text-center f-s-20" style="width: 80px; height: 80px; line-height: 80px; border-radius: 6px;">
                            <i class="fa fa-file-image fa-lg text-muted"></i>
                        </div>
                    {% } %}
                </span>
            </td>
            <td>
                <div class="alert alert-secondary p-10 m-b-0">
                    <dl class="m-b-0">
                        <dt class="text-inverse">File Name:</dt>
                        <dd class="name">
                            {% if (file.url) { %}
                                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                            {% } else { %}
                                <span>{%=file.name%}</span>
                            {% } %}
                        </dd>
                        <dt class="text-inverse m-t-10">File Size:</dt>
                        <dd class="size">{%=o.formatFileSize(file.size)%}</dd>
                    </dl>
                    {% if (file.error) { %}
                        <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                    {% } %}
                </div>
            </td>
            <td></td>
            <td>
                {% if (file.deleteUrl) { %}
                    <button class="btn btn-danger delete width-100 m-r-3 p-r-20" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                        <i class="fa fa-trash pull-left fa-fw text-inverse m-t-2"></i>
                        <span>Delete</span>
                    </button>
                    <input type="checkbox" name="delete" value="1" class="toggle">
                {% } else { %}
                    <button class="btn btn-default cancel width-100 m-r-3 p-r-20">
                        <i class="fa fa-trash pull-left fa-fw text-muted m-t-2"></i>
                        <span>Cancel</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
</script>

<script>
	"use strict";

	$(document).ready({
        $('.select2, .select2-search__field').css('width', '100%');
	$('input.select2-search__field').attr('placeholder', 'Select one or multiple report categories');

	$("#report_cat").on('change', function() {
		var cats = [];
		$.each($("#report_cat option:selected"), function() {
			cats.push($(this).val());
		});

		if (cats.length == 0) {
			$('input.select2-search__field').attr('placeholder', 'Select one or multiple report categories');
		}
	});
    });
</script>