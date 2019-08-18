<?php
class Turn extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }
    public function get($id = FALSE)
    {
		if ($id === FALSE)
		{
			$query = $this->db->get('turn');
			return $query->result_array();
		}
    
		$query = $this->db->get_where('turn', array('user_id' => $id));
		return $query->row_array();
    }
    public function set($user_id, $turn)
    {
		$query = $this->db->get_where('turn', array('user_id' => $user_id));
        $data = array(
            'user_id' => $user_id,
            'turn' => $turn,
        );
		if ($query->row_array()) {
			$id = $query->row_array()['id'];
			return $this->db->update('turn', $data, array('id' => $id));
		} else {
			return $this->db->insert('turn', $data);
		}
        
    }
}
