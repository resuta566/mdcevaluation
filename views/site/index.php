<?php
use  yii\bootstrap\Carousel;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */

$this->title = 'Mater Dei College Teachers Evaluation';
?>
<header id="home">
		<!-- Background Image -->
		<div class="bg-img" style="background-image: url('<?= Yii::$app->request->baseUrl ?>/img/mdcbg.jpg');">
			<div class="overlay"></div>
		</div>
		<!-- /Background Image -->

		<!-- Nav -->
		<nav id="nav" class="navbar nav-transparent">
			<div class="container">

				<div class="navbar-header">
					<!-- Logo -->
					<div class="navbar-brand">
						<a href="<?= \yii\helpers\Url::to(['/']) ?>"> 
							<img class="logo" src="<?= Yii::$app->request->baseUrl ?>/img/mdclogo.png" alt="logo">
							<p style="color: white"><img class="logo-alt" src="<?= Yii::$app->request->baseUrl ?>/img/mdclogo.png" style="display:inline; horizontal-align: top; height:45px;" alt="logo"> 
                            Teacher Evaluation</p>
                        </a>
					</div>
					<!-- /Logo -->

					<!-- Collapse nav button -->
					<div class="nav-collapse">
						<span></span>
					</div>
					<!-- /Collapse nav button -->
				</div>

				<!--  Main navigation  -->
				<ul class="main-nav nav navbar-nav navbar-right">
					<li><a class="modalButton" href="<?= \yii\helpers\Url::to(['site/logins']) ?>" style="color: white">LOGIN</a></li>
				</ul>
				<!-- /Main navigation -->

			</div>
		</nav>
		<!-- /Nav -->

		<!-- home wrapper -->
		<div class="home-wrapper">
			<div class="container">
				<div class="row">

					<!-- home content -->
					<div class="col-md-10 col-md-offset-1">
						<div class="home-content">
                            <h1 class="white-text">MATER DEI COLLEGE</h1>
                            <h3 class="white-text">Teacher Evaluation</h3>
							<p class="white-text">This is the Automated Teacher Evaluation System of Mater Dei College Tubigon Bohol
							</p>
							<button id="modalButton" class="btn btn-info" href="<?= \yii\helpers\Url::to(['site/logins']) ?>"  style="color: white">LOGIN</button>
						
						</div>
					</div>
					<!-- /home content -->

				</div>
			</div>
		</div>
		<!-- /home wrapper -->

	</header>
<div class="content">
	<?php 
		Modal::begin([
		'header' => '',
		'id' => 'modal',
		'size' => '',
		]);
		echo "<div id='modalContent'></div>";
		Modal::end();
	?>

</div>

