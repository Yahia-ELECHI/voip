<?php
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
//var_dump($data);
//echo ($data[0]);
//print_r($data);
//print_r(array_count_values($data));

//$countdata=count($data);
//echo $countdata;
if(!empty($data)){
foreach($data as $val) {
  $countmatchescdr=preg_match_all('/(cdr)/i', $val, $matchecdr);
  $countmatchescmr=preg_match_all('/(cmr)/i', $val, $matchecmr);
    if($countmatchescdr>0){
    rename($Directory.$val , $ArcDirectory.$val);                                   
                          }
    elseif($countmatchescmr>0){
    rename($Directory.$val , $ArcDirectory.$val);
    }
  else {echo "il n y a pas de fichiers CDR CMR";}
    
     
                        }
    
}
    


//$i = 0;
//while($i<$nbr){
    //$nomparcouru=$data[$i];
    //loadinfile $nomparcouru;
       
 //       $i++;
//}



//$filename=$Directory.$data[1];
//echo $filename;

//$sql = ("LOAD DATA LOW_PRIORITY LOCAL INFILE '$filename'" . "INTO TABLE `CMR` FIELDS TERMINATED BY ',' LINES TERMINATED BY '\\n'");
    
    
    
?>