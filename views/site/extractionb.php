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
        <h6 class="m-0 font-weight-bold text-primary">Step 2: Identification of Personal Data</h6>
      </div>
      <div class="card-body">
        The following input data objects are being used by the Controller. Select the personal data object to analyze:
        <br>
        <br>
        <form action="<?php echo Url::to(['site/extractionc', 'diagramID' => $diagramID]) ?>" method="POST">
        <?php
        foreach ($data as $key => $value) {
        echo '<div class="form-check">
                <input class="form-check-input" type="radio" value="' . explode('(',trim($value))[0] . '" id="' . $value . '" name="personalData" required>
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
        if ($roles['data_subject'] !== 'NULL') { echo '<span class="btn btn-info"><strong>Data Subject: ' . $roles['data_subject'] . '</strong></span>'; }
        if ($roles['controller'] !== 'NULL') { echo '<span class="btn btn-info"><strong>Controller: ' . $roles['controller'] . '</strong></span>'; }
        if ($roles['processor'] !== 'NULL') { echo '<span class="btn btn-info"><strong>Processor: ' . $roles['processor'] . '</strong></span>'; }
        if ($roles['recipient'] !== 'NULL') { echo '<span class="btn btn-info"><strong>Recipient: ' . $roles['recipient'] . '</strong></span>'; }
        if ($roles['third_party'] !== 'NULL') { echo '<span class="btn btn-info"><strong>Third Party: ' . $roles['third_party'] . '</strong></span>'; }
        ?>
      </div>
    </div>

      
  </div>
</div>
