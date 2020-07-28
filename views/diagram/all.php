<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
// use jawira\plantuml

//Below command works. Check security before deploy.
// <?php exec("java -jar jar/plantuml.jar -charset UTF-8 $@ misc/gdprModelTest.puml 2>&1", $output);

$this->title = 'dpoe 0.2';


?>

<div class="row">
  <div class="col-lg-12 mb-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">All BPMN Models</h6>
        </div>
        <div class="card-body">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
     			<?php for($i = 0 ; $i < count($diagramNames) ; $i++) {
     			echo '<tr><td>' . $diagramNames[$i] . '<a href="' . Url::to(['site/extractiona', 'diagramID' => $diagramIDs[$i]]) . '"><div class="btn btn-primary float-right">Evaluate</div></a><a href="' . Url::to(['diagram/delete', 'diagramID' => $diagramIDs[$i]]) . '"><div class="btn btn-secondary float-right mr-2">Delete</div></a><a href="' . Url::to(['diagram/view', 'diagramName' => $diagramNames[$i]]) . '"><div class="btn btn-info float-right mr-2">View</div></a></td><tr>';
 				} ?>
			</table>
        </div>

        </div>

      </div>
</div>


