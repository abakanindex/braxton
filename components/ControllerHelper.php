<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 21.12.2017
 * Time: 20:02
 */

namespace app\components;

use app\models\AuthControllerList;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use Yii;
use yii\helpers\StringHelper;

class ControllerHelper
{
    public $description;

    private $ignoreItems;

    public static function getControllerNames()
    {
        $controllerNames = [];

        $controllers['core'] = FileHelper::findFiles(Yii::$app->controllerPath, ['only' => ['*Controller.php']]);
        $controllers['modules'] = FileHelper::findFiles(DOCUMENT__ROOT . '/modules', [
            'only' => ['*Controller.php'
            ]
        ]);

        foreach ($controllers as $controller) {
            foreach ($controller as $item) {
                $item = basename($item);
                $item = strtolower($item);
                list($controllerNames[], $Controllerphp) = explode('controller.php', $item);
            }
        }
        //  self::saveControllers();
        return $controllerNames;
    }

    /**
     * @return bool|array
     */
    public static function getActionsByController()
    {
        $steady = false;
        $result = false;
        $controllers = ArrayHelper::merge(
            FileHelper::findFiles(DOCUMENT__ROOT . '/controllers/', ['only' => ['*Controller.php']]),
            FileHelper::findFiles(DOCUMENT__ROOT . '/modules/', ['only' => ['*Controller.php']])
        );

        foreach ($controllers as $controller) {
            $content = file($controller);
            $steady[str_replace('Controller.php', '', basename($controller))] =
                preg_grep('/(public)\s(function)\s(action)([a-zA-Z]+)(\()/', $content);
        }
        foreach ($steady as $key => $value) {
            foreach ($value as $item) {
                $actions = preg_replace('/(public)\s(function)\s(action)/', '',
                    preg_replace('/(\()(\$[a-zA-Z]+)(\))|(\()(\))/', '', trim(strtolower($item))));
                if (strlen($actions) <= 2) continue;
                $result[$key]['uniqueIds'][] = trim(strtolower($key) . '/' . strtolower($actions));
                $result[$key]['controllerNames'][] = $key;
                $result[$key]['actionNames'][] = $actions;
            }
        }
        return $result;
    }

    public function save()
    {
        $model = false;
        $error = false;
        $description = false;
        $list = self::getActionsByController();
        AuthControllerList::deleteAll();
        foreach ($list as $controllerName => $arrays) {
            if (!$this->checkIgnore($controllerName)) {
                foreach ($arrays['actionNames'] as $key => $action) {
                    if (!$this->checkIgnore($action)) {
                        $model[$controllerName][$key] = new AuthControllerList();
                        $model[$controllerName][$key]->controller_id = $controllerName;
                        $model[$controllerName][$key]->action_id = $action;
                        $model[$controllerName][$key]->unique_id = $arrays['uniqueIds'][$key];
                        $description[$controllerName][$key] = $controllerName . ' ' . $arrays['actionNames'][$key] . ' page';
                        switch ($controllerName) {
                            case ('Site'):
                                $description[$controllerName][$key] = 'CRM main' . ' ' . $arrays['actionNames'][$key] . ' page';
                                break;
                        }
                        $model[$controllerName][$key]->description = $description[$controllerName][$key];
                        if (!$model[$controllerName][$key]->save()) {
                            $error[$controllerName][$key] = true;
                        }
                    }
                }
            }
        }
        return $error ? $error : $model;
    }

    /**
     * @param $itemName string | array
     * @return bool
     */
    private function checkIgnore($itemName)
    {
        if (is_array($this->ignoreItems)) {
            return in_array(strtolower(trim($itemName)), $this->ignoreItems) ? true : false;
        }
        return strtolower(trim($this->ignoreItems)) === strtolower(trim($itemName)) ? true : false;
    }

    /**
     * @param $items string | array
     */
    public function setIgnoreItems($items)
    {
        if (!is_array($items)) {
            $this->ignoreItems = strtolower(trim($items));
        }
        foreach ($items as $key => $item) {
            $items[$key] = strtolower(trim($item));
        }
        $this->ignoreItems = $items;
    }

    public function checkIfTableEmpty()
    {
        return count(AuthControllerList::find()->all()) == 0 ? true : false;
    }
}