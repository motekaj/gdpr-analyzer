<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

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



$controller = "class " . str_replace(' ', '', $data['controller']) . " <<Controller>> { \n }";
$dataSubject = "class " . str_replace(' ', '', $data['data_subject']) . " <<DataSubject>> { \n }";
$processor = "";
$errors = "";

if($data['processor']) { 
	$processor = "class " . str_replace(' ', '', $data['processor']) . " <<Processor>> { \n }";
} else { 
	$processor = "class Processor <<NotRequired>>";
};

$recipient = "";

if($data['recipient']) { 
	$recipient = "class " . str_replace(' ', '', $data['recipient']) . " <<Recipient>> { \n }";
} else { 
	$recipient = "class Recipient <<NotRequired>> { \n }";
};

$thirdParty = "";

if($data['third_party']) { 
	$thirdParty = "class " . str_replace(' ', '', $data['third_party']) . " <<ThirdParty>> { \n }";
} else { 
	$thirdParty = "class ThirdParty <<NotRequired>> { \n }";
};

$personalData = "";

if($data['personal_data']) { 
	$personalData = "class " . $data['personal_data'] . " <<PersonalData>> { \n 
		category: " . $data['data_category'] . "\n}";
} else { 
	$personalData = "class PersonalData <<MissingClass>> { \n }";
};

$specialPurpose = "";

if($data['data_category'] == "general") {
	$specialPurpose = "class SpecialPurpose <<NotRequired>> {
	unspecified: false
	employment_purpose: false
	social_purpose: false
	vital_interest: false
	nonprofit_body: false
	public_from_subject: false
	legal_claim: false
	substantial_public_interest: false
	preventive_medicine: false
	occupational_medicine: false
	public_health: false
	archiving: false
	statistical_purposes: false
	}";
} else {
	$specialPurpose = "class SpecialPurpose { \n" . $data['special_purpose'] . ": true \n }";
};

$purpose = "";

if($data['purpose'] == "unspecified") {
	$purpose = "class Purpose {
	  unspecified: true
	  contract_performance: false
	  controller_legal_obligation: false
	  vital_interest_protection: false
	  public_interest: false
	  legitimate_interest: false
	}";
} else {
	$purpose = "class Purpose { \n" . $data['purpose'] . ": true \n }";
};

$consent = "";
$consentAgreement = "";

if (($data['data_category'] !== "unspecified" && $data['special_purpose'] !== "unspecified") || ($data['purpose'] !== "unspecified")) {
	$consent = "class Consent <<NotRequired>> {}";
	$consentAgreement = "class ConsentAgreement <<NotRequired>> {}";
} else {
	if($data['consent'] == "false") {
		$errors = $errors . "\n note top of ConsentAgreement #salmon: Consent agreement is missing [Art. 7]\n";
		$errors = $errors . "\n note top of Consent #salmon: Data subject consent is missing [Art. 7] \n";
		$consent = "class Consent <<MissingClass>> {}";
		$consentAgreement = "class ConsentAgreement <<MissingArtifact>> {
		  clear_purpose: 
		  unambiguous: 
		  affirmative_action: 
		  distinguishable: 
		  specific: 
		  withdrawable: 
		  freely_given: 
		}";
	} else {
		$consent = "class Consent {}";
		$consentAgreement = "class ConsentAgreement <<Artifact>> { \n" .
		  "clear_purpose: " . $data['clear_purpose'] . "\n" . 
		  "unambiguous: " . $data['unambiguous'] . "\n" . 
		  "affirmative_action: " . $data['affirmative_action'] . "\n" . 
		  "distinguishable: " . $data['distinguishable'] . "\n" . 
		  "specific: " . $data['specific'] . "\n" . 
		  "withdrawable: " . $data['withdrawable'] . "\n" . 
		  "freely_given: " . $data['freely_given'] . "\n" . 
		"}";

		if($data['clear_purpose'] !== "true" ||
			$data['unambiguous'] !== "true" ||
			$data['affirmative_action'] !== "true" ||
			$data['distinguishable'] !== "true" ||
			$data["specific"] !== "true" ||
			$data['withdrawable'] !== "true" ||
			$data['freely_given'] !== "true") {
			$errors = $errors . "\n note top of ConsentAgreement #salmon: Consent agreement has missing attributes \n";
		}
	}
}

$filingSystem = "";

if($data['data_storage'] !== "true") {
	$filingSystem = "class FilingSystem <<NotRequired>> {
  		data_storage: false
  		storage_limited: false
	}";
} else {
	$filingSystem = "class FilingSystem {
  		data_storage: true
  		storage_limited: " . $data['storage_limited'] . "\n }";
  	if($data['storage_limited'] !== "true") {
  		$errors = $errors . "\n note top of FilingSystem #salmon: Filing System does not limit storage [Art. 5(e)] \n";
  	}
}

$technicalMeasures = "";

if($data['technical_measures'] == NULL) {
	$technicalMeasures = "class TechnicalMeasures <<MissingClass>> {
  		technologies:
	}";

	$errors = $errors . "\n note top of TechnicalMeasures #salmon: No technical measures present [Art. 25] \n";
} else {
	$technicalMeasures = "class TechnicalMeasures {
  		technologies: " . $data['technical_measures'] . "\n }";
};


$processingSystem = "class ProcessingSystem { \n" .
		  "confidentiality:" . $data['confidentiality'] . "\n" . 
		  "integrity:" . $data['integrity'] . "\n" . 
		  "availability:" . $data['availability'] . "\n" . 
		  "resilient:" . $data['resilient'] . "\n" . 
		  "pseudonimity:" . $data['pseudonimity'] . "\n" . 
		  "data_minimization:" . $data['data_minimization'] . "\n" . 
		  "redundancies:" . $data['redundancies'] . "\n" . 
		  "tested:" . $data['tested'] . "\n" . 
		"}";

if($data['confidentiality'] !== "true" ||
	$data['integrity'] !== "true" ||
	$data['availability'] !== "true" ||
	$data['resilient'] !== "true" ||
	$data["pseudonimity"] !== "true" ||
	$data["data_minimization"] !== "true" ||
	$data['redundancies'] !== "true" ||
	$data['tested'] !== "true") {
	$errors = $errors . "\n note top of ProcessingSystem #salmon: Processing system has missing attributes [Art. 32]\n";
}

$processingTask = "";

if ($data['processing_log'] !== "true") {
	$processingTask = "class " . $data['processing_task'] . " <<ProcessingTask>> {
		logged: false
	}";
	$errors = $errors . "\n note top of " . $data['processing_task'] . " #salmon: Processing task is not being recorded [Art. 30] \n";
} else {
	$processingTask = "class " . $data['processing_task'] . " <<ProcessingTask>> {
		logged: true
	}";
};

$processingLog = "";

if ($data['processing_log'] !== "true") {
	$processingLog = "class ProcessingLog <<MissingArtifact>> {
		name: 
		contact_details:
		personal_data_category:
		data_storage_period:
		technical_safeguards:
		recipients:
	}";

	$errors = $errors . "\n note top of ProcessingLog #salmon: Record of processing is missing [Art. 30] \n";
} else {
	$processingLog = "class ProcessingLog <<Artifact>> { \n" .
		  "name: " . $data['name'] . "\n" . 
		  "contact_details: " . $data['contact_details'] . "\n" . 
		  "personal_data_category: " . $data['personal_data_category'] . "\n" . 
		  "data_storage_period: " . $data['data_storage_period'] . "\n" . 
		  "technical_safeguards: " . $data['technical_safeguards'] . "\n" . 
		  "recipients: " . $data['recipients'] . "\n" . 
		"}";

	if($data['name'] !== "true" ||
		$data['contact_details'] !== "true" ||
		$data['personal_data_category'] !== "true" ||
		$data['data_storage_period'] !== "true" ||
		$data["technical_safeguards"] !== "true" ||
		$data["recipients"] !== "true") {
	$errors = $errors . "\n note top of ProcessingLog #salmon: Record of processing has missing attributes [Art. 30] \n";
}
}

$associations = "PersonalData -- Consent : requires >
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
TechnicalMeasures -- ProcessingSystem : secures >";


$associations = str_replace("Controller", str_replace(' ', '', $data['controller']), $associations);
$associations = str_replace("DataSubject", str_replace(' ', '', $data['data_subject']), $associations);
if ($data['processor']) { $associations = str_replace("Processor", str_replace(' ', '', $data['processor']), $associations); };
if ($data['recipient']) { $associations = str_replace("Recipient", str_replace(' ', '', $data['recipient']), $associations); };
if ($data['third_party']) { $associations = str_replace("ThirdParty", str_replace(' ', '', $data['third_party']), $associations); };
if ($data['personal_data']) { $associations = str_replace("PersonalData", $data['personal_data'], $associations); };
if ($data['processing_task']) { $associations = str_replace("ProcessingTask", $data['processing_task'], $associations); };

$skinparams = "skinparam class {
  BackgroundColor<<Artifact>> PaleGreen
  BorderColor<<Artifact>> SpringGreen
  BackGroundColor<<NotRequired>> White
  BorderColor<<NotRequired>> DarkGray
  AttributeFontColor<<NotRequired>> LightGray
  BorderColor<<MissingClass>> Red
  BackgroundColor<<MissingArtifact>> PaleGreen
  BorderColor<<MissingArtifact>> Red
}";


$output = $controller . 
"\n" . $dataSubject . 
"\n" . $processor  . 
"\n" . $recipient  . 
"\n" . $thirdParty  . 
"\n" . $personalData  . 
"\n" . $specialPurpose  . 
"\n" . $purpose  . 
"\n" . $consent  . 
"\n" . $consentAgreement  . 
"\n" . $filingSystem  . 
"\n" . $technicalMeasures  . 
"\n" . $processingSystem  . 
"\n" . $processingTask  . 
"\n" . $processingLog  . 
"\n" . $associations . 
"\n" . $skinparams .
"\n" . $errors;

$encode = encodep($output);

// echo '<pre>';
// print_r(htmlentities($output));
// echo '</pre>';
// die();

// echo '<pre>';
// print_r($data);
// echo '</pre>';
// die();
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Summary</h1>
</div>
<div class="row">
  	<div class="col-lg-12 mb-4">
	    <div class="card shadow mb-4">
	        <div class="card-header py-3">
	          <h6 class="m-0 font-weight-bold text-primary">Instantiated GDPR Model</h6>
	        </div>
	        <div class="card-body">
	          <img style="max-width: 100%;" src=<?php echo "http://www.plantuml.com/plantuml/img/{$encode}"; ?>>
	        </div>
	    </div>
    </div>
</div>