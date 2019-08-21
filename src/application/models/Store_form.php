<?php
class Store_Form extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->database();

    }
    public function get_store($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->get('store');
            return $query->result_array();
        }

        $query = $this->db->get_where('store', array('id' => $id));
        return $query->row_array();
    }
    public function set_store()
    {
        $this->load->helper('url');

        
        $data = array(
            // 'name'          => $this->input->post('name'),
            // 'category'      => $this->input->post('category'),
            // 'open_at'       => $this->input->post('open_at'),
            // 'close_at'      => $this->input->post('close_at'),
            // 'holiday'       => $this->input->post('holiday'),
            // 'day_average'   => $this->input->post('day_average'),
            // 'night_average' => $this->input->post('night_average'),
            // 'url'           => $this->input->post('url'),
            // 'address'       => $this->input->post('address'),
            // 'tel'           => $this->input->post('tel'),
            'img'           => $this->input->post('img')
        );
    
        return $this->db->insert('store', $data);
    }

    public function get_by_key($key, $text) {
        $query = $this->db->get_where('store', array($key => $text));
        return $query->result_array();
    }
}
