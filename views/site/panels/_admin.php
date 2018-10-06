<?php 
use yii\helpers\Html;
use app\components\MyWidgets;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\MaterialAsset;
use app\models\Teacher;
use app\models\Student;
use app\models\Instrument;
use app\models\User;

MaterialAsset::register($this);
$this->title = "Admin Dashboard";
?>
<body>
<div class="wrapper">
			<div class="sidebar" data-color="blue" data-image="http://mdc.ph/wp-content/uploads/2013/08/MDC-Logo-clipped.png">
							<!--
								Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

								Tip 2: you can also add an image using data-image tag
							-->

							<div class="logo">
							<a href="<?= \yii\helpers\Url::to(['/']) ?>" class="simple-text">
							<?= Yii::$app->user->identity->teacher->fullName; ?>
							</a>
			</div>

	    	<div class="sidebar-wrapper">
									<ul class="nav">
										<li class="active">
											<a href="<?= \yii\helpers\Url::to(['/']) ?>">
												<i class="glyphicon glyphicon-home"></i>
												<p>Dashboard</p>
											</a>
										</li>
										<li>
											<a href="<?= \yii\helpers\Url::to(['/user']) ?>">
												<i class="glyphicon glyphicon-user"> </i>
												<p>User</p>
											</a>
										</li>
										<li>
											<a href="<?= \yii\helpers\Url::to(['/teacher']) ?>">
												<i class="glyphicon glyphicon-blackboard"> </i>
												<p>Teachers</p>
											</a>
										</li>
										<li>
											<a href="<?= \yii\helpers\Url::to(['/student']) ?>">
												<i class="glyphicon glyphicon-education"></i>
												<p>Students</p>
											</a>
										</li>
										<li>
											<a href="<?= \yii\helpers\Url::to(['/instrument']) ?>">
												<i class="glyphicon glyphicon-book"> </i>
												<p>Instrument</p>
											</a>
										</li>
										<li>
											<a href="<?= \yii\helpers\Url::to(['/evaluation-item']) ?>">
												<i class="glyphicon glyphicon-book"> </i>
												<p>Evaluation Item</p>
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
						<a class="navbar-brand" href="<?= \yii\helpers\Url::to(['/']) ?>">
							<img src="http://mdc.ph/wp-content/uploads/2013/08/MDC-Logo-clipped.png" style="display:inline; horizontal-align: top; height:45px;"/> Teacher Evaluation
						</a>
					</div>
					<div class="collapse navbar-collapse">
									<ul class="nav navbar-nav navbar-right">
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">
												<i style="font-size:25px;" class="glyphicon glyphicon-cog"> </i>
												<p class="hidden-lg hidden-md"> </p>
											</a>
											<ul class="dropdown-menu">
												<li>
													<?= Html::a('Logout', ['site/logout'], ['data' => ['method' => 'post']]); ?>
												</li>
											</ul>
										</li>
									</ul>
								</div>
	</nav>
				<div class="container-fluid">
						<div class="card">
					<div class="card-header" data-background-color="blue">
						<h1 class="title">DASHBOARD</h1>
						<p class="category">Admin Dashboard</p>
					</div>
								<div class="panel-body">
								<center>
											<div class="col-lg-3 col-md-6 col-sm-6">
												<div class="card card-stats">
												<a href="<?= \yii\helpers\Url::to(['/user']) ?>">
													<div class="card-header" data-background-color="blue">
														<i class="glyphicon glyphicon-user"></i>
													</div>
													<div class="card-content">
														<p class="category">Users</p>
														<h3 class="title"><?= User::find()->count(); ?></h3>
													</div>
													<div class="card-footer">
														<div class="stats">
															<i class="glyphicon glyphicon-check"></i> Users
														</div>
													</div>
													</a>
												</div>
												</div>
											<div class="col-lg-3 col-md-6 col-sm-6">
												<div class="card card-stats">
													<a href="<?= \yii\helpers\Url::to(['/teacher']) ?>">
														<div class="card-header" data-background-color="orange">
															<i class="glyphicon glyphicon-blackboard"></i>
														</div>
														<div class="card-content">
															<p class="category">Teachers</p>
															<h3 class="title"><?= Teacher::find()->count(); ?></h3>
														</div>
														<div class="card-footer">
															<div class="stats">
																<i class="glyphicon glyphicon-briefcase"></i> Active
															</div>
														</div>
													</a>
												</div>
												</div>
											<div class="col-lg-3 col-md-6 col-sm-6">
												<div class="card card-stats">
													<a href="<?= \yii\helpers\Url::to(['/student']) ?>">
													<div class="card-header" data-background-color="green">
														<i class="glyphicon glyphicon-education"></i>
													</div>
													<div class="card-content">
														<p class="category">Students</p>
														<h3 class="title"><?= Student::find()->count(); ?></h3>
													</div>
													<div class="card-footer">
														<div class="stats">
														<i class="glyphicon glyphicon-calendar"></i> Enrolled
														</div>
													</div>
													</a>
												</div>
												</div>
											<div class="col-lg-3 col-md-6 col-sm-6">
													<div class="card card-stats">
														<a href="<?= \yii\helpers\Url::to(['/instrument']) ?>">
															<div class="card-header" data-background-color="red">
																<i class="glyphicon glyphicon-book"></i>
															</div>
															<div class="card-content">
																<p class="category">Instruments</p>
																<h3 class="title"><?= Instrument::find()->count(); ?></h3>
															</div>
															<div class="card-footer">
																<div class="stats">
																	<i class="glyphicon glyphicon-bookmark"></i> Evaluation Instruments	
																</div>
															</div>
														</a>
													</div>
												</div>
											</center>
		
								</div>
						  	</div>
			</div>
	</div>

</div>
<body>

