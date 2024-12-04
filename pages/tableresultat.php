<?php
	require_once('session.php');
?>
<?php
 
require('connexion.php');

$size=isset($_GET['size'])?$_GET['size']:50;
$page=isset($_GET['page'])?$_GET['page']:1;
$offset=($page-1)*$size;
 
if(isset($_GET['filtre']))
 $recherche=$_GET['filtre'];
else
    $recherche="";

if($recherche=="all" xor $recherche==""){
    
    $requete=" select * from resultat limit $size offset $offset";
    
    $requetecount="select count(*) countF from resultat";
    
}else{
    $requete="select * from resultat
            where cmr_finalCalledPartyNumber LIKE '$recherche%' order by cdr_dateTimeOrigination limit $size offset $offset";
    
    
    $requetecount="select count(*) countF from resultat where cmr_finalCalledPartyNumber LIKE '$recherche%'";
    
}




 $resultatF=$con->query($requete);
 $resultatcount=$con->query($requetecount);
 $tabcount=$resultatcount->fetch();
 $nbrrslt=$tabcount['countF'];
 $reste=$nbrrslt%$size; //% operateur modulo :reste de la division


    if($reste==0)
        $nbrpage=$nbrrslt/$size;
    else
        $nbrpage=floor($nbrrslt/$size)+1;

?>

<! DOCTYPE HTML>
<HTML>
    <head>
        <meta charset="utf-8">
        <title>UPLOAD DES TICKETS CMR</title>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
    
    </head>
    <body>
        <?php include ("menu.php");?>
        <div class="container">
            <div class="panel panel-primary espace60">
                <div class="panel-heading">Rechercher les tickets...
                    <form method="post" action="Recheck.php" name="upload_excel" enctype="multipart/form-data" class="form-inline pull-right">
                    <div class="form-group">
                        <?php if($_SESSION['utilisateur']['ROLE']=="ADMIN") {?>
                        <button type="submit" id="recheck" name="recheck" class="btn btn-info pull-right button-loading" data-loading-text="Loading...">
                        <span class="glyphicon glyphicon-plus"></span>
                           &nbsp; Revérification
                    </button>
                       <?php } ?> 
                        &nbsp;
                        &nbsp;
                    <!--<button type="file" name="file" id="file" class="btn btn-warning pull-right">
                        <span class="glyphicon glyphicon-plus"></span>
                           &nbsp; Selectionner un fichier CMR
                    </button>
                    -->
                 
                    </div>

                    </form>
                    <form method="post" action="autouploadcdr.php" name="upload_excel" enctype="multipart/form-data" class="form-inline pull-right">
                    <div class="form-group">
                       <?php if($_SESSION['utilisateur']['ROLE']=="ADMIN") {?> 
                    <button type="submit" id="submit" name="Import" class="btn btn-success pull-right button-loading" data-loading-text="Loading...">
                        <span class="glyphicon glyphicon-plus"></span>
                           &nbsp; Lancer le traitement
                    </button>
                        <?php } ?>
                        &nbsp;
                        &nbsp;
                    <!--<button type="file" name="file" id="file" class="btn btn-warning pull-right">
                        <span class="glyphicon glyphicon-plus"></span>
                           &nbsp; Selectionner un fichier CMR
                    </button>
                    -->
                 
                    </div>

                    </form>

                </div>
                    <div class="panel-body">
                    <form method="get" action="tableresultat.php" >
                        <div class="form-group">
                        <input type="text" name="filtre" placeholder="Inserer le 'FINAL CALLED NUMBER'" class="form-control" value="<?php echo $recherche ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-search"></span>
                           &nbsp; Chercher...
                        </button>
                    </form>
                    </div>
            </div>
          </div>  
            
            <div class="panel panel-primary">
                <div class="panel-heading">Liste des tickets (<?php echo $nbrrslt ?>  Appels)</div>
                    <div class="panel-body table-responsive">
                        
                    <table class="table table-striped table-bordered">
        
                        <thead>
                            <tr>
                                <th>CALL ID</th>
                                <th>DATE TIME</th>
                                <th>DURATION (sec)</th>
                                <th>CALLING NUMBER</th>
                                <th>FINAL CALLED NUMBER</th>
                                
<!--                                <th>SCS Tx</th>
                                <th>SCS Rx</th>-->
                                <th>CALLING DEVICE</th>
                                <th>CALLED DEVICE</th>
                                <th>Type</th>
<!--                                <th>Moy SCS</th>-->
                                <th>Class</th>
                                <th>Site Source</th>
                                <th>Site Destination</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                <?php while($RST=$resultatF->fetch()){?>
                                <tr>
                                    <td><?php echo $RST['cdr_globalCallID_callId'] ?> </td>
                                    <td><?php echo $RST['cdr_dateTimeOrigination'] ?> </td>
                                    <td><?php echo $RST['cdr_duration'] ?> </td>
                                    <td><?php echo $RST['cmr_callingPartyNumber'] ?> </td>
                                    <td><?php echo $RST['cmr_finalCalledPartyNumber'] ?> </td>
<!--                                    <td><?php echo $RST['cmr_origvarVQMetrics']?> </td>
                                    <td><?php echo $RST['cmr_destvarVQMetrics']?> </td>-->
                                    <td><?php echo $RST['cmr_origdeviceName'] ?> </td>
                                    <td><?php echo $RST['cmr_destdeviceName'] ?> </td>
                                    <td><?php echo $RST['Type']?></td>
<!--                                    <td><?php echo $RST['Moyenne_SCS'] ?> </td>-->
                                    <td><?php echo $RST['Classification']?></td>
                                    <td><?php echo $RST['SiteSource']?></td>
                                    <td><?php echo $RST['SiteDestination']?></td>
                                                                    
 
                                </tr>
                                <?php } ?>

                            
                        </tbody>
                    </table>
                        <div>
                             <ul class="nav nav-pills nav-right">
									<li>
                                        <form class="form-inline">
                                            <input type="hidden" name="page" 
												value="<?php echo $page ?>">
											<select name="size" class="form-control"
													onchange="this.form.submit()">
												<option <?php if($size==50)  echo "selected" ?>>50</option>
												<option <?php if($size==100) echo "selected" ?>>100</option>
												<option <?php if($size==150) echo "selected" ?>>150</option>
												<option <?php if($size==200) echo "selected" ?>>200</option>
												<option <?php if($size==250) echo "selected" ?>>250</option>
											</select>
										</form>
									</li>
                            </ul>

                                
                            
                        </div>
                    </div>
            </div>
        
    </body>

</HTML>