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
    high_risk: bool
}

class RiskCriteria {
    profiling: bool
    automatic_decision: bool
    systematic_monitoring: bool
    special_personal_data: bool
    large_scale_processing: bool
    data_merging: bool
    incapacitated_persons_data: bool
    new_technology: bool
    third_country_data_transfer: bool
    rights_inhibition: bool
}

class DataProtectionImpactAssessment <<Artifact>> {
    task_description: bool
    purpose: bool
    necessity_and_proportionality_assessment: bool
    risks_to_rights : bool
    risk_mitigation_measures: bool
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

ProcessingTask -- DataProtectionImpactAssessment : manifests >
RiskCriteria -- ProcessingTask');

$encode = encodep($output);
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Data Protection Impact Assessment</h1>
</div>
<div class="row">
  	<div class="col-lg-6 mb-4">
	    <div class="card shadow mb-4">
	        <div class="card-header py-3">
	          <h6 class="m-0 font-weight-bold text-primary">Description</h6>
	        </div>
	        <div class="card-body">
	          <p>The Data Protection Impact Assesment (DPIA) is necessary for any ongoing/planned processing tasks in your business process if it falls under a high risk category. The DPIA model to the right captures the risk criteria that determine whether the processing task falls under a high risk category according to the <a target="_blank" href="https://ec.europa.eu/newsroom/article29/item-detail.cfm?item_id=611236">Article 29 Working Party Guidelines for DPIA</a>. Generally, multiple criteria need to be applicable for a task to be considered high risk.</p>
            <p>The DPIA process model below describes the process to be used to determine whether a DPIA is necessary and how to apply the DPIA model. If a DPIA is deemed to be necessary, the report must be prepared fulfilling all the criteria in the modeled artifact.</p>
	        </div>
	    </div>
  	</div>
  	<div class="col-lg-6 mb-4">
	    <div class="card shadow mb-4">
	        <div class="card-header py-3">
	          <h6 class="m-0 font-weight-bold text-primary">DPIA Model</h6>
	        </div>
	        <div class="card-body">
	          <img style="width:50%;" src=<?php echo "http://www.plantuml.com/plantuml/img/{$encode}"; ?>>
	        </div>
	    </div>
    </div>
</div>

<div class="row">
  	<div class="col-lg-12 mb-4">
	    <div class="card shadow mb-4">
	        <div class="card-header py-3">
	          <h6 class="m-0 font-weight-bold text-primary">DPIA Process Diagram</h6>
	        </div>
	        <div class="card-body">
	          <img style="width:100%;" src="/img/dpiaprocess.png">
	        </div>
	    </div>
    </div>
</div>








