<?php

$v_data['signature_location'] = base_url().'assets/signatures/';
$v_data['query'] = $this->nurse_model->get_notes(2, $visit_id);

if(!isset($mobile_personnel_id))
{
	$mobile_personnel_id = NULL;
}
$v_data['mobile_personnel_id'] = $mobile_personnel_id;

$notes = $this->load->view('nurse/patients/notes', $v_data, TRUE);

echo '<div id="doctor_notes_section">'.$notes.'</div>';
$patient_id = $this->nurse_model->get_patient_id($visit_id);


$get_medical_rs = $this->nurse_model->get_doctor_notes($patient_id);
$num_rows = count($get_medical_rs);
//echo $num_rows;

if($num_rows > 0){
	foreach ($get_medical_rs as $key2) :
		$doctor_notes = $key2->doctor_notes;
	endforeach;

echo
'	<div class="row">
		<div class="col-sm-6" >
			<div class="form-group">
				<label class="control-label">Date</label>
				<div id="datetimepicker1" class="input-append">
                    <input data-format="yyyy-MM-dd" class="picker" id="doctor_notes_date" type="text" name="date" placeholder="Date" value="'.date('Y-m-d').'">
                    <span class="add-on">
                        &nbsp;<i data-time-icon="icon-time" data-date-icon="icon-calendar" style="cursor:pointer;">
                        </i>
                    </span>
                </div>
			</div>
		</div>
		
		<div class="col-sm-6" >
			<div class="form-group">
				<label class="control-label">Time</label>
				<div id="datetimepicker3" class="input-append">
				   <input data-format="hh:mm" class="picker" id="doctor_notes_time" name="time"  type="text" class="form-control" value="'.date('H:i').'">
				   <span class="add-on" style="cursor:pointer;">
					 &nbsp;<i data-time-icon="icon-time" data-date-icon="icon-calendar">
					 </i>
				   </span>
				</div>
			</div>
		</div>
	</div>';

echo
'
	<div class="row">
		<div class="col-md-12">
			 <textarea id="doctor_notes_item" rows="10" cols="100" class="cleditor" ></textarea>
		</div>
	</div>
	<br>
	<div class="row">
	    <div class="col-md-12">
	        <div class="form-group">
	            <div class="col-lg-12">
	                <div class="center-align">
	                      <a hred="#" class="btn btn-sm btn-primary" onclick="save_doctor_notes('.$visit_id.')">Update Doctor Notes</a>
	                  </div>
	            </div>
	        </div>
	    </div>
	</div>
';
}

else{
echo

'
	<div class="row">
		<div class="col-md-12" style="height:500px;">
			 <textarea id="doctor_notes_item" rows="10" cols="100" class="cleditor" ></textarea>
		</div>
	</div>
	<br>
	<div class="row">
	    <div class="col-md-12">
	        <div class="form-group">
	            <div class="col-lg-12">
	                <div class="center-align">
	                      <a hred="#" class="btn btn-sm btn-success" onclick="save_doctor_notes('.$visit_id.')">Save Doctor Notes</a>
	                  </div>
	            </div>
	        </div>
	    </div>
	</div>
';
}
	
?>
