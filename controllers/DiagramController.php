<?php

namespace app\controllers;

use Yii;
use app\models\BPMNDiagram;
use yii\web\Controller;
use yii\db\Connection;

class DiagramController extends Controller
{

    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

	public function actionAll()
	{
		$diagram = new BPMNDiagram;
		$diagramNames = $diagram->getFilenames();
		$diagramIDs = $diagram->getFileIDs();

		return $this->render('all', ['diagramNames' => $diagramNames, 'diagramIDs' => $diagramIDs]);
	}

	public function actionGetList()
	{

	}

	public function actionDelete($diagramID)
	{
		$connection = Yii::$app->db;
        $connection->createCommand('DELETE FROM bpmn_models WHERE id=:diagramID')
        ->bindValue(':diagramID', $diagramID)
        ->execute();
        $connection->createCommand('DELETE FROM model_info WHERE model_ref=:diagramID')
        ->bindValue(':diagramID', $diagramID)
        ->execute();

        return $this->redirect('all');
    }
    public function actionView($diagramName) {
        $xml = file_get_contents('uploads/' . $diagramName);
        $xml = str_replace("\n", '', $xml);
        return $this  -> render('view', ['xml' => $xml]);
        
    }

}
