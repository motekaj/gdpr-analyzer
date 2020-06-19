<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

// $this->title = 'dpoe 0.2';
$this->registerJsFile(
    '@web/js/extractiond.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

?>
<div class="row">
  <div class="col-lg-6">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Step 4: Purpose of Processing and Consent</h6>
      </div>
      <div class="card-body">
        <form action="<?php echo Url::to(['site/extractione', 'diagramID' => $diagramID]) ?>" method="POST">
          <div class="form-group">
          <label for="dataCategory" href="#" >Select the category that the personal data falls under:</label>
          <select class="form-control" id="dataCategory" name="data_category">
            <option value="general">General</option>
            <option value="biometric">Biometric</option>
            <option value="genetic">Genetic</option>
            <option value="health">Health</option>
            <option value="ethnic_origin">Ethnic origin</option>
            <option value="racial_origin">Racial origin</option>
            <option value="political_affiliation">Political affiliation</option>
            <option value="philosophical_beliefs">Philosophical beliefs</option>
            <option value="criminal_offense">Criminal offense</option>
            <option value="religion">Religion</option>
            <option value="trade_union_membership">Trade union membership</option>
            <option value="sexual_orientation">Sexual orientation</option>
            <option value="sex_life">Sex life</option>
          </select>
        </div>
        <br>
        <div class="form-group" id="legalGroundContainer">
          <label for="legalGround" href="#" >Select the legal ground under which the personal data is collected:</label>
          <select class="form-control" id="legalGround" name="legal_ground">
            <option value="unspecified">Unspecified</option>
            <option value="consent">Consent</option>
            <option value="contract_performance">Contract performance</option>
            <option value="controller_legal_obligation">Controller legal obligation</option>
            <option value="vital_interest_protection">Vital interest protection</option>
            <option value="public_interest">Public interest</option>
            <option value="legitimate_interest">Legitimate interest</option>
          </select>
        <br>
        </div>
        <div class="form-group" id="legalGroundSpecialCategoryContainer">
          <label for="legalGroundSpecialCategory" href="#" >This is a special category of personal data. Select the legal ground under which the personal data is collected:</label>
          <select class="form-control" id="legalGroundSpecialCategory" name="legal_ground_special_category">
            <option value="unspecified">Unspecified</option>
            <option value="consent">Consent</option>
            <option value="employment_purpose">Employment Purpose</option>
            <option value="social_purpose">Social Purpose</option>
            <option value="vital_interest">Vital Interest</option>
            <option value="non_profit_body">Non Profit Body</option>
            <option value="public_from_subject">Public From Subject</option>
            <option value="legal_claim">Legal Claim</option>
            <option value="substantial_public_interest">Substantial Public Interest</option>
            <option value="preventive_medicine">Preventive Medicine</option>
            <option value="occupational_medicine">Occupational Medicine</option>
            <option value="public_health">Public Health</option>
            <option value="archiving">Archiving</option>
            <option value="statistical_purposes">Statistical Purposes</option>
          </select>
        <br>
        </div>
        <div id="consentWrapper">
	        <div class="form-group">
	            <label for="consent" href="#" >Is the data subject's consent collected prior to the processing tasks performed by the Controller?</label>
	        	<select class="form-control" id="consent" name="consent">
			        <option value="false">No</option>
			        <option value="true">Yes</option>
	        	</select>
	        </div>
        <!-- <div class="form-group"> -->
	          <div class="form-check" id="consentAgreement">
	          <p>Select the characteristics of the consent agreement:</p>
	              <input type="checkbox" class="form-check-input" id="Clear purpose" name="clear_purpose" value="true">
	              <label class="form-check-label" for="Clear purpose">Clear purpose</label><br>
	              <input type="checkbox" class="form-check-input" id="Unambiguous" name="unambiguous" value="true">
	              <label class="form-check-label" for="Unambiguous">Unambiguous</label><br>
	              <input type="checkbox" class="form-check-input" id="Affirmative Action" name="affirmative_action" value="true">
	              <label class="form-check-label" for="Affirmative Action">Affirmative Action</label><br>
	              <input type="checkbox" class="form-check-input" id="Specific" name="specific" value="true">
	              <label class="form-check-label" for="Specific">Specific</label><br>
	              <input type="checkbox" class="form-check-input" id="Distinguishable" name="distinguishable" value="true">
	              <label class="form-check-label" for="Distinguishable">Distinguishable</label><br>
	              <input type="checkbox" class="form-check-input" id="Withdrawable" name="withdrawable" value="true">
	              <label class="form-check-label" for="Withdrawable">Withdrawable</label><br>
	              <input type="checkbox" class="form-check-input" id="Freely Given" name="freely_given" value="true">
	              <label class="form-check-label" for="Freely Given">Freely Given</label><br>
	          </div>
	     </div>
	     <div id="consentNotRequired">
	     	Due to the selected legal ground of processing, consent is not required.
	     </div>
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

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Assigned Data: Processing Task</h6>
      </div>
      <div class="card-body">
        <span class="btn btn-info"><strong><?= $data['processing_task'] ?></strong></span>&nbsp;
      </div>
    </div>
  </div>
</div>