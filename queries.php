<?php
    // check for image size parameter, exit if input is not correct
  /**
   *
   */
  class queries extends AnotherClass
  {

    function __construct(argument)
    {
      # code...
    }


    function fset($fset) {

      if ($fset = '04') {$img_size = $reg_size;}
      if ($fset = '06') {$img_size = $thumbnail;}
                
      if ($fset = '07') {
     
        $f_query = $conn->query("SELECT data FROM media WHERE proweb_id='$p_id' AND datatype='FILE' type_id='FCO'") or die(mysql_error());
     
        if ($row = mysqli_fetch_array($f_query)) {
     
          $img = $img_path.$row['data'];
          if(empty($row['data'])) {if ($error == 1) {error();} $img = $img_path.'broken_link_image.gif';}
          if(file_exists($img)) {} else {if ($error == 1) {error();} $img = $img_path.'broken_link_image.gif';}
     
          header('Content-Type: image/jpeg');
          $onon = new SimpleImage();
          $onon->load($img);
          $onon->output();
          exit();
        }
      }
    }

    function qset($qset) {
          // image query
      if ($qset = 'm') {
        $superquery = $conn->query("SELECT data FROM media WHERE proweb_id='$p_id' AND datatype='FILE' AND type_id='FCO'") or die(mysql_error());
        if ($debug) {error_log('DEBUG: media '); }
        if ($row = mysqli_fetch_array($superquery)) {
         
          $img = $img_path.$row['data'];
          if(empty($row['data'])) { if ($error == 1) {error();} $img = $img_path.'kuvaa_ei_saatavilla.jpg'; $img_size = 80; if ($debug) {error_log('DEBUG: image not available ' . $p_id); }}
          if(file_exists($img)) {if ($debug) {error_log('DEBUG: image found ' . $img); }} else { if ($error == 1) {error();} $img = $img_path.'broken_link_image.gif'; $img_size = 80; if ($debug) {error_log('DEBUG: image not found ' . $img); }}
         
        } else {if ($error == 1) {error();} $img = $img_path.'kuvaa_ei_saatavilla.jpg'; $img_size = 80;}
         
        header('Content-Type: image/jpeg');
        $onon = new SimpleImage();
        $onon->load($img);
        $size = $onon->getWidth($img);
        if ($size >=  $img_size) {
          $onon->resizeToWidth($img_size);
          $onon->output();
          exit();
        } else {$onon->output(); exit();}
      }
       
               
              case 'b':
       
              // product page
       
                  echo '<!DOCTYPE html>';
                  echo '<html><head><meta http-equiv="Content-Type" content="text/html;charset=utf-8">';
                  echo '<link rel="stylesheet" type="text/css" href="prodinfo.css" />';
                  echo '</head><body bgcolor=#F0F0F0><div id="wrapper">';
                  echo '<div id="header"><h1 id="heading">';
       
                  $result = $conn->query("SELECT data FROM media WHERE proweb_id = '$p_id' AND type_id = 'DESC' AND datatype = 'TEXT'") or die(mysql_error());
                  if ($desc = mysqli_fetch_array($result)) {
                      $data = $desc['data'];
                  }
       
                  $result = $conn->query("SELECT name, author, publishingyear, publisher FROM product WHERE proweb_id = '$p_id'") or die(mysql_error());
                  $info = mysqli_fetch_array($result);
                  if ($info) {
                      $name = $info['name'];
                      $auth = $info['author'];
                      $pub = $info['publisher'];
                      $year = $info['publishingyear'];
                  }
       
                  if(empty($name)) {$name = 'Ei saatavilla';}
                  if(empty($auth)) {$auth = 'Ei saatavilla';}
                  if(empty($pub)) {$pub = 'Ei saatavilla';}
                  if(empty($year)) {$year = 'Ei saatavilla';}
                  if(empty($data)) {$data = 'Kuvausta ei saatavilla'; }
       
                  echo $name;
                  echo '</h1></div><div id="image">';
                  echo '<img src="'.$_SERVER['PHP_SELF'].'?id='.$id.'&pid='.$p_id.'">';
                  echo '</div><div id="desc"><article><p><b>Tekijä: </b>';
                  echo $auth;
                  echo '<br /><b>Kustantaja: </b>';
                  echo $pub;
                  echo '<br /><b>Vuosi: </b>';
                  echo $year;
                  echo '<br /></p><p>';
                  echo $data;
                  echo '</p></article></div></div></body></html>';
                  break;
       
              case 't':
       
              // description text only
       
                  $result = $conn->query("SELECT data FROM media WHERE proweb_id = '$p_id' AND type_id = 'DESC' AND datatype = 'TEXT'") or die(mysql_error());
                  if ($desc = mysqli_fetch_array($result)) {
                      $data = $desc['data'];
       
                      if (empty($data)) {$data = 'Kuvausta ei saatavilla'; }
       
                      echo '<!DOCTYPE html>';
                      echo '<html>';
                      echo '<head><meta http-equiv="Content-Type" content="text/html;charset=utf-8"></head>';
                      echo '<body bgcolor=#F0F0F0>';
                      echo '<article><p>';
                      echo $data;
                      echo '</p></article></body></html>';
       
                  }
                  break;
              case 'xml';
               
              //xml-listing of all existing media for selected product
               
                  $xml_query = $conn->query("select distinct media.id, media.type_id, media.datatype, media.rights, media.date_modified from media, license, media_type where media.proweb_id = $p_id and media.type_id = license.mediatype_id and license.accno = $accno and license.pwcategory_id = $iidee");
               
                  $xml_amount = mysqli_num_rows($xml_query);
                   
                  if ($xml_amount == 0) {echo "sinulla ei ole oikeuksia tuotteen {$p_id} medioihin"; exit();}
               
                  function sqlToXml($queryResult, $rootElementName, $childElementName) {
                      $xmlData = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n";
                      $xmlData .= "<" . $rootElementName . ">";
                    
                      while($record = mysql_fetch_object($queryResult))
                      {
                          /* Create the first child element */
                          $xmlData .= "<" . $childElementName . ">";
                    
                          for ($i = 0; $i < mysql_num_fields($queryResult); $i++)
                          {
                              $fieldName = mysql_field_name($queryResult, $i);
                    
                              /* The child will take the name of the table column */
                              $xmlData .= "<" . $fieldName . ">";
                    
                              /* We set empty columns with NULL, or you could set
                                  it to '0' or a blank. */
                              if(!empty($record->$fieldName))
                                  $xmlData .= $record->$fieldName;
                              else
                                  $xmlData .= "null";
                    
                              $xmlData .= "</" . $fieldName . ">";
                          }
                          $xmlData .= "</" . $childElementName . ">";
                      }
                      $xmlData .= "</" . $rootElementName . ">";
                    
                      return $xmlData;
                  }
                  header("Content-Type: application/xml");
                  echo sqlToXml($xml_query, "Mediatyypit", "Mediatyyppi");
                  break;
          
      }
 
    mysqli_close($conn);

} 
?>