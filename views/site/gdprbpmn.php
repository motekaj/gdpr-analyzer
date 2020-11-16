<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'dpoe 0.2';

$this->registerMetaTag(['http-equiv' => 'Content-Security-Policy','content' =>""]);

?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">GDPR-BPMN Analyzer</h1>
</div>
<div class="row">
  <div class="col-lg-6 mb-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Welcome!</h6>
        </div>
        <div class="card-body">
          <p>Upload a GDPR-BPMN annotated model to begin evaluating the compliance level of your business process to the GDPR. The output will help refine the process model and determine potential violations of the GDPR that may risk your organization receiving administrative fines as outlined by the regulation.</p>

          <p>The output is intended to serve as a basis for rectification of the process model and may require further consultation with the process stakeholders to correct.</p>
        </div>

    </div>

      </div>
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card border-left-success py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Upload</div>
                <br>
                <?php $form = ActiveForm::begin([
                    'action' => [
                        'site/gdprbpmn'
                    ],
                    'options' => [
                        'enctype' => 'multipart/form-data'
                    ]
                ]) ?>
                <?= $form->field($model, 'file', [
                    'options' => [
                        'class' => '',
                    ]
                ])->fileInput() ?>
                <div class="h5 mb-0 font-weight-bold text-gray-800">

                  <br>
              
                  <button href="#" class="btn btn-success ">
                    <span class="text"><strong>UPLOAD MODEL</strong></span>
                  </button>
                  
                  <?php ActiveForm::end() ?>
                </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-upload fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>






