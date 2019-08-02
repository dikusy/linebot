<?php
class Store_Form extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }
    public function get_store($slug = FALSE)
    {
            if ($slug === FALSE)
            {
                    $query = $this->db->get('store');
                    return $query->result_array();
            }
    
            $query = $this->db->get_where('store', array('slug' => $slug));
            return $query->row_array();
    }
    public function set_store()
    {
        $this->load->helper('url');
    
        $slug = url_title($this->input->post('name'), 'dash', TRUE);
    
        $data = array(
            'name' => $this->input->post('name'),
            'slug' => $slug,
            'address' => $this->input->post('address')
        );
    
        return $this->db->insert('store', $data);
    }
}