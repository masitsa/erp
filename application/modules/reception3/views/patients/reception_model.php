<?php

class Reception_model extends CI_Model 
{
	/*
	*	Count all items from a table
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function count_items($table, $where, $limit = NULL)
	{
		if($limit != NULL)
		{
			$this->db->limit($limit);
		}
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->count_all_results();
	}
	
	/*
	*	Retrieve all patients
	*	@param string $table
	* 	@param string $where
	*	@param int $per_page
	* 	@param int $page
	*
	*/
	public function get_all_patients($table, $where, $per_page, $page, $items = '*')
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select($items);
		$this->db->where($where);
		$this->db->order_by('patient_date','desc');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Retrieve ongoing visits
	*	@param string $table
	* 	@param string $where
	*	@param int $per_page
	* 	@param int $page
	*
	*/
	public function get_all_ongoing_visits($table, $where, $per_page, $page, $order = NULL)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('visit.*, visit_department.created AS visit_created, patients.gender_id, patients.patient_date_of_birth, patients.visit_type_id, patients.patient_othernames, patients.patient_surname, patients.dependant_id, patients.strath_no,patients.patient_national_id,visit_type.visit_type_name');
		$this->db->where($where);
		$this->db->order_by('visit_department.created','ASC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	public function get_all_ongoing_visits2($table, $where, $per_page, $page, $order = NULL)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('visit.*, patients.visit_type_id, patients.gender_id, patients.patient_othernames, patients.patient_date_of_birth, patients.patient_surname, patients.dependant_id, patients.strath_no,patients.patient_national_id');
		$this->db->where($where);
		$this->db->order_by('visit.visit_date','ASC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	/*
	*	Retrieve a single dependant
	*	@param int $strath_no
	*
	*/
	public function get_dependant($strath_no)
	{
		$this->db->from('staff_dependants');
		$this->db->select('*');
		$this->db->where('staff_dependants_id = \''.$strath_no.'\'');
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_dependant_patient($strath_no)
	{
		$this->db->from('patients');
		$this->db->select('*');
		$this->db->where('patients.visit_type_id = 2 AND patients.dependant_id IS NOT NULL AND patients.dependant_id = patients.strath_no  AND patients.patient_delete = 0
 AND patients.dependant_id = \''.$strath_no.'\'');
		$query = $this->db->get();
		
		return $query;
	}
	/*
	*	Retrieve a single staff
	*	@param int $strath_no
	*
	*/
	public function get_staff_new($strath_no)
	{
		// $this->db->from('staff');
		$this->db->from('patients');
		$this->db->select('*');
		$this->db->where('strath_no = \''.$strath_no.'\'');
		$query = $this->db->get();
		
		return $query;
	}

	/*
	*	Retrieve a single staff
	*	@param int $strath_no
	*
	*/
	public function get_staff($strath_no)
	{
		$this->db->from('staff');
		// $this->db->from('patients');
		$this->db->select('*');
		$this->db->where('Staff_Number = \''.$strath_no.'\'');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Retrieve a single staff
	*	@param int $strath_no
	*
	*/
	public function get_patient_staff($strath_no)
	{
		$this->db->from('patients');
		$this->db->select('*');
		$this->db->where('patients.visit_type_id = 2 AND patients.patient_delete = 0 AND strath_no = \''.$strath_no.'\'');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Retrieve a single staff
	*	@param int $strath_no
	*
	*/
	public function get_patient_student($strath_no)
	{
		$this->db->from('patients');
		$this->db->select('*');
		$this->db->where('patients.visit_type_id = 1 AND patients.patient_delete = 0 AND strath_no = \''.$strath_no.'\'');
		$query = $this->db->get();
		
		return $query;
	}
	/*
	*	Retrieve a insert patient information
	*	@param int $strath_no
	*
	*/
	public function insert_into_patients($strath_no, $visit_type)
	{
		//get patients data
		$patient_data = $this->get_strath_patient_data($visit_type, $visit_id = NULL, $strath_no, $row = NULL, $dependant_id = NULL, $visit_type, $patient_id = NULL);
		
		//$visit_type = $patient_data['visit_type'];
		$patient_type = $patient_data['patient_type'];
		$patient_othernames = $patient_data['patient_othernames'];
		$patient_surname = $patient_data['patient_surname'];
		$patient_date_of_birth = $patient_data['patient_date_of_birth'];
		$gender = $patient_data['gender'];
		$gender_id = $patient_data['gender_id'];
		$faculty = $patient_data['faculty'];
		$contact = '';//$patient_data['contact'];
		
		//  instert data into the patients table
		$date = date("Y-m-d H:i:s");
		$patient_data = array(
			'patient_number'=>$this->strathmore_population->create_patient_number(),
			'patient_date'=>$date,
			'visit_type_id'=>$visit_type,
			'strath_no'=>$strath_no,
			'created_by'=>$this->session->userdata('personnel_id'),
			'modified_by'=>$this->session->userdata('personnel_id'),
			'patient_surname'=>ucwords(strtolower($patient_surname)),
			'patient_othernames'=>ucwords(strtolower($patient_othernames)),
			'patient_date_of_birth'=>$patient_date_of_birth,
			'patient_phone1'=>$contact,
			'gender_id'=>$gender_id,
		);
		$this->db->insert('patients', $patient_data);
		//var_dump($patient_data);die();
		return $this->db->insert_id();
	}
	public function get_student_new($strath_no)
	{
		$this->db->from('student');
		//$this->db->from('patients');
		$this->db->select('*');
		//$this->db->where('strath_no = \''.$strath_no.'\'');
		$this->db->where('student_Number = \''.$strath_no.'\'');
		$query = $this->db->get();
		
		return $query;
	}
	/*
	*	Retrieve a single student
	*	@param int $strath_no
	*
	*/
	public function get_student($strath_no)
	{
		$this->db->from('student');
		// $this->db->from('patients');
		$this->db->select('*');
		$this->db->where('student_Number = \''.$strath_no.'\'');
		$query = $this->db->get();
		
		return $query;
	}
	
	
	
	/*
	*	Retrieve gender
	*
	*/
	public function get_gender()
	{
		$this->db->order_by('gender_name');
		$query = $this->db->get('gender');
		
		return $query;
	}
	
	/*
	*	Retrieve title
	*
	*/
	public function get_title()
	{
		$this->db->order_by('title_name');
		$query = $this->db->get('title');
		
		return $query;
	}
	
	/*
	*	Retrieve civil_status
	*
	*/
	public function get_civil_status()
	{
		$this->db->order_by('civil_status_name');
		$query = $this->db->get('civil_status');
		
		return $query;
	}
	
	/*
	*	Retrieve religion
	*
	*/
	public function get_religion()
	{
		$this->db->order_by('religion_name');
		$query = $this->db->get('religion');
		
		return $query;
	}
	
	/*
	*	Retrieve relationship
	*
	*/
	public function get_relationship()
	{
		$this->db->order_by('relationship_name');
		$query = $this->db->get('relationship');
		
		return $query;
	}
	
	/*
	*	Save other patient
	*
	*/
	public function save_other_patient()
	{
		$data = array(
			'patient_surname'=>ucwords(strtolower($this->input->post('patient_surname'))),
			'patient_othernames'=>ucwords(strtolower($this->input->post('patient_othernames'))),
			'title_id'=>$this->input->post('title_id'),
			'patient_date_of_birth'=>$this->input->post('patient_dob'),
			'gender_id'=>$this->input->post('gender_id'),
			'religion_id'=>$this->input->post('religion_id'),
			'civil_status_id'=>$this->input->post('civil_status_id'),
			'patient_email'=>$this->input->post('patient_email'),
			'patient_address'=>$this->input->post('patient_address'),
			'patient_postalcode'=>$this->input->post('patient_postalcode'),
			'patient_town'=>$this->input->post('patient_town'),
			'patient_phone1'=>$this->input->post('patient_phone1'),
			'patient_phone2'=>$this->input->post('patient_phone2'),
			'patient_kin_sname'=>$this->input->post('patient_kin_sname'),
			'patient_kin_othernames'=>$this->input->post('patient_kin_othernames'),
			'relationship_id'=>$this->input->post('relationship_id'),
			'patient_national_id'=>$this->input->post('patient_national_id'),
			'patient_date'=>date('Y-m-d H:i:s'),
			'patient_number'=>$this->strathmore_population->create_patient_number(),
			'created_by'=>$this->session->userdata('personnel_id'),
			'modified_by'=>$this->session->userdata('personnel_id'),
			'visit_type_id'=>3,
			'dependant_id'=>$this->input->post('dependant_id'),
			'patient_kin_phonenumber1'=>$this->input->post('next_of_kin_contact')
		);
		
		if($this->db->insert('patients', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Edit other patient
	*
	*/
	public function edit_other_patient($patient_id)
	{
		$data = array(
			'patient_surname'=>ucwords(strtolower($this->input->post('patient_surname'))),
			'patient_othernames'=>ucwords(strtolower($this->input->post('patient_othernames'))),
			'title_id'=>$this->input->post('title_id'),
			'patient_date_of_birth'=>$this->input->post('patient_dob'),
			'gender_id'=>$this->input->post('gender_id'),
			'religion_id'=>$this->input->post('religion_id'),
			'civil_status_id'=>$this->input->post('civil_status_id'),
			'patient_email'=>$this->input->post('patient_email'),
			'patient_address'=>$this->input->post('patient_address'),
			'patient_postalcode'=>$this->input->post('patient_postalcode'),
			'patient_town'=>$this->input->post('patient_town'),
			'patient_phone1'=>$this->input->post('patient_phone1'),
			'patient_phone2'=>$this->input->post('patient_phone2'),
			'patient_kin_sname'=>$this->input->post('patient_kin_sname'),
			'patient_kin_othernames'=>$this->input->post('patient_kin_othernames'),
			'relationship_id'=>$this->input->post('relationship_id'),
			'patient_national_id'=>$this->input->post('patient_national_id'),
			'modified_by'=>$this->session->userdata('personnel_id'),
			'patient_kin_phonenumber1'=>$this->input->post('next_of_kin_contact')
		);
		
		$this->db->where('patient_id', $patient_id);
		if($this->db->update('patients', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	/*
	*	Edit other patient
	*
	*/
	public function edit_staff_patient($patient_id)
	{
		$data = array(
			'patient_phone1'=>$this->input->post('phone_number'),
			'patient_phone2'=>$this->input->post('patient_phone2')
		);
		
		$this->db->where('patient_id', $patient_id);
		if($this->db->update('patients', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function edit_student_patient($patient_id)
	{
		$data = array(
			'patient_phone1'=>$this->input->post('phone_number'),
			'patient_phone2'=>$this->input->post('patient_phone2')
		);
		
		$this->db->where('patient_id', $patient_id);
		if($this->db->update('patients', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	 
	function edit_staff_dependant_patient($patient_id)
	{
		$data = array(
			'patient_surname'=>ucwords(strtolower($this->input->post('patient_surname'))),
			'patient_othernames'=>ucwords(strtolower($this->input->post('patient_othernames'))),
			'title_id'=>$this->input->post('title_id'),
			'patient_date_of_birth'=>$this->input->post('patient_dob'),
			'gender_id'=>$this->input->post('gender_id'),
			'religion_id'=>$this->input->post('religion_id'),
			'civil_status_id'=>$this->input->post('civil_status_id'),
			'relationship_id'=>$this->input->post('relationship_id'),
			'modified_by'=>$this->session->userdata('personnel_id')
		);
		
		$this->db->where('patient_id', $patient_id);
		if($this->db->update('patients', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Save dependant patient
	*
	*/
	public function save_dependant_patient($dependant_staff)
	{
		$this->db->select('staff_system_id');
		$this->db->where('Staff_Number', $dependant_staff);
		$query = $this->db->get('staff');
		
		if($query->num_rows() > 0)
		{
			$res = $query->row();
			$staff_system_id = $res->staff_system_id;
			// $data = array(
			// 	'surname'=>ucwords(strtolower($this->input->post('patient_surname'))),
			// 	'other_names'=>ucwords(strtolower($this->input->post('patient_othernames'))),
			// 	'title_id'=>$this->input->post('title_id'),
			// 	'DOB'=>$this->input->post('patient_dob'),
			// 	'gender_id'=>$this->input->post('gender_id'),
			// 	'religion_id'=>$this->input->post('religion_id'),
			// 	'staff_id'=>$staff_system_id,
			// 	'civil_status_id'=>$this->input->post('civil_status_id')
			// );
			// $this->db->insert('staff_dependants', $data);
			
			$data2 = array(
				'patient_surname'=>ucwords(strtolower($this->input->post('patient_surname'))),
				'patient_othernames'=>ucwords(strtolower($this->input->post('patient_othernames'))),
				'title_id'=>$this->input->post('title_id'),
				'patient_date_of_birth'=>$this->input->post('patient_dob'),
				'gender_id'=>$this->input->post('gender_id'),
				'dependant_id'=>$dependant_staff,
				'visit_type_id'=>2,
				'relationship_id'=>$this->input->post('relationship_id'),
				'patient_date'=>date('Y-m-d H:i:s'),
				'patient_number'=>$this->strathmore_population->create_patient_number(),
				'created_by'=>$this->session->userdata('personnel_id'),
				'modified_by'=>$this->session->userdata('personnel_id')
			);
			
			if($this->db->insert('patients', $data2))
			{
				return $this->db->insert_id();
			}
			else{
				return FALSE;
			}
		}
		
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Save dependant patient
	*
	*/
	public function save_other_dependant_patient($patient_id)
	{
		$data = array(
			'visit_type_id'=>3,
			'patient_surname'=>ucwords(strtolower($this->input->post('patient_surname'))),
			'patient_othernames'=>ucwords(strtolower($this->input->post('patient_othernames'))),
			'title_id'=>$this->input->post('title_id'),
			'patient_date_of_birth'=>$this->input->post('patient_dob'),
			'gender_id'=>$this->input->post('gender_id'),
			'religion_id'=>$this->input->post('religion_id'),
			'civil_status_id'=>$this->input->post('civil_status_id'),
			'relationship_id'=>$this->input->post('relationship_id'),
			'patient_date'=>date('Y-m-d H:i:s'),
			'patient_number'=>$this->strathmore_population->create_patient_number(),
			'created_by'=>$this->session->userdata('personnel_id'),
			'modified_by'=>$this->session->userdata('personnel_id'),
			'dependant_id'=>$patient_id
		);
		
		if($this->db->insert('patients', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	
	public function get_service_charges($patient_id)
	{
		$table = "service_charge";
		$where = "service_charge.service_id = 1 AND service_charge.visit_type_id = (SELECT visit_type_id FROM patients WHERE patient_id = $patient_id)";
		$items = "service_charge.service_charge_name, service_charge_id";
		$order = "service_charge_name";
		
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	public function get_service_charge($id)
	{
		$table = "service_charge";
		$where = "service_charge_id = $id";
		$items = "service_charge_amount AS number";
		$order = "service_charge_amount";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		foreach ($result as $rs1):
			$visit_type2 = $rs1->number;
		endforeach;
		return $visit_type2;
	}
	public function save_consultation_charge($visit_id, $service_charge_id, $service_charge)
	{
		$insert = array(
        	"visit_id" => $visit_id,
        	"service_charge_id" => $service_charge_id,
        	"visit_charge_amount" => $service_charge
    	);
		$table = "visit_charge";
		$this->load->model('database', '',TRUE);
		$this->database->insert_entry($table, $insert);
		
		return TRUE;
	}
	public function get_doctor()
	{
		$table = "personnel, job_title";
		$where = "job_title.job_title_id = personnel.job_title_id AND job_title.job_title_id = 2";
		$items = "personnel.personnel_onames, personnel.personnel_fname, personnel.personnel_id";
		$order = "personnel_onames";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}	
	public function get_personnel_details($personnel_id)
	{
		$table = "personnel, job_title";
		$where = "job_title.job_title_id = personnel.job_title_id AND  personnel.personnel_id = '$personnel_id'";
		$items = "personnel.personnel_onames, personnel.personnel_fname, personnel.personnel_id";
		$order = "personnel_onames";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}	
	public function get_types()
	{
		$table = "visit_type";
		$where = "visit_type_id > 0";
		$items = "visit_type_name, visit_type_id";
		$order = "visit_type_name";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
	public function patient_names2($patient_id, $visit_id = NULL)
	{
		// var_dump($visit_id); die();
		if($visit_id == NULL)
		{
			$table = "patients";
			$where = "patient_id = ".$patient_id;
			$items = "*";
			$order = "patient_date";
		}
		
		else
		{
			$table = "patients, visit";
			$where = "patients.patient_id = visit.patient_id AND visit.visit_id = ".$visit_id;
			$items = "patients.*, visit.visit_type,visit.close_card";
			$order = "patient_date";
		}

		$this->db->select($items);
		$this->db->where($where);
		$this->db->order_by($order, 'DESC');
		$result = $this->db->get($table);
		
		foreach ($result->result() as $row)
		{
			$patient_id = $row->patient_id;
			$dependant_id = $row->dependant_id;
			$patient_number = $row->patient_number;
			$dependant_id = $row->dependant_id;
			$strath_no = $row->strath_no;
			$created_by = $row->created_by;
			$modified_by = $row->modified_by;
			$visit_type_id = $row->visit_type_id;
			$created = $row->patient_date;
			$last_modified = $row->last_modified;
			$last_visit = $row->last_visit;
			$close_card = 0;
			
			if($visit_id != NULL)
			{
				$close_card = $row->close_card;
				$visit_type = $row->visit_type;
				$check_id = $visit_type;
				
				//a student being charged as an outsider
				if(($visit_type == 3) && ($visit_type_id == 1))
				{
					$check_id = $visit_type_id;
					$visit_type = 0;
				}
				
				//staff being charged as an outsider
				if(($visit_type == 3) && ($visit_type_id == 2))
				{
					$check_id = $visit_type_id;
					$visit_type = 0;
				}
			}
			
			else
			{
				$check_id = $visit_type_id;
				$visit_type = 0;
			}
			
			if($check_id < 3 && $dependant_id != NULL)
			{
				$patient_data = $this->get_strath_patient_data($check_id, $visit_id, $strath_no, $row, $dependant_id, $visit_type_id, $patient_id);
				$visit_type = $patient_data['visit_type'];
				$patient_type = $patient_data['patient_type'];
				$patient_othernames = $patient_data['patient_othernames'];
				$patient_surname = $patient_data['patient_surname'];
				$patient_date_of_birth = $patient_data['patient_date_of_birth'];
				$gender = $patient_data['gender'];
				$faculty = $patient_data['faculty'];
			}
			
			//other patient
			else
			{
				$patient_type = $this->reception_model->get_patient_type($visit_type_id);
				
				if($visit_type == 3)
				{
					$visit_type = 'Other';
				}
				else if($visit_type == 2)
				{
					$visit_type = 'Staff';
				}
				else if($visit_type == 1)
				{
					$visit_type = 'Student';
				}
				else if($visit_type == 4)
				{
					$visit_type = 'Insurance';
				}
				else
				{
					$visit_type = 'General';
				}
				
				$patient_othernames = $row->patient_othernames;
				$patient_surname = $row->patient_surname;
				$patient_date_of_birth = $row->patient_date_of_birth;
				$gender_id = $row->gender_id;
				$faculty ='';
				if($gender_id == 1)
				{
					$gender = 'M';
				}
				else
				{
					$gender = 'F';
				}
					
				if(($patient_surname == '0.00') && ($patient_othernames == '0.00'))
				{
					$patient_data = $this->get_strath_patient_data($visit_type_id, $visit_id, $strath_no, $row, $dependant_id, $visit_type_id, $patient_id);
					$patient_othernames = $patient_data['patient_othernames'];
					$patient_surname = $patient_data['patient_surname'];
					$patient_date_of_birth = $patient_data['patient_date_of_birth'];
					$gender = $patient_data['gender'];
					$faculty = $patient_data['faculty'];

				}
				
			}
		}

		// calculate patient balance
		$this->load->model('administration/administration_model');

		$account_balance = $this->administration_model->patient_account_balance($patient_id);

		// end of patient balance

		$patient['patient_id'] = $patient_id;
		$patient['account_balance'] = $account_balance;
		$patient['visit_type'] = $visit_type;
		$patient['visit_type_name'] = $visit_type;
		$patient['patient_type'] = $patient_type;
		$patient['visit_type_id'] = $check_id;
		$patient['patient_othernames'] = $patient_othernames;
		$patient['patient_surname'] = $patient_surname;
		$patient['patient_date_of_birth'] = $patient_date_of_birth;
		$patient['gender'] = $gender;
		$patient['patient_number'] = $patient_number;
		$patient['faculty'] = $faculty;
		$patient['close_card'] = $close_card;
		$patient['staff_dependant_no'] = $dependant_id;

		return $patient;
	}
	//  function place to change 
	public function get_strath_patient_data($check_id, $visit_id, $strath_no, $row, $dependant_id = NULL, $visit_type_id, $patient_id)
	{
		$patient_surname = '';
		$patient_othernames = '';
		$patient_date_of_birth = '';
		$faculty = '';
		$patient_phone1 = '';//$student_result->patient_phone1;
		$gender = 0;
		
		//staff & dependant
		if($check_id == 2)
		{
			//dependant
			if($dependant_id != 0)
			{
				$patient_type = $this->reception_model->get_patient_type($visit_type_id, $dependant_id);
				$visit_type = 'Dependant';

				$dependant_query = $this->reception_model->get_dependant($strath_no);

				if($dependant_query->num_rows() > 0)
				{
					$dependants_result = $dependant_query->row();

					$patient_othernames = $dependants_result->other_names;
					$patient_surname = $dependants_result->surname;
					$patient_date_of_birth = $dependants_result->DOB;
					$relationship = $dependants_result->relation;
					$gender = $dependants_result->Gender;
					$faculty = $this->get_staff_faculty_details($dependant_id);
				}

				else if(($row->patient_surname != '0.00') && ($row->patient_othernames != '0.00'))
				{
					$patient_othernames = $row->patient_othernames;
					$patient_surname = $row->patient_surname;
					$patient_date_of_birth = $row->patient_date_of_birth;
					$gender_id = $row->gender_id;
					// get parent faculty 
					$faculty = $this->get_staff_faculty_details($dependant_id);
					// end of parent faculty
					if($gender_id == 1)
					{
						$gender = 'M';
					}
					else
					{
						$gender = 'F';
					}
				}

				else
				{
					$patient_othernames = '<span class="label label-important">Dependant not found: '.$strath_no.'</span>';
					$patient_surname = $patient_id;
					$patient_date_of_birth = '';
					$relationship = '';
					$gender = '';
					$faculty ='';
				}
			}

			//staff
			else
			{
				$patient_type = $this->reception_model->get_patient_type($visit_type_id, $dependant_id);
				$visit_type = 'Staff';
				
				$staff_query = $this->reception_model->get_staff($strath_no);

				if($staff_query->num_rows() > 0)
				{
					$staff_result = $staff_query->row();

					$patient_surname = $staff_result->Surname;
					$patient_othernames = $staff_result->Other_names;
					$patient_date_of_birth = $staff_result->DOB;
					$patient_phone1 = '';//$staff_result->patient_phone1;
					$gender = $staff_result->gender;
					$faculty = $staff_result->department;
				}

				else if(($row->patient_surname != '0.00') && ($row->patient_othernames != '0.00'))
				{
					$patient_othernames = $row->patient_othernames;
					$patient_surname = $row->patient_surname;
					$patient_date_of_birth = $row->patient_date_of_birth;
					$gender_id = $row->gender_id;
					$faculty = '';
					if($gender_id == 1)
					{
					$gender = 'M';
					}
					else
					{
					$gender = 'F';
					}
				}

				else
				{
					$patient_othernames = '<span class="label label-important">Staff not found: '.$strath_no.'</span>';
					$patient_surname = '';
					$patient_date_of_birth = '';
					$relationship = '';
					$gender = '';
					$patient_type = '';
					$faculty ='';
				}
			}
			
		}

		//student
		else if($check_id == 1)
		{
			$patient_type = $this->reception_model->get_patient_type($visit_type_id);
			$visit_type = 'Student';
			$student_query = $this->reception_model->get_student_new($strath_no);

			if($student_query->num_rows() > 0)
			{
				$student_result = $student_query->row();
				$patient_surname = $student_result->Surname;
				$patient_othernames = $student_result->Other_names;
				$patient_date_of_birth = date('Y-m-d',strtotime($student_result->DOB));
				$patient_phone1 = '';//$student_result->patient_phone1;
				$gender = $student_result->gender;
				$faculty = $student_result->faculty;
			}
		}

		else
		{
			$visit_type = $check_id;
			$patient_type = 'Other';
			$patient_othernames = $row->patient_othernames;
			$patient_surname = $row->patient_surname;
			$patient_date_of_birth = $row->patient_date_of_birth;
			$gender_id = $row->gender_id;
			$faculty = '';
			if($gender_id == 1)
			{
				$gender = 'M';
			}
			else
			{
				$gender = 'F';
			}
		}

		if(($gender == 'M') || ($gender == 'Male'))
		{
			$gender_id = 1;
		}
		else if(($gender == 'F') || ($gender == 'Female'))
		{
			$gender_id = 2;
		}
		else
		{
			$gender_id = 0;
		}

		$patient['visit_type'] = $visit_type;
		$patient['patient_type'] = $patient_type;
		$patient['patient_othernames'] = $patient_othernames;
		$patient['patient_surname'] = $patient_surname;
		$patient['patient_date_of_birth'] = $patient_date_of_birth;
		$patient['gender'] = $gender;
		$patient['faculty'] = $faculty;
		$patient['gender_id'] = $gender_id;

		return $patient;
	}

	// / ennf of function place to edit
	
	public function get_staff_faculty_details($strath_no)
	{
		$this->db->from('staff');
		$this->db->select('department');
		$this->db->where('Staff_Number = \''.$strath_no.'\'');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$department_result = $query->row();
			$department = $department_result->department;
		}
		else
		{
			$department = '';
		}
		return $department;
	}
	public function get_patient_insurance($patient_id)
	{
		$table = "insurance_company";
		$where = "insurance_company_id > 0";
		$items = "*";
		$order = "insurance_company_name";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	public function doctors_schedule($personelle_id,$date){
		$table = "visit";
		$where = "personnel_id = '$personelle_id' and visit_date >= '$date' and time_start <> 0 and time_end <> 0";
		$items = "*";
		$order = "visit_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	public function doctors_names($personelle_id){
		$table = "personnel";
		$where = "personnel_id = '$personelle_id'";
		$items = "*";
		$order = "personnel_id";
			//echo $sql;
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}

	public function get_service_charges_per_type($patient_type){
		$table = "service_charge";
		$where = "visit_type_id = $patient_type and service_id = 1 and service_charge_status = 1";
		$items = "*";
		$order = "visit_type_id";
			//echo $sql;
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	public function get_counseling_service_charges_per_type($patient_type){
		$table = "service_charge";
		$where = "visit_type_id = $patient_type and service_id = 11 and service_charge_status = 1";
		$items = "*";
		$order = "visit_type_id";
			//echo $sql;
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	public function get_counselors(){
		$table = "personnel";
		$where = "job_title_id = 8 AND authorise = 0";
		$items = "*";
		$order = "personnel_id";
			//echo $sql;
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
	public function get_doctor2($doc_name)
	{
		$table = "personnel, job_title";
		$where = "job_title.job_title_id = personnel.job_title_id AND job_title.job_title_id = 2 AND personnel.personnel_onames = '$doc_name'";
		$items = "personnel.personnel_onames, personnel.personnel_fname, personnel.personnel_id";
		$order = "personnel_onames";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
	public function get_patient_id_from_visit($visit_id)
	{
		$this->db->where("visit_id = ".$visit_id);
		$this->db->select("patient_id");
		$query = $this->db->get('visit');
		
		$row = $query->row();
		
		return $row->patient_id;
	}

	
	public function get_patient_type($visit_type_id, $dependant_id = NULL)
	{
		if($visit_type_id == 1)
		{
			return 'Student';
		}
		
		else if(($visit_type_id == 2) && ($dependant_id > 0))
		{
			return 'Dependant';
		}
		
		else if(($visit_type_id == 2) && ($dependant_id <= 0))
		{
			return 'Staff';
		}
		
		else if(($visit_type_id == 3))
		{
			return 'Other';
		}
		
		else if(($visit_type_id == 4))
		{
			return 'Insurance';
		}
		
		else if(($visit_type_id == 5))
		{
			return 'General';
		}
		
		else
		{
			return 'N/A';
		}
		
	}
	
	/*
	*	Retrieve a single patient's details
	*	@param int $patient_id
	*
	*/
	public function get_patient_data($patient_id)
	{
		$this->db->from('patients');
		$this->db->select('*');
		$this->db->where('patient_id = '.$patient_id);
		$query = $this->db->get();
		
		return $query;
	}

	/*
	*	Retrieve a single patient's details
	*	@param int $patient_id
	*
	*/
	public function get_patient_staff_data($patient_id)
	{
		$this->db->from('patients');
		$this->db->select('*');
		$this->db->where('patient_id = '.$patient_id);
		$query = $this->db->get();
		
		return $query;
	}

	/*
	*	Retrieve a single patient's details
	*	@param int $patient_id
	*
	*/
	public function get_patient_student_data($patient_id)
	{
		$this->db->from('patients,student');
		$this->db->select('*');
		$this->db->where('patients.strath_no = student.student_Number AND patient_id = '.$patient_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Retrieve all staff dependants
	*	@param int $strath_no
	*
	*/
	public function get_all_staff_dependant($strath_no)
	{
		$this->db->from('staff_dependants');
		$this->db->select('*');
		$this->db->where('staff_dependants_id = \''.$strath_no.'\'');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Retrieve all patient dependants
	*	@param int $strath_no
	*
	*/
	public function get_all_patient_dependant($patient_id)
	{
		$this->db->from('patients');
		$this->db->select('*');
		$this->db->where('dependant_id = \''.$patient_id.'\'');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Retrieve all patient dependants
	*	@param int $strath_no
	*
	*/
	public function get_all_staff_dependants($patient_id)
	{
		$this->db->from('patients, staff_dependants, staff');
		$this->db->select('staff_dependants.*, staff.Staff_Number');
		$this->db->where('patients.strath_no = staff.Staff_Number AND staff.staff_system_id = staff_dependants.staff_id AND patients.patient_id = \''.$patient_id.'\'');
		$query = $this->db->get();
		
		return $query;
	}
	public function check_student_exist($patient_id,$visit_date)
	{
		$table = "visit";
		$where = "patient_id = ". $patient_id ." AND visit_date = ".$visit_date;
		$items = "*";
		$order = "visit_id";
			//echo $sql;
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
	public function get_staff_dependant_patient($staff_dependant_id, $staff_no)
	{
		$this->db->from('patients');
		$this->db->select('patients.*');
		$this->db->where('patients.strath_no = \''.$staff_dependant_id.'\' AND patients.dependant_id = \''.$staff_no.'\'');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Retrieve all appointments
	*	@param string $table
	* 	@param string $where
	*	@param int $per_page
	* 	@param int $page
	*
	*/
	public function get_all_appointments($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('visit.*, patients.*');
		$this->db->where($where);
		$this->db->order_by('visit_time','desc');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	public function get_patient_details($appointments_result, $visit_type_id, $dependant_id, $strath_no)
	{
		//staff & dependant
		if($visit_type_id == 2)
		{
			//dependant
			if($dependant_id > 0)
			{
				$patient_type = $this->reception_model->get_patient_type($visit_type_id, $dependant_id);
				$visit_type = 'Dependant';
				$dependant_query = $this->reception_model->get_dependant($strath_no);
				
				if($dependant_query->num_rows() > 0)
				{
					$dependants_result = $dependant_query->row();
					$patient_othernames = $dependants_result->other_names;
					$patient_surname = $dependants_result->names;
				}
				
				else
				{
					$patient_othernames = '<span class="label label-important">Dependant not found</span>';
					$patient_surname = '';
				}
			}
			
			//staff
			else
			{
				$patient_type = $this->reception_model->get_patient_type($visit_type_id, $dependant_id);
				$staff_query = $this->reception_model->get_staff($strath_no);
				$visit_type = 'Staff';
				
				if($staff_query->num_rows() > 0)
				{
					$staff_result = $staff_query->row();
					
					$patient_surname = $staff_result->Surname;
					$patient_othernames = $staff_result->Other_names;
				}
				
				else
				{
					$patient_othernames = '<span class="label label-important">Staff not found</span>';
					$patient_surname = '';
				}
			}
		}
		
		//student
		else if($visit_type_id == 1)
		{
			$student_query = $this->reception_model->get_student($strath_no);
			$patient_type = $this->reception_model->get_patient_type($visit_type_id);
			$visit_type = 'Student';
			
			if($student_query->num_rows() > 0)
			{
				$student_result = $student_query->row();
				
				$patient_surname = $student_result->Surname;
				$patient_othernames = $student_result->Other_names;
			}
			
			else
			{
				$patient_othernames = '<span class="label label-important">Student not found</span>';
				$patient_surname = '';
			}
		}
		
		//other patient
		else
		{
			$patient_type = $this->reception_model->get_patient_type($visit_type_id);
			
			if($visit_type_id == 3)
			{
				$visit_type = 'Other';
			}
			else if($visit_type_id == 4)
			{
				$visit_type = 'Insurance';
			}
			else
			{
				$visit_type = 'General';
			}
			$row = $appointments_result->row();
			$patient_othernames = $row->patient_othernames;
			$patient_surname = $row->patient_surname;
		}
		
		$patient = $visit_type.': '.$patient_surname.' '.$patient_othernames;
		
		return $patient;
	}
	
	public function delete_patient($patient_id)
	{
		$data = array
		(
			"patient_delete" => 1,
			"deleted_by" => $this->session->userdata('personnel_id'),
			"date_deleted" => date('Y-m-d H:i:s')
		);
		
		$this->db->where('patient_id', $patient_id);
		if($this->db->update('patients', $data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function delete_visit($visit_id)
	{
		$data = array
		(
			"visit_delete" => 1,
			"deleted_by" => $this->session->userdata('personnel_id'),
			"date_deleted" => date('Y-m-d H:i:s')
		);
		
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
	public function get_visit_date($visit_id)
	{
		$table = "visit";
		$where = "visit_id = ".$visit_id;
		$items = "visit_date";
		$order = "visit_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		$num_rows = count($result);
		if($num_rows > 0){
			foreach($result as $key):
				$visit_date = $key->visit_date;
			endforeach;
			return $visit_date;
		}
		else
		{
			return "None";
		}
	}
	public function change_patient_type_to_others($patient_id,$visit_type_idd)
	{
		
		$data = array
				(
					"visit_type_id" => 3,
				);
				
				$this->db->where('patient_id', $patient_id);
				if($this->db->update('patients', $data))
				{
					return TRUE;
				}
				
				else
				{
					return FALSE;
				}

	}

	public function get_student_details($patient_id)
	{
		$table = "patients,student";
		$where = "patients.patient_id = ".$patient_id." AND patients.strath_no = student.student_Number";
		$items = "student.Surname,student.Other_names,student.DOB,student.contact,student.gender,student.GUARDIAN_NAME,student.student_Number";
		$order = "student.student_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	
	}
	public function get_staff_details($patient_id)
	{
		$table = "patients";
		$where = "patients.patient_id = ".$patient_id." ";
		$items = "*";
		$order = "patient.patient_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	
	}
	public function change_patient_type($patient_id)
	{
	
		// check if the staff of student exist 
		$visit_type_id = $this->input->post('visit_type_id');
		$strath_no = $this->input->post('strath_no');
			$data = array
			(
				"visit_type_id" => $visit_type_id,
				"strath_no" => $student_number
			);
		
		$this->db->where('patient_id', $patient_id);
		if($this->db->update('patients', $data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
		
	}
	public function get_staff_details_from_patients($visit_type_id,$strath_no)
	{
		if($visit_type_id == 3)
		{
			//housekeeping
			$table = "patients";
			$where = "patient_national_id = '$strath_no'";
			$items = "*";
			$order = "patients.patient_id";
			
			$result = $this->database->select_entries_where($table, $where, $items, $order);
		}
		else if($visit_type_id == 4)
		{
			// sbs
			$table = "patients";
			$where = "strath_no = '$strath_no'";
			$items = "*";
			$order = "patients.patient_id";
			
			$result = $this->database->select_entries_where($table, $where, $items, $order);
		}

		
		return $result;
	}
	public function get_staff_number_from_staff($strath_no){
		$table = "staff";
		$where = "Staff_Number = ".$strath_no;
		$items = "*";
		$order = "staff.staff_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
	public function get_staff_number_from_patients($national_id){
		$table = "patients";
		$where = "patient_national_id = ".$national_id;
		$items = "*";
		$order = "patients.patient_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	public function get_student_number_from_student($strath_no)
	{
		$table = "student";
		$where = "student_Number = ".$strath_no;
		$items = "*";
		$order = "student.student_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	
	}
	public function add_sbs_patient()
	{
		$staff_type = $this->input->post('staff_type');
		$strath_no = $this->input->post('strath_no');
		
		
		// check if exist in the patients table
		
		 $check_patient = $this->check_patient_if_exist($staff_type,$strath_no);
		// count($check_patient);
		if(count($check_patient) > 0){
				return TRUE;
		}else{

			if($staff_type == "housekeeping"){
				$type_of_staff = 'housekeeping';
			}
			else
			{
				$type_of_staff = 'sbs';
			}

			$gender = $this->input->post('gender');

			if($gender == 'F')
			{
				$gender_id = 2;
			}
			else
			{
				$gender_id = 1;
			}
			$data2 = array(
				'patient_surname'=>ucwords(strtolower($this->input->post('surname'))),
				'patient_othernames'=>ucwords(strtolower($this->input->post('other_names'))),
				'patient_date_of_birth'=>$this->input->post('date_of_birth'),
				'gender_id'=>$gender_id,
				'patient_phone1'=>$this->input->post('phone'),
				'strath_no'=>$this->input->post('strath_no'),
				'patient_national_id'=>$this->input->post('strath_no'),
				'visit_type_id'=>2,
				'patient_date'=>date('Y-m-d H:i:s'),
				'patient_number'=>$this->strathmore_population->create_patient_number(),
				'created_by'=>$this->session->userdata('personnel_id'),
				'department'=>$type_of_staff,
				'modified_by'=>$this->session->userdata('personnel_id')
			);
			
			if($this->db->insert('patients', $data2))
			{
				return $this->db->insert_id();
			}
			else{
				return FALSE;
			}
		}	
			
		
	}
	public function check_patient_if_exist($staff_type,$strath_no){
		
		$table = "patients";
		
		$where = "strath_no = '".$strath_no."'";
		
		$items = "*";
		$order = "patients.patient_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	
	}
	public function check_staff_if_exist($staff_type,$strath_no){
		
		$table = "staff";
		$where = "Staff_Number = '".$strath_no."'";
		$items = "*";
		$order = "staff_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	
	}

	public function bulk_add_sbs_staff()
	{
		$query = $this->db->get('staff2');
		
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			
			foreach($result as $res)
			{
				$exists = $this->strathmore_population->staff_exists($res->Staff_Number);
				
				if(!$exists)
				{
					echo 'doesn\'t exist '.$res->Staff_Number.'<br/>';
					$data = array(
						'Other_names'=>ucwords(strtolower($res->Other_names)),
						'Surname'=>ucwords(strtolower($res->Surname)),
						'Staff_Number'=>$res->Staff_Number,
						'title'=>$res->title,
						'sbs'=>'1'
					);
					if(!$this->db->insert('staff', $data))
					{
						break;
						return FALSE;
					}
				}
				
				else
				{
					echo 'Exists '.$res->Staff_Number.'<br/>';
				}
			}
		}
		
		return TRUE;
	}
	
	function random_color()
	{
		$rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
    	$color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
		
		return $color;
	}
	
	public function get_patient_data_from_visit($visit_id)
	{
		$this->db->select('visit.*, patients.*');
		$this->db->where("visit.patient_id = patients.patient_id AND visit.visit_id = ".$visit_id);
		$query = $this->db->get('visit, patients');
		
		$row = $query->row();
		
		return $row;
	}

	public function calculate_age($patient_date_of_birth)
	{
		$value = $this->dateDiff(date('y-m-d  h:i'), $patient_date_of_birth." 00:00", 'year');
		
		return $value;
	}

	public function dateDiff($time1, $time2, $interval) 
	{
	    // If not numeric then convert texts to unix timestamps
	    if (!is_int($time1)) {
	      $time1 = strtotime($time1);
	    }
	    if (!is_int($time2)) {
	      $time2 = strtotime($time2);
	    }
	 
	    // If time1 is bigger than time2
	    // Then swap time1 and time2
	    if ($time1 > $time2) {
	      $ttime = $time1;
	      $time1 = $time2;
	      $time2 = $ttime;
	    }
	 
	    // Set up intervals and diffs arrays
	    $intervals = array('year','month','day','hour','minute','second');
	    if (!in_array($interval, $intervals)) {
	      return false;
	    }
	 
	    $diff = 0;
	    // Create temp time from time1 and interval
	    $ttime = strtotime("+1 " . $interval, $time1);
	    // Loop until temp time is smaller than time2
	    while ($time2 >= $ttime) {
	      $time1 = $ttime;
	      $diff++;
	      // Create new temp time from time1 and interval
	      $ttime = strtotime("+1 " . $interval, $time1);
	    }
	 
	    return $diff;
  	}
  	function check_patient_exist($patient_id,$visit_date){
  		$table = "visit";
		$where = "visit.patient_id =" .$patient_id ." AND visit.visit_date = '$visit_date' AND close_card = 0 AND visit.visit_delete = 0";
		$items = "*";
		$order = "visit.visit_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
  	}
	/*
	*	Retrieve a single dependant
	*	@param int $strath_no
	*
	*/
	public function get_visit_departments()
	{
		$this->db->from('departments');
		$this->db->select('*');
		$this->db->where('visit = 1');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Create remove visit department
	*
	*/
	public function remove_visit_department($visit_id)
	{
		$update['visit_department_status'] = 0;
		$update['modified_by'] = $this->session->userdata('personnel_id');
		$update['last_modified'] = date('Y-m-d H:i:s');
		
		$this->db->where(array('visit_department_status' => 1, 'visit_id' => $visit_id));
		
		if($this->db->update('visit_department', $update))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Create visit department
	*
	*/
	public function set_visit_department($visit_id, $department_id)
	{
		if($this->remove_visit_department($visit_id))
		{
			$data = array(
				'visit_id'=>$visit_id,
				'department_id'=>$department_id,
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('personnel_id'),
				'modified_by'=>$this->session->userdata('personnel_id')
			);
			
			if($this->db->insert('visit_department', $data))
			{
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function save_visit_consultation_charge($visit_id, $service_charge_id)
	{
		//add charge for visit
		$service_charge = $this->reception_model->get_service_charge($service_charge_id);		
		
		$visit_charge_data = array(
			"visit_id" => $visit_id,
			"service_charge_id" => $service_charge_id,
			"created_by" => $this->session->userdata("personnel_id"),
			"date" => date("Y-m-d"),
			"visit_charge_amount" => $service_charge
		);
		if($this->db->insert('visit_charge', $visit_charge_data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function set_last_visit_date($patient_id, $visit_date)
	{
		$patient_date = array(
			"last_visit" => $visit_date
		);
		$this->db->where('patient_id', $patient_id);
		$this->db->update('patients', $patient_date);
	}
	
	public function create_visit($visit_date, $patient_id, $doctor_id, $patient_insurance_id, $patient_insurance_number, $patient_type, $timepicker_start, $timepicker_end, $appointment_id, $close_card)
	{
		$visit_data = array(
			"visit_date" => $visit_date,
			"patient_id" => $patient_id,
			"personnel_id" => $doctor_id,
			"patient_insurance_id" => $patient_insurance_id,
			"patient_insurance_number" => $patient_insurance_number,
			"visit_type" => $patient_type,
			"time_start"=>$timepicker_start,
			"time_end"=>$timepicker_end,
			"appointment_id"=>$appointment_id,
			"close_card"=>$close_card,
		);

		$this->db->insert('visit', $visit_data);
		$visit_id = $this->db->insert_id();
		
		return $visit_id;
	}
	
	public function coming_from($visit_id)
	{
		$where = 'visit_department.visit_id = '.$visit_id.' AND visit_department.department_id = departments.department_id AND visit_department.visit_department_status = 0';
		$this->db->select('departments.departments_name');
		$this->db->where($where);
		$this->db->order_by('visit_department.last_modified','DESC');
		$query = $this->db->get('visit_department, departments', 1, 0);
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row->departments_name;
		}
		
		else
		{
			return 'Reception';
		}
	}
	
	public function going_to($visit_id)
	{
		$where = 'visit_department.visit_id = '.$visit_id.' AND visit_department.department_id = departments.department_id AND visit_department.visit_department_status = 1';
		$this->db->select('departments.departments_name');
		$this->db->where($where);
		$query = $this->db->get('visit_department, departments', 1, 0);
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row->departments_name;
		}
		
		else
		{
			return 'Reception';
		}
	}
	
	public function get_visit_trail($visit_id)
	{
		$where = 'visit_department.visit_id = '.$visit_id.' AND visit_department.department_id = departments.department_id AND visit_department.created_by = personnel.personnel_id';
		$this->db->select('departments.departments_name, personnel.personnel_fname, visit_department.*');
		$this->db->where($where);
		$this->db->order_by('visit_department.created','ASC');
		$query = $this->db->get('visit_department, departments, personnel');
		
		return $query;
	}
	
	public function get_student_data($strath_no)
	{
		$where = 'strath_no = '.$strath_no;
		$this->db->select('*');
		$this->db->where($where);
		$query = $this->db->get('patients');
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$student['student_number'] = $row->strath_no;
			$student['patient_othernames'] = $row->patient_surname;
			$student['patient_surname'] = $row->patient_othernames;
			$student['patient_date_of_birth'] = $row->patient_date_of_birth;
			$student['gender'] = $row->gender_id;
		}
		
		else
		{
			$student['student_number'] = '';
			$student['patient_othernames'] = '';
			$student['patient_surname'] = '<span class="label label-important">Student not found: '.$strath_no.'</span>';
			$student['patient_date_of_birth'] = '';
			$student['gender'] = '';
		}
		return $student;
	}
	public function get_staff_dependant_data($strath_no)
	{
		$where = 'staff.staff_system_id = staff_dependants.staff_id AND staff.Staff_Number = '.$strath_no;
		$this->db->select('*');
		$this->db->where($where);
		$query = $this->db->get('staff_dependants,staff');
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$student['staff_id'] = $row->staff_id;
			$student['patient_othernames'] = $row->other_names;
			$student['patient_surname'] = $row->surname;
			$student['patient_date_of_birth'] = $row->patient_date_of_birth;
			$student['gender'] = $row->gender;
		}
		
		else
		{
			$student['staff_id'] = '';
			$student['patient_othernames'] = '';
			$student['patient_surname'] = '<span class="label label-important">Dependant not found: '.$strath_no.'</span>';
			$student['patient_date_of_birth'] = '';
			$student['gender'] = '';
		}
		return $student;
	}
	
	/*
	*	Retrieve all students in SUMC db
	*
	*/
	public function get_all_students($per_page, $page)
	{
		$this->db->from('student');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Retrieve all students patients in SUMC db
	*
	*/
	public function get_all_student_patients($student_no)
	{
		$this->db->from('patients');
		$this->db->where('strath_no = \''.$student_no.'\' AND visit_type_id = 1');
		$query = $this->db->get();
		
		return $query;
	}
	
	public function change_patient_id($standing_patient_id, $patient_id)
	{
		$where['patient_id'] = $patient_id;
		$items['patient_id'] = $standing_patient_id;
		
		$this->db->where($where);
		if($this->db->update('visit', $items))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function delete_duplicate_patient($patient_id)
	{
		$where['patient_id'] = $patient_id;
		
		$this->db->where($where);
		if($this->db->delete('patients'))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Retrieve all students in SUMC db
	*
	*/
	public function get_all_dependants()
	{
		$this->db->select('patients.patient_id, staff_dependants.DOB, staff_dependants.Gender, staff_dependants.surname, staff_dependants.other_names');
		$this->db->from('patients, staff_dependants');
		$this->db->where('patients.visit_type_id = 2 AND patients.strath_no > 0 AND patients.strath_no = staff_dependants.staff_dependants_id');
		$query = $this->db->get();
		
		return $query;
	}
	public function get_all_ongoing_visits3()
	{
		//retrieve all users
		$this->db->from('visit, patients');
		$this->db->select('visit.*, patients.visit_type_id, patients.visit_type_id, patients.gender_id, patients.patient_date_of_birth, patients.patient_othernames, patients.patient_surname, patients.dependant_id, patients.strath_no,patients.patient_national_id,patients.patient_phone1,patients.patient_phone2');
		$this->db->where('visit.visit_delete = 0 AND patients.patient_delete = 0 AND visit.patient_id = patients.patient_id AND visit.appointment_id = 1 AND visit.close_card = 2');
		$this->db->order_by('visit.visit_date','ASC');
		$query = $this->db->get('',10);
		
		return $query;
	}
	
	public function update_patient_names()
	{
		$table = "patients";
		$where = "patient_id > 0";
		$items = "*";
		$order = "patient_surname";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		foreach ($result as $row)
		{
			$patient_id = $row->patient_id;
			$dependant_id = $row->dependant_id;
			$patient_number = $row->patient_number;
			$dependant_id = $row->dependant_id;
			$strath_no = $row->strath_no;
			$created_by = $row->created_by;
			$modified_by = $row->modified_by;
			$visit_type_id = $row->visit_type_id;
			$created = $row->patient_date;
			$last_modified = $row->last_modified;
			$last_visit = $row->last_visit;
			$visit_type = 0;
			$check_id = $visit_type_id;
			$visit_id = NULL;
			
			/*if($visit_id != NULL)
			{
				$visit_type = $row->visit_type;
				$check_id = $visit_type;
				
				//a student being charged as an outsider
				if(($visit_type == 3) && ($visit_type_id == 1))
				{
					$check_id = $visit_type_id;
					$visit_type = 0;
				}
				
				//staff being charged as an outsider
				if(($visit_type == 3) && ($visit_type_id == 2))
				{
					$check_id = $visit_type_id;
					$visit_type = 0;
				}
			}
			
			else
			{
				$visit_type = 0;
			}*/
			
			if($visit_type_id != 3)
			{
				if($check_id < 3)
				{
					$patient_data = $this->get_strath_patient_data($check_id, $visit_id, $strath_no, $row, $dependant_id, $visit_type_id, $patient_id);
					$visit_type = $patient_data['visit_type'];
					$patient_type = $patient_data['patient_type'];
					$patient_othernames = $patient_data['patient_othernames'];
					$patient_surname = $patient_data['patient_surname'];
					$patient_date_of_birth = $patient_data['patient_date_of_birth'];
					$gender = $patient_data['gender'];
					$gender_id = $patient_data['gender_id'];
					$faculty = $patient_data['faculty'];
					$contact = '';//$patient_data['contact'];
				}
				
				//other patient
				else
				{
					$patient_type = $this->reception_model->get_patient_type($visit_type_id);
					
					if($visit_type == 3)
					{
						$visit_type = 'Other';
					}
					else if($visit_type == 2)
					{
						$visit_type = 'Staff';
					}
					else if($visit_type == 1)
					{
						$visit_type = 'Student';
					}
					else if($visit_type == 4)
					{
						$visit_type = 'Insurance';
					}
					else
					{
						$visit_type = 'General';
					}
					
					$patient_othernames = $row->patient_othernames;
					$patient_surname = $row->patient_surname;
					$patient_date_of_birth = $row->patient_date_of_birth;
					$gender_id = $row->gender_id;
					$faculty ='';
					$contact = $row->patient_phone1;
					if($gender_id == 1)
					{
						$gender = 'M';
					}
					else
					{
						$gender = 'F';
					}
						
					if(($patient_surname == '0.00') && ($patient_othernames == '0.00'))
					{
						$patient_data = $this->get_strath_patient_data($visit_type_id, $visit_id, $strath_no, $row, $dependant_id, $visit_type_id, $patient_id);
						$patient_othernames = $patient_data['patient_othernames'];
						$patient_surname = $patient_data['patient_surname'];
						$patient_date_of_birth = $patient_data['patient_date_of_birth'];
						$gender = $patient_data['gender'];
						$faculty = $patient_data['faculty'];
						$gender_id = $patient_data['gender_id'];
						$contact = '';//$patient_data['contact'];
					}
					
				}
				
				//update db

				if($visit_type_id == 1)
				{
					// this is a student
					$data = array(
						'patient_surname'=>ucwords(strtolower($patient_surname)),
						'patient_othernames'=>ucwords(strtolower($patient_othernames)),
						//'title_id'=>$this->input->post('title_id'),
						'patient_date_of_birth'=>$patient_date_of_birth,
						'patient_phone1'=>$contact,
						'gender_id'=>$gender_id,
						'faculty'=> $faculty
					);
					
					$this->db->where('patient_id', $patient_id);
					if($this->db->update('patients', $data))
					{
						echo $check_id.' - '.$visit_id.' - '.$strath_no.' - '.$dependant_id.' - '.$visit_type_id.' - '.$patient_id.'- '.$faculty.'<br/>';
					}
					else{
						echo 'Unable to insert <br/>';
					}
				}
				else if($visit_type_id == 2)
				{
					$data = array(
					'patient_surname'=>ucwords(strtolower($patient_surname)),
					'patient_othernames'=>ucwords(strtolower($patient_othernames)),
					//'title_id'=>$this->input->post('title_id'),
					'patient_date_of_birth'=>$patient_date_of_birth,
					'patient_phone1'=>$contact,
					'gender_id'=>$gender_id,
					'department'=> $faculty
					);
					
					$this->db->where('patient_id', $patient_id);
					if($this->db->update('patients', $data))
					{
						echo $check_id.' - '.$visit_id.' - '.$strath_no.' - '.$dependant_id.' - '.$visit_type_id.' - '.$patient_id.'- '.$faculty.'<br/>';
					}
					else{
						echo 'Unable to insert <br/>';
					}

				}
				else
				{
					$data = array(
					'patient_surname'=>ucwords(strtolower($patient_surname)),
					'patient_othernames'=>ucwords(strtolower($patient_othernames)),
					//'title_id'=>$this->input->post('title_id'),
					'patient_date_of_birth'=>$patient_date_of_birth,
					'patient_phone1'=>$contact,
					'gender_id'=>$gender_id
					);
					
					$this->db->where('patient_id', $patient_id);
					if($this->db->update('patients', $data))
					{
						echo $check_id.' - '.$visit_id.' - '.$strath_no.' - '.$dependant_id.' - '.$visit_type_id.' - '.$patient_id.'<br/>';
					}
					else{
						echo 'Unable to insert <br/>';
					}
				}

				
			}
		}
	}
	public function update_invoice_data($visit_id)
	{
		$where['visit_id'] = $visit_id;
		
		//normal payments
		$this->db->where($where);
		$this->db->select('SUM(normal_payments.amount_paid) AS total_payments');
		$query = $this->db->get('normal_payments');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$total_payments = $row->total_payments;
		}
		else
		{
			$total_payments = 0;
		}
		
		//cash payments
		$this->db->where($where);
		$this->db->select('SUM(cash_payments.amount_paid) AS total_payments');
		$query = $this->db->get('cash_payments');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$cash_payments = $row->total_payments;
		}
		else
		{
			$cash_payments = 0;
		}
		
		//cheque payments
		$this->db->where($where);
		$this->db->select('SUM(cheque_payments.amount_paid) AS total_payments');
		$query = $this->db->get('cheque_payments');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$cheque_payments = $row->total_payments;
		}
		else
		{
			$cheque_payments = 0;
		}
		
		//mpesa payments
		$this->db->where($where);
		$this->db->select('SUM(mpesa_payments.amount_paid) AS total_payments');
		$query = $this->db->get('mpesa_payments');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$mpesa_payments = $row->total_payments;
		}
		else
		{
			$mpesa_payments = 0;
		}
		
		//total_debit_notes
		$this->db->where($where);
		$this->db->select('SUM(debit_notes.amount_paid) AS total_debit_notes');
		$query = $this->db->get('debit_notes');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$total_debit_notes = $row->total_debit_notes;
		}
		else
		{
			$total_debit_notes = 0;
		}
		
		//total_credit_notes
		$this->db->where($where);
		$this->db->select('SUM(credit_notes.amount_paid) AS total_credit_notes');
		$query = $this->db->get('credit_notes');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$total_credit_notes = $row->total_credit_notes;
		}
		else
		{
			$total_credit_notes = 0;
		}
		
		//consultation
		$this->db->where($where);
		$this->db->select('SUM(invoice_clinic_meds.clinic_meds) AS clinic_meds');
		$query = $this->db->get('invoice_clinic_meds');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$clinic_meds = $row->clinic_meds;
		}
		else
		{
			$clinic_meds = 0;
		}
		
		//consultation
		$this->db->where($where);
		$this->db->select('SUM(invoice_consultation.consultation) AS consultation');
		$query = $this->db->get('invoice_consultation');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$consultation = $row->consultation;
		}
		else
		{
			$consultation = 0;
		}
		
		//counseling
		$this->db->where($where);
		$this->db->select('SUM(invoice_counseling.counseling) AS counseling');
		$query = $this->db->get('invoice_counseling');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$counseling = $row->counseling;
		}
		else
		{
			$counseling = 0;
		}
		
		//dental
		$this->db->where($where);
		$this->db->select('SUM(invoice_dental.dental) AS dental');
		$query = $this->db->get('invoice_dental');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$dental = $row->dental;
		}
		else
		{
			$dental = 0;
		}
		
		//ecg
		$this->db->where($where);
		$this->db->select('SUM(invoice_ecg.ecg) AS ecg');
		$query = $this->db->get('invoice_ecg');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$ecg = $row->ecg;
		}
		else
		{
			$ecg = 0;
		}
		
		//laboratory
		$this->db->where($where);
		$this->db->select('SUM(invoice_laboratory.laboratory) AS laboratory');
		$query = $this->db->get('invoice_laboratory');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$laboratory = $row->laboratory;
		}
		else
		{
			$laboratory = 0;
		}
		
		//normal payments
		$this->db->where($where);
		$this->db->select('SUM(invoice_nursing_fee.nursing_fee) AS nursing_fee');
		$query = $this->db->get('invoice_nursing_fee');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$nursing_fee = $row->nursing_fee;
		}
		else
		{
			$nursing_fee = 0;
		}
		
		//paediatrics
		$this->db->where($where);
		$this->db->select('SUM(invoice_paediatrics.paediatrics) AS paediatrics');
		$query = $this->db->get('invoice_paediatrics');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$paediatrics = $row->paediatrics;
		}
		else
		{
			$paediatrics = 0;
		}
		
		//pharmacy
		$this->db->where($where);
		$this->db->select('SUM(invoice_pharmacy.pharmacy) AS pharmacy');
		$query = $this->db->get('invoice_pharmacy');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$pharmacy = $row->pharmacy;
		}
		else
		{
			$pharmacy = 0;
		}
		
		//physician
		$this->db->where($where);
		$this->db->select('SUM(invoice_physician.physician) AS physician');
		$query = $this->db->get('invoice_physician');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$physician = $row->physician;
		}
		else
		{
			$physician = 0;
		}
		
		//physiotherapy
		$this->db->where($where);
		$this->db->select('SUM(invoice_physiotherapy.physiotherapy) AS physiotherapy');
		$query = $this->db->get('invoice_physiotherapy');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$physiotherapy = $row->physiotherapy;
		}
		else
		{
			$physiotherapy = 0;
		}
		
		//procedures
		$this->db->where($where);
		$this->db->select('SUM(invoice_procedures.procedures) AS procedures');
		$query = $this->db->get('invoice_procedures');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$procedures = $row->procedures;
		}
		else
		{
			$procedures = 0;
		}
		
		//radiology
		$this->db->where($where);
		$this->db->select('SUM(invoice_radiology.radiology) AS radiology');
		$query = $this->db->get('invoice_radiology');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$radiology = $row->radiology;
		}
		else
		{
			$radiology = 0;
		}
		
		//ultrasound
		$this->db->where($where);
		$this->db->select('SUM(invoice_ultrasound.ultrasound) AS ultrasound');
		$query = $this->db->get('invoice_ultrasound');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$ultrasound = $row->ultrasound;
		}
		else
		{
			$ultrasound = 0;
		}
		
		$data = array(
			'total_payments' => $total_payments,
			'cash' => $cash_payments,
			'cheque' => $cheque_payments,
			'mpesa' => $mpesa_payments,
			'total_debit_notes' => $total_debit_notes,
			'total_credit_notes' => $total_credit_notes,
			'consultation' => $consultation,
			'clinic_meds' => $clinic_meds,
			'counseling' => $counseling,
			'dental' => $dental,
			'ecg' => $ecg,
			'laboratory' => $laboratory,
			'nursing_fee' => $nursing_fee,
			'paediatrics' => $paediatrics,
			'pharmacy' => $pharmacy,
			'physician' => $physician,
			'physiotherapy' => $physiotherapy,
			'procedures' => $procedures,
			'radiology' => $radiology,
			'ultrasound' => $ultrasound
		);
		
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
	public function update_clinic_meds($visit_id)
	{
		$where['visit_id'] = $visit_id;
		
		//clinic meds
		$this->db->where($where);
		$this->db->select('SUM(invoice_clinic_meds.clinic_meds) AS clinic_meds');
		$query = $this->db->get('invoice_clinic_meds');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$clinic_meds = $row->clinic_meds;
		}
		else
		{
			$clinic_meds = 0;
		}
		
		$data = array(
			'clinic_meds' => $clinic_meds
		);
		
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
	
	public function update_sbs_departments($staff_number = NULL)
	{
		$where = "(strath_no LIKE 'sbs%') OR (strath_no LIKE 'SBS%')";
		
		if($staff_number != NULL)
		{
			$where = " strath_no = '".$staff_number."'";
		}
		
		$this->db->where($where);
		$query = $this->db->get('patients');
		
		if($query->num_rows() > 0)
		{
			$return = '';
			foreach($query->result() as $res)
			{
				$surname = $res->patient_surname;
				$othernames = $res->patient_othernames;
				$patient_id = $res->patient_id;
				$data['department'] = 'SBS';
				
				$this->db->where('patient_id', $patient_id);
				if($this->db->update('patients', $data))
				{
					$return .= $surname.' '.$othernames.' department updated to SBS<br/>';
				}
				
				else
				{
					$return .= 'Unable to update '.$surname.' '.$othernames.'<br/>';
				}
			}
		}
		
		else
		{
			$return = 'No patients found';
		}
		
		return $return;
	}
	
	public function update_housekeeping_departments($staff_number = NULL)
	{
		$where = "CHAR_LENGTH(strath_no) >= 7";
		
		if($staff_number != NULL)
		{
			$where = " strath_no = '".$staff_number."'";
		}
		$this->db->where($where);
		$query = $this->db->get('patients');
		
		if($query->num_rows() > 0)
		{
			$return = '';
			foreach($query->result() as $res)
			{
				$surname = $res->patient_surname;
				$othernames = $res->patient_othernames;
				$patient_id = $res->patient_id;
				$data['department'] = 'Housekeeping';
				
				$this->db->where('patient_id', $patient_id);
				if($this->db->update('patients', $data))
				{
					$return .= $surname.' '.$othernames.' department updated to Housekeeping<br/>';
				}
				
				else
				{
					$return .= 'Unable to update '.$surname.' '.$othernames.'<br/>';
				}
			}
		}
		
		else
		{
			$return = 'No patients found';
		}
		
		return $return;
	}
	
	public function is_card_held($visit_id)
	{
		$this->db->where('visit_id', $visit_id);
		$this->db->join('personnel', 'personnel.personnel_id = visit.held_by', 'left');
		$query = $this->db->get('visit');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$close_card = $row->close_card;
			$held_by = $row->personnel_fname.' '.$row->personnel_onames;
			
			if($close_card == 7)
			{
				$this->session->set_userdata('error_message', 'You cannot close this card. It has been held by '.$held_by);
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
}

?>