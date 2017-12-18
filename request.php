<?php

  interface request
  {

    if (!isset($_REQUEST['id'], $_REQUEST['pid'])) {
      if ($debug) {error_log('DEBUG: no id/pid ' . );}

    //header($_SERVER['PHP_SELF']);
      echo '<!DOCTYPE html>';
      echo '<html><head><title>400 Bad Request</title></head>';
      echo '<body><center><h1>400 Bad Request</h1></center></body>';
      echo '</html>';
      exit();
    }

    $qtype_id = $conn->query("SELECT accno FROM customer WHERE hash = '$id'") or die(mysql_error());
    if ($idquery = mysqli_fetch_array($qtype_id)) {$accno = $idquery['accno'];}
 
    if(!isset($accno)) {
        if ($debug) {error_log('DEBUG: customer not found ' . $id);}
        echo '<!DOCTYPE html>';
        echo '<html><head><title>401 Unauthorized</title></head>';
        echo '<body><center><h1>401 Unauthorized</h1></center></body>';
        echo '</html>';
        exit();
    }

    if (!isset($_REQUEST['qtype'])) {$qtype = 'm';}
    if (!isset($_REQUEST['ftype']))  {$ftype = '04';}
    if (!isset($_REQUEST['format'])) {$format = '03';}
    if (!isset($_REQUEST['debug'])) {$debug = 0;}
    if (!isset($_REQUEST['error'])) {$error = 0;}

    $id = $_REQUEST['id'];        //customer id
    $p_id = $_REQUEST['pid'];       //product id
    $qtype = $_REQUEST['qtype'];  //m=media, b=media & text
    $ftype = $_REQUEST['ftype'];   //type of image (ONIX) 04=cover 06=thumb 07=full
    $format = $_REQUEST['format'];   //
    $debug = $_REQUEST['debug'];  // debug messages 0|1
    $error = $_REQUEST['error'];  // error parameter
   
    if ($error != 0) {
      function error() {
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
        echo '<!DOCTYPE html>';
        echo '<html><head><title>404 Not Found</title></head>';
        echo '<body><center><h1>404 Not Found</h1></center></body>';
        echo '</html>';
        exit();
      }
    }

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

    //check if product exists
    public function product_check();

    //check customer licensing
    public function licence_check();

    //call image type function with given URL parameter
    public function fset();

    //call query type function with given URL parameter
    public function qset();
  }

?>
