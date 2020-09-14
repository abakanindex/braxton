<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19.11.2017
 * Time: 22:27
 */

namespace app\widgets;

use app\models\FontAwesomeIconsList;
use yii\helpers\ArrayHelper;
use dmstr\widgets\Menu;
use app\modules\menu\models\MenuItems;


class LeftsideMenu
{
    /**
     * @var array
     */
    public static $menu = [];

    /**
     * @var array
     */
    public static $items = [];

    /**
     * @var array
     */
    public static $class = [];

    /**
     * set all variables for menu`s working
     */
    private static function defines()
    {
        self::$items = self::getItems();
        self::$menu = [
            'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
            'items' => [
                ['label' => 'Menu', 'options' => ['class' => 'header']],
            ]
        ];
        self::getMenuItems();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public static function create()
    {
        self::defines();//var_dump(self::$menu);
        return Menu::widget(self::$menu);
    }

    /**
     * @return array
     */
    public static function getItems()
    {
        return \yii\helpers\ArrayHelper::toArray(
            MenuItems::find()
                ->with('parent')
                ->where(['status' => 1])
                ->all()
        );
    }

    /**
     * @return bool
     */
    public static function getItemsClass()
    {
        $class = false;
        foreach (self::$items as $key => $item) {
            if ($item['class'] !== '' && !empty($item['class'])) {
                $class[$item['id']] = $item['class'];
            } else {
                $class[$item['id']] = false;
            }
        }
        return $class;
    }

    /**
     * prepare elements for menu
     */
    public static function getMenuItems()
    {
        $menu = false;
        $class = self::getItemsClass();

        foreach (self::$items as $key => $item) {
            if ($item['uri'])
            {
                $itemEl = [
                    'label' => $item['title'],
                    'icon' => $item['icon'],
                    'options' => ['class' => $class[$item['id']]],
                    'url' => ["$item[uri]"],
                ];
            }
            else {
                $itemEl = [
                    'label' => $item['title'],
                    'icon' => $item['icon'],
                    'options' => ['class' => $class[$item['id']]],
                    'url' => ["#"],
                ];
            }
           if (!empty($item['parent_id']))
           {
               self::$menu['items'][$item['parent_id']]['items'][] = $itemEl;
           } else {
               self::$menu['items'][$item['id']] = $itemEl;
           }
        }
    }


}
