<?php

namespace blumster\migration;

use yii\base\Application;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        if ($app->hasModule('gii') && !isset($app->getModule('gii')->generators['migration-designer'])) {
            $app->getModule('gii')->generators['migration-designer'] = 'blumster\migration\generators\designer\Generator';
        }
    }
}
