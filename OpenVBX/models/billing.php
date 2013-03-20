<?php

class Billing extends MY_Model {

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
	
	function getCards($tenant_id)
	{
		$query = $this->db->query('select distinct concat(billing_cards.exp_month,billing_cards.exp_year,billing_cards.last4,billing_cards.`type`) as a, billing_cards.* from billing_customers left join billing_cards on billing_customers.cardID = billing_cards.id where billing_customers.tenant_id = ? group by a order by id desc', array('tenant_id' => $tenant_id));
		return $query->result();
	}
	

}
