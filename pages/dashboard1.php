<?php		
	try {
		
	    $con = new PDO("mysql:host=localhost;dbname=cdrcmr","test", "test", array(
        PDO::MYSQL_ATTR_LOCAL_INFILE => true,));
		
	}catch (Exception $e){
		die('Erreur : ' . $e->getMessage());
		
		//die('Erreur : impossible de se connecter à la base de donnée');
	}	

$sqlSGOOD=("SELECT COUNT(`Classification`) FROM `resultat` WHERE Classification = \"GOOD\"");
$sqlSACC=("SELECT COUNT(`Classification`) FROM `resultat` WHERE Classification = \"ACCEPTABLE\"");
$sqlSPOOR=("SELECT COUNT(`Classification`) FROM `resultat` WHERE Classification = \"POOR\"");
//*******
$resultSGOOD = $con->query($sqlSGOOD);
$resultSACC = $con->query($sqlSACC);
$resultSPOOR = $con->query($sqlSPOOR);

while($ROWG=$resultSGOOD->fetch()){$dataG=$ROWG['COUNT(`Classification`)'];}
while($ROWA=$resultSACC->fetch()){$dataA=$ROWA['COUNT(`Classification`)'];}
while($ROWP=$resultSPOOR->fetch()){$dataP=$ROWP['COUNT(`Classification`)'];}
echo $dataG;
echo $dataA;
echo $dataP;


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="../Chart/dist/Chart.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
  <title>My Chart.js Chart</title>
</head>
<body>
  <div class="container">
    <canvas id="myChart"></canvas>
  </div>

  <script>
    let myChart = document.getElementById('myChart').getContext('2d');

    // Global Options
    Chart.defaults.global.defaultFontFamily = 'Lato';
    Chart.defaults.global.defaultFontSize = 18;
    Chart.defaults.global.defaultFontColor = '#000';

    let massPopChart = new Chart(myChart, {
      type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
      data:{
        labels:['GOOD', 'ACCEPTABLE', 'POOR'],
          
//           datasets: 
//           [{
//           label: 'GOOD,ACCEPTABLE',
//           data: [<?php echo $dataG; ?>],
//           backgroundColor: '#80FC20',
//           borderColor:'#777',
//           hoverBorderWidth:3,
//           order:1,
//           borderWidth: 3
//           },

//           {
//           label: 'ACCEPTABLE',
//           data: [<?php echo $dataA; ?>],
//           backgroundColor: '#20A1FC',
//           borderColor:'#777',
//           hoverBorderWidth:3,
//           order:2,
//           borderWidth: 3	
//           },
//           {
//           label: 'POOR',
//           data: [<?php echo $dataP; ?>],
//           backgroundColor: '#FC2024',
//           borderColor:'#777',
//           hoverBorderWidth:3,
//           order:3,
//           borderWidth: 3	
//           }]
//           
          
       datasets:[{
         label:'Appels',
         data:[
           <?php echo $dataG; ?>,
           <?php echo $dataA; ?>,
           <?php echo $dataP; ?>
                     ],
         //backgroundColor:'green',
         backgroundColor:[
           '#80FC20',
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
          text:'Classification des appels',
          fontSize:25
        },
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
</body>
</html>