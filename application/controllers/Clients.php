<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('client_model');
        $this->load->model('login_model');
        $this->load->model('payroll_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
  
    }
    
	public function index()
	{
		if ($this->session->userdata('user_login_access') != 1)
            redirect(base_url() . 'login', 'refresh');
        if ($this->session->userdata('user_login_access') == 1)
          $data= array();
        redirect('clients/Clients');
	}
    public function Clients(){
        if($this->session->userdata('user_login_access') != False) { 
        $data['clients'] = $this->client_model->read("", 1);
        $this->load->view('backend/clients',$data);
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }
    public function Add_client(){
        if($this->session->userdata('user_login_access') != False) { 
        $this->load->view('backend/add-client');
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }
	public function Save(){ 
        if($this->session->userdata('user_login_access') != false) {    
            $org_name = $this->input->post('org_name');    
            $email = $this->input->post('email');    
        	$phone = $this->input->post('phone');
        	$address = $this->input->post('address');
            	
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters();
            // Validating Fields
            $this->form_validation->set_rules('org_name', 'Organization Name', 'required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'required|xss_clean');
            $this->form_validation->set_rules('phone', 'Phone', 'required|xss_clean');
            $this->form_validation->set_rules('address', 'Address', 'required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
    		} else {
                if($this->client_model->checkOrgName($org_name) ){
                    $this->session->set_flashdata('formdata','Organization Name already Exists');
                    echo "Organization Name already Exists";
                } else {
                
                    $data = array();
                    $data = array(
                        'org_name' => $org_name,
                        'email' => $email,
                        'phone' => $phone,
                        'address' => $address,
                    );
                    $success = $this->client_model->create($data);
                    $this->session->set_flashdata('feedback','Successfully Added');
                    echo "Successfully Added";                     
                
    			}
            
            }
        }else{
    		redirect(base_url() , 'refresh');
    	}        
	}

	public function Update(){
        if($this->session->userdata('user_login_access') != False) {    
            $client_id = $this->input->post('client_id');    
        	$org_name  = $this->input->post('org_name');
        	$email     = $this->input->post('email');
        	$phone     = $this->input->post('phone');
        	$address   = $this->input->post('address');

            $id         = $client_id;
    		
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters();
            $this->form_validation->set_rules('client_id', 'client_id', 'required|xss_clean');
            $this->form_validation->set_rules('org_name', 'Organization Name', 'required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'required|xss_clean');
            $this->form_validation->set_rules('phone', 'Phone', 'required|xss_clean');
            $this->form_validation->set_rules('address', 'Address', 'required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
    			#redirect("employee/view?I=" .base64_encode($eid));
            }else{
                $data = array();

                if($id == $client_id){
                    // Small security check. OKAY. PROCEED
                }else{
                    $this->session->set_flashdata('feedback','Update Security Check Failed');
                    echo "Update Security Check Failed";
                    return false;
                }

                $data = array(
                    'org_name'      => $org_name,
                    'email'         => $email,
                    'phone'         => $phone,
                    'address'       => $address,
                );
                if($id){
                    $success = $this->client_model->updateRecord($id, $data); 
                    $this->session->set_flashdata('feedback','Successfully Updated');
                    echo "Successfully Updated";
                }
            }
        }else{
    		redirect(base_url() , 'refresh');
    	}
    }

    public function view(){
        if($this->session->userdata('user_login_access') != False) {
            $id = base64_decode($this->input->get('I'));
            $data['client'] = $this->client_model->readRecord($id);
            $this->load->view('backend/client_view', $data);
            }
        else{
    		redirect(base_url() , 'refresh');
    	}         
    }
    
    public function Inactive_Clients(){
        $data['invalid_clients'] = $this->client_model->read("", "0");
        $this->load->view('backend/invalid_clients',$data);
    }
}