<?php
/**
 * THIS IS THE ACCOUNT CREATION API, DO NOT BREAK!!
 */
//echo "V0.0.19 initialized...<br>";

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once('./os_remad.php');

//echo "creating a new account...<br>";


$session = opensim_rest_session(
    array(
      'uri' => "cherryworks.serv.nu:9008",
      'ConsoleUser' => 'Bonii0RemAdmin',
      'ConsolePass' => 'G6sXzFbT9r$HkYl3IeM#8qJvDp1C&',
    )
);

function fs_payload_broker($string) {
//    $string = preg_replace('/[^A-Za-z0-9$\/=]/', '-', $string);
    $string = preg_replace('/[^A-Za-z0-9@$\/=.]/', '-', $string);
    $string = str_replace(' ', '-', $string);   // AT FIRST THIS IS A SMALL PAYLOAD BROKER
    $string = str_replace('$', '-', $string);   // IT WILL CLEAN UP ALL OF THE POTENTIAL
    $string = str_replace('\'', '-', $string);  // PAYLOADS THAT THE ATTACKER SENDS
    $string = str_replace('\"', '-', $string);  // 
    return preg_replace('/-+/', '-', $string);  // BASICALLY, STRING SANITIZATION
}

//echo "payload broker enabled...<br>";

function generateUuidv4()
{
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    // 32 bits for "time_low"
    mt_rand(0, 0xffff), mt_rand(0, 0xffff),
    // 16 bits for "time_mid"
    mt_rand(0, 0xffff),
    // 16 bits for "time_hi_and_version",
    // four most significant bits holds version number 4
    mt_rand(0, 0x0fff) | 0x4000,
    // 16 bits, 8 bits for "clk_seq_hi_res",
    // 8 bits for "clk_seq_low",
    // two most significant bits holds zero and one for variant DCE1.1
    mt_rand(0, 0x3fff) | 0x8000,
    // 48 bits for "node"
    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

//echo "class uuid created completed...<br>";

$User = $_GET['UXSYEBRR'];
$Lnme = $_GET['LXNYMBER'];
$Pssw = $_GET['PYSXSBWD'];
$Mail = $_GET['MXAYIBLR'];

//echo "fetched args<br>";

$Enc_pwd = fs_payload_broker($Pssw);
//$Gen_id = UUID::v4();
$Gen_id=generateUuidv4();

//echo "started session for rest konsole...<br>";
$cMail = fs_payload_broker($Mail);
$cUser = fs_payload_broker($User);
$cLnme = fs_payload_broker($Lnme);

//$command = "create user " . $cUser . " " . $cLnme . " " . $Enc_pwd . " " . $cMail . " " . $Gen_id . " 00000000-0000-0000-0000-00000000";
//echo $command . "<br>";

if(strlen($cUser) <= 2){echo 'user cant be blank';/*header("Location: http://cherryworks.serv.nu:80/index.php");*/die();}
if(strlen($cLnme) <= 2){echo 'lname cant be null';/*header("Location: http://cherryworks.serv.nu:80/index.php");*/die();}
if(strlen($cMail) <= 2){echo 'mail cant be blank';/*header("Location: http://cherryworks.serv.nu:80/index.php");*/die();}
if(strlen($Enc_pwd) <= 2){echo 'must set passwrd';/*header("Location: http://cherryworks.serv.nu:80/index.php");*/die();}    

$command = "create user " . $cUser . " " . $cLnme . " " . $Enc_pwd . " " . $cMail . " " . $Gen_id . " 00000000-0000-0000-0000-00000000";
//echo $command . "<br>";
    
if ( is_opensim_rest_error($session) ) {
    //echo $session->getMessage() . "<br>";
    //echo "failed... <br>";
    error_log( "OpenSim_Rest error: " . $session->getMessage() );
  } else {
    //echo "success...<br>";
    $responseLines = $session->sendCommand($command);
    //echo $responseLines . "<br>";
  }
  //echo "completed...";
  header("Location: http://cherryworks.serv.nu:80/index.php");
  die();
?>
