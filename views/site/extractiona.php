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
        <h6 class="m-0 font-weight-bold text-primary">Step 1: GDPR Role Assignment</h6>
      </div>
      <div class="card-body">
        Assign the identified process participants (listed on the right) to their corresponding GDPR roles below:
        <br>
        <br>
        <form action="<?php echo Url::to(['site/extractionb', 'diagramID' => $diagramID]) ?>" method="POST">
          <div class="form-group">
            <label for="data_subject" href="#" ><strong>Data Subject</strong></label>
            <select class="form-control" id="data_subject" name="data_subject">
              <?php
                foreach ($data as $key => $value) {
                  echo '<option value="' . $value['name'] . '">' . $value['name'] . '</option>';
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="controller" href="#" ><strong>Controller</strong></label>
            <select class="form-control" id="controller" name="controller">
              <?php
                foreach ($data as $key => $value) {
                  echo '<option value="' . $value['name'] . '">' . $value['name'] . '</option>';
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="processorx" data-toggle="dropdown" class=""><strong>Processor</strong></label>
               <select class="form-control" id="processorx" name="processor">
                <option value="None">None</option>
                <?php
                  foreach ($data as $key => $value) {
                    echo '<option value="' . $value['name'] . '">' . $value['name'] . '</option>';
                  }
                ?>
              </select>
          </div>
          <div class="form-group">
            <label for="recipient" data-toggle="dropdown" class=""><strong>Recipient (Optional)</strong></label>
               <select class="form-control" id="recipient" name="recipient">
                <option value="None">None</option>
                <?php
                  foreach ($data as $key => $value) {
                    echo '<option value="' . $value['name'] . '">' . $value['name'] . '</option>';
                  }
                ?>
              </select>
          </div>
          <div class="form-group">
            <label for="third_party" data-toggle="dropdown" class=""><strong>Third party (Optional)</strong></label>
               <select class="form-control" id="third_party" name="third_party">
                <option value="None">None</option>
                <?php
                  foreach ($data as $key => $value) {
                    echo '<option value="' . $value['name'] . '">' . $value['name'] . '</option>';
                  }
                ?>
              </select>
          </div>
          <br>
          <input type="hidden" name="diagramID" value="<?= $diagramID ?>">
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
        <h6 class="m-0 font-weight-bold text-primary">Extracted Data: Participants</h6>
      </div>
      <div class="card-body">
        <?php
        foreach ($data as $key => $value) {
          echo '<span class="btn btn-info"><strong>' . $value['name'] . '</strong></span>';
        }
        ?>
      </div>
    </div>
  </div>
</div>
