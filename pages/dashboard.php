<?php
	require_once('session.php');
?>
<?php		
	try {
		
	    $con = new PDO("mysql:host=localhost;dbname=cdrcmr","test", "test", array(
        PDO::MYSQL_ATTR_LOCAL_INFILE => true,));
		
	}catch (Exception $e){
		die('Erreur : ' . $e->getMessage());
		
		//die('Erreur : impossible de se connecter à la base de donnée');
	}

set_time_limit(0);
//$Datedebut=date("Y-n-j", strtotime("first day of previous month"));
//$DateFin=date("Y-n-j", strtotime("last day of previous month"));

$Datedebut="2019-12-01 00:00";
$DateFin="2019-12-31 23:55";


if(isset($_GET['filter'])){
    $Datedebut=$_GET['Datedebut'];
    $DateFin=$_GET['DateFin'];
}
//if(empty(($Datedebut)and($DateFin))){$Datedebut=date("Y-n-j", strtotime("first day of previous month"));
//                                     $DateFin=date("Y-n-j", strtotime("last day of previous month"));}

//***************Qualité des appels******************************************************
$sqlSGOOD=("SELECT COUNT(`Classification`) FROM `resultat` WHERE Classification = \"GOOD\" AND cdr_dateTimeOrigination BETWEEN '$Datedebut' AND '$DateFin'");
$sqlSACC=("SELECT COUNT(`Classification`) FROM `resultat` WHERE Classification = \"ACCEPTABLE\" AND cdr_dateTimeOrigination BETWEEN '$Datedebut' AND '$DateFin'");
$sqlSPOOR=("SELECT COUNT(`Classification`) FROM `resultat` WHERE Classification = \"POOR\" AND cdr_dateTimeOrigination BETWEEN '$Datedebut' AND '$DateFin'");
$sqlSTotQ=("SELECT COUNT(`Classification`) FROM `resultat`");
//*******
$resultSGOOD = $con->query($sqlSGOOD);
$resultSACC = $con->query($sqlSACC);
$resultSPOOR = $con->query($sqlSPOOR);
$resultSTotQ = $con->query($sqlSTotQ);

while($ROWG=$resultSGOOD->fetch()){$dataG=$ROWG['COUNT(`Classification`)'];}
while($ROWA=$resultSACC->fetch()){$dataA=$ROWA['COUNT(`Classification`)'];}
while($ROWP=$resultSPOOR->fetch()){$dataP=$ROWP['COUNT(`Classification`)'];}
while($ROWQ=$resultSTotQ->fetch()){$dataTQ=$ROWQ['COUNT(`Classification`)'];}

//****************************************************************************************

//***************Type des appels******************************************************
$sqlO=("SELECT COUNT(`Type`) FROM `resultat` WHERE Type = \"O\" AND cdr_dateTimeOrigination BETWEEN '$Datedebut' AND '$DateFin'");
$sqlI=("SELECT COUNT(`Type`) FROM `resultat` WHERE Type = \"I\" AND cdr_dateTimeOrigination BETWEEN '$Datedebut' AND '$DateFin'");
$sqlL=("SELECT COUNT(`Type`) FROM `resultat` WHERE Type = \"L\" AND cdr_dateTimeOrigination BETWEEN '$Datedebut' AND '$DateFin'");
$sqlSTotT=("SELECT COUNT(`Type`) FROM `resultat`");
//*******
$resultSO = $con->query($sqlO);
$resultSI = $con->query($sqlI);
$resultSL = $con->query($sqlL);
$resultSTotT = $con->query($sqlSTotT);

while($ROWO=$resultSO->fetch()){$dataO=$ROWO['COUNT(`Type`)'];}
while($ROWI=$resultSI->fetch()){$dataI=$ROWI['COUNT(`Type`)'];}
while($ROWL=$resultSL->fetch()){$dataL=$ROWL['COUNT(`Type`)'];}
while($ROWT=$resultSTotT->fetch()){$dataTT=$ROWT['COUNT(`Type`)'];}

//****************************************************************************************
//****************************Top 10 site / poor Sortant******************************************
$sqltoppoorS=("SELECT `SiteSource`, COUNT(`Classification`) FROM `resultat` WHERE (`Type`= \"O\" AND `Classification` = \"POOR\") AND cdr_dateTimeOrigination BETWEEN '$Datedebut' AND '$DateFin' GROUP BY `SiteSource` ORDER BY COUNT(`Classification`) DESC LIMIT 10");
$resulttoppoorS = $con->query($sqltoppoorS);
while($ROWresulttoppoorS=$resulttoppoorS->fetch())
{$tabresulttoppoorname[]=$ROWresulttoppoorS['SiteSource'];
$tabresulttoppoorcount[]=$ROWresulttoppoorS['COUNT(`Classification`)'];}


//****************************************************************************************
//****************************Top 10 site / poor Entrant******************************************
$sqltoppoorE=("SELECT `SiteDestination`, COUNT(`Classification`) FROM `resultat` WHERE (`Type`= \"I\" AND `Classification` = \"POOR\") AND cdr_dateTimeOrigination BETWEEN '$Datedebut' AND '$DateFin' GROUP BY `SiteDestination` ORDER BY COUNT(`Classification`) DESC LIMIT 10");
$resulttoppoorE = $con->query($sqltoppoorE);
while($ROWresulttoppoorE=$resulttoppoorE->fetch())
{$tabresulttoppoornameE[]=$ROWresulttoppoorE['SiteDestination'];
$tabresulttoppoorcountE[]=$ROWresulttoppoorE['COUNT(`Classification`)'];}
//************************************************************************************************
$sitenametoppoorS=isset($_GET['SiteNameS'])?$_GET['SiteNameS']:$tabresulttoppoorname[0];
$sitenametoppoorE=isset($_GET['SiteNameE'])?$_GET['SiteNameE']:$tabresulttoppoornameE[0];
//****************************Top  site / poor Entrant******************************************
//$sitenametoppoorS=$tabresulttoppoorname[0];
$sqlStoppoorS=("SELECT Classification, COUNT(`Classification`) FROM `resultat` WHERE SiteSource = '$sitenametoppoorS' AND TYPE= \"O\" AND cdr_dateTimeOrigination BETWEEN '$Datedebut' AND '$DateFin' GROUP BY Classification");
$resultStoppoorS = $con->query($sqlStoppoorS);
while($ROWresultStoppoorS=$resultStoppoorS->fetch())
{$tabresultStoppoorS[]=$ROWresultStoppoorS['Classification'];
$tabresultStoppoorcountS[]=$ROWresultStoppoorS['COUNT(`Classification`)'];}
//************************************************************************************************
//****************************Top  site / poor Sortant******************************************
//$sitenametoppoorE=$tabresulttoppoornameE[0];
$sqlStoppoorE=("SELECT Classification, COUNT(`Classification`) FROM `resultat` WHERE SiteDestination = '$sitenametoppoorE' AND TYPE= \"I\" AND cdr_dateTimeOrigination BETWEEN '$Datedebut' AND '$DateFin' GROUP BY Classification");
$resultStoppoorE = $con->query($sqlStoppoorE);
while($ROWresultStoppoorE=$resultStoppoorE->fetch())
{$tabresultStoppoorE[]=$ROWresultStoppoorE['Classification'];
$tabresultStoppoorcountE[]=$ROWresultStoppoorE['COUNT(`Classification`)'];}
//*************************************************************************************
$sqllistsitename=("SELECT name FROM `devicemobility` where name LIKE \"DMI_%\"");
$rstlistsitename = $con->query($sqllistsitename);
$rstlistsitenameE = $con->query($sqllistsitename);
//***********


?>


<! DOCTYPE HTML>
<HTML>
    <head>
        <meta charset="utf-8">
        <title>Dashboard</title>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
        <link rel="stylesheet" href="../bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.css" />
        <script src="../Chart/dist/Chart.min.js"></script>
        <script src="../css/chartjs-plugin-datalabels.min.js"></script>
        <script src="../canvas-gauges-master/gauge.min.js"></script>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript" src="../bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js"></script>
    <title>Dashboard</title>
    </head>
    <body>
       <?php include ("menu.php"); ?>
       <div class="container">
           <div class="panel panel-primary espace60">
               <div class="panel-heading  panel-relative">
                  <div class="row container ">
                      <div class="col-sm-3 panel-relative pull-left margin-right margin-left">
                    <h1 style="font-family:Times New Roman, Times, serif; font-size: 50px;font-weight: bold;color: #fff;" align="center">DASHBORD</h1>
                      </div>
                   <div class="col-sm-3 panel-relative pull-right margin-right margin-left">
                        <form method="GET" action="dashboard.php">
                            
                            
                            <div class='input-group date'  id='datedebut'>
                                <input type='text' class="form-control" placeholder="Date Début"  name="Datedebut" value="<?php echo $Datedebut ?>">
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                        <script type="text/javascript">
                                            $(function () {
                                            $('#datedebut').datetimepicker();
                                            });
                                        </script>
                            </div>
                            <div class='input-group date'  id='datefin'>
                                <input type='text' class="form-control" placeholder="Date Fin" name="DateFin" value="<?php echo $DateFin ?>">
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                        <script type="text/javascript">
                                            $(function () {
                                            $('#datefin').datetimepicker();
                                            });
                                        </script>
                                
                            </div>
                                <input type="submit" name="filter" class="btn btn-success pull-right">
                           
                            
                        
                            
                       </form>
                    </div>
                      <div class="col-sm-2 panel-relative pull-right" align="right"><div style="font-family:Times New Roman, Times, serif; font-size: 15px;font-weight: bold;color: #fff;">Date Début :</div><div>-----------------</div><div style="font-family:Times New Roman, Times, serif; font-size: 15px;font-weight: bold;color: #fff;">Date Fin :</div></div>

                      
                     <!-- <div class="col-sm-3 panel-relative pull-right margin-right">
                        <div class="form-group">Date Début
                            
                        </div>
                    </div>-->
            
                      
                   </div>
               </div>
               <div class="row container ">
                 <div class="panel-body">
                   <div class="col-sm-4 well well-sm">
                   <h1 style="font-family:Times New Roman, Times, serif; font-size: 20px;font-weight: bold;color: #000;" align="center">Appels de Type 'POOR'</h1>
                        <canvas id="gauge-ps"></canvas>
                       
                       <script>
var gaugePS = new RadialGauge({
    renderTo: 'gauge-ps',
    title: 'Pourcentage des appels',
    width: 350,
    height: 200,
    units: 'POOR %',
    minValue: 0,
    maxValue: 100,
    majorTicks: [
        '0',
        '10',
        '20',
        '30',
        '40',
        '50',
        '60',
        '70',
        '80',
        '90',
        '100'
    ],
    minorTicks: 2,
    ticksAngle: 270,
    startAngle: 45,
    strokeTicks: true,
    highlights  : [
        { from : 0,  to : 10, color : '#01B300' },
        { from : 10, to : 100, color : '#FC2024' }
    ],
    
    valueInt: 1,
    valueDec: 0,
    colorPlate: "#000",
    colorMajorTicks: "#000",
    colorMinorTicks: "#000",
    colorTitle: "#fff",
    colorUnits: "#fff",
    colorNumbers: "#fff",
    valueBox: true,
    colorValueText: "#000",
    colorValueBoxRect: "#fff",
    colorValueBoxRectEnd: "#fff",
    colorValueBoxBackground: "#FFCCCC",
    colorValueBoxShadow: false,
    colorValueTextShadow: false,
    colorNeedleShadowUp: true,
    colorNeedleShadowDown: false,
    colorNeedle: "rgba(200, 50, 50, .75)",
    colorNeedleEnd: "rgba(200, 50, 50, .75)",
    colorNeedleCircleOuter: "rgba(200, 200, 200, 1)",
    colorNeedleCircleOuterEnd: "rgba(200, 200, 200, 1)",
    borderShadowWidth: 0,
    borders: true,
    borderInnerWidth: 0,
    borderMiddleWidth: 0,
    borderOuterWidth: 5,
    colorBorderOuter: "#fafafa",
    colorBorderOuterEnd: "#cdcdcd",
    needleType: "arrow",
    needleWidth: 2,
    needleCircleSize: 7,
    needleCircleOuter: true,
    needleCircleInner: false,
    animationDuration: 1500,
    animationRule: "dequint",
    fontNumbers: "Verdana",
    fontTitle: "Verdana",
    fontUnits: "Verdana",
    fontValue: "Impact",
    fontValueStyle: '',
    fontNumbersSize: 20,
    fontNumbersStyle: 'italic',
    fontNumbersWeight: 'bold',
    fontTitleSize: 24,
    fontUnitsSize: 22,
    fontValueSize: 40,
    animatedValue: true
});
gaugePS.draw();
gaugePS.value = Math.round((<?php echo json_encode($dataP); ?>/<?php echo json_encode($dataTQ); ?>)*100)
</script>
                       
                       
</div>
                     
<div class="col-sm-4 well well-sm">
 <h1 style="font-family:Times New Roman, Times, serif; font-size: 20px;font-weight: bold;color: #000;" align="center">Appels de Type 'ACCEPTABLE'</h1>                  
<canvas id="gauge-psA"></canvas>
                       
<script>
var gaugePS = new RadialGauge({
    renderTo: 'gauge-psA',
    title: 'Pourcentage des appels',
    width: 350,
    height: 200,
    units: 'ACCEPTABLE %',
    minValue: 0,
    maxValue: 100,
    majorTicks: [
        '0',
        '10',
        '20',
        '30',
        '40',
        '50',
        '60',
        '70',
        '80',
        '90',
        '100'
    ],
    minorTicks: 2,
    ticksAngle: 270,
    startAngle: 45,
    strokeTicks: true,
    highlights  : [
        
        { from : 0, to : 100, color : '#1291FF' }
    ],
    valueInt: 1,
    valueDec: 0,
    colorPlate: "#000",
    colorMajorTicks: "#000",
    colorMinorTicks: "#000",
    colorTitle: "#fff",
    colorUnits: "#fff",
    colorNumbers: "#fff",
    valueBox: true,
    colorValueText: "#000",
    colorValueBoxRect: "#fff",
    colorValueBoxRectEnd: "#fff",
    colorValueBoxBackground: "#A9C5DE",
    colorValueBoxShadow: false,
    colorValueTextShadow: false,
    colorNeedleShadowUp: true,
    colorNeedleShadowDown: false,
    colorNeedle: "rgba(200, 50, 50, .75)",
    colorNeedleEnd: "rgba(200, 50, 50, .75)",
    colorNeedleCircleOuter: "rgba(200, 200, 200, 1)",
    colorNeedleCircleOuterEnd: "rgba(200, 200, 200, 1)",
    borderShadowWidth: 0,
    borders: true,
    borderInnerWidth: 0,
    borderMiddleWidth: 0,
    borderOuterWidth: 5,
    colorBorderOuter: "#fafafa",
    colorBorderOuterEnd: "#cdcdcd",
    needleType: "arrow",
    needleWidth: 2,
    needleCircleSize: 7,
    needleCircleOuter: true,
    needleCircleInner: false,
    animationDuration: 1500,
    animationRule: "dequint",
    fontNumbers: "Verdana",
    fontTitle: "Verdana",
    fontUnits: "Verdana",
    fontValue: "Impact",
    fontValueStyle: '',
    fontNumbersSize: 20,
    fontNumbersStyle: 'italic',
    fontNumbersWeight: 'bold',
    fontTitleSize: 24,
    fontUnitsSize: 22,
    fontValueSize: 40,
    animatedValue: true
});
gaugePS.draw();
gaugePS.value = Math.round((<?php echo json_encode($dataA); ?>/<?php echo json_encode($dataTQ); ?>)*100)
</script>
                       
                       
</div>

<div class="col-sm-4 well well-sm">
 <h1 style="font-family:Times New Roman, Times, serif; font-size: 20px;font-weight: bold;color: #000;" align="center">Appels de Type 'GOOD'</h1>                  
<canvas id="gauge-psG"></canvas>
                       
<script>
var gaugePS = new RadialGauge({
    renderTo: 'gauge-psG',
    title: 'Pourcentage des appels',
    width: 350,
    height: 200,
    units: 'GOOD %',
    minValue: 0,
    maxValue: 100,
    majorTicks: [
        '0',
        '10',
        '20',
        '30',
        '40',
        '50',
        '60',
        '70',
        '80',
        '90',
        '100'
    ],
    minorTicks: 2,
    ticksAngle: 270,
    startAngle: 45,
    strokeTicks: true,
    highlights  : [
        
        { from : 0, to : 100, color : '#01B300' }
    ],
    valueInt: 1,
    valueDec: 0,
    colorPlate: "#000",
    colorMajorTicks: "#000",
    colorMinorTicks: "#000",
    colorTitle: "#fff",
    colorUnits: "#fff",
    colorNumbers: "#fff",
    valueBox: true,
    colorValueText: "#000",
    colorValueBoxRect: "#fff",
    colorValueBoxRectEnd: "#fff",
    colorValueBoxBackground: "#D7FFBF",
    colorValueBoxShadow: false,
    colorValueTextShadow: false,
    colorNeedleShadowUp: true,
    colorNeedleShadowDown: false,
    colorNeedle: "rgba(200, 50, 50, .75)",
    colorNeedleEnd: "rgba(200, 50, 50, .75)",
    colorNeedleCircleOuter: "rgba(200, 200, 200, 1)",
    colorNeedleCircleOuterEnd: "rgba(200, 200, 200, 1)",
    borderShadowWidth: 0,
    borders: true,
    borderInnerWidth: 0,
    borderMiddleWidth: 0,
    borderOuterWidth: 5,
    colorBorderOuter: "#fafafa",
    colorBorderOuterEnd: "#cdcdcd",
    needleType: "arrow",
    needleWidth: 2,
    needleCircleSize: 7,
    needleCircleOuter: true,
    needleCircleInner: false,
    animationDuration: 1500,
    animationRule: "dequint",
    fontNumbers: "Verdana",
    fontTitle: "Verdana",
    fontUnits: "Verdana",
    fontValue: "Impact",
    fontValueStyle: '',
    fontNumbersSize: 20,
    fontNumbersStyle: 'italic',
    fontNumbersWeight: 'bold',
    fontTitleSize: 24,
    fontUnitsSize: 22,
    fontValueSize: 40,
    animatedValue: true
});
gaugePS.draw();
gaugePS.value = Math.round((<?php echo json_encode($dataG); ?>/<?php echo json_encode($dataTQ); ?>)*100)
</script>
                       
                       
</div>
                     
                     
</div>
                    
               <div class="panel-body">
                   <div class="col-sm-6 well well-sm">
                   
                        <canvas id="myChart"></canvas>
                    
                   </div>
            <script>
                let myChart = document.getElementById('myChart').getContext('2d');

                // Global Options
                Chart.defaults.global.defaultFontFamily = 'Lato';
                Chart.defaults.global.defaultFontSize = 12;
                Chart.defaults.global.defaultFontColor = '#000';

                let massPopChart = new Chart(myChart, {
                  type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                  data:{
                    labels:['GOOD', 'ACCEPTABLE', 'POOR'],
                     datasets:[{
                     label:'Appels',
                     data:[
                       <?php echo $dataG; ?>,
                       <?php echo $dataA; ?>,
                       <?php echo $dataP; ?>
                                 ],
                     //backgroundColor:'green',
                     backgroundColor:[
                       '#01B300',
                       '#20A1FC',
                       '#FC2024'
                     ],
                     borderWidth:1,
                     borderColor:'#000',
                     hoverBorderWidth:3,
                     hoverBorderColor:'#000'
                   }]
                  },
                  options:{
                    title:{
                      display:true,
                      text:'Classification des appels / Qualité',
                      fontSize:20
                    },
                      //*****************
                        plugins: {
                          datalabels: {
                              color: '#fff',
                              anchor: 'end',
                              align: 'start',
                              offset: -10,
                              borderWidth: 2,
                              borderColor: '#fff',
                              borderRadius: 25,
                              backgroundColor: (context)=>{
                                return context.dataset.backgroundColor;
                              },
                             font: {
                                 weight: 'bold',
                                 size: '10'
                             },
                              formatter: function(value, context) {
                                    return value + ': ' + Math.round((value/<?php echo json_encode($dataTQ); ?>)*100) + '%';
                                }
                          }
                      },
                      //*****************
                    legend:{
                      display:false,
                      position:'right',
                      labels:{
                        fontColor:'#000'
                      }
                    },
                    layout:{
                      padding:{
                        left:50,
                        right:0,
                        bottom:0,
                        top:0
                      }
                    },
                    tooltips:{
                      enabled:true
                    },
                      chartArea: {
                    backgroundColor: 'rgba(#000)'
                },
                        gridLines:{
                      color: "#fff",
                      lineWidth:2
                    }
                  }
                });
              </script>
                      
                      
                   
                    <div class="col-sm-6 well well-sm">
                        <canvas id="myChart2"></canvas>
                   </div>

                   
                   <script>
                let myChart2 = document.getElementById('myChart2').getContext('2d');

                // Global Options
                Chart.defaults.global.defaultFontFamily = 'Lato';
                Chart.defaults.global.defaultFontSize = 12;
                Chart.defaults.global.defaultFontColor = '#000';

                let massPopChart2 = new Chart(myChart2, {
                  type:'pie', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                  data:{
                labels:['SORTANT', 'ENTRANT', 'LOCAL'],
                     datasets:[{
                     label:'Appels',
                     data:[
                       <?php echo $dataO; ?>,
                       <?php echo $dataI; ?>,
                       <?php echo $dataL; ?>
                                 ],
                     //backgroundColor:'green',
                     backgroundColor:[
                       '#FFA833',
                       '#33B7FF',
                       '#5A6D78'
                     ],
                     borderWidth:1,
                     borderColor:'#000',
                     hoverBorderWidth:3,
                     hoverBorderColor:'#000'
                   }]
                  },
                  options:{
                    title:{
                      display:true,
                      text:'Classification des appels / Type',
                      fontSize:20
                    },
                    //*************
                      plugins: {
                          datalabels: {
                              color: '#fff',
                              anchor: 'end',
                              align: 'start',
                              offset: -10,
                              borderWidth: 2,
                              borderColor: '#fff',
                              borderRadius: 25,
                              backgroundColor: (context)=>{
                                return context.dataset.backgroundColor;
                              },
                             font: {
                                 weight: 'bold',
                                 size: '10'
                             },
                              formatter: function(value, context) {
                                    return value + ': ' + Math.round((value/<?php echo json_encode($dataTT); ?>)*100) + '%';
                                }
                          }
                      },
 
                    
                    //*************
                    legend:{
                      display:true,
                      position:'bottom',
                      labels:{
                        fontColor:'#000'
                      }
                    },
                    layout:{
                      padding:{
                        left:50,
                        right:0,
                        bottom:0,
                        top:0
                      }
                    },
                    tooltips:{
                      enabled:true
                    },
                      chartArea: {
                    backgroundColor: 'rgba(#000)'
                },
                        gridLines:{
                      color: "#fff",
                      lineWidth:2
                    }
                  }
                });
              </script>
               </div>
               </div>
           </div>

<!--*********************************************************************************************************************************-->
           <div class="panel panel-primary">
               <div class="panel-heading text-center panel-relative" style="font-family:Times New Roman, Times, serif; font-size: 30px;font-weight: bold;color: #fff;">Vue Détaillée</div>
               <div class="panel-body">
                   <div class="col-sm-6 well well-sm">
                   <canvas id="myChart3"></canvas>
                   </div>
                    
                   <div class="col-sm-6 well well-sm">
                   <canvas id="myChart4"></canvas>
                   </div>
               </div>
               
               <div class="panel-body ">
                   <div class="col-sm-6 well well-sm">
                <form method="get">
                
                    <select name="SiteNameS" id="SiteNameS" class="form-control"
									onChange="this.form.submit();">
								<option value="DefaultSiteS" "selected"><?php echo $sitenametoppoorS ?></option>
							        <?php
                                    while($ListsiteNameS=$rstlistsitename->fetch()){
                                            
                                    ?>
                                <option value= "<?php echo $ListsiteNameS['name']; ?>" "selected" ><?php echo $ListsiteNameS['name']; ?></option> <?php }?>
				    </select>
                   <canvas id="myChart5"></canvas>
                
                </form>
                </div>
                   <div class="col-sm-6 well well-sm">
                <form method="get">
                
                    <select name="SiteNameE" id="SiteNameE" class="form-control"
                        onChange="this.form.submit();">
                                <option value="DefaultSiteE" "selected"><?php echo $sitenametoppoorE ?></option>
                        <?php
                        while($ListsiteNameE=$rstlistsitenameE->fetch()){

                        ?>
                                <option value= "<?php echo $ListsiteNameE['name']; ?>" "selected" ><?php echo $ListsiteNameE['name']; ?></option> <?php }?>
				    </select>
                   <canvas id="myChart6"></canvas>
                
                </form>
                       </div>
               </div>
               
               <script>
                let myChart3 = document.getElementById('myChart3').getContext('2d');

                // Global Options
                Chart.defaults.global.defaultFontFamily = 'Lato';
                Chart.defaults.global.defaultFontSize = 12;
                Chart.defaults.global.defaultFontColor = '#000';

                let massPopChart3 = new Chart(myChart3, {
                  type:'horizontalBar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                  data:{
                    labels:<?php echo json_encode($tabresulttoppoorname) ?>,
                     datasets:[{
                     label:'Appels',
                     data:<?php echo json_encode($tabresulttoppoorcount) ?>,
                     //backgroundColor:'green',
                     backgroundColor:[
                       '#FC2024',
                       '#FC2024',
                       '#FC2024',
                       '#FC2024',
                       '#FC2024',
                       '#FC2024',
                       '#FC2024',
                       '#FC2024',
                       '#FC2024',
                       '#FC2024'
                     ],
                     borderWidth:1,
                     borderColor:'#000',
                     hoverBorderWidth:3,
                     hoverBorderColor:'#000'
                   }]
                  },
                  options:{
                    title:{
                      display:true,
                      text:'Top 10 Sites / Appels Sortant \'POOR\'',
                      fontSize:20
                    },
                    
                      //*****************
                        plugins: {
                          datalabels: {
                              color: '#fff',
                              anchor: 'end',
                              align: 'start',
                              offset: -10,
                              borderWidth: 2,
                              borderColor: '#fff',
                              borderRadius: 25,
                              backgroundColor: (context)=>{
                                return context.dataset.backgroundColor;
                              },
                             font: {
                                 weight: 'bold',
                                 size: '10'
                             },
                              
                          }
                      },
                      //*****************
                                           
                            
                    legend:{
                      display:false,
                      position:'right',
                      labels:{
                        fontColor:'#000'
                      }
                    },
                    layout:{
                      padding:{
                        left:50,
                        right:0,
                        bottom:0,
                        top:0
                      }
                    },
                    tooltips:{
                      enabled:true
                    },
                      chartArea: {
                    backgroundColor: 'rgba(#000)'
                },
                        gridLines:{
                      color: "#fff",
                      lineWidth:2
                    }
                  }
                });
              </script>
               
                    


               
               <script>
                let myChart4 = document.getElementById('myChart4').getContext('2d');

                // Global Options
                Chart.defaults.global.defaultFontFamily = 'Lato';
                Chart.defaults.global.defaultFontSize = 12;
                Chart.defaults.global.defaultFontColor = '#000';

                let massPopChart4 = new Chart(myChart4, {
                  type:'horizontalBar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                  data:{
                    labels:<?php echo json_encode($tabresulttoppoornameE) ?>,
                     datasets:[{
                     label:'Appels',
                     data:<?php echo json_encode($tabresulttoppoorcountE) ?>,
                     //backgroundColor:'green',
                     backgroundColor:[
                       '#FC2024',
                       '#FC2024',
                       '#FC2024',
                       '#FC2024',
                       '#FC2024',
                       '#FC2024',
                       '#FC2024',
                       '#FC2024',
                       '#FC2024',
                       '#FC2024'
                     ],
                     borderWidth:1,
                     borderColor:'#000',
                     hoverBorderWidth:3,
                     hoverBorderColor:'#000'
                   }]
                  },
                  options:{
                    title:{
                      display:true,
                      text:'Top 10 Sites / Appels Entrant \'POOR\'',
                      fontSize:20
                    },
                    
                      //*****************
                        plugins: {
                          datalabels: {
                              color: '#fff',
                              anchor: 'end',
                              align: 'start',
                              offset: -10,
                              borderWidth: 2,
                              borderColor: '#fff',
                              borderRadius: 25,
                              backgroundColor: (context)=>{
                                return context.dataset.backgroundColor;
                              },
                             font: {
                                 weight: 'bold',
                                 size: '10'
                             },
                              
                          }
                      },
                      //*****************
                                           
                            
                    legend:{
                      display:false,
                      position:'right',
                      labels:{
                        fontColor:'#000'
                      }
                    },
                    layout:{
                      padding:{
                        left:50,
                        right:0,
                        bottom:0,
                        top:0
                      }
                    },
                    tooltips:{
                      enabled:true
                    },
                      chartArea: {
                    backgroundColor: 'rgba(#000)'
                },
                        gridLines:{
                      color: "#fff",
                      lineWidth:2
                    }
                  }
                });
              </script>
               
               <script>
                let myChart5 = document.getElementById('myChart5').getContext('2d');

                // Global Options
                Chart.defaults.global.defaultFontFamily = 'Lato';
                Chart.defaults.global.defaultFontSize = 12;
                Chart.defaults.global.defaultFontColor = '#000';

                let massPopChart5 = new Chart(myChart5, {
                  type:'radar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                  data:{
                    labels:<?php echo json_encode($tabresultStoppoorS) ?>,
                     datasets:[{
                     label:'Appels',
                     data:<?php echo json_encode($tabresultStoppoorcountS) ?>,
                     //backgroundColor:'green',
                     backgroundColor:[
                      '#20A1FC',  
                      '#01B300',
                      '#FC2024',

                     ],
                     borderWidth:1,
                     borderColor:'#000',
                     hoverBorderWidth:3,
                     hoverBorderColor:'#000'
                   }]
                  },
                  options:{
                    title:{
                      display:true,
                      text:'Détailles Du Site <?php echo json_encode($sitenametoppoorS) ?> / Appels Sortant',
                      fontSize:20
                    },
                    
                      //*****************
                        plugins: {
                          datalabels: {
                              color: '#fff',
                              anchor: 'end',
                              align: 'start',
                              offset: -10,
                              borderWidth: 2,
                              borderColor: '#fff',
                              borderRadius: 25,
                              backgroundColor: (context)=>{
                                return context.dataset.backgroundColor;
                              },
                             font: {
                                 weight: 'bold',
                                 size: '10'
                             },
                              
                          }
                      },
                      //*****************
                                           
                            
                    legend:{
                      display:false,
                      position:'right',
                      labels:{
                        fontColor:'#000'
                      }
                    },
                    layout:{
                      padding:{
                        left:50,
                        right:0,
                        bottom:0,
                        top:0
                      }
                    },
                    tooltips:{
                      enabled:true
                    },
                      chartArea: {
                    backgroundColor: 'rgba(#000)'
                },
                        gridLines:{
                      color: "#fff",
                      lineWidth:2
                    }
                  }
                });
              </script>
               
               
            <script>
                let myChart6 = document.getElementById('myChart6').getContext('2d');

                // Global Options
                Chart.defaults.global.defaultFontFamily = 'Lato';
                Chart.defaults.global.defaultFontSize = 12;
                Chart.defaults.global.defaultFontColor = '#000';

                let massPopChart6 = new Chart(myChart6, {
                  type:'radar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                  data:{
                    labels:<?php echo json_encode($tabresultStoppoorE) ?>,
                     datasets:[{
                     label:'Appels',
                     data:<?php echo json_encode($tabresultStoppoorcountE) ?>,
                     //backgroundColor:'green',
                     backgroundColor:[
                      '#20A1FC',  
                      '#01B300',
                      '#FC2024',

                     ],
                     borderWidth:1,
                     borderColor:'#000',
                     hoverBorderWidth:3,
                     hoverBorderColor:'#000'
                   }]
                  },
                  options:{
                    title:{
                      display:true,
                      text:'Détailles Du Site <?php echo json_encode($sitenametoppoorE) ?> / Appels Entrant',
                      fontSize:20
                    },
                    
                      //*****************
                        plugins: {
                          datalabels: {
                              color: '#fff',
                              anchor: 'end',
                              align: 'start',
                              offset: -10,
                              borderWidth: 2,
                              borderColor: '#fff',
                              borderRadius: 25,
                              backgroundColor: (context)=>{
                                return context.dataset.backgroundColor;
                              },
                             font: {
                                 weight: 'bold',
                                 size: '10'
                             },
                              
                          }
                      },
                      //*****************
                                           
                            
                    legend:{
                      display:false,
                      position:'right',
                      labels:{
                        fontColor:'#000'
                      }
                    },
                    layout:{
                      padding:{
                        left:50,
                        right:0,
                        bottom:0,
                        top:0
                      }
                    },
                    tooltips:{
                      enabled:true
                    },
                      chartArea: {
                    backgroundColor: 'rgba(#000)'
                },
                        gridLines:{
                      color: "#fff",
                      lineWidth:2
                    }
                  }
                });
              </script>
               
               
           </div>
        </div>
    </body>

</HTML>