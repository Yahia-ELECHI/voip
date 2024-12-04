<nav class="navbar navbar-inverse navbar-fixed-top">
    
    <div class="container-fluid">
            <a href="../index.php" style="float: left;
                    height: 50px;
                    padding: 10px 10px;
                    padding-top: 10px;
                    padding-right: 10px;
                    padding-bottom: 10px;
                    padding-left: 10px;
                    font-size: 18px;
                    line-height: 20px;
                    margin-left: 10px;
                    "><img src="../PNG/logo.png"></a>
            <a href="../index.php" class="navbar-brand">Cisco VOIP QOS</a>
            <ul class="nav navbar-nav">
                <?php if($_SESSION['utilisateur']['ROLE']=="ADMIN" OR $_SESSION['utilisateur']['ROLE']=="EXPLOITATION") {?>
                <li><a href="CDR.php">Tickets CDR</a></li>
                <?php } ?>
                <?php if($_SESSION['utilisateur']['ROLE']=="ADMIN" OR $_SESSION['utilisateur']['ROLE']=="EXPLOITATION") {?>
                <li><a href="CMR.php">Tickets CMR</a></li>
                <?php } ?>
                <?php if($_SESSION['utilisateur']['ROLE']=="ADMIN" OR $_SESSION['utilisateur']['ROLE']=="EXPLOITATION") {?>
                <li><a href="tableresultat.php">Classification</a></li>
                <?php } ?>
                <?php if($_SESSION['utilisateur']['ROLE']=="ADMIN" OR $_SESSION['utilisateur']['ROLE']=="EXPLOITATION") {?>
                <li><a href="CMlocation.php">Sites</a></li>
                <?php } ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <?php if($_SESSION['utilisateur']['ROLE']=="ADMIN") {?>
                <li><a href="utilisateurs.php">Utilisateurs</a></li>
                <?php } ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
				<li>
					<a href="editerUtilisateur.php?id=<?php echo $_SESSION['utilisateur']['ID'];?>">
						<span class="glyphicon glyphicon-user"></span> 
						<?php echo $_SESSION['utilisateur']['LOGIN'];?>
					</a>
				</li>
				<li>
					<a href="SeDeconnecter.php">
						<span class="glyphicon glyphicon-log-out"></span>
						Deconnection
					</a>
				</li>
			</ul>
        
    </div>
</nav>nav>