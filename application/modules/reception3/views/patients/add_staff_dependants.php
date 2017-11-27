<p class="center-align">Enter a staff's number to add their dependants</p>
<form class="form-horizontal" role="form" method="POST" id="search_dependant_parent" action="<?php echo site_url().'reception/search_dependant_parent'?>">
    <div class="form-group">
        <label class="col-lg-2 control-label">Staff Number</label>
        <div class="col-lg-8">
        	<input type="text" class="form-control" name="patient_parent_number" placeholder="">
        </div>
        <div class="col-lg-2">
        	<button class="btn btn-info btn-lg" type="submit">Search</button>
        </div>
    </div>
</form>

<div id="add_staff_dependant_error"></div>
<div id="add_staff_dependant"></div>

<script type="text/javascript">

$(document).on("submit","form#search_dependant_parent",function(e)
{
	e.preventDefault();
	var staff_number = $("input[name=patient_parent_number]").val();
	$.get("<?php echo site_url();?>reception/search_dependant_parent/"+staff_number, function( data ) {
		$("#add_staff_dependant").html(data);
	});
	return false;
});

$(document).on("submit","form#submit_staff_dependant",function(e)
{
	e.preventDefault();
	var form_data = new FormData(this);
	var submit_url = $(this).attr("action");
    $.ajax({
		type:'POST',
		url: submit_url,
		cache:false,
		data: form_data,
		contentType: false,
		processData: false,
		dataType: 'json',
		success:function(data)
		{
			if(data.response == "success")
			{
				$("#add_staff_dependant_error").html(data.message);
				window.location.href = "<?php echo site_url();?>reception/set_visit/"+data.patient_id;
			}
			else
			{
				$("#add_staff_dependant_error").html(data.message);
			}
		},
		error: function(xhr, status, error) {
			console.log("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
		}
	});
	return false;
});
</script>