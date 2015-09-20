<div class="row">
	<div class="col-md-12">
		<!-- Widget -->
		<section class="panel">


			<!-- Widget head -->
			<header class="panel-heading">
				<h4 class="pull-left"><i class="icon-reorder"></i><?php echo $title;?></h4>
				<div class="clearfix"></div>
			</header>             

			<!-- Widget content -->
			<div class="panel-body">
				<?php 
				$validation_error = validation_errors();
				
				if(!empty($validation_error))
				{
					echo '<div class="alert alert-danger">'.$validation_error.'</div>';
				}
				echo form_open('nurse/search_procedures/'.$visit_id, array('class'=>'form-inline'));
				?>
				<div class="form-group">
					<?php
					$search = $this->session->userdata('procedure_search');
					if(!empty($search))
					{
					?>
					<a href="<?php echo site_url().'nurse/close_procedure_search/'.$visit_id;?>" class="btn btn-warning pull-right">Close Search</a>
					<?php }?>
					<input type="submit" class="btn btn-info pull-right" value="Search" name="search"/>
						
					<div class="input-group">
						<input type="text" class="form-control col-md-6" name="search_item" placeholder="Search for a procedure">
					</div>
				</div>
					
				<input type="hidden" value="<?php echo $visit_id?>" name="visit_id">
					
				<?php echo form_close();?>
				
				<table border="0" class="table table-hover table-condensed">
					<thead> 
						<th> </th>
						<th>Procedure</th>
						<th>Patient Type</th>
						<th>Cost</th>
					</thead>
		
					<?php 
					//echo "current - ".$current_item."end - ".$end_item;
					
					$rs9 = $query->result();
					foreach ($rs9 as $rs10) :
					
					
					$procedure_id = $rs10->service_charge_id;
					$proced = $rs10->service_charge_name;
					$visit_type = $rs10->visit_type_id;
					$visit_type_name = $rs10->visit_type_name;
					
					$stud = $rs10->service_charge_amount;
					
					?>
					<tr>
						<td></td>
						
						<td> <?php $suck=1; ?>                
						<a href="#" onClick="procedures(<?php echo $procedure_id?>,<?php echo $visit_id?>,<?php echo $suck; ?>)"><?php echo $proced?> </a></td>
						<td><?php echo $visit_type_name;?></td>
						<td><?php echo $stud?></td>
					</tr>
					<?php endforeach;?>
				</table>
          
            </div>
			<div class="widget-foot">
								
				<?php if(isset($links)){echo $links;}?>
			
				<div class="clearfix"></div> 
			
			</div>
		</section>
	</div>
</div>
<script type="text/javascript">
  
  function procedures(id, v_id, suck){
   
    var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
    var url = "<?php echo site_url();?>nurse/procedure/"+id+"/"+v_id+"/"+suck;
   
    if(XMLHttpRequestObject) {
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
                window.close(this);
                
                window.opener.document.getElementById("procedures").innerHTML=XMLHttpRequestObject.responseText;
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}
</script>
