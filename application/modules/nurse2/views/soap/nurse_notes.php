<?php

$v_data['signature_location'] = base_url().'assets/signatures/';
$v_data['query'] = $this->nurse_model->get_notes(1, $visit_id);

if(!isset($mobile_personnel_id))
{
	$mobile_personnel_id = NULL;
}
$v_data['mobile_personnel_id'] = $mobile_personnel_id;

$notes = $this->load->view('nurse/patients/notes', $v_data, TRUE);

echo '<div id="nurse_notes_section">'.$notes.'</div>';
echo form_open('nurse/save_nurse_notes/'.$visit_id, array('class' => 'form-horizontal', 'id' => 'nurse_notes_form', 'visit_id' => $visit_id));
	
echo
'	<div class="row">
		<div class="col-sm-6" >
			<div class="form-group">
				<label class="control-label">Date</label>
				<div id="datetimepicker_other_patient" class="input-append">
                    <input data-format="yyyy-MM-dd" class="picker" id="nurse_notes_date" type="text" name="date" placeholder="Date" value="'.date('Y-m-d').'">
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
				<div id="datetimepicker2" class="input-append">
				   <input data-format="hh:mm" class="picker" id="nurse_notes_time" name="time"  type="text" class="form-control" value="'.date('H:i').'">
				   <span class="add-on" style="cursor:pointer;">
					 &nbsp;<i data-time-icon="icon-time" data-date-icon="icon-calendar">
					 </i>
				   </span>
				</div>
			</div>
		</div>
	</div>';
	

if($mobile_personnel_id != NULL)
{
	echo '
	<!--<div class="row">
		<div class="col-md-12 sigPad" >
			<label class="control-label">Signature</label>
			<div class="sig ">
				<div class="typed"></div>
				<canvas class="pad sigWrapper"></canvas>
				<a id="clear" class="btn btn-default">Clear signature</a>
				<input type="hidden" name="output" class="output">
			</div>
		</div>
	</div>-->
	<div class="row">
		<div class="col-md-12 sigPad" >
			<ul class="sigNav">
				<li class="typeIt"><a href="#type-it"></a></li>
				<li class="drawIt"><a href="#draw-it" class="current" >Click to sign</a></li>
				<li class="clearButton"><a href="#clear">Clear</a></li>
			</ul>
			<div class="sig ">
				<div class="typed"></div>
				<canvas class="pad sigWrapper"></canvas>
				<input type="hidden" name="output" class="output">
			</div>
		</div>
	</div>';
}

echo '	
	<div class="row" style="margin-top:10px;">
		<div class="col-md-12" >
			<textarea id="nurse_notes_item" class="cleditor" rows="10" name="nurse_notes"></textarea>
		</div>
	</div>
	
	<br>
	<div class="row">
	    <div class="col-md-12">
			<div class="center-align">
				<button type="submit" class="btn btn-large btn-primary">Update</button>
			</div>
	    </div>
	</div>
';
echo form_close();
?>

<script type="text/javascript">
	
	$(document).on("submit", "form#nurse_notes_form", function (e) 
	{
		e.preventDefault();
		console.debug(tinymce.activeEditor.getContent());
	   	var nurse_notes = tinymce.get('nurse_notes_item').getContent();
		var visit_id = '<?php echo $visit_id;?>';
		var config_url = $('#config_url').val();
        var data_url = config_url+"nurse/save_nurse_notes/"+visit_id;
        //window.alert(data_url);
         //var nurse_notes = $('#nurse_notes_item').val();//document.getElementById("vital"+vital_id).value;
		 var nurse_notes_date = $('#nurse_notes_date').val();
		 var nurse_notes_time = $('#nurse_notes_time').val();
        $.ajax({
			type:'POST',
			url: data_url,
			data:{notes: nurse_notes, date: nurse_notes_date, time: nurse_notes_time},
			dataType: 'json',
			success:function(data){
				if(data.result == 'success')
				{
					$('#nurse_notes_section').html(data.message);
					$('#soap_nurse_notes_section').html(data.message);
					alert("You have successfully updated the doctors' notes");
				}
				else
				{
					alert("Unable to update the doctors' notes");
				}
			//obj.innerHTML = XMLHttpRequestObject.responseText;
			},
			error: function(xhr, status, error) {
				//alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
				alert(error);
			}

        });
		return false;
	})
	
	$(document).on("submit", "form#edit_nurse_notes", function (e) 
	{
		e.preventDefault();
		$('#notes_response'+notes_id).html('');
		var notes_id = $(this).attr('notes_id');
		var notes_div_name = 'nurse_notes'+notes_id;
		var nurse_notes = tinymce.activeEditor.getContent();
		//alert(nurse_notes);
	   	//var nurse_notes = tinymce.get(notes_div_name).getContent();alert(nurse_notes);
		var nurse_notes_date = $('#date'+notes_id).val();
		var nurse_notes_time = $('#time'+notes_id).val();
		var notes_type_id = $('#notes_type_id'+notes_id).val();
		var visit_id = '<?php echo $visit_id;?>';
		var config_url = $('#config_url').val();
        var data_url = config_url+"nurse/update_nurse_notes/"+notes_id+'/'+notes_type_id+'/'+visit_id;
		
        $.ajax({
			type:'POST',
			url: data_url,
			data:{notes: nurse_notes, date: nurse_notes_date, time: nurse_notes_time},
			dataType: 'json',
			success:function(data){
				if(data.result == 'success')
				{
					$('#notes_response'+notes_id).html('<div class="alert alert-success center-align">Update successfull</div>');
					//nurse notes
					if(notes_type_id == '1')
					{
						$('#nurse_notes_section').html(data.message);
						$('#soap_nurse_notes_section').html(data.message);
					}
					
					//symptoms
					else if(notes_type_id == '3')
					{
						$('#symptoms_section').html(data.message);
					}
					
					//objective findings
					else if(notes_type_id == '4')
					{
						$('#objective_findings_section').html(data.message);
					}
					
					//assessment
					else if(notes_type_id == '5')
					{
						$('#assessment_section').html(data.message);
					}
					
					//plan
					else if(notes_type_id == '6')
					{
						$('#plan_section').html(data.message);
					}
					$('#edit_notes'+notes_id).modal('hide');
					//initiate WYSIWYG editor
					tinymce.init({
						selector: ".cleditor",
						height : "100"
					});
					//alert("You have successfully updated your notes");
				}
				else
				{
					alert("Unable to update the notes");
				}
			},
			error: function(xhr, status, error) {
				//alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
				alert(error);
			}

        });
		return false;
	})
	
	$(document).on("click", "a.delete_nurse_notes", function (e) 
	{
		e.preventDefault();
		var visit_id = $(this).attr('visit_id');
		var notes_id = $(this).attr('notes_id');
		var notes_type_id = $(this).attr('notes_type_id');
		
        var data_url = config_url+"nurse/delete_nurse_notes/"+notes_id+'/'+notes_type_id+'/'+visit_id;
		
		$.ajax({
			type:'POST',
			url: data_url,
			data:{},
			dataType: 'json',
			success:function(data){
				if(data.result == 'success')
				{
					//nurse notes
					if(notes_type_id == '1')
					{
						$('#nurse_notes_section').html(data.message);
						$('#soap_nurse_notes_section').html(data.message);
					}
					
					//symptoms
					else if(notes_type_id == '3')
					{
						$('#symptoms_section').html(data.message);
					}
					
					//objective findings
					else if(notes_type_id == '4')
					{
						$('#objective_findings_section').html(data.message);
					}
					
					//assessment
					else if(notes_type_id == '5')
					{
						$('#assessment_section').html(data.message);
					}
					
					//plan
					else if(notes_type_id == '6')
					{
						$('#plan_section').html(data.message);
					}
					//initiate WYSIWYG editor
					tinymce.init({
						selector: ".cleditor",
						height : "100"
					});
					alert("You have successfully deleted your notes");
				}
				else
				{
					alert("Unable to delete the notes");
				}
			//obj.innerHTML = XMLHttpRequestObject.responseText;
			},
			error: function(xhr, status, error) {
				//alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
				alert(error);
			}

        });
		return false;
	})
</script>