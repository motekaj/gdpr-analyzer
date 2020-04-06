<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Dropdown;

// $this->title = 'dpoe 0.2';
?>
<div class="row">
  <div class="col-lg-6">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Step 3: Processing Task</h6>
      </div>
      <div class="card-body">
        The following tasks were identified in the Controller's pool. Select the processing task corresponding to the identified personal data:
        <br>
        <br>
        <form action="<?php echo Url::to(['site/extractiond', 'diagramID' => $diagramID]) ?>" method="POST">
        <?php
        foreach ($processingTasks as $key => $value) {
        echo '<div class="form-check">
                <input class="form-check-input" type="radio" value="' . preg_replace('/\s+/', '_', $value) . '" id="' . $value . '" name="processingTask">
                <label class="form-check-label" for="' . $value . '">
                  <strong>' . $value . '</strong>
                </label>
              </div>';
        }
        ?>
        <br>
        <br>

        <div class="form-group">
          <?= Html::submitButton('Submit', ['class'=>'btn btn-primary']) ?>
        </div>
        </form>
      </div>
    </div>

    
  </div>

    <div class="col-lg-6">
      <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Assigned Data: Roles</h6>
      </div>
      <div class="card-body">
        <?php
        if ($data['data_subject'] !== 'NULL') { echo '<span class="btn btn-info"><strong>Data Subject: ' . $data['data_subject'] . '</strong></span>'; }
        if ($data['controller'] !== 'NULL') { echo '<span class="btn btn-info"><strong>Controller: ' . $data['controller'] . '</strong></span>'; }
        if ($data['processor'] !== 'NULL') { echo '<span class="btn btn-info"><strong>Processor: ' . $data['processor'] . '</strong></span>'; }
        if ($data['recipient'] !== 'NULL') { echo '<span class="btn btn-info"><strong>Recipient: ' . $data['recipient'] . '</strong></span>'; }
        if ($data['third_party'] !== 'NULL') { echo '<span class="btn btn-info"><strong>Third Party: ' . $data['third_party'] . '</strong></span>'; }
        ?>
      </div>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Assigned Data: Personal Data</h6>
      </div>
      <div class="card-body">
        <span class="btn btn-info"><strong><?= $data['personal_data'] ?></strong></span>&nbsp;
      </div>
    </div>

      
  </div>
</div>