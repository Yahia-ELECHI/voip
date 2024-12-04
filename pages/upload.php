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

 
$sql = ("LOAD DATA LOCAL INFILE '$filename'" . "INTO TABLE `CDR` FIELDS TERMINATED BY ',' LINES TERMINATED BY '\\n' IGNORE 1 LINES (cdr_cdrRecordType, cdr_globalCallID_callManagerId, cdr_globalCallID_callId, cdr_origLegCallIdentifier,@dateTimeOrigination,cdr_origNodeId, cdr_origSpan, cdr_origIpAddr, cdr_callingPartyNumber, cdr_callingPartyUnicodeLoginUserID, cdr_origCause_location, cdr_origCause_value, cdr_origPrecedenceLevel, cdr_origMediaTransportAddress_IP, cdr_origMediaTransportAddress_Port, cdr_origMediaCap_payloadCapability, cdr_origMediaCap_maxFramesPerPacket, cdr_origMediaCap_g723BitRate, cdr_origVideoCap_Codec, cdr_origVideoCap_Bandwidth, cdr_origVideoCap_Resolution, cdr_origVideoTransportAddress_IP, cdr_origVideoTransportAddress_Port, cdr_origRSVPAudioStat, cdr_origRSVPVideoStat, cdr_destLegIdentifier, cdr_destNodeId, cdr_destSpan, cdr_destIpAddr, cdr_originalCalledPartyNumber, cdr_finalCalledPartyNumber, cdr_finalCalledPartyUnicodeLoginUserID, cdr_destCause_location, cdr_destCause_value, cdr_destPrecedenceLevel, cdr_destMediaTransportAddress_IP, cdr_destMediaTransportAddress_Port, cdr_destMediaCap_payloadCapability, cdr_destMediaCap_maxFramesPerPacket, cdr_destMediaCap_g723BitRate, cdr_destVideoCap_Codec, cdr_destVideoCap_Bandwidth, cdr_destVideoCap_Resolution, cdr_destVideoTransportAddress_IP, cdr_destVideoTransportAddress_Port, cdr_destRSVPAudioStat, cdr_destRSVPVideoStat, cdr_dateTimeConnect, cdr_dateTimeDisconnect, cdr_lastRedirectDn, cdr_pkid, cdr_originalCalledPartyNumberPartition, cdr_callingPartyNumberPartition, cdr_finalCalledPartyNumberPartition, cdr_lastRedirectDnPartition, cdr_duration, cdr_origDeviceName, cdr_destDeviceName, cdr_origCallTerminationOnBehalfOf, cdr_destCallTerminationOnBehalfOf, cdr_origCalledPartyRedirectOnBehalfOf, cdr_lastRedirectRedirectOnBehalfOf, cdr_origCalledPartyRedirectReason, cdr_lastRedirectRedirectReason, cdr_destConversationId, cdr_globalCallId_ClusterID, cdr_joinOnBehalfOf, cdr_comment, cdr_authCodeDescription, cdr_authorizationLevel, cdr_clientMatterCode,cdr_origDTMFMethod, cdr_destDTMFMethod, cdr_callSecuredStatus, cdr_origConversationId, cdr_origMediaCap_Bandwidth, cdr_destMediaCap_Bandwidth, cdr_authorizationCodeValue, cdr_outpulsedCallingPartyNumber, cdr_outpulsedCalledPartyNumber, cdr_origIpv4v6Addr, cdr_destIpv4v6Addr, cdr_origVideoCap_Codec_Channel2, cdr_origVideoCap_Bandwidth_Channel2, cdr_origVideoCap_Resolution_Channel2, cdr_origVideoTransportAddress_IP_Channel2, cdr_origVideoTransportAddress_Port_Channel2, cdr_origVideoChannel_Role_Channel2, cdr_destVideoCap_Codec_Channel2, cdr_destVideoCap_Bandwidth_Channel2, cdr_destVideoCap_Resolution_Channel2, cdr_destVideoTransportAddress_IP_Channel2, cdr_destVideoTransportAddress_Port_Channel2, cdr_destVideoChannel_Role_Channel2, cdr_incomingProtocolID, cdr_incomingProtocolCallRef, cdr_outgoingProtocolID, cdr_outgoingProtocolCallRef, cdr_currentRoutingReason, cdr_origRoutingReason, cdr_lastRedirectingRoutingReason, cdr_huntPilotDN, cdr_huntPilotPartition, cdr_calledPartyPatternUsage, cdr_outpulsedOriginalCalledPartyNumber, cdr_outpulsedLastRedirectingNumber, cdr_wasCallQueued, cdr_totalWaitTimeInQueue, cdr_callingPartyNumber_uri, cdr_originalCalledPartyNumber_uri, cdr_finalCalledPartyNumber_uri, cdr_lastRedirectDn_uri, cdr_mobileCallingPartyNumber, cdr_finalMobileCalledPartyNumber, cdr_origMobileDeviceName, cdr_destMobileDeviceName, cdr_origMobileCallDuration, cdr_destMobileCallDuration, cdr_mobileCallType, cdr_originalCalledPartyPattern, cdr_finalCalledPartyPattern, cdr_lastRedirectingPartyPattern, cdr_huntPilotPattern) SET cdr_dateTimeOrigination = FROM_UNIXTIME(@dateTimeOrigination)");

 
$result = $con->query($sql);


 

 

if(!isset($result))
        {
          echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"CDR.php\"
              </script>";    
        }
        else {
            echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"CDR.php\"
          </script>";
        }
        
       }
      
           fclose($file);  
     }
 
?>