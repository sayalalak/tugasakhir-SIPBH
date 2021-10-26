<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class barang extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_barang');
    }


    public function index()
    {
        $data['barang']      = $this->Model_barang->getAll();
        
        
        if($this->uri->segment(3)=="create-success") {
            $data['message'] = "<div class='alert alert-block alert-success'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <p><strong><i class='icon-ok'></i>Data</strong> Berhasil Disimpan...!</p></div>";    
            $this->template->load('layoutbackend', 'barang/barang_data', $data); 
        }
        else if($this->uri->segment(3)=="update-success"){
            $data['message'] = "<div class='alert alert-block alert-success'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <p><strong><i class='icon-ok'></i>Data</strong> Berhasil Diubah...!</p></div>"; 
            $this->template->load('layoutbackend', 'barang/barang_data', $data);
        }
        else if($this->uri->segment(3)=="delete-success"){
            $data['message'] = "<div class='alert alert-block alert-success'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <p><strong><i class='icon-ok'></i>Data</strong> Berhasil Dihapus...!</p></div>"; 
            $this->template->load('layoutbackend', 'barang/barang_data', $data);
        }
        else{
            $data['message'] = "";
            $this->template->load('layoutbackend', 'barang/barang_data', $data);
        }
        
    }

    public function create()
    {
        $this->template->load('layoutbackend', 'barang/barang_create');
    }

    public function insert()
    {
        if(isset($_POST['save'])) {

            //function validasi
            $this->_set_rules();

            //apabila user mengkosongkan form input
            if($this->form_validation->run()==true){
                // echo "masuk"; die();
                $kode_brg = $this->input->post('kode_brg');
                $cek = $this->Model_barang->cekbarang($kode_brg);
                //cek nik yg sudah digunakan
                if($cek->num_rows() > 0){
                    $data['message'] = "<div class='alert alert-block alert-danger'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <p><strong><i class='icon-ok'></i>Kode barang</strong> Sudah Digunakan...!</p></div>"; 
                    $this->template->load('layoutbackend', 'barang/barang_create', $data); 
                }
                else{
                    $nama_brg = slug($this->input->post('nama_brg'));
                    $config['upload_path']   = './assets/img/barang/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size']	     = '1000';
                    $config['max_width']     = '2000';
                    $config['max_height']    = '1024';
                    $config['file_name']     = $nama_brg; 
                            
                    $this->upload->initialize($config);

                     //apabila ada gambar yg diupload
                    if ($this->upload->do_upload('userfile')){
                        
                        $gambar = $this->upload->data();

                        $save  = array(
                            'kode_brg'   => $this->input->post('kode_brg'),
                            'nama_brg'   => $this->input->post('nama_brg'),
                            'jenis_barang'  => $this->input->post('jenis_barang'),
                            'jumlah'        => $this->input->post('jumlah'),
                            'keterangan'    => $this->input->post('keterangan'),
                            'gambar'        => $gambar['file_name']
                        );
                        $this->Model_barang->insertbarang("barang", $save);
                        // echo "berhasil"; die();
                        redirect('barang/index/create-success');

                    }
                    //apabila tidak ada gambar yg diupload
                    else{
                        $data['message'] = "<div class='alert alert-block alert-danger'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <p><strong><i class='icon-ok'></i>Gambar</strong> Masih Kosong...!</p></div>"; 
                        $this->template->load('layoutbackend', 'barang/barang_create', $data);
                    } 
                }
            
            }
            //jika tidak mengkosongkan form
            else{
                $data['message'] = "";
                $this->template->load('layoutbackend', 'barang/barang_create', $data);
            }

        }
    }

    public function edit()
    {
        $kode_brg = $this->uri->segment(3);
        
        $data['edit']    = $this->Model_barang->cekbarang($kode_brg)->row_array();
       
        $this->template->load('layoutbackend', 'barang/barang_edit', $data);
    }

    public function update()
    {
        if(isset($_POST['update'])) {

            //apabila ada gambar yg diupload
            if(!empty($_FILES['userfile']['name'])) {

                $this->_set_rules();

                //apabila user mengkosongkan form input
                if($this->form_validation->run()==true){
                    
                    $kode_brg = $this->input->post('kode_brg');
                    
                    $nama_brg = slug($this->input->post('nama_brg'));
                    $config['upload_path']   = './assets/img/barang/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size']	     = '1000';
                    $config['max_width']     = '2000';
                    $config['max_height']    = '1024';
                    $config['file_name']     = $nama_brg; 
                            
                    $this->upload->initialize($config);

                        //apabila ada gambar yg diupload
                    if ($this->upload->do_upload('userfile')){
                        
                        $gambar = $this->upload->data();

                        $save  = array(
                            'kode_brg'   => $this->input->post('kode_brg'),
                            'nama_brg'   => $this->input->post('nama_brg'),
                            'tglkejadian'  => $this->input->post('tglkejadian'),
                            'spesifikasibrg'        => $this->input->post('spesifikasibrg'),
                            'tmptkejadian'        => $this->input->post('tmptkejadian'),
                            'kronologi'        => $this->input->post('kronologi'),
                            'pelapor'        => $this->input->post('pelapor'),
                            'keterangan'    => $this->input->post('keterangan')
                            'gambar'        => $gambar['file_name']
                        );

                        $g = $this->Model_barang->getGambar($kode_brg)->row_array();
                        
                        //hapus gambar yg ada diserver
                        unlink('assets/img/barang/'.$g['gambar']);

                        $this->Model_barang->updatebarang($kode_brg, $save);
                        redirect('barang/index/update-success');

                    }
                    //apabila tidak ada gambar yg diupload
                    else{
                        $data['message'] = "<div class='alert alert-block alert-danger'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <p><strong><i class='icon-ok'></i>Gambar</strong> Masih Kosong...!</p></div>"; 
                        $this->template->load('layoutbackend', 'barang/barang_edit', $data);
                    } 
                        
                    
                }
                //jika tidak mengkosongkan
                else{

                    $kode_brg = $this->input->post('kode_brg');
                    $data['edit']    = $this->Model_barang->cekbarang($kode_brg)->row_array();
                    $data['message'] = "";
                    $this->template->load('layoutbackend', 'barang/barang_edit', $data);
                }
            
            }
            //jika tidak ada gambar yg diupload
            else{
                $this->_set_rules();
                
                //apabila user mengkosongkan form input
                if($this->form_validation->run()==true){
                    
                    $kode_brg = $this->input->post('kode_brg');
                    
                    $save  = array(
                        'kode_brg'   => $this->input->post('kode_brg'),
                        'nama_brg'   => $this->input->post('nama_brg'),
                        'tglkejadian'  => $this->input->post('tglkejadian'),
                        'spesifikasibrg'        => $this->input->post('spesifikasibrg'),
                        'tmptkejadian'        => $this->input->post('tmptkejadian'),
                        'kronologi'        => $this->input->post('kronologi'),
                        'pelapor'        => $this->input->post('pelapor'),
                        'keterangan'    => $this->input->post('keterangan')
                    );
                    $this->Model_barang->updatebarang($kode_brg, $save);

                    redirect('barang/index/update-success');      
                }
                //jika tidak mengkosongkan
                else{
                    $kode_brg = $this->input->post('kode_brg');
                    $data['edit']    = $this->Model_barang->cekbarang($kode_brg)->row_array();
                    $data['message'] = "";
                    $this->template->load('layoutbackend', 'barang/barang_edit', $data);
                }

            } //end empty $_FILES

        } // end $_POST['update']
    
    }

    public function delete()
    {

        $kode_brg = $this->input->post('kode_brg');
          
        $g = $this->Model_barang->getGambar($kode_brg)->row_array();
        
        //hapus gambar yg ada diserver
        unlink('assets/img/barang/'.$g['gambar']);

        $this->Model_barang->deletebarang($kode_brg, 'baranghilang');

        redirect('barang/index/delete-success');
    }

    //function global buat validasi input
    public function _set_rules()
    {
        $this->form_validation->set_rules('kode_brg','Kode Barang','required|max_length[5]');
        $this->form_validation->set_rules('nama_brg','Nama Barang','required|max_length[100]');
        $this->form_validation->set_rules('tglkejadian','Tanggal Kejadian','required|max_length[50]');
        $this->form_validation->set_rules('spesifikasibrg','Sepsifikasi Barang','required|max_length[200]'); 
        $this->form_validation->set_rules('tmptkejadian','Tempat Kejadian','required|max_length[50]');
        $this->form_validation->set_rules('kronologi','Kronologi','required|max_length[200]');
        $this->form_validation->set_rules('pelapor','Pelapor','required|max_length[50]');
        $this->form_validation->set_rules('keterangan','Keterangan','required|max_length[200]');
        $this->form_validation->set_message('required', '{field} kosong, silahkan diisi');
        $this->form_validation->set_error_delimiters("<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert'>&times;</a>","</div>");
    }

}

/* End of file barang.php */
