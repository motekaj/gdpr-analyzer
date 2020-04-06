<?php

namespace app\models;

use yii\base\Model;

class BPMNData extends Model
{
    public $xml;
    public $taskData;
    public $participantTasks;

    public function parseBPMN($xml)
    {
        $this->registerBPMNNS($xml);

        $participantQuery = '//bpmn2:collaboration/bpmn2:participant[@*]';
        $messageFlowQuery = '//bpmn2:collaboration/bpmn2:messageFlow[@*]';

        $participants = $this->getXMLAttributes($participantQuery, $xml);
        $messageFlows = $this->getXMLAttributes($messageFlowQuery, $xml);

        $arrayParticipantTasks = [];
        $arrayTaskData         = [];

        //Initialize array1 with participant names
        foreach ($participants as $key => $value) {
            $arrayParticipantTasks[$value['@attributes']['name']] = [];
        }

        //Add task names to each participant as arrays
        foreach ($arrayParticipantTasks as $key => $value) {
            $processRef                  = $this->getProcessRef($key, $participants);
            $arrayParticipantTasks[$key] = $this->getProcessTasks($processRef, $xml);
        }

        //Add input data objects to each activity

        // $inputDataArtifacts = $this->getInputDataArtifacts("Task_0qkv0fn", $xml);

        foreach ($arrayParticipantTasks as $key => $value) {
            foreach ($value as $taskName => $taskID) {
                $arrayTaskData[$taskID] = ["inputs" => "splt", "outputs" => null];
            }
        }

        //Add output data objects to each activity

        foreach ($arrayTaskData as $key => $value) {
            $arrayTaskData[$key]['inputs'] = $this->getInputDataArtifacts($key, $xml);
        }

        foreach ($arrayTaskData as $key => $value) {
            $arrayTaskData[$key]['outputs'] = $this->getOutputDataArtifacts($key, $xml);
        }

        $this->taskData         = $arrayTaskData;
        $this->participantTasks = $arrayParticipantTasks;

        return;
        // print "<pre>";
        // print_r($arrayTaskData);
        // print "<p>#################</p>";
        // print_r($arrayParticipantTasks);
        // print "</pre>";
        // die();
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

    //Get input data objects in the data subject's lane via data subject ID

    public function getDataSubjectInputDataObjects($id, $xml) 
    {
        $processRef = $xml->xpath('//bpmn2:participant[@id = ' . '"' . $id . '"' . '][@processRef]/text()');

        print_r($processRef);
        die();
    }

    //find the processRef of a participant by its name
    public function getProcessRef($participantId, $participants)
    {
        foreach ($participants as $key => $value) {
            if ($value['@attributes']['id'] == $participantName) {
                return $value['@attributes']['processRef'];
            }
        }
    }

    //find all tasks in a process
    public function getProcessTasks($processRef, $xml)
    {

        //$tasks is array of simpleXML objects with @attributes => task_name and ID
        $taskAttributes = $xml->xpath('//bpmn2:process[@id = ' . '"' . $processRef . '"' . ']/bpmn2:task');
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
        $inputs = $xml->xpath('//bpmn2:task[@id=' . '"' . $taskID . '"]/bpmn2:dataInputAssociation/bpmn2:sourceRef/text()');
        $inputs = $this->convertSimpleXMLArrayToArray($inputs);

        //Flatten Array
        $inputDataArtifacts = [];
        foreach ($inputs as $key => $value) {
            $name = $xml->xpath('//bpmn2:*[@id=' . '"' . $value[0] . '"' . ']')[0]['name']->__toString();

            // array_push($inputDataArtifacts, $value[0] . '__' . $name);
            array_push($inputDataArtifacts, $name);
        }

        return $inputDataArtifacts;
    }

    public function getOutputDataArtifacts($taskID, $xml)
    {
        $outputs = $xml->xpath('//bpmn2:task[@id=' . '"' . $taskID . '"]/bpmn2:dataOutputAssociation/bpmn2:targetRef/text()');
        $outputs = $this->convertSimpleXMLArrayToArray($outputs);

        //Flatten Array
        $outputDataArtifacts = [];
        foreach ($outputs as $key => $value) {
            $name = $xml->xpath('//bpmn2:*[@id=' . '"' . $value[0] . '"' . ']')[0]['name']->__toString();

            // array_push($outputDataArtifacts, $value[0] . '__' . $name);
            array_push($outputDataArtifacts, $name);
        }

        return $outputDataArtifacts;
    }

}
