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
    $requete="select cmr_globalCallID_callId,cmr_origdeviceName,cmr_destdeviceName,cmr_origvarVQMetrics,cmr_destvarVQMetrics,cmr_callingPartyNumber,cmr_finalCalledPartyNumber from cmr limit $size offset $offset";
    $requetecount="select count(*) countF from cmr";
}else{
    $requete="select cmr_globalCallID_callId,cmr_origdeviceName,cmr_destdeviceName,cmr_origvarVQMetrics,cmr_destvarVQMetrics,cmr_callingPartyNumber,cmr_finalCalledPartyNumber from cmr
            where cmr_globalCallID_callId LIKE '$recherche%' limit $size offset $offset";
    $requetecount="select count(*) countF from cmr where cmr_globalCallID_callId LIKE '$recherche%'";
    
}




 $resultatF=$con->query($requete);
 $resultatcount=$con->query($requetecount);
 $tabcount=$resultatcount->fetch();
 $nbrcmr=$tabcount['countF'];
 $reste=$nbrcmr%$size; //% operateur modulo :reste de la division


    if($reste==0)
        $nbrpage=$nbrcmr/$size;
    else
        $nbrpage=floor($nbrcmr/$size)+1;


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
                <div class="panel-heading">Rechercher les tickets CMR...
                    <form method="post" action="uploadcmr.php" name="upload_excel" enctype="multipart/form-data" class="form-inline pull-right">
                    <div class="form-group">
                      <?php if($_SESSION['utilisateur']['ROLE']=="ADMIN") {?>  
                    <button type="submit" id="submit" name="Import" class="btn btn-success pull-right button-loading" data-loading-text="Loading...">
                        <span class="glyphicon glyphicon-plus"></span>
                           &nbsp; Upload fichier CMR 
                    </button>
                        <?php } ?>
                        &nbsp;
                        &nbsp;
                    <!--<button type="file" name="file" id="file" class="btn btn-warning pull-right">
                        <span class="glyphicon glyphicon-plus"></span>
                           &nbsp; Selectionner un fichier CMR
                    </button>
                    -->
                        <?php if($_SESSION['utilisateur']['ROLE']=="ADMIN") {?>
                        <input type="file" name="file" id="file" class=" custom-file-input pull-right">
                        <?php } ?>
                      
                    </div>

                    </form>
                </div>
                    <div class="panel-body">
                    <form method="get" action="CMR.php" >
                        <div class="form-group">
                        <input type="text" name="filtre" placeholder="Inserer le globalCallID_callId" class="form-control" value="<?php echo $recherche ?>">
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
                <div class="panel-heading">Liste des tickets CMR (<?php echo $nbrcmr ?>  Tickets)</div>
                    <div class="panel-body">
                        
                    <table class="table table-striped table-bordered">
        
                        <thead>
                            <tr>
                                <th>globalCallID_callId</th>
                                <th>origdeviceName</th>
                                <th>destdeviceName</th>
                                <th>callingPartyNumber</th>
                                <th>finalCalledPartyNumber</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                <?php while($CMR=$resultatF->fetch()){?>
                                <tr>

                                    <td><?php echo $CMR['cmr_globalCallID_callId'] ?> </td>
                                    <td><?php echo $CMR['cmr_origdeviceName'] ?> </td>
                                    <td><?php echo $CMR['cmr_destdeviceName'] ?> </td>
                                    <td><?php echo $CMR['cmr_callingPartyNumber'] ?> </td>
                                    <td><?php echo $CMR['cmr_finalCalledPartyNumber'] ?> </td>
                                                                    
 
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