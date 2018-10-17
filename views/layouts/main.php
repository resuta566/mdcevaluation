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
use ramosisw\CImaterial\web\MaterialAsset;
if (class_exists('ramosisw\CImaterial\web\MaterialAsset')) {
    ramosisw\CImaterial\web\MaterialAsset::register($this);
}
// AppAsset::register($this);
// MaterialAsset::register($this);
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
	    <div class="sidebar" data-color="blue" data-image="http://mdc.ph/wp-content/uploads/2013/08/MDC-Logo-clipped.png">

			<!--
		        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

		        Tip 2: you can also add an image using data-image tag
		    -->

			<div class="logo">
			

		 <?php if(Yii::$app->user->identity->role==User::ROLE_ADMIN){ ?>
			<a href="<?= \yii\helpers\Url::to(['/']) ?>" class="simple-text">
		<?= Yii::$app->user->identity->teacher->fullName . '</a>'; ?>
		</a>
        <?php }else if(Yii::$app->user->identity->role==User::ROLE_STUDENT){?>
			<a href="<?= \yii\helpers\Url::to(['/']) ?>" class="simple-text">
		<?= Yii::$app->user->identity->student->fullName . '</a>'; ?>
		</a>
		<?php }else if(Yii::$app->user->identity->role==User::ROLE_TEACHER){?>
			<a href="<?= \yii\helpers\Url::to(['/']) ?>" class="simple-text">
		<?= Yii::$app->user->identity->teacher->fullName . '</a>'; ?>
		</a>
		<?php }?>
						</div>

	    	<div class="sidebar-wrapper">
			<?= ramosisw\CImaterial\widgets\Menu::widget(
            [
                'options' => ['class' => 'nav'],
                'items' => [
                    ['label' => 'Dashboard', 'icon' => 'home', 'url' => ['/']],
                    ['label' => 'Users', 'icon' => 'user', 'url' => ['/user']],
                    ['label' => 'Teachers', 'icon' => 'blackboard', 'url' => ['/teacher']],
                    ['label' => 'Heads/Deans', 'icon' => 'blackboard', 'url' => ['/head']],
                    ['label' => 'Students', 'icon' => 'education', 'url' => ['/student']],
                    ['label' => 'Instruments', 'icon' => 'book', 'url' => ['/instrument']],
                ],
            ]
        ) ?>
	    	</div>
		</div>

	    <div class="main-panel">
		<?php
		NavBar::begin([
			'brandLabel' => '<img src="http://mdc.ph/wp-content/uploads/2013/08/MDC-Logo-clipped.png" style="display:inline; horizontal-align: top; height:45px;" alt="logo"/> Teacher Evaluation',
			'brandUrl' => Yii::$app->homeUrl,
			'innerContainerOptions' => ['class' => 'container-fluid'],
			'options' => [
				'class' => 'navbar navbar-transparent navbar-absolute',
			],
		]);
		echo Nav::widget([
			'options' => ['class' => 'nav navbar-nav navbar-right'],
			'encodeLabels' => false,
			'dropDownCaret' => "<span style='font-size:25px;' class='glyphicon glyphicon-cog'></span>",
			'items' => [
				[
					'label' => '',
					'items' => [
						[
						 'label' => 'Logout',
						 'url' => ['site/logout'],
						 'linkOptions' => ['data-method' => 'post']
						],
				   ],
				]
				],
		]);
		NavBar::end();
		?>
			

	        <div class="content">
	            <div class="container-fluid">
	                <div class="row">
					<?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
					<?= ramosisw\CImaterial\widgets\Alert::widget() ?>
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
