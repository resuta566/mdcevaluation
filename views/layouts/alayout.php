<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AdminLteAsset;
use app\assets\AppAsset;
use app\models\User;
if (class_exists('ramosisw\CImaterial\web\MaterialAsset')) {
    ramosisw\CImaterial\web\MaterialAsset::register($this);
}
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrapper">
	    <div class="sidebar" data-color="blue" data-image="../web/img/mdclogo.png">

			<!--
		        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

		        Tip 2: you can also add an image using data-image tag
		    -->

			<div class="logo">
			

		 <?php if(Yii::$app->user->identity->role==User::ROLE_ADMIN){ ?>
        <?= '<a href="../index.php" class="simple-text">'.
            Yii::$app->user->identity->teacher->fullName . '</a>'; ?>
        <?php }else if(Yii::$app->user->identity->role==User::ROLE_STUDENT){?>
		<?= '<a href="../index.php" class="simple-text">'.
            Yii::$app->user->identity->student->fullName . '</a>'; ?>
		<?php }else if(Yii::$app->user->identity->role==User::ROLE_TEACHER){?>
		<?= '<a href="../index.php" class="simple-text">'.
            Yii::$app->user->identity->teacher->fullName . '</a>'; ?>
		<?php }?>
						</div>

	    	<div class="sidebar-wrapper">
			<ul class="nav">
								<li class="active">
									<a href="../index.php">
										<i class="glyphicon glyphicon-home"></i>
										<p>Dashboard</p>
									</a>
								</li>
								<li>
									<a href="../index.php/user">
										<i class="glyphicon glyphicon-user"> </i>
										<p>User</p>
									</a>
								</li>
								<li>
									<a href="../index.php/teacher">
										<i class="glyphicon glyphicon-blackboard"> </i>
										<p>Teachers</p>
									</a>
								</li>
								<li>
									<a href="../index.php/student">
										<i class="glyphicon glyphicon-education"></i>
										<p>Students</p>
									</a>
								</li>
								<li>
									<a href="../index.php/instrument">
										<i class="glyphicon glyphicon-book"> </i>
										<p>Instrument</p>
									</a>
									
								</li>
								<li>
									<a href="../index.php/section">
										<i class="glyphicon glyphicon-book"> </i>
										<p>Section</p>
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
						<a class="navbar-brand" href="../index.php">
								<img src="../img/mdclogo.png" style="display:inline; horizontal-align: top; height:45px;"/> Teacher Evaluation
						</a>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
							
							<li class="dropdown">
								  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
								  <i style="font-size:25px;" class="glyphicon glyphicon-cog"> </i>
										<p class="hidden-lg hidden-md">Logout</p>
								  </a>
								  <ul class="dropdown-menu">
								  <li>
								<?= Html::a('Logout', ['site/logout'], ['data' => ['method' => 'post']]); ?>
												</li>
								  </ul>
							</li>
							
						</ul>

					</div>
				</div>
			</nav>

	        <div class="content">
	            <div class="container-fluid">
	                <div class="row">
						<?= $content ?>
	                </div>
	            </div>
	        </div>
			
	    </div>
	</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
