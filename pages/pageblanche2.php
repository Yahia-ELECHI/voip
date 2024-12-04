<?php
try {
		
	    $con = new PDO("mysql:host=localhost;dbname=cdrcmr","test", "test", array(
        PDO::MYSQL_ATTR_LOCAL_INFILE => true,));
		
	}catch (Exception $e){
		die('Erreur : ' . $e->getMessage());
		
		//die('Erreur : impossible de se connecter à la base de donnée');
	}	
//
//$sql = ("INSERT INTO test (nom, prenom) VALUES ('John', 'Doe') where id_cdr= '$LASTID'");
//
// 
//$resultINSERT = $con->query($sql);
//



?>

<! DOCTYPE HTML>
<HTML>
    <head>
        <meta charset="utf-8">
        <title>Page blanche</title>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/monstyle.css">

    </head>
    <body>
    <?php
        $countmatchesscs1 = preg_match_all('/SCS\=(\d+)/i', "MLQK=0.0000;MLQKav=0.0000;MLQKmn=0.0000;MLQKmx=0.0000;ICR=0.0000;CCR=0.0000;ICRmx=0.0000;CS=0;SCS=0;MLQKvr=0.95", $matchesscs1);
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
        echo "////////sommescs1 :".$sommescs1;
        echo "////////divscs1 :".$divscs1;
        echo "////////moysommescs1 :".$moysommescs1;

        }
        
        
        //****************************************
             $countmatchesscs2 = preg_match_all('/SCS\=(\d+)/i',"", $matchesscs2);
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
        echo "////////sommescs2 :".$sommescs2;
        echo "////////divscs2 :".$divscs2;
        echo "////////moysommescs2 :".$moysommescs2;

        }
        
        
        if (!is_numeric($moysommescs1)){$MOYSCS= ($moysommescs2/2); echo "la moysommescs1 est vide et moysommescs2 = ".$moysommescs2;}
        elseif (!is_numeric($moysommescs2)){$MOYSCS= ($moysommescs1/2); echo "la moysommescs2 est vide et moysommescs1 = ".$moysommescs1;}
        else{$MOYSCS= ((($moysommescs1 + $moysommescs2)/2)/2); echo "ne sont pas vide = ";}
        
        echo"moyscs est : ".$MOYSCS
        ?>
    </body>

</HTML>