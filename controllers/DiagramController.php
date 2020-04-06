<?php

namespace app\controllers;

use Yii;
use app\models\ContactForm;
use app\models\LoginForm;
use app\models\BPMNDiagram;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
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

	public function actionEvaluateOne() 
	{

	}

	public function EditOne() 
	{

	}
}