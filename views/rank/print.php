<?php

$this->title = "MDC Teacher Evaluation";
$this->params['breadcrumbs'][] = ['label' => 'Teachers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
 $teachers = app\models\User::find()->where(['department' => $userDept])->andWhere(['role' => [20,30]])->all();
 ?>

 <button onclick="printContent('div1')" class="btn btn-info btn-pdfprint"><i class="glyphicon glyphicon-print" style="font-size: 20px"></i></button>
    
 <div id="div1"> 

    <?=
    $this->render('_castPrint',[
        'teachers' => $teachers,
        'userDept' => $userDept
    ]);
    ?>
<br><br><br><br><br><br><br><br><br><br>
<div class="jem">
<input type="text" style="border: 0; border-bottom: 1px solid #000;" disabled/><br>
      
    </div>
    <div class="jem">
    <?= Yii::$app->user->identity->teacher->fullName?>
</div>
</div>
<script>
      function printContent(el)
      {
         var restorepage = document.body.innerHTML;
         var printcontent = document.getElementById(el).innerHTML;
         document.body.innerHTML = printcontent;
         window.print();
         document.body.innerHTML = restorepage;
     }
   </script>