<?php

  interface request
  {

    //check if customer exists
    public function account_check();

    //verify that isbn is set alphanumeric and remove unnecessary characters
    public function alnum_check();

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
