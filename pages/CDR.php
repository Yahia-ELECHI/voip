<?php
	require_once('session.php');
?>
<?php
 
require('connexion.php');

$size=isset($_GET['size'])?$_GET['size']:50;
$page=isset($_GET['page'])?$_GET['page']:1;
$offset=($page-1)*$size;
 
if (isset($_GET['filtre'])) {
    $recherche = $_GET['filtre'];
} else {
    $recherche = "";
}

if($recherche=="all" xor $recherche==""){
    $requete="select cdr_globalCallID_callId,cdr_dateTimeOrigination,cdr_callingPartyNumber,cdr_originalCalledPartyNumber,cdr_finalCalledPartyNumber,cdr_duration,cdr_origDeviceName,cdr_destDeviceName from cdr order by cdr_dateTimeOrigination DESC limit $size offset $offset";
    $requetecount="select count(*) countF from cdr";
}else{
    $requete="select cdr_globalCallID_callId,cdr_dateTimeOrigination,cdr_callingPartyNumber,cdr_originalCalledPartyNumber,cdr_finalCalledPartyNumber,cdr_duration,cdr_origDeviceName,cdr_destDeviceName from cdr
            where cdr_globalCallID_callId LIKE '$recherche%' order by cdr_dateTimeOrigination DESC limit $size offset $offset";
    $requetecount="select count(*) countF from cdr where cdr_globalCallID_callId LIKE '$recherche%'";
    
}




 $resultatF=$con->query($requete);
 $resultatcount=$con->query($requetecount);
 $tabcount=$resultatcount->fetch();
 $nbrcdr=$tabcount['countF'];
 $reste=$nbrcdr%$size; //% operateur modulo :reste de la division


    if($reste==0)
        $nbrpage=$nbrcdr/$size;
    else
        $nbrpage=floor($nbrcdr/$size)+1;


?>


<! DOCTYPE HTML>
<HTML>
    <head>
        <meta charset="utf-8">
        <title>UPLOAD DES TICKETS CDR</title>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
    
    </head>
    <body>
        <?php include ("menu.php");?>
        <div class="container">
            <div class="panel panel-primary espace60">
                <div class="panel-heading">Rechercher les tickets CDR...
                    <form method="post" action="upload.php" name="upload_excel" enctype="multipart/form-data" class="form-inline pull-right">
                    <div class="form-group">
                     <?php if($_SESSION['utilisateur']['ROLE']=="ADMIN") {?>   
                    <button type="submit" id="submit" name="Import" class="btn btn-success pull-right button-loading" data-loading-text="Loading...">
                        <span class="glyphicon glyphicon-plus"></span>
                           &nbsp; Upload fichier CDR 
                    </button>
                        <?php } ?>
                        &nbsp;
                        &nbsp;
                    <!--<button type="file" name="file" id="file" class="btn btn-warning pull-right">
                        <span class="glyphicon glyphicon-plus"></span>
                           &nbsp; Selectionner un fichier CDR
                    </button>
                    -->
                        <?php if($_SESSION['utilisateur']['ROLE']=="ADMIN") {?>
                        <input type="file" name="file" id="file" class=" custom-file-input pull-right">
                        <?php } ?>
                      
                    </div>

                    </form>
                </div>
                    <div class="panel-body">
                    <form method="get" action="CDR.php" >
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
                <div class="panel-heading">Liste des tickets CDR (<?php echo $nbrcdr ?>  Tickets)</div>
                    <div class="panel-body">
                        
                    <table class="table table-striped table-bordered">
        
                        <thead>
                            <tr>
                                <th>globalCallID_callId</th>
                                <th>dateTimeOrigination</th>
                                <th>callingPartyNumber</th>
                                <th>originalCalledPartyNumber</th>
                                <th>finalCalledPartyNumber</th>
                                <th>duration</th>
                                <th>origDeviceName</th>
                                <th>destDeviceName</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                <?php while($CDR=$resultatF->fetch()){?>
                                <tr>

                                    <td><?php echo $CDR['cdr_globalCallID_callId'] ?> </td>
                                    <td><?php echo $CDR['cdr_dateTimeOrigination'] ?> </td>
                                    <td><?php echo $CDR['cdr_callingPartyNumber'] ?> </td>
                                    <td><?php echo $CDR['cdr_originalCalledPartyNumber'] ?> </td>
                                    <td><?php echo $CDR['cdr_finalCalledPartyNumber'] ?> </td>
                                    <td><?php echo $CDR['cdr_duration'] ?> </td>
                                    <td><?php echo $CDR['cdr_origDeviceName'] ?> </td>
                                    <td><?php echo $CDR['cdr_destDeviceName'] ?> </td>
                                    
 
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
												<option <?php if($size==5)  echo "selected" ?>>50</option>
												<option <?php if($size==10) echo "selected" ?>>100</option>
												<option <?php if($size==15) echo "selected" ?>>150</option>
												<option <?php if($size==20) echo "selected" ?>>200</option>
												<option <?php if($size==25) echo "selected" ?>>250</option>
											</select>
										</form>
									</li>
                            </ul>

                                
                            
                        </div>
                    </div>
            </div>
        
    </body>

</HTML>