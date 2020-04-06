<?php 

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\db\Connection;

class BPMNDiagram extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;    

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'bpmn', 'checkExtensionByMimeType' => false],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {

            $filename = $this->file->baseName . '.' . $this->file->extension;
            
            $this->file->saveAs('uploads/' . $filename);
            
            $connection = Yii::$app->db;

            $connection->createCommand('INSERT INTO bpmn_models (filename) VALUES (:filename) ON DUPLICATE KEY UPDATE filename=:filename')
            ->bindValue(':filename', $filename)
            ->execute();

            $diagramID = $connection->createCommand('SELECT id FROM bpmn_models WHERE filename=:filename')
            ->bindValue(':filename', $filename)
            ->queryOne();

            return $diagramID;
        } else {
            return false;
        }
    }

    public function getFilenames()
    {
        $connection = Yii::$app->db;

        $fileNames = $connection->createCommand('SELECT filename FROM bpmn_models')
             ->queryColumn();

        return $fileNames;
    }

    public function getFileIds()
    {
        $connection = Yii::$app->db;

        $ids = $connection->createCommand('SELECT id FROM bpmn_models')
             ->queryColumn();

        return $ids;
    }
}