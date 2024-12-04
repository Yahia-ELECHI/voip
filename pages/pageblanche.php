
<! DOCTYPE HTML>
<HTML>
    <head>
        <meta charset="utf-8">
        <title>Page blanche</title>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
        <link rel="stylesheet" href="../bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.css" />
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="../bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js"></script>

    </head>
    <body>
       <?php include ("menu.php"); ?>
       <div class="container">
           <div class="panel panel-primary espace60">
               <div class="panel-heading"><div class="container">
    <div class="row">
        <div class='col-sm-3'>
            <div class="form-group">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>
    </div>
</div></div>
               <div class="panel-body">
                   <?php
                   echo date("Y-n-j", strtotime("first day of current month"));
                   echo date("Y-n-j", strtotime("last day of current month"));
                   ?>
               </div>
           </div>


           <div class="panel panel-primary">
               <div class="panel-heading">Liste</div>
               <div class="panel-body">
            
               </div>
           </div>
        </div>
    </body>

</HTML>