<?php

class Billing extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function addCard($data)
	{
		$this->db->insert('billing_cards', $data); 
		return $this->db->insert_id();
	}
	
	function addCharge($data)
	{
		$this->db->insert('billing_charges', $data); 
		return $this->db->insert_id();
	}
	
	function addCustomer($data)
	{
		$this->db->insert('billing_customers', $data); 
		return $this->db->insert_id();
	}
	
	function getCards($userID)
	{
		$query = $this->db->query('select * from billing_customers left join billing_cards on billing_customers.cardID = billing_cards.id where billing_customers.userID = ?', array('userID' => $userID));
		return $query->result();
	}
	

}
