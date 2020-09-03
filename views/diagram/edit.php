<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Dropdown;

// $this->title = 'dpoe 0.2';
?>

    <!-- <script src="https://unpkg.com/bpmn-js@7.2.1/dist/bpmn-navigated-viewer.development.js"></script> -->
    <link rel="stylesheet" href="https://unpkg.com/bpmn-js@7.3.0/dist/assets/diagram-js.css" />
	<link rel="stylesheet" href="https://unpkg.com/bpmn-js@7.3.0/dist/assets/bpmn-font/css/bpmn.css" />
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/bpmn-js@7.3.0/dist/bpmn-modeler.development.js"></script>

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
<ul class="buttons">
	<li>
	  <a class="btn btn-primary" id="js-download-diagram" href title="download BPMN diagram">
	    Download BPMN diagram
	  </a>
	</li>
	<li>
	  <a class="btn btn-primary" id="js-download-svg" href title="download as SVG image">
	    Download SVG image
	  </a>
	</li>
</ul>
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

	$(function() {


	  var downloadLink = $('#js-download-diagram');
	  var downloadSvgLink = $('#js-download-svg');

	  $('.buttons a').click(function(e) {
	    if (!$(this).is('.active')) {
	      e.preventDefault();
	      e.stopPropagation();
	    }
	  });

	  function setEncoded(link, name, data) {
	    var encodedData = encodeURIComponent(data);

	    if (data) {
	      link.addClass('active').attr({
	        'href': 'data:application/bpmn20-xml;charset=UTF-8,' + encodedData,
	        'download': name
	      });
	    } else {
	      link.removeClass('active');
	    }
	  }     

	  function debounce(func, wait, immediate) {
	  	var timeout;
	  	return function() {
	  		var context = this, args = arguments;
	  		var later = function() {
	  			timeout = null;
	  			if (!immediate) func.apply(context, args);
	  		};
	  		var callNow = immediate && !timeout;
	  		clearTimeout(timeout);
	  		timeout = setTimeout(later, wait);
	  		if (callNow) func.apply(context, args);
	  	};
	  };

	  var exportArtifacts = debounce(async function() {

	      try {

	        const { svg } = await modeler.saveSVG();

	        setEncoded(downloadSvgLink, 'diagram.svg', svg);
	      } catch (err) {

	        console.error('Error happened saving svg: ', err);
	        setEncoded(downloadSvgLink, 'diagram.svg', null);
	      }

	      try {

	        const { xml } = await modeler.saveXML({ format: true });
	        setEncoded(downloadLink, 'diagram.bpmn', xml);
	      } catch (err) {

	        console.error('Error happened saving XML: ', err);
	        setEncoded(downloadLink, 'diagram.bpmn', null);
	      }
	    }, 500);

	    modeler.on('commandStack.changed', exportArtifacts);
	  });  
</script>



