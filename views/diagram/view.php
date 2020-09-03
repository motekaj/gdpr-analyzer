<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Dropdown;

// $this->title = 'dpoe 0.2';
?>

    <script src="https://unpkg.com/bpmn-js@7.2.1/dist/bpmn-navigated-viewer.development.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/bpmn-js@7.3.0/dist/assets/diagram-js.css" />
	<link rel="stylesheet" href="https://unpkg.com/bpmn-js@7.3.0/dist/assets/bpmn-font/css/bpmn.css" />


    <!-- example styles -->
<style>
  html, body, #canvas {
    height: 100%;
    padding: 0;
    margin: 0;
  }

  .container, .container-fluid {
    height: 100%;
  }

  .diagram-note {
    background-color: rgba(66, 180, 21, 0.7);
    color: White;
    border-radius: 5px;
    font-family: Arial;
    font-size: 12px;
    padding: 5px;
    min-height: 16px;
    width: 50px;
    text-align: center;
  }

  .needs-discussion:not(.djs-connection) .djs-visual > :nth-child(1) {
    stroke: rgba(66, 180, 21, 0.7) !important; /* color elements as red */
  }

  .buttons {
  	list-style: none;
  	padding-left: 0;
  }

  .buttons li {
  	display: inline;
  }
</style>
<div id="canvas"></div>

<script language="JavaScript">
	var diagram = '<?php echo $xml ?>';

	var modeler = new BpmnJS({
		container: '#canvas'
  	});
	try {

	modeler.importXML(diagram);

	console.log('success!');
	  // viewer.get('canvas').zoom('fit-viewport');
	} catch (err) {

	console.error('something went wrong:', err);
	}

	
</script>



