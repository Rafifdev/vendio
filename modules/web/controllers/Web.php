<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *| --------------------------------------------------------------------------
 *| Web Controller
 *| --------------------------------------------------------------------------
 *| For default controller
 *|
 */
class Web extends Front
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->template->title('Vendio | Modern Omnichannel ERP & Commerce Hub');
        $this->home();
    }

    public function switch_lang($lang = 'indonesian')
    {
        $this->load->helper(['cookie']);

        $lang = preg_replace('/[^a-zA-Z0-9_-]/', '', (string) $lang) ?: 'indonesian';
        set_cookie('language', $lang, (60 * 60 * 24) * 365);
        $this->lang->load('web', $lang);
        redirect_back();
    }

    public function home()
    {
        $this->data['plans'] = $this->db->where('status', 'active')->order_by('sort_order', 'ASC')->get('plans')->result();
        if (defined('IS_DEMO')) {
            $this->template->build('home-demo', $this->data);
        } else {
            $this->template->build('home', $this->data);
        }
    }

    public function spinwheel()
    {
        $this->template->title('Vendio Lucky Wheel | Hadiah & Reward Eksklusif Mitra');
        $this->template->build('spinwheel');
    }
}


/* End of file Web.php */
/* Location: ./application/controllers/Web.php */
