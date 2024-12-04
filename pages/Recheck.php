<?php
require('connexion.php');



    unset($sqlISELECTrecheck);
    unset($resultSELECTrecheck);
    unset($TableRST);



if(isset($_POST["recheck"])){

$sqlISELECTrecheck=("select cmr_pkid,cdr_duration, cmr_origvarVQMetrics,cmr_destvarVQMetrics,cmr_origdeviceName,cmr_destdeviceName,SiteSource,SiteDestination from resultat where (`Classification`IS NULL OR `Type` IS NULL)");

$resultSELECTrecheck = $con->query($sqlISELECTrecheck);


                while($TableRST=$resultSELECTrecheck->fetch()){
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
                    echo "///";
                    echo $moysommescs1;
                    echo "///";
                    echo $moysommescs2;
                    echo "///";
                    echo $MOYSCS;
                    echo "///";
                    echo $Class;
                    echo "///";
                    echo $Typeapp;
                    echo "///";
                    
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

if(!isset($ResultUPDATE))
        {
          echo "<script type=\"text/javascript\">
              alert(\"No new data added.\");
              window.location = \"tableresultat.php\"
              </script>";    
        }
        else {
            echo "<script type=\"text/javascript\">
            alert(\"Data has been successfully checked.\");
            window.location = \"tableresultat.php\"
          </script>";
        }
        
}
   else {"<script type=\"text/javascript\">
              alert(\"No new data added.\");
              window.location = \"tableresultat.php\"
              </script>";}
?>