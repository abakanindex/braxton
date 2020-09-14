<?php

namespace app\models\uploadfile;

use Yii;
use yii\base\Model;
use tpmanc\imagick\Imagick;
use app\models\UserProfile;
use app\models\ref\Ref;
use app\models\Gallery;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\validators\FileValidator;
use app\models\Company;
use app\modules\profileCompany\models\ProfileCompany;

class UploadForm extends Model
{
    const MAX_WIDTH_IMAGE = 800;
    const MAX_HEIGHT_IMAGE = 600;

    const MAX_WIDTH_THUMBNAIL = 150;
    const MAX_HEIGHT_THUMBNAIL = 100;

    /**
     * @var $imageFiles[]
     */

    public $imageFiles;

    public function rules()
    {
        return [
            [[$this->imageFiles], 'file', 'skipOnEmpty' => false, 'maxFiles' => 1000],
        ];
    }
    
    /**
     * this method create directory for reference of company 
     * @return void
     * @param $model
     */
    
    public function createDirRefIdCompany(iterable $model) : void
    {
        if (!empty($model->ref)) {
            mkdir(
                Yii::getAlias(
                    '@webroot/images/img/' . $model->ref
                ), 
                0777, 
                true
            );
            mkdir(
                Yii::getAlias(
                    '@webroot/images/img/' . $model->ref . '/thumbnail'
                ),
                0777,
                true
            );
            mkdir(
                Yii::getAlias(
                    '@webroot/images/img/' . $model->ref . '/watermark'
                ), 
                0777, 
                true
            );
        } else {
            mkdir(
                Yii::getAlias(
                    '@webroot/images/img/' . (new Ref())->getRefCompany($model)
                ), 
                0777, 
                true
            );
            mkdir(
                Yii::getAlias(
                    '@webroot/images/img/' . (new Ref())->getRefCompany($model) . '/thumbnail'
                ), 
                0777, 
                true
            );
            mkdir(
                Yii::getAlias(
                    '@webroot/images/img/' . (new Ref())->getRefCompany($model) . '/watermark'
                ),
                0777,
                true
            );
        }
        
    }
    
   /**
    * put Watermark 
    *
    * @param iterable $model
    * @param [type] $checimg
    * @return void
    */
    public function putWatermark(iterable $model, $checimg) : void
    {
        
        $companyId    = Company::getCompanyIdBySubdomain();
        $modelProfile = ProfileCompany::findOne(['company_id' => $companyId]);
        if (!empty($model->ref)) {
            $ref = $model->ref;
        } else {
            $ref = (new Ref())->getRefCompany($model);
        }

        $files = glob('../web/images/img/' .$ref. '/watermark/*'); 
        foreach($files as $file){
            if(is_file($file))
            unlink($file); 
        }

        foreach($checimg as $value => $key) {
           
            $im = imagecreatefromjpeg('../' . str_replace('%22', '', $value));
            $stamp = imagecreatefrompng('../' . $modelProfile->watermark);
    
            $sx = imagesx($stamp);
            $sy = imagesy($stamp);
            imagecopy(
                $im, 
                $stamp, 
                (imagesx($im) / 2) - ($sx / 2), 
                (imagesy($im) / 2) - ($sy / 2), 
                 0, 
                 0, 
                 imagesx($stamp), 
                 imagesy($stamp)
            );
    
            imagepng(
                $im, 
                '../' . str_replace(
                    '/web/images/img/'. $ref .'/',
                    '/web/images/img/' . $ref . '/watermark/',
                    str_replace('%22', '', $value)
                )
            );
            imagedestroy($im);
           
           
        }

    }  
    
    /**
     * 
     * this method upload image of company 
     * 
     * @return bool 
     * @param $model
     */
    public function uploadImagesCompany(iterable $model) : bool
    {

        if ($this->validate()) {
           
            $this->createDirRefIdCompany($model);
            
            if (!empty($model->ref)) {
                $ref = $model->ref;
            } else {
                $ref = (new Ref())->getRefCompany($model);
            }

            $handler = new ImageHandler();

            foreach ($this->imageFiles as $file) {

                // Resize image
                $handler->setImage($file);
                $handler->changeByMaxSize(self::MAX_WIDTH_IMAGE, self::MAX_HEIGHT_IMAGE);

                $handler->saveTo(Yii::getAlias(
                    '@webroot/images/img/' . $ref .
                    '/' . $file->baseName .
                    '.' . $file->extension
                ));

                // Create thumbnail
                $handler->setImage($file);
                $handler->createThumbnailByMaxSize(self::MAX_WIDTH_THUMBNAIL, self::MAX_HEIGHT_THUMBNAIL);

                $handler->saveTo(Yii::getAlias(
                    '@webroot/images/img/' . $ref .
                    '/thumbnail/' . $file->baseName .
                    '.' . $file->extension
                ));

                $values = [
                    'ref'  => $ref,
                    'path' => Yii::getAlias(
                        '@web/images/img/' . 
                        $ref . 
                        '/' . $file->baseName . 
                        '.' . $file->extension
                    ),
                    'path_thumbnail' => Yii::getAlias(
                        '@web/images/img/' .
                        $ref .
                        '/thumbnail/' . $file->baseName .
                        '.' . $file->extension
                    ),
                ];

                $modelGallery = new Gallery();
                $modelGallery->attributes = $values;
                $modelGallery->save();
            }
            
            return true;
        } else {
            return false;
        }
    }


    /**
     * 
     * this method upload image of company 
     * 
     * @return bool 
     * @param $model
     */
    public function uploadImages()
    {

        
        foreach ($this->imageFiles as $file) {
            
            $modelGallery = new Gallery();
            
            $file->saveAs(Yii::getAlias(
                '@webroot/images/img/' 
                . $file->baseName . 
                '.' . $file->extension
            ));
            
        }

    }
    
    /** 
     * 
     * @param iterable $model
     * @return array
     */
    public function getPathToImagesByRef(iterable $model = null) : ?array
    {
       $path   = [];
       $result = Gallery::find()->where(['ref' => $model->ref])->asArray()->all();
       foreach ($result as $value) {
            $path[] = $value['path'];
       }
       return $path;
    }

    /**
     * upload img for user
     * @param $file
     * @param $attributeName
     */
    public function uploadImgUser($file, iterable $model, $attributeName)
    {
        $pathUpload    = Yii::getAlias('@webroot') . '/images/users/' . $model->id;
        $pathToDB      = Yii::getAlias('@web') . '/images/users/' . $model->id;
        $fileValidator = new FileValidator(['extensions' => 'jpeg, gif, png, jpg', 'checkExtensionByMimeType' => false]);
        FileHelper::createDirectory($pathUpload);

        if ($fileValidator->validate($file)) {
            $fileName          = $file->baseName . '.' . $file->extension;
            $fileNameUpload    = '/' . $fileName;

            if ($file->saveAs($pathUpload . $fileNameUpload)) {
                $model->{$attributeName} = $pathToDB . $fileNameUpload;
                $model->save();
            }
        }
    }

    /**
     * upload any file
     *
     * @return bool
     */
    public function upload($img, $arrImg)
    {
        $arrImg->saveAs(
            Yii::getAlias(
                '@webroot/images/img/' . $img
            )
        );

        return Yii::getAlias('@web/images/img/' . $img);
    }
}
