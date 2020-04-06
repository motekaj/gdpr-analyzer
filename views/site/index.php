<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'dpoe 0.2';

function encodep($text) {
   $data = utf8_encode($text);
   $compressed = gzdeflate($data, 9);
   return encode64($compressed);
}

function encode6bit($b) {
   if ($b < 10) {
        return chr(48 + $b);
   }
   $b -= 10;
   if ($b < 26) {
        return chr(65 + $b);
   }
   $b -= 26;
   if ($b < 26) {
        return chr(97 + $b);
   }
   $b -= 26;
   if ($b == 0) {
        return '-';
   }
   if ($b == 1) {
        return '_';
   }
   return '?';
}

function append3bytes($b1, $b2, $b3) {
   $c1 = $b1 >> 2;
   $c2 = (($b1 & 0x3) << 4) | ($b2 >> 4);
   $c3 = (($b2 & 0xF) << 2) | ($b3 >> 6);
   $c4 = $b3 & 0x3F;
   $r = "";
   $r .= encode6bit($c1 & 0x3F);
   $r .= encode6bit($c2 & 0x3F);
   $r .= encode6bit($c3 & 0x3F);
   $r .= encode6bit($c4 & 0x3F);
   return $r;
}

function encode64($c) {
   $str = "";
   $len = strlen($c);
   for ($i = 0; $i < $len; $i+=3) {
          if ($i+2==$len) {
                $str .= append3bytes(ord(substr($c, $i, 1)), ord(substr($c, $i+1, 1)), 0);
          } else if ($i+1==$len) {
                $str .= append3bytes(ord(substr($c, $i, 1)), 0, 0);
          } else {
                $str .= append3bytes(ord(substr($c, $i, 1)), ord(substr($c, $i+1, 1)),
                    ord(substr($c, $i+2, 1)));
          }
   }
   return $str;
}

$output = ('class ProcessingTask <<ProcessingTask>> {
  logged : bool
}

class FilingSystem {
  data_storage: bool
  storage_limited: bool
}

class ProcessingSystem {
  confidentiality: bool
  integrity: bool
  availability: bool
  resilient: bool
  pseudonymity: bool
  data_minimization: bool
  redundancies: bool
  tested: bool
}

class TechnicalMeasures {
  technologies: Array
}

class SpecialPurpose {
 general: bool
 employment_purpose: bool
 social_purpose: bool
 vital_interest: bool
 nonprofit_body: bool
 public_from_subject: bool
 legal_claim: bool
 substantial_public_interest: bool
 preventive_medicine: bool
 occupational_medicine: bool
 public_health: bool
 archiving: bool
 statistical_purposes: bool
}

class Purpose {
  general: bool
  contract_performance: bool
  controller_legal_obligation: bool
  vital_interest_protection: bool
  public_interest: bool
  legitimate_interest: bool
}

class PersonalData <<PersonalData>> {
  category: DATA_CATEGORY
}

class Consent {
}

class Controller <<Controller>> {
}

class DataSubject <<DataSubject>> {
  minor : false  
}

class DataHandler {
}

class Recipient <<Recipient>> {
}

class ThirdParty <<ThirdParty>> {
}

class Processor <<Processor>> {
}

class ProcessingLog <<Artifact>> {
  name: bool
  contact_details: bool
  personal_data_category: bool
  data_storage_period: bool
  technical_safeguards: bool
  recipients: bool
}
  
class ConsentAgreement <<Artifact>> {
  clear_purpose: bool
  unambiguous: bool
  affirmative_action: bool
  distinguishable: bool
  specific: bool
  withdrawable: bool
  freely_given: bool
}


skinparam class {
  BackgroundColor<<Artifact>> PaleGreen
  BorderColor<<Artifact>> SpringGreen
  BackGroundColor<<NotRequired>> White
  BorderColor<<NotRequired>> DarkGray
  AttributeFontColor<<NotRequired>> LightGray
  BorderColor<<MissingClass>> Red
  BackgroundColor<<MissingArtifact>> PaleGreen
  BorderColor<<MissingArtifact>> Red
}


PersonalData -- Consent : requires >
DataSubject -- PersonalData : provides >
Controller -- ProcessingSystem : implements >
Controller -- Processor
Consent -- ConsentAgreement : manifests >
ProcessingTask -- ProcessingLog : manifests >
PersonalData -- SpecialPurpose
Purpose -- Consent
Controller --|> DataHandler
Processor --|> DataHandler
Recipient --|> DataHandler
ThirdParty --|> DataHandler
DataHandler -- PersonalData : receives >
ProcessingSystem -- ProcessingTask : performs >
FilingSystem --|> ProcessingSystem
TechnicalMeasures -- ProcessingSystem : secures >
');

$encode = encodep($output);
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Evaluate Business Process</h1>
</div>
<div class="row">
  <div class="col-lg-6 mb-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Welcome!</h6>
        </div>
        <div class="card-body">
          <p>Upload a BPMN model to begin evaluating the compliance level of your business process to the GDPR.</p>

          <p>You will be asked a series of questions to identify GDPR-focused characteristics and attributes of the relevant elements in the process diagram. This information will be used to instantiate a compliance model of the GDPR (below) that this analyzer is based on. The output will help refine the process model and determine potential violations of the GDPR that may risk your organization receiving administrative fines as outlined by the regulation.</p>

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
          <h6 class="m-0 font-weight-bold text-primary">GDPR Compliance Model</h6>
        </div>
        <div class="card-body">
          <img style="width:100%;" src=<?php echo "http://www.plantuml.com/plantuml/img/{$encode}"; ?>>
        </div>

        </div>

      </div>
</div>




