<?php
class Form extends CI_Controller {
    public function __construct()
    {
            parent::__construct();
            $this->load->model('store_form');
            $this->load->helper('url_helper');
            $this->load->helper(array('form', 'url'));

    }

    public function index()
    {
            $data['store'] = $this->store_form->get_store();
            $data['title'] = 'Store Archive';
    
            // $this->load->view('templates/header', $data);
            $this->load->view('form/index', $data);
            // $this->load->view('templates/footer');
    }

    public function view($id = NULL)
    {
        $data['store_item'] = $this->store_form->get_store($id);
    
        if (empty($data['store_item']))
        {
            show_404();
        }
        $data['title'] = $data['store_item']['name'];
        // $this->load->view('templates/header', $data);
        $this->load->view('form/view', $data);
        // $this->load->view('templates/footer');
    }

    public function create()
    {

        $config['upload_path']          = './';
        // $config['upload_path']          = './application/libraries/uploads/';
        // $config['allowed_types']        = 'gif|jpg|png';
        // $config['max_size']             = 100;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);
        $this->upload->do_upload('img');


        $this->load->helper('form');
        $this->load->library('form_validation');
    
        $data['title'] = 'Create a form item';
    
        // $this->form_validation->set_rules('name', 'Name', 'required');
        // $this->form_validation->set_rules('address', 'Address', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('form/create');
        }
        else
        {
            $this->store_form->set_store();

            $data['store'] = $this->store_form->get_store();
            $this->load->view('form/index', $data);
        }
    }
}
