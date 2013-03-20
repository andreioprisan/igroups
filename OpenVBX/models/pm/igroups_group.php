<?php

	
class iGroups_GroupException extends Exception {}
class iGroups_Group extends CI_Model {

	protected static $__CLASS__ = __CLASS__;
	public $table = 'groups';
	
	static public $select = array('groups.*');
	
	public $fields =  array('id', 'name', 'is_active');
	
	public $admin_fields = array('');

	public function __construct($object = null)
	{
		parent::__construct($object);
	}

/*
	static function get($search_options = array(), $limit = -1, $offset = 0)
	{
		if(empty($search_options))
		{
			return null;
		}

		if(is_numeric($search_options))
		{
			$search_options = array('id' => $search_options, 'is_active' => 1);
		}

		return self::search($search_options,
							1,
							0);
	}
*/
	static function search($search_options = array(), $limit = -1, $offset = 0)
	{
		$sql_options = array('joins' => array(),
							 'select' => self::$select,
							 );
		
		$obj = new self();
		$groups = parent::search(self::$__CLASS__,
								 $obj->table,
								 $search_options,
								 $sql_options,
								 $limit,
								 $offset);
		if(is_object($groups))
		{
			$groups = array($groups);
		}
		
		$sorted_groups = array();
		foreach($groups as $group)
		{
			$sorted_groups[$group->id] = $group;
			$sorted_groups[$group->id]->users = array();
		}
		
		$groups = $sorted_groups;

		if(empty($sorted_groups))
		{
			return $sorted_groups;
		}
		
		$ci = &get_instance();
		$ci->db
			 ->select('u.*, g.*, gu.*')
			 ->from('groups as g')
			 ->join('groups_users gu', 'gu.group_id = g.id')
			 ->join('users u', 'u.id = gu.user_id')
			 ->where('u.is_active', true)
			 ->where_in('g.id', array_keys($sorted_groups))
			 ->where('g.is_active', true);
		
		$groups_users = $ci->db->get()->result();
		foreach($groups_users as $gu)
		{
			$groups[$gu->group_id]->users[$gu->user_id] = $gu; 
		}
		
		if($limit == 1 && count($groups) == 1)
		{
			$groups = current($groups);
		}
		
		return $groups;
	}

	// --------------------------------------------------------------------

	function get_user_ids($group_id)
	{
		$ci =& get_instance();

		$user_ids = array();
		$ci->db->select('gu.user_id');
		$ci->db->from('groups_users gu');
		$ci->db->join('users u', 'u.id = gu.user_id');
		$ci->db->where('gu.group_id', $group_id);
		$ci->db->where('u.is_active', true);
		$ci->db->group_by('gu.user_id');
		$users = $ci->db->get()->result();
		foreach($users as $gu) {
			$user_ids[] = $gu->user_id;
		}
		return $user_ids;
	}

	function get_by_id($group_id)
	{
		$ci =& get_instance();

		return $ci->db
			->from('groups')
			->where('id', $group_id)
			->get()->first_row();
	}


	function remove_user($owner_id, $user_id)
	{
		$query = $this->db->delete('groups_users', array('owner_id' => $owner_id, 'user_id' => $user_id));	
		$query = $this->db->delete('users', array('owner_id' => $owner_id, 'id' => $user_id));	

		$counter = $this->db->affected_rows();
		if ($counter > 1)
			return true;
		else 
			return false;
	}

	function remove_groupuser($owner_id, $group_id, $user_id = NULL)
	{
		if ($user_id != NULL)
		{
			$query = $this->db->delete('groups_users', array('owner_id' => $owner_id, 'group_id' => $group_id, 'user_id' => $user_id));	
		} else {
			$query = $this->db->delete('groups_users', array('owner_id' => $owner_id, 'group_id' => $group_id));	
		}

		$counter = $this->db->affected_rows();
		if ($counter >= 1)
			return true;
		else 
			return false;
	}

	function add_groupuser($owner_id, $group_id, $user_id)
	{
		$query = $this->db->insert('groups_users', array('owner_id' => $owner_id, 'group_id' => $group_id, 'user_id' => $user_id));	

		$counter = $this->db->affected_rows();
		if ($counter >= 1)
			return true;
		else 
			return false;
	}

/*
	function delete()
	{
		$this->remove_all_users($this->id);
		$this->set_active($this->id, false);
	}
*/
	function remove_all_users($group_id)
	{
		$ci =& get_instance();

		$ci->db
			->where('tenant_id', $ci->tenant->id)
			->where('group_id', $group_id);
		
		$result = $ci->db->delete('groups_users');
		return $result;
	}

	function get_active_groups()
	{
		$ci =& get_instance();

		$groups = array();
		$groups = $ci->db
			 ->from($this->table . ' as g')
			 ->where('g.tenant_id', $ci->tenant->id)
			 ->where('g.is_active', true)
			 ->get()->result();
		
		$sorted_groups = array();
		foreach($groups as $group)
		{
			$sorted_groups[$group->id] = $group;
			$sorted_groups[$group->id]->users = array();
		}
		
		$groups = $sorted_groups;
		
		$ci->db
			 ->select('u.*, g.*, gu.*')
			 ->from($this->table . ' as g')
			 ->join('groups_users gu', 'gu.group_id = g.id')
			 ->join('users u', 'u.id = gu.user_id')
			 ->where('gu.tenant_id', $ci->tenant->id)
			 ->where('u.is_active', true)
			 ->where('g.is_active', true);
		
		$groups_users = $ci->db->get()->result();
		foreach($groups_users as $gu)
		{
			$groups[$gu->group_id]->users[$gu->user_id] = $gu;
		}

		return $groups;
	}

	function set_active($id, $active = true)
	{
		$ci =& get_instance();

		return $ci->db
			->where('id', $id)
			->where('tenant_id', $ci->tenant->id)
			->set('is_active', $active)
			->update('groups');
	}

	public function update_user($id, $data)
	{
		$this->db->where('id', $id);
		$query = $this->db->update('users', $data);
		return $this->get_user(array('id' => $id));
	}

	public function update_group($id, $data)
	{
		$this->db->where('id', $id);
		$query = $this->db->update('groups', $data);
		return $this->get($id);
	}

	public function add_group($data)
	{
		$query = $this->db->insert('groups', $data);
		return $this->get($this->db->insert_id());
	}

	public function add_user($data)
	{
		$query = $this->db->insert('users', $data);
		return $this->get_user(array('id' => $this->db->insert_id()));
	}

	public function get($id)
	{
		$query = $this->db->get_where('groups', array('id' => $id));
		return $query->row();
	}
	
	
	public function get_user($data)
	{
		$query = $this->db->get_where('users', $data);
		return $query->row();
	}

	public function get_users($data)
	{
		$query = $this->db->get_where('users', $data);
		return $query->result();
	}
	
	public function get_all_groups($owner_id)
	{
		$sql = "select distinct id, name from groups where owner_id = '".$owner_id."' and is_active = '1' order by id";
		$query = $this->db->query($sql);
		
		return $query->result();
	}

	public function get_distinct_groups_users_pairing_gmpage($owner_id)
	{
		$all_groups = $this->get_all_groups($owner_id);
		$data_array = array();

		$last_g_id = -1;
		foreach ($all_groups as $a => $group)
		{
			$sql = "select groups_users.group_id as g_id, groups_users.user_id as u_id from groups_users where groups_users.group_id = '".$group->id."' order by g_id, u_id";
			$query = $this->db->query($sql);
			$gr_q = $query->result();
		
			if ($group->id != $last_g_id)
			{
				$group_info = $this->get($group->id);
				$data_array[$group->id] = array('name' => $group->name, 'users' => array());
			}
			
			foreach ($gr_q as $i)
			{
				$user_info = $this->get_user(array('id' => $i->u_id));
				$data_array[$group->id]['users'][$i->u_id] = $user_info->first_name." ".$user_info->last_name;
			
				$last_g_id = $group->id;
			}
			
			$last_g_id = $group->id;
			
		}
		
		return $data_array;
	}
	
	public function delete($data)
	{
		$query = $this->db->delete('groups', $data);
		return $query;
	}
	
	public function get_users_groups_assoc($owner_id)
	{
		$sql = "select * from groups_users left join groups on groups_users.group_id = groups.id left join users on groups_users.user_id = users.id where groups_users.owner_id = '".$owner_id."' order by group_id, user_id";
		$query = $this->db->query($sql);
		return $query->result();
	}
}
