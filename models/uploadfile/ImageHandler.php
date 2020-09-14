<?php

namespace app\models\uploadfile;

use tpmanc\imagick\Imagick;
use yii\web\UploadedFile;

class ImageHandler
{
    /**
     * @var Imagick
     */
    protected $image;

    /**
     * @param UploadedFile $file
     * @return ImageHandler
     */
    public function setImage(UploadedFile $file): self
    {
        $this->image = Imagick::open($file->tempName);
        return $this;
    }

    /**
     * @param int $maxWidth
     * @param int $maxHeight
     * @throws \tpmanc\imagick\Exception
     */
    public function changeByMaxSize(int $maxWidth, int $maxHeight): void
    {
        $width = $this->image->getWidth();
        $height = $this->image->getHeight();

        if ($width > $maxWidth || $height > $maxHeight) {
            $this->image->resize($maxWidth, $maxHeight);
        }
    }

    /**
     * @param int $maxWidth
     * @param int $maxHeight
     */
    public function createThumbnailByMaxSize(int $maxWidth, int $maxHeight): void
    {
        $width = $this->image->getWidth();
        $height = $this->image->getHeight();

        if ($width > $maxWidth || $height > $maxHeight) {
            $this->image->thumb($maxWidth, $maxHeight);
        }
    }

    /**
     * @param string $path
     */
    public function saveTo(string $path): void
    {
        $this->image->saveTo($path);
    }
}
