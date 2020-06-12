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

$output = ('class PersonalData <<PersonalData>> {
    category: string
    number: int

}

class DataSubject <<DataSubject>> {
	category: string
	number: string
}

class DataBreach {
}

class SupervisoryAuthorityNotification <<Artifact>> {
	nature_of_breach: bool
	dpo_contact: bool
	consequences: bool
	measures_taken: bool
  personal_data_category: bool
  personal_data_number: bool
  data_subject_category: bool
  data_subject_number: bool
  reasons_for_delay: bool
}

class DataSubjectNotification <<Artifact>> {
  clear_explanation: bool
  dpo_contact: bool
  consequences: bool
  measures_taken: bool
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

DataSubject --|> DataBreach
PersonalData --|> DataBreach
DataBreach -- SupervisoryAuthorityNotification : manifests >
DataBreach -- DataSubjectNotification : manifests >');

$encode = encodep($output);
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Data Breach</h1>
</div>
<div class="row">
  	<div class="col-lg-6 mb-4">
	    <div class="card shadow mb-4">
	        <div class="card-header py-3">
	          <h6 class="m-0 font-weight-bold text-primary">Description</h6>
	        </div>
	        <div class="card-body">
	          <p>In the event of a data breach, the GDPR mandates the preparation and dispersal of notifications to the supervisory authority and the data subject under certain conditions. The notification process diagrams below describe these conditions.</p>
            <p>In the case of the supervisory authority notification, the breach must represent a significant risk to the rights and freedoms of the data subjects. The notification must fulfill the attributes in the modeled artifact in the data breach model. If it has been more than 72 hours since the breach, the notification must contain an explanation providing the reasons for the notification delay as well.</p>
            <p>In the case of the notification to the data subject, the notification must be sent if the implemented technical measures cannot protect the breached personal data and represent a high risk to the rights and freedoms of the data subject. The supervisory authority may be consulted on whether the notification must be prepared as well. If the notification is deemed necessray, it must fulfill the attributes of the modeled artifact in the data breach model.</p>
	        </div>
	    </div>
  	</div>
  	<div class="col-lg-6 mb-4">
	    <div class="card shadow mb-4">
	        <div class="card-header py-3">
	          <h6 class="m-0 font-weight-bold text-primary">Data Breach Model</h6>
	        </div>
	        <div class="card-body">
	          <img style="width:80%;" src=<?php echo "http://www.plantuml.com/plantuml/img/{$encode}"; ?>>
	        </div>
	    </div>
    </div>
</div>

<div class="row">
  	<div class="col-lg-12 mb-4">
	    <div class="card shadow mb-4">
	        <div class="card-header py-3">
	          <h6 class="m-0 font-weight-bold text-primary">Supervisory Authority Notification Process Diagram</h6>
	        </div>
	        <div class="card-body">
	          <img style="width:80%;" src="/img/supervisoryauthoritynotification.png">
	        </div>
	    </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
      <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Subject Notification Process Diagram</h6>
          </div>
          <div class="card-body">
            <img style="width:80%;" src="/img/datasubjectnotification.png">
          </div>
      </div>
    </div>
</div>







