<?php

class Shifttracker_model extends CI_Model{
  //Constructor
  function __construct(){
  // Call the Model constructor
        parent::__construct();

  //  date_default_timezone_set("Africa/Lagos");
  }

  private $table = "shifttracker";

  public function check($id){
    $this->db->where(array("id" => $id));
    $query = $this->db->get($this->table);
    if($query->num_rows() > 0){
      return true;
    }
    return false;
  }

  public function checkDuplicate($employee_id, $client_id, $department, $period, $shift_date){
    $this->db->where(array("employee_id" => $employee_id, "client_id" => $client_id,
                "department" => $department,"period" => $period,"shift_date" => $shift_date));
    $query = $this->db->get($this->table);
    if($query->num_rows() > 0){
      return true;
    }
    return false;
  }

  public function create($query){
    $this->db->insert($this->table, $query);
    return array(true, $this->db->insert_id());
  }

  public function read($employee_id, $client_id, $department, $period, $shift_status, $status = "", $limit = ""){

    if($employee_id != ""){
      $this->db->where(array("employee_id" => $employee_id) );
    }
    if($client_id != ""){
      $this->db->where(array("client_id" => $client_id) );
    }
    if($department != ""){
      $this->db->where(array("department" => $department) );
    }
    if($period != ""){
      $this->db->where(array("period" => $period) );
    }
    if($shift_status != ""){
      $this->db->where(array("shift_status" => $shift_status) );
    }
    if($status != ""){
      $this->db->where(array("status" => $status) );
    }
    if($limit != ""){
      $this->db->limit($limit);
    }
    $this->db->order_by($this->table.".time_updated", "DESC");
    $this->db->from($this->table);
    $query = $this->db->get();
    if ($query->num_rows() > 0)
    {
      return $query->result_array();
    }
    return false;
  }
  public function readRecord($id){
    
    $this->db->where(array("id" => $id) );
    $this->db->from($this->table);
    $query = $this->db->get();
    if ($query->num_rows() > 0)
    {
      return $query->result_array()[0];
    }
    return false;
  }

  public function updateRecord($id, $query){
    $this->db->where("id", $id);
    $this->db->update($this->table, $query);
    return true;
  }

  public function delete($id)
  {
    $query = "DELETE FROM ".$this->table." WHERE id = '$id' ";
    $query = $this->db->query($query);
    return true;
  }


  
}
?>