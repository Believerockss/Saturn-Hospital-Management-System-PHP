<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Medical extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();

        $this->output->set_header("X-Frame-Options: sameorigin");
        $this->output->set_header("X-XSS-Protection: 1; mode=block");
        $this->output->set_header("X-Content-Type-Options: nosniff");
        $this->output->set_header("Strict-Transport-Security: max-age=31536000");
    }
    public function index()
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'dashboard'))->row()->module_id), $this->session->userdata('permissions'))) {
            $page_data['page_title']    =   'Dashboard';
            $page_data['page_name']     =   'dashboard';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    public function login()
    {
        $this->load->view('login');
    }

    // Function related to occupancies (In-Patient Department)
    public function occupancies($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'occupancies'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_occupancy();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_occupancy_details($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_occupancy_details($param2);
            }

            $page_data['page_title']    =   'Occupancies';
            $page_data['page_name']     =   'occupancies';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to treatments (In-Patient Department)
    public function treatments($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'treatments'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_treatment();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_treatment_details($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_treatment_details($param2);
            }

            $page_data['page_title']    =   'Treatments';
            $page_data['page_name']     =   'treatments';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to Discharges
    public function discharges($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'discharges'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_discharge();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_discharge_details($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_discharge_details($param2);
            }

            $page_data['page_title']    =   'Discharges';
            $page_data['page_name']     =   'discharges';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to meals
    public function patient_meals($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'patient_meals'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_patient_meal();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_patient_meal_details($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_patient_meal_details($param2);
            }

            $page_data['page_title']    =   'Patient Meals';
            $page_data['page_name']     =   'patient_meals';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to transport services
    public function transport_services($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'transport_services'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_transport_service();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_transport_service_details($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_transport_service_details($param2);
            }

            $page_data['page_title']    =   'Transport Services';
            $page_data['page_name']     =   'transport_services';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to appointments
    public function appointments($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'appointments'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_appointment();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_appointment_details($param2);
            } elseif ($param1 == 'update_status') {
                $this->medical_model->update_appointment_status($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_appointment_details($param2);
            }

            $page_data['page_title']    =   'Appointments';
            $page_data['page_name']     =   'appointments';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to patients
    public function patients($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'patients'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_patient();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_patient_details($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_patient_details($param2);
            }

            $page_data['page_title']    =   'Patients';
            $page_data['page_name']     =   'patients';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to patient
    function patient($param = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'patients'))->row()->module_id), $this->session->userdata('permissions'))) {
            // if ($param1 == 'create') {
            //     $this->medical_model->create_patient();
            // } elseif ($param1 == 'update') {
            //     $this->medical_model->update_patient_details($param2);
            // } elseif ($param1 == 'delete') {
            //     $this->medical_model->delete_patient_details($param2);
            // }

            $page_data['page_title']    =   'Patient';
            $page_data['page_name']     =   'patient';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to prescriptions
    public function prescriptions($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'prescriptions'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_prescription();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_prescription_details($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_prescription_details($param2);
            }

            $page_data['page_title']    =   'Prescriptions';
            $page_data['page_name']     =   'prescriptions';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    function html_prescription_to_pdf($prescription_id = '')
    {
        $page_data['prescription_id']   =   $prescription_id;
        $this->load->view('generate_html_prescription_to_pdf', $page_data);
		$html = $this->output->get_output();
		$this->load->library('pdf');
		$this->pdf->loadHtml($html);
		$this->pdf->setPaper('A4', 'potrait');		
        $this->pdf->render();

		// $this->pdf->stream("mypdf.pdf", array("Attachment" => 0));
		// exit(0);

		$pdf = $this->pdf->output();
		$file_location = $_SERVER['DOCUMENT_ROOT'] . '/uploads/prescriptions/' . $prescription_id . '.pdf';
		file_put_contents($file_location, $pdf);
    }

    // Function related to emergency rosters
    public function emergency_rosters($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'emergency_rosters'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_emergency_roster();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_emergency_roster_details($param2);
            } elseif ($param1 == 'update_status') {
                $this->medical_model->update_emergency_roster_status($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_emergency_roster_details($param2);
            }

            $page_data['page_title']    =   'Emergency Rosters';
            $page_data['page_name']     =   'emergency_rosters';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to emergency patients
    public function emergency_patients($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'emergency_patients'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_emergency_patient();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_emergency_patient_details($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_emergency_patient_details($param2);
            }

            $page_data['page_title']    =   'Emergency Patients';
            $page_data['page_name']     =   'emergency_patients';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to pharmacy inventory
    public function pharmacy_inventory($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'pharmacy_inventory'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_pharmacy_inventory();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_pharmacy_inventory_details($param2);
            } elseif ($param1 == 'update_inventory') {
                $this->medical_model->update_pharmacy_inventory($param2);
            }

            $page_data['page_title']    =   'Pharmacy Inventory';
            $page_data['page_name']     =   'pharmacy_inventory';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to pharmacy pos
    public function pharmacy_pos()
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'pharmacy_pos'))->row()->module_id), $this->session->userdata('permissions'))) {
            $page_data['page_title']    =   'Pharmacy POS';
            $page_data['page_name']     =   'pharmacy_pos';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to pharmacy sale
    public function pharmacy_sales($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'pharmacy_sales'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'add') {
                $this->medical_model->add_pharmacy_sale();
            } elseif ($param1 == 'edit') {
                $this->medical_model->edit_pharmacy_sale($param2);
            } elseif ($param1 == 'remove') {
                $this->medical_model->remove_pharmacy_sale($param2);
            } elseif ($param1 == 'create') {
                $this->medical_model->create_pharmacy_sale($param2);
            } elseif ($param1 == 'update_status') {
                $this->medical_model->update_pharmacy_sale_status($param2);
            }

            $page_data['page_title']    =   'Pharmacy Sales';
            $page_data['page_name']     =   'pharmacy_sales';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to pharmacy sale returns
    public function pharmacy_sale_returns($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'pharmacy_sale_returns'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_pharmacy_sale_return($param2);
            } elseif ($param1 == 'update') {
                $this->medical_model->update_pharmacy_sale_return_details($param2);
            }

            $page_data['page_title']    =   'Pharmacy Sale Returns';
            $page_data['page_name']     =   'pharmacy_sale_returns';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to pharmacy invoice
    public function pharmacy_invoice($param = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'pharmacy_invoice'))->row()->module_id), $this->session->userdata('permissions'))) {
            $page_data['pharmacy_sale_id']  =   $param;
            $page_data['page_title']        =   'Pharmacy Invoice';
            $page_data['page_name']         =   'pharmacy_invoice';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to pharmacy units
    public function pharmacy_units($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'pharmacy_units'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_pharmacy_unit();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_pharmacy_unit($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_pharmacy_unit($param2);
            }

            $page_data['page_title']    =   'Pharmacy Units';
            $page_data['page_name']     =   'pharmacy_units';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to cafeteria inventory
    public function cafeteria_inventory($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'cafeteria_inventory'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_cafeteria_inventory();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_cafeteria_inventory_details($param2);
            } elseif ($param1 == 'update_inventory') {
                $this->medical_model->update_cafeteria_inventory($param2);
            }

            $page_data['page_title']    =   'Cafeteria Inventory';
            $page_data['page_name']     =   'cafeteria_inventory';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to pharmacy pos
    public function cafeteria_pos()
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'cafeteria_pos'))->row()->module_id), $this->session->userdata('permissions'))) {
            $page_data['page_title']    =   'Cafeteria POS';
            $page_data['page_name']     =   'cafeteria_pos';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to cafeteria sale
    public function cafeteria_sales($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'cafeteria_sales'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'add') {
                $this->medical_model->add_cafeteria_sale();
            } elseif ($param1 == 'edit') {
                $this->medical_model->edit_cafeteria_sale($param2);
            } elseif ($param1 == 'remove') {
                $this->medical_model->remove_cafeteria_sale($param2);
            } elseif ($param1 == 'create') {
                $this->medical_model->create_cafeteria_sale();
            } elseif ($param1 == 'update_status') {
                $this->medical_model->update_cafeteria_sale_status($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_cafeteria_sale($param2);
            }

            $page_data['page_title']    =   'Cafeteria Sales';
            $page_data['page_name']     =   'cafeteria_sales';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to cafeteria invoice
    public function cafeteria_invoice($param = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'cafeteria_invoice'))->row()->module_id), $this->session->userdata('permissions'))) {
            $page_data['cafeteria_sale_id'] =   $param;
            $page_data['page_title']        =   'Cafeteria Invoice';
            $page_data['page_name']         =   'cafeteria_invoice';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to cafeteria units
    public function cafeteria_units($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'cafeteria_units'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_cafeteria_unit();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_cafeteria_unit($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_cafeteria_unit($param2);
            }

            $page_data['page_title']    =   'Cafeteria Units';
            $page_data['page_name']     =   'cafeteria_units';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to tickets
    function tickets($param1 = '', $param2 = '')
	{
		if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

		if (in_array($this->db->get_where('module', array('name' => 'tickets'))->row()->module_id, $this->session->userdata('permissions'))) {
			if ($param1 == 'create') {
                $this->medical_model->create_ticket();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_ticket($param2);
            } elseif ($param1 == 'close') {
                $this->medical_model->close_ticket($param2);
            }

            $page_data['page_title']    =   'Tickets';
            $page_data['page_name']     =   'tickets';
            $this->load->view('index', $page_data);
		} else {
            redirect(base_url() . 'notfound', 'refresh');
        }
	}

    // Function related to staff category
    public function staff_categories($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'staff_categories'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_staff_category();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_staff_category($param2);
            } elseif ($param1 == 'update_permission') {
                $this->medical_model->update_staff_permission($param2);
            }

            $page_data['page_title']            =   'Staff Categories';
            $page_data['page_name']             =   'staff_categories';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to staff
    public function staff($param1 = '', $param2 = '', $param3 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'staff'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_staff($param2);
            } elseif ($param1 == 'update') {
                $this->medical_model->update_staff_details($param2, $param3);
            } elseif ($param1 == 'update_status') {
                $this->medical_model->update_staff_status($param2, $param3);
            }

            $page_data['staff_category_id']     =   $param1;
            $page_data['is_doctor']             =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $param1))->row()->is_doctor);

            $page_data['page_title']            =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $param1))->row()->name);
            $page_data['page_name']             =   'staff';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to accommodation category
    public function accommodation_categories($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'accommodation_categories'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_accommodation_category();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_accommodation_category($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_accommodation_category($param2);
            }

            $page_data['page_title']    =   'Accommodation Categories';
            $page_data['page_name']     =   'accommodation_categories';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to accommodation
    public function accommodations($param1 = '', $param2 = '', $param3 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'accommodations'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_accommodation($param2);
            } elseif ($param1 == 'update') {
                $this->medical_model->update_accommodation_details($param2, $param3);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_accommodation_details($param2, $param3);
            }

            $page_data['accommodation_category_id'] =   $param1;
            $page_data['accommodation_type']        =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $param1))->row()->accommodation_type);

            $page_data['page_title']                =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $param1))->row()->name);
            $page_data['page_name']                 =   'accommodations';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to transport categories
    public function transport_categories($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'transport_categories'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_transport_category();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_transport_category($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_transport_category($param2);
            }

            $page_data['page_title']    =   'Transport Categories';
            $page_data['page_name']     =   'transport_categories';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to transports
    public function transports($param1 = '', $param2 = '', $param3 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'transports'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_transport($param2);
            } elseif ($param1 == 'update') {
                $this->medical_model->update_transport_details($param2, $param3);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_transport_details($param2, $param3);
            }

            $page_data['transport_category_id']     =   $param1;

            $page_data['page_title']                =   $this->security->xss_clean($this->db->get_where('transport_category', array('transport_category_id' => $param1))->row()->name);
            $page_data['page_name']                 =   'transports';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to custom invoice items
    public function custom_invoice_items($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'custom_invoice_items'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_custom_invoice_item();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_custom_invoice_item($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_custom_invoice_item($param2);
            }

            $page_data['page_title']    =   'Custom Invoice Items';
            $page_data['page_name']     =   'custom_invoice_items';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to Department
    public function departments($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'departments'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_department();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_department($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_department($param2);
            }

            $page_data['page_title']    =   'Departments';
            $page_data['page_name']     =   'departments';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to settings
    public function settings($param = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'settings'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param == 'system') {
                $this->medical_model->update_system_setting();
            } elseif ($param == 'login_bg') {
                $this->medical_model->update_login_bg();
            } elseif ($param == 'favicon') {
                $this->medical_model->update_favicon();
            } elseif ($param == 'meal') {
                $this->medical_model->update_meal_plan_price();
            }

            $page_data['page_title']    =   'Settings';
            $page_data['page_name']     =   'settings';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to payroll
    public function payroll($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'payroll'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_payroll();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_payroll($param2);
            } elseif ($param1 == 'update_status') {
                $this->medical_model->update_payroll_status($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_payroll($param2);
            }

            if ($this->input->post('year', TRUE) && $this->input->post('month', TRUE)) {
                $page_data['year']              =   $this->input->post('year', TRUE);
                $page_data['month']             =   $this->input->post('month', TRUE);
                $page_data['payroll_details']   =   $this->security->xss_clean($this->db->get_where('payroll', array('month' => $page_data['month'], 'year' => $page_data['year']))->result_array());
            } else {
                $page_data['year']              =   '';
                $page_data['month']             =   '';
                $page_data['payroll_details']   =   $this->security->xss_clean($this->db->get('payroll')->result_array());
            }

            $page_data['page_title']    =   'Payroll';
            $page_data['page_name']     =   'payroll';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to revenue
    public function revenue()
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'revenue'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($this->input->post('year', TRUE) && $this->input->post('month', TRUE)) {
                $page_data['year']              =   $this->input->post('year', TRUE);
                $page_data['month']             =   $this->input->post('month', TRUE);
                $page_data['revenue_details']   =   $this->medical_model->read_revenue($page_data['year'], $page_data['month']);
            } else {
                $page_data['year']              =   '';
                $page_data['month']             =   '';
                $page_data['revenue_details']   =   $this->medical_model->read_revenue($page_data['year'], $page_data['month']);
            }

            $page_data['page_title']    =   'Revenue';
            $page_data['page_name']     =   'revenue';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to inventory
    public function inventory($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'inventory'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_inventory();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_inventory($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_inventory($param2);
            }

            $page_data['page_title']    =   'Inventory';
            $page_data['page_name']     =   'inventory';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to expenses
    public function expenses($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'expenses'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_expense();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_expense($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_expense($param2);
            }

            $page_data['page_title']    =   'Expenses';
            $page_data['page_name']     =   'expenses';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to income statement
    public function income_statement()
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'income_statement'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($this->input->post('year', TRUE) && $this->input->post('month', TRUE)) {
                $page_data['year']              =   $this->input->post('year', TRUE);
                $page_data['month']             =   $this->input->post('month', TRUE);
                $page_data['revenue_details']   =   $this->medical_model->read_revenue($page_data['year'], $page_data['month']);
                $page_data['total_expense']     =   $this->medical_model->read_expense($page_data['year'], $page_data['month']);
            } else {
                $page_data['year']              =   '';
                $page_data['month']             =   '';
                $page_data['revenue_details']   =   $this->medical_model->read_revenue($page_data['year'], $page_data['month']);
                $page_data['total_expense']     =   $this->medical_model->read_expense($page_data['year'], $page_data['month']);
            }

            $page_data['page_title']    =   'Income Statement';
            $page_data['page_name']     =   'income_statement';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to blood requests
    public function blood_requests($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'blood_requests'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_blood_request();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_blood_request_details($param2);
            } elseif ($param1 == 'update_status') {
                $this->medical_model->update_blood_request_status($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_blood_request_details($param2);
            }

            $page_data['page_title']    =   'Blood Requests';
            $page_data['page_name']     =   'blood_requests';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to blood inventory
    public function blood_inventory($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'blood_inventory'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'update') {
                $this->medical_model->update_blood_inventory();
            } elseif ($param1 == 'update_group') {
                $this->medical_model->update_blood_group_inventory($param2);
            }

            $page_data['page_title']    =   'Blood Inventory';
            $page_data['page_name']     =   'blood_inventory';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to blood donors
    public function blood_donors($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'blood_donors'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_blood_donor();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_blood_donor_details($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_blood_donor_details($param2);
            }

            $page_data['page_title']    =   'Blood Donors';
            $page_data['page_name']     =   'blood_donors';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    function add_report_patient()
    {
        $page_data['page_title']    =   'Add Report Patient';
        $page_data['page_name']     =   'add_report_patient';
        $this->load->view('index', $page_data);
    }

    // Function related to reports
    public function reports($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'reports'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_report($param2);
            } elseif ($param1 == 'update') {
                $this->medical_model->update_report_details($param2);
            } elseif ($param1 == 'update_status') {
                $this->medical_model->update_report_status($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_report_details($param2);
            }

            $page_data['page_title']    =   'Reports';
            $page_data['page_name']     =   'reports';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to report categories
    public function report_categories($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'report_categories'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_report_category();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_report_category_details($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_report_category_details($param2);
            }

            $page_data['page_title']    =    'Report Categories';
            $page_data['page_name']     =    'report_categories';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to laboratories
    public function laboratories($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'laboratories'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_laboratory();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_laboratory_details($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_laboratory_details($param2);
            }

            $page_data['page_title']    =   'Laboratories';
            $page_data['page_name']     =   'laboratories';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to notices
    public function notices($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'notices'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_notice();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_notice_details($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_notice_details($param2);
            }

            $page_data['page_title']    =   'Notices';
            $page_data['page_name']     =   'notices';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to feedback and ratings
    public function feedback_and_ratings($param1 = '', $param2 = '', $param3 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'feedback_and_ratings'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'feedback') {
                if ($param2 == 'create') {
                    $this->medical_model->create_feedback();
                } elseif ($param2 == 'update') {
                    $this->medical_model->update_feedback_details($param3);
                } elseif ($param2 == 'delete') {
                    $this->medical_model->delete_feedback_details($param3);
                }
            } elseif ($param1 == 'ratings') {
                if ($param2 == 'create') {
                    $this->medical_model->create_rating();
                } elseif ($param2 == 'update') {
                    $this->medical_model->update_rating_details($param3);
                } elseif ($param2 == 'delete') {
                    $this->medical_model->delete_rating_details($param3);
                }
            }

            $page_data['page_title']    =   'Feedback &amp; Ratings';
            $page_data['page_name']     =   'feedback_and_ratings';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to Birth and Death certificates
    public function certificates($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'certificates'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_certicate($param2);
            } elseif ($param1 == 'update') {
                $this->medical_model->update_certificate_details($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_certificate_details($param2);
            }

            $page_data['page_title']    =   'Certificates';
            $page_data['page_name']     =   'certificates';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to medicines
    public function medicines($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'medicines'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_medicine();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_medicine_details($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_medicine_details($param2);
            }

            $page_data['page_title']    =   'Medicines';
            $page_data['page_name']     =   'medicines';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to diseases
    public function diseases($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'diseases'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_disease();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_disease_details($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_disease_details($param2);
            }

            $page_data['page_title']    =   'Diseases';
            $page_data['page_name']     =   'diseases';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to staff roster
    public function rosters($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'rosters'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_roster();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_roster_details($param2);
            } elseif ($param1 == 'update_status') {
                $this->medical_model->update_roster_status($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_roster_details($param2);
            }

            $page_data['page_title']    =   'Rosters';
            $page_data['page_name']     =   'rosters';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to individual workload
    public function individual_workload()
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'rosters'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($this->input->post('user_id', TRUE)) {
                $page_data['staff_duties']  =   $this->medical_model->read_staff_duties($this->input->post('user_id', TRUE));
                $page_data['user_id']       =   $this->input->post('user_id', TRUE);
            } else {
                $page_data['staff_duties']  =   [];
                $page_data['user_id']       =   '';
            }

            $page_data['page_title']    =   'Individual Workload';
            $page_data['page_name']     =   'individual_workload';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to shift categories
    public function shift_categories($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'shift_categories'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_shift_category();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_shift_category($param2);
            } elseif ($param1 == 'update_permission') {
                $this->medical_model->update_shift_permission($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_shift_category($param2);
            }

            $page_data['page_title']    =   'Shift categories';
            $page_data['page_name']     =   'shift_categories';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to shifts
    public function shifts($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'shifts'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_shift($param2);
            } elseif ($param1 == 'update') {
                $this->medical_model->update_shift_details($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_shift_details($param2);
            }

            $page_data['staff_category_id']     =   $param1;

            $page_data['page_title']            =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $param1))->row()->name);
            $page_data['page_name']             =   'shifts';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to custom invoice items
    public function invoice_requests($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'invoice_requests'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_custom_invoice_request();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_custom_invoice_request($param2);
            } elseif ($param1 == 'update_occurance') {
                $this->medical_model->update_invoice_request_occurance($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_custom_invoice_request($param2);
            }

            $page_data['page_title']    =   'Invoice Requests';
            $page_data['page_name']     =   'invoice_requests';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    public function read_invoice_request($param = '')
    {
        $invoice_requests = $this->medical_model->read_invoice_request($param);

        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');

        echo $invoice_requests;
    }

    // Function related to invoices
    public function invoices($param1 = '', $param2 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'invoices'))->row()->module_id), $this->session->userdata('permissions'))) {
            if ($param1 == 'create') {
                $this->medical_model->create_invoice();
            } elseif ($param1 == 'update') {
                $this->medical_model->update_invoice($param2);
            } elseif ($param1 == 'delete') {
                $this->medical_model->delete_invoice($param2);
            }

            $page_data['page_title']    =   'Invoices';
            $page_data['page_name']     =   'invoices';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Function related to invoice
    public function invoice($param = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if (in_array($this->security->xss_clean($this->db->get_where('module', array('name' => 'invoices'))->row()->module_id), $this->session->userdata('permissions'))) {
            $page_data['invoice_id']    =   $param;
            $page_data['page_title']    =   'Invoice';
            $page_data['page_name']     =   'invoice';
            $this->load->view('index', $page_data);
        } else {
            redirect(base_url() . 'notfound', 'refresh');
        }
    }

    // Profile Settings
    public function profile_settings($param1 = '', $param2 = '', $param3 = '')
    {
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'login');
        }

        if ($param1 == 'update') {
            $this->medical_model->update_profile_settings($param2, $param3);
        } elseif ($param1 == 'update_image') {
            $this->medical_model->update_profile_image($param2);
        }

        $page_data['page_title']    =    'Profile Settings';
        $page_data['page_name']     =    'profile_settings';
        $this->load->view('index', $page_data);
    }
}
