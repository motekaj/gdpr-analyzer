<?php

namespace app\components;

use yii\base\Component;

class BPMNParser extends Component
{
    public $taskData;
    public $participantList;

    public function getParticipants($xml)
    {
        $this->registerBPMNNS($xml);
        $query     = '//bpmn:collaboration/bpmn:participant[@*]';
        $simpleXML = $this->getXMLAttributes($query, $xml);

        $participants = [];

        foreach ($simpleXML as $key => $value) {
            $participantID   = $simpleXML[$key]['@attributes']['id'];
            $participantName = $simpleXML[$key]['@attributes']['name'];
            array_push($participants, ['id' => $participantID, 'name' => $participantName]);
        }

        return $participants;
    }

    public function getControllerDataObjects($name, $xml)
    {
        $dataSubjectElement = $xml->xpath('//bpmn:participant[@name=' . '"' . $name . '"' . ']');
        $dataSubjectElement = $this->convertSimpleXMLArrayToArray($dataSubjectElement);

        $processRef = $dataSubjectElement[0]['@attributes']['processRef'];

        $inputDataObjectRefs = $xml->xpath('//bpmn:process[@id=' . '"' . $processRef . '"' . ']/bpmn:task/bpmn:dataInputAssociation/bpmn:sourceRef');
        $inputDataObjectRefs = $this->convertSimpleXMLArrayToArray($inputDataObjectRefs);

        $controllerDataObjects = [];
        $dataObjectNames       = [];

        foreach ($inputDataObjectRefs as $key => $value) {
            $dataObjectName = $xml->xpath('//bpmn:dataObjectReference[@id=' . '"' . $value[0] . '"' . ']');

            if ($dataObjectName) {
                $dataObjectName = (array) $dataObjectName[0];
                $dataObjectName = $dataObjectName['@attributes']['name'];

                array_push($dataObjectNames, $dataObjectName);
            }
        }

        return $dataObjectNames;
    }

    public function getControllerTasks($controller, $xml)
    {
        $controllerProcessRef = $xml->xpath('//bpmn:participant[@name=' . '"' . $controller . '"' . ']');
        $controllerProcessRef = (array) $controllerProcessRef[0];
        $controllerProcessRef = $controllerProcessRef['@attributes']['processRef'];

        $processingTasksSimpleXML = $xml->xpath('//bpmn:process[@id=' . '"' . $controllerProcessRef . '"' . ']/bpmn:task/@name');
        $processingTasksArray     = [];

        foreach ($processingTasksSimpleXML as $task => $value) {
            $value = (array) $value;
            array_push($processingTasksArray, $value['@attributes']['name']);
        }

        return $processingTasksArray;
    }

    public function registerBPMNNS($xml)
    {
        $ns = $xml->getNamespaces(1);

        foreach ($ns as $ns => $uri) {
            $xml->registerXPathNamespace($ns, $uri);
        }

        return $xml;
    }

    public function getXMLAttributes($query, $xml)
    {

        $arr = $xml->xpath($query); //Array of simplexmlelement objects
        $arr = $this->convertSimpleXMLArrayToArray($arr);

        return $arr;
    }

    //find the processRef of a participant by its name
    public function getProcessRef($participantName, $participants)
    {
        foreach ($participants as $key => $value) {
            if ($value['@attributes']['name'] == $participantName) {
                return $value['@attributes']['processRef'];
            }
        }
    }

    //find all tasks in a process
    public function getProcessTasks($processRef, $xml)
    {

        //$tasks is array of simpleXML objects with @attributes => task_name and ID
        $taskAttributes = $xml->xpath('//bpmn:process[@id = ' . '"' . $processRef . '"' . ']/bpmn:task');
        $taskAttributes = $this->convertSimpleXMLArrayToArray($taskAttributes);

        $taskNames = [];

        foreach ($taskAttributes as $key => $value) {
            $taskNames[$value['@attributes']['name']] = $value['@attributes']['id'];
        }

        return $taskNames;
    }

    public function convertSimpleXMLArrayToArray($simplexmlarr)
    {
        $count = count($simplexmlarr);

        for ($i = 0; $i <= $count - 1; $i++) {
            $simplexmlarr[$i] = (array) $simplexmlarr[$i];
        }

        return $simplexmlarr;
    }

    public function getInputDataArtifacts($taskID, $xml)
    {
        $inputs = $xml->xpath('//bpmn:task[@id=' . '"' . $taskID . '"]/bpmn:dataInputAssociation/bpmn:sourceRef/text()');
        $inputs = $this->convertSimpleXMLArrayToArray($inputs);

        //Flatten Array
        $inputDataArtifacts = [];
        foreach ($inputs as $key => $value) {
            $name = $xml->xpath('//bpmn:*[@id=' . '"' . $value[0] . '"' . ']')[0]['name']->__toString();

            array_push($inputDataArtifacts, $name);
        }

        return $inputDataArtifacts;
    }

    public function getOutputDataArtifacts($taskID, $xml)
    {
        $outputs = $xml->xpath('//bpmn:task[@id=' . '"' . $taskID . '"]/bpmn:dataOutputAssociation/bpmn:targetRef/text()');
        $outputs = $this->convertSimpleXMLArrayToArray($outputs);

        //Flatten Array
        $outputDataArtifacts = [];
        foreach ($outputs as $key => $value) {
            $name = $xml->xpath('//bpmn:*[@id=' . '"' . $value[0] . '"' . ']')[0]['name']->__toString();

            array_push($outputDataArtifacts, $name);
        }

        return $outputDataArtifacts;
    }

    public function parseGdprbpmn($xml)
    {
        $this->registerBPMNNS($xml);
        $data = [
            "data_subject" => NULL,
            "controller" => NULL,
            "processor" => NULL,
            "recipient" => NULL,
            "third_party" => NULL,
            "model_ref" => NULL,
            "personal_data" => NULL,
            "processing_task" => NULL,
            "data_category" => NULL,
            "legal_ground" => NULL,
            "legal_ground_special_category" => NULL,
            "consent" => NULL,
            "clear_purpose" => NULL,
            "unambiguous" => NULL,
            "affirmative_action" => NULL,
            "distinguishable" => NULL,
            "specific" => NULL,
            "withdrawable" => NULL,
            "freely_given" => NULL,
            "privacy_policy" => NULL,
            "controller_contact_info" => NULL,
            "dpo_contact_info" => NULL,
            "purpose_of_processing" => NULL,
            "legal_basis" => NULL,
            "data_recipients" => NULL,
            "storage_period" => NULL,
            "right_to_access" => NULL,
            "right_to_rectify" => NULL,
            "right_to_erasure" => NULL,
            "right_to_portability" => NULL,
            "right_to_withdraw_consent" => NULL,
            "right_to_lodge_complaint" => NULL,
            "automated_decision_making" => NULL,
            "confidentiality" => NULL,
            "integrity" => NULL,
            "availability" => NULL,
            "resilient" => NULL,
            "pseudonimity" => NULL,
            "data_minimization" => NULL,
            "redundancies" => NULL,
            "tested" => NULL,
            "data_storage" => NULL,
            "storage_limited" => NULL,
            "technologies" => NULL,
            "isms_standard" => NULL,
            "processing_log" => NULL,
            "name" => NULL,
            "purpose" => NULL,
            "contact_details" => NULL,
            "personal_data_category" => NULL,
            "data_storage_period" => NULL,
            "security_measures" => NULL,
            "third_countries_transfer" => NULL,
            "recipients" => NULL,
        ];


        $participants  = $this->getParticipants($xml);
        $controllerID  = '';
        $dataSubjectID = '';

        foreach ($participants as $key => $value) {
            if (preg_match('/\[Controller\]/i', $value['name'], $match)) {
                if (preg_match('/[^\[]*/i', $value['name'], $match)) {
                    $data['controller'] = $match[0];
                    $controllerID       = $value['id'];
                }
            }

            if (preg_match('/\[Processor\]/i', $value['name'], $match)) {
                if (preg_match('/[^\[]*/i', $value['name'], $match)) {
                    $data['processor'] = $match[0];
                }
            }

            if (preg_match('/\[Recipient\]/i', $value['name'], $match)) {
                if (preg_match('/[^\[]*/i', $value['name'], $match)) {
                    $data['recipient'] = $match[0];
                }
            }

            if (preg_match('/\[ThirdParty\]/i', $value['name'], $match)) {
                if (preg_match('/[^\[]*/i', $value['name'], $match)) {
                    $data['third_party'] = $match[0];
                }
            }

            if (preg_match('/\[DataSubject\]/i', $value['name'], $match)) {
                if (preg_match('/[^\[]*/i', $value['name'], $match)) {
                    $data['data_subject'] = $match[0];
                    $dataSubjectID        = $value['id'];
                }
            }
        }

        $query                = '//bpmn:collaboration/bpmn:participant[@id=' . '"' . $controllerID . '"]/@processRef';
        $controllerProcessRef = ((array) $xml->xpath($query)[0])['@attributes']['processRef'];

        $query             = '//bpmn:process/bpmn:textAnnotation/bpmn:text';
        $globalAnnotations = $this->convertSimpleXMLArrayToArray($xml->xpath($query));

        foreach ($globalAnnotations as $key => $value) {
            if (preg_match_all('/(?<=\[).+?(?=\])/', $globalAnnotations[$key][0], $match)) {
                foreach ($match[0] as $key => $value) {
                    $data[$value] = 'true';
                }
            }
        }

        $query                 = '//bpmn:collaboration/bpmn:textAnnotation/bpmn:text';
        $controllerAnnotations = $this->convertSimpleXMLArrayToArray($xml->xpath($query));

        if (preg_match_all('/(?<=\[).+?(?=\])/', $controllerAnnotations[0][0], $match)) {
            foreach ($match[0] as $key => $value) {
                $data[$value] = 'true';
            }
        }

        $query       = '//bpmn:process/bpmn:dataObjectReference';
        $dataObjects = $this->convertSimpleXMLArrayToArray($xml->xpath($query));

        foreach ($dataObjects as $key => $value) {
            if (preg_match('/\[Artifact\] PrivacyPolicy/i', $value['@attributes']['name'])) {
                $data['privacy_policy'] = 'true';
            }

            if (preg_match('/\[Artifact\] Consent/i', $value['@attributes']['name'])) {
                $data['consent'] = 'true';
            }

            if (preg_match('/\[Artifact\] RecordOfProcessing/i', $value['@attributes']['name'])) {
                $data['processing_log'] = 'true';
            }

            if (preg_match('/\[personal_data\](.*)/i', $value['@attributes']['name'], $match)) {
                $data['personal_data'] = $match[1];
            }
        }

        if (isset($data['general'])) {
            $data['data_category'] = 'general';
        }

        if (isset($data['biometric'])) {
            $data['data_category'] = 'biometric';
        }

        if (isset($data['genetic'])) {
            $data['data_category'] = 'genetic';
        }

        if (isset($data['health'])) {
            $data['data_category'] = 'health';
        }

        if (isset($data['ethnic_origin'])) {
            $data['data_category'] = 'ethnic_origin';
        }

        if (isset($data['racial_origin'])) {
            $data['data_category'] = 'racial_origin';
        }

        if (isset($data['political_affiliation'])) {
            $data['data_category'] = 'political_affiliation';
        }

        if (isset($data['philosophical_beliefs'])) {
            $data['data_category'] = 'philosophical_beliefs';
        }

        if (isset($data['criminal_offense'])) {
            $data['data_category'] = 'criminal_offense';
        }

        if (isset($data['religion'])) {
            $data['data_category'] = 'religion';
        }

        if (isset($data['trade_union_membership'])) {
            $data['data_category'] = 'trade_union_membership';
        }

        if (isset($data['sexual_orientation'])) {
            $data['data_category'] = 'sexual_orientation';
        }

        if (isset($data['sex_life'])) {
            $data['data_category'] = 'sex_life';
        }

        if ($data['consent'] == 'true') {
            $data['legal_ground'] = 'consent';
        }

        if (isset($data['contract_performance'])) {
            $data['legal_ground'] = 'contract_performance';
        }

        if (isset($data['controller_legal_obligation'])) {
            $data['legal_ground'] = 'controller_legal_obligation';
        }

        if (isset($data['vital_interest_protection'])) {
            $data['legal_ground'] = 'vital_interest_protection';
        }

        if (isset($data['public_interest'])) {
            $data['legal_ground'] = 'public_interest';
        }

        if (isset($data['legitimate_interest'])) {
            $data['legal_ground'] = 'legitimate_interest';
        }

        $query = '//bpmn:process/bpmn:task';
        $tasks = $this->convertSimpleXMLArrayToArray($xml->xpath($query));

        foreach ($tasks as $key => $value) {
            if (preg_match('/\[processing_task\] (.*)/i', $value['@attributes']['name'], $match)) {
                $data['processing_task'] = str_replace(' ', '_', $match[1]);
            }

            if (preg_match('/(.*) \[processing_task\]/i', $value['@attributes']['name'], $match)) {
                $data['technologies'] = $match[1];
            }
        }

        return $data;
    }

}
