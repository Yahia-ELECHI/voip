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
if(isset($_POST["Import"])?$_GET['Import']:1);
$SQLcountindexcdr=("select MAX(cdr_ID) from cdr USE INDEX (PRIMARY)");
$resultcountindexcdr = $con->query($SQLcountindexcdr);
    while($TblRSTidxCDR=$resultcountindexcdr->fetch()){$OLDdiffcdr=($TblRSTidxCDR['MAX(cdr_ID)']);}
    
    
$SQLcountindexcmr=("select MAX(cmr_ID) from cmr USE INDEX (PRIMARY)");
$resultcountindexcmr = $con->query($SQLcountindexcmr);
    while($TblRSTidxCMR=$resultcountindexcmr->fetch()){$OLDdiffcmr=($TblRSTidxCMR['MAX(cmr_ID)']);}



//***********************Remote pull file CDR/CMR***************
$Directory= str_replace("\\", "/", 'C:\Users\webapp\Downloads\CDR\test\\');  //Directory work
$ArcDirectory= str_replace("\\", "/", 'C:\Users\webapp\Downloads\CDR\archive\\');   //directory archive


//*****************  function to list and sort file into work directory*********
function GetFilesAndFolder($Directory) {
    /*Which file want to be escaped, Just add to this array*/
    $EscapedFiles = [
        '.',
        '..'
    ];

    $FilesAndFolders = [];
    /*Scan Files and Directory*/
    $FilesAndDirectoryList = scandir($Directory);
    foreach ($FilesAndDirectoryList as $SingleFile) {
        if (in_array($SingleFile, $EscapedFiles)){
            continue;
        }
        /*Store the Files with Modification Time to an Array*/
        $FilesAndFolders[$SingleFile] = filemtime($Directory . '/' . $SingleFile);
    }
    /*Sort the result as your needs*/
    arsort($FilesAndFolders);
    $FilesAndFolders = array_keys($FilesAndFolders);

    return ($FilesAndFolders) ? $FilesAndFolders : false;
}


//***************get function result****************
$data = GetFilesAndFolder($Directory);
//**************************************************


//*********************check if any file exit in the directory and check evry file idivudualy******************************
$cntmtchcdr=0;
$cntmtchcmr=0;
$countmatchescdr=0;
$countmatchescmr=0;
$icdr=0;
$icmr=0;
if(!empty($data)){

    foreach($data as $val) {
  $cntmtchcdr=preg_match_all('/(.*CDR.*)/i', $val, $matchecdr);
  $cntmtchcmr=preg_match_all('/(.*CMR.*)/i', $val, $matchecmr);
        if($cntmtchcdr==1){$icdr++;}
        if($cntmtchcmr==1){$icmr++;}
     //echo $val;
     //$cntmtchcdr=($matchecdr[0][0]);
     //$cntmtchcmr=($matchecmr[0][0]);
}
    //print_r ($matchecdr);
    //echo "//////////";
    //print_r ($matchecmr);
    //echo "//////////";
    //echo $cntmtchcdr;
    //echo "//////////";
    //echo $cntmtchcmr;
    //echo "//////////";
    //echo $icdr;
    //echo "//////////";
    //echo $icmr;
if ($icdr==1 and $icmr==1){
foreach($data as $val) {
  $countmatchescdr=preg_match_all('/(CDR)/i', $val, $matchecdr);
  $countmatchescmr=preg_match_all('/(CMR)/i', $val, $matchecmr);
//    ********************** test file cdr matched*************
if($countmatchescdr==1){


    $filename= ($Directory.$val);  
      
$sql = ("LOAD DATA LOCAL INFILE '$filename'" . "INTO TABLE `CDR` FIELDS TERMINATED BY ',' LINES TERMINATED BY '\\n' IGNORE 1 LINES (cdr_cdrRecordType, cdr_globalCallID_callManagerId, cdr_globalCallID_callId, cdr_origLegCallIdentifier,@dateTimeOrigination,cdr_origNodeId, cdr_origSpan, cdr_origIpAddr, cdr_callingPartyNumber, cdr_callingPartyUnicodeLoginUserID, cdr_origCause_location, cdr_origCause_value, cdr_origPrecedenceLevel, cdr_origMediaTransportAddress_IP, cdr_origMediaTransportAddress_Port, cdr_origMediaCap_payloadCapability, cdr_origMediaCap_maxFramesPerPacket, cdr_origMediaCap_g723BitRate, cdr_origVideoCap_Codec, cdr_origVideoCap_Bandwidth, cdr_origVideoCap_Resolution, cdr_origVideoTransportAddress_IP, cdr_origVideoTransportAddress_Port, cdr_origRSVPAudioStat, cdr_origRSVPVideoStat, cdr_destLegIdentifier, cdr_destNodeId, cdr_destSpan, cdr_destIpAddr, cdr_originalCalledPartyNumber, cdr_finalCalledPartyNumber, cdr_finalCalledPartyUnicodeLoginUserID, cdr_destCause_location, cdr_destCause_value, cdr_destPrecedenceLevel, cdr_destMediaTransportAddress_IP, cdr_destMediaTransportAddress_Port, cdr_destMediaCap_payloadCapability, cdr_destMediaCap_maxFramesPerPacket, cdr_destMediaCap_g723BitRate, cdr_destVideoCap_Codec, cdr_destVideoCap_Bandwidth, cdr_destVideoCap_Resolution, cdr_destVideoTransportAddress_IP, cdr_destVideoTransportAddress_Port, cdr_destRSVPAudioStat, cdr_destRSVPVideoStat, cdr_dateTimeConnect, cdr_dateTimeDisconnect, cdr_lastRedirectDn, cdr_pkid, cdr_originalCalledPartyNumberPartition, cdr_callingPartyNumberPartition, cdr_finalCalledPartyNumberPartition, cdr_lastRedirectDnPartition, cdr_duration, cdr_origDeviceName, cdr_destDeviceName, cdr_origCallTerminationOnBehalfOf, cdr_destCallTerminationOnBehalfOf, cdr_origCalledPartyRedirectOnBehalfOf, cdr_lastRedirectRedirectOnBehalfOf, cdr_origCalledPartyRedirectReason, cdr_lastRedirectRedirectReason, cdr_destConversationId, cdr_globalCallId_ClusterID, cdr_joinOnBehalfOf, cdr_comment, cdr_authCodeDescription, cdr_authorizationLevel, cdr_clientMatterCode,cdr_origDTMFMethod, cdr_destDTMFMethod, cdr_callSecuredStatus, cdr_origConversationId, cdr_origMediaCap_Bandwidth, cdr_destMediaCap_Bandwidth, cdr_authorizationCodeValue, cdr_outpulsedCallingPartyNumber, cdr_outpulsedCalledPartyNumber, cdr_origIpv4v6Addr, cdr_destIpv4v6Addr, cdr_origVideoCap_Codec_Channel2, cdr_origVideoCap_Bandwidth_Channel2, cdr_origVideoCap_Resolution_Channel2, cdr_origVideoTransportAddress_IP_Channel2, cdr_origVideoTransportAddress_Port_Channel2, cdr_origVideoChannel_Role_Channel2, cdr_destVideoCap_Codec_Channel2, cdr_destVideoCap_Bandwidth_Channel2, cdr_destVideoCap_Resolution_Channel2, cdr_destVideoTransportAddress_IP_Channel2, cdr_destVideoTransportAddress_Port_Channel2, cdr_destVideoChannel_Role_Channel2, cdr_incomingProtocolID, cdr_incomingProtocolCallRef, cdr_outgoingProtocolID, cdr_outgoingProtocolCallRef, cdr_currentRoutingReason, cdr_origRoutingReason, cdr_lastRedirectingRoutingReason, cdr_huntPilotDN, cdr_huntPilotPartition, cdr_calledPartyPatternUsage, cdr_outpulsedOriginalCalledPartyNumber, cdr_outpulsedLastRedirectingNumber, cdr_wasCallQueued, cdr_totalWaitTimeInQueue, cdr_callingPartyNumber_uri, cdr_originalCalledPartyNumber_uri, cdr_finalCalledPartyNumber_uri, cdr_lastRedirectDn_uri, cdr_mobileCallingPartyNumber, cdr_finalMobileCalledPartyNumber, cdr_origMobileDeviceName, cdr_destMobileDeviceName, cdr_origMobileCallDuration, cdr_destMobileCallDuration, cdr_mobileCallType, cdr_originalCalledPartyPattern, cdr_finalCalledPartyPattern, cdr_lastRedirectingPartyPattern, cdr_huntPilotPattern) SET cdr_dateTimeOrigination = FROM_UNIXTIME(@dateTimeOrigination)");

 
$result = $con->query($sql);
    

    
  //****move file cdr to archive**********  
rename($Directory.$val , $ArcDirectory.$val);                                   



} //IF CDR FILE EXIST

        //*************test file cmr matched********
    if($countmatchescmr==1){
        
    

    $filename= ($Directory.$val);  


 $sql = ("LOAD DATA LOW_PRIORITY LOCAL INFILE '$filename'" . "INTO TABLE `CMR` FIELDS TERMINATED BY ',' LINES TERMINATED BY '\\n' IGNORE 1 LINES (cmr_cdrRecordType,cmr_globalCallID_callManagerId,cmr_globalCallID_callId,cmr_orignodeId,cmr_destnodeId,cmr_origlegcallIdentifier,cmr_destlegidentifier,cmr_orignumberPacketsSent,cmr_orignumberOctetsSent,cmr_orignumberPacketsReceived,cmr_orignumberOctetsReceived,cmr_orignumberPacketsLost,cmr_destnumberPacketsSent,cmr_destnumberOctetsSent,cmr_destnumberPacketsReceived,cmr_destnumberOctetsReceived,cmr_destnumberPacketsLost,cmr_origjitter,cmr_destjitter,cmr_origlatency,cmr_destlatency,cmr_pkid,cmr_origdeviceName,cmr_destdeviceName,cmr_origvarVQMetrics,cmr_destvarVQMetrics,cmr_globalCallId_ClusterID,cmr_callingPartyNumber,cmr_finalCalledPartyNumber,cmr_callingPartyNumberPartition,cmr_finalCalledPartyNumberPartition)");
         
//$sql = ("LOAD DATA LOW_PRIORITY LOCAL INFILE '$filename'" . "INTO TABLE `CMR` FIELDS TERMINATED BY ',' LINES TERMINATED BY '\\n' IGNORE 1 LINES (cmr_cdrRecordType,cmr_globalCallID_callManagerId,cmr_globalCallID_callId,cmr_orignodeId,cmr_destnodeId,cmr_origlegcallIdentifier,cmr_destlegidentifier,cmr_orignumberPacketsSent,cmr_orignumberOctetsSent,cmr_orignumberPacketsReceived,cmr_orignumberOctetsReceived,cmr_orignumberPacketsLost,cmr_destnumberPacketsSent,cmr_destnumberOctetsSent,cmr_destnumberPacketsReceived,cmr_destnumberOctetsReceived,cmr_destnumberPacketsLost,cmr_origjitter,cmr_destjitter,cmr_origlatency,cmr_destlatency,cmr_pkid,cmr_origdeviceName,cmr_destdeviceName,@cmr_origvarVQMetrics,@cmr_destvarVQMetrics,cmr_globalCallId_ClusterID,cmr_callingPartyNumber,cmr_finalCalledPartyNumber,cmr_callingPartyNumberPartition,cmr_finalCalledPartyNumberPartition) SET cmr_origvarVQMetrics = SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(@cmr_origvarVQMetrics,LOCATE('SCS=',@cmr_origvarVQMetrics),8),';',1),'=',-1),cmr_destvarVQMetrics = SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(@cmr_destvarVQMetrics,LOCATE('SCS=',@cmr_destvarVQMetrics),8),';',1),'=',-1)");



$result = $con->query($sql);

        
    //*********move file cmr to archive******
    rename($Directory.$val , $ArcDirectory.$val);
    
    
} //IF CMR FILE EXIST

} //FOREACH
    
    
    
//**************************Traitement*****************
    
$SQLcountindexcdr=("select MAX(cdr_ID) from cdr USE INDEX (PRIMARY)");
$resultcountindexcdr = $con->query($SQLcountindexcdr);
    while($TblRSTidxCDR=$resultcountindexcdr->fetch()){$NEWdiffcdr=($TblRSTidxCDR['MAX(cdr_ID)']);}
    
    
$SQLcountindexcmr=("select MAX(cmr_ID) from cmr USE INDEX (PRIMARY)");
$resultcountindexcmr = $con->query($SQLcountindexcmr);
    while($TblRSTidxCMR=$resultcountindexcmr->fetch()){$NEWdiffcmr=($TblRSTidxCMR['MAX(cmr_ID)']);}
    //echo "///";
    //echo $NEWdiffcdr;
    //echo "///";
    //echo $OLDdiffcdr;
    //echo "///";
    //echo $NEWdiffcmr;
    //echo "///";
    //echo $OLDdiffcmr;
    //echo "///";
    
if($NEWdiffcdr>$OLDdiffcdr and $NEWdiffcmr>$OLDdiffcmr){   
    
    $sqlINSERT = ("INSERT INTO resultat(
    Rcdr_ID,
    Rcmr_ID,
    cmr_pkid,
    cdr_globalCallID_callId,
    cdr_dateTimeOrigination,
    cdr_duration,
    cmr_callingPartyNumber,
    cmr_finalCalledPartyNumber,
    cmr_origvarVQMetrics,
    cmr_destvarVQMetrics,
    cmr_origdeviceName,
    cmr_destdeviceName,
    SiteSource,
    SiteDestination

)
SELECT
    cdr.cdr_ID,
    cmr.cmr_ID,
	cmr.cmr_pkid,
    cmr.cmr_globalCallID_callId,
    cdr.cdr_dateTimeOrigination,
    SUM(cdr.cdr_duration),
    cmr.cmr_callingPartyNumber,
    cmr.cmr_finalCalledPartyNumber,
    GROUP_CONCAT(cmr.cmr_origvarVQMetrics),
    GROUP_CONCAT(cmr.cmr_destvarVQMetrics),
    cmr.cmr_origdeviceName,
    cmr.cmr_destdeviceName,
    cdr_origIpv4v6Addr,
    cdr_destIpv4v6Addr

FROM
    cdr
LEFT JOIN cdrcmr.cmr ON
    cdr.cdr_pkid LIKE cmr.cmr_pkid
    where (cdr.cdr_ID > '$OLDdiffcdr' AND cmr.cmr_ID > '$OLDdiffcmr')
GROUP BY
    cmr.cmr_globalCallID_callId");
$sqlIDELETE = ("DELETE FROM `resultat` WHERE resultat.cdr_duration = 0");
$sqlIDELETESCS = ("DELETE FROM `resultat` WHERE resultat.cmr_origvarVQMetrics ='' AND resultat.cmr_destvarVQMetrics = ''");
$sqlISELECT=("select cmr_pkid,cdr_duration, cmr_origvarVQMetrics,cmr_destvarVQMetrics,cmr_origdeviceName,cmr_destdeviceName,SiteSource,SiteDestination from resultat where (Rcdr_ID > '$OLDdiffcdr' AND Rcmr_ID > '$OLDdiffcmr')");
 
$resultINSERT = $con->query($sqlINSERT);
$resultDELETE = $con->query($sqlIDELETE);
$resultDELETESCS = $con->query($sqlIDELETESCS);
$resultSELECT = $con->query($sqlISELECT);


                while($TableRST=$resultSELECT->fetch()){
    //***************SCS1****************************    
    $countmatchesscs1 = preg_match_all('/SCS\=(\d+)/i', $TableRST['cmr_origvarVQMetrics'], $matchesscs1);
    $iscs1 = 0;
    $sommescs1 = 0;
    $divscs1=0;
    if (!empty($countmatchesscs1)) {
        while ($iscs1 < $countmatchesscs1) {
//
            $mscs1 = ($matchesscs1[1][$iscs1]);
            if(is_numeric($mscs1)){
            $sommescs1 = $sommescs1 + $mscs1;
            $divscs1++;
            $iscs1++;
                }
            else{$iscs1++;}
        }
        $moysommescs1 = ($sommescs1 / $divscs1);

        }
                    
    


    //***************SCS2**************************** 
                    
    $countmatchesscs2= preg_match_all('/SCS\=(\d+)/i',$TableRST['cmr_destvarVQMetrics'] , $matchesscs2);
    $iscs2 = 0;
    $sommescs2 = 0;
    $divscs2=0;
    if (!empty($countmatchesscs2)) {
        while ($iscs2 < $countmatchesscs2) {
//
            $mscs2 = ($matchesscs2[1][$iscs2]);
            if(is_numeric($mscs2)){
            $sommescs2 = $sommescs2 + $mscs2;
            $divscs2++;
            $iscs2++;
                }
            else{$iscs2++;}
        }
        $moysommescs2 = ($sommescs2 / $divscs2);

        }
                    
                    //***************MOY SCS**************************** 
                   
    $Duree= $TableRST['cdr_duration'];
    if (!is_numeric($moysommescs1)){$MOYSCS= ($moysommescs2/$Duree);}
    elseif (!is_numeric($moysommescs2)){$MOYSCS= ($moysommescs1/$Duree);}
    else{$MOYSCS= ((($moysommescs1 + $moysommescs2)/2)/$Duree);}
                    
                    //***************Classification****************************
                        if($Duree > 0 and $Duree <20){

                            if($MOYSCS > 0.3){$Class= "POOR";} 

                            elseif($MOYSCS<0.2){$Class= "GOOD";} 

                            elseif($MOYSCS >= 0.2 and $MOYSCS <= 0.3){$Class= "ACCEPTABLE";}
                          }
                        elseif ($Duree > 0 and $Duree >= 20){

                            if($MOYSCS > 0.07){$Class= "POOR";} 

                            elseif($MOYSCS<0.03){$Class= "GOOD";} 

                            elseif($MOYSCS >= 0.03 and $MOYSCS <= 0.07){$Class= "ACCEPTABLE";}
                        }
                    
                    //***************Type d'appel****************************
                    $devicesource=$TableRST['cmr_origdeviceName'];
                    $devicedest=$TableRST['cmr_destdeviceName'];
                    require('connexion.php');
                    $sqlselecttrunksip=("SELECT name FROM `devicemobility` where name LIKE \"trunk%\" and name NOT LIKE \"Trunk_CUC%\" and name NOT LIKE \"Trunk_IMP%\" and name NOT LIKE \"Trunk_Expressway%\"");
                    $rsttrksip=$con->query($sqlselecttrunksip);
                    
                    
                    while($ROWselecttrunksip=$rsttrksip->fetch()){
                        
                    if($devicesource==$ROWselecttrunksip['name']){$Typeapp= "I";}
                    if($devicedest==$ROWselecttrunksip['name']){$Typeapp= "O";}
                    }
                    if(empty($Typeapp)){$Typeapp="L";}
                    
                    //**********************Function search IP***********************************
                    
                    //**********************Site Source***********************************
                    $IPSOURCE=$TableRST['SiteSource'];
                    
                    $sqlselectDMsrc=("SELECT name FROM devicemobility WHERE (INET_ATON('$IPSOURCE') BETWEEN INET_ATON(`subnetip`) AND INET_ATON(`brdcastip`))");
                    $rsltselectDMsrc=$con->query($sqlselectDMsrc);
                    while($ROWselectDMsrc=$rsltselectDMsrc->fetch()){
                      $sitesrcname= $ROWselectDMsrc['name'];
                    }
                    
                    //********************************************************************
                    //**********************Site Destination***********************************
                    $IPDEST=$TableRST['SiteDestination'];
                    
                     $sqlselectDMdst=("SELECT name FROM devicemobility WHERE (INET_ATON('$IPDEST') BETWEEN INET_ATON(`subnetip`) AND INET_ATON(`brdcastip`))");
                    $rsltselectDMdst=$con->query($sqlselectDMdst);
                    while($ROWselectDMdst=$rsltselectDMdst->fetch()){
                      $sitedstname= $ROWselectDMdst['name'];
                    }
                    //********************************************************************
                    
                    $PKID=$TableRST['cmr_pkid'];
                    $sqlIUPDATE = ("UPDATE resultat SET cmr_origvarVQMetrics= '$moysommescs1',cmr_destvarVQMetrics= '$moysommescs2',	Moyenne_SCS= '$MOYSCS', Classification='$Class',Type= '$Typeapp', SiteSource= '$sitesrcname', SiteDestination= '$sitedstname' WHERE cmr_pkid = '$PKID'");
                    $ResultUPDATE = $con->query($sqlIUPDATE);
                    //echo "///";
                    //echo $moysommescs1;
                    //echo "///";
                    //echo $moysommescs2;
                    //echo "///";
                    //echo $MOYSCS;
                    //echo "///";
                    //echo $Class;
                    //echo "///";
                    //echo $Typeapp;
                    //echo "///";
                    
                    unset($moysommescs1);
                    unset($moysommescs2);
                    unset($MOYSCS);
                    unset($Class);
                    unset($Typeapp);
                    //echo "<---------apres--------->";
                    //echo "///";
                    //echo $moysommescs1;
                    //echo "///";
                    //echo $moysommescs2;
                    //echo "///";
                    //echo $MOYSCS;
                    //echo "///";
                    //echo $Class;
                    //echo "///";
                    //echo $Typeapp;
                    //echo "///";
                    
                    
                }

//echo "DONE !!!!";
} //if($NEWdiffcdr>$OLDdiffcdr and $NEWdiffcmr>$OLDdiffcmr)
else{echo "pas de nvx lignes";}
//*****************************************************
} //IF ($cntmtchcdr=1 and $cntmtchcmr=1)
}//IF EMPTY $DATA

if(!isset($ResultUPDATE))
        {
          echo "<script type=\"text/javascript\">
              alert(\"No new data added.\");
              window.location = \"tableresultat.php\"
              </script>";    
        }
        else {
            echo "<script type=\"text/javascript\">
            alert(\"Sites has been successfully Imported.\");
            window.location = \"tableresultat.php\"
          </script>";
        }
        
       
 
     


?>