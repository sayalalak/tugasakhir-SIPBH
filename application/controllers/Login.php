<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Model_barangtemuan','Model_baranglelang',
            'Model_transaksilelang','Model_laporhilang', 'Model_login'));
        
    }

    public function index()
    {
        if(isset($_POST['proses'])) {
            
            //form validation
            $this->form_validation->set_rules('username', 'Nama Pengguna', 'required');
            $this->form_validation->set_rules('password', 'Kata Sandi', 'required');
            $this->form_validation->set_message('required', '{field} kosong, silahkan diisi !');
            $this->form_validation->set_error_delimiters('<span class="peringatan">', '</span>');
            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('formlogin/login_data');
            }
            else{
                    //cek username database
                $username = $this->input->post('username');
                $password = $this->input->post('password');

                if($this->Model_login->check_db($username)->num_rows()==1) {

                    //cek verfied bycrpt menyamakan data yg di input dengan ada yg di database 
                    $db = $this->Model_login->check_db($username)->row();
        
                     if($db->password) {

                    //cek username dan password dengan ada yg di database
                    // print_r($data); die();
                        $userdata = array(
                            'id_petugas'  => $db->id_admin,
                            'nama'        => ucfirst($db->nama),
                            'username'    => $db->username,
                            'password'    => $db->password,
                        );

                    // print_r($userdata); die();    

                    $this->session->set_userdata($userdata);

                    redirect('dashboard');
                    }
                    else{
                        $data['pesan'] = "<div class='alert alert-danger'>
                                                                <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                                                <strong>Maaf</strong> Nama Pengguna dan Kata Sandi Anda Salah. </div>";
                        $this->load->view('formlogin/login_data', $data);
                    }

                }
                else{
                    $data['pesan'] = "<div class='alert alert-danger'>
                                                                <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                                                <strong>Maaf</strong> Nama Pengguna dan Kata Sandi Tidak Terdaftar. </div>";
                        $this->load->view('formlogin/login_data', $data); 
                }    

               // } //end cek sql injeqtion
            }
        }
        else{
            $this->load->view('formlogin/login_data');
        }

        
    }//end function index

    public function view_barangtemuan()
    {
        $total = $this->Model_barangtemuan->totalRows('brg_temuan');
        $config['base_url']   = base_url('login/view_barang/');
        $config['total_rows'] = $total;
        $config['per_page']   = 3;

        /*config*/
        // tag pagination bootstrap
        $config['full_tag_open']    = "<ul class='pagination pull-left'>";
        $config['full_tag_close']   = "</ul>";
        $config['num_tag_open']     = "<li>";
        $config['num_tag_close']    = "</li>";
        $config['cur_tag_open']     = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
        // $config['next_link']        = "Selanjutnya";
        $config['next_tag_open']    = "<li>";
        $config['next_tagl_close']  = "</li>";
        // $config['prev_link']        = "Sebelumnya";
        $config['prev_tag_open']    = "<li>";
        $config['prev_tagl_close']  = "</li>";
        // $config['first_link']       = "Awal";
        $config['first_tag_open']   = "<li>";
        $config['first_tagl_close'] = "</li>";
        // $config['last_link']        = 'Terakhir';
        $config['last_tag_open']    = "<li>";
        $config['last_tagl_close']  = "</li>";


        //load hasil config
        $this->pagination->initialize($config);

        $limit  = $config['per_page'];
        $offset = (int) $this->uri->segment(3);

        $data['pagination'] = $this->pagination->create_links();
        $data['brg_temuan']    = $this->Model_barangtemuan->getDataBarangTemuan($limit, $offset);
        $data['title']      = 'Data Barang Temuan';

        // $data['barangtemuan'] = $this->Model_barangtemuan->getAll()->result();
        $this->load->view('formlogin/view_barang', $data);
    }

    public function search_barangtemuan()
    {
        $total = $this->Model_barangtemuan->totalRows('brg_temuan');
        $config['base_url']   = base_url('login/search_barangtemuan/');
        $config['total_rows'] = $total;
        $config['per_page']   = 3;

        /*config*/
        // tag pagination bootstrap
        $config['full_tag_open']    = "<ul class='pagination pull-left'>";
        $config['full_tag_close']   = "</ul>";
        $config['num_tag_open']     = "<li>";
        $config['num_tag_close']    = "</li>";
        $config['cur_tag_open']     = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
        // $config['next_link']        = "Selanjutnya";
        $config['next_tag_open']    = "<li>";
        $config['next_tagl_close']  = "</li>";
        // $config['prev_link']        = "Sebelumnya";
        $config['prev_tag_open']    = "<li>";
        $config['prev_tagl_close']  = "</li>";
        // $config['first_link']       = "Awal";
        $config['first_tag_open']   = "<li>";
        $config['first_tagl_close'] = "</li>";
        // $config['last_link']        = 'Terakhir';
        $config['last_tag_open']    = "<li>";
        $config['last_tagl_close']  = "</li>";


        //load hasil config
        $this->pagination->initialize($config);

        $limit  = $config['per_page'];
        $offset = (int) $this->uri->segment(3);

        $data['pagination'] = $this->pagination->create_links();

        $cari = $this->input->post('cari_barang');
        $data['title']   = 'Data Barang Temuan';
        $data['barang'] = $this->Model_barangtemuan->searchBarang($cari, $limit, $offset);
        $this->load->view('formlogin/view_barang', $data);
    }
    

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

}

/* End of file Login.php */
