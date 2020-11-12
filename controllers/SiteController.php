<?php

namespace app\controllers;

use Yii;
use app\models\BPMNDiagram;
use yii\web\Controller;
use yii\web\UploadedFile;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $model = new BPMNDiagram();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $diagramID   = $model->upload();

            if ($diagramID) {
                return $this->redirect(['extractiona', 'diagramID' => $diagramID['id']]);
            }
        }
        return $this->render('index', ['model' => $model]);
    }

    public function actionGdprbpmn()
    {

        $model = new BPMNDiagram();
        

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $diagramID   = $model->upload();

            $connection = Yii::$app->db;

            $filename = $connection->createCommand('SELECT filename FROM bpmn_models WHERE id=:id')
                ->bindValue(':id', $diagramID['id'])
                ->queryOne();

            $xml = simplexml_load_file('uploads/' . $filename['filename']);


            if ($diagramID) {
                $data = Yii::$app->BPMNParser->parseGdprbpmn($xml);

                // return $this->render('gdprbpmnsummary', ['data' => $data, 'diagramID' => $diagramID]);
                return $this->redirect(['gdprbpmnsummary', 'diagramName' => $filename['filename'], 'diagramID' => $diagramID['id']]);
            }
        }
        return $this->render('gdprbpmn', ['model' => $model]);
    }

    public function actionGdprbpmnsummary($diagramName, $diagramID)
    {

        $xml = simplexml_load_file('uploads/' . $diagramName);
        // print_r($xml);
        // die();
        $data = Yii::$app->BPMNParser->parseGdprbpmn($xml);

        return $this->render('gdprbpmnsummary', ['data' => $data, 'diagramID' => $diagramID]);
    }

    public function actionDpia()
    {
        return $this->render('dpia');
    }

    public function actionBreach()
    {
        return $this->render('breach');
    }

    //forma formb etc refer to inputs of the forms
    //data refers to the results of the query needed for that view
    public function actionExtractiona($diagramID)
    {
        $connection = Yii::$app->db;

        $filename = $connection->createCommand('SELECT filename FROM bpmn_models WHERE id=:id')
            ->bindValue(':id', $diagramID)
            ->queryOne();
        $xml = simplexml_load_file('uploads/' . $filename['filename']);

        $connection->createCommand('INSERT INTO model_info (model_ref) VALUES (:diagramID) ON DUPLICATE KEY UPDATE model_ref=:diagramID')
            ->bindValue(':diagramID', $diagramID)
            ->execute();

        $participants = Yii::$app->BPMNParser->getParticipants($xml);
        return $this->render('extractiona', ['data' => $participants, 'diagramID' => $diagramID]);
    }

    public function actionExtractionb($diagramID)
    {
        $forma  = Yii::$app->request->post();
        $params = [];
        if (array_key_exists('data_subject', $forma)) {$params[':dataSubject'] = $forma['data_subject'];} else { $params[':dataSubject'] = null;};
        if (array_key_exists('controller', $forma)) {$params[':controller'] = $forma['controller'];} else { $params[':controller'] = null;};
        if (array_key_exists('processor', $forma)) {$params[':processor'] = $forma['processor'];if ($params[':processor'] == "None") {$params[':processor'] = null;}} else { $params[':processor'] = null;};
        if (array_key_exists('recipient', $forma)) {$params[':recipient'] = $forma['recipient'];if ($params[':recipient'] == "None") {$params[':recipient'] = null;}} else { $params[':recipient'] = null;};
        if (array_key_exists('third_party', $forma)) {$params[':thirdParty'] = $forma['third_party'];if ($params[':thirdParty'] == "None") {$params[':thirdParty'] = null;}} else { $params[':thirdParty'] = null;};
        $params[':diagramID'] = $diagramID;

        $connection = Yii::$app->db;
        $connection->createCommand('UPDATE model_info SET data_subject=:dataSubject, controller=:controller, processor=:processor, recipient=:recipient, third_party=:thirdParty WHERE model_ref=:diagramID')
            ->bindValues($params)
            ->execute();

        $filename = $connection->createCommand('SELECT filename FROM bpmn_models WHERE id=:diagramID')
            ->bindValue(':diagramID', $diagramID)
            ->queryOne();
        $filename = array_shift($filename);

        $xml = simplexml_load_file('uploads/' . $filename);

        $data = Yii::$app->BPMNParser->getControllerDataObjects($forma['controller'], $xml);

        $roles = $connection->createCommand('SELECT * FROM model_info WHERE model_ref=:diagramID')
            ->bindValue(':diagramID', $diagramID)
            ->queryOne();

        //add processingtask ER  logic here and update same view 20.3.2020

        return $this->render('extractionb', ['data' => $data, 'roles' => $roles, 'diagramID' => $forma['diagramID']]);
    }

    public function actionExtractionc($diagramID)
    {
        $formb = Yii::$app->request->post();

        $params = [
            ':personalData' => $formb['personalData'],
            ':diagramID'    => $diagramID,
        ];

        $connection = Yii::$app->db;
        $connection->createCommand('UPDATE model_info SET personal_data=:personalData WHERE model_ref=:diagramID')
            ->bindValues($params)
            ->execute();

        $filename = $connection->createCommand('SELECT filename FROM bpmn_models WHERE id=:diagramID')
            ->bindValue(':diagramID', $diagramID)
            ->queryOne();

        $filename = array_shift($filename);
        $xml      = simplexml_load_file('uploads/' . $filename);

        //get data (roles+personaldata) from db

        $data = $connection->createCommand('SELECT data_subject, controller, processor, recipient, third_party, personal_data FROM model_info WHERE model_ref=:diagramID')
            ->bindValue(':diagramID', $diagramID)
            ->queryOne();

        //get processing task from xml
        $processingTasks = Yii::$app->BPMNParser->getControllerTasks($data['controller'], $xml);

        return $this->render('extractionc', ['data' => $data, 'processingTasks' => $processingTasks, 'diagramID' => $diagramID]);
    }

    public function actionExtractiond($diagramID)
    {
        $formc = Yii::$app->request->post();

        $params = [
            ':processingTask' => $formc['processingTask'],
            ':diagramID'      => $diagramID,
        ];

        $connection = Yii::$app->db;
        $connection->createCommand('UPDATE model_info SET processing_task=:processingTask WHERE model_ref=:diagramID')
            ->bindValues($params)
            ->execute();

        $data = $connection->createCommand('SELECT data_subject, controller, processor, recipient, third_party, personal_data, processing_task FROM model_info WHERE model_ref=:diagramID')
            ->bindValue(':diagramID', $diagramID)
            ->queryOne();

        return $this->render('extractiond', ['data' => $data, 'diagramID' => $diagramID]);
    }

    public function actionExtractione($diagramID)
    {
        $formd = Yii::$app->request->post();

        $params                    = [];
        $params[':dataCategory']   = $formd['data_category'];
        $params[':legalGround']        = $formd['legal_ground'];
        $params[':legalGroundSpecialCategory'] = $formd['legal_ground_special_category'];
        $params[':consent']        = $formd['consent'];
        $params[':privacyPolicy']        = $formd['privacy_policy'];

        if (array_key_exists('clear_purpose', $formd)) {$params[':clearPurpose'] = $formd['clear_purpose'];} else { $params[':clearPurpose'] = null;};
        if (array_key_exists('unambiguous', $formd)) {$params[':unambiguous'] = $formd['unambiguous'];} else { $params[':unambiguous'] = null;};
        if (array_key_exists('affirmative_action', $formd)) {$params[':affirmativeAction'] = $formd['affirmative_action'];} else { $params[':affirmativeAction'] = null;};
        if (array_key_exists('distinguishable', $formd)) {$params[':distinguishable'] = $formd['distinguishable'];} else { $params[':distinguishable'] = null;};
        if (array_key_exists('specific', $formd)) {$params[':specific'] = $formd['specific'];} else { $params[':specific'] = null;};
        if (array_key_exists('withdrawable', $formd)) {$params[':withdrawable'] = $formd['withdrawable'];} else { $params[':withdrawable'] = null;};
        if (array_key_exists('freely_given', $formd)) {$params[':freelyGiven'] = $formd['freely_given'];} else { $params[':freelyGiven'] = null;};
        if (array_key_exists('controller_contact_info', $formd)) {$params[':controllerContactInfo'] = $formd['controller_contact_info'];} else { $params[':controllerContactInfo'] = null;};
        if (array_key_exists('dpo_contact_info', $formd)) {$params[':dpoContactInfo'] = $formd['dpo_contact_info'];} else { $params[':dpoContactInfo'] = null;};
        if (array_key_exists('purpose_of_processing', $formd)) {$params[':purposeOfProcessing'] = $formd['purpose_of_processing'];} else { $params[':purposeOfProcessing'] = null;};
        if (array_key_exists('legal_basis', $formd)) {$params[':legalBasis'] = $formd['legal_basis'];} else { $params[':legalBasis'] = null;};
        if (array_key_exists('data_recipients', $formd)) {$params[':dataRecipients'] = $formd['data_recipients'];} else { $params[':dataRecipients'] = null;};
        if (array_key_exists('storage_period', $formd)) {$params[':storagePeriod'] = $formd['storage_period'];} else { $params[':storagePeriod'] = null;};
        if (array_key_exists('right_to_access', $formd)) {$params[':rightToAccess'] = $formd['right_to_access'];} else { $params[':rightToAccess'] = null;};
        if (array_key_exists('right_to_rectify', $formd)) {$params[':rightToRectify'] = $formd['right_to_rectify'];} else { $params[':rightToRectify'] = null;};
        if (array_key_exists('right_to_erasure', $formd)) {$params[':rightToErasure'] = $formd['right_to_erasure'];} else { $params[':rightToErasure'] = null;};
        if (array_key_exists('right_to_portability', $formd)) {$params[':rightToPortability'] = $formd['right_to_portability'];} else { $params[':rightToPortability'] = null;};
        if (array_key_exists('right_to_withdraw_consent', $formd)) {$params[':rightToWithdrawConsent'] = $formd['right_to_withdraw_consent'];} else { $params[':rightToWithdrawConsent'] = null;};
        if (array_key_exists('right_to_lodge_complaint', $formd)) {$params[':rightToLodgeComplaint'] = $formd['right_to_lodge_complaint'];} else { $params[':rightToLodgeComplaint'] = null;};
        if (array_key_exists('automated_decision_making', $formd)) {$params[':automatedDecisionMaking'] = $formd['automated_decision_making'];} else { $params[':automatedDecisionMaking'] = null;};

        $params[':diagramID'] = $diagramID;

        $connection = Yii::$app->db;
        $connection->createCommand('UPDATE model_info SET data_category=:dataCategory, legal_ground=:legalGround, legal_ground_special_category=:legalGroundSpecialCategory, consent=:consent, clear_purpose=:clearPurpose, unambiguous=:unambiguous, affirmative_action=:affirmativeAction, distinguishable=:distinguishable, `specific`=:specific, withdrawable=:withdrawable, freely_given=:freelyGiven, privacy_policy=:privacyPolicy, controller_contact_info=:controllerContactInfo, dpo_contact_info=:dpoContactInfo, purpose_of_processing=:purposeOfProcessing, legal_basis=:legalBasis, data_recipients=:dataRecipients, storage_period=:storagePeriod, right_to_access=:rightToAccess, right_to_rectify=:rightToRectify, right_to_erasure=:rightToErasure, right_to_portability=:rightToPortability, right_to_withdraw_consent=:rightToWithdrawConsent, right_to_lodge_complaint=:rightToLodgeComplaint, automated_decision_making=:automatedDecisionMaking WHERE model_ref=:diagramID')
            ->bindValues($params)
            ->execute();

        $data = $connection->createCommand('SELECT data_subject, controller, processor, recipient, third_party, personal_data, processing_task, data_category FROM model_info WHERE model_ref=:diagramID')
            ->bindValue(':diagramID', $diagramID)
            ->queryOne();

        return $this->render('extractione', ['data' => $data, 'diagramID' => $diagramID]);
    }

    public function actionSummary($diagramID)
    {
        $forme = Yii::$app->request->post();

        $params = [];

        if (array_key_exists('confidentiality', $forme)) {$params[':confidentiality'] = $forme['confidentiality'];} else { $params[':confidentiality'] = null;};
        if (array_key_exists('integrity', $forme)) {$params[':integrity'] = $forme['integrity'];} else { $params[':integrity'] = null;};
        if (array_key_exists('availability', $forme)) {$params[':availability'] = $forme['availability'];} else { $params[':availability'] = null;};
        if (array_key_exists('resilient', $forme)) {$params[':resilient'] = $forme['resilient'];} else { $params[':resilient'] = null;};
        if (array_key_exists('pseudonimity', $forme)) {$params[':pseudonimity'] = $forme['pseudonimity'];} else { $params[':pseudonimity'] = null;};
        if (array_key_exists('data_minimization', $forme)) {$params[':dataMinimization'] = $forme['data_minimization'];} else { $params[':dataMinimization'] = null;};
        if (array_key_exists('redundancies', $forme)) {$params[':redundancies'] = $forme['redundancies'];} else { $params[':redundancies'] = null;};
        if (array_key_exists('tested', $forme)) {$params[':tested'] = $forme['tested'];} else { $params[':tested'] = null;};
        if (array_key_exists('data_storage', $forme)) {$params[':dataStorage'] = $forme['data_storage'];} else { $params[':dataStorage'] = null;};
        if (array_key_exists('storage_limited', $forme)) {$params[':storageLimited'] = $forme['storage_limited'];} else { $params[':storageLimited'] = null;};
        if (array_key_exists('technologies', $forme)) {$params[':technologies'] = implode(',', $forme['technologies']);if ($params[':technologies'] == "None") {$params[':technologies'] = null;}} else { $params[':technologies'] = null;};
        if (array_key_exists('isms_standard', $forme)) {$params[':ismsStandard'] = $forme['isms_standard'];} else { $params[':ismsStandard'] = null;};
        if (array_key_exists('processing_log', $forme)) {$params[':processingLog'] = $forme['processing_log'];} else { $params[':processingLog'] = null;};
        if (array_key_exists('name', $forme)) {$params[':name'] = $forme['name'];} else { $params[':name'] = null;};
        if (array_key_exists('purpose', $forme)) {$params[':purpose'] = $forme['purpose'];} else { $params[':purpose'] = null;};
        if (array_key_exists('contact_details', $forme)) {$params[':contactDetails'] = $forme['contact_details'];} else { $params[':contactDetails'] = null;};
        if (array_key_exists('personal_data_category', $forme)) {$params[':personalDataCategory'] = $forme['personal_data_category'];} else { $params[':personalDataCategory'] = null;};
        if (array_key_exists('data_storage_period', $forme)) {$params[':dataStoragePeriod'] = $forme['data_storage_period'];} else { $params[':dataStoragePeriod'] = null;};
        if (array_key_exists('security_measures', $forme)) {$params[':securityMeasures'] = $forme['security_measures'];} else { $params[':securityMeasures'] = null;};
        if (array_key_exists('third_countries_transfer', $forme)) {$params[':thirdCountriesTransfer'] = $forme['third_countries_transfer'];} else { $params[':thirdCountriesTransfer'] = null;};
        if (array_key_exists('recipients', $forme)) {$params[':recipients'] = $forme['recipients'];} else { $params[':recipients'] = null;};
        $params[':diagramID'] = $diagramID;

        $connection = Yii::$app->db;
        $connection->createCommand('UPDATE model_info SET confidentiality=:confidentiality, integrity=:integrity, availability=:availability, resilient=:resilient, pseudonimity=:pseudonimity, data_minimization=:dataMinimization, redundancies=:redundancies, tested=:tested, data_storage=:dataStorage, storage_limited=:storageLimited, technologies=:technologies, isms_standard=:ismsStandard, processing_log=:processingLog, name=:name, purpose=:purpose, contact_details=:contactDetails, personal_data_category=:personalDataCategory, data_storage_period=:dataStoragePeriod, security_measures=:securityMeasures, third_countries_transfer=:thirdCountriesTransfer, recipients=:recipients WHERE model_ref=:diagramID')
            ->bindValues($params)
            ->execute();

        $data = $connection->createCommand('SELECT * FROM model_info WHERE model_ref=:diagramID')
            ->bindValue(':diagramID', $diagramID)
            ->queryOne();

        return $this->render('summary', ['data' => $data, 'diagramID' => $diagramID]);

    }

    public function actionPuml($output) {
        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=plantuml.txt");
        return $output;
    }


}
