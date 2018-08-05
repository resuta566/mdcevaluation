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
use app\models\Users;
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
							Yii::$app->user->identity->username . '</a>'.
								Html::a('Logout', ['site/logout'], ['data' => ['method' => 'post']])
								.''
							)
						],
					]); ?>
				
			</div>

	    	<div class="sidebar-wrapper">
	            <ul class="nav">
	                <li class="active">
	                    <a href="dashboard.html">
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
	                <li>
	                    <a href="table.html">
	                        <i class="material-icons">content_paste</i>
	                        <p>Table List</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="typography.html">
	                        <i class="material-icons">library_books</i>
	                        <p>Typography</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="icons.html">
	                        <i class="material-icons">bubble_chart</i>
	                        <p>Icons</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="maps.html">
	                        <i class="material-icons">location_on</i>
	                        <p>Maps</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="notifications.html">
	                        <i class="material-icons text-gray">notifications</i>
	                        <p>Notifications</p>
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
