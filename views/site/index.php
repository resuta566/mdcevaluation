<?php
use  yii\bootstrap\Carousel;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */

$this->title = 'Mater Dei College Teachers Evaluation';
?>

    <nav class="navbar navbar-fixed-top">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a href="<?= \yii\helpers\Url::to(['/']) ?>" style="color: black"><img src="http://mdc.ph/wp-content/uploads/2013/08/MDC-Logo-clipped.png" style="display:inline; horizontal-align: top; height:45px;" alt="logo"/> <strong>Teacher Evaluation</strong></a>
                
            </div>
            <div class="pull-right" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                    <a class="modalButton" href="<?= \yii\helpers\Url::to(['site/login']) ?>" style="color: black">LOGIN</button>
                    
                </ul>
            </div>
    </nav>

   <?php echo Carousel::widget([
    'items' => [
        // equivalent to the above
        [
            'content' => '<img style="width:1400px;height:700px;" src="http://mdc.ph/wp-content/uploads/2013/08/mdc-memorial-wall-955x350.png"/>',
            'caption' => '<strong><h1>Mater Dei College</h1><p>This is the MDC Campus</p></strong>',
            
    ],
        // the item contains both the image and the caption
        [
            'content' => '<img src="https://dbkpop.com/wp-content/uploads/2018/06/momoland_baam_yeonwoo_profile.jpg"/>',
            'caption' => '<strong><h2>Yeonwoo</h2><p>Lee Da-Bin</p></strong>',
            
        ],
    ],
    'options' => [
        'class'=>'carousel slide',
        'interval' => '600'
        ]
]);

?>
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

