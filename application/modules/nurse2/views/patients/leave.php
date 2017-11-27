<?php
$leave_types = $this->leave_model->get_leave_types();
$patient_leaves = $this->leave_model->get_patient_leaves($patient_id);
$total_leave_days = $this->leave_model->calculate_total_annual_leave($patient_id);
?>
<div class="row">
	<div class="col-md-12">
		<section class="panel panel-featured panel-featured-info">
			<header class="panel-heading">
				<h2 class="panel-title">Add Leave</h2>
			</header>

			<div class="panel-body">
                <?php echo form_open('doctor/add_patient_leave/'.$visit_id);?>
                	<div class="form-group">
                        <label for="leave_type" class="col-md-4">Leave Type</label>
                        <div class="col-md-8">
                        	<select class="form-control" name="leave_type_id">
                            	<option value="">--Select Leave Type</option>
                            	<?php
                                	if($leave_types->num_rows())
									{
										foreach($leave_types->result() as $res)
										{
											$leave_type_id = $res->leave_type_id;
											$leave_type_name = $res->leave_type_name;
											
											echo '<option value="'.$leave_type_id.'">'.$leave_type_name.'</option>';
										}
									}
								?>
                            </select>
                        </div>
                    </div>
                	<div class="form-group">
                        <label for="start_date" class="col-md-4">Start Date</label>
                        <div class="col-md-8">
                        	<div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input data-format="yyyy-MM-dd" type="text" data-plugin-datepicker class="form-control" name="start_date" id="start_date" placeholder="Start date">
                            </div>
                        </div>
                    </div>
                	<div class="form-group">
                        <label for="no_of_days" class="col-md-4">Number of Days</label>
                        <div class="col-md-8">
                        	<input type="text" class="form-control" name="no_of_days" id="calculate_end_date" placeholder="Number of Days">
                        </div>
                    </div>
                	<div class="form-group">
                        <label for="no_of_days" class="col-md-4">End Date</label>
                        <div class="col-md-8">
                        	<input type="text" class="form-control" name="end_date" readonly id="end_date" placeholder="End Date">
                        </div>
                    </div>
                	<div class="form-group">
                        <label for="comments" class="col-md-4">Comments</label>
                        <div class="col-md-8">
                        	<textarea name="comments" class="form-control" placeholder="Comments"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4 col-md-offset-6">
                    	<button type="submit" class="btn btn-primary">Add Leave</button>
                    </div>
                <?php echo form_close();?>
            </div>
		</section>
    </div>
</div>


<div class="row">
	<div class="col-md-12">
		<section class="panel panel-featured panel-featured-info">
			<header class="panel-heading">
				<h2 class="panel-title">Assigned Leave</h2>
			</header>

			<div class="panel-body">
            	<div class="col-md-6 col-lg-6 col-xl-6">
					<section class="panel panel-featured-left panel-featured-tertiary">
						<div class="panel-body">
							<div class="widget-summary">
								<div class="widget-summary-col widget-summary-col-icon">
									<div class="summary-icon bg-tertiary">
										<i class="fa fa-calendar"></i>
									</div>
								</div>
								<div class="widget-summary-col">
									<div class="summary">
										<h4 class="title">Total Leave Days</h4>
										<div class="info">
											<strong class="amount"><?php echo $total_leave_days;?> days</strong>
										</div>
									</div>
									<div class="summary-footer">
										<!--<a class="text-muted text-uppercase">(statement)</a>-->
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
            	<table class="table table-condensed table-striped table-hover">
                	<tr>
                    	<th>#</th>
                    	<th>Start Date</th>
                    	<th>End Date</th>
                    	<th>No of Days</th>
                    	<th>Assigned By</th>
                    	<th>Leave Type</th>
                    	<th>Comments</th>
                    	<th colspan="2">Actions</th>
                    </tr>
            	<?php
					$count = 0;
                	if($patient_leaves->num_rows() > 0)
					{
						foreach($patient_leaves->result() as $res)
						{
							$count++;
							$patient_leave_id = $res->patient_leave_id;
							$start_date = $res->start_date;
							$end_date = $res->end_date;
							$no_of_days = $res->no_of_days;
							$personnel_fname = $res->personnel_fname;
							$personnel_onames = $res->personnel_onames;
							$leave_type_name = $res->leave_type_name;
							$comments = $res->comments;
							?>
                            <tr>
                            	<td><?php echo $count;?></td>
                            	<td><?php echo $start_date;?></td>
                            	<td><?php echo $end_date;?></td>
                            	<td><?php echo $no_of_days;?></td>
                            	<td><?php echo $personnel_fname.' '.$personnel_onames;?></td>
                            	<td><?php echo $leave_type_name;?></td>
                            	<td><?php echo $comments;?></td>
                                <td><a href="<?php echo site_url().'doctor/edit_patient_leave/'.$visit_id.'/'.$patient_leave_id;?>" class="btn btn-success btn-sm">Edit</a></td>
                                <td><a href="<?php echo site_url().'doctor/delete_patient_leave/'.$visit_id.'/'.$patient_leave_id;?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure you want to delete this leave?')">Delete</a></td>
                            </tr>
                            <?php
						}
					}
				?>
                </table>
            </div>
		</section>
    </div>
</div>

<script type="text/javascript">
	$(document).on("focusout", "#calculate_end_date",function(e)
	{
        var config_url = document.getElementById("config_url").value;
        var no_of_days = $(this).val();
        var start_date = $('#start_date').val();
        var data_url = config_url+"doctor/calculate_end_date/"+no_of_days+"/"+start_date;
       
        $.ajax({
			type:'POST',
			url: data_url,
			dataType: 'text',
			success:function(data)
			{
				$('#end_date').val(data);
			},
			error: function(xhr, status, error)
			{
				//alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
				alert(error);
			}

        });
        
	});
</script>