

<?php		
	try {
		
	    $con = new PDO("mysql:host=localhost;dbname=cdrcmr","test", "test", array(
        PDO::MYSQL_ATTR_LOCAL_INFILE => true,));
		
	}catch (Exception $e){
		die('Erreur : ' . $e->getMessage());
		
		//die('Erreur : impossible de se connecter à la base de donnée');
	}	
?>


//**************************Traitement*****************
<?php   
$SQLcountindexcdr=("select MAX(cdr_ID) from cdr USE INDEX (PRIMARY)");
$resultcountindexcdr = $con->query($SQLcountindexcdr);
    while($TblRSTidxCDR=$resultcountindexcdr->fetch()){$NEWdiffcdr=($TblRSTidxCDR['MAX(cdr_ID)']);}
    
    
$SQLcountindexcmr=("select MAX(cmr_ID) from cmr USE INDEX (PRIMARY)");
$resultcountindexcmr = $con->query($SQLcountindexcmr);
    while($TblRSTidxCMR=$resultcountindexcmr->fetch()){$NEWdiffcmr=($TblRSTidxCMR['MAX(cmr_ID)']);}
  //  echo "///";
  //  echo $NEWdiffcdr;
  //  echo "///";
  //  echo $OLDdiffcdr;
  //  echo "///";
  //  echo $NEWdiffcmr;
  //  echo "///";
  //  echo $OLDdiffcmr;
  //  echo "///";
 //if ($icdr==1 and $icmr==1){   
//if($NEWdiffcdr>$OLDdiffcdr and $NEWdiffcmr>$OLDdiffcmr){   
    
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
$sqlISELECT=("select cmr_pkid,cdr_duration, cmr_origvarVQMetrics,cmr_destvarVQMetrics,cmr_origdeviceName,cmr_destdeviceName from resultat where (Rcdr_ID > '$OLDdiffcdr' AND Rcmr_ID > '$OLDdiffcmr')");
 
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
                    if($devicesource=='SBC9C'){$Typeapp= "I";}
                    elseif($devicesource=='Trunk_EMEA_ARKADIN'){$Typeapp= "I";}
                    elseif($devicedest=='Trunk_EMEA_ARKADIN'){$Typeapp= "O";}
                    elseif($devicedest=='SBC9C'){$Typeapp= "O";}
                    else{$Typeapp= "L";}
                    
                    $PKID=$TableRST['cmr_pkid'];
                    $sqlIUPDATE = ("UPDATE resultat SET cmr_origvarVQMetrics= '$moysommescs1',cmr_destvarVQMetrics= '$moysommescs2',	Moyenne_SCS= '$MOYSCS', Classification='$Class',Type= '$Typeapp' WHERE cmr_pkid = '$PKID'");
                    $ResultUPDATE = $con->query($sqlIUPDATE);

                    
                    unset($moysommescs1);
                    unset($moysommescs2);
                    unset($MOYSCS);
                    unset($Class);
                    unset($Typeapp);
  
                    
                }

if(!isset($ResultUPDATE))
        {
          echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"tableresultat.php\"
              </script>";    
        }
        else {
            echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"tableresultat.php\"
          </script>";
        }
//} //if($NEWdiffcdr>$OLDdiffcdr and $NEWdiffcmr>$OLDdiffcmr)
//else{echo "pas de nvx lignes";}
//*****************************************************
//} //IF ($cntmtchcdr=1 and $cntmtchcmr=1)
//}IF EMPTY $DATA



?>
 
        


 

