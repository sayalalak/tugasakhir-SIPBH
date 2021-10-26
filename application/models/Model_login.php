<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_login extends CI_Model {

    function Auth($username, $password)
    {

        //menggunakan active record . untuk menghindari sql injection
        $this->db->where("username", $username);
        $this->db->where("password", $password);
        return $this->db->get("login");    
    }

    function check_db($username)
    {
        return $this->db->get_where('login', array('username' => $username));
    }

}

/* End of file Model_login.php */
