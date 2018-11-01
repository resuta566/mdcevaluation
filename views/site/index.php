<?php
use  yii\bootstrap\Carousel;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */

$this->title = 'Mater Dei College Teachers Evaluation';
?>
<header id="home">
		<!-- Background Image -->
		<div class="bg-img" style="background-image: url('http://mdc.ph/wp-content/uploads/2013/08/mdc-memorial-wall-955x350.png');">
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
							<img class="logo" src="http://mdc.ph/wp-content/uploads/2013/08/MDC-Logo-clipped.png" alt="logo">
							<p style="color: white"><img class="logo-alt" src="http://mdc.ph/wp-content/uploads/2013/08/MDC-Logo-clipped.png" style="display:inline; horizontal-align: top; height:45px;" alt="logo"> 
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
<?php $this->registerJsFile("@web/js/main.js");?>
<div class="content">
                <?php Modal::begin([
                            'header' => '<center><h2>LOGIN</h2></center>',
                            'id' => 'modal',
                            'size' => 'modal-lg',
                        ]);
                        echo "<div id='modalContent'></div>";
                        Modal::end();
                        ?>

</div>

