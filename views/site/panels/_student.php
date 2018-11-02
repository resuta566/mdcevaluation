<?php 
use yii\helpers\Html;
use app\components\MyWidgets;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\MaterialAsset;
use app\models\Teacher;
use app\models\Evaluation;

MaterialAsset::register($this);
$this->title = "Dashboard";
?>



<body>
<div class="wrapper">
			<div class="sidebar" data-color="blue" data-image="<?= Yii::$app->request->baseUrl ?>/img/mdclogo.png">
							<!--
								Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

								Tip 2: you can also add an image using data-image tag
							-->

							<div class="logo">
							<a href="<?= \yii\helpers\Url::to(['/']) ?>" class="simple-text">
							<?= Yii::$app->user->identity->student->fullName; ?>
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
									<a href="<?= \yii\helpers\Url::to(['/']) ?>">
										<i class="glyphicon glyphicon-user"> </i>
										<p>Profile</p>
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
						<h1 class="title">DASHBOARD</h1>
						<p class="category">Student Dashboard</p>
					</div>
								<div class="panel-body">
								<?php $evaluation = Evaluation::find()->where(['eval_by' => Yii::$app->user->identity->id])->all();  ?>
								<?php if(!$evaluation){?>
										<h3>There is no Evaluation yet.</h3>
										<small>Please wait for the admin to create an evaluation form for you.</small>
								<?php } else{ ?>
									<?php foreach ($evaluation as $usereval => $eval): ?>
								<center> 
								<div class="col-lg-3 col-md-6 col-sm-6">
									<div class="card card-stats">
                                            <a href="<?= \yii\helpers\Url::to(['evaluation/evaluate', 'id' => $eval->id ]) ?>">
                                                <div class="card-header" data-background-color="orange">
                                                    <i class="glyphicon glyphicon-blackboard"></i>
                                                </div>
                                                <div class="card-content">
                                                    <h5 class="title"><?= $eval->evalFor->teacher->fullName ?></h5>
                                                    <p class="category"><?= $eval->class->name ?></p>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="stats">
                                                        <i class="glyphicon glyphicon-briefcase"></i> <?= $eval->class->day ?>, <?= $eval->class->time ?>
                                                    </div>
                                                </a>
                                        </div>
										
                        			</div>
									</center>
							<?php endforeach; ?>
								<?php }?>
		
								</div>
						  	</div>
			</div>
	</div>

</div>
<body>