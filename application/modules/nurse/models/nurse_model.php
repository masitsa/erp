<?php

class Nurse_model extends CI_Model 
{
	public function save_dental_vitals($visit_id)
	{
		$visit_major_reason= $this->input->post('reason');
		//$treatment= $this->input->post('treatment');
		$treatment_hospital= $this->input->post('hospital');
		$treatment_doctor=$this->input->post('doctor');
		$Food_allergies=$this->input->post('food_allergies');
		$Regular_treatment=$this->input->post('regular_treatment');
		$Recent_medication=$this->input->post('medication_description');
		$Medicine_allergies=$this->input->post('medicine_allergies');
		$prior_treatment=$this->input->post('prior_treatment');
		$alcohol=$this->input->post('alcohol');
		$smoke=$this->input->post('smoke');
		
		$women_pregnant=$this->input->post('preg');
		$pregnancy_month=$this->input->post('months');
		$serious_illness=$this->input->post('illness');
		$serious_illness_xplain=$this->input->post('illness_exp');
		$additional_infor=$this->input->post('additional');
		
		$data = array(
			'visit_id' => $visit_id,
			'visit_major_reason'=>$visit_major_reason,
			'serious_illness'=>$serious_illness,
			'serious_illness_xplain'=>$serious_illness_xplain,
			//'treatment'=>$treatment,
			'treatment_hospital'=>$treatment_hospital,
			'treatment_doctor'=>$treatment_doctor,
			'Food_allergies'=>$Food_allergies,
			'Regular_treatment'=>$Regular_treatment,
			'Recent_medication'=>$Recent_medication,
			'Medicine_allergies'=>$Medicine_allergies,
			/*'chest_trouble'=>$chest_trouble,
			'heart_problems'=>$heart_problems,
			'diabetic'=>$diabetic,
			'epileptic'=>$epileptic,
			'rheumatic_fever'=>$rheumatic_fever,
			'elongated_bleeding'=>$elongated_bleeding,
			'jaundice'=>$jaundice,
			'hepatitis'=>$hepatitis,
			'asthma'=>$asthma,
			'eczema'=>$eczema,
			'cancer'=>$cancer,*/
			'women_pregnant'=>$women_pregnant,
			'pregnancy_month'=>$pregnancy_month,
			'additional_infor'=>$additional_infor,
			'prior_treatment'=>$prior_treatment,
			'smoke'=>$smoke,
			'alcohol'=>$alcohol
		);
		
		if($this->db->insert('dental_vitals', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}

	public function select_current_dental_vitals($visit_id)
	{	
		$this->db->select('*');
		$this->db->where('visit_id', $visit_id);
		$query = $this->db->get('dental_vitals');
		
		return $query;	
	}
	
	public function update_dental_vitals($dental_vitals_id)
	{	
		$visit_major_reason= $this->input->post('reason');
		$treatment_hospital= $this->input->post('hospital');
		$treatment_doctor=$this->input->post('doctor');
		$Food_allergies=$this->input->post('food_allergies');
		$Regular_treatment=$this->input->post('regular_treatment');
		$Recent_medication=$this->input->post('medication_description');
		$Medicine_allergies=$this->input->post('medicine_allergies');
		$prior_treatment=$this->input->post('prior_treatment');
		$alcohol=$this->input->post('alcohol');
		$smoke=$this->input->post('smoke');
		$women_pregnant=$this->input->post('preg');
		$pregnancy_month=$this->input->post('months');
		$serious_illness=$this->input->post('illness');
		$serious_illness_xplain=$this->input->post('illness_exp');
		$additional_infor=$this->input->post('additional');
		
		$data = array(
			'visit_major_reason'=>$visit_major_reason,
			'serious_illness'=>$serious_illness,
			'serious_illness_xplain'=>$serious_illness_xplain,
			//'treatment'=>$treatment,
			'treatment_hospital'=>$treatment_hospital,
			'treatment_doctor'=>$treatment_doctor,
			'Food_allergies'=>$Food_allergies,
			'Regular_treatment'=>$Regular_treatment,
			'Recent_medication'=>$Recent_medication,
			'Medicine_allergies'=>$Medicine_allergies,
			/*'chest_trouble'=>$chest_trouble,
			'heart_problems'=>$heart_problems,
			'diabetic'=>$diabetic,
			'epileptic'=>$epileptic,
			'rheumatic_fever'=>$rheumatic_fever,
			'elongated_bleeding'=>$elongated_bleeding,
			'jaundice'=>$jaundice,
			'hepatitis'=>$hepatitis,
			'asthma'=>$asthma,
			'eczema'=>$eczema,
			'cancer'=>$cancer,*/
			'women_pregnant'=>$women_pregnant,
			'pregnancy_month'=>$pregnancy_month,
			'additional_infor'=>$additional_infor,
			'prior_treatment'=>$prior_treatment,
			'smoke'=>$smoke,
			'alcohol'=>$alcohol
		);
		
		$this->db->where('dental_vitals_id', $dental_vitals_id);
		if($this->db->update('dental_vitals', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function update_dental_visit($visit_id)
	{
		$data['dental_visit'] = 1;
		$data['nurse_visit'] = 1;
		
		$this->db->where('visit_id', $visit_id);
		if($this->db->update('visit', $data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function get_family_disease()
	{
		$this->db->select('*');
		$this->db->order_by('family_disease_name', 'ASC');
		$query = $this->db->get('family_disease');
		
		return $query;
	}
	
	public function get_family()
	{
		$this->db->select('*');
		$this->db->order_by('family_id', 'DESC');
		$query = $this->db->get('family');
		
		return $query;
	}
	
	public function get_family_history($family, $patient_id, $disease)
	{
		$this->db->select('*');
		$this->db->where(array('patient_id' => $patient_id, 'family_id' => $family, 'disease_id' => $disease));
		$query = $this->db->get('family_history_disease');
		
		return $query;
	}

	function get_visit_vitals($visit_id, $vitals_id){
		
		$table = "visit_vital";
		$where = "visit_id = '$visit_id' and vital_id = '$vitals_id'";
		$items = "*";
		$order = "visit_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}

	function vitals_range($vitals_id){
		
		$table = "vitals_range";
		$where = "vitals_id = '$vitals_id'";
		$items = "*";
		$order = "vitals_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}

	function get_previous_vitals($visit_id){
		

		// $table = "visit_vital, visit, patients, vitals";
		// $where = "visit_vital.vital_id = vitals.vitals_id 
		// AND visit_vital.visit_id = visit.visit_id 
		// AND visit.visit_id = $visit_id 
		// AND visit.patient_id = patients.patient_id
		// AND patients.patient_id = (SELECT patients.patient_id FROM patients, visit WHERE visit.visit_id = $visit_id AND visit.patient_id = patients.patient_id)
		// ";
		// $items = "visit_vital.visit_vital_value, vitals.vitals_name, visit.visit_id, visit.visit_date, visit_vital.vital_id";
		// $order = "visit_id";

		$table = "visit_vital, vitals,visit";
		$where = "visit_vital.vital_id = vitals.vitals_id 
		AND visit_vital.visit_id = visit.visit_id 
		AND visit_vital.visit_id = $visit_id 
		AND visit.patient_id = (SELECT patient_id FROM visit WHERE visit.visit_id = $visit_id)
		";
		$items = "visit_vital.visit_vital_value, vitals.vitals_name, visit_vital.visit_id, visit.visit_date, visit_vital.vital_id,visit_vital.visit_counter,visit_vital.visit_vitals_time,visit_vital.created_by";
		$order = "visit_vital.visit_counter";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}
	function get_distict_vitals($visit_id){

		$table = "visit_vital, vitals,visit";
		$where = "visit_vital.vital_id = vitals.vitals_id 
		AND visit_vital.visit_id = visit.visit_id 
		AND visit_vital.visit_id = $visit_id 
		AND visit.patient_id = (SELECT patient_id FROM visit WHERE visit.visit_id = $visit_id)
		";
		$items = "DISTINCT(visit_vital.visit_counter), visit_vital.visit_vitals_time,visit_vital.created_by";
		$order = "visit_vital.visit_counter";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}

	function get_vitals($id){
		$table = "visit_vital";
		$where = "visit_id = '$id'";
		$items = "*";
		$order = "vital_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	function check_visit_type($id){
		$table = "visit";
		$where = "visit_id = '$id'";
		$items = "visit_type, visit_id";
		$order = "visit_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}

	function visit_charge($visit_id){
		$table = "visit_charge";
		$where = "visit_charge.visit_charge_delete = 0 AND visit_charge.visit_id  = '$visit_id'";
		$items = "*";
		$order = "visit_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	function get_service_charge($procedure_id){
		$table = "service_charge, service";
		$where = "service_charge.service_id = service.service_id AND service_charge.service_charge_id = '$procedure_id'";
		$items = "service_charge.*, service.service_name";
		$order = "service_charge.service_charge_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}

	function search_procedures($order, $search,$visit_t){
		$table = "service_charge, service";
		$where = "service_charge_name LIKE '%$search%' AND service.service_id = 3 AND service_charge.service_id = service.service_id AND service_charge.visit_type_id = $visit_t";
		$items = "service_charge.service_charge_name, service_charge.visit_type_id,service_charge.service_charge_id , service_charge.service_charge_amount ";
		$order = "'$order'";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
	public function get_procedures($table, $where, $per_page, $page, $order)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order,'asc');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	public function get_other_procedures($table, $where, $order)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order,'asc');
		$query = $this->db->get('');
		
		return $query;
	}
	public function get_vaccines_list($table, $where, $per_page, $page, $order)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order,'asc');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	public function get_inpatient_consumable_list($table, $where, $order)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order,'asc');
		$query = $this->db->get('');
		
		return $query;
	}
	public function get_inpatient_vaccines_list($table, $where, $order)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order,'asc');
		$query = $this->db->get('');
		
		return $query;
	}


	function submitvisitprocedure($procedure_id,$visit_id,$suck)
	{//echo "purity";die();
		$visit_data = array(
			'procedure_id'=>$procedure_id,
			'visit_id'=>$visit_id,
			'units'=>$suck,
			'created'=>date('Y-m-d H:i:s'),
			'created_by'=>$this->session->userdata('personnel_id'),
			'modified_by'=>$this->session->userdata('personnel_id')
		);
		$this->db->insert('visit_procedure', $visit_data);
	}
	function submitvisitvaccine($vaccine_id,$visit_id,$suck){
		$visit_data = array('vaccine_id'=>$vaccine_id,'visit_id'=>$visit_id,'units'=>$suck,'created_by'=>$this->session->userdata("personnel_id"),'created'=>date("Y-m-d"));
		$this->db->insert('visit_vaccine', $visit_data);
	}
	public function submitvisitconsumable($consumable_id,$visit_id,$suck)
	{
		$visit_data = array('consumable_id'=>$consumable_id,'visit_id'=>$visit_id,'units'=>$suck,'created_by'=>$this->session->userdata("personnel_id"),'created'=>date("Y-m-d"));
		$this->db->insert('visit_consumable', $visit_data);
	}
	function get_visit_type($visit_id){
		$table = "visit";
		$where = "visit_id = '$visit_id'";
		$items = "visit_type, visit_id";
		$order = "visit_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}

	function visit_charge_insert($v_id,$procedure_id,$suck)
	{
		$service_charge_rs = $this->get_service_charge($procedure_id);

		foreach ($service_charge_rs as $key) :
			# code...
			$visit_charge_amount = $key->service_charge_amount;
		endforeach;

		$visit_data = array(
			'service_charge_id'=>$procedure_id,
			'visit_id'=>$v_id,
			'visit_charge_amount'=>$visit_charge_amount,
			'visit_charge_units'=>$suck,
			'created_by'=>$this->session->userdata("personnel_id"),
			'date'=>date("Y-m-d H:i:s")
		);//print_r($visit_data); die();
		$this->db->insert('visit_charge', $visit_data);
	}

	function get_visit_procedure_charges($v_id)
	{
		$table = "visit_charge, service_charge, service";
		$where = "visit_charge.visit_charge_delete = 0 AND visit_charge.visit_id = $v_id AND visit_charge.service_charge_id = service_charge.service_charge_id AND service.service_id = service_charge.service_id AND service.service_name = 'Procedures'";
		$items = "*";
		$order = "visit_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		return $result;
	}

	function get_visit_vaccine_charges($v_id)
	{
		$table = "visit_charge, service_charge, service";
		$where = "visit_charge.visit_charge_delete = 0 AND visit_charge.visit_id = $v_id AND visit_charge.service_charge_id = service_charge.service_charge_id AND service.service_id = service_charge.service_id AND service.service_name = 'Vaccination'";
		$items = "*";
		$order = "visit_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		return $result;
	}
	function get_visit_consumables_charges($v_id)
	{
		//check patient visit type
		$rs = $this->check_visit_type($v_id);
		if(count($rs)>0){
		  foreach ($rs as $rs1) {
			# code...
			  $visit_t = $rs1->visit_type;
		  }
		}

		$table = "visit_charge,service_charge,product,category";
		$where = 
				"service_charge.product_id = product.product_id
				AND service_charge.service_charge_id = visit_charge.service_charge_id
				AND category.category_id = product.category_id 
				AND category.category_name = 'Consumable'
				AND visit_charge.visit_charge_delete = 0 
				AND visit_charge.visit_id = $v_id 
				AND service_charge.visit_type_id = $visit_t";
		$items = "*";
		$order = "visit_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		return $result;
	}
	public function get_all_patient_history($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('visit.*,patients.*');
		$this->db->where($where);
		$this->db->order_by('visit_time','desc');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	public function get_patient_lifestyle($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('patient_id','desc');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	public function get_patient_id($visit_id){
		$table = "visit";
		$where = "visit_id = ". $visit_id;
		$items = "patient_id";
		$order = "visit_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		if(count($result) > 0){
			foreach ($result as $row2):
				 $patient_id = $row2->patient_id;
			endforeach;
		}
		return $patient_id;
	}

	public function waiting_time($visit_id)
	{
		
		$table = "visit";
		$where = "visit_id = ".$visit_id;
		$items = "visit_time, visit_time_out";
		$order = "visit_time";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		if(count($result) > 0){
			foreach ($result as $row2):
				$visit_time = $row2->visit_time;
				$visit_time_out = $row2->visit_time_out;
			endforeach;
		}
		
		if($visit_time_out == "0000-00-00 00:00:00"){
			$time1 = date('y-m-d  H:i:s');
		}
		else{
			$time1 = $visit_time_out;
		}
		
		$time_difference = $this->time_difference($time1, $visit_time);
		return $time_difference;
	}

	public function time_difference($higher_time, $lower_time)
	{
		$seconds = strtotime($higher_time) - strtotime($lower_time);
		$hours = $seconds/3600;
		$hours_rounded = intval(($seconds/3600));
		$minutes = ($hours - $hours_rounded) * 60;
		$minutes_rounded = intval($minutes);
		$ms = ($minutes - $minutes_rounded) * 60;
		$ms_rounded = intval($ms);
		return $hours_rounded.":".$minutes_rounded.":".$ms_rounded;
	}
	public function save_family_disease($family_id, $patient_id, $disease_id)
	{
		$data = array(
			'family_id'=>$family_id,
			'patient_id'=>$patient_id,
			'disease_id'=>$disease_id
		);
		
		if($this->db->insert('family_history_disease', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	public function delete_family_disease($family_id, $patient_id, $disease_id)
	{
		$data = array(
			'family_id'=>$family_id,
			'patient_id'=>$patient_id,
			'disease_id'=>$disease_id
		);
		$this->db->where($data);
		if($this->db->delete('family_history_disease'))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function get_exercices_values(){
		$table = "excersise";
		$where = "excersise_id > 0 ";
		$items = "*";
		$order = "excersise_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);

		return $result;
	}

	public function get_exercices_duration_values(){
		$table = "excersise_duration";
		$where = "excersise_duration_id > 0 ";
		$items = "*";
		$order = "excersise_duration_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);

		return $result;
	}

	public function get_sleep_values(){
		$table = "sleep";
		$where = "sleep_id > 0 ";
		$items = "*";
		$order = "sleep_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);

		return $result;
	}

	public function get_values($table_name,$primary_key){
		$table = "$table_name";
		$where = "$primary_key > 0 ";
		$items = "*";
		$order = "$primary_key";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);

		return $result;
	}

	public function submit_lifestyle_values($patient_id)
	{
		//delete previous entries
		$this->db->where('patient_id', $patient_id);
		if($this->db->delete('lifestyle'))
		{
			$excercise= $this->input->post('excercise');
			$excercise_duration= $this->input->post('excercise_duration');
			$sleep=$this->input->post('sleep');
			$meals=$this->input->post('meals');
			$coffee=$this->input->post('coffee');
			$housing=$this->input->post('housing');
			$education_id=$this->input->post('education');
			$drugs=$this->input->post('drugs');
			$diet=$this->input->post('diet');
			$alcohol_qty=$this->input->post('alcohol_qty');
			$alcohol_percentage=$this->input->post('alcohol_percentage');
			
			$data = array(
				'excersise_id'=>$excercise,
				'excersise_duration_id'=>$excercise_duration,
				'sleep_id'=>$sleep,
				'meals_id'=>$meals,
				'coffee_id'=>$coffee,
				'housing_id'=>$housing,
				'education_id'=>$education_id,
				'lifestyle_diet'=>$diet,
				'lifestyle_drugs'=>$drugs,
				'lifestyle_alcohol_percentage'=>$alcohol_percentage,
				'lifestyle_alcohol_quantity'=>$alcohol_qty,
				'patient_id'=>$patient_id
			);
			
			if($this->db->insert('lifestyle', $data))
			{
				return $this->db->insert_id();
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	
	public function get_patient_lifestyle2($visit_id)
	{
		$where = 'visit.patient_id = lifestyle.patient_id AND visit.visit_id = '.$visit_id;
		$this->db->select('lifestyle.*');
		$this->db->where($where);
		$query = $this->db->get('visit, lifestyle');
		
		return $query;
	}

	public function get_symptoms($visit_id){
		$table = "visit";
		$where = "visit_id = ".$visit_id;
		$items = "*";
		$order = "visit_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);

		return $result;
	}

	
	public function get_symptoms_visit($visit_id)
	{
		$this->db->where('visit_id', $visit_id);
		return $this->db->get('visit_symptoms');
	}

	public function get_visit_symptoms($visit_id){
		$table = "status, visit_symptoms, symptoms";
		$where = "visit_symptoms.visit_id = $visit_id AND visit_symptoms.symptoms_id = symptoms.symptoms_id AND visit_symptoms.status_id = status.status_id";
		$items = "visit_symptoms.description, symptoms.symptoms_name, status.status_name, visit_symptoms.visit_symptoms_id";
		$order = "symptoms.symptoms_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);

		return $result;
	}

	public function get_objective_findings($visit_id){
		$table = "visit";
		$where = "visit_id = ".$visit_id;
		$items = "visit_objective_findings";
		$order = "visit_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		return $result;
	}

	function get_visit_objective_findings($visit_id){

		$table = "objective_findings, objective_findings_class, visit_objective_findings";
		$where = "objective_findings_class.objective_findings_class_id = objective_findings.objective_findings_class_id 
		AND visit_objective_findings.`objective_findings_id` = objective_findings.objective_findings_id
		AND visit_objective_findings.visit_id = ".$visit_id;
		$items = "objective_findings.objective_findings_name, objective_findings_class.objective_findings_class_name, objective_findings.objective_findings_id, visit_objective_findings.visit_objective_findings_id,visit_objective_findings.description";
		$order = "objective_findings.objective_findings_name";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);

		return $result;
		
	
	}

	function get_assessment($visit_id){
		$table = "visit";
		$where = "visit_id = ".$visit_id;
		$items = "visit_assessment";
		$order = "visit_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		return $result;
	}

	function get_plan($visit_id){
		$table = "visit";
		$where = "visit_id = ".$visit_id;
		$items = "visit_plan";
		$order = "visit_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
	function get_diagnosis($visit_id){

		$table = "diagnosis, diseases";
		$where = "diagnosis.disease_id = diseases.diseases_id AND diagnosis.visit_id = ".$visit_id;
		$items = "diagnosis.diagnosis_id, diseases.diseases_name, diseases.diseases_code";
		$order = "diagnosis.disease_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		


	}

	function get_symptom_list($table, $where, $per_page, $page, $order){

		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order,'asc');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	function get_inpatient_symptom_list($table, $where, $order){

		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order,'asc');
		$query = $this->db->get('');
		
		return $query;
	}
	function update_visit_sypmtom($symptoms_id,$visit_id,$description)
	{
		$description = str_replace('%20', ' ',$description);
		$visit_data = array('description'=>$description);

		$this->db->where(array("symptoms_id"=>$symptoms_id,"visit_id"=>$visit_id));
		$this->db->update('visit_symptoms', $visit_data);
		
	}
	function save_visit_sypmtom($symptoms_id,$visit_id,$status)
	{
		//check if symptom has been saved
		$where = array(
			'visit_id'=>$visit_id,
			'symptoms_id'=>$symptoms_id
		);
		$this->db->where($where);
		$query = $this->db->get('visit_symptoms');
		
		//exists
		if($query->num_rows() > 0)
		{
			$this->db->where($where);
			if($this->db->delete('visit_symptoms'))
			{
				return TRUE;
			}
			
			else
			{
				return FALSE;
			}
		}
		
		else
		{
			$visit_data = array(
				'visit_id'=>$visit_id,
				'symptoms_id'=>$symptoms_id,
				'status_id'=>$status
			);
			
			if($this->db->insert('visit_symptoms', $visit_data))
			{
				return TRUE;
			}
			
			else
			{
				return FALSE;
			}
		}
	}

	function update_objective_finding($objective_finding_id, $visit_id, $description)
	{
		$description = str_replace('%20', ' ',$description);
		$visit_data = array('description'=>$description);

		$this->db->where(array("objective_findings_id"=>$objective_finding_id,"visit_id"=>$visit_id));
		if($this->db->update('visit_objective_findings', $visit_data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	function save_objective_finding($objective_finding_id, $visit_id)
	{
		$visit_data = array(
			'visit_id'=>$visit_id,
			'objective_findings_id'=>$objective_finding_id
		);
		$this->db->insert('visit_objective_findings', $visit_data);
	}
	
	function delete_objective_finding($objective_finding_id, $visit_id)
	{
		$visit_data = array(
			'visit_id'=>$visit_id,
			'objective_findings_id'=>$objective_finding_id
		);
		$this->db->where($visit_data);
		if($this->db->delete('visit_objective_findings'))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}

	public function get_diseases($table, $where, $per_page, $page, $order)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order,'asc');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	public function get_inpatient_diseases($table, $where, $order)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order,'asc');
		$query = $this->db->get('');
		
		return $query;
	}

	public function get_all_diseases($table, $order)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->order_by($order,'asc');
		$query = $this->db->get();
		
		return $query;
	}
	function get_doctor_notes($patient_id){
		$table = "doctor_patient_notes";
		$where = "patient_id = ".$patient_id;
		$items = "*";
		$order = "doctor_notes";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}
	function patient_illnes_notes($patient_id){
		$table = "patient_illness";
		$where = "patient_id = ".$patient_id;
		$items = "*";
		$order = "illness_notes";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}
	
	


	function get_nurse_notes($patient_id,$visit_id){
		// $table = "nurse_notes";
		// $where = "patient_id = ".$patient_id;
		// $items = "*";
		// $order = "note_id";
		
		$table = "nurse_patient_notes";
		$where = "visit_id = ".$visit_id." AND patient_id = ".$patient_id;
		$items = "*";
		$order = "nurse_notes_id";
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}
	function save_nurse_notes($nurse_notes, $patient_id){	
		$rs = $this->get_doctor_notes($patient_id);
		$num_doc_notes = count($rs);
		
		if($num_doc_notes == 0){	
			$visit_data = array('patient_id'=>$patient_id,'nurse_notes'=>$doctor_notes);
			$this->db->insert('nurse_notes', $visit_data);

		}
		else {
			$visit_data = array('patient_id'=>$patient_id,'nurse_notes'=>$doctor_notes);
			$this->db->where('patient_id',$patient_id);
			$this->db->update('nurse_notes', $visit_data);
		}
	}



	public function medical_exam_categories()
	{
		$query = $this->db->get('medical_exam_categories');
		
		return $query;
	}

	public function get_illness($visit_id, $mec_id)
	{
		$this->db->where('med_id = '.$mec_id.' AND visit_id = '.$visit_id);
		$query = $this->db->get('med_check_text_save');
		
		return $query;
	}
	
	function get_visit_charge($visit_id)
	{
		$this->db->select('visit_charge_amount, visit_charge_timestamp');
		$this->db->where('visit_id = '.$visit_id);
		$query = $this->db->get('visit_charge');
		
		return $query;
	}
	
	function get_credit_amount($visit_type_id)
	{
		$this->db->select('account_credit, Amount, efect_date');
		$this->db->where('visit_type_id = '.$visit_type_id);
		$query = $this->db->get('account_credit');
		
		return $query;
	}
	
	function get_visit_type_name($visit_type_id)
	{
		$this->db->select('visit_type_id,visit_type_name');
		$this->db->where('visit_type_id = '.$visit_type_id);
		$query = $this->db->get('visit_type');
		
		return $query;
	}
	
	function get_visit_payment($visit_id)
	{
		$this->db->select('amount_paid');
		$this->db->where('visit_id = '.$visit_id);
		$query = $this->db->get('payments');
		
		return $query;
	}
	
	function max_visit($p_id)
	{
		$this->db->select('MAX(visit_id)');
		$this->db->where('patient_id = '.$p_id);
		$query = $this->db->get('visit');
		
		return $query;
	}
	
	function min_visit($visit_id,$payment_method_id,$amount_paid)
	{
		$this->db->select('MIN(time), payment_id');
		$this->db->where('payment_method_id = '.$payment_method_id.' AND visit_id = '.$visit_id.' AND amount_paid = '.$amount_paid);
		$query = $this->db->get('payments');
		
		return $query;
	}
		
	function mec_med($mec_id)
	{
		$this->db->select('DISTINCT(item_format_id)');
		$this->db->where('mec_id = '.$mec_id);
		$query = $this->db->get('cat_items');
		
		return $query;
	}
		
	function format_id($item_format_id)
	{
		$this->db->where('item_format_id = '.$item_format_id);
		$query = $this->db->get('format');
		
		return $query;
	}
		
	function get_cat_items($item_format_id, $mec_id)
	{
		$this->db->select('cat_items.cat_item_name, cat_items.cat_items_id, cat_items.item_format_id, format.format_name, format.format_id');
		$this->db->where('cat_items.item_format_id = format.item_format_id AND cat_items.item_format_id = '.$item_format_id.' AND mec_id = '.$mec_id);
		$query = $this->db->get('cat_items, format');
		
		return $query;
	}
	
	function cat_items($item_format_id, $mec_id)
	{
		$this->db->select('cat_items.cat_item_name, cat_items.cat_items_id');
		$this->db->where('cat_items.item_format_id = '.$item_format_id.' AND mec_id = '.$mec_id);
		$query = $this->db->get('cat_items');
		
		return $query;
	}
	
	function cat_items2($cat_items_id,$format_id,$visit_id)
	{
		$this->db->where('cat_id = '.$cat_items_id.' AND format_id = '.$format_id.' AND visit_id = '.$visit_id);
		$query = $this->db->get('medical_checkup_results');
		
		return $query;
	}
	
	function check_text_save($mec_id, $visit_id)
	{			
		$this->db->where('med_id = '.$mec_id.' AND visit_id = '.$visit_id);
		$query = $this->db->get('med_check_text_save');
		
		return $query;
		
	}
	
	function save_illness($illness, $mec_id, $visit_id)
	{	
		$data['med_id'] = $mec_id;
		$data['infor'] = $illness;
		$data['visit_id'] = $visit_id;
		
		if($this->db->insert('med_check_text_save', $data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	function update_illness($illness, $result)
	{
		$mcts_id= $result->mcts_id;
		
		$data['infor'] = $illness;
		
		$this->db->where('mcts_id', $mcts_id);
		if($this->db->update('med_check_text_save', $data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	function save_medical_exam($cat_items_id, $format_id, $visit_id)
	{
		$data['cat_id'] = $cat_items_id;
		$data['format_id'] = $format_id;
		$data['visit_id'] = $visit_id;
		
		if($this->db->insert('medical_checkup_results', $data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	function delete_medical_exam($cat_items_id,$format_id,$visit_id)
	{
		$data['cat_id'] = $cat_items_id;
		$data['format_id'] = $format_id;
		$data['visit_id'] = $visit_id;
		$this->db->where($data);
		
		if($this->db->delete('medical_checkup_results'))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function get_queue_total($table, $where)
	{
		$total = $this->reception_model->count_items($table, $where);
		
		if($total > 0)
		{
			return $total;
		}
		
		else
		{
			return 0;
		}
	}
	function get_medicals($id){
		$table = "medication";
		$where = "patient_id = ".$id;
		$items = "*";
		$order = "patient_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	function get_surgeries($patient_id){
		$table = "surgery, month";
		$where = "surgery.month_id = month.month_id AND patient_id = '$patient_id'";
		$items = "*";
		$order = "patient_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	function get_vaccines(){
		$table = "vaccine";
		$where = "vaccine_id > 0";
		$items = "*";
		$order = "vaccine_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}
	function check_vaccine($patient_id, $patient_vaccine){
		$table = "patients_vaccine";
		$where = "patient_id = '". $patient_id ."' AND vaccine_id = ". $patient_vaccine;
		$items = "patient_vaccine_id, status_id ";
		$order = "vaccine_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;

		
	}

	function check_visit_counter($visit_id)
	{
		$table = "visit_vital";
		$where = "visit_id = '$visit_id'";
		$items = "MAX(visit_counter) AS visit_counter";
		$order = "visit_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		if(count($result) > 0)
		{
			foreach ($result as $key) :
				# code...
				$visit_counter = $key->visit_counter;

				if(!is_numeric($visit_counter))
				{
					$counter = 1;
				}
				else
				{
					$counter = $visit_counter + 1;
				}
			endforeach;
		}
		else
		{
			$counter = 1;
		}
		return $counter;

	}
	public function get_vaccine_list($table, $where, $per_page, $page, $order)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order,'asc');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	public function save_vaccine()
	{
		$array = array(
			'vaccine_name'=>$this->input->post('vaccine_name'),
			'quantity'=>$this->input->post('quantity'),
			'batch_no'=>$this->input->post('batch_no'),
			'vaccine_unitprice'=>$this->input->post('vaccine_unitprice'),
			'vaccine_packsize'=>$this->input->post('vaccine_pack_size'),
			'vaccine_dose'=>$this->input->post('drug_dose')
		);
		if($this->db->insert('vaccines', $array))
		{
			//calculate the price of the drug
			$vaccine_id = $this->db->insert_id();
			
			
			
			$service_data = array(
				'vaccine_id'=>$vaccine_id,
				'service_charge_amount'=>$this->input->post('vaccine_unitprice'),
				'service_id'=>15,
				'visit_type_id'=>0,
				'service_charge_status'=>1,
				'service_charge_name'=>$this->input->post('vaccine_name')
			);
			$this->db->insert('service_charge', $service_data);
			
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function edit_vaccine($vaccine_id)
	{
		$array = array(
			'vaccine_name'=>$this->input->post('vaccine_name'),
			'quantity'=>$this->input->post('quantity'),
			'batch_no'=>$this->input->post('batch_no'),
			'vaccine_unitprice'=>$this->input->post('vaccine_unitprice'),
			'vaccine_packsize'=>$this->input->post('vaccine_pack_size'),
			'vaccine_dose'=>$this->input->post('drug_dose')
		);
		
		$this->db->where('vaccine_id', $vaccine_id);
		if($this->db->update('vaccines', $array))
		{
			//edit service charge
			
			
			
			$service_data = array(
				'vaccine_id'=>$vaccine_id,
				'service_charge_amount'=>$this->input->post('vaccine_unitprice'),
				'service_id'=>15,
				'visit_type_id'=>0,
				'service_charge_status'=>1,
				'service_charge_name'=>$this->input->post('vaccine_name'),
			);
			//check if drug exists
			$where = array(
				'vaccine_id'=>$vaccine_id,
				'visit_type_id'=>0,
			);
			$this->db->where($where);
			$query2 = $this->db->get('service_charge');
			
			if($query2->num_rows() > 0)
			{
				$this->db->where($where);
				$this->db->update('service_charge', $service_data);
			}
			
			else
			{
				$this->db->insert('service_charge', $service_data);
			}
			
			$purchases_array = array(
			'expiry_date'=>$this->input->post('expiry_date')
			);
			$this->db->where('vaccine_id', $vaccine_id);
			if($this->db->update('vaccine_purchase', $purchases_array))
			{
				return TRUE;
			}else
			{
				return FALSE;
			}
		}
		else{
			return FALSE;
		}
	}
	public function get_vaccine_details($vaccine_id)
	{
		$this->db->where('vaccine_id', $vaccine_id);
		$query = $this->db->get('vaccines');
		
		return $query;
	}
	
	public function get_vaccine_purchase_details($vaccine_id)
	{
		$table = "vaccine_purchase";
		$where = "vaccine_id = '$vaccine_id'";
		$items = "*";
		$order = "vaccine_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	public function get_vaccine_purchases($table, $where, $per_page, $page, $order)
	{
		//retrieve all purchases
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order,'DESC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	public function purchase_vaccine($vaccine_id)
	{
		$array = array(
			'vaccine_id'=>$vaccine_id,
			'purchase_quantity'=>$this->input->post('purchase_quantity'),
			'purchase_pack_size'=>$this->input->post('purchase_pack_size'),
			'expiry_date'=>$this->input->post('expiry_date')
		);
		if($this->db->insert('vaccine_purchase', $array))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function edit_vaccine_purchase($purchase_id)
	{
		$array = array(
			'purchase_quantity'=>$this->input->post('purchase_quantity'),
			'purchase_pack_size'=>$this->input->post('purchase_pack_size'),
			'expiry_date'=>$this->input->post('expiry_date')
		);
		$this->db->where('purchase_id', $purchase_id);
		if($this->db->update('vaccine_purchase', $array))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function get_purchase_details($purchase_id)
	{
		$this->db->where('purchase_id', $purchase_id);
		$query = $this->db->get('vaccine_purchase');
		
		return $query;
	}
	
	public function get_ward_rooms($ward_id)
	{
		$where = 'ward.ward_id = room.ward_id AND ward.ward_id = '.$ward_id;
		$this->db->select('room.*');
		$this->db->where($where);
		$query = $this->db->get('ward, room');
		
		return $query;
	}
	
	public function get_room_beds($room_id)
	{
		$where = 'bed.room_id = room.room_id AND room.room_id = \''.$room_id.'\'';
		$this->db->select('bed.*');
		$this->db->where($where);
		$query = $this->db->get('bed, room');
		
		return $query;
	}
	
	public function get_visit_bed($visit_id)
	{
		$where = 'visit_bed.visit_bed_status = 1 AND visit_bed.bed_id = bed.bed_id AND bed.room_id = room.room_id AND visit_bed.visit_id = '.$visit_id;
		$this->db->select('bed.bed_number, bed.bed_id, room.room_id');
		$this->db->where($where);
		$query = $this->db->get('bed, room, visit_bed');
		
		return $query;
	}
	
	public function update_room_details($visit_id)
	{
		//unset all other assigned beds
		$this->db->where('visit_id', $visit_id);
		if($this->db->update('visit_bed', array('visit_bed_status' => 0)))
		{
			//add new bed
			$data = array(
				'bed_id' => $this->input->post('bed_id'),
				'visit_id' => $visit_id,
				'visit_bed_status' => 1,
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('personnel_id'),
				'modified_by'=>$this->session->userdata('personnel_id')
			);
			
			if($this->db->insert('visit_bed', $data))
			{
				return TRUE;
			}
			
			else
			{
				return FALSE;
			}
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function bill_bed($bed_id, $visit_id)
	{
		//unset all other assigned beds
		$this->db->where('bed_id', $bed_id);
		$query = $this->db->get('bed');
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$bed_name = $row->bed_number;
			
			$this->db->where('service.service_id = service_charge.service_id AND service_name = "Bed charge" AND service_charge_name = "'.$bed_name.'" AND service_charge.visit_type_id = (SELECT visit_type FROM visit WHERE visit_id = '.$visit_id.')');
			$query2 = $this->db->get('service, service_charge');
			$service_charge_amount = 0;
			
			if($query2->num_rows() > 0)
			{
				$row2 = $query2->row();
				$service_charge_amount = $row2->service_charge_amount;
				$service_charge_id = $row2->service_charge_id;
				
				//add new bed charge
				$data = array(
					'service_charge_id' => $service_charge_id,
					'visit_id' => $visit_id,
					'visit_charge_amount' => $service_charge_amount,
					'visit_charge_units' => 1,
					'created_by'=>$this->session->userdata("personnel_id"),
					'date'=>date("Y-m-d H:i:s")
				);
				
				if($this->db->insert('visit_charge', $data))
				{
					return TRUE;
				}
				
				else
				{
					return FALSE;
				}
			}
			
			else
			{
				return FALSE;
			}
		}
		
		else
		{
			return FALSE;
		}
	}

	function get_visit_bed_charges($v_id)
	{
		$table = "visit_charge, service_charge, service";
		$where = "visit_charge.visit_charge_delete = 0 AND visit_charge.visit_id = $v_id AND visit_charge.service_charge_id = service_charge.service_charge_id AND service.service_id = service_charge.service_id AND service.service_name = 'Bed charge'";
		$items = "*";
		$order = "visit_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		return $result;
	}

	function get_visit_consultant_charges($v_id)
	{
		$table = "visit_charge, service_charge, service, personnel";
		$where = "visit_charge.personnel_id = personnel.personnel_id AND visit_charge.visit_charge_delete = 0 AND visit_charge.visit_id = $v_id AND visit_charge.service_charge_id = service_charge.service_charge_id AND service.service_id = service_charge.service_id AND service.service_name = 'Doctor review'";
		$items = "*";
		$order = "visit_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		return $result;
	}

	function get_visit_consultant($v_id)
	{
		$table = "visit, personnel";
		$where = "visit.visit_id = $v_id AND visit.personnel_id = personnel.personnel_id";
		$items = "*";
		$order = "visit_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		$personnel = '';
		
		if(count($result) > 0)
		{
			$personnel = 'Dr. '.$result[0]->personnel_onames.' '.$result[0]->personnel_fname;
		}
		
		return $personnel;
	}
	
	public function get_consultants()
	{
		$this->db->where('personnel.personnel_id = personnel_job.personnel_id AND personnel_job.job_title_id = 12');
		$this->db->order_by('personnel.personnel_onames');
		$query = $this->db->get('personnel, personnel_job');
		
		return $query;
	}
	
	public function get_doctor_review_charges($visit_id)
	{
		$this->db->where('visit.visit_type = service_charge.visit_type_id AND service.service_id = service_charge.service_id AND service.service_name = \'Doctor review\' AND visit.visit_id = '.$visit_id);
		$query = $this->db->get('visit, service_charge, service');
		
		return $query;
	}
	
	public function add_consultant($visit_id)
	{
		$amount = 0;
		$service_charge_id = $this->input->post('service_charge_id');
		$personnel_id = $this->input->post('personnel_id');
		
		//get service charge amount
		$this->db->where('service_charge_id', $service_charge_id);
		$query = $this->db->get('service_charge');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$amount = $row->service_charge_amount;
		}
		
		$data = array(
			'service_charge_id' => $service_charge_id,
			'personnel_id' => $personnel_id,
			'visit_charge_qty' => 1,
			'visit_charge_units' => 1,
			'visit_charge_amount' => $amount,
			'visit_id' => $visit_id,
			'date' => date('Y-m-d'),
			'time' => date('H:i:s'),
			'created_by' => $this->session->userdata('personnel_id'),
			'modified_by' => $this->session->userdata('personnel_id')
		);
		
		if($this->db->insert('visit_charge', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function add_notes($visit_id, $notes_type_id, $signature_name, $personnel_id)
	{
		$notes=$this->input->post('notes');
		$date=$this->input->post('date');
		$time=$this->input->post('time');

		//  enter into the nurse notes trail 
		$trail_data = array(
        		"notes_type_id" => $notes_type_id,
        		"visit_id" => $visit_id,
        		"notes_name" => $notes,
        		"notes_time" => $time,
        		"notes_date" => $date,
        		"notes_signature" => $signature_name,
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$personnel_id,
				'modified_by'=>$personnel_id
	    	);

		if($this->db->insert('notes', $trail_data))
		{
			return $this->db->insert_id();
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function update_notes($notes_id, $signature_name, $personnel_id)
	{
		$notes=$this->input->post('notes');
		$date=$this->input->post('date');
		$time=$this->input->post('time');

		//  enter into the nurse notes trail 
		$trail_data = array(
        		"notes_name" => $notes,
        		/*"notes_time" => $time,
        		"notes_date" => $date,*/
				'modified_by'=>$personnel_id
	    	);
		$this->db->where('notes_id', $notes_id);
		if($this->db->update('notes', $trail_data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function edit_notes($visit_id, $notes_type_id, $notes_id, $personnel_id)
	{
		$notes=$this->input->post('nurse_notes');
		$date=$this->input->post('date');
		$time=$this->input->post('time');

		//  enter into the nurse notes trail 
		$trail_data = array(
        		"notes_name" => $notes,
        		"notes_time" => $time,
        		"notes_date" => $date,
				'modified_by'=>$personnel_id
	    	);
		
		$this->db->where('notes_id', $notes_id);
		if($this->db->update('notes', $trail_data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function get_notes($notes_type_id, $visit_id)
	{
		$this->db->select('notes.*, notes_type.notes_type_name, personnel.personnel_fname');
		$this->db->where('notes.visit_id = '.$visit_id.' AND notes.notes_type_id = '.$notes_type_id.' AND notes.notes_status = 1 AND notes.notes_type_id = notes_type.notes_type_id');
		$this->db->join('personnel', 'personnel.personnel_id = notes.created_by', 'left');
		$this->db->order_by('notes_date', 'ASC');
		$this->db->order_by('notes_time', 'ASC');
		$query = $this->db->get('notes, notes_type');
		
		return $query;
	}
	
	public function delete_notes($notes_id, $personnel_id)
	{
		$data['notes_status'] = 0;
		$data['modified_by'] = $personnel_id;
		$this->db->where('notes_id', $notes_id);
		if($this->db->update('notes', $data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
}
?>
