<?php 
use yii\helpers\Html;
use app\components\MyWidgets;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\MaterialAsset;

MaterialAsset::register($this);
$this->title = "Dashboard";
?>



<body>
<div class="wrapper">
			<div class="sidebar" data-color="purple" data-image="../assets/img/sidebar-1.jpg">
							<!--
								Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

								Tip 2: you can also add an image using data-image tag
							-->

							<div class="logo">
								
									<?= Nav::widget([
						'items' => [
							Yii::$app->user->isGuest ? (
								['label' => 'Login', 'url' => ['/site/login'],
								]
							) : (
								'<a href="../web/index.php" class="simple-text">'.
								Yii::$app->user->identity->student->fullName . '</a>'.
								Html::a('Logout', ['site/logout'], ['data' => ['method' => 'post']])
								.''
							)
						],
					]); ?>
				
			</div>

	    	<div class="sidebar-wrapper">
	            <ul class="nav">
	                <li class="active">
	                    <a href="index.php">
	                        <i class="material-icons">dashboard</i>
	                        <p>Dashboard</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="user.html">
	                        <i class="material-icons">person</i>
	                        <p>User Profile</p>
	                    </a>
	                </li>
	               
	            </ul>
	    	</div>
		</div>
		
	<div class="main-panel">
	
	<nav class="navbar navbar-transparent navbar-absolute">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">
							<img src="mdclogo.png" style="display:inline; horizontal-align: top; height:45px;"/>Teacher Evaluation
						</a>
					</div>
	</nav>
		<div class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="panel panel-info">
								<div class="panel-heading">
									<span class="big">
										<h2>Student Panel</h2>
									</span>
								</div>
								<div class="panel-body">
									<center>
										<?= MyWidgets::mainPanelButton("glyphicon glyphicon-th-list", "Study Load", "/students/load" ) ?>
										<?= MyWidgets::mainPanelButton("glyphicon glyphicon-folder-close", "Courses", "/courses" ) ?>
										<p><?= Html::a('Logout', ['site/logout'], ['data' => ['method' => 'post']]) ?></p>
									</center>
								</div>
							</div>
							</div>
						</div>
					</div>
		</div>

</div>
<body>