<?php

$v_data['signature_location'] = base_url().'assets/signatures/';
$v_data['query'] = $this->nurse_model->get_notes(5, $visit_id);

if(!isset($mobile_personnel_id))
{
	$mobile_personnel_id = NULL;
}
$v_data['mobile_personnel_id'] = $mobile_personnel_id;

$notes = $this->load->view('nurse/patients/notes', $v_data, TRUE);

?>
	<div class='row'>
		<div class='col-md-2 col-md-offset-8'>
			<button type='button' class='btn btn-success' data-toggle='modal' data-target='#add_assessment'>Add Assessment</button>
		</div>
	</div>
    <div class="modal fade bs-example-modal-lg" id="add_assessment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Assessment</h4>
                </div>
                <div class="modal-body">
                	<div class="row">
                    	<div class='col-md-12'>
                            <textarea class='cleditor' id='visit_assessment' ></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a class='btn btn-info btn-sm' type='submit' onclick='save_assessment(<?php echo $visit_id;?>)'>Add Assessment</a>
                </div>
            </div>
        </div>
    </div>
	<div class='row'>
    	<div class="col-md-12">
            <h4>Assessment</h4>
            <div id="assessment_section"><?php echo $notes;?></div>
        </div>
    </div>