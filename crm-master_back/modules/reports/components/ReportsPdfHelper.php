<?php

namespace app\modules\reports\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\Url;

class ReportsPdfHelper extends Component
{

    public $tempPath;

    public function init()
    {
        $this->initTempPaths();
        parent::init();
    }

    public function initTempPaths()
    {
        if (empty($this->tempPath)) {
            $this->tempPath = Yii::getAlias('@runtime/reports-pdf');
        }
        $s = DIRECTORY_SEPARATOR;
        $prefix = $this->tempPath . $s;
        static::definePath('_RPDF_TEMP_PATH', "{$prefix}tmp{$s}");
    }

    protected static function definePath($prop, $dir)
    {
        if (defined($prop)) {
            $propDir = constant($prop);
            if (is_writable($propDir)) {
                return;
            }
        }
        $status = true;
        if (!is_dir($dir)) {
            $status = mkdir($dir, 0777, true);
        }
        if (!$status) {
            throw new InvalidConfigException("Could not create the folder '{$dir}' in '\$tempPath' set.");
        }
        define($prop, $dir);
    }

    public function render($urlId)
    {
        $tempName = $randomString = Yii::$app->getSecurity()->generateRandomString(32) . '.pdf';
        $path = Yii::getAlias('@runtime/reports-pdf/tmp/') . $tempName;
        chdir(Yii::getAlias('@app') . '/bin');
        $command = 'phantomjs'
            . ' ../web/js/pdfReportsConfig.js'
            . ' ' . Url::toRoute(['main/pdf-report', 'urlId' => $urlId], true)
            . ' ' . $path
            . ' Leads-by-status';
        $response = exec($command);
        return $tempName;
    }

}