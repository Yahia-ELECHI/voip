<?php

		
	try {
		
	    $con = new PDO("mysql:host=localhost;dbname=cdrcmr","test", "test", array(
        PDO::MYSQL_ATTR_LOCAL_INFILE => true,));
		
	}catch (Exception $e){
		die('Erreur : ' . $e->getMessage());
		
		//die('Erreur : impossible de se connecter à la base de donnée');
	}
$DirTrunkGW= str_replace("\\", "/", 'C:\xampp\htdocs\Stagiaire\TunkGW\trunkvaleo.csv');


ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);
    $host="192.168.86.150";
    $username="admin";
    $password="Gss@2016";

$context = stream_context_create([


    'ssl' => [


        // set some SSL/TLS specific options


        'verify_peer' => false,


        'verify_peer_name' => false,


        'allow_self_signed' => true


    ]


]);


    //$context = stream_context_create(array('ssl'=>array(
        //'allow_self_signed'=>true,
        //'cafile'=>"cucmpub.pem"
        //)));

    $client = new SoapClient("../axlsqltoolkit/schema/11.5/AXLAPI.wsdl",
        //$client = new SoapClient("AXLAPI.wsdl",
        array('trace'=>true,
       'exceptions'=>true,
       'location'=>"https://".$host.":8443/axl",
       'login'=>$username,
       'password'=>$password,
     'stream_context'=>$context       
    ));


    // Just set every tag you want returned to an empty string ("") in this array
    $returnedTags = array("name"=>"","subNet"=>"","subNetMaskSz"=>"");

    // "%" is a wild card to find every user
    $searchCriteria = array("name"=>"%");


    try {
        $response = $client->listDeviceMobility(array("returnedTags"=>
            $returnedTags,"searchCriteria"=>$searchCriteria));
    }
    catch (SoapFault $sf) {
        echo "SoapFault: " . $sf . "<BR>";
    }
    catch (Exception $e) {
        echo "Exception: ". $e ."<br>";
    }

//********************************************************************
function cidrToRange($ipaddr,$Maskcidr) {
  $LastIP = long2ip((ip2long($ipaddr)) + pow(2, (32 - $Maskcidr)) - 1);
  return $LastIP;
}
//********************************************************************

//echo(cidrToRange("73.35.143.0","24"));
$sqlTRUNCATE = "TRUNCATE TABLE `devicemobility`";
$resultTRUNCATE=$con->query($sqlTRUNCATE);

    // Iterate through array of returned values (as specified by $returnedTags)
    foreach($response->return->deviceMobility as $deviceMobility) {
        $DMname = $deviceMobility->name;
        $DMsubnet = $deviceMobility->subNet;
        $DMmask = $deviceMobility->subNetMaskSz;
        $DMbrdcastIP = (cidrToRange($DMsubnet,$DMmask));
        //echo $DMsubnet."---->".$DMbrdcastIP."<BR>";
        //echo("<hr>");
        $sqlDeviceMobility = ("INSERT INTO `devicemobility`(`name`, `subnetip`, `brdcastip`, `mask`) VALUES ('$DMname','$DMsubnet','$DMbrdcastIP','$DMmask')");
        $resultDeviceMobility = $con->query($sqlDeviceMobility);
    }

if(isset($_POST["Import"])){

   

$sqlTrunkGW = ("LOAD DATA LOCAL INFILE '$DirTrunkGW'" . "INTO TABLE `devicemobility` FIELDS TERMINATED BY ',' LINES TERMINATED BY '\\n' IGNORE 1 LINES (name,subnetip,brdcastip,mask)");
$resultTrunkGW = $con->query($sqlTrunkGW);

if(!isset($resultTrunkGW))
        {
          echo "<script type=\"text/javascript\">
              alert(\"Error during importing sites.\");
              window.location = \"CMlocation.php\"
              </script>";    
        }
        else {
            echo "<script type=\"text/javascript\">
            alert(\"Sites has been successfully Imported.\");
            window.location = \"CMlocation.php\"
          </script>";
        }
        
       
 
     }

?>