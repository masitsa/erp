<?php
$reopen_result = '';
if($query->num_rows() > 0)
{
	$count = 0;
	$reopen_result .= 
			'
				<table class="table table-hover table-bordered ">
					  <thead>
						<tr>
						  <th>#</th>
						  <th>Surname</th>
						  <th>Other Names</th>
						  <th>Last Visit</th>
						  <th colspan="2">Actions</th>
						</tr>
					  </thead>
					  <tbody>
			';
	foreach ($query->result() as $row)
	{
		$patient_id = $row->patient_id;
		$dependant_id = $row->dependant_id;
		$strath_no = $row->strath_no;
		$created_by = $row->created_by;
		$modified_by = $row->modified_by;
		$deleted_by = $row->deleted_by;
		$visit_type_id = $row->visit_type_id;
		$created = $row->patient_date;
		$last_modified = $row->last_modified;
		$last_visit = date('jS M Y',strtotime($row->last_visit));
		$visit_id = $row->visit_id;
		$patient_phone1 = $row->patient_phone1;
		$patient_othernames = $row->patient_othernames;
		$patient_surname = $row->patient_surname;
		$count++; 
		
		$reopen_result .= 
			'<tr>
				<td>'.$count.'</td>
				<td>'.$patient_surname.'</td>
				<td>'.$patient_othernames.'</td>
				<td>'.$last_visit.'</td>
				<td><a href="'.site_url().'reception/reopen_visit/'.$visit_id.'" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Reopen Card</a></td>
			</tr>
			';
		
	}
	$reopen_result .= 
			'</tbody>
		</table>';
}
else
{
	$reopen_result .= 'No patients have been seen today';
}
?>
<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title"><?php echo $title;?></h2>
    </header>
    <div class="panel-body">
    	<?php echo $reopen_result;?>
    </div>
</section>