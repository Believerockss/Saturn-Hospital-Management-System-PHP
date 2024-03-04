<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Medical_model extends CI_Model
{
    // Creating occupancy
    public function create_occupancy()
    {
        $accommodation_and_category_id      =   $this->input->post('accommodation_and_category_id', TRUE);

        $accommodation_id                   =   explode(" ", $accommodation_and_category_id)[0];
        $accommodation_category_id          =   explode(" ", $accommodation_and_category_id)[1];

        $data['occupancy_id']               =   $this->uuid->v4();
        $data['patient_id']                 =   $this->input->post('patient_id', TRUE);
        $data['accommodation_id']           =   $accommodation_id;
        $data['accommodation_category_id']  =   $accommodation_category_id;
        $data['doctor_id']                  =   $this->input->post('doctor_id', TRUE);
        $data['status']                     =   1;
        $data['reason']                     =   $this->input->post('reason', TRUE);
        $data['extra_note']                 =   $this->input->post('extra_note', TRUE);
        $data['created_on']                 =   time();
        $data['created_by']                 =   $this->session->userdata('user_id');
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->insert('occupancy', $data);

        $accommodation_type                 =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $accommodation_category_id))->row()->accommodation_type);

        if ($accommodation_type == 1) {
            $data2['status']                =   1;
            $data2['timestamp']             =   time();
            $data2['updated_by']            =   $this->session->userdata('user_id');

            $this->db->where('bed_id', $accommodation_id);
            $this->db->update('bed', $data2);
        } else {
            $data2['status']                =   1;
            $data2['timestamp']             =   time();
            $data2['updated_by']            =   $this->session->userdata('user_id');

            $this->db->where('accommodation_id', $accommodation_id);
            $this->db->update('accommodation', $data2);
        }

        $this->db->where('patient_id', $data['patient_id']);
        $this->db->update('patient', $data2);

        $invoice_request_data['table_name']     =   'occupancy';
        $invoice_request_data['table_row_id']   =   $data['occupancy_id'];

        $occupancy_rent = 0;
        $accommodation_category_name = '';
        $accommodation_name = '';
        $accommodation_type    =    $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $data['accommodation_category_id']))->row()->accommodation_type);
        if ($accommodation_type == 1) {
            $occupancy_rent                 =   $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $data['accommodation_id']))->row()->rent);
            $root_accommodation_category_id =   $this->security->xss_clean($this->db->get_where('bed', array('accommodation_category_id' => $data['accommodation_category_id']))->row()->root_accommodation_category_id);
            $accommodation_category_name    =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $root_accommodation_category_id))->row()->name);
            $accommodation_id               =   $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $data['accommodation_id']))->row()->accommodation_id);
            $accommodation_name             =   'Bed ' . $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $data['accommodation_id']))->row()->bed_number) . ' of Room ' . $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $accommodation_id))->row()->room_number);
        } else {
            $occupancy_rent                 =   $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $data['accommodation_id']))->row()->rent);
            $accommodation_category_name    =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $data['accommodation_category_id']))->row()->name);
            $accommodation_name             =   'Room ' . $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $data['accommodation_id']))->row()->room_number);
        }

        $invoice_request_data['amount']         =   $occupancy_rent;
        $invoice_request_data['content']        =   'Occupancy: Accommodation category - ' . $accommodation_category_name . ', Accommodation - ' . $accommodation_name;
        $invoice_request_data['status']         =   0;
        $invoice_request_data['patient_id']     =   $data['patient_id'];
        $invoice_request_data['item']           =   'Occupancy';
        $invoice_request_data['quantity']       =   1;

        $this->create_invoice_request($invoice_request_data);

        $this->session->set_flashdata('success', 'Occupancy has been created successfully');

        redirect(base_url() . 'occupancies', 'refresh');
    }

    // Updating occupancy
    public function update_occupancy_details($param = '')
    {
        $database_accommodation_id          =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $param))->row()->accommodation_id);
        $database_accommodation_category_id =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $param))->row()->accommodation_category_id);

        $database_patient_id                =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $param))->row()->patient_id);

        $accommodation_and_category_id      =   $this->input->post('accommodation_and_category_id', TRUE);

        $accommodation_id                   =   explode(" ", $accommodation_and_category_id)[0];
        $accommodation_category_id          =   explode(" ", $accommodation_and_category_id)[1];

        // In case accommodation is changed
        if ($database_accommodation_id != $accommodation_id || $database_accommodation_category_id != $accommodation_category_id) {
            $database_accommodation_type    =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $database_accommodation_category_id))->row()->accommodation_type);

            if ($database_accommodation_type == 1) {
                $data3['status']            =   0;
                $data3['timestamp']         =   time();
                $data3['updated_by']        =   $this->session->userdata('user_id');

                $this->db->where('bed_id', $database_accommodation_id);
                $this->db->update('bed', $data3);
            } else {
                $data3['status']            =   0;
                $data3['timestamp']         =   time();
                $data3['updated_by']        =   $this->session->userdata('user_id');

                $this->db->where('accommodation_id', $database_accommodation_id);
                $this->db->update('accommodation', $data3);
            }
        }

        // In case patient is changed
        if ($database_patient_id != $this->input->post('patient_id', TRUE)) {
            $data3['status']                =   0;
            $data3['timestamp']             =   time();
            $data3['updated_by']            =   $this->session->userdata('user_id');

            $this->db->where('patient_id', $database_patient_id);
            $this->db->update('patient', $data3);
        }

        $data['patient_id']                 =   $this->input->post('patient_id', TRUE);
        $data['accommodation_id']           =   $accommodation_id;
        $data['accommodation_category_id']  =   $accommodation_category_id;
        $data['doctor_id']                  =   $this->input->post('doctor_id', TRUE);
        $data['status']                     =   1;
        $data['reason']                     =   $this->input->post('reason', TRUE);
        $data['extra_note']                 =   $this->input->post('extra_note', TRUE);
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->where('occupancy_id', $param);
        $this->db->update('occupancy', $data);

        $accommodation_type                 =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $accommodation_category_id))->row()->accommodation_type);

        if ($accommodation_type == 1) {
            $data2['status']                =   1;
            $data2['timestamp']             =   time();
            $data2['updated_by']            =   $this->session->userdata('user_id');

            $this->db->where('bed_id', $accommodation_id);
            $this->db->update('bed', $data2);
        } else {
            $data2['status']                =   1;
            $data2['timestamp']             =   time();
            $data2['updated_by']            =   $this->session->userdata('user_id');

            $this->db->where('accommodation_id', $accommodation_id);
            $this->db->update('accommodation', $data2);
        }

        $this->db->where('patient_id', $data['patient_id']);
        $this->db->update('patient', $data2);

        if ($database_accommodation_id != $accommodation_id || $database_accommodation_category_id != $accommodation_category_id) {
            $occupancy_rent = 0;
            $accommodation_category_name = '';
            $accommodation_name = '';
            $accommodation_type    =    $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $data['accommodation_category_id']))->row()->accommodation_type);
            if ($accommodation_type == 1) {
                $occupancy_rent                 =   $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $data['accommodation_id']))->row()->rent);
                $root_accommodation_category_id =   $this->security->xss_clean($this->db->get_where('bed', array('accommodation_category_id' => $data['accommodation_category_id']))->row()->root_accommodation_category_id);
                $accommodation_category_name    =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $root_accommodation_category_id))->row()->name);
                $accommodation_id               =   $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $data['accommodation_id']))->row()->accommodation_id);
                $accommodation_name             =   'Bed ' . $this->security->xss_clean($this->db->get_where('bed', array('bed_id' => $data['accommodation_id']))->row()->bed_number) . ' of Room ' . $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $accommodation_id))->row()->room_number);
            } else {
                $occupancy_rent                 =   $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $data['accommodation_id']))->row()->rent);
                $accommodation_category_name    =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $data['accommodation_category_id']))->row()->name);
                $accommodation_name             =   'Room ' . $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $data['accommodation_id']))->row()->room_number);
            }

            $invoice_request_data['amount']         =   $occupancy_rent;
            $invoice_request_data['content']        =   'Occupancy: Accommodation category - ' . $accommodation_category_name . ', Accommodation - ' . $accommodation_name;
            $invoice_request_data['status']         =   0;
            $invoice_request_data['patient_id']     =   $data['patient_id'];
            $invoice_request_data['item']           =   'Occupancy';
            $invoice_request_data['quantity']       =   1;

            $this->create_invoice_request($invoice_request_data);
        }

        $this->session->set_flashdata('success', 'Occupancy has been updated successfully');

        redirect(base_url() . 'occupancies', 'refresh');
    }

    // Deleting occupancy
    public function delete_occupancy_details($param = '')
    {
        $patient_id                     =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $param))->row()->patient_id);
        $patient_status                 =   $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->status);

        if ($patient_status) {
            $data['status']             =   0;
            $data['timestamp']          =   time();
            $data['updated_by']         =   $this->session->userdata('user_id');

            $this->db->where('patient_id', $patient_id);
            $this->db->update('patient', $data);

            $accommodation_category_id  =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $param))->row()->accommodation_category_id);
            $accommodation_id           =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $param))->row()->accommodation_id);

            $accommodation_type         =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $accommodation_category_id))->row()->accommodation_type);

            if ($accommodation_type == 1) {
                $this->db->where('bed_id', $accommodation_id);
                $this->db->update('bed', $data);
            } else {
                $this->db->where('accommodation_id', $accommodation_id);
                $this->db->update('accommodation', $data);
            }
        }

        $this->db->where('occupancy_id', $param);
        $this->db->delete('occupancy');

        $this->session->set_flashdata('success', 'Occupancy has been removed successfully');

        redirect(base_url() . 'occupancies', 'refresh');
    }

    // Creating treatment
    public function create_treatment()
    {
        $medicine_ids_input                 =   $this->input->post('medicine_ids', TRUE);
        $doses_input                        =   $this->input->post('doses', TRUE);
        $medication_times_input             =   $this->input->post('medication_times', TRUE);

        $data['treatment_id']               =   $this->uuid->v4();
        $data['patient_id']                 =   $this->input->post('patient_id', TRUE);
        $data['disease_id']                 =   $this->input->post('disease_id', TRUE);
        $data['next_checkup']               =   strtotime($this->input->post('next_checkup', TRUE));
        $data['extra_note']                 =   $this->input->post('extra_note', TRUE);
        $data['symptoms']                   =   $this->input->post('symptoms', TRUE);
        $data['created_on']                 =   time();
        $data['created_by']                 =   $this->session->userdata('user_id');
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->insert('treatment', $data);

        foreach ($medicine_ids_input as $key => $value) {
            $treatment_details['treatment_details_id']  =   $this->uuid->v4();
            $treatment_details['medicine_id']           =   $value;
            $treatment_details['dose']                  =   $doses_input[$key];
            $treatment_details['medication_time']       =   $medication_times_input[$key];
            $treatment_details['treatment_id']          =   $data['treatment_id'];
            $treatment_details['timestamp']             =   time();

            $this->db->insert('treatment_details', $treatment_details);
        }

        $this->session->set_flashdata('success', 'Treatment has been created successfully');

        redirect(base_url() . 'treatments', 'refresh');
    }

    // Updating treatment details
    public function update_treatment_details($param = '')
    {
        $medicine_ids_input                 =   $this->input->post('medicine_ids', TRUE);
        $doses_input                        =   $this->input->post('doses', TRUE);
        $medication_times_input             =   $this->input->post('medication_times', TRUE);

        $data['patient_id']                 =   $this->input->post('patient_id', TRUE);
        $data['disease_id']                 =   $this->input->post('disease_id', TRUE);
        $data['next_checkup']               =   strtotime($this->input->post('next_checkup', TRUE));
        $data['extra_note']                 =   $this->input->post('extra_note', TRUE);
        $data['symptoms']                   =   $this->input->post('symptoms', TRUE);
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->where('treatment_id', $param);
        $this->db->update('treatment', $data);

        $db_treatment_details               =   $this->security->xss_clean($this->db->get_where('treatment_details', array('treatment_id' => $param))->result_array());
        foreach ($db_treatment_details as $db_treatment_detail) {
            $this->db->where('treatment_details_id', $db_treatment_detail['treatment_details_id']);
            $this->db->delete('treatment_details');
        }

        foreach ($medicine_ids_input as $key => $value) {
            $treatment_details['treatment_details_id']  =   $this->uuid->v4();
            $treatment_details['medicine_id']           =   $value;
            $treatment_details['dose']                  =   $doses_input[$key];
            $treatment_details['medication_time']       =   $medication_times_input[$key];
            $treatment_details['treatment_id']          =   $param;
            $treatment_details['timestamp']             =   time();

            $this->db->insert('treatment_details', $treatment_details);
        }

        $this->session->set_flashdata('success', 'Treatment has been updated successfully');

        redirect(base_url() . 'treatments', 'refresh');
    }

    // Deleting treatment
    public function delete_treatment_details($param = '')
    {
        $treatment_details = $this->security->xss_clean($this->db->get_where('treatment_details', array('treatment_id' => $param))->result_array());

        foreach ($treatment_details as $treatment_details_row) {
            $this->db->where('treatment_details_id', $treatment_details_row['treatment_details_id']);
            $this->db->delete('treatment_details');
        }

        $this->db->where('treatment_id', $param);
        $this->db->delete('treatment');

        $this->session->set_flashdata('success', 'Treatment has been removed successfully');

        redirect(base_url() . 'treatments', 'refresh');
    }

    // Creating discharge
    public function create_discharge()
    {
        $medicine_ids_input                 =   $this->input->post('medicine_ids', TRUE);
        $doses_input                        =   $this->input->post('doses', TRUE);
        $medication_times_input             =   $this->input->post('medication_times', TRUE);

        $data['discharge_id']               =   $this->uuid->v4();
        $data['doctor_id']                  =   $this->input->post('doctor_id', TRUE);
        $data['occupancy_id']               =   $this->input->post('occupancy_id', TRUE);
        $data['next_appointment']           =   $this->input->post('next_appointment') ? strtotime($this->input->post('next_appointment', TRUE)) : 0;
        $data['instructions']               =   $this->input->post('instructions', TRUE);
        $data['conditions']                 =   $this->input->post('conditions', TRUE);
        $data['created_on']                 =   time();
        $data['created_by']                 =   $this->session->userdata('user_id');
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->insert('discharge', $data);

        foreach ($medicine_ids_input as $key => $value) {
            $discharge_details['discharge_details_id']  =   $this->uuid->v4();
            $discharge_details['medicine_id']           =   $value;
            $discharge_details['dose']                  =   $doses_input[$key];
            $discharge_details['medication_time']       =   $medication_times_input[$key];
            $discharge_details['discharge_id']          =   $data['discharge_id'];
            $discharge_details['timestamp']             =   time();

            $this->db->insert('discharge_details', $discharge_details);
        }

        $status_data['status']              =   0;
        $status_data['timestamp']           =   time();
        $status_data['updated_by']          =   $this->session->userdata('user_id');

        $this->db->where('occupancy_id', $data['occupancy_id']);
        $this->db->update('occupancy', $status_data);

        $accommodation_category_id          =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $data['occupancy_id']))->row()->accommodation_category_id);
        $accommodation_type                 =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $accommodation_category_id))->row()->accommodation_type);
        $accommodation_id                   =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $data['occupancy_id']))->row()->accommodation_id);

        if ($accommodation_type == 1) {
            $this->db->where('bed_id', $accommodation_id);
            $this->db->update('bed', $status_data);
        } elseif ($accommodation_type == 0) {
            $this->db->where('accommodation_id', $accommodation_id);
            $this->db->update('accommodation', $status_data);
        }

        $this->db->where('patient_id', $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $data['occupancy_id']))->row()->patient_id));
        $this->db->update('patient', $status_data);

        $this->session->set_flashdata('success', 'Discharge has been created successfully');

        redirect(base_url() . 'discharges', 'refresh');
    }

    // Updating discharge details
    public function update_discharge_details($param = '')
    {
        $old_occupancy_id                   =    $this->security->xss_clean($this->db->get_where('discharge', array('discharge_id' => $param))->row()->occupancy_id);

        $medicine_ids_input                 =   $this->input->post('medicine_ids', TRUE);
        $doses_input                        =   $this->input->post('doses', TRUE);
        $medication_times_input             =   $this->input->post('medication_times', TRUE);

        $data['doctor_id']                  =   $this->input->post('doctor_id', TRUE);
        $data['occupancy_id']               =   $this->input->post('occupancy_id', TRUE);
        $data['next_appointment']           =   strtotime($this->input->post('next_appointment', TRUE));
        $data['instructions']               =   $this->input->post('instructions', TRUE);
        $data['conditions']                 =   $this->input->post('conditions', TRUE);
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->where('discharge_id', $param);
        $this->db->update('discharge', $data);

        $db_discharge_details               =   $this->security->xss_clean($this->db->get_where('discharge_details', array('discharge_id' => $param))->result_array());
        foreach ($db_discharge_details as $db_discharge_detail) {
            $this->db->where('discharge_details_id', $db_discharge_detail['discharge_details_id']);
            $this->db->delete('discharge_details');
        }

        foreach ($medicine_ids_input as $key => $value) {
            $discharge_details['discharge_details_id']  =   $this->uuid->v4();
            $discharge_details['medicine_id']           =   $value;
            $discharge_details['dose']                  =   $doses_input[$key];
            $discharge_details['medication_time']       =   $medication_times_input[$key];
            $discharge_details['discharge_id']          =   $param;
            $discharge_details['timestamp']             =   time();

            $this->db->insert('discharge_details', $discharge_details);
        }

        if ($old_occupancy_id != $data['occupancy_id']) {
            $data2['status']                =   0;
            $data2['timestamp']             =   time();
            $data2['updated_by']            =   $this->session->userdata('user_id');

            $this->db->where('occupancy_id', $data['occupancy_id']);
            $this->db->update('occupancy', $data2);

            $accommodation_category_id      =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $data['occupancy_id']))->row()->accommodation_category_id);
            $accommodation_type             =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $accommodation_category_id))->row()->accommodation_type);
            $accommodation_id               =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $data['occupancy_id']))->row()->accommodation_id);

            if ($accommodation_type == 1) {
                $this->db->where('bed_id', $accommodation_id);
                $this->db->update('bed', $data2);
            } elseif ($accommodation_type == 0) {
                $this->db->where('accommodation_id', $accommodation_id);
                $this->db->update('accommodation', $data2);
            }

            $data3['status']                =   1;
            $data3['timestamp']             =   time();
            $data3['updated_by']            =   $this->session->userdata('user_id');

            $this->db->where('occupancy_id', $old_occupancy_id);
            $this->db->update('occupancy', $data3);

            $old_accommodation_category_id  =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $old_occupancy_id))->row()->accommodation_category_id);
            $old_accommodation_type         =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $old_accommodation_category_id))->row()->accommodation_type);
            $old_accommodation_id           =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $old_occupancy_id))->row()->accommodation_id);

            if ($old_accommodation_type == 1) {
                $this->db->where('bed_id', $old_accommodation_id);
                $this->db->update('bed', $data3);
            } elseif ($old_accommodation_type == 0) {
                $this->db->where('accommodation_id', $old_accommodation_id);
                $this->db->update('accommodation', $data3);
            }
        }

        $this->session->set_flashdata('success', 'Discharge has been updated successfully');

        redirect(base_url() . 'discharges', 'refresh');
    }

    // Deleting discharge
    public function delete_discharge_details($param = '')
    {
        $occupancy_id                   =   $this->security->xss_clean($this->db->get_where('discharge', array('discharge_id' => $param))->row()->occupancy_id);

        $patient_id                     =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $occupancy_id))->row()->patient_id);
        $patient_status                 =   $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->status);

        if ($patient_status) {
            $data['status']             =   0;
            $data['timestamp']          =   time();
            $data['updated_by']         =   $this->session->userdata('user_id');

            $this->db->where('patient_id', $patient_id);
            $this->db->update('patient', $data);

            $accommodation_category_id  =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $occupancy_id))->row()->accommodation_category_id);
            $accommodation_id           =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $occupancy_id))->row()->accommodation_id);

            $accommodation_type         =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $accommodation_category_id))->row()->accommodation_type);

            if ($accommodation_type == 1) {
                $this->db->where('bed_id', $accommodation_id);
                $this->db->update('bed', $data);
            } else {
                $this->db->where('accommodation_id', $accommodation_id);
                $this->db->update('accommodation', $data);
            }
        }

        $discharge_details = $this->security->xss_clean($this->db->get_where('discharge_details', array('discharge_id' => $param))->result_array());

        foreach ($discharge_details as $discharge_details_row) {
            $this->db->where('discharge_details_id', $discharge_details_row['discharge_details_id']);
            $this->db->delete('discharge_details');
        }

        $this->db->where('discharge_id', $param);
        $this->db->delete('discharge');

        $this->session->set_flashdata('success', 'Discharge has been removed successfully');

        redirect(base_url() . 'discharges', 'refresh');
    }

    // Creating patient meal
    public function create_patient_meal()
    {
        $data['patient_meal_id']            =   $this->uuid->v4();
        $data['doctor_id']                  =   $this->input->post('doctor_id', TRUE);
        $data['occupancy_id']               =   $this->input->post('occupancy_id', TRUE);
        $data['breakfast']                  =   $this->input->post('breakfast', TRUE);
        $data['milk_break']                 =   $this->input->post('milk_break', TRUE);
        $data['lunch']                      =   $this->input->post('lunch', TRUE);
        $data['tea_break']                  =   $this->input->post('tea_break', TRUE);
        $data['dinner']                     =   $this->input->post('dinner', TRUE);
        $data['extra_note']                 =   $this->input->post('extra_note', TRUE);
        $data['created_on']                 =   time();
        $data['created_by']                 =   $this->session->userdata('user_id');
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->insert('patient_meal', $data);

        $meal_price_total                       =   0;
        foreach ($this->security->xss_clean($this->db->get_where('setting', array('tag' => 'meal'))->result_array()) as $row) {
            $meal_price_total                   +=  $row['content'];
        }

        $invoice_request_data['table_name']     =   'patient_meal';
        $invoice_request_data['table_row_id']   =   $data['patient_meal_id'];
        $invoice_request_data['amount']         =   $meal_price_total;
        $invoice_request_data['content']        =   'Patient meals for breakfast, milk break, lunch, tea break & dinner';
        $invoice_request_data['status']         =   0;
        $invoice_request_data['patient_id']     =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $data['occupancy_id']))->row()->patient_id);
        $invoice_request_data['item']           =   'Patient Meal';
        $invoice_request_data['quantity']       =   1;

        $this->create_invoice_request($invoice_request_data);

        $this->session->set_flashdata('success', 'Patient Meal has been created successfully');

        redirect(base_url() . 'patient_meals', 'refresh');
    }

    // Updating patient meal details
    public function update_patient_meal_details($param = '')
    {
        $data['doctor_id']                  =   $this->input->post('doctor_id', TRUE);
        $data['occupancy_id']               =   $this->input->post('occupancy_id', TRUE);
        $data['breakfast']                  =   $this->input->post('breakfast', TRUE);
        $data['milk_break']                 =   $this->input->post('milk_break', TRUE);
        $data['lunch']                      =   $this->input->post('lunch', TRUE);
        $data['tea_break']                  =   $this->input->post('tea_break', TRUE);
        $data['dinner']                     =   $this->input->post('dinner', TRUE);
        $data['extra_note']                 =   $this->input->post('extra_note', TRUE);
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->where('patient_meal_id', $param);
        $this->db->update('patient_meal', $data);

        $this->session->set_flashdata('success', 'Patient Meal has been updated successfully');

        redirect(base_url() . 'patient_meals', 'refresh');
    }

    // Deleting patient meal
    public function delete_patient_meal_details($param = '')
    {
        $invoice_request_id                     =   $this->security->xss_clean($this->db->get_where('invoice_request', array('table_name' => 'patient_meal', 'table_row_id' => $param))->row()->invoice_request_id);

        $this->db->where('invoice_request_id', $invoice_request_id);
        $this->db->delete('invoice_request');

        $this->db->where('patient_meal_id', $param);
        $this->db->delete('patient_meal');

        $this->session->set_flashdata('success', 'Patient meal has been removed successfully');

        redirect(base_url() . 'patient_meals', 'refresh');
    }

    // Creating transport service
    public function create_transport_service()
    {
        $data['transport_service_id']       =   $this->uuid->v4();
        $data['patient_id']                 =   $this->input->post('patient_id', TRUE);
        $data['transport_id']               =   $this->input->post('transport_id', TRUE);
        $data['transport_category_id']      =   $this->security->xss_clean($this->db->get_where('transport', array('transport_id' => $data['transport_id']))->row()->transport_category_id);
        $data['cost']                       =   $this->security->xss_clean($this->db->get_where('transport_category', array('transport_category_id' => $data['transport_category_id']))->row()->cost);
        $data['created_on']                 =   time();
        $data['created_by']                 =   $this->session->userdata('user_id');
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->insert('transport_service', $data);

        $invoice_request_data['table_name']     =   'transport_service';
        $invoice_request_data['table_row_id']   =   $data['transport_service_id'];
        $invoice_request_data['amount']         =   $data['cost'];
        $invoice_request_data['content']        =   'Transport Service has been taken; Transport number: ' . $this->security->xss_clean($this->db->get_where('transport', array('transport_id' => $data['transport_id']))->row()->transport_number) . ' from this Transport Category: ' . $this->security->xss_clean($this->db->get_where('transport_category', array('transport_category_id' => $data['transport_category_id']))->row()->name);
        $invoice_request_data['status']         =   0;
        $invoice_request_data['patient_id']     =   $data['patient_id'];
        $invoice_request_data['item']           =   'Transport Service';
        $invoice_request_data['quantity']       =   1;

        $this->create_invoice_request($invoice_request_data);

        $this->session->set_flashdata('success', 'Transport Service has been created successfully');

        redirect(base_url() . 'transport_services', 'refresh');
    }

    // Creating transport service
    public function update_transport_service_details($param = '')
    {
        $data['patient_id']                 =   $this->input->post('patient_id', TRUE);
        $data['transport_id']               =   $this->input->post('transport_id', TRUE);
        $data['transport_category_id']      =   $this->security->xss_clean($this->db->get_where('transport', array('transport_id' => $data['transport_id']))->row()->transport_category_id);
        $data['cost']                       =   $this->security->xss_clean($this->db->get_where('transport_category', array('transport_category_id' => $data['transport_category_id']))->row()->cost);
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->where('transport_service_id', $param);
        $this->db->update('transport_service', $data);

        $invoice_request_data['table_name']     =   'transport_service';
        $invoice_request_data['table_row_id']   =   $param;
        $invoice_request_data['amount']         =   $data['cost'];
        $invoice_request_data['content']        =   'Transport Service has been taken; Transport number: ' . $this->security->xss_clean($this->db->get_where('transport', array('transport_id' => $data['transport_id']))->row()->transport_number) . ' from this Transport Category: ' . $this->security->xss_clean($this->db->get_where('transport_category', array('transport_category_id' => $data['transport_category_id']))->row()->name);
        $invoice_request_data['patient_id']     =   $data['patient_id'];
        $invoice_request_data['item']           =   'Transport Service';
        $invoice_request_data['quantity']       =   1;

        $this->update_invoice_request($invoice_request_data);

        $this->session->set_flashdata('success', 'Transport Service has been updated successfully');

        redirect(base_url() . 'transport_services', 'refresh');
    }

    // Deleting transport services
    public function delete_transport_service_details($param = '')
    {
        $invoice_request_id                     =   $this->security->xss_clean($this->db->get_where('invoice_request', array('table_name' => 'transport_service', 'table_row_id' => $param))->row()->invoice_request_id);

        $this->db->where('invoice_request_id', $invoice_request_id);
        $this->db->delete('invoice_request');

        $this->db->where('transport_service_id', $param);
        $this->db->delete('transport_service');

        $this->session->set_flashdata('success', 'Transport Service has been removed successfully');

        redirect(base_url() . 'transport_services', 'refresh');
    }

    // Creating appointment
    public function create_appointment()
    {
        $data['appointment_id']             =   $this->uuid->v4();
        $data['doctor_id']                  =   $this->input->post('doctor_id', TRUE);
        $data['patient_id']                 =   $this->input->post('patient_id', TRUE);
        $data['appointment_date']           =   strtotime($this->input->post('appointment_date', TRUE));
        $data['appointment_time']           =   $this->input->post('appointment_time', TRUE);
        $data['status']                     =   0;
        $data['created_on']                 =   time();
        $data['created_by']                 =   $this->session->userdata('user_id');
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->insert('appointment', $data);

        $staff_category_id                  =   $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $data['doctor_id']))->row()->staff_category_id);
        $payment_type                       =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $staff_category_id))->row()->payment_type);

        if ($payment_type == 2) {
            $invoice_request_data['table_name']     =   'appointment';
            $invoice_request_data['table_row_id']   =   $data['appointment_id'];
            $invoice_request_data['amount']         =   $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $data['doctor_id']))->row()->appointment_fee);
            $invoice_request_data['content']        =   'Appointment with ' . $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $data['doctor_id']))->row()->designation) . ' ' . $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $data['doctor_id']))->row()->name) . ' at ' . $data['appointment_time'] . ' on ' . date('d M, Y', $data['appointment_date']);
            $invoice_request_data['status']         =   0;
            $invoice_request_data['patient_id']     =   $data['patient_id'];
            $invoice_request_data['item']           =   'Appointment';
            $invoice_request_data['quantity']       =   1;

            $this->create_invoice_request($invoice_request_data);
        }

        $this->session->set_flashdata('success', 'Appointment has been created successfully');

        redirect(base_url() . 'appointments', 'refresh');
    }

    // Updating appointment details
    public function update_appointment_details($param = '')
    {
        $data['doctor_id']                  =   $this->input->post('doctor_id', TRUE);
        $data['patient_id']                 =   $this->input->post('patient_id', TRUE);
        $data['appointment_date']           =   strtotime($this->input->post('appointment_date', TRUE));
        $data['appointment_time']           =   $this->input->post('appointment_time', TRUE);
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->where('appointment_id', $param);
        $this->db->update('appointment', $data);

        $staff_category_id                  =   $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $data['doctor_id']))->row()->staff_category_id);
        $payment_type                       =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $staff_category_id))->row()->payment_type);

        if ($payment_type == 2) {
            $invoice_request_data['table_name']     =   'appointment';
            $invoice_request_data['table_row_id']   =   $param;
            $invoice_request_data['amount']         =   $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $data['doctor_id']))->row()->appointment_fee);
            $invoice_request_data['content']        =   'Appointment with ' . $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $data['doctor_id']))->row()->designation) . ' ' . $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $data['doctor_id']))->row()->name) . ' at ' . $data['appointment_time'] . ' on ' . date('d M, Y', $data['appointment_date']);
            $invoice_request_data['patient_id']     =   $data['patient_id'];
            $invoice_request_data['item']           =   'Appointment';
            $invoice_request_data['quantity']       =   1;

            $this->update_invoice_request($invoice_request_data);
        }

        $this->session->set_flashdata('success', 'Appointment details has been updated successfully');

        redirect(base_url() . 'appointments', 'refresh');
    }

    // Updating appointment status
    public function update_appointment_status($param = '')
    {
        $data['status']                     =   $this->input->post('status', TRUE);
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->where('appointment_id', $param);
        $this->db->update('appointment', $data);

        $this->session->set_flashdata('success', 'Appointment status has been updated successfully');

        redirect(base_url() . 'appointments', 'refresh');
    }

    // Deleting appointmenet
    public function delete_appointment_details($param = '')
    {
        $invoice_request_id                 =   $this->security->xss_clean($this->db->get_where('invoice_request', array('table_name' => 'appointment', 'table_row_id' => $param))->row()->invoice_request_id);

        $this->db->where('invoice_request_id', $invoice_request_id);
        $this->db->delete('invoice_request');

        $this->db->where('appointment_id', $param);
        $this->db->delete('appointment');

        $this->session->set_flashdata('success', 'Appointment has been removed successfully');

        redirect(base_url() . 'appointments', 'refresh');
    }

    // Creating patient
    public function create_patient()
    {
        $data['patient_id']                 =   $this->uuid->v4();
        $data['pid']                        =   $this->input->post('pid', TRUE);
        $data['profession_id']              =   $this->input->post('profession_id', TRUE);
        
        $data['name']                       =   $this->input->post('name', TRUE);
        $data['email']                      =   $this->input->post('email', TRUE);
        $data['password']                   =   password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT);

        $data['mobile_number']              =   $this->input->post('mobile_number', TRUE);
        $data['address']                    =   $this->input->post('address_1', TRUE) . '<br>' . $this->input->post('address_2', TRUE);
        $data['age']                        =   $this->input->post('age', TRUE);
        $data['dob']                        =   strtotime($this->input->post('dob', TRUE));
        $data['sex_id']                     =   $this->input->post('sex_id', TRUE);
        $data['blood_inventory_id']         =   $this->input->post('blood_inventory_id', TRUE);
        $data['father_name']                =   $this->input->post('father_name', TRUE);
        $data['mother_name']                =   $this->input->post('mother_name', TRUE);
        $data['emergency_contact']          =   $this->input->post('emergency_contact', TRUE);
        $data['emergency_contact_number']   =   $this->input->post('emergency_contact_number', TRUE);
        $data['emergency_contact_relation'] =   $this->input->post('emergency_contact_relation', TRUE);
        $data['type']                       =   0;
        $data['status']                     =   1;
        $data['created_on']                 =   time();
        $data['created_by']                 =   $this->session->userdata('user_id');
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->insert('patient', $data);

        $this->session->set_flashdata('success', 'Patient has been created successfully');

        redirect(base_url() . 'patients', 'refresh');
    }

    // Updating patient
    public function update_patient_details($param = '')
    {
        $data['pid']                        =   $this->input->post('pid', TRUE);
        $data['profession_id']              =   $this->input->post('profession_id', TRUE);
        $data['name']                       =   $this->input->post('name', TRUE);
        $data['email']                      =   $this->input->post('email', TRUE);
        $data['mobile_number']              =   $this->input->post('mobile_number', TRUE);
        $data['address']                    =   $this->input->post('address_1', TRUE) . '<br>' . $this->input->post('address_2', TRUE);
        $data['age']                        =   $this->input->post('age', TRUE);
        $data['dob']                        =   strtotime($this->input->post('dob', TRUE));
        $data['sex_id']                     =   $this->input->post('sex_id', TRUE);
        $data['blood_inventory_id']         =   $this->input->post('blood_inventory_id', TRUE);
        $data['father_name']                =   $this->input->post('father_name', TRUE);
        $data['mother_name']                =   $this->input->post('mother_name', TRUE);
        $data['emergency_contact']          =   $this->input->post('emergency_contact', TRUE);
        $data['emergency_contact_number']   =   $this->input->post('emergency_contact_number', TRUE);
        $data['emergency_contact_relation'] =   $this->input->post('emergency_contact_relation', TRUE);
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->where('patient_id', $param);
        $this->db->update('patient', $data);

        $this->session->set_flashdata('success', 'Patient details has been updated successfully');

        redirect(base_url() . 'patients', 'refresh');
    }

    // Deleting patient
    public function delete_patient_details($param = '')
    {
        $patient_status                 =   $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $param))->row()->status);

        if ($patient_status) {
            $data['status']             =   0;
            $data['timestamp']          =   time();
            $data['updated_by']         =   $this->session->userdata('user_id');

            $accommodation_category_id  =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $param))->row()->accommodation_category_id);
            $accommodation_id           =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $param))->row()->accommodation_id);

            $accommodation_type         =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $accommodation_category_id))->row()->accommodation_type);

            if ($accommodation_type == 1) {
                $this->db->where('bed_id', $accommodation_id);
                $this->db->update('bed', $data);
            } else {
                $this->db->where('accommodation_id', $accommodation_id);
                $this->db->update('accommodation', $data);
            }
        }

        $this->db->where('patient_id', $param);
        $this->db->delete('patient');

        $this->session->set_flashdata('success', 'Patient has been removed successfully');

        redirect(base_url() . 'patients', 'refresh');
    }

    // Creating prescription
    public function create_prescription()
    {
        $medicine_ids_input                 =   $this->input->post('medicine_ids', TRUE);
        $doses_input                        =   $this->input->post('doses', TRUE);
        $medication_times_input             =   $this->input->post('medication_times', TRUE);

        $data['prescription_id']            =   $this->uuid->v4();
        $data['doctor_id']                  =   $this->session->userdata('user_id');
        $data['patient_id']                 =   $this->input->post('patient_id', TRUE);
        $data['disease_id']                 =   $this->input->post('disease_id', TRUE);
        $data['next_appointment']           =   strtotime($this->input->post('next_appointment', TRUE));
        $data['extra_note']                 =   $this->input->post('extra_note', TRUE);
        $data['symptoms']                   =   $this->input->post('symptoms', TRUE);
        $data['created_on']                 =   time();
        $data['created_by']                 =   $this->session->userdata('user_id');
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->insert('prescription', $data);

        foreach ($medicine_ids_input as $key => $value) {
            $prescription_details['prescription_details_id']    =   $this->uuid->v4();
            $prescription_details['medicine_id']                =   $value;
            $prescription_details['dose']                       =   $doses_input[$key];
            $prescription_details['medication_time']            =   $medication_times_input[$key];
            $prescription_details['prescription_id']            =   $data['prescription_id'];
            $prescription_details['timestamp']                  =   time();

            $this->db->insert('prescription_details', $prescription_details);
        }

        $this->session->set_flashdata('success', 'Prescription has been created successfully');

        redirect(base_url() . 'prescriptions', 'refresh');
    }

    // Updating prescription
    public function update_prescription_details($param = '')
    {
        $medicine_ids_input                 =   $this->input->post('medicine_ids', TRUE);
        $doses_input                        =   $this->input->post('doses', TRUE);
        $medication_times_input             =   $this->input->post('medication_times', TRUE);

        // $data['doctor_id']					=	$this->session->userdata('doctor_id');
        $data['patient_id']                 =   $this->input->post('patient_id', TRUE);
        $data['disease_id']                 =   $this->input->post('disease_id', TRUE);
        $data['next_appointment']           =   strtotime($this->input->post('next_appointment', TRUE));
        $data['extra_note']                 =   $this->input->post('extra_note', TRUE);
        $data['symptoms']                   =   $this->input->post('symptoms', TRUE);
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->where('prescription_id', $param);
        $this->db->update('prescription', $data);

        $db_prescription_details            =   $this->security->xss_clean($this->db->get_where('prescription_details', array('prescription_id' => $param))->result_array());
        foreach ($db_prescription_details as $db_treatment_detail) {
            $this->db->where('prescription_details_id', $db_treatment_detail['prescription_details_id']);
            $this->db->delete('prescription_details');
        }

        foreach ($medicine_ids_input as $key => $value) {
            $prescription_details['prescription_details_id']    =   $this->uuid->v4();
            $prescription_details['medicine_id']                =   $value;
            $prescription_details['dose']                       =   $doses_input[$key];
            $prescription_details['medication_time']            =   $medication_times_input[$key];
            $prescription_details['prescription_id']            =   $param;
            $prescription_details['timestamp']                  =   time();

            $this->db->insert('prescription_details', $prescription_details);
        }

        $this->session->set_flashdata('success', 'Prescription has been updated successfully');

        redirect(base_url() . 'prescriptions', 'refresh');
    }

    // Deleting prescription
    public function delete_prescription_details($param = '')
    {
        $prescription_details = $this->security->xss_clean($this->db->get_where('prescription_details', array('prescription_id' => $param))->result_array());

        foreach ($prescription_details as $prescription_details_row) {
            $this->db->where('prescription_details_id', $prescription_details_row['prescription_details_id']);
            $this->db->delete('prescription_details');
        }

        $this->db->where('prescription_id', $param);
        $this->db->delete('prescription');

        $this->session->set_flashdata('success', 'Prescription has been removed successfully');

        redirect(base_url() . 'prescriptions', 'refresh');
    }

    // Creating emergency rosters
    public function create_emergency_roster()
    {
        $data['roster_id']          =   $this->uuid->v4();
        $data['duty_on']            =   strtotime($this->input->post('duty_on', TRUE));
        $data['shift_id']           =   $this->input->post('shift_id', TRUE);
        $data['staff_id']           =   $this->input->post('staff_id', TRUE);
        $data['extra_note']         =   $this->input->post('extra_note', TRUE);
        $data['status']             =   0;
        $data['type']               =   1;
        $data['created_on']         =   time();
        $data['created_by']         =   $this->session->userdata('user_id');
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->insert('roster', $data);

        $this->session->set_flashdata('success', 'Emergency Roster has been created successfully');

        redirect(base_url() . 'emergency_rosters', 'refresh');
    }

    // Updating emergency roster details
    public function update_emergency_roster_details($param = '')
    {
        $data['duty_on']            =   strtotime($this->input->post('duty_on', TRUE));
        $data['shift_id']           =   $this->input->post('shift_id', TRUE);
        $data['staff_id']           =   $this->input->post('staff_id', TRUE);
        $data['extra_note']         =   $this->input->post('extra_note', TRUE);
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->where('roster_id', $param);
        $this->db->update('roster', $data);

        $this->session->set_flashdata('success', 'Details of the emergency roster has updated successfully');

        redirect(base_url() . 'emergency_rosters', 'refresh');
    }

    // Updating emergency roster status
    public function update_emergency_roster_status($param = '')
    {
        $data['status']             =   $this->input->post('status', TRUE);
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->where('roster_id', $param);
        $this->db->update('roster', $data);

        $this->session->set_flashdata('success', 'Details of the emergency roster has updated successfully');

        redirect(base_url() . 'emergency_rosters', 'refresh');
    }

    // Deleting roster
    public function delete_emergency_roster_details($param = '')
    {
        $this->db->where('roster_id', $param);
        $this->db->delete('roster');

        $this->session->set_flashdata('success', 'Emergency Roster has been removed successfully');

        redirect(base_url() . 'emergency_rosters', 'refresh');
    }

    // Creating emergency patient
    public function create_emergency_patient()
    {
        $data['patient_id']                 =   $this->uuid->v4();
        $data['pid']                        =   $this->input->post('pid', TRUE);
        $data['profession_id']              =   $this->input->post('profession_id', TRUE);
        $data['name']                       =   $this->input->post('name', TRUE);
        $data['email']                      =   $this->input->post('email', TRUE);
        $data['mobile_number']              =   $this->input->post('mobile_number', TRUE);
        $data['address']                    =   $this->input->post('address_1', TRUE) . '<br>' . $this->input->post('address_2', TRUE);
        $data['age']                        =   $this->input->post('age', TRUE);
        $data['dob']                        =   strtotime($this->input->post('dob', TRUE));
        $data['sex_id']                     =   $this->input->post('sex_id', TRUE);
        $data['blood_inventory_id']         =   $this->input->post('blood_inventory_id', TRUE);
        $data['father_name']                =   $this->input->post('father_name', TRUE);
        $data['mother_name']                =   $this->input->post('mother_name', TRUE);
        $data['emergency_contact']          =   $this->input->post('emergency_contact', TRUE);
        $data['emergency_contact_number']   =   $this->input->post('emergency_contact_number', TRUE);
        $data['emergency_contact_relation'] =   $this->input->post('emergency_contact_relation', TRUE);
        $data['type']                       =   1;
        $data['status']                     =   0;
        $data['created_on']                 =   time();
        $data['created_by']                 =   $this->session->userdata('user_id');
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->insert('patient', $data);

        $this->session->set_flashdata('success', 'Emergency Patient has been created successfully');

        redirect(base_url() . 'emergency_patients', 'refresh');
    }

    // Updating emergency patient
    public function update_emergency_patient_details($param = '')
    {
        $data['pid']                        =   $this->input->post('pid', TRUE);
        $data['profession_id']              =   $this->input->post('profession_id', TRUE);
        $data['name']                       =   $this->input->post('name', TRUE);
        $data['email']                      =   $this->input->post('email', TRUE);
        $data['mobile_number']              =   $this->input->post('mobile_number', TRUE);
        $data['address']                    =   $this->input->post('address_1', TRUE) . '<br>' . $this->input->post('address_2', TRUE);
        $data['age']                        =   $this->input->post('age', TRUE);
        $data['dob']                        =   strtotime($this->input->post('dob', TRUE));
        $data['sex_id']                     =   $this->input->post('sex_id', TRUE);
        $data['blood_inventory_id']         =   $this->input->post('blood_inventory_id', TRUE);
        $data['father_name']                =   $this->input->post('father_name', TRUE);
        $data['mother_name']                =   $this->input->post('mother_name', TRUE);
        $data['emergency_contact']          =   $this->input->post('emergency_contact', TRUE);
        $data['emergency_contact_number']   =   $this->input->post('emergency_contact_number', TRUE);
        $data['emergency_contact_relation'] =   $this->input->post('emergency_contact_relation', TRUE);
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->where('patient_id', $param);
        $this->db->update('patient', $data);

        $this->session->set_flashdata('success', 'Emergency Patient details has been updated successfully');

        redirect(base_url() . 'emergency_patients', 'refresh');
    }

    // Deleting emergency patient
    public function delete_emergency_patient_details($param = '')
    {
        $patient_status                 =   $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $param))->row()->status);

        if ($patient_status) {
            $data['status']             =   0;
            $data['timestamp']          =   time();
            $data['updated_by']         =   $this->session->userdata('user_id');

            $accommodation_category_id  =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $param))->row()->accommodation_category_id);
            $accommodation_id           =   $this->security->xss_clean($this->db->get_where('occupancy', array('occupancy_id' => $param))->row()->accommodation_id);

            $accommodation_type         =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $accommodation_category_id))->row()->accommodation_type);

            if ($accommodation_type == 1) {
                $this->db->where('bed_id', $accommodation_id);
                $this->db->update('bed', $data);
            } else {
                $this->db->where('accommodation_id', $accommodation_id);
                $this->db->update('accommodation', $data);
            }
        }

        $this->db->where('patient_id', $param);
        $this->db->delete('patient');

        $this->session->set_flashdata('success', 'Emergency Patient details has been removed successfully');

        redirect(base_url() . 'emergency_patients', 'refresh');
    }

    // Creating pharmacy inventory
    public function create_pharmacy_inventory()
    {
        $data['pharmacy_inventory_id']  =   $this->uuid->v4();
        $data['name']                   =   $this->input->post('name', TRUE);
        $data['code']                   =   $this->input->post('code', TRUE);
        $data['price']                  =   $this->input->post('price', TRUE);
        $data['quantity']               =   $this->input->post('quantity', TRUE);
        $data['unit_id']                =   $this->input->post('unit_id', TRUE);
        $data['created_on']             =   time();
        $data['created_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->insert('pharmacy_inventory', $data);

        $this->session->set_flashdata('success', 'Pharmacy inventory has been created successfully');

        redirect(base_url() . 'pharmacy_inventory', 'refresh');
    }

    // Updating pharmacy inventory details
    public function update_pharmacy_inventory_details($param = '')
    {
        $data['name']                   =   $this->input->post('name', TRUE);
        $data['code']                   =   $this->input->post('code', TRUE);
        $data['price']                  =   $this->input->post('price', TRUE);
        $data['unit_id']                =   $this->input->post('unit_id', TRUE);
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->where('pharmacy_inventory_id', $param);
        $this->db->update('pharmacy_inventory', $data);

        $this->session->set_flashdata('success', 'Pharmacy inventory details has been Updated successfully');

        redirect(base_url() . 'pharmacy_inventory', 'refresh');
    }

    // Updating pharmacy inventory
    public function update_pharmacy_inventory($param = '')
    {
        $operation                      =   $this->input->post('operation', TRUE);
        $current_quantity               =   $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $param))->row()->quantity);

        if ($operation == 'add') {
            $data['quantity']           =   $current_quantity + $this->input->post('quantity', TRUE);
        } else {
            $data['quantity']           =   $current_quantity - $this->input->post('quantity', TRUE);
        }

        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->where('pharmacy_inventory_id', $param);
        $this->db->update('pharmacy_inventory', $data);

        $this->session->set_flashdata('success', 'Pharmacy inventory has been Updated successfully');

        redirect(base_url() . 'pharmacy_inventory', 'refresh');
    }

    // Adding pharmacy sale
    public function add_pharmacy_sale()
    {
        $db_quantity    =   $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $this->input->post('pharmacy_inventory_id', TRUE)))->row()->quantity);
        $db_name        =   $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $this->input->post('pharmacy_inventory_id', TRUE)))->row()->name);

        if ($this->input->post('quantity', TRUE) > $db_quantity) {
            $this->session->set_flashdata('warning', $db_name . ' sold quantity cannot be greater than ' . $db_quantity);

            redirect(base_url() . 'pharmacy_pos', 'refresh');
        }

        $data = array(
            'id'        =>  $this->input->post('pharmacy_inventory_id', TRUE),
            'qty'       =>  $this->input->post('quantity', TRUE),
            'price'     =>  $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $this->input->post('pharmacy_inventory_id', TRUE)))->row()->price),
            'name'      =>  $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $this->input->post('pharmacy_inventory_id', TRUE)))->row()->name),
            'unit_id'   =>  $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $this->input->post('pharmacy_inventory_id', TRUE)))->row()->unit_id),
            'sold_from' =>  'pharmacy'
        );

        $this->cart->insert($data);

        $this->session->set_flashdata('success', 'Pharmacy sale item has been added successfully');

        redirect(base_url() . 'pharmacy_pos', 'refresh');
    }

    // Editing pharmacy sale
    public function edit_pharmacy_sale($param = '')
    {
        $pharmacy_inventory_id = $this->cart->contents()[$param]['id'];

        $db_quantity    =   $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $pharmacy_inventory_id))->row()->quantity);
        $db_name        =   $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $pharmacy_inventory_id))->row()->name);

        if ($this->input->post('quantity', TRUE) > $db_quantity) {
            $this->session->set_flashdata('warning', $db_name . ' sold quantity cannot be greater than ' . $db_quantity);

            redirect(base_url() . 'pharmacy_pos', 'refresh');
        }

        $data = array(
            'rowid'     =>  $param,
            'qty'       =>  $this->input->post('quantity', TRUE)
        );

        $this->cart->update($data);

        $this->session->set_flashdata('success', 'Pharmacy sale item has been edited successfully');

        redirect(base_url() . 'pharmacy_pos', 'refresh');
    }

    // Removing pharmacy sale
    public function remove_pharmacy_sale($param = '')
    {
        $data = array(
            'rowid'     =>  $param,
            'qty'       =>  0
        );

        $this->cart->update($data);

        $this->session->set_flashdata('success', 'Pharmacy sale item has been removed successfully');

        redirect(base_url() . 'pharmacy_pos', 'refresh');
    }

    // Creating pharmacy sale
    public function create_pharmacy_sale($param = '')
    {
        $data['pharmacy_sale_id']       =   $this->uuid->v4();
        $data['is_patient']             =   $param;
        $data['status']                 =   $this->input->post('status', TRUE);

        if ($param) {
            $data['patient_id']         =   $this->input->post('patient_id', TRUE);
        } else {
            $data['customer_name']      =   $this->input->post('customer_name', TRUE);
            $data['customer_mobile']    =   $this->input->post('customer_mobile', TRUE);
        }

        $data['discount']               =   $this->input->post('discount', TRUE) ? $this->input->post('discount', TRUE) : 0;
        $data['invoice_number']         =   'PHR' . rand(1000000, 1000000000);
        $data['created_on']             =   time();
        $data['created_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $grand_total                    =   0;
        $pharmacy_sale_details          =   '';

        foreach ($this->cart->contents() as $item) {
            if ($item['sold_from'] == 'pharmacy') {
                $sale_details['pharmacy_sale_details_id']   =   $this->uuid->v4();
                $sale_details['pharmacy_inventory_id']      =   $item['id'];
                $sale_details['quantity']                   =   $item['qty'];
                $sale_details['total']                      =   $item['price'] * $item['qty'];
                $sale_details['pharmacy_sale_id']           =   $data['pharmacy_sale_id'];
                $sale_details['timestamp']                  =   time();

                $pharmacy_sale_details                      .=  $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $item['id']))->row()->name) . ', ';

                $this->db->insert('pharmacy_sale_details', $sale_details);

                $grand_total            +=  $sale_details['total'];

                $data2['quantity']      =   $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $item['id']))->row()->quantity - $item['qty']);

                $this->db->where('pharmacy_inventory_id', $item['id']);
                $this->db->update('pharmacy_inventory', $data2);

                $data3 = array(
                    'rowid'     =>  $item['rowid'],
                    'qty'       =>  0
                );

                $this->cart->update($data3);
            }
        }

        $data['grand_total']            =   $grand_total;

        $this->db->insert('pharmacy_sale', $data);

        if ($param) {
            $invoice_request_data['table_name']     =   'pharmacy_sale';
            $invoice_request_data['table_row_id']   =   $data['pharmacy_sale_id'];
            $invoice_request_data['amount']         =   $data['discount'] ? $data['grand_total'] - ($data['grand_total'] * $data['discount'] / 100) : $data['grand_total'];
            $invoice_request_data['content']        =   'Pharmacy sales: ' . substr(trim($pharmacy_sale_details), 0, -1);
            $invoice_request_data['status']         =   $data['status'];
            $invoice_request_data['patient_id']     =   $data['patient_id'];
            $invoice_request_data['item']           =   'Pharmacy Sale';
            $invoice_request_data['quantity']       =   1;

            $this->create_invoice_request($invoice_request_data);
        }

        if ($param) {
            $this->session->set_flashdata('success', 'Pharmacy sale for existing patient has been created successfully');
        } else {
            $this->session->set_flashdata('success', 'Pharmacy sale for new customer has been created successfully');
        }

        redirect(base_url() . 'pharmacy_sales', 'refresh');
    }

    // Updating pharmacy sale status
    public function update_pharmacy_sale_status($param = '')
    {
        $data['status']                     =   $this->input->post('status', TRUE);
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->where('pharmacy_sale_id', $param);
        $this->db->update('pharmacy_sale', $data);

        $invoice_request_data['table_name']     =   'pharmacy_sale';
        $invoice_request_data['table_row_id']   =   $param;
        $invoice_request_data['status']         =   $data['status'];

        $this->update_invoice_request_status($invoice_request_data);

        $this->session->set_flashdata('success', 'Pharmacy sale status has been updated successfully');

        redirect(base_url() . 'pharmacy_sales', 'refresh');
    }

    // Creating pharmacy sale return
    public function create_pharmacy_sale_return($param = '')
    {
        $returned_pharmacy_inventory_ids    =   $this->input->post('returned_pharmacy_inventory_ids', TRUE);
        $returned_quantities                =   $this->input->post('returned_quantities', TRUE);
        $grand_total                        =   0;

        $sale_return['pharmacy_sale_return_id'] =   $this->uuid->v4();
        $sale_return['pharmacy_sale_id']        =   $param;
        $sale_return['created_on']              =   time();
        $sale_return['created_by']              =   $this->session->userdata('user_id');
        $sale_return['timestamp']               =   time();
        $sale_return['updated_by']              =   $this->session->userdata('user_id');

        foreach ($returned_quantities as $key => $value) {
            if ($value > 0) {
                $sale_return_details['pharmacy_sale_return_details_id'] =   $this->uuid->v4();
                $sale_return_details['pharmacy_inventory_id']           =   $returned_pharmacy_inventory_ids[$key];
                $sale_return_details['pharmacy_sale_return_id']         =   $sale_return['pharmacy_sale_return_id'];
                $sale_return_details['quantity']                        =   $value;
                $sale_return_details['total']                           =   $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $returned_pharmacy_inventory_ids[$key]))->row())->price * $value;
                $sale_return_details['timestamp']                       =   time();

                $this->db->insert('pharmacy_sale_return_details', $sale_return_details);

                $grand_total                +=  $sale_return_details['total'];

                $previous_quantity          =   $this->security->xss_clean($this->db->get_where('pharmacy_inventory', array('pharmacy_inventory_id' => $returned_pharmacy_inventory_ids[$key]))->row()->quantity);

                $data['quantity']           =   $previous_quantity + $value;
                $data['timestamp']          =   time();
                $data['updated_by']         =   $this->session->userdata('user_id');

                $this->db->where('pharmacy_inventory_id', $returned_pharmacy_inventory_ids[$key]);
                $this->db->update('pharmacy_inventory', $data);
            }
        }

        $sale_return['grand_total']         =   $grand_total;

        $this->db->insert('pharmacy_sale_return', $sale_return);

        if ($this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $param))->row()->is_patient)) {
            $invoice_request_data['table_name']     =   'pharmacy_sale';
            $invoice_request_data['table_row_id']   =   $param;

            $sales_total                            =   $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $param))->row()->grand_total);
            $sales_return_total                     =   0;
            foreach ($this->security->xss_clean($this->db->get_where('pharmacy_sale_return', array('pharmacy_sale_id' => $param))->result_array()) as $sale_return_row) {
                $sales_return_total                 +=   $sale_return_row['grand_total'];
            }
            $discount                               =   $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $param))->row()->discount);

            $invoice_request_data['amount']         =   $discount ? ($sales_total - $sales_return_total) - (($sales_total - $sales_return_total) * $discount / 100) : ($sales_total - $sales_return_total);
            $invoice_request_data['content']        =   $this->security->xss_clean($this->db->get_where('invoice_request', array('table_name' => $invoice_request_data['table_name'], 'table_row_id' => $invoice_request_data['table_row_id']))->row()->content);
            $invoice_request_data['patient_id']     =   $this->security->xss_clean($this->db->get_where('pharmacy_sale', array('pharmacy_sale_id' => $param))->row()->patient_id);
            $invoice_request_data['item']           =   'Pharmacy Sale';
            $invoice_request_data['quantity']       =   1;

            $this->update_invoice_request($invoice_request_data);
        }

        $this->session->set_flashdata('success', 'Pharmacy sale return has been created successfully');

        redirect(base_url() . 'pharmacy_sale_returns', 'refresh');
    }

    // Creating pharmacy unit
    public function create_pharmacy_unit()
    {
        $data['unit_id']                =   $this->uuid->v4();
        $data['name']                   =   $this->input->post('name', TRUE);
        $data['unit_for']               =   1;
        $data['created_on']             =   time();
        $data['created_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->insert('unit', $data);

        $this->session->set_flashdata('success', 'Pharmacy unit has been created successfully');

        redirect(base_url() . 'pharmacy_units', 'refresh');
    }

    // Updating pharmacy unit
    public function update_pharmacy_unit($param = '')
    {
        $data['name']                   =   $this->input->post('name', TRUE);
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->where('unit_id', $param);
        $this->db->update('unit', $data);

        $this->session->set_flashdata('success', 'Pharmacy unit has been updated successfully');

        redirect(base_url() . 'pharmacy_units', 'refresh');
    }

    // Deleting pharmacy unit
    public function delete_pharmacy_unit($param = '')
    {
        $this->db->where('unit_id', $param);
        $this->db->delete('unit');

        $this->session->set_flashdata('success', 'Pharmacy unit has been deleted successfully');

        redirect(base_url() . 'pharmacy_units', 'refresh');
    }

    // Creating cafeteria inventory
    public function create_cafeteria_inventory()
    {
        $data['cafeteria_inventory_id']     =   $this->uuid->v4();
        $data['name']                       =   $this->input->post('name', TRUE);
        $data['code']                       =   $this->input->post('code', TRUE);
        $data['price']                      =   $this->input->post('price', TRUE);
        $data['quantity']                   =   $this->input->post('quantity', TRUE);
        $data['unit_id']                    =   $this->input->post('unit_id', TRUE);
        $data['created_on']                 =   time();
        $data['created_by']                 =   $this->session->userdata('user_id');
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->insert('cafeteria_inventory', $data);

        $this->session->set_flashdata('success', 'Cafeteria inventory has been created successfully');

        redirect(base_url() . 'cafeteria_inventory', 'refresh');
    }

    // Updating pharmacy inventory details
    public function update_cafeteria_inventory_details($param = '')
    {
        $data['name']                       =   $this->input->post('name', TRUE);
        $data['code']                       =   $this->input->post('code', TRUE);
        $data['price']                      =   $this->input->post('price', TRUE);
        $data['unit_id']                    =   $this->input->post('unit_id', TRUE);
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->where('cafeteria_inventory_id', $param);
        $this->db->update('cafeteria_inventory', $data);

        $this->session->set_flashdata('success', 'Cafeteria inventory details has been Updated successfully');

        redirect(base_url() . 'cafeteria_inventory', 'refresh');
    }

    // Updating cateteria inventory
    public function update_cafeteria_inventory($param = '')
    {
        $operation                          =   $this->input->post('operation', TRUE);
        $current_quantity                   =   $this->security->xss_clean($this->db->get_where('cafeteria_inventory', array('cafeteria_inventory_id' => $param))->row()->quantity);

        if ($operation == 'add') {
            $data['quantity']               =   $current_quantity    + $this->input->post('quantity', TRUE);
        } else {
            $data['quantity']               =   $current_quantity    - $this->input->post('quantity', TRUE);
        }

        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->where('cafeteria_inventory_id', $param);
        $this->db->update('cafeteria_inventory', $data);

        $this->session->set_flashdata('success', 'Cafeteria inventory has been Updated successfully');

        redirect(base_url() . 'cafeteria_inventory', 'refresh');
    }

    // Adding cafeteria sale
    public function add_cafeteria_sale()
    {
        $db_quantity    =   $this->security->xss_clean($this->db->get_where('cafeteria_inventory', array('cafeteria_inventory_id' => $this->input->post('cafeteria_inventory_id', TRUE)))->row()->quantity);
        $db_name        =   $this->security->xss_clean($this->db->get_where('cafeteria_inventory', array('cafeteria_inventory_id' => $this->input->post('cafeteria_inventory_id', TRUE)))->row()->name);

        if ($this->input->post('quantity', TRUE) > $db_quantity) {
            $this->session->set_flashdata('warning', $db_name . ' sold quantity cannot be greater than ' . $db_quantity);

            redirect(base_url() . 'cafeteria_pos', 'refresh');
        }

        $data = array(
            'id'        =>  $this->input->post('cafeteria_inventory_id'),
            'qty'       =>  $this->input->post('quantity'),
            'price'     =>  $this->security->xss_clean($this->db->get_where('cafeteria_inventory', array('cafeteria_inventory_id' => $this->input->post('cafeteria_inventory_id', TRUE)))->row()->price),
            'name'      =>  $this->security->xss_clean($this->db->get_where('cafeteria_inventory', array('cafeteria_inventory_id' => $this->input->post('cafeteria_inventory_id', TRUE)))->row()->name),
            'unit_id'   =>  $this->security->xss_clean($this->db->get_where('cafeteria_inventory', array('cafeteria_inventory_id' => $this->input->post('cafeteria_inventory_id', TRUE)))->row()->unit_id),
            'sold_from' =>  'cafeteria'
        );

        $this->cart->insert($data);

        $this->session->set_flashdata('success', 'Cafeteria sale item has been added successfully');

        redirect(base_url() . 'cafeteria_pos', 'refresh');
    }

    // Editing cafeteria sale
    public function edit_cafeteria_sale($param = '')
    {
        $cafeteria_inventory_id = $this->cart->contents()[$param]['id'];

        $db_quantity    =   $this->security->xss_clean($this->db->get_where('cafeteria_inventory', array('cafeteria_inventory_id' => $cafeteria_inventory_id))->row()->quantity);
        $db_name        =   $this->security->xss_clean($this->db->get_where('cafeteria_inventory', array('cafeteria_inventory_id' => $cafeteria_inventory_id))->row()->name);

        if ($this->input->post('quantity', TRUE) > $db_quantity) {
            $this->session->set_flashdata('warning', $db_name . ' sold quantity cannot be greater than ' . $db_quantity);

            redirect(base_url() . 'cafeteria_pos', 'refresh');
        }

        $data = array(
            'rowid'     =>  $param,
            'qty'       =>  $this->input->post('quantity', TRUE)
        );

        $this->cart->update($data);

        $this->session->set_flashdata('success', 'Cafeteria sale item has been edited successfully');

        redirect(base_url() . 'cafeteria_pos', 'refresh');
    }

    // Removing cafeteria sale
    public function remove_cafeteria_sale($param = '')
    {
        $data = array(
            'rowid'     =>  $param,
            'qty'       =>  0
        );

        $this->cart->update($data);

        $this->session->set_flashdata('success', 'Cafeteria sale item has been removed successfully');

        redirect(base_url() . 'cafeteria_pos', 'refresh');
    }

    // Creating cafeteria sale
    public function create_cafeteria_sale()
    {
        $grand_total                =   0;

        $data['cafeteria_sale_id']  =   $this->uuid->v4();
        $data['status']             =   $this->input->post('status', TRUE);
        $data['customer_name']      =   $this->input->post('customer_name', TRUE);
        $data['customer_mobile']    =   $this->input->post('customer_mobile', TRUE);
        $data['discount']           =   $this->input->post('discount', TRUE) ? $this->input->post('discount', TRUE) : 0;
        $data['invoice_number']     =   'CAF' . rand(1000000, 1000000000);
        $data['created_on']         =   time();
        $data['created_by']         =   $this->session->userdata('user_id');
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        foreach ($this->cart->contents() as $item) {
            if ($item['sold_from'] == 'cafeteria') {
                $sale_details['cafeteria_sale_details_id']  =   $this->uuid->v4();
                $sale_details['cafeteria_inventory_id']     =   $item['id'];
                $sale_details['quantity']                   =   $item['qty'];
                $sale_details['total']                      =   $item['price'] * $item['qty'];
                $sale_details['cafeteria_sale_id']          =   $data['cafeteria_sale_id'];
                $sale_details['timestamp']                  =   time();

                $this->db->insert('cafeteria_sale_details', $sale_details);

                $grand_total            +=  $sale_details['total'];

                $data2['quantity']      =   $this->security->xss_clean($this->db->get_where('cafeteria_inventory', array('cafeteria_inventory_id' => $item['id']))->row()->quantity) - $item['qty'];

                $this->db->where('cafeteria_inventory_id', $item['id']);
                $this->db->update('cafeteria_inventory', $data2);

                $data3 = array(
                    'rowid'     =>  $item['rowid'],
                    'qty'       =>  0
                );

                $this->cart->update($data3);
            }
        }

        $data['grand_total']            =   $grand_total;

        $this->db->insert('cafeteria_sale', $data);

        $this->session->set_flashdata('success', 'Cafeteria sale has been created successfully');

        redirect(base_url() . 'cafeteria_sales', 'refresh');
    }

    // Updating cafeteria sale status
    public function update_cafeteria_sale_status($param = '')
    {
        $data['status']                     =   $this->input->post('status', TRUE);
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->where('cafeteria_sale_id', $param);
        $this->db->update('cafeteria_sale', $data);

        $this->session->set_flashdata('success', 'Cafeteria sale status has been updated successfully');

        redirect(base_url() . 'cafeteria_sales', 'refresh');
    }

    // Updating cafeteria sale status
    public function delete_cafeteria_sale($param = '')
    {
        $cafeteria_sale_details = $this->security->xss_clean($this->db->get_where('cafeteria_sale_details', array('cafeteria_sale_id' => $param))->result_array());

        foreach ($cafeteria_sale_details as $cafeteria_sale_details_row) {
            $db_inventory_quantity = $this->security->xss_clean($this->db->get_where('cafeteria_inventory', array('cafeteria_inventory_id' => $cafeteria_sale_details_row['cafeteria_inventory_id']))->row()->quantity);

            $data['quantity']   =   $db_inventory_quantity + $cafeteria_sale_details_row['quantity'];
            $data['timestamp']  =   time();
            $data['updated_by'] =   $this->session->userdata('user_id');

            $this->db->where('cafeteria_inventory_id', $cafeteria_sale_details_row['cafeteria_inventory_id']);
            $this->db->update('cafeteria_inventory', $data);

            $this->db->where('cafeteria_sale_details_id', $cafeteria_sale_details_row['cafeteria_sale_details_id']);
            $this->db->delete('cafeteria_sale_details');
        }

        $this->db->where('cafeteria_sale_id', $param);
        $this->db->delete('cafeteria_sale');

        $this->session->set_flashdata('success', 'Cafeteria sale has been deleted successfully');

        redirect(base_url() . 'cafeteria_sales', 'refresh');
    }

    // Creating cafeteria unit
    public function create_cafeteria_unit()
    {
        $data['unit_id']                =   $this->uuid->v4();
        $data['name']                   =   $this->input->post('name', TRUE);
        $data['unit_for']               =   2;
        $data['created_on']             =   time();
        $data['created_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->insert('unit', $data);

        $this->session->set_flashdata('success', 'Cafeteria unit has been created successfully');

        redirect(base_url() . 'cafeteria_units', 'refresh');
    }

    // Updating cafeteria unit
    public function update_cafeteria_unit($param = '')
    {
        $data['name']                   =   $this->input->post('name', TRUE);
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->where('unit_id', $param);
        $this->db->update('unit', $data);

        $this->session->set_flashdata('success', 'Cafeteria unit has been updated successfully');

        redirect(base_url() . 'cafeteria_units', 'refresh');
    }

    // Deleting cafeteria unit
    public function delete_cafeteria_unit($param = '')
    {
        $this->db->where('unit_id', $param);
        $this->db->delete('unit');

        $this->session->set_flashdata('success', 'Cafeteria unit has been deleted successfully');

        redirect(base_url() . 'cafeteria_units', 'refresh');
    }

    // Creating ticket
    function create_ticket()
	{
        $data['ticket_id']                  =   $this->uuid->v4();
		$data['ticket_number']			    =	$this->random_strings(11);
		$data['subject']					=	$this->input->post('subject');
		$data['status']						=	0;
		$data['patient_id']					=	($this->session->userdata('user_type') == 'patient') ? $this->session->userdata('user_id') : $this->input->post('patient_id');
		$data['created_on']					=	time();
		$data['created_by']					=	$this->session->userdata('user_id');
		$data['timestamp']					=	time();
		$data['updated_by']					=	$this->session->userdata('user_id');

		$this->db->insert('ticket', $data);

        $data2['ticket_details_id']         =   $this->uuid->v4();
		$data2['ticket_id']					=	$data['ticket_id'];
		$data2['content']					=	$this->input->post('content');
		$data2['created_on']				=	time();
		$data2['created_by']				=	$this->session->userdata('user_id');
		$data2['timestamp']					=	time();
		$data2['updated_by']				=	$this->session->userdata('user_id');

		$this->db->insert('ticket_details', $data2);

		$this->session->set_flashdata('success', 'Ticket has been created successfully');

		redirect(base_url('tickets'), 'refresh');
	}

    // Random string
	private function random_strings($length_of_string)
	{
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

		return substr(str_shuffle($str_result), 0, $length_of_string);
	}

    // Updating ticket
	function update_ticket($ticket_id = '')
	{
		$data['timestamp']					=	time();
		$data['updated_by']					=	$this->session->userdata('user_id');

		$this->db->where('ticket_id', $ticket_id);
		$this->db->update('ticket', $data);

		$data2['ticket_id']					=	$ticket_id;
		$data2['content']					=	$this->input->post('content');
		$data2['created_on']				=	time();
		$data2['created_by']				=	$this->session->userdata('user_id');
		$data2['timestamp']					=	time();
		$data2['updated_by']				=	$this->session->userdata('user_id');

		$this->db->insert('ticket_details', $data2);

		$this->session->set_flashdata('success', 'Ticket has been replied successfully');

		redirect(base_url('tickets'), 'refresh');
	}

    // Closing ticket
	function close_ticket($ticket_id = '')
	{
		$data['status']						=	1;
		$data['timestamp']					=	time();
		$data['updated_by']					=	$this->session->userdata('user_id');

		$this->db->where('ticket_id', $ticket_id);
		$this->db->update('ticket', $data);

		$this->session->set_flashdata('success', 'Ticket has been closed successfully');

		redirect(base_url('tickets'), 'refresh');
	}

    // Creating staff category
    public function create_staff_category()
    {
        $data['staff_category_id']  =   $this->uuid->v4();
        $data['name']               =   $this->input->post('name', TRUE);
        $data['uri']                =   strtolower(str_replace(' ', '-', $this->input->post('name', TRUE)));
        $data['is_doctor']          =   $this->input->post('is_doctor', TRUE);
        $data['payment_type']       =   $this->input->post('payment_type', TRUE);
        if ($this->input->post('pay_scale', TRUE)) {
            $data['pay_scale']      =   $this->input->post('pay_scale', TRUE);
        } else {
            $data['pay_scale']      =   0;
        }
        $data['duties']             =   $this->input->post('duties', TRUE);
        $data['created_on']         =   time();
        $data['created_by']         =   $this->session->userdata('user_id');
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->insert('staff_category', $data);

        $this->session->set_flashdata('success', 'Staff category has been created successfully');

        redirect(base_url() . 'staff_categories', 'refresh');
    }

    // Updating staff category
    public function update_staff_category($param = '')
    {
        $data['name']               =   $this->input->post('name', TRUE);
        $data['uri']                =   strtolower(str_replace(' ', '-', $this->input->post('name', TRUE)));
        $data['is_doctor']          =   $this->input->post('is_doctor', TRUE);
        $data['payment_type']       =   $this->input->post('payment_type', TRUE);
        if ($this->input->post('pay_scale', TRUE)) {
            $data['pay_scale']      =   $this->input->post('pay_scale', TRUE);
        } else {
            $data['pay_scale']      =   0;
        }
        $data['duties']             =   $this->input->post('duties', TRUE);
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->where('staff_category_id', $param);
        $this->db->update('staff_category', $data);

        $this->session->set_flashdata('success', 'Staff category has been updated successfully');

        redirect(base_url() . 'staff_categories', 'refresh');
    }

    public function update_staff_permission($param = '')
    {
        $permission                 =   $this->input->post('permission', TRUE);

        $permissions                =   '';
        if (isset($permission)) {
            foreach ($permission as $key => $value) {
                $permissions        .=  $value . ',';
            }
        }

        $data['permissions']        =   substr(trim($permissions), 0, -1);
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->where('staff_category_id', $param);
        $this->db->update('staff_category', $data);

        // $this->session->set_userdata('permissions', explode(",", $data['permissions']));

        $this->session->set_flashdata('success', 'Staff category permission has been updated successfully.');

        redirect(base_url() . 'staff_categories', 'refresh');
    }

    // Creating staff
    public function create_staff($param = '')
    {
        $name                           =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $param))->row()->name);
        $uri                            =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $param))->row()->uri);
        $is_doctor                      =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $param))->row()->is_doctor);

        $ext                            =   pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $data['image_link']         =   $data2['user_id'] . '.' . $ext;

            if ($is_doctor) {
                move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/doctor/' . $data2['user_id'] . '.' . $ext);
            } else {
                move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/staff/' . $data2['user_id'] . '.' . $ext);
            }
        }

        if ($is_doctor) {
            $data['doctor_id']          =   $this->uuid->v4();
            $data['name']               =   $this->input->post('name', TRUE);
            $data['email']              =   $this->input->post('email', TRUE);
            $data['mobile_number']      =   $this->input->post('mobile_number', TRUE);
            $data['department_id']      =   $this->input->post('department_id', TRUE);
            $data['address']            =   $this->input->post('address_1', TRUE) . '<br>' . $this->input->post('address_2', TRUE);
            $data['age']                =   $this->input->post('age', TRUE);
            $data['dob']                =   strtotime($this->input->post('dob', TRUE));
            $data['appointment_fee']    =   $this->input->post('appointment_fee', TRUE) ? $this->input->post('appointment_fee', TRUE) : 0;
            $data['sex_id']             =   $this->input->post('sex_id', TRUE);
            $data['blood_inventory_id'] =   $this->input->post('blood_inventory_id', TRUE);
            $data['staff_category_id']  =   $param;
            $data['degrees']            =   $this->input->post('degrees', TRUE);
            $data['designation']        =   $this->input->post('designation', TRUE);
            $data['status']             =   1;
            $data['created_on']         =   time();
            $data['created_by']         =   $this->session->userdata('user_id');
            $data['timestamp']          =   time();
            $data['updated_by']         =   $this->session->userdata('user_id');

            $this->db->insert('doctor', $data);

            $data2['user_id']           =   $this->uuid->v4();
            $data2['staff_id']          =   $data['doctor_id'];
            $data2['email']             =   $data['email'];
            $data2['password']          =   password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT);
            $data2['status']            =   $data['status'];
            $data2['is_doctor']         =   $is_doctor;
            $data2['staff_category_id'] =   $data['staff_category_id'];
            $data2['created_on']        =   $data['created_on'];
            $data2['created_by']        =   $data['created_by'];
            $data2['timestamp']         =   $data['timestamp'];
            $data2['updated_by']        =   $data['updated_by'];

            $this->db->insert('user', $data2);
        } else {
            $data['staff_id']           =   $this->uuid->v4();
            $data['name']               =   $this->input->post('name', TRUE);
            $data['email']              =   $this->input->post('email', TRUE);
            $data['mobile_number']      =   $this->input->post('mobile_number', TRUE);
            $data['address']            =   $this->input->post('address_1', TRUE) . '<br>' . $this->input->post('address_2', TRUE);
            $data['sex_id']             =   $this->input->post('sex_id', TRUE);
            $data['blood_inventory_id'] =   $this->input->post('blood_inventory_id', TRUE);
            $data['staff_category_id']  =   $param;
            $data['status']             =   1;
            $data['created_on']         =   time();
            $data['created_by']         =   $this->session->userdata('user_id');
            $data['timestamp']          =   time();
            $data['updated_by']         =   $this->session->userdata('user_id');

            $this->db->insert('staff', $data);

            $data2['user_id']           =   $this->uuid->v4();
            $data2['staff_id']          =   $data['staff_id'];
            $data2['email']             =   $data['email'];
            $data2['password']          =   password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT);
            $data2['status']            =   $data['status'];
            $data2['is_doctor']         =   $is_doctor;
            $data2['staff_category_id'] =   $data['staff_category_id'];
            $data2['created_on']        =   $data['created_on'];
            $data2['created_by']        =   $data['created_by'];
            $data2['timestamp']         =   $data['timestamp'];
            $data2['updated_by']        =   $data['updated_by'];

            $this->db->insert('user', $data2);
        }

        $this->session->set_flashdata('success', $name . ' has been created successfully');

        redirect(base_url() . 'staff/' . $param, 'refresh');
    }

    // Updating staff details
    public function update_staff_details($param2 = '', $param3 = '')
    {
        $name                           =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $param2))->row()->name);
        $uri                            =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $param2))->row()->uri);
        $is_doctor                      =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $param2))->row()->is_doctor);

        if ($is_doctor) {
            $data['name']               =   $this->input->post('name', TRUE);
            $data['email']              =   $this->input->post('email', TRUE);
            $data['mobile_number']      =   $this->input->post('mobile_number', TRUE);
            $data['department_id']      =   $this->input->post('department_id', TRUE);
            $data['address']            =   $this->input->post('address_1', TRUE) . '<br>' . $this->input->post('address_2', TRUE);
            $data['age']                =   $this->input->post('age', TRUE);
            $data['dob']                =   strtotime($this->input->post('dob', TRUE));
            $data['appointment_fee']    =   $this->input->post('appointment_fee', TRUE) ? $this->input->post('appointment_fee', TRUE) : 0;
            $data['sex_id']             =   $this->input->post('sex_id', TRUE);
            $data['blood_inventory_id'] =   $this->input->post('blood_inventory_id', TRUE);
            $data['staff_category_id']  =   $this->input->post('staff_category_id', TRUE);
            $data['degrees']            =   $this->input->post('degrees', TRUE);
            $data['designation']        =   $this->input->post('designation', TRUE);
            $data['timestamp']          =   time();
            $data['updated_by']         =   $this->session->userdata('user_id');

            $this->db->where('doctor_id', $param3);
            $this->db->update('doctor', $data);

            $data2['email']             =   $data['email'];
            $data2['staff_category_id'] =   $data['staff_category_id'];
            $data2['timestamp']         =   $data['timestamp'];
            $data2['updated_by']        =   $data['updated_by'];

            $this->db->where(array('staff_category_id' => $param2, 'staff_id' => $param3));
            $this->db->update('user', $data2);
        } else {
            $data['name']               =   $this->input->post('name', TRUE);
            $data['email']              =   $this->input->post('email', TRUE);
            $data['mobile_number']      =   $this->input->post('mobile_number', TRUE);
            $data['address']            =   $this->input->post('address_1', TRUE) . '<br>' . $this->input->post('address_2', TRUE);
            $data['sex_id']             =   $this->input->post('sex_id', TRUE);
            $data['blood_inventory_id'] =   $this->input->post('blood_inventory_id', TRUE);
            $data['staff_category_id']  =   $this->input->post('staff_category_id', TRUE);
            $data['timestamp']          =   time();
            $data['updated_by']         =   $this->session->userdata('user_id');

            $this->db->where('staff_id', $param3);
            $this->db->update('staff', $data);

            $data2['email']             =   $data['email'];
            $data2['staff_category_id'] =   $data['staff_category_id'];
            $data2['timestamp']         =   $data['timestamp'];
            $data2['updated_by']        =   $data['updated_by'];

            $this->db->where(array('staff_category_id' => $param2, 'staff_id' => $param3));
            $this->db->update('user', $data2);
        }

        $this->session->set_flashdata('success', $name . ' details has been updated successfully');

        redirect(base_url() . 'staff/' . $param2, 'refresh');
    }

    // Updating staff status
    public function update_staff_status($param2 = '', $param3 = '')
    {
        $name                           =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $param2))->row()->name);
        $uri                            =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $param2))->row()->uri);
        $is_doctor                      =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $param2))->row()->is_doctor);

        if ($is_doctor) {
            $data['status']             =   $this->input->post('status', TRUE);
            $data['timestamp']          =   time();
            $data['updated_by']         =   $this->session->userdata('user_id');

            $this->db->where('doctor_id', $param3);
            $this->db->update('doctor', $data);

            $this->db->where(array('staff_category_id' => $param2, 'staff_id' => $param3));
            $this->db->update('user', $data);
        } else {
            $data['status']             =   $this->input->post('status', TRUE);
            $data['timestamp']          =   time();
            $data['updated_by']         =   $this->session->userdata('user_id');

            $this->db->where('staff_id', $param3);
            $this->db->update('staff', $data);

            $this->db->where(array('staff_category_id' => $param2, 'staff_id' => $param3));
            $this->db->update('user', $data);
        }

        $this->session->set_flashdata('success', $name . ' status has been updated successfully');

        redirect(base_url() . 'staff/' . $param2, 'refresh');
    }

    // Creating accommodation category
    public function create_accommodation_category()
    {
        $data['accommodation_category_id']  =   $this->uuid->v4();
        $data['name']                       =   $this->input->post('name', TRUE);
        $data['uri']                        =   strtolower(str_replace(' ', '-', $this->input->post('name', TRUE)));
        $data['accommodation_type']         =   $this->input->post('accommodation_type', TRUE);
        $data['description']                =   $this->input->post('description', TRUE);
        $data['created_on']                 =   time();
        $data['created_by']                 =   $this->session->userdata('user_id');
        $data['timestamp']                  =   time();
        $data['updated_by']                 =   $this->session->userdata('user_id');

        $this->db->insert('accommodation_category', $data);

        $this->session->set_flashdata('success', 'Accommodation category has been created successfully');

        redirect(base_url() . 'accommodation_categories', 'refresh');
    }

    // Updating accommodation category
    public function update_accommodation_category($param = '')
    {
        $data['name']               =   $this->input->post('name', TRUE);
        $data['uri']                =   strtolower(str_replace(' ', '-', $this->input->post('name', TRUE)));
        $data['accommodation_type'] =   $this->input->post('accommodation_type', TRUE);
        $data['description']        =   $this->input->post('description', TRUE);
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->where('accommodation_category_id', $param);
        $this->db->update('accommodation_category', $data);

        $this->session->set_flashdata('success', 'Accommodation category has been updated successfully');

        redirect(base_url() . 'accommodation_categories', 'refresh');
    }

    // Deleting accommodation category
    public function delete_accommodation_category($param = '')
    {
        $accommodation_type =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $param))->row()->accommodation_type);

        if ($accommodation_type == 1) {
            $beds           =   $this->security->xss_clean($this->db->get_where('bed', array('accommodation_category_id' => $param))->result_array());

            foreach ($beds as $bed) {
                $this->db->where('bed_id', $bed['bed_id']);
                $this->db->delete('bed');
            }
        } else {
            $accommodations =   $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_category_id' => $param))->result_array());

            foreach ($accommodations as $accommodation) {
                $this->db->where('accommodation_id', $accommodation['accommodation_id']);
                $this->db->delete('accommodation');
            }
        }

        $this->db->where('accommodation_category_id', $param);
        $this->db->delete('accommodation_category');

        $this->session->set_flashdata('success', 'Accommodation category has been deleted successfully');

        redirect(base_url() . 'accommodation_categories', 'refresh');
    }

    // Creating bed and accommodation
    public function create_accommodation($param = '')
    {
        $name                                       =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $param))->row()->name);
        $uri                                        =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $param))->row()->uri);
        $accommodation_type                         =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $param))->row()->accommodation_type);

        if ($accommodation_type == 1) {
            $data['bed_id']                         =   $this->uuid->v4();
            $data['bed_number']                     =   $this->input->post('bed_number', TRUE);
            $data['rent']                           =   $this->input->post('rent', TRUE);
            $data['accommodation_category_id']      =   $param;
            $data['accommodation_id']               =   $this->input->post('accommodation_id', TRUE);
            $data['root_accommodation_category_id'] =   $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $data['accommodation_id']))->row()->accommodation_category_id);
            $data['status']                         =   0;
            $data['created_on']                     =   time();
            $data['created_by']                     =   $this->session->userdata('user_id');
            $data['timestamp']                      =   time();
            $data['updated_by']                     =   $this->session->userdata('user_id');

            $this->db->insert('bed', $data);
        } else {
            $data['accommodation_id']               =   $this->uuid->v4();
            $data['room_number']                    =   $this->input->post('room_number', TRUE);
            if ($accommodation_type == 0) {
                $data['rent']                       =   $this->input->post('rent', TRUE);
            } else {
                $data['rent']                       =   0;
            }
            $data['accommodation_category_id']      =   $param;
            $data['status']                         =   0;
            $data['created_on']                     =   time();
            $data['created_by']                     =   $this->session->userdata('user_id');
            $data['timestamp']                      =   time();
            $data['updated_by']                     =   $this->session->userdata('user_id');

            $this->db->insert('accommodation', $data);
        }

        $this->session->set_flashdata('success', $name . ' has been created successfully');

        redirect(base_url() . 'accommodations/' . $param, 'refresh');
    }

    // Updating bed and accommodation
    public function update_accommodation_details($param2 = '', $param3 = '')
    {
        $name                                       =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $param2))->row()->name);
        $uri                                        =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $param2))->row()->uri);
        $accommodation_type                         =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $param2))->row()->accommodation_type);

        if ($accommodation_type == 1) {
            $data['bed_number']                     =   $this->input->post('bed_number', TRUE);
            $data['rent']                           =   $this->input->post('rent', TRUE);
            $data['accommodation_id']               =   $this->input->post('accommodation_id', TRUE);
            $data['root_accommodation_category_id'] =   $this->security->xss_clean($this->db->get_where('accommodation', array('accommodation_id' => $this->input->post('accommodation_id', TRUE)))->row()->accommodation_category_id);
            $data['timestamp']                      =   time();
            $data['updated_by']                     =   $this->session->userdata('user_id');

            $this->db->where('bed_id', $param3);
            $this->db->update('bed', $data);
        } else {
            $data['room_number']                    =   $this->input->post('room_number', TRUE);
            if ($accommodation_type == 0) {
                $data['rent']                       =   $this->input->post('rent', TRUE);
            } else {
                $data['rent']                       =   0;
            }
            $data['timestamp']                      =   time();
            $data['updated_by']                     =   $this->session->userdata('user_id');

            $this->db->where('accommodation_id', $param3);
            $this->db->update('accommodation', $data);
        }

        $this->session->set_flashdata('success', $name . ' has been updated successfully');

        redirect(base_url() . 'accommodations/' . $param2, 'refresh');
    }

    // Deleting bed and accommodation
    public function delete_accommodation_details($param2 = '', $param3 = '')
    {
        $name                                       =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $param2))->row()->name);
        $accommodation_type                         =   $this->security->xss_clean($this->db->get_where('accommodation_category', array('accommodation_category_id' => $param2))->row()->accommodation_type);

        if ($accommodation_type == 1) {
            $this->db->where('bed_id', $param3);
            $this->db->delete('bed');
        } else {
            $this->db->where('accommodation_id', $param3);
            $this->db->delete('accommodation');
        }

        $this->session->set_flashdata('success', $name . 'Accommodation has been deleted successfully');

        redirect(base_url() . 'accommodations/' . $param2, 'refresh');
    }

    // Creating transport category
    public function create_transport_category()
    {
        $data['transport_category_id']  =   $this->uuid->v4();
        $data['name']                   =   $this->input->post('name', TRUE);
        $data['cost']                   =   $this->input->post('cost', TRUE);
        $data['description']            =   $this->input->post('description', TRUE);
        $data['created_on']             =   time();
        $data['created_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->insert('transport_category', $data);

        $this->session->set_flashdata('success', 'Transport category has been created successfully');

        redirect(base_url() . 'transport_categories', 'refresh');
    }

    // Updating transport category
    public function update_transport_category($param = '')
    {
        $data['name']                   =   $this->input->post('name', TRUE);
        $data['cost']                   =   $this->input->post('cost', TRUE);
        $data['description']            =   $this->input->post('description', TRUE);
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->where('transport_category_id', $param);
        $this->db->update('transport_category', $data);

        $this->session->set_flashdata('success', 'Transport category has been updated successfully');

        redirect(base_url() . 'transport_categories', 'refresh');
    }

    // Deleting transport category
    public function delete_transport_category($param = '')
    {
        $this->db->where('transport_category_id', $param);
        $this->db->delete('transport_category');

        $this->session->set_flashdata('success', 'Transport category has been deleted successfully');

        redirect(base_url() . 'transport_categories', 'refresh');
    }

    // Creating transport
    public function create_transport($param = '')
    {
        $name                           =   $this->security->xss_clean($this->db->get_where('transport_category', array('transport_category_id' => $param))->row()->name);

        $data['transport_id']           =   $this->uuid->v4();
        $data['transport_number']       =   $this->input->post('transport_number', TRUE);
        $data['status']                 =   1;
        $data['transport_category_id']  =   $param;
        $data['created_on']             =   time();
        $data['created_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->insert('transport', $data);

        $this->session->set_flashdata('success', $name . ' has been created successfully');

        redirect(base_url() . 'transports/' . $param, 'refresh');
    }

    // Updating transport
    public function update_transport_details($param2 = '', $param3 = '')
    {
        $name                           =   $this->security->xss_clean($this->db->get_where('transport_category', array('transport_category_id' => $param2))->row()->name);
        $uri                            =   $this->security->xss_clean($this->db->get_where('transport_category', array('transport_category_id' => $param2))->row()->uri);

        $data['transport_number']       =   $this->input->post('transport_number', TRUE);
        $data['status']                 =   $this->input->post('status', TRUE);
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->where('transport_id', $param3);
        $this->db->update('transport', $data);

        $this->session->set_flashdata('success', $name . ' has been updated successfully');

        redirect(base_url() . 'transports/' . $param2, 'refresh');
    }

    // Deleting transport
    public function delete_transport_details($param2 = '', $param3 = '')
    {
        $this->db->where('transport_id', $param3);
        $this->db->delete('transport');

        $this->session->set_flashdata('success', 'Transport has been updated successfully');

        redirect(base_url() . 'transports/' . $param2, 'refresh');
    }

    // Creating custom invoice item
    public function create_custom_invoice_item()
    {
        $data['custom_invoice_item_id'] =   $this->uuid->v4();
        $data['item']                   =   $this->input->post('item', TRUE);
        $data['content']                =   $this->input->post('content', TRUE);
        $data['cost']                   =   $this->input->post('cost', TRUE);
        $data['created_on']             =   time();
        $data['created_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->insert('custom_invoice_item', $data);

        $this->session->set_flashdata('success', 'Custom invoice item has been created successfully');

        redirect(base_url() . 'custom_invoice_items', 'refresh');
    }

    // Updating custom invoice item
    public function update_custom_invoice_item($param = '')
    {
        $data['item']                   =   $this->input->post('item', TRUE);
        $data['content']                =   $this->input->post('content', TRUE);
        $data['cost']                   =   $this->input->post('cost', TRUE);
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->where('custom_invoice_item_id', $param);
        $this->db->update('custom_invoice_item', $data);

        $this->session->set_flashdata('success', 'Custom invoice item has been updated successfully');

        redirect(base_url() . 'custom_invoice_items', 'refresh');
    }

    // Deleting custom invoice item
    public function delete_custom_invoice_item($param = '')
    {
        $this->db->where('custom_invoice_item_id', $param);
        $this->db->delete('custom_invoice_item');

        $this->session->set_flashdata('success', 'Custom invoice item has been deleted successfully');

        redirect(base_url() . 'custom_invoice_items', 'refresh');
    }

    // Creating department
    public function create_department()
    {
        $data['department_id']      =   $this->uuid->v4();
        $data['name']               =   $this->input->post('name', TRUE);
        $data['description']        =   $this->input->post('description', TRUE);
        $data['created_on']         =   time();
        $data['created_by']         =   $this->session->userdata('user_id');
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->insert('department', $data);

        $this->session->set_flashdata('success', 'Department has been created successfully');

        redirect(base_url() . 'departments', 'refresh');
    }

    // Updating department
    public function update_department($param = '')
    {
        $data['name']               =   $this->input->post('name', TRUE);
        $data['description']        =   $this->input->post('description', TRUE);
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->where('department_id', $param);
        $this->db->update('department', $data);

        $this->session->set_flashdata('success', 'Department has been updated successfully');

        redirect(base_url() . 'departments', 'refresh');
    }

    // Deleting department
    public function delete_department($param = '')
    {
        $this->db->where('department_id', $param);
        $this->db->delete('department');

        $this->session->set_flashdata('success', 'Department has been deleted successfully');

        redirect(base_url() . 'departments', 'refresh');
    }

    // Updating system seeting
    public function update_system_setting()
    {
        $system_name['content']     =   $this->input->post('system_name', TRUE);
        $system_tagline['content']  =   $this->input->post('system_tagline', TRUE);
        $currency['content']        =   $this->input->post('currency', TRUE);
        $system_address['content']  =   $this->input->post('system_address_1', TRUE) . '<br>' . $this->input->post('system_address_2', TRUE);
        $system_phone['content']    =   $this->input->post('system_phone', TRUE);
        $system_website['content']  =   $this->input->post('system_website', TRUE);
        $system_email['content']    =   $this->input->post('system_email', TRUE);
        $system_font['font']        =   $this->input->post('font', TRUE);

        // Font changing switch case of the system
        switch ($system_font['font']) {
            case 'PT Sans Narrow':
                $font['content']        =   "'PT Sans Narrow', sans-serif";
                $font_family['content'] =   "PT Sans Narrow";
                $font_src['content']    =   "https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@400;700&display=swap";
                break;
            case 'Josefin Sans':
                $font['content']        =   "'Josefin Sans', sans-serif";
                $font_family['content'] =   "Josefin Sans";
                $font_src['content']    =   "https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap";
                break;
            case 'Titillium Web':
                $font['content']        =   "'Titillium Web', sans-serif";
                $font_family['content'] =   "Titillium Web";
                $font_src['content']    =   "https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap";
                break;
            case 'Mukta':
                $font['content']        =   "'Mukta', sans-serif";
                $font_family['content'] =   "Mukta";
                $font_src['content']    =   "https://fonts.googleapis.com/css2?family=Mukta:wght@200;300;400;500;600;700;800&display=swap";
                break;
            case 'PT Sans':
                $font['content']        =   "'PT Sans', sans-serif";
                $font_family['content'] =   "PT Sans";
                $font_src['content']    =   "https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap";
                break;
            case 'Rubik':
                $font['content']        =   "'Rubik', sans-serif";
                $font_family['content'] =   "Rubik";
                $font_src['content']    =   "https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap";
                break;
            case 'Oswald':
                $font['content']        =   "'Oswald', sans-serif";
                $font_family['content'] =   "Oswald";
                $font_src['content']    =   "https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap";
                break;
            case 'Poppins':
                $font['content']        =   "'Poppins', sans-serif";
                $font_family['content'] =   "Poppins";
                $font_src['content']    =   "https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap";
                break;
            case 'Open Sans':
                $font['content']        =   "'Open Sans', sans-serif";
                $font_family['content'] =   "Open Sans";
                $font_src['content']    =   "https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap";
                break;
            case 'Cantarell':
                $font['content']        =   "'Cantarell', sans-serif";
                $font_family['content'] =   "Cantarell";
                $font_src['content']    =   "https://fonts.googleapis.com/css2?family=Cantarell:ital,wght@0,400;0,700;1,400;1,700&display=swap";
                break;
            case 'Ubuntu':
                $font['content']        =   "'Ubuntu', sans-serif";
                $font_family['content'] =   "Ubuntu";
                $font_src['content']    =   "https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap";
                break;
            default:
                $font['content']        =   "'PT Sans Narrow', sans-serif";
                $font_family['content'] =   "PT Sans Narrow";
                $font_src['content']    =   "https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@400;700&display=swap";
        }

        $this->db->where('item', 'font');
        $this->db->update('setting', $font);
        $this->db->where('item', 'font_family');
        $this->db->update('setting', $font_family);
        $this->db->where('item', 'font_src');
        $this->db->update('setting', $font_src);

        $this->db->where('item', 'system_name');
        $this->db->update('setting', $system_name);
        $this->db->where('item', 'system_tagline');
        $this->db->update('setting', $system_tagline);
        $this->db->where('item', 'currency');
        $this->db->update('setting', $currency);
        $this->db->where('item', 'system_address');
        $this->db->update('setting', $system_address);
        $this->db->where('item', 'system_phone');
        $this->db->update('setting', $system_phone);
        $this->db->where('item', 'system_website');
        $this->db->update('setting', $system_website);
        $this->db->where('item', 'system_email');
        $this->db->update('setting', $system_email);

        $this->session->set_flashdata('success', 'System settings has been updated successfully');

        redirect(base_url() . 'settings', 'refresh');
    }

    // Updating login background
    public function update_login_bg()
    {
        $ext                    =   pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $image_link = $this->security->xss_clean($this->db->get_where('setting', array('item' => 'login_bg'))->row()->content);
            if (isset($image_link)) unlink('uploads/website/' . $image_link);

            move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/website/' . 'login_bg_' . time() . '.' . $ext);

            $data['content']    =   'login_bg_' . time() . '.' . $ext;

            $this->db->where('item', 'login_bg');
            $this->db->update('setting', $data);

            $this->session->set_flashdata('success', 'System login background has been updated successfully.');

            redirect(base_url() . 'settings', 'refresh');
        } else {
            $this->session->set_flashdata('warning', 'Only supported image types: jpeg, jpg, png');

            redirect(base_url() . 'settings', 'refresh');
        }
    }

    // Updating favicons
    public function update_favicon()
    {
        $ext                    =   pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $image_link = $this->security->xss_clean($this->db->get_where('setting', array('item' => 'favicon'))->row()->content);
            if (isset($image_link)) unlink('uploads/website/' . $image_link);

            move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/website/' . 'favicon_' . time() . '.' . $ext);

            $data['content']    =   'favicon_' . time() . '.' . $ext;

            $this->db->where('item', 'favicon');
            $this->db->update('setting', $data);

            $this->session->set_flashdata('success', 'System favicon has been updated successfully.');

            redirect(base_url() . 'settings', 'refresh');
        } else {
            $this->session->set_flashdata('warning', 'Only supported image types: jpeg, jpg, png');

            redirect(base_url() . 'settings', 'refresh');
        }
    }

    // Updating meal plan price setting
    public function update_meal_plan_price()
    {
        $breakfast_price['content']    =   $this->input->post('breakfast_price', TRUE);
        $milk_break_price['content']   =   $this->input->post('milk_break_price', TRUE);
        $lunch_price['content']        =   $this->input->post('lunch_price', TRUE);
        $tea_break_price['content']    =   $this->input->post('tea_break_price', TRUE);
        $dinner_price['content']       =   $this->input->post('dinner_price', TRUE);

        $this->db->where('item', 'breakfast_price');
        $this->db->update('setting', $breakfast_price);
        $this->db->where('item', 'milk_break_price');
        $this->db->update('setting', $milk_break_price);
        $this->db->where('item', 'lunch_price');
        $this->db->update('setting', $lunch_price);
        $this->db->where('item', 'tea_break_price');
        $this->db->update('setting', $tea_break_price);
        $this->db->where('item', 'dinner_price');
        $this->db->update('setting', $dinner_price);

        $this->session->set_flashdata('success', 'Meal price plan has been updated successfully');

        redirect(base_url() . 'settings', 'refresh');
    }

    // Creating payroll
    public function create_payroll()
    {
        $year   =   $this->input->post('year', TRUE);
        $month  =   $this->input->post('month', TRUE);

        $users = $this->security->xss_clean($this->db->get('user')->result_array());

        foreach ($users as $user) {
            $pay_scale  =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $user['staff_category_id']))->row()->pay_scale);

            $array = array('user_id' => $user['user_id'], 'month' => $month, 'year' => $year);
            $this->db->where($array);
            $num_of_row      =   $this->security->xss_clean($this->db->get('payroll')->num_rows());

            if ($pay_scale > 0 && $num_of_row == 0) {
                $data['payroll_id'] =   $this->uuid->v4();
                $data['user_id']    =   $user['user_id'];
                $data['status']     =   0;
                $data['amount']     =   $pay_scale;
                $data['created_on'] =   time();
                $data['created_by'] =   $this->session->userdata('user_id');
                $data['timestamp']  =   time();
                $data['updated_by'] =   $this->session->userdata('user_id');
                $data['month']      =   $month;
                $data['year']       =   $year;

                $this->db->insert('payroll', $data);
            }
        }

        $this->session->set_flashdata('success', 'Payroll has been created successfully');

        redirect(base_url() . 'payroll', 'refresh');
    }

    // updating payroll
    public function update_payroll($param = '')
    {
        $data['amount']     =   $this->input->post('amount', TRUE);
        $data['timestamp']  =   time();
        $data['updated_by'] =   $this->session->userdata('user_id');
        $data['month']      =   $this->input->post('month', TRUE);
        $data['year']       =   $this->input->post('year', TRUE);

        $this->db->where('payroll_id', $param);
        $this->db->update('payroll', $data);

        $this->session->set_flashdata('success', 'Payroll has been updated successfully');

        redirect(base_url() . 'payroll', 'refresh');
    }

    // updating payroll
    public function update_payroll_status($param = '')
    {
        $data['status']     =   $this->input->post('status', TRUE);
        $data['timestamp']  =   time();
        $data['updated_by'] =   $this->session->userdata('user_id');

        $this->db->where('payroll_id', $param);
        $this->db->update('payroll', $data);

        $this->session->set_flashdata('success', 'Payroll status has been updated successfully');

        redirect(base_url() . 'payroll', 'refresh');
    }

    // Deleting payroll
    public function delete_payroll($param = '')
    {
        $this->db->where('payroll_id', $param);
        $this->db->delete('payroll');

        $this->session->set_flashdata('success', 'Payroll has been deleted successfully');

        redirect(base_url() . 'payroll', 'refresh');
    }

    // Reading revenue
    public function read_revenue($year = '', $month = '')
    {
        $revenue_details = [];

        if ($year != '' && $month != '') {
            $start_date =   strtotime($month . ' ' . '01' . ', ' . $year);
            $end_date   =   strtotime($month . ' ' . date('t', strtotime($year . '-' . $month)) . ', ' . $year . '11:59:59 pm');

            $array = array('status' => 1, 'created_on >=' => $start_date, 'created_on <=' => $end_date);
            $this->db->where($array);

            $invoice_requests = $this->security->xss_clean($this->db->get('invoice_request')->result_array());
            foreach ($invoice_requests as $invoice_request) {
                $data['source']             =   $invoice_request['item'];
                $data['amount']             =   $invoice_request['amount'];
                $data['consumer']           =   $this->db->get_where('patient', array('patient_id' => $invoice_request['patient_id']))->num_rows() > 0 ? $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $invoice_request['patient_id']))->row()->name) : 'Consumer not found.';
                $data['consumer_mobile']    =   $this->db->get_where('patient', array('patient_id' => $invoice_request['patient_id']))->num_rows() > 0 ? $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $invoice_request['patient_id']))->row()->mobile_number) : 'Mobile not found.';
                $data['month']              =   date('F', $invoice_request['created_on']);
                $data['year']               =   date('Y', $invoice_request['created_on']);

                array_push($revenue_details, $data);
            }

            $array = array('status' => 1, 'created_on >=' => $start_date, 'created_on <=' => $end_date);
            $this->db->where($array);

            $cafeteria_sales = $this->security->xss_clean($this->db->get('cafeteria_sale')->result_array());
            foreach ($cafeteria_sales as $cafeteria_sale) {
                $data['source']             =   'Cafeteria';
                $data['amount']             =   $cafeteria_sale['discount'] ? $cafeteria_sale['grand_total'] - ($cafeteria_sale['grand_total'] * $cafeteria_sale['discount'] / 100) : $cafeteria_sale['grand_total'];
                $data['consumer']           =   $cafeteria_sale['customer_name'];
                $data['consumer_mobile']    =   $cafeteria_sale['customer_mobile'];
                $data['month']              =   date('F', $cafeteria_sale['created_on']);
                $data['year']               =   date('Y', $cafeteria_sale['created_on']);

                array_push($revenue_details, $data);
            }
        } else {
            $invoice_requests = $this->db->get_where('invoice_request', array('status' => 1))->result_array();
            foreach ($invoice_requests as $invoice_request) {
                $data['source']             =   $invoice_request['item'];
                $data['amount']             =   $invoice_request['amount'];
                $data['consumer']           =   $this->db->get_where('patient', array('patient_id' => $invoice_request['patient_id']))->num_rows() > 0 ? $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $invoice_request['patient_id']))->row()->name) : 'Consumer not found.';
                $data['consumer_mobile']    =   $this->db->get_where('patient', array('patient_id' => $invoice_request['patient_id']))->num_rows() > 0 ? $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $invoice_request['patient_id']))->row()->mobile_number) : 'Mobile not found.';
                $data['month']              =   date('F', $invoice_request['created_on']);
                $data['year']               =   date('Y', $invoice_request['created_on']);

                array_push($revenue_details, $data);
            }

            $cafeteria_sales = $this->security->xss_clean($this->db->get_where('cafeteria_sale', array('status' => 1))->result_array());
            foreach ($cafeteria_sales as $cafeteria_sale) {
                $data['source']             =   'Cafeteria';
                $data['amount']             =   $cafeteria_sale['discount'] ? $cafeteria_sale['grand_total'] - ($cafeteria_sale['grand_total'] * $cafeteria_sale['discount'] / 100) : $cafeteria_sale['grand_total'];
                $data['consumer']           =   $cafeteria_sale['customer_name'];
                $data['consumer_mobile']    =   $cafeteria_sale['customer_mobile'];
                $data['month']              =   date('F', $cafeteria_sale['created_on']);
                $data['year']               =   date('Y', $cafeteria_sale['created_on']);

                array_push($revenue_details, $data);
            }
        }

        return $revenue_details;
    }

    public function read_expense($year = '', $month = '')
    {
        $expense_total      =   0;
        $payroll_expense    =   0;

        if ($year != '' && $month != '') {
            $expenses = $this->security->xss_clean($this->db->get_where('expense', array('month' => $month, 'year' => $year))->result_array());
            foreach ($expenses as $expense) {
                $expense_total      +=  $expense['amount'];
            }

            $array = array('status' => 1, 'month' => $month, 'year' => $year);
            $this->db->where($array);

            $payroll = $this->security->xss_clean($this->db->get('payroll')->result_array());
            foreach ($payroll as $payroll_row) {
                $payroll_expense    +=  $payroll_row['amount'];
            }
        } else {
            $expenses = $this->security->xss_clean($this->db->get('expense')->result_array());
            foreach ($expenses as $expense) {
                $expense_total      +=  $expense['amount'];
            }

            $payroll = $this->security->xss_clean($this->db->get_where('payroll', array('status' => 1))->result_array());
            foreach ($payroll as $payroll_row) {
                $payroll_expense    +=  $payroll_row['amount'];
            }
        }

        return $expense_total + $payroll_expense;
    }

    // Creating inventory
    public function create_inventory()
    {
        $data['inventory_id']   =   $this->uuid->v4();
        $data['item']           =   $this->input->post('item', TRUE);
        $data['quantity']       =   $this->input->post('quantity', TRUE);
        $data['description']    =   $this->input->post('description', TRUE);
        $data['created_on']     =   time();
        $data['created_by']     =   $this->session->userdata('user_id');
        $data['timestamp']      =   time();
        $data['updated_by']     =   $this->session->userdata('user_id');

        $this->db->insert('inventory', $data);

        $this->session->set_flashdata('success', 'Inventory item has been created successfully');

        redirect(base_url() . 'inventory', 'refresh');
    }

    // Updating inventory
    function update_inventory($param = '')
    {
        $data['item']           =   $this->input->post('item', TRUE);
        $data['quantity']       =   $this->input->post('quantity', TRUE);
        $data['description']    =   $this->input->post('description', TRUE);
        $data['timestamp']      =   time();
        $data['updated_by']     =   $this->session->userdata('user_id');

        $this->db->where('inventory_id', $param);
        $this->db->update('inventory', $data);

        $this->session->set_flashdata('success', 'Inventory item has been updated successfully.');

        redirect(base_url() . 'inventory', 'refresh');
    }

    // Deleting inventory
    function delete_inventory($param = '')
    {
        $this->db->where('inventory_id', $param);
        $this->db->delete('inventory');

        $this->session->set_flashdata('success', 'Inventory item has been deleted successfully.');

        redirect(base_url() . 'inventory', 'refresh');
    }

    // Creating expense
    public function create_expense()
    {
        $data['expense_id']     =   $this->uuid->v4();
        $data['name']           =   $this->input->post('name', TRUE);
        $data['amount']         =   $this->input->post('amount', TRUE);
        $data['description']    =   $this->input->post('description', TRUE);
        $data['year']           =   $this->input->post('year', TRUE);
        $data['month']          =   $this->input->post('month', TRUE);
        $data['created_on']     =   time();
        $data['created_by']     =   $this->session->userdata('user_id');
        $data['timestamp']      =   time();
        $data['updated_by']     =   $this->session->userdata('user_id');

        $this->db->insert('expense', $data);

        $this->session->set_flashdata('success', 'Expense has been created successfully');

        redirect(base_url() . 'expenses', 'refresh');
    }

    // Updating expense
    function update_expense($param = '')
    {
        $data['name']           =   $this->input->post('name', TRUE);
        $data['amount']         =   $this->input->post('amount', TRUE);
        $data['description']    =   $this->input->post('description', TRUE);
        $data['year']           =   $this->input->post('year', TRUE);
        $data['month']          =   $this->input->post('month', TRUE);
        $data['timestamp']      =   time();
        $data['updated_by']     =   $this->session->userdata('user_id');

        $this->db->where('expense_id', $param);
        $this->db->update('expense', $data);

        $this->session->set_flashdata('success', 'Expense has been updated successfully.');

        redirect(base_url() . 'expenses', 'refresh');
    }

    // Deleting expense
    function delete_expense($param = '')
    {
        $this->db->where('expense_id', $param);
        $this->db->delete('expense');

        $this->session->set_flashdata('success', 'Expense has been deleted successfully.');

        redirect(base_url() . 'expenses', 'refresh');
    }

    // Creating blood request
    public function create_blood_request()
    {
        $data['blood_request_id']       =   $this->uuid->v4();
        $data['blood_inventory_id']     =   $this->input->post('blood_inventory_id', TRUE);
        $data['blood_donor_id']         =   $this->input->post('blood_donor_id', TRUE);
        $data['num_of_bags']            =   1;
        $data['purpose']                =   $this->input->post('purpose', TRUE);
        $data['status']                 =   0;
        $data['doctor_id']              =   $this->input->post('doctor_id', TRUE);
        $data['created_on']             =   time();
        $data['created_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->insert('blood_request', $data);

        $this->session->set_flashdata('success', 'Blood request has been created successfully');

        redirect(base_url() . 'blood_requests', 'refresh');
    }

    // Updating blood request details
    public function update_blood_request_details($param = '')
    {
        $data['blood_inventory_id']     =   $this->input->post('blood_inventory_id', TRUE);
        $data['num_of_bags']            =   1;
        $data['blood_donor_id']         =   $this->input->post('blood_donor_id', TRUE);
        $data['purpose']                =   $this->input->post('purpose', TRUE);
        $data['doctor_id']              =   $this->input->post('doctor_id', TRUE);
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->where('blood_request_id', $param);
        $this->db->update('blood_request', $data);

        $db_blood_donor_id              =   $this->security->xss_clean($this->db->get_where('blood_request', array('blood_request_id' => $param))->row()->blood_donor_id);
        $db_blood_request_status        =   $this->security->xss_clean($this->db->get_where('blood_request', array('blood_request_id' => $param))->row()->status);

        if ($db_blood_request_status != 0 && $db_blood_donor_id != $data['blood_donor_id']) {
            $data2['status']            =   0;
            $data2['timestamp']         =   time();
            $data2['updated_by']        =   $this->session->userdata('user_id');

            $this->db->where('blood_donor_id', $db_blood_donor_id);
            $this->db->update('blood_donor', $data2);

            $data3['status']            =   1;
            $data3['timestamp']         =   time();
            $data3['updated_by']        =   $this->session->userdata('user_id');

            $this->db->where('blood_donor_id', $data['blood_donor_id']);
            $this->db->update('blood_donor', $data3);
        }

        $this->session->set_flashdata('success', 'Blood request details has been updated successfully');

        redirect(base_url() . 'blood_requests', 'refresh');
    }

    // Updating blood request status
    public function update_blood_request_status($param = '')
    {
        $data['status']                 =   $this->input->post('status', TRUE);
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        if ($data['status'] == 1) {
            $blood_inventory_id         =   $this->security->xss_clean($this->db->get_where('blood_request', array('blood_request_id' => $param))->row()->blood_inventory_id);
            $blood_group_inventory      =   $this->security->xss_clean($this->db->get_where('blood_inventory', array('blood_inventory_id' => $blood_inventory_id))->row()->num_of_bags);
            $requested_num_of_bags      =   1;

            if ($blood_group_inventory > $requested_num_of_bags) {
                $data2['num_of_bags']   =   $blood_group_inventory - $requested_num_of_bags;
                $data2['timestamp']     =   time();
                $data2['updated_by']    =   $this->session->userdata('user_id');

                $this->db->where('blood_inventory_id', $blood_inventory_id);
                $this->db->update('blood_inventory', $data2);

                $data3['status']                 =   1;
                $data3['timestamp']              =   time();
                $data3['updated_by']             =   $this->session->userdata('user_id');

                $this->db->where('blood_donor_id', $this->security->xss_clean($this->db->get_where('blood_request', array('blood_request_id' => $param))->row()->blood_donor_id));
                $this->db->update('blood_donor', $data3);
            } else {
                $this->session->set_flashdata('warning', 'Blood request status has not been updated successfully, because number of bags avaialable is ' . $blood_group_inventory);

                redirect(base_url() . 'blood_requests', 'refresh');
            }
        }

        $this->db->where('blood_request_id', $param);
        $this->db->update('blood_request', $data);

        $this->session->set_flashdata('success', 'Blood request status has been updated successfully');

        redirect(base_url() . 'blood_requests', 'refresh');
    }

    // Updating blood request status
    public function delete_blood_request_details($param = '')
    {
        $blood_request_status   =   $this->security->xss_clean($this->db->get_where('blood_request', array('blood_request_id' => $param))->row()->status);

        if ($blood_request_status) {
            $blood_donor_id     =   $this->security->xss_clean($this->db->get_where('blood_request', array('blood_request_id' => $param))->row()->blood_donor_id);

            $this->db->where('blood_donor_id', $blood_donor_id);
            $this->db->delete('blood_donor');
        }

        $this->db->where('blood_request_id', $param);
        $this->db->delete('blood_request');

        $this->session->set_flashdata('success', 'Blood request status has been deleted successfully');

        redirect(base_url() . 'blood_requests', 'refresh');
    }

    // Updating blood inventory
    public function update_blood_inventory()
    {
        $num_of_bags                    =   $this->input->post('num_of_bags', TRUE);

        foreach ($num_of_bags as $key => $value) {
            $data['num_of_bags']        =   $value;
            $data['updated_by']         =   $this->session->userdata('user_id');
            $data['timestamp']          =   time();

            $this->db->where('blood_inventory_id', $key + 1);
            $this->db->update('blood_inventory', $data);
        }

        $this->session->set_flashdata('success', 'Blood inventory has been updated successfully');

        redirect(base_url() . 'blood_inventory', 'refresh');
    }

    // Updating blood inventory according to blood group
    public function update_blood_group_inventory($param = '')
    {
        $data['num_of_bags']            =   $this->input->post('num_of_bags', TRUE);
        $data['updated_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();

        $this->db->where('blood_inventory_id', $param);
        $this->db->update('blood_inventory', $data);

        $this->session->set_flashdata('success', 'Blood inventory has been updated successfully');

        redirect(base_url() . 'blood_inventory', 'refresh');
    }

    // Creating blood donor
    public function create_blood_donor()
    {
        $data['blood_donor_id']         =   $this->uuid->v4();
        $data['name']                   =   $this->input->post('name', TRUE);
        $data['blood_inventory_id']     =   $this->input->post('blood_inventory_id', TRUE);
        $data['mobile_number']          =   $this->input->post('mobile_number', TRUE);
        $data['email']                  =   $this->input->post('email', TRUE);
        $data['address']                =   $this->input->post('address_1', TRUE) . '<br>' . $this->input->post('address_2', TRUE);
        $data['last_donated_on']        =   strtotime($this->input->post('last_donated_on', TRUE));
        $data['profession_id']          =   $this->input->post('profession_id', TRUE);
        $data['purpose']                =   $this->input->post('purpose', TRUE);
        $data['dob']                    =   strtotime($this->input->post('dob', TRUE));
        $data['age']                    =   $this->input->post('age', TRUE);
        $data['sex_id']                 =   $this->input->post('sex_id', TRUE);
        $data['health_status']          =   $this->input->post('health_status', TRUE);
        $data['status']                 =   0;
        $data['created_on']             =   time();
        $data['created_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->insert('blood_donor', $data);

        $blood_group_inventory          =   $this->security->xss_clean($this->db->get_where('blood_inventory', array('blood_inventory_id' => $data['blood_inventory_id']))->row()->num_of_bags);

        $data2['num_of_bags']           =   $blood_group_inventory + 1;
        $data2['timestamp']             =   time();
        $data2['updated_by']            =   $this->session->userdata('user_id');

        $this->db->where('blood_inventory_id', $data['blood_inventory_id']);
        $this->db->update('blood_inventory', $data2);

        $this->session->set_flashdata('success', 'Blood donor has been created successfully');

        redirect(base_url() . 'blood_donors', 'refresh');
    }

    // Updating blood donor details
    public function update_blood_donor_details($param = '')
    {
        $data['name']                   =   $this->input->post('name', TRUE);
        $data['blood_inventory_id']     =   $this->input->post('blood_inventory_id', TRUE);
        $data['mobile_number']          =   $this->input->post('mobile_number', TRUE);
        $data['email']                  =   $this->input->post('email', TRUE);
        $data['address']                =   $this->input->post('address_1', TRUE) . '<br>' . $this->input->post('address_2', TRUE);
        $data['last_donated_on']        =   strtotime($this->input->post('last_donated_on', TRUE));
        $data['profession_id']          =   $this->input->post('profession_id', TRUE);
        $data['purpose']                =   $this->input->post('purpose', TRUE);
        $data['dob']                    =   strtotime($this->input->post('dob', TRUE));
        $data['age']                    =   $this->input->post('age', TRUE);
        $data['sex_id']                 =   $this->input->post('sex_id', TRUE);
        $data['health_status']          =   $this->input->post('health_status', TRUE);
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->where('blood_donor_id', $param);
        $this->db->update('blood_donor', $data);

        $this->session->set_flashdata('success', 'Blood donor details has been updated successfully');

        redirect(base_url() . 'blood_donors', 'refresh');
    }

    // Deleting blood donor details
    public function delete_blood_donor_details($param = '')
    {
        $blood_donor_status = $this->security->xss_clean($this->db->get_where('blood_donor', array('blood_donor_id' => $param))->row()->status);

        if ($blood_donor_status) {
            $this->db->where('blood_donor_id', $param);
            $this->db->delete('blood_request');
        }

        $this->db->where('blood_donor_id', $param);
        $this->db->delete('blood_donor');

        $this->session->set_flashdata('success', 'Blood donor details has been deleted successfully');

        redirect(base_url() . 'blood_donors', 'refresh');
    }

    // Creating report
    public function create_report($param = '')
    {
        $data['report_id']              =   $this->uuid->v4();
        if ($param) {
            $data['patient_id']         =   $this->input->post('patient_id', TRUE);
        } else {
            $data['customer_name']      =   $this->input->post('customer_name', TRUE);
            $data['customer_mobile']    =   $this->input->post('customer_mobile', TRUE);
        }
        $data['doctor_id']              =   $this->input->post('doctor_id', TRUE);
        $data['is_patient']             =   $param;
        $data['status']                 =   0;
        $data['delivery_date']          =   strtotime($this->input->post('delivery_date', TRUE));
        if ($this->input->post('discount', TRUE)) {
            $data['discount']           =   $this->input->post('discount', TRUE);
        } else {
            $data['discount']           =   0;
        }
        $data['description']            =   $this->input->post('description', TRUE);
        $data['created_on']             =   time();
        $data['created_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $grand_total = 0;
        $report_categories = '';

        for ($i = 0; $i < sizeof($this->input->post('report_category_id', TRUE)); $i++) {
            $data2['report_details_id']     =   $this->uuid->v4();
            $data2['report_category_id']    =   $this->input->post('report_category_id', TRUE)[$i];
            $data2['report_id']             =   $data['report_id'];
            $data2['timestamp']             =   time();
            $data2['total']                 =   $this->security->xss_clean($this->db->get_where('report_category', array('report_category_id' => $data2['report_category_id']))->row()->cost);

            $grand_total                    +=  $data2['total'];
            $report_categories              .=  $this->security->xss_clean($this->db->get_where('report_category', array('report_category_id' => $this->input->post('report_category_id', TRUE)[$i]))->row()->name) . ', ';

            $this->db->insert('report_details', $data2);
        }

        $data['grand_total']            =   $grand_total;

        $this->db->insert('report', $data);

        if ($param) {
            $invoice_request_data['table_name']     =   'report';
            $invoice_request_data['table_row_id']   =   $data['report_id'];
            $invoice_request_data['amount']         =   $data['discount'] ? $data['grand_total'] - ($data['grand_total'] * $data['discount'] / 100) : $data['grand_total'];
            $invoice_request_data['content']        =   'Report generated for Report Categories: ' . substr(trim($report_categories), 0, -1);
            $invoice_request_data['status']         =   0;
            $invoice_request_data['patient_id']     =   $data['patient_id'];
            $invoice_request_data['item']           =   'Report';
            $invoice_request_data['quantity']       =   1;

            $this->create_invoice_request($invoice_request_data);
        }

        $this->session->set_flashdata('success', 'Report has been created successfully');

        redirect(base_url() . 'reports', 'refresh');
    }

    // Updating report details
    public function update_report_details($param = '')
    {
        $is_patient                     =   $this->security->xss_clean($this->db->get_where('report', array('report_id' => $param))->row()->is_patient);

        $data['doctor_id']              =   $this->input->post('doctor_id', TRUE);
        if ($this->input->post('discount', TRUE)) {
            $data['discount']           =   $this->input->post('discount', TRUE);
        } else {
            $data['discount']           =   0;
        }
        if ($is_patient) {
            $data['patient_id']         =   $this->input->post('patient_id', TRUE);
        } else {
            $data['customer_name']      =   $this->input->post('customer_name', TRUE);
            $data['customer_mobile']    =   $this->input->post('customer_mobile', TRUE);
        }
        $data['delivery_date']          =   strtotime($this->input->post('delivery_date', TRUE));
        $data['description']            =   $this->input->post('description', TRUE);
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $report_details                 =   $this->security->xss_clean($this->db->get_where('report_details', array('report_id' => $param))->result_array());

        foreach ($report_details as $report_details_row) {
            $this->db->where('report_id', $report_details_row['report_id']);
            $this->db->delete('report_details');
        }

        $grand_total = 0;
        $report_categories = '';

        for ($i = 0; $i < sizeof($this->input->post('report_category_id', TRUE)); $i++) {
            $data2['report_details_id']     =   $this->uuid->v4();
            $data2['report_category_id']    =   $this->input->post('report_category_id', TRUE)[$i];
            $data2['report_id']             =   $param;
            $data2['timestamp']             =   time();
            $data2['total']                 =   $this->security->xss_clean($this->db->get_where('report_category', array('report_category_id' => $data2['report_category_id']))->row()->cost);

            $grand_total                    +=  $data2['total'];
            $report_categories              .=  $this->security->xss_clean($this->db->get_where('report_category', array('report_category_id' => $this->input->post('report_category_id', TRUE)[$i]))->row()->name) . ', ';

            $this->db->insert('report_details', $data2);
        }

        $data['grand_total']            =   $grand_total;

        $this->db->where('report_id', $param);
        $this->db->update('report', $data);

        if ($is_patient) {
            $invoice_request_data['table_name']     =   'report';
            $invoice_request_data['table_row_id']   =   $param;
            $invoice_request_data['amount']         =   $data['discount'] ? $data['grand_total'] - ($data['grand_total'] * $data['discount'] / 100) : $data['grand_total'];
            $invoice_request_data['content']        =   'Report generated for Report Categories: ' . substr(trim($report_categories), 0, -1);
            $invoice_request_data['patient_id']     =   $data['patient_id'];
            $invoice_request_data['item']           =   'Report';
            $invoice_request_data['quantity']       =   1;

            $this->update_invoice_request($invoice_request_data);
        }

        $this->session->set_flashdata('success', 'Report details has been updated successfully');

        redirect(base_url() . 'reports', 'refresh');
    }

    // Updating report status
    public function update_report_status($param = '')
    {
        $data['status']                 =   $this->input->post('status', TRUE);
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->where('report_id', $param);
        $this->db->update('report', $data);

        $this->session->set_flashdata('success', 'Report status has been updated successfully');

        redirect(base_url() . 'reports', 'refresh');
    }

    // Deleting report details
    public function delete_report_details($param = '')
    {
        $report_details = $this->security->xss_clean($this->db->get_where('report_details', array('report_id' => $param))->result_array());

        foreach ($report_details as $report_details_row) {
            $this->db->where('report_details_id', $report_details_row['report_details_id']);
            $this->db->delete('report_details');
        }

        $this->db->where('report_id', $param);
        $this->db->delete('report');

        $this->session->set_flashdata('success', 'Report has been deleted successfully');

        redirect(base_url() . 'reports', 'refresh');
    }

    // Creating report categories
    public function create_report_category()
    {
        $data['report_category_id']     =   $this->uuid->v4();
        $data['name']                   =   $this->input->post('name', TRUE);
        $data['cost']                   =   $this->input->post('cost', TRUE);
        $data['laboratory_id']          =   $this->input->post('laboratory_id', TRUE);
        $data['created_on']             =   time();
        $data['created_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->insert('report_category', $data);

        $this->session->set_flashdata('success', 'Report category has been created successfully');

        redirect(base_url() . 'report_categories', 'refresh');
    }

    // Updating report categories
    public function update_report_category_details($param = '')
    {
        $data['name']                   =   $this->input->post('name', TRUE);
        $data['cost']                   =   $this->input->post('cost', TRUE);
        $data['laboratory_id']          =   $this->input->post('laboratory_id', TRUE);
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->where('report_category_id', $param);
        $this->db->update('report_category', $data);

        $this->session->set_flashdata('success', 'Report category has been updated successfully');

        redirect(base_url() . 'report_categories', 'refresh');
    }

    // Deleting report category
    public function delete_report_category_details($param = '')
    {
        $report_details = $this->security->xss_clean($this->db->get_where('report_details', array('report_category_id' => $param))->result_array());

        foreach ($report_details as $report_details_row) {
            $this->db->where('report_details_id', $report_details_row['report_details_id']);
            $this->db->delete('report_details');
        }

        $this->db->where('report_category_id', $param);
        $this->db->delete('report_category');

        $this->session->set_flashdata('success', 'Report category has been deleted successfully');

        redirect(base_url() . 'report_categories', 'refresh');
    }

    // Creating laboratories
    public function create_laboratory()
    {
        $data['laboratory_id']          =   $this->uuid->v4();
        $data['name']                   =   $this->input->post('name', TRUE);
        $data['room_number']            =   $this->input->post('room_number', TRUE);
        $data['created_on']             =   time();
        $data['created_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->insert('laboratory', $data);

        $this->session->set_flashdata('success', 'Laboratory has been created successfully');

        redirect(base_url() . 'laboratories', 'refresh');
    }

    // Updating laboratories
    public function update_laboratory_details($param = '')
    {
        $data['name']                   =   $this->input->post('name', TRUE);
        $data['room_number']            =   $this->input->post('room_number', TRUE);
        $data['created_on']             =   time();
        $data['created_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->where('laboratory_id', $param);
        $this->db->update('laboratory', $data);

        $this->session->set_flashdata('success', 'Laboratory has been updated successfully');

        redirect(base_url() . 'laboratories', 'refresh');
    }

    // Deleting laboratories
    public function delete_laboratory_details($param = '')
    {
        $this->db->where('laboratory_id', $param);
        $this->db->delete('laboratory');

        $this->session->set_flashdata('success', 'Laboratory has been deleted successfully');

        redirect(base_url() . 'laboratories', 'refresh');
    }

    // Creating notices
    public function create_notice()
    {
        $data['notice_id']              =   $this->uuid->v4();
        $data['title']                  =   $this->input->post('title', TRUE);
        $data['notice']                 =   $this->input->post('notice', TRUE);
        $data['created_on']             =   time();
        $data['created_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->insert('notice', $data);

        $this->session->set_flashdata('success', 'Notice has been created successfully');

        redirect(base_url() . 'notices', 'refresh');
    }

    // Updating notice details
    public function update_notice_details($param = '')
    {
        $data['title']                  =   $this->input->post('title', TRUE);
        $data['notice']                 =   $this->input->post('notice', TRUE);
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->where('notice_id', $param);
        $this->db->update('notice', $data);

        $this->session->set_flashdata('success', 'Notice has been updated successfully');

        redirect(base_url() . 'notices', 'refresh');
    }

    // Deleting notice details
    public function delete_notice_details($param = '')
    {
        $this->db->where('notice_id', $param);
        $this->db->delete('notice');

        $this->session->set_flashdata('success', 'Notice has been deleted successfully');

        redirect(base_url() . 'notices', 'refresh');
    }

    // Creating feedback
    public function create_feedback()
    {
        $data['feedback_id']            =   $this->uuid->v4();
        $data['feedback']               =   $this->input->post('feedback', TRUE);
        $data['user_id']                =   $this->input->post('user_id', TRUE);
        $data['created_on']             =   time();
        $data['created_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->insert('feedback', $data);

        $this->session->set_flashdata('success', 'Feedback has been created successfully');

        redirect(base_url() . 'feedback_and_ratings', 'refresh');
    }

    // Updating feedback
    public function update_feedback_details($param = '')
    {
        $data['feedback']               =   $this->input->post('feedback', TRUE);
        $data['user_id']                =   $this->input->post('user_id', TRUE);
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->where('feedback_id', $param);
        $this->db->update('feedback', $data);

        $this->session->set_flashdata('success', 'Feedback has been updated successfully');

        redirect(base_url() . 'feedback_and_ratings', 'refresh');
    }

    // Deleting feedback
    public function delete_feedback_details($param = '')
    {
        $this->db->where('feedback_id', $param);
        $this->db->delete('feedback');

        $this->session->set_flashdata('success', 'Feedback has been deleted successfully');

        redirect(base_url() . 'feedback_and_ratings', 'refresh');
    }

    // Creating rating
    public function create_rating()
    {
        $data['rating_id']              =   $this->uuid->v4();
        $data['rating']                 =   $this->input->post('rating', TRUE);
        $data['user_id']                =   $this->input->post('user_id', TRUE);
        $data['created_on']             =   time();
        $data['created_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->insert('rating', $data);

        $this->session->set_flashdata('success', 'Rating has been created successfully');

        redirect(base_url() . 'feedback_and_ratings', 'refresh');
    }

    // Updating rating
    public function update_rating_details($param = '')
    {
        $data['rating']                 =   $this->input->post('rating', TRUE);
        $data['user_id']                =   $this->input->post('user_id', TRUE);
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->where('rating_id', $param);
        $this->db->update('rating', $data);

        $this->session->set_flashdata('success', 'Rating has been updated successfully');

        redirect(base_url() . 'feedback_and_ratings', 'refresh');
    }

    // Deleting rating details
    public function delete_rating_details($param = '')
    {
        $this->db->where('rating_id', $param);
        $this->db->delete('rating');

        $this->session->set_flashdata('success', 'Rating has been deleted successfully');

        redirect(base_url() . 'feedback_and_ratings', 'refresh');
    }

    // Creating ceritificates
    public function create_certicate($param = '')
    {
        $data['certificate_id']         =   $this->uuid->v4();
        $data['certificate_type']       =   $param;
        $data['name']                   =   $this->input->post('name', TRUE);
        $data['father_name']            =   $this->input->post('father_name', TRUE);
        $data['mother_name']            =   $this->input->post('mother_name', TRUE);
        $data['sex_id']                 =   $this->input->post('sex_id', TRUE);
        if ($this->input->post('dod', TRUE)) {
            $data['dod']                =   strtotime($this->input->post('dod', TRUE));
        } else {
            $data['dod']                =   0;
        }
        $data['address']                =   $this->input->post('address_1', TRUE) . '<br>' . $this->input->post('address_2', TRUE);
        $data['age']                    =   $this->input->post('age', TRUE);
        $data['dob']                    =   strtotime($this->input->post('dob', TRUE));
        $data['extra_note']             =   $this->input->post('extra_note', TRUE);
        $data['place']                  =   $this->input->post('place_1', TRUE) . '<br>' . $this->input->post('place_2', TRUE);
        $data['reason']                 =   $this->input->post('reason', TRUE);
        $data['email']                  =   $this->input->post('email', TRUE);
        $data['mobile_number']          =   $this->input->post('mobile_number', TRUE);
        $data['doctor_id']              =   $this->input->post('doctor_id', TRUE);
        $data['created_on']             =   time();
        $data['created_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->insert('certificate', $data);

        $this->session->set_flashdata('success', 'Certificate has been created successfully');

        redirect(base_url() . 'certificates', 'refresh');
    }

    // Updating certificates
    public function update_certificate_details($param = '')
    {
        $data['name']                   =   $this->input->post('name', TRUE);
        $data['father_name']            =   $this->input->post('father_name', TRUE);
        $data['mother_name']            =   $this->input->post('mother_name', TRUE);
        $data['sex_id']                 =   $this->input->post('sex_id', TRUE);
        if ($this->input->post('dod', TRUE)) {
            $data['dod']                =   strtotime($this->input->post('dod', TRUE));
        } else {
            $data['dod']                =   0;
        }
        $data['address']                =   $this->input->post('address_1', TRUE) . '<br>' . $this->input->post('address_2', TRUE);
        $data['age']                    =   $this->input->post('age', TRUE);
        $data['dob']                    =   strtotime($this->input->post('dob', TRUE));
        $data['extra_note']             =   $this->input->post('extra_note', TRUE);
        $data['place']                  =   $this->input->post('place_1', TRUE) . '<br>' . $this->input->post('place_2', TRUE);
        $data['reason']                 =   $this->input->post('reason', TRUE);
        $data['email']                  =   $this->input->post('email', TRUE);
        $data['mobile_number']          =   $this->input->post('mobile_number', TRUE);
        $data['doctor_id']              =   $this->input->post('doctor_id', TRUE);
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->where('certificate_id', $param);
        $this->db->update('certificate', $data);

        $this->session->set_flashdata('success', 'Certificate details has been update successfully');

        redirect(base_url() . 'certificates', 'refresh');
    }

    // Deleting certificate
    public function delete_certificate_details($param = '')
    {
        $this->db->where('certificate_id', $param);
        $this->db->delete('certificate');

        $this->session->set_flashdata('success', 'Certificate details has been deleted successfully');

        redirect(base_url() . 'certificates', 'refresh');
    }

    // Creating medicine
    public function create_medicine()
    {
        $data['medicine_id']        =   $this->uuid->v4();
        $data['name']               =   $this->input->post('name', TRUE);
        $data['created_on']         =   time();
        $data['created_by']         =   $this->session->userdata('user_id');
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->insert('medicine', $data);

        $this->session->set_flashdata('success', 'Medicine has been created successfully');

        redirect(base_url() . 'medicines', 'refresh');
    }

    // Updating medicine
    public function update_medicine_details($param = '')
    {
        $data['name']               =   $this->input->post('name', TRUE);
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->where('medicine_id', $param);
        $this->db->update('medicine', $data);

        $this->session->set_flashdata('success', 'Medicine has been updated successfully');

        redirect(base_url() . 'medicines', 'refresh');
    }

    // Deleting medicine
    public function delete_medicine_details($param = '')
    {
        $this->db->where('medicine_id', $param);
        $this->db->delete('medicine');

        $this->session->set_flashdata('success', 'Medicine has been deleted successfully');

        redirect(base_url() . 'medicines', 'refresh');
    }

    // Creating disease
    public function create_disease()
    {
        $data['disease_id']         =   $this->uuid->v4();
        $data['name']               =   $this->input->post('name', TRUE);
        $data['created_on']         =   time();
        $data['created_by']         =   $this->session->userdata('user_id');
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->insert('disease', $data);

        $this->session->set_flashdata('success', 'Disease has been created successfully');

        redirect(base_url() . 'diseases', 'refresh');
    }

    // Updating disease
    public function update_disease_details($param = '')
    {
        $data['name']               =   $this->input->post('name', TRUE);
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->where('disease_id', $param);
        $this->db->update('disease', $data);

        $this->session->set_flashdata('success', 'Disease has been updated successfully');

        redirect(base_url() . 'diseases', 'refresh');
    }

    // Deleting disease
    public function delete_disease_details($param = '')
    {
        $this->db->where('disease_id', $param);
        $this->db->delete('disease');

        $this->session->set_flashdata('success', 'Disease has been deleted successfully');

        redirect(base_url() . 'diseases', 'refresh');
    }

    // Creating rosters
    public function create_roster()
    {
        $data['roster_id']          =   $this->uuid->v4();
        $data['duty_on']            =   strtotime($this->input->post('duty_on', TRUE));
        $data['shift_id']           =   $this->input->post('shift_id', TRUE);
        $data['staff_id']           =   $this->input->post('staff_id', TRUE);
        $data['extra_note']         =   $this->input->post('extra_note', TRUE);
        $data['status']             =   0;
        $data['type']               =   0;
        $data['created_on']         =   time();
        $data['created_by']         =   $this->session->userdata('user_id');
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->insert('roster', $data);

        $this->session->set_flashdata('success', 'Roster has been created successfully');

        redirect(base_url() . 'rosters', 'refresh');
    }

    // Updating roster details
    public function update_roster_details($param = '')
    {
        $data['duty_on']            =   strtotime($this->input->post('duty_on', TRUE));
        $data['shift_id']           =   $this->input->post('shift_id', TRUE);
        $data['staff_id']           =   $this->input->post('staff_id', TRUE);
        $data['extra_note']         =   $this->input->post('extra_note', TRUE);
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->where('roster_id', $param);
        $this->db->update('roster', $data);

        $this->session->set_flashdata('success', 'Details of the roster has updated successfully');

        redirect(base_url() . 'rosters', 'refresh');
    }

    // Updating roster status
    public function update_roster_status($param = '')
    {
        $data['status']             =   $this->input->post('status', TRUE);
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->where('roster_id', $param);
        $this->db->update('roster', $data);

        $this->session->set_flashdata('success', 'Status of the roster has updated successfully');

        redirect(base_url() . 'rosters', 'refresh');
    }

    // Deleting roster details
    public function delete_roster_details($param = '')
    {
        $this->db->where('roster_id', $param);
        $this->db->delete('roster');

        $this->session->set_flashdata('success', 'Details of the roster has deleted successfully');

        redirect(base_url() . 'rosters', 'refresh');
    }

    // Reading staff duties
    public function read_staff_duties($param = '')
    {
        return $this->security->xss_clean($this->db->get_where('roster', array('staff_id' => $this->security->xss_clean($this->db->get_where('user', array('user_id' => $param))->row()->staff_id)))->result_array());
    }

    // Creating staff category
    public function create_shift_category()
    {
        $data['staff_category_id']  =   $this->uuid->v4();
        $data['name']               =   $this->input->post('name', TRUE);
        $data['uri']                =   strtolower(str_replace(' ', '-', $this->input->post('name', TRUE)));
        $data['is_doctor']          =   $this->input->post('is_doctor', TRUE);
        $data['payment_type']       =   $this->input->post('payment_type', TRUE);
        if ($this->input->post('pay_scale', TRUE)) {
            $data['pay_scale']      =   $this->input->post('pay_scale', TRUE);
        } else {
            $data['pay_scale']      =   0;
        }
        $data['duties']             =   $this->input->post('duties', TRUE);
        $data['created_on']         =   time();
        $data['created_by']         =   $this->session->userdata('user_id');
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->insert('staff_category', $data);

        $this->session->set_flashdata('success', 'Shift category has been created successfully');

        redirect(base_url() . 'shift_categories', 'refresh');
    }

    // Updating staff category
    public function update_shift_category($param = '')
    {
        $data['name']               =   $this->input->post('name', TRUE);
        $data['uri']                =   strtolower(str_replace(' ', '-', $this->input->post('name', TRUE)));
        $data['is_doctor']          =   $this->input->post('is_doctor', TRUE);
        $data['payment_type']       =   $this->input->post('payment_type', TRUE);
        if ($this->input->post('pay_scale', TRUE)) {
            $data['pay_scale']      =   $this->input->post('pay_scale', TRUE);
        } else {
            $data['pay_scale']      =   0;
        }
        $data['duties']             =   $this->input->post('duties', TRUE);
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->where('staff_category_id', $param);
        $this->db->update('staff_category', $data);

        $this->session->set_flashdata('success', 'Shift category has been updated successfully');

        redirect(base_url() . 'shift_categories', 'refresh');
    }

    // Updating shift
    public function update_shift_permission($param = '')
    {
        $permission                 =   $this->input->post('permission', TRUE);

        $permissions                =   '';
        if (isset($permission)) {
            foreach ($permission as $key => $value) {
                $permissions        .=  $value . ',';
            }
        }

        $data['permissions']        =   substr(trim($permissions), 0, -1);
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->where('staff_category_id', $param);
        $this->db->update('staff_category', $data);

        // $this->session->set_userdata('permissions', explode(",", $data['permissions']));

        $this->session->set_flashdata('success', 'Shift category permission has been updated successfully.');

        redirect(base_url() . 'shift_categories', 'refresh');
    }

    // Deleting staff category
    public function delete_shift_category($param = '')
    {
        $name   =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $param))->row()->name);

        $shifts = $this->security->xss_clean($this->db->get_where('shift', array('staff_category_id' => $param))->result_array());

        foreach ($shifts as $shift) {
            $this->db->where('shift_id', $shift['shift_id']);
            $this->db->delete('shift');
        }

        $this->session->set_flashdata('success', 'All Shifts has been deleted successfully of this category ' . $name);

        redirect(base_url() . 'shift_categories', 'refresh');
    }

    // Creating shifts
    public function create_shift($param = '')
    {
        $name                       =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $param))->row()->name);
        $is_doctor                  =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $param))->row()->is_doctor);

        $data['shift_id']           =   $this->uuid->v4();
        $data['shift_starts']       =   $this->input->post('shift_starts', TRUE);
        $data['shift_ends']         =   $this->input->post('shift_ends', TRUE);
        $data['staff_category_id']  =   $param;
        $data['is_doctor']          =   $is_doctor;
        $data['created_on']         =   time();
        $data['created_by']         =   $this->session->userdata('user_id');
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->insert('shift', $data);

        $this->session->set_flashdata('success', 'Shift of ' . $name . ' has been created successfully');

        redirect(base_url() . 'shifts/' . $param, 'refresh');
    }

    // Updating shifts
    public function update_shift_details($param = '')
    {
        $staff_category_id          =   $this->security->xss_clean($this->db->get_where('shift', array('shift_id' => $param))->row()->staff_category_id);
        $name                       =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $staff_category_id))->row()->name);

        $data['shift_starts']       =   $this->input->post('shift_starts', TRUE);
        $data['shift_ends']         =   $this->input->post('shift_ends', TRUE);
        $data['timestamp']          =   time();
        $data['updated_by']         =   $this->session->userdata('user_id');

        $this->db->where('shift_id', $param);
        $this->db->update('shift', $data);

        $this->session->set_flashdata('success', 'Shift of ' . $name . ' has been updated successfully');

        redirect(base_url() . 'shifts/' . $staff_category_id, 'refresh');
    }

    // Deleting shifts
    public function delete_shift_details($param = '')
    {
        $staff_category_id          =   $this->security->xss_clean($this->db->get_where('shift', array('shift_id' => $param))->row()->staff_category_id);
        $name                       =   $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $staff_category_id))->row()->name);

        $this->db->where('shift_id', $param);
        $this->db->delete('shift');

        $this->session->set_flashdata('success', 'Shift of ' . $name . ' has been deleted successfully');

        redirect(base_url() . 'shifts/' . $staff_category_id, 'refresh');
    }

    // Reading invoice request
    public function read_invoice_request($param = '')
    {
        return json_encode($this->db->get_where('invoice_request', array('patient_id' => $param, 'status' => 0))->result_array());
    }

    // Creating invoice request
    public function create_custom_invoice_request()
    {
        $custom_invoice_item_ids_input  =   $this->input->post('custom_invoice_item_ids', TRUE);
        $quantities_input               =   $this->input->post('quantities', TRUE);

        foreach ($custom_invoice_item_ids_input as $key => $value) {
            $data['invoice_request_id']     =   $this->uuid->v4();
            $data['table_name']             =   'custom_invoice_item';
            $data['table_row_id']           =   $value;
            $data['amount']                 =   $this->security->xss_clean($this->db->get_where('custom_invoice_item', array('custom_invoice_item_id' => $value))->row()->cost);
            $data['content']                =   $this->security->xss_clean($this->db->get_where('custom_invoice_item', array('custom_invoice_item_id' => $value))->row()->content);
            $data['created_on']             =   time();
            $data['created_by']             =   $this->session->userdata('user_id');
            $data['timestamp']              =   time();
            $data['updated_by']             =   $this->session->userdata('user_id');
            $data['status']                 =   0;
            $data['patient_id']             =   $this->input->post('patient_id', TRUE);
            $data['item']                   =   $this->security->xss_clean($this->db->get_where('custom_invoice_item', array('custom_invoice_item_id' => $value))->row()->item);
            $data['quantity']               =   $quantities_input[$key];
            $data['is_custom']              =   1;

            $this->db->insert('invoice_request', $data);
        }

        $this->session->set_flashdata('success', 'Invoice request has been created successfully');

        redirect(base_url() . 'invoice_requests', 'refresh');
    }

    // Updating invoice request
    public function update_custom_invoice_request($param = '')
    {
        $data['patient_id']             =   $this->input->post('patient_id', TRUE);
        $data['table_row_id']           =   $this->input->post('custom_invoice_item_id', TRUE);
        $data['item']                   =   $this->security->xss_clean($this->db->get_where('custom_invoice_item', array('custom_invoice_item_id' => $this->input->post('custom_invoice_item_id', TRUE)))->row()->item);
        $data['quantity']               =   $this->input->post('quantity', TRUE);
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $this->db->where('invoice_request_id', $param);
        $this->db->update('invoice_request', $data);

        $this->session->set_flashdata('success', 'Invoice request has been updated successfully');

        redirect(base_url() . 'invoice_requests', 'refresh');
    }

    // Updating invoice request occurance
    public function update_invoice_request_occurance($param = '')
    {
        $data['quantity']               =   $this->input->post('quantity', TRUE);

        $this->db->where('invoice_request_id', $param);
        $this->db->update('invoice_request', $data);

        $this->session->set_flashdata('success', 'Invoice request occurance has been updated successfully');

        redirect(base_url() . 'invoice_requests', 'refresh');
    }

    // Deleting invoice request
    public function delete_custom_invoice_request($param = '')
    {
        $this->db->where('invoice_request_id', $param);
        $this->db->delete('invoice_request');

        $this->session->set_flashdata('success', 'Invoice request has been deleted successfully');

        redirect(base_url() . 'invoice_requests', 'refresh');
    }

    // Creating invoice request
    private function create_invoice_request($invoice_request_data = [])
    {
        $data['invoice_request_id']     =   $this->uuid->v4();
        $data['table_name']             =   $invoice_request_data['table_name'];
        $data['table_row_id']           =   $invoice_request_data['table_row_id'];
        $data['amount']                 =   $invoice_request_data['amount'];
        $data['content']                =   $invoice_request_data['content'];
        $data['created_on']             =   time();
        $data['created_by']             =   $this->session->userdata('user_id');
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');
        $data['status']                 =   $invoice_request_data['status'];
        $data['patient_id']             =   $invoice_request_data['patient_id'];
        $data['item']                   =   $invoice_request_data['item'];
        $data['quantity']               =   $invoice_request_data['quantity'];
        $data['is_custom']              =   0;

        $this->db->insert('invoice_request', $data);
    }

    // Updating invoice request
    private function update_invoice_request($invoice_request_data = [])
    {
        $data['amount']                 =   $invoice_request_data['amount'];
        $data['content']                =   $invoice_request_data['content'];
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');
        $data['patient_id']             =   $invoice_request_data['patient_id'];
        $data['item']                   =   $invoice_request_data['item'];
        $data['quantity']               =   $invoice_request_data['quantity'];

        $invoice_request_id             =   $this->security->xss_clean($this->db->get_where('invoice_request', array('table_name' => $invoice_request_data['table_name'], 'table_row_id' => $invoice_request_data['table_row_id']))->row()->invoice_request_id);

        $this->db->where('invoice_request_id', $invoice_request_id);
        $this->db->update('invoice_request', $data);
    }

    // Updating invoice request
    private function update_invoice_request_status($invoice_request_data = [])
    {
        $data['status']                 =   $invoice_request_data['status'];
        $data['timestamp']              =   time();
        $data['updated_by']             =   $this->session->userdata('user_id');

        $invoice_request_id             =   $this->security->xss_clean($this->db->get_where('invoice_request', array('table_name' => $invoice_request_data['table_name'], 'table_row_id' => $invoice_request_data['table_row_id']))->row()->invoice_request_id);

        $this->db->where('invoice_request_id', $invoice_request_id);
        $this->db->update('invoice_request', $data);
    }

    // Creating invoice
    public function create_invoice()
    {
        $invoice_request_ids_input  =   $this->input->post('invoice_request_ids', TRUE);

        $patient_id                 =   $this->security->xss_clean($this->db->get_where('invoice_request', array('invoice_request_id' => $invoice_request_ids_input[0]))->row()->patient_id);

        $invoice['invoice_id']      =   $this->uuid->v4();
        $invoice['invoice_number']  =   'INV' . rand(1000000, 1000000000);
        $invoice['discount']        =   $this->input->post('discount', TRUE) ? $this->input->post('discount', TRUE) : 0;
        $invoice['created_on']      =   time();
        $invoice['created_by']      =   $this->session->userdata('user_id');
        $invoice['timestamp']       =   time();
        $invoice['updated_by']      =   $this->session->userdata('user_id');
        $invoice['patient_name']    =   $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->name);
        $invoice['patient_mobile']  =   $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->mobile_number);
        $invoice['patient_address'] =   $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $patient_id))->row()->address);
        $invoice['patient_id']      =   $patient_id;

        $grand_total = 0;
        foreach ($invoice_request_ids_input as $key => $value) {
            $data['invoice_id']             =   $invoice['invoice_id'];
            $data['status']                 =   1;
            $data['timestamp']              =   time();
            $data['updated_by']             =   $this->session->userdata('user_id');

            $amount                         =   $this->security->xss_clean($this->db->get_where('invoice_request', array('invoice_request_id' => $value))->row()->amount);
            $quantity                       =   $this->security->xss_clean($this->db->get_where('invoice_request', array('invoice_request_id' => $value))->row()->quantity);
            $grand_total                    +=  ($amount * $quantity);

            $this->db->where('invoice_request_id', $value);
            $this->db->update('invoice_request', $data);
        }

        $invoice['grand_total']     =   $grand_total;

        $this->db->insert('invoice', $invoice);

        $this->session->set_flashdata('success', 'Invoice has been created successfully');

        redirect(base_url() . 'invoices', 'refresh');
    }

    // Updating invoice
    public function update_invoice($param = '')
    {
        $invoice_request_ids_input  =   $this->input->post('invoice_request_ids', TRUE);
        foreach ($this->security->xss_clean($this->db->get_where('invoice_request', array('invoice_id' => $param))->result_array()) as $item) {
            $nulled['invoice_id']   =   null;
            $nulled['status']       =   0;

            $this->db->where('invoice_request_id', $item['invoice_request_id']);
            $this->db->update('invoice_request', $nulled);
        }

        $invoice['discount']        =   $this->input->post('discount', TRUE) ? $this->input->post('discount', TRUE) : 0;
        $invoice['timestamp']       =   time();
        $invoice['updated_by']      =   $this->session->userdata('user_id');

        $grand_total = 0;
        foreach ($invoice_request_ids_input as $key => $value) {
            $data['invoice_id']             =   $param;
            $data['status']                 =   1;
            $data['timestamp']              =   time();
            $data['updated_by']             =   $this->session->userdata('user_id');

            $amount                         =   $this->security->xss_clean($this->db->get_where('invoice_request', array('invoice_request_id' => $value))->row()->amount);
            $quantity                       =   $this->security->xss_clean($this->db->get_where('invoice_request', array('invoice_request_id' => $value))->row()->quantity);
            $grand_total                    +=  ($amount * $quantity);

            $this->db->where('invoice_request_id', $value);
            $this->db->update('invoice_request', $data);
        }

        $invoice['grand_total']     =   $grand_total;

        $this->db->where('invoice_id', $param);
        $this->db->update('invoice', $invoice);

        $this->session->set_flashdata('success', 'Invoice has been updated successfully');

        redirect(base_url() . 'invoices', 'refresh');
    }

    // Deleting invoice
    public function delete_invoice($param = '')
    {
        foreach ($this->security->xss_clean($this->db->get_where('invoice_request', array('invoice_id' => $param))->result_array()) as $item) {
            $nulled['invoice_id']   =   null;
            $nulled['status']       =   0;

            $this->db->where('invoice_request_id', $item['invoice_request_id']);
            $this->db->update('invoice_request', $nulled);
        }

        $this->db->where('invoice_id', $param);
        $this->db->delete('invoice');

        $this->session->set_flashdata('success', 'Invoice has been deleted successfully');

        redirect(base_url() . 'invoices', 'refresh');
    }

    // Updating porifle image
    public function update_profile_image($user_id = '')
    {
        $ext                        =   pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $data['image_link']     =   $user_id . '.' . $ext;
            $data['timestamp']      =   time();
            $data['updated_by']     =   $this->session->userdata('user_id');

            $is_doctor = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $user_id))->row()->is_doctor);
            $staff_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $user_id))->row()->staff_id);

            if ($is_doctor) {
                $image_link = $this->security->xss_clean($this->db->get_where('doctor', array('doctor_id' => $staff_id))->row()->image_link);
                if (isset($image_link)) unlink('uploads/doctor/' . $image_link);

                move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/doctor/' . $user_id . '.' . $ext);

                $this->db->where('doctor_id', $staff_id);
                $this->db->update('doctor', $data);
            } else {
                $image_link = $this->security->xss_clean($this->db->get_where('staff', array('staff_id' => $staff_id))->row()->image_link);
                if (isset($image_link)) unlink('uploads/staff/' . $image_link);

                move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/staff/' . $user_id . '.' . $ext);

                $this->db->where('staff_id', $staff_id);
                $this->db->update('staff', $data);
            }

            $this->session->set_flashdata('success', 'Your profile image has been uploaded successfully.');

            redirect(base_url() . 'profile_settings', 'refresh');
        } else {
            $this->session->set_flashdata('warning', 'Only supported image types: jpeg, jpg, png');

            redirect(base_url() . 'profile_settings', 'refresh');
        }
    }

    // Updating profile setting
    public function update_profile_settings($user_type = '', $user_id = '')
    {
        if ($user_type == 'staff') {
            $db_password                    =   $this->security->xss_clean($this->db->get_where('user', array('user_id' => $user_id))->row()->password);
            $given_password                 =   $this->input->post('old_password', TRUE);

            $existing_email                 =   $this->security->xss_clean($this->db->get_where('user', array('user_id' => $user_id))->row()->email);

            if (password_verify($given_password, $db_password)) {
                if ($existing_email != $this->input->post('email', TRUE)) {
                    $users = $this->security->xss_clean($this->db->get('user')->result_array());
                    foreach ($users as $user) {
                        if ($user['email'] == $this->input->post('email', TRUE)) {
                            $this->session->set_flashdata('warning', 'The email address is already registered.');

                            redirect(base_url() . 'profile_settings', 'refresh');
                        }
                    }
                }

                $data['email']              =   $this->input->post('email', TRUE);
                $data['password']           =   password_hash($this->input->post('new_password', TRUE), PASSWORD_DEFAULT);

                $this->db->where('user_id', $user_id);
                $this->db->update('user', $data);

                // Updating Doctor/Staff tables
                $is_doctor = $this->db->get_where('user', array('user_id' => $user_id))->row()->is_doctor;
                $staff_category_id = $this->db->get_where('user', array('user_id' => $user_id))->row()->staff_category_id;
                $staff_id = $this->db->get_where('user', array('user_id' => $user_id))->row()->staff_id;
                if ($is_doctor) {
                    $doctor['email']        =   $data['email'];

                    $this->db->where(array('staff_category_id' => $staff_category_id, 'doctor_id' => $staff_id));
                    $this->db->update('doctor', $doctor);
                } else {
                    $staff['email']         =   $data['email'];

                    $this->db->where(array('staff_category_id' => $staff_category_id, 'staff_id' => $staff_id));
                    $this->db->update('staff', $staff);
                }

                $this->session->set_flashdata('success', 'Your profile has been updated successfully.');

                redirect(base_url() . 'profile_settings', 'refresh');
            } else {
                $this->session->set_flashdata('warning', 'Passwords do not match, Try again.');

                redirect(base_url() . 'profile_settings', 'refresh');
            }
        } else {
            $db_password                    =   $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $user_id))->row()->password);
            $given_password                 =   $this->input->post('old_password', TRUE);

            $existing_email                 =   $this->security->xss_clean($this->db->get_where('patient', array('patient_id' => $user_id))->row()->email);

            if (password_verify($given_password, $db_password)) {
                if ($existing_email != $this->input->post('email', TRUE)) {
                    $patients = $this->security->xss_clean($this->db->get('patient')->result_array());
                    foreach ($patients as $patient) {
                        if ($patient['email'] == $this->input->post('email', TRUE)) {
                            $this->session->set_flashdata('warning', 'The email address is already registered.');

                            redirect(base_url() . 'profile_settings', 'refresh');
                        }
                    }
                }

                $data['email']              =   $this->input->post('email', TRUE);
                $data['password']           =   password_hash($this->input->post('new_password', TRUE), PASSWORD_DEFAULT);

                $this->db->where('patient_id', $user_id);
                $this->db->update('patient', $data);

                $this->session->set_flashdata('success', 'Your profile has been updated successfully.');

                redirect(base_url() . 'profile_settings', 'refresh');
            } else {
                $this->session->set_flashdata('warning', 'Passwords do not match, Try again.');

                redirect(base_url() . 'profile_settings', 'refresh');
            }
        }
    }
}