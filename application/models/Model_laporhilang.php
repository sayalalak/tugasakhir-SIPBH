<?php 


defined('BASEPATH') OR exit('No direct script access allowed');

class Model_laporhilang extends CI_Model 
{

    private $table = "lapor_hilang";
    private $tmp   = "tmp";
    
    function AutoNumbering()
    {
        $today = date('Ymd');

        $data = $this->db->query("SELECT MAX(id_lapor) AS last FROM $this->table ")->row_array();

        $lastNoFaktur = $data['last'];
        
        $lastNoUrut   = substr($lastNoFaktur,8,3);
        
        $nextNoUrut   = $lastNoUrut+1;
        
        $nextNoLapor = $today.sprintf('%03s',$nextNoUrut);
        
        return $nextNoLapor;
    }

    function getTmp()
    {
        return $this->db->get("tmp");
    }
    
    function cekTmp($kode)
    {
        $this->db->where("kode_brg",$kode);
        return $this->db->get("tmp");
    }

    function InsertTmp($data)
    {
        
        $this->db->insert($this->tmp, $data);    
    }

    function InsertLapor($data)
    {
        $this->db->insert($this->table, $data);
    }

    function jumlahTmp()
    {
        return $this->db->count_all("tmp");
    }

    function deleteTmp($kode_brg)
    {
        $this->db->where("kode_brg",$kode_brg);
        $this->db->delete($this->tmp);
    }

    function getLapor()
    {
        return $this->db->get($this->table);
    }

}

/* End of file Mod_peminjaman.php */
