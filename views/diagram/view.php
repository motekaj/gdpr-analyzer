<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Dropdown;

// $this->title = 'dpoe 0.2';
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Hello World</title>

    <!-- viewer distro (without pan and zoom) -->
    <!-- <script src="https://unpkg.com/bpmn-js@7.2.1/dist/bpmn-viewer.development.js"></script> -->

    <!-- viewer distro (with pan and zoom) -->
    <script src="https://unpkg.com/bpmn-js@7.2.1/dist/bpmn-navigated-viewer.development.js"></script>


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
    </style>
  </head>
  <body>
    <div id="canvas"></div>

    <script language="JavaScript">
    var diagram = '<?php echo $xml ?>';

    var bpmnJS = new BpmnJS({
    container: '#canvas'
  });
try {

  bpmnJS.importXML(diagram);

  console.log('success!');
  viewer.get('canvas').zoom('fit-viewport');
} catch (err) {

  console.error('something went wrong:', err);
}
    </script>
  </body>
</html>



