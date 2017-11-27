<?php

$rs2 = $this->nurse_model->get_visit_symptoms($visit_id);
$num_rows2 = count($rs2);

$v_data['signature_location'] = base_url().'assets/signatures/';
$v_data['query'] = $this->nurse_model->get_notes(3, $visit_id);

if(!isset($mobile_personnel_id))
{
	$mobile_personnel_id = NULL;
}
$v_data['mobile_personnel_id'] = $mobile_personnel_id;

$notes = $this->load->view('nurse/patients/notes', $v_data, TRUE);

?>
	<div class='row'>
		<div class='col-md-2 col-md-offset-8'>
			<input type='button' class='btn btn-primary' value='Symptoms List' onclick='open_symptoms(<?php echo $visit_id;?>)'/>
		</div>
		<div class='col-md-2'>
			<button type='button' class='btn btn-success' data-toggle='modal' data-target='#add_symptoms'>Add Symptoms</button>
		</div>
	</div>
    <div class="modal fade bs-example-modal-lg" id="add_symptoms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Symptoms</h4>
                </div>
                <div class="modal-body">
                	<div class="row">
                    	<div class='col-md-12'>
                        	<input type="hidden" name="date" value="<?php echo date('Y-m-d');?>" />
                        	<input type="hidden" name="time" value="<?php echo date('H:i');?>" />
                            <textarea class='cleditor' id='visit_symptoms'></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a class='btn btn-info btn-sm' type='submit' onclick='save_symptoms(<?php echo $visit_id;?>)'>Add Symptoms</a>
                </div>
            </div>
        </div>
    </div>
	<div class='row'>
		<div class='col-md-4'>
        	<h4>Selected Symptoms</h4>
<?php
//symptoms table
	echo '<div id="visit_symptoms1">';
if($num_rows2 > 0){
	echo"<table class='table table-striped table-condensed table-bordered'>"; 
		echo"<tr>"; 
			echo"<th>";
				echo"#"; 
			echo"</th>"; 
			echo"<th>";
				echo"Symptom"; 
			echo"</th>"; 
			echo"<th>";
				echo"Yes/ No"; 
			echo"</th>"; 
			echo"<th>";
				echo"Description"; 
			echo"</th>"; 
		echo"</tr>"; 
			$count=0;
			foreach ($rs2 as $key):	
				$count++;
				$symptoms_name = $key->symptoms_name;
				$status_name = $key->status_name;
				$visit_symptoms_id = $key->visit_symptoms_id;
				$description= $key->description;
				
				echo"<tr>"; 
					echo"<td>";
						echo $count; 
					echo"</td>"; 
					echo"<td>";
						echo $symptoms_name; 
					echo"</td>"; 
					echo"<td>";
						echo $status_name; 
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

else
{
	echo '<p>No symptoms selected</p>';
}
			echo "
		</div>
	";

?>

        </div>
        
        <div class="col-md-8">
            <h4>Other Symptoms</h4>
            <div id="symptoms_section"><?php echo $notes;?></div>
        </div>
    </div><script type="text/javascript">
			$(document).ready(function(){
				tinymce.init({
					selector: ".cleditor"
				});
            });
        </script>