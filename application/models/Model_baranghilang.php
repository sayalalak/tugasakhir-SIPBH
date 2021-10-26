<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_baranghilang extends CI_Model {

    private $table   = "brg_hilang";
    private $primary = "kode_brg";

    function searchBarangHilang($cari, $limit, $offset)
    {
        $this->db->like($this->primary,$cari);
        $this->db->or_like("nama_brg",$cari);
        $this->db->limit($limit, $offset);
        return $this->db->get($this->table);
    }

    function totalRows($table)
	{
		return $this->db->count_all_results($table);
    }

    
    function getAll()
    {
        $this->db->order_by('brg_hilang.kode_brg desc');
        return $this->db->get('brg_hilang');
    }

    function insertBaranghilang($tabel, $data)
    {
        $insert = $this->db->insert($tabel, $data);
        return $insert;
    }

    function cekBarang($kode)
    {
        $this->db->where("kode_brg", $kode);
        return $this->db->get("brg_hilang");
    }

    function updateBarang($kode_brg, $data)
    {
        $this->db->where('kode_brg', $kode_brg);
		$this->db->update('brg_hilang', $data);
    }

    function getGambar($kode_brg)
    {
        $this->db->select('gambar');
        $this->db->from('brg_hilang');
        $this->db->where('kode_brg', $kode_brg);
        return $this->db->get();
    }

    function deleteBarang($kode, $table)
    {
        $this->db->where('kode_brg', $kode);
        $this->db->delete($table);
    }

    function baranghilangSearch($cari)
    {
        $this->db->like($this->primary,$cari);
        $this->db->or_like("nama_brg",$cari);
        $this->db->where('jumlah >', 0);
        $this->db->limit(10);
        return $this->db->get($this->table);
    }

    function pinjam($kode)
    {
        $this->db->select('jumlah');
        $this->db->from('barang');
        $this->db->where('kode_brg', $kode);
        $barang = $this->db->get()->result();
        $data = array('jumlah' => $barang[0]->jumlah-1);
       
        $this->db->where('kode_brg', $kode);
        $this->db->update('barang', $data);
    }
    
    function kembalikan($kode)
    {
        $this->db->select('jumlah');
        $this->db->from('barang');
        $this->db->where('kode_brg', $kode);
        $barang = $this->db->get()->result();
        $data = array('jumlah' => $barang[0]->jumlah+1);
        //var_dump($data);
        $this->db->where('kode_brg', $kode);
        $this->db->update('barang', $data);
    }



}

/* End of file ModelName.php */
