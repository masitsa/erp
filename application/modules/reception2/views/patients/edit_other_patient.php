<?php
//patient data
$row = $patient->row();
$patient_surname = $row->patient_surname;
$patient_othernames = $row->patient_othernames;
$title_id = $row->title_id;
$patient_date_of_birth = $row->patient_date_of_birth;
$gender_id = $row->gender_id;
$county_id = $row->county_id;
$religion_id = $row->religion_id;
$civil_status_id = $row->civil_status_id;
$patient_email = $row->patient_email;
$patient_address = $row->patient_address;
$patient_postalcode = $row->patient_postalcode;
$patient_town = $row->patient_town;
$patient_phone1 = $row->patient_phone1;
$patient_phone2 = $row->patient_phone2;
//$patient_county = $row->patient_county;
$patient_location = $row->patient_location;
$patient_refferal = $row->patient_refferal;
$patient_occupation = $row->patient_occupation;
$patient_kin_sname = $row->patient_kin_sname;
$patient_kin_othernames = $row->patient_kin_othernames;
$relationship_id = $row->relationship_id;
$patient_national_id = $row->patient_national_id;
$insurance_company_id = $row->insurance_company_id;
$next_of_kin_contact = $row->patient_kin_phonenumber1;
$current_patient_number = $row->current_patient_number;
//echo $gender_id;
//repopulate data if validation errors occur
$validation_error = validation_errors();
                
if(!empty($validation_error))
{
    $patient_surname = set_value('patient_surname');
    $patient_othernames = set_value('patient_othernames');
    $title_id = set_value('title_id');
    $patient_date_of_birth = set_value('patient_dob');
    $religion_id = set_value('religion_id');
    $gender_id = set_value('gender_id');
    $county_id = set_value('county_id');
    $religion_id = set_value('religion_id');
    $civil_status_id = set_value('civil_status_id');
    $patient_email = set_value('patient_email');
    $patient_address = set_value('patient_address');
    $patient_postalcode = set_value('patient_postalcode');
    $patient_town = set_value('patient_town');
    $patient_phone1 = set_value('patient_phone1');
    $patient_phone2 = set_value('patient_phone2');
    $patient_location = set_value('patient_location');
    $patient_occupation = set_value('patient_occupation');
    $patient_refferal = set_value('patient_refferal');
    $patient_kin_sname = set_value('patient_kin_sname');
    $patient_kin_othernames = set_value('patient_kin_othernames');
    $relationship_id = set_value('relationship_id');
    $insurance_company_id = set_value('insurance_company_id');
    $patient_national_id = set_value('patient_national_id');
    $next_of_kin_contact = set_value('next_of_kin_contact');
    $current_patient_number = set_value('current_patient_number');
 
}
?>
 <section class="panel">
    <div class="row">
        <div class="col-md-12">

          <!-- Widget -->
         <header class="panel-heading">
              <h4 class="pull-left"><i class="icon-reorder"></i>Edit <?php echo $patient_surname.' '.$patient_othernames;?></h4>
              <div class="widget-icons pull-right">
                     <a href="<?php echo site_url();?>reception/patients-list" class="btn btn-success btn-sm pull-right">  Patients List</a>
              </div>
              <div class="clearfix"></div>
        </header>             

            <!-- Widget content -->
        <div class="panel-body">
              <div class="padd">
              <div class="center-align">
                <?php
                    $error = $this->session->userdata('error_message');
                    $success = $this->session->userdata('success_message');
                    
                    if(!empty($error))
                    {
                        echo '<div class="alert alert-danger">'.$error.'</div>';
                        $this->session->unset_userdata('error_message');
                    }
                    
                    if(!empty($validation_error))
                    {
                        echo '<div class="alert alert-danger">'.$validation_error.'</div>';
                    }
                    
                    if(!empty($success))
                    {
                        echo '<div class="alert alert-success">'.$success.'</div>';
                        $this->session->unset_userdata('success_message');
                    }
                ?>
              </div>
                <?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal"));?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Title: </label>
                                
                                <div class="col-md-8">
                                    <select class="form-control" name="title_id">
                                        <?php
                                            if($titles->num_rows() > 0)
                                            {
                                                $title = $titles->result();
                                                
                                                foreach($title as $res)
                                                {
                                                    $db_title_id = $res->title_id;
                                                    $title_name = $res->title_name;
                                                    
                                                    if($db_title_id == $title_id)
                                                    {
                                                        echo '<option value="'.$db_title_id.'" selected>'.$title_name.'</option>';
                                                    }
                                                    
                                                    else
                                                    {
                                                        echo '<option value="'.$db_title_id.'">'.$title_name.'</option>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Surname: </label>
                                
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="patient_surname" placeholder="Surname" value="<?php echo $patient_surname;?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Other Names: </label>
                                
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="patient_othernames" placeholder="Other Names" value="<?php echo $patient_othernames;?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Date of Birth: </label>
                                
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input data-format="yyyy-MM-dd" type="text" data-plugin-datepicker class="form-control" name="patient_dob" placeholder="Date of Birth" value="<?php echo $patient_date_of_birth;?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Gender: </label>
                                
                                <div class="col-md-8">
                                    <select class="form-control" name="gender_id">
                                        <?php
                                            if($genders->num_rows() > 0)
                                            {
                                                $gender = $genders->result();
                                                
                                                foreach($gender as $res)
                                                {
                                                    $db_gender_id = $res->gender_id;
                                                    $gender_name = $res->gender_name;
                                                    
                                                    if($db_gender_id == $gender_id)
                                                    {
                                                        echo '<option value="'.$db_gender_id.'" selected>'.$gender_name.'</option>';
                                                    }
                                                    
                                                    else
                                                    {
                                                        echo '<option value="'.$db_gender_id.'">'.$gender_name.'</option>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        <div class="form-group">
                              <label class="col-lg-4 control-label">Religion: </label>
            
			             <div class="col-lg-8">
			        	     <select class="form-control" name="religion_id">
			            	<?php
			                	if($religions->num_rows() > 0)
								{
									$religion = $religions->result();
									
									foreach($religion as $res)
									{
										$db_religion_id = $res->religion_id;
										$religion_name = $res->religion_name;
										
										if($db_religion_id == $religion_id)
										{
											echo '<option value="'.$db_religion_id.'" selected>'.$religion_name.'</option>';
										}
										
										else
										{
											echo '<option value="'.$db_religion_id.'">'.$religion_name.'</option>';
										}
									}
								}
							?>
			            </select>
			        </div>
        </div>
                            
                            
                           
                            <div class="form-group">
                                <label class="col-md-4 control-label">Email Address: </label>
                                
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="patient_email" placeholder="Email Address" value="<?php echo $patient_email;?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">National ID: </label>
                                
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="patient_national_id" placeholder="National ID" value="<?php echo $patient_national_id;?>">
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-md-4 control-label">Refferal Facility: </label>
                                
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="patient_refferal" placeholder="Refferal Facility" value="<?php echo $patient_refferal;?>">
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="col-md-6">
                            
                           
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Primary Phone: </label>
                                
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="patient_phone1" placeholder="Primary Phone" value="<?php echo $patient_phone1;?>">
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-md-4 control-label">Location: </label>
                                
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="patient_location" placeholder="Location" value="<?php echo $patient_location;?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Other Phone: </label>
                                
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="patient_phone2" placeholder="Other Phone" value="<?php echo $patient_phone2;?>">
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-md-4 control-label">County : </label>
                                
                                <div class="col-md-8">
                                    <select class="form-control" name="county_id">
                                        <?php
                                            if($countys->num_rows() > 0)
                                            {
                                                $county = $countys->result();
                                                
                                                foreach($county as $res)
                                                {
                                                    $db_county_id = $res->county_id;
                                                    $county_name = $res->county_name;
                                                    
                                                    if($db_county_id == $county_id)
                                                    {
                                                        echo '<option value="'.$db_county_id.'" selected>'.$county_name.'</option>';
                                                    }
                                                    
                                                    else
                                                    {
                                                        echo '<option value="'.$db_county_id.'">'.$county_name.'</option>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Occupation: </label>
                                
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="patient_occupation" placeholder="Occupation" value="<?php echo $patient_occupation;?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Next of Kin Surname: </label>
                                
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="patient_kin_sname" placeholder="Kin Surname" value="<?php echo $patient_kin_sname;?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Next of Kin Other Names: </label>
                                
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="patient_kin_othernames" placeholder="Kin Other Names" value="<?php echo $patient_kin_sname;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Next of Kin Contact: </label>
                                
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="next_of_kin_contact" placeholder="" value="<?php echo $next_of_kin_contact;?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Relationship To Kin: </label>
                                
                                <div class="col-md-8">
                                    <select class="form-control" name="relationship_id">
                                        <?php
                                            if($relationships->num_rows() > 0)
                                            {
                                                $relationship = $relationships->result();
                                                
                                                foreach($relationship as $res)
                                                {
                                                    $db_relationship_id = $res->relationship_id;
                                                    $relationship_name = $res->relationship_name;
                                                    
                                                    if($db_relationship_id == $relationship_id)
                                                    {
                                                        echo '<option value="'.$db_relationship_id.'" selected>'.$relationship_name.'</option>';
                                                    }
                                                    
                                                    else
                                                    {
                                                        echo '<option value="'.$db_relationship_id.'">'.$relationship_name.'</option>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                         <!--    <div class="form-group">
                                <label class="col-md-4 control-label">Insurance : </label>
                                
                                <div class="col-md-8">
                                    <select class="form-control" name="insurance_company_id">
                                         <option value="0">Select an insurance Company</option>
                                        <?php
                                            if($insurance->num_rows() > 0)
                                            {
                                                $insurance = $insurance->result();
                                                
                                                foreach($insurance as $res)
                                                {
                                                    $insurance_company_id1 = $res->insurance_company_id;
                                                    $insurance_company_name = $res->insurance_company_name;
                                                    
                                                    if($insurance_company_id1 == $insurance_company_id)
                                                    {
                                                        echo '<option value="'.$insurance_company_id1.'" selected>'.$insurance_company_name.'</option>';
                                                    }
                                                    
                                                    else
                                                    {
                                                        echo '<option value="'.$insurance_company_id1.'">'.$insurance_company_name.'</option>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div> -->
                            
                        </div>
                    </div>
                <br/>
                <div class="center-align">
                    <button class="btn btn-info btn-sm" type="submit">Edit Patient</button>
                </div>
    <?php echo form_close();?>
              </div>
            </div>
            <!-- Widget ends -->

          </div>
        </div>
</section>