<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

// $this->title = 'dpoe 0.2';
$this->registerJsFile(
    '@web/js/extractione.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

?>
<div class="row">
  <div class="col-lg-6">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Step 5: Processing System and Technical Measures</h6>
      </div>
      <div class="card-body">
        <form action="<?php echo Url::to(['site/summary', 'diagramID' => $diagramID]) ?>" method="POST">
          <div class="form-check">
          <p>Does the processing system have the following security/privacy attributes?</p>
          	<input type="checkbox" class="form-check-input" id="Confidentiality" name="confidentiality" value="true">
			<label class="form-check-label" for="Confidentiality">Confidentiality</label><br>
			<input type="checkbox" class="form-check-input" id="Integrity" name="integrity" value="true">
			<label class="form-check-label" for="Integrity">Integrity</label><br>
			<input type="checkbox" class="form-check-input" id="Availability" name="availability" value="true">
			<label class="form-check-label" for="Availability">Availability</label><br>
			<input type="checkbox" class="form-check-input" id="Resilient" name="resilient" value="true">
			<label class="form-check-label" for="Resilient">Resilient</label><br>
			<input type="checkbox" class="form-check-input" id="Pseudonimity" name="pseudonimity" value="true">
			<label class="form-check-label" for="Pseudonimity">Pseudonimity</label><br>
			<input type="checkbox" class="form-check-input" id="Data Minimization" name="data_minimization" value="true">
			<label class="form-check-label" for="Data Minimization">Data Minimization</label><br>
			<input type="checkbox" class="form-check-input" id="Redundancies" name="redundancies" value="true">
			<label class="form-check-label" for="Redundancies">Redundancies</label><br>
			<input type="checkbox" class="form-check-input" id="Tested" name="tested" value="true">
			<label class="form-check-label" for="Tested">Tested</label><br>
        </div>
        <br>
        <div class="form-check">
          <p>Does the processing system store data and is there a limit on the storage duration?</p>
          	<input type="checkbox" class="form-check-input" id="Data Storage" name="data_storage" value="true">
			<label class="form-check-label" for="Data Storage">Data Storage</label><br>
			<input type="checkbox" class="form-check-input" id="Storage Limited" name="storage_limited" value="true">
			<label class="form-check-label" for="Storage Limited">Storage Limited</label><br>
		</div>
        <br>
        <div class="form-group">
          <label for="dataCategory" href="#" >If there are specific technologies implemented to secure the processing and/or filing system, select them below:</label>
          <select multiple size="6" class="form-control" id="technologies" name="technologies[]">
            <option value="None">None</option>
            <option value="TLS Encryption">TLS Encryption</option>
            <option value="IPSec Encryption">IPSec Encryption</option>
            <option value="E2E Encryption">E2E Encryption</option>
            <option value="PK Encryption">PK Encryption</option>
            <option value="Proxies">Proxies</option>
            <option value="VPN">VPN</option>
            <option value="2FA">2FA</option>
            <option value="User Login">User Login</option>
            <option value="Homomorphic Encryption">Homomorphic Encryption</option>
            <option value="Secure MPC">Secure Multiparty Computation</option>
            <option value="Differential Privacy">Differential Privacy</option>
            <option value="Anonymization">Anonymization</option>
          </select>
        </div>
        <br>

        <div class="form-group">
            <label for="ismsStandard" href="#" >Does the controller implement organizational measures such as adherence to a security/privacy standard (eg. ISO27701)? </label>
          <select class="form-control" id="ismsStandard" name="isms_standard">
            <option value="">No</option>
            <option value="true">Yes</option>
          </select>
        </div>

        <div class="form-group">
            <label for="processingLog" href="#" >Is a record of processing maintained?</label>
        	<select class="form-control" id="processingLog" name="processing_log">
		        <option value="">No</option>
		        <option value="true">Yes</option>
        	</select>
        </div>
		<div class="form-check" id="logAttributes">
		<p>Check whether the record of processing has the following attributes:</p>
			<input type="checkbox" class="form-check-input" id="Name" name="name" value="true">
			<label class="form-check-label" for="Name">Name</label><br>
      <input type="checkbox" class="form-check-input" id="Purpose" name="purpose" value="true">
      <label class="form-check-label" for="Purpose">Purpose</label><br>
			<input type="checkbox" class="form-check-input" id="Contact Details" name="contact_details" value="true">
			<label class="form-check-label" for="Contact Details">Contact Details</label><br>
			<input type="checkbox" class="form-check-input" id="Personal Data Category" name="personal_data_category" value="true">
			<label class="form-check-label" for="Personal Data Category">Personal Data Category</label><br>
			<input type="checkbox" class="form-check-input" id="Data Storage Period" name="data_storage_period" value="true">
			<label class="form-check-label" for="Data Storage Period">Data Storage Period</label><br>
			<input type="checkbox" class="form-check-input" id="Security Measures" name="security_measures" value="true">
			<label class="form-check-label" for="Security Measures">Security Measures</label><br>
      <input type="checkbox" class="form-check-input" id="Third Countries Transfer" name="third_countries_transfer" value="true">
      <label class="form-check-label" for="Third Countries Transfer">Third Countries Transfer</label><br>
			<input type="checkbox" class="form-check-input" id="Recipients" name="recipients" value="true">
			<label class="form-check-label" for="Recipients">Recipients</label><br>
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

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Assigned Data: Data Category</h6>
      </div>
      <div class="card-body">
        <span class="btn btn-info"><strong><?= $data['data_category'] ?></strong></span>&nbsp;
      </div>
    </div>
  </div>
</div>