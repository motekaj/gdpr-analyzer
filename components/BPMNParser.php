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

    public function getControllerDataObjects($name, $xml) {
        $dataSubjectElement = $xml->xpath('//bpmn:participant[@name=' . '"' . $name . '"' . ']');
        $dataSubjectElement = $this->convertSimpleXMLArrayToArray($dataSubjectElement);

        $processRef = $dataSubjectElement[0]['@attributes']['processRef'];

        $inputDataObjectRefs = $xml->xpath('//bpmn:process[@id=' . '"' . $processRef . '"' . ']/bpmn:task/bpmn:dataInputAssociation/bpmn:sourceRef');
        $inputDataObjectRefs = $this->convertSimpleXMLArrayToArray($inputDataObjectRefs);

        $controllerDataObjects = [];
        $dataObjectNames = [];

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

    public function getControllerTasks($controller, $xml) {
        $controllerProcessRef = $xml->xpath('//bpmn:participant[@name=' . '"' . $controller . '"' . ']');
        $controllerProcessRef = (array) $controllerProcessRef[0];
        $controllerProcessRef = $controllerProcessRef['@attributes']['processRef'];

        $processingTasksSimpleXML = $xml->xpath('//bpmn:process[@id=' . '"' . $controllerProcessRef . '"' . ']/bpmn:task/@name');
        $processingTasksArray = [];
        
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
    }}
