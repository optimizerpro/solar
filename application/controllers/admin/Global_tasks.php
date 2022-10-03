<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Global_tasks extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        if(!is_admin()){
            redirect(admin_url());
        }
        $this->load->model('global_tasks_model');
    }
    
    public function index()
    {
        if (!is_admin()) {
            access_denied('Ticket Priorities');
        }
        $data['global_tasks'] = $this->global_tasks_model->get();
        $data['title']      = _l('global_tasks');
        $this->load->view('admin/settings/global_tasks/manage', $data);
    }

    public function add()
    {
        if (!is_admin()) {
            access_denied('Global Tasks');
        }
        if ($this->input->post()) {
            if (!$this->input->post('id')) {
                $id = $this->global_tasks_model->add($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('global_tasks')));
                }
            } else {
                $data = $this->input->post();
                $id   = $data['id'];
                unset($data['id']);
                $success = $this->global_tasks_model->update($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('global_tasks')));
                }
            }
            die;
        }
    }

    /* Delete ticket priority */
    public function delete($id)
    {
        if (!is_admin()) {
            access_denied('Global Tasks');
        }
        if (!$id) {
            redirect(admin_url('global_tasks'));
        }
        $response = $this->tickets_model->delete_priority($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('ticket_priority_lowercase')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('ticket_priority')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('ticket_priority_lowercase')));
        }
        redirect(admin_url('global_tasks'));
    }
}