<?php
    require_once('./os_remad.php');

    $sql_user = "webosgri";
    $sql_db   = "webosim";
    $sql_pswd = "There3s2just1something1about2them3I4like5t";
    $sql_serv = "localhost";

    function fs_payload_broker($string) {
        $string = preg_replace('/[^A-Za-z0-9$\/=]/', '-', $string);
        $string = str_replace(' ', '-', $string);   // AT FIRST THIS IS A SMALL PAYLOAD BROKER
        $string = str_replace('$', '-', $string);   // IT WILL CLEAN UP ALL OF THE POTENTIAL
        $string = str_replace('\'', '-', $string);  // PAYLOADS THAT THE ATTACKER SENDS
        $string = str_replace('\"', '-', $string);  // 
        return preg_replace('/-+/', '-', $string);  // BASICALLY, STRING SANITIZATION
    }

    $conn = mysqli_connect($sql_serv, $sql_user, $sql_pswd, $sql_db);

    if(!$conn){
        echo 'ERROR: 200';
        die('mysql server couldnt connect');
    }

   $kod = fs_payload_broker($_GET['KYOXDQIRUWM']); // VERIFICATION CODE
   $uid = fs_payload_broker($_GET['UYUWIRDQX']);   // UUID FOR VERIFICATION
   $fnm = fs_payload_broker($_GET['UYSWERRXQ']);   // FIRST NAME
   $lnm = fs_payload_broker($_GET['LYAWSRTXNM']);  // LAST NAME
   $pwd = fs_payload_broker($_GET['NYEWWRPXWQD']); // NEW PASSWORD


   if(strlen($fnm) <= 2){echo 'user cant be blank';/*header("Location: http://cherryworks.serv.nu:80/index.php");*/die();}
   if(strlen($lnm) <= 2){echo 'lname cant be null';/*header("Location: http://cherryworks.serv.nu:80/index.php");*/die();}
   if(strlen($uid) <= 2){echo 'uuid cant be blank';/*header("Location: http://cherryworks.serv.nu:80/index.php");*/die();}
   if(strlen($pwd) <= 2){echo 'must set passwrd';/*header("Location: http://cherryworks.serv.nu:80/index.php");*/die();}    
   if(strlen($kod) <= 2){echo 'code cant be blank';/*header("Location: http://cherryworks.serv.nu:80/index.php");*/die();}

   if(strcmp($uid,'62119bdd-c54b-4136-9a35-4f23e4d0c3ff') == 0){
    die('grid owner cannot reset password');
   }

   $test = "SELECT * FROM Ver_codes WHERE code = '" . $kod . "' AND Valid = 1 AND uuid = '".$uid."' AND uuid <> '62119bdd-c54b-4136-9a35-4f23e4d0c3ff' ORDER BY Id DESC LIMIT 1;";

   $res = mysqli_query($conn, $test);

   if(!$res){
    die('error 900');
   }

   $row_cnt = mysqli_num_rows($res);
   if($row_cnt > 0){
    while ($row = mysqli_fetch_assoc($res)) {
       // echo "<a href=\"".$row['link']."\"><img src=\"" . $row['image'] . "\" width=45% height=45%></img></a>";
       if(strcmp($row['uuid'], $uid)==0 
       && strcmp($row['code'], $kod)==0
       && strcmp($row['FirstName'], $fnm)==0
       && strcmp($row['LastName'], $lnm)==0
       ){
        $session = opensim_rest_session(
            array(
              'uri' => "cherryworks.serv.nu:9008",
              'ConsoleUser' => 'Bonii0RemAdmin0Konsole',
              'ConsolePass' => 'k4l1l1lnuksArt1x$B0nC15k8R3m4Dmn03132431',
            )
        );

        $command = "reset user password " . $fnm . " " . $lnm . " " . $Enc_pwd . " " . $pwd;
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
       }else{
        die('invalid credentials');
       }
    }
   }else{
    die('Invalid code >:(');
   }


   mysqli_free_result($res);
   mysqli_close($conn);

   //echo "completed...";
   header("Location: http://cherryworks.serv.nu:80/index.php");
   die();
?>
