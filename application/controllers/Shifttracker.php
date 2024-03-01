<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shifttracker extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('client_model');
        $this->load->model('shifttracker_model');
        $this->load->model('loan_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('attendance_model');
        $this->load->model('project_model');
        $this->load->library('csvimport');
    }
    
    public function Shifttracker()
    {
        if ($this->session->userdata('user_login_access') != False) {
            #$data['employee'] = $this->employee_model->emselect();
            $data['shifttracker_list'] = $this->shifttracker_model->read("", "", "", "", "", "", 200);
            $data['settingsvalue'] = $this->settings_model->GetSettingsValue();
            $this->load->view('backend/shifttracker', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Save_Shifttracker()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data['employee'] = $this->employee_model->emselect();
            $data['department'] = $this->employee_model->depselect();
            $data['clients'] = $this->client_model->read("", 1);
            $this->load->view('backend/add_shifttracker', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    
    public function getPINFromID($employee_ID) {
        return $this->attendance_model->getPINFromID($employee_ID);
    }
    
    public function Get_attendance_data_for_report()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $date_from   = $this->input->post('date_from');
            $date_to   = $this->input->post('date_to');
            $employee_id   = $this->input->post('employee_id');
            $employee_PIN = $this->getPINFromID($employee_id)->em_code;
            $attendance_data = $this->attendance_model->getAttendanceDataByID($employee_PIN, $date_from, $date_to);
            $data['attendance'] = $attendance_data;
            $attendance_hours = $this->attendance_model->getTotalAttendanceDataByID($employee_PIN, $date_from, $date_to);
            if(!empty($attendance_data)){
            $data['name'] = $attendance_data[0]->name;
            $data['days'] = count($attendance_data);
            $data['hours'] = $attendance_hours;                
            }
            echo json_encode($data);

            /*foreach ($attendance_data as $row) {
                $row =  
                    "<tr>
                        <td>$numbering</td>
                        <td>$row->first_name $row->first_name</td>
                        <td>$row->atten_date</td>
                        <td>$row->signin_time</td>
                        <td>$row->signout_time</td>
                        <td>$row->working_hour</td>
                        <td>Type</td>
                    </tr>";
            }*/
            
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    
    public function Add_Shifttracker()
    {
        if ($this->session->userdata('user_login_access') != False) {
            
            $employee_id    = $this->input->post('employee_id');    
            $client_id      = $this->input->post('client_id');    
            $department     = $this->input->post('department');
            $period         = $this->input->post('period');
            $shift_date     = $this->input->post('shift_date');    
            $client_rate    = $this->input->post('client_rate');    
            $employee_rate  = $this->input->post('employee_rate');
            $break          = $this->input->post('break');
            $start_time     = $this->input->post('start_time');
            $end_time       = $this->input->post('end_time');    
            $mileage        = $this->input->post('mileage');    
            $total_hours    = $this->input->post('total_hours');
            $bank_holiday   = $this->input->post('bank_holiday');
                
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters();
            // Validating Fields
            $this->form_validation->set_rules('employee_id', 'Employee', 'required|xss_clean');
            $this->form_validation->set_rules('client_id', 'Client', 'required|xss_clean');
            $this->form_validation->set_rules('department', 'Department', 'required|xss_clean');
            $this->form_validation->set_rules('period', 'Period', 'required|xss_clean');
            $this->form_validation->set_rules('shift_date', 'Shift Date', 'required|xss_clean');
            $this->form_validation->set_rules('client_rate', 'Client Rate', 'required|xss_clean');
            $this->form_validation->set_rules('employee_rate', 'Employee Rate', 'required|xss_clean');
            $this->form_validation->set_rules('break', 'Break', 'required|xss_clean');
            $this->form_validation->set_rules('total_hours', 'Total Hours', 'required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
            } else {
                if($this->shifttracker_model->checkDuplicate($employee_id, $client_id, $department, $period, $shift_date) ){
                    $this->session->set_flashdata('formdata','Shift Tracker record already Exists. Possible Duplicate');
                    echo "Shift Tracker record already Exists. Possible Duplicate";
                } else {
                
                    $data = array();
                    $data = array(
                        'employee_id'       => $employee_id,
                        'client_id'         => $client_id,
                        'department'        => $department,
                        'period'            => $period,
                        'shift_date'        => $shift_date,
                        'client_rate'       => $client_rate,
                        'employee_rate'     => $employee_rate,
                        'break'             => $break,
                        'start_time'        => $start_time,
                        'end_time'          => $end_time,
                        'mileage'           => $mileage,
                        'total_hours'       => $total_hours,
                        'bank_holiday'      => $bank_holiday,
                    );
               //     print_r($data); die();
                    $success = $this->shifttracker_model->create($data);
                    $this->session->set_flashdata('feedback','Successfully Added');
                    echo "Successfully Added"; 
                
                }
            
            }
        }else{
            redirect(base_url() , 'refresh');
        }
    }
    function import()
    {
        $this->load->library('csvimport');
        $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
        //echo $file_data;
        foreach ($file_data as $row){
            if($row["Check-in at"] > '0:00:00'){
                $date = date('Y-m-d',strtotime($row["Date"]));
                $duplicate = $this->attendance_model->getDuplicateVal($row["Employee No"],$date);
                //print_r($duplicate);
            if(!empty($duplicate)){
            $data = array();
            $data = array(
                'signin_time' => $row["Check-in at"],
                'signout_time' => $row["Check-out at"],
                'working_hour' => $row["Work Duration"],
                'absence' => $row["Absence Duration"],
                'overtime' => $row["Overtime Duration"],
                'status' => 'A',
                'place' => 'office'
            );
            $this->attendance_model->bulk_Update($row["Employee No"],$date,$data);
            } else {
            $data = array();
            $data = array(
                'emp_id' => $row["Employee No"],
                'atten_date' => date('Y-m-d',strtotime($row["Date"])),
                'signin_time' => $row["Check-in at"],
                'signout_time' => $row["Check-out at"],
                'working_hour' => $row["Work Duration"],
                'absence' => $row["Absence Duration"],
                'overtime' => $row["Overtime Duration"],
                'status' => 'A',
                'place' => 'office'
            ); 
                    //echo count($data); 
        $this->attendance_model->Add_AttendanceData($data);          
        }
        }
            else {

            }
        }
         echo "Successfully Updated"; 
        }

}
?>
