<?php 
use yii\helpers\Html;
use app\components\MyWidgets;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\MaterialAsset;
use app\models\Teacher;
use app\models\User;

MaterialAsset::register($this);
$this->title = "Dashboard";
?>
<body>
<div class="wrapper">
			<div class="sidebar" data-color="purple" data-image="<?= Yii::$app->request->baseUrl ?>/img/mdclogo.png">
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
								<?php if(Yii::$app->user->identity->role==User::ROLE_TEACHER){ ?>
									<li>
									<a href="<?= \yii\helpers\Url::to(['/user/profile','id' => Yii::$app->user->identity->id]) ?>">
										<i class="glyphicon glyphicon-user"> </i>
										<p>Profile</p>
									</a>
								</li>
								<?php }else if(Yii::$app->user->identity->role==User::ROLE_HEAD){?>
									<li>
									<a href="<?= \yii\helpers\Url::to(['/rank/department']) ?>">
										<i class="glyphicon glyphicon-equalizer"> </i>
										<p>Ranking</p>
									</a>
								</li>
								<li>
									<a href="<?= \yii\helpers\Url::to(['/user/profile','id' => Yii::$app->user->identity->id]) ?>">
										<i class="glyphicon glyphicon-user"> </i>
										<p>Profile</p>
									</a>
								</li>
								<?php }?>
								
	               
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
						<a class="navbar-brand" href="<?= \yii\helpers\Url::to(['/']) ?>" style="font-family:Old English Text MT;">
							<img src="<?= Yii::$app->request->baseUrl ?>/img/mdclogo.png" style="display:inline; horizontal-align: top; height:45px;"/> Teacher Evaluation
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
						<h1 class="title" style="font-family:Old English Text MT;">DASHBOARD</h1>
						<p class="category">Teacher Dashboard</p>
					</div>
					<div class="panel-body">
					<?php if(Yii::$app->user->identity->role==User::ROLE_TEACHER){?>
						<center>
							<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
							<a href="<?= \yii\helpers\Url::to(['teacher/view', 'id' => Yii::$app->user->identity->teacher->id ]) ?>">
								<div class="card-header" data-background-color="green">
									<i class="glyphicon glyphicon-user"></i>
								</div>
								<div class="card-content">
									<p class="category">Teacher Profile</p>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="glyphicon glyphicon-check"></i> Comments and Score
									</div>
								</div>
								</a>
							</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
							<a href="<?= \yii\helpers\Url::to(['user/profile', 'id' => Yii::$app->user->identity->id ]) ?>">
								<div class="card-header" data-background-color="orange">
										<i class="glyphicon glyphicon-blackboard"></i>
									</div>
									<div class="card-content">
										<p class="category">Teachers</p>
									</div>
									<div class="card-footer">
										<div class="stats">
											<i class="glyphicon glyphicon-briefcase"></i> Active
										</div>
									</div>
								</a>
							</div>
							</div>
						</center>
					<?php }else{?>
					<div class="row">
								<?php $evaluation = app\models\Evaluation::find()->where(['eval_by' => Yii::$app->user->identity->id])->andWhere(['status' => 0])->all();  ?>
								<?php if(!$evaluation){?>
										<h3>There is no Evaluation yet.</h3>
										<small>Please wait for the admin to create an evaluation form for you.</small>
								<?php } else{ ?>
									<div class="row">
									<center>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
							<a href="<?= \yii\helpers\Url::to(['/rank/department']) ?>">
								<div class="card-header" data-background-color="green">
									<i class="glyphicon glyphicon-equalizer"></i>
								</div>
								<div class="card-content">
									<p class="category">Ranking</p>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="glyphicon glyphicon-check"></i> Teacher Ranking
									</div>
								</div>
								</a>
							</div>
							</div>

							<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
							<a href="<?= \yii\helpers\Url::to(['/user/profile']) ?>">
								<div class="card-header" data-background-color="gray">
									<i class="glyphicon glyphicon-user"></i>
								</div>
								<div class="card-content">
									<p class="category">User Profile</p>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="glyphicon glyphicon-check"></i> User Profile
									</div>
								</div>
								</a>
							</div>
							</div>
					</center>
					</div>
					<center>
					<h2>Evaluation<h2>
					</center>
									<?php foreach ($evaluation as $usereval => $eval): ?>
									<center>
									<div class="col-lg-3 col-md-6 col-sm-6">
												<div class="card card-stats">
												<a href="<?= \yii\helpers\Url::to(['evaluation/evaluate', 'id' => $eval->id ]) ?>">
													<div class="card-header" data-background-color="purple">
														<i class="glyphicon glyphicon-blackboard"></i>
													</div>
													<div class="card-content">
														<h4 class="title"><?= $eval->evalFor->teacher->fullName ?></h4>
													</div>
													<div class="card-footer">
														<div class="stats">
														<i class="glyphicon glyphicon-briefcase"></i> <?= $eval->evalFor->departmentName?>
                                                    </div>
													</div>
													</a>
												</div>
									</center>
							<?php endforeach; ?>
								<?php }?>
								<?php }?>
								</div>
								</div>
						  	</div>
			</div>
	</div>

</div>
<body>