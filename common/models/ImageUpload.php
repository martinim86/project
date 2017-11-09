<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpload extends Model{
    
    public $img;


    public function rules()
    {
        return [
            [['img'], 'required'],
            [['img'], 'file', 'extensions' => 'jpg,png']
        ];
    }


    public function uploadFile(UploadedFile $file, $currentImage)
    {
           $this->img = $file;
           if($this->validate()){
               $this->deleteCurrentImage($currentImage);
               return $this->saveImage();
           }

    }

    private function getFolder()
    {
        return Yii::getAlias('@backend') . '/web/uploads/';
    }

    private function generateFilename()
    {
        return strtolower(md5(uniqid($this->img->baseName)) . '.' . $this->img->extension);
    }

    public function deleteCurrentImage($currentImage)
    {
        if($this->fileExists($currentImage))
        {
            unlink($this->getFolder() . $currentImage);
        }
    }

    public function fileExists($currentImage)
    {
        if(!empty($currentImage) && $currentImage != null)
        {
            return file_exists($this->getFolder() . $currentImage);
        }
    }

    public function saveImage()
    {
        $filename = $this->generateFilename();

        $this->img->saveAs($this->getFolder() . $filename);

        return $filename;
    }
}