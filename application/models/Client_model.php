<?php

class Client_model extends CI_Model{
  //Constructor
  function __construct(){
  // Call the Model constructor
        parent::__construct();

  //  date_default_timezone_set("Africa/Lagos");
  }

  private $table = "clients";

  public function check($id){
    $this->db->where(array("id" => $id));
    $query = $this->db->get($this->table);
    if($query->num_rows() > 0){
      return true;
    }
    return false;
  }

  public function checkOrgName($org_name){
    $this->db->where(array("org_name" => $org_name));
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

  public function read($client_code = "", $status = "", $limit = ""){

    if($client_code != ""){
      $this->db->where(array("client_code" => $client_code) );
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