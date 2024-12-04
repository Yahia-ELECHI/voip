<?php		
	try {
		
	    $con = new PDO("mysql:host=localhost;dbname=cdrcmr","test", "test", array(
        PDO::MYSQL_ATTR_LOCAL_INFILE => true,));
		
	}catch (Exception $e){
		die('Erreur : ' . $e->getMessage());
		
		//die('Erreur : impossible de se connecter à la base de donnée');
	}	
?>

<?php
set_time_limit(0);



if(isset($_POST["Import"])){

    $filename= str_replace("\\", "/", $_FILES['file']['tmp_name']);  
     if($_FILES["file"]["size"] > 0)
     {

 $sql = ("LOAD DATA LOW_PRIORITY LOCAL INFILE '$filename'" . "INTO TABLE `CMR` FIELDS TERMINATED BY ',' LINES TERMINATED BY '\\n' IGNORE 1 LINES (cmr_cdrRecordType,cmr_globalCallID_callManagerId,cmr_globalCallID_callId,cmr_orignodeId,cmr_destnodeId,cmr_origlegcallIdentifier,cmr_destlegidentifier,cmr_orignumberPacketsSent,cmr_orignumberOctetsSent,cmr_orignumberPacketsReceived,cmr_orignumberOctetsReceived,cmr_orignumberPacketsLost,cmr_destnumberPacketsSent,cmr_destnumberOctetsSent,cmr_destnumberPacketsReceived,cmr_destnumberOctetsReceived,cmr_destnumberPacketsLost,cmr_origjitter,cmr_destjitter,cmr_origlatency,cmr_destlatency,cmr_pkid,cmr_origdeviceName,cmr_destdeviceName,cmr_origvarVQMetrics,cmr_destvarVQMetrics,cmr_globalCallId_ClusterID,cmr_callingPartyNumber,cmr_finalCalledPartyNumber,cmr_callingPartyNumberPartition,cmr_finalCalledPartyNumberPartition)");
         
//$sql = ("LOAD DATA LOW_PRIORITY LOCAL INFILE '$filename'" . "INTO TABLE `CMR` FIELDS TERMINATED BY ',' LINES TERMINATED BY '\\n' IGNORE 1 LINES (cmr_cdrRecordType,cmr_globalCallID_callManagerId,cmr_globalCallID_callId,cmr_orignodeId,cmr_destnodeId,cmr_origlegcallIdentifier,cmr_destlegidentifier,cmr_orignumberPacketsSent,cmr_orignumberOctetsSent,cmr_orignumberPacketsReceived,cmr_orignumberOctetsReceived,cmr_orignumberPacketsLost,cmr_destnumberPacketsSent,cmr_destnumberOctetsSent,cmr_destnumberPacketsReceived,cmr_destnumberOctetsReceived,cmr_destnumberPacketsLost,cmr_origjitter,cmr_destjitter,cmr_origlatency,cmr_destlatency,cmr_pkid,cmr_origdeviceName,cmr_destdeviceName,@cmr_origvarVQMetrics,@cmr_destvarVQMetrics,cmr_globalCallId_ClusterID,cmr_callingPartyNumber,cmr_finalCalledPartyNumber,cmr_callingPartyNumberPartition,cmr_finalCalledPartyNumberPartition) SET cmr_origvarVQMetrics = SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(@cmr_origvarVQMetrics,LOCATE('SCS=',@cmr_origvarVQMetrics),8),';',1),'=',-1),cmr_destvarVQMetrics = SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(@cmr_destvarVQMetrics,LOCATE('SCS=',@cmr_destvarVQMetrics),8),';',1),'=',-1)");



$result = $con->query($sql);



 

 

if(!isset($result))
        {
          echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"CMR.php\"
              </script>";    
        }
        else {
            echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"CMR.php\"
          </script>";
        }
        
       }
      
           fclose($file);  
     }
 
?>