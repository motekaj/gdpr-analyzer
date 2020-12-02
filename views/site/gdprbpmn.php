<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'dpoe 0.2';

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

    <div class="row">
      <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">GDPR-BPMN Modeling Syntax</h6>
            </div>
            <div class="card-body">
              <p>The GDPR-BPMN modeling syntax is based on the <a href="<?= Url::to(['site/index']) ?>">GDPR Compliance Model</a> and captures all the classes and their corresponding attributes using BPMN annotations attached to appropriate BPMN elements. The annotations are described using square brackets. (Eg. [Controller])</p>
              <p>The process diagram below describes how to depict the core elements of the compliance model to run a successful analysis.</p>
              <ol>
                <li>Actors such as the controller are described using <strong>Company [Controller]</strong>.</li>
                <li>Artifacts are described using <strong>[Artifact] Consent</strong> or <strong>[Artifact] PrivacyPolicy</strong>.</li>
                <li>Attributes of artifacts are described by annotating the appropriate artifact with labels corresponding to the attributes. Multiple attributes are separated by a space - <strong>[clear_purpose] [unambiguous]</strong> in this case.</li>
                <li>Personal data is assigned by prefixing the appropriate data object label with the prefix <strong>[personal_data]</strong></li>
                <li>Data category is assigned by annotating the personal data object with the appropriate label - <strong>[general]</strong> in this case.</li>
                <li>Technical measures and processing task are described by prefixing the task label with the technical measure and the label [processing_task] in that order - <strong>[PKEncryption] [processing_task]</strong> in this case.</li>
                <li>Attributes of the processing system, filing system and miscellaneous attributes are annotated on the controller's pool - <strong>[confidentiality] [integrity]</strong> in this case.</li>
                <li>Legal ground is described by annotating the controller's pool - <strong>[consent]</strong> in this case.</li>
              </ol>
            </div>


            <img style="width:50%; padding:20px;" src="/img/gdprbpmnexample.png">



        </div>

      </div>
    </div>





