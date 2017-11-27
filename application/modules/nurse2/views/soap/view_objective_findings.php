<?php

$rs2 = $this->nurse_model->get_visit_objective_findings($visit_id);
$num_rows2 = count($rs2);

$v_data['signature_location'] = base_url().'assets/signatures/';
$v_data['query'] = $this->nurse_model->get_notes(4, $visit_id);

if(!isset($mobile_personnel_id))
{
	$mobile_personnel_id = NULL;
}
$v_data['mobile_personnel_id'] = $mobile_personnel_id;

$notes = $this->load->view('nurse/patients/notes', $v_data, TRUE);

?>
	<div class='row'>
		<div class='col-md-2 col-md-offset-8'>
			<input type='button' class='btn btn-primary' value='Objective Findings List' onclick='open_objective_findings(<?php echo $visit_id;?>)'/>
		</div>
		<div class='col-md-2'>
			<button type='button' class='btn btn-success' data-toggle='modal' data-target='#add_objective_findings'>Add Objective Findings</button>
		</div>
	</div>
    <div class="modal fade bs-example-modal-lg" id="add_objective_findings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Objective Findings</h4>
                </div>
                <div class="modal-body">
                	<div class="row">
                    	<div class='col-md-12'>
                            <textarea class='cleditor' id='visit_objective_findings' ></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a class='btn btn-info btn-sm' type='submit' onclick='save_objective_findings(<?php echo $visit_id;?>)'>Add Objective Findings</a>
                </div>
            </div>
        </div>
    </div>
	<div class='row'>
		<div class='col-md-4'>
        	<h4>Selected Objective Findings</h4>
<?php

	echo
	"
		<div class='col-md-4' id='visit_objective_findings1'>"; 
if($num_rows2 > 0){
			
	echo"<table class='table table-condensed table-striped table-bordered'>"; 
		echo"<tr>"; 
			echo"<th>";
				echo"#"; 
			echo"</th>"; 
			echo"<th>";
				echo"Group"; 
			echo"</th>"; 
			echo"<th>";
				echo"Name"; 
			echo"</th>"; 
			echo"<th>";
				echo"Description"; 
			echo"</th>"; 
		echo"</tr>"; 
		$count=0;
		
			foreach ($rs2 as $key):
				$count++;
				$objective_findings_name = $key->objective_findings_name;
				$visit_objective_findings_id = $key->visit_objective_findings_id;
				$objective_findings_class_name = $key->objective_findings_class_name;
				$description= $key->description;
				
				echo"<tr>"; 
					echo"<td>";
						echo $count; 
					echo"</td>"; 
					echo"<td>";
						echo $objective_findings_class_name; 
					echo"</td>"; 
					echo"<td>";
						echo $objective_findings_name; 
					echo"</td>"; 
					echo"<td>";
						echo $description; 
					echo"</td>"; 
				echo"<tr>"; 
			endforeach; 
			echo "
			</table>
	";
} 
			echo "
		</div>
	";

?>
        </div>
        
        <div class="col-md-8">
            <h4>Other Objective Findings</h4>
            <div id="objective_findings_section"><?php echo $notes;?></div>
        </div>
    </div>