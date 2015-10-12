<?php

$rs2 = $this->nurse_model->get_visit_consultant_charges($visit_id);
$consultant = $this->nurse_model->get_visit_consultant($visit_id);

echo "
<table align='center' class='table table-striped table-hover table-condensed'>
	<tr>
		
		<th>Consultant</th>
		<th>Units</th>
		<th>Unit Cost</th>
		<th>Total</th>
		<th></th>
	</tr>		
";                     
		$total= 0;  
		if(count($rs2) >0){
			foreach ($rs2 as $key1):
				$visit_charge_id = $key1->visit_charge_id;
				$service_charge_id = $key1->service_charge_id;
				$visit_charge_amount = $key1->visit_charge_amount;
				$units = $key1->visit_charge_units;
				$procedure_name = $key1->service_charge_name;
				$service_id = $key1->service_id;
			
				$total= $total +($units * $visit_charge_amount);
				
				echo"
						<tr> 
							<td>Consultant fee - ".$consultant."</td>
							<td align='center'>
								<input class='form-control' type='text' id='consultation_charge_units".$visit_charge_id."' value='".$units."' size='3'/>
							</td>
							<td align='center'>".number_format($visit_charge_amount)."</td>
							<td align='center'><input type='text' class='form-control' readonly='readonly' size='5' value='".$units * $visit_charge_amount."' id='total".$visit_charge_id."'></div></td>
							<td>
							<a class='btn btn-sm btn-primary' href='#' onclick='calculateconsultationtotal(".$visit_charge_amount.",".$visit_charge_id.", ".$service_charge_id.",".$visit_id.")'><i class='fa fa-pencil'></i></a>
							</td>
						</tr>	
				";
				endforeach;

		}
echo"
<tr bgcolor='#D9EDF7'>
<td></td>
<td></td>
<th>Grand Total: </th>
<th colspan='3'><div id='grand_total'>".number_format($total)."</div></th>
</tr>
 </table>
";
?>