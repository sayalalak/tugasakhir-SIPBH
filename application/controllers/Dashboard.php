<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_baranghilang');
        $this->load->model('Model_baranglelang');
        $this->load->model('Model_barangtemuan');


        $this->load->model('Model_jenis');
    }

    function index()
    {
        $data['countkaryawan'] = $this->Mod_karyawan->totalRows('karyawan');
        $data['countbarang'] = $this->Model_barang->totalRows('barang');
        $data['countjenis'] = $this->Mod_jenis->totalRows('jenis');
        $this->template->load('layoutbackend', 'dashboard/dashboard_data', $data);
    }
        
    


}
/* End of file Controllername.php */
 