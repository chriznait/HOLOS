<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fichas extends CI_Controller {
    function __construct() {
        parent::__construct();
               
        $this->controller = $this->router->fetch_class();
        $this->sisgalen = $this->load->database("sisgalen",TRUE);
    }

    public function index(){        
        $this->load->view($this->controller."/fichas");
    }


}
?>