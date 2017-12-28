<?php

  interface request
  {

    //remove unnecessary characters
    $p_id = str_replace('-', '', $p_id);
   
    if (!ctype_alnum($id) or !ctype_alnum($p_id)) {
      if ($debug) {error_log('DEBUG: id/pid not alphanumeric ' . $id . ' ' . $p_id); }
      echo '<!DOCTYPE html>';
      echo '<html><head><title>400 Bad Request</title></head>';
      echo '<body><center><h1>400 Bad Request</h1></center></body>';
      echo '</html>';
      exit();
    }

    //check if customer exists
    public function account_check();

    //check if product exists
    public function product_check();

    //check customer licensing
    public function licence_check();

    //call image type function with given URL parameter
    public function fset();

    //call query type function with given URL parameter
    public function qset();

    //check if error is set
    public function error_is_set();
  }

?>
