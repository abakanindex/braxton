<?php


$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id'        => 'basic',
    'basePath'  => dirname(__DIR__),
    'bootstrap' => ['log'],
    'timeZone'  => 'Europe/Kiev',
    'name'      => 'Systavision CRM',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'on beforeAction' => function () {
        if (Yii::$app->request->get('new_design') == 1) {
            Yii::$app->layout = 'new_design/main.php';
        }
    },
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
        'notifications' => [
            'class'             => 'app\modules\notifications\NotificationsModule',
            'notificationClass' => 'app\components\Notification',
            'allowDuplicate'    => false,
            'dbDateFormat'      => 'Y-m-d H:i:s',
            'userId'            => function () {
                return \Yii::$app->user->id;
            }
        ],
        'propspace-import' => [
            'class' => 'app\modules\admin\import\PropspaceImport',
        ],
        'yii2images' => [
            'class' => 'rico\yii2images\Module',
            //be sure, that permissions ok
            //if you cant avoid permission errors you have to create "images" folder in web root manually and set 777 permissions
            'imagesStorePath' => 'images/store',
            //path to origin images
            'imagesCachePath' => 'images/cache',
            //path to resized copies
            'graphicsLibrary' => 'GD',
            //but really its better to use 'Imagick'
            'placeHolderPath' => '@webroot/images/placeHolder.png',
            // if you want to get placeholder when image not exists, string will be processed by Yii::getAlias
            'imageCompressionQuality' => 100,
            // Optional. Default value is 85.
        ],
        'import_export' => [
            'class' => 'app\modules\import_export\import',
        ],
        'menu' => [
            'class' => 'app\modules\menu\Menu',
        ],
        'profileCompany' => [
            'class' => 'app\modules\profileCompany\profileCompany',
        ],
        'rights' => [
            'class' => 'app\modules\admin\Rights',
        ],
        'calendar' => [
            'class' => 'app\modules\calendar\Calendar',
        ],
        'deals' => [
            'class' => 'app\modules\deals\Deals',
        ],
        'api' => [
            'class' => 'app\modules\api\Api'
        ],
        'users' => [
            'class' => 'app\modules\admin\Users',
        ],
        'email-lead-source' => [
            'class' => 'app\modules\admin\EmailLeadSource',
        ],
        'areports' => [
            'class' => 'app\modules\admin\Reports',
        ],
        'reports-items' => [
            'class' => 'app\modules\admin\ReportsMenuItem',
        ],
        'roles' => [
            'class' => 'app\modules\admin\Roles',
        ],
        'reports' => [
            'class' => 'app\modules\reports\Reports',
        ],
        'userviewings' => [
            'class' => 'app\modules\admin\UserViewings',
        ],
        'lead_viewing' => [
            'class' => 'app\modules\lead_viewing\LeadViewing',
        ],
        'lead' => [
            'class' => 'app\modules\lead\Lead',
        ],
        'sales' => [
            'class' => 'app\modules\sales\Sales'
        ],
        'rentals' => [
            'class' => 'app\modules\rentals\Rentals'
        ]
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'p-WFdmIBdio1RwhAOUnGh3KKDykJ_W6q',
        ],
        'assetManager' => [
            'basePath'        => __DIR__ . '/../web/assets',
            'appendTimestamp' => true,
            //'forceCopy' => true
        ],
        'i18n' => [
            'translations' => [
                'translator' => 'Yii::t',
                'languages'  => ['ru', 'en'],
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',

                    'fileMap' => [
                        'app'       => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class'            => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'authManager' => [
            // 'class' => 'yii\rbac\DbManager',
            'class' => 'app\components\rbac\AuthManager',
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules' => [
                ''                                  => 'site/index',
                '<action>'                          => 'site/<action>',
                'note/create'                       => 'note/create',
                'viewing/create'                    => 'viewing/create',
                'viewing/load/<id:\d+>/<ref>/<type>'=> 'viewing/load',
                'viewing/update/<id:\d+>'           => 'viewing/update',
                'documents/create'                  => 'documents/create',
                'documents/download/<id:\d+>'       => 'documents/download',
                'documents/download-pdf/<name>'     => 'documents/download-pdf',
                'documents/download-pdf-zip/<name>' => 'documents/download-pdf-zip',
                'documents/download-xls/<name>'     => 'documents/download-xls',
                'sale/index'                        => 'sale/index',
                'sale/create'                       => 'sale/create',
                'sale/view/<id:\d+>'                => 'sale/view',
                'sale/update/<id:\d+>'              => 'sale/update',
                'sale/upload/<id:\d+>'              => 'sale/upload',
                'sale/delete/<id:\d+>'              => 'sale/delete',
                'sale/archive/<id:\d+>'             => 'sale/archive',
                'sale/<slug>'                       => 'sale/slug',
                'sales/advanced-search'             => 'sale/advanced-search',
                'sales/drop-img'                    => 'sale/drop-img',
                'sales/make-published'              => 'sale/make-published',
                'sales/make-unpublished'            => 'sale/make-unpublished',
                'sales/bulk-update'                 => 'sale/bulk-update',
                'sales/save-column-filter'          => 'sale/save-column-filter',
                'sales/grid-panel-archive'          => 'sale/grid-panel-archive',
                'sales/grid-panel-current'          => 'sale/grid-panel-current',
                'sales/grid-panel-pending'          => 'sale/grid-panel-pending',
                'sales/unarchive'                   => 'sale/unarchive',
                'sales/generate-pdf-table'          => 'sale/generate-pdf-table',
                'sales/generate-poster'             => 'sale/generate-poster',
                'sales/generate-brochure'           => 'sale/generate-brochure',
                'sales/get-list-owners'             => 'sale/get-list-owners',
                'rentals/index'                     => 'rentals/index',
                'rentals/create'                    => 'rentals/create',
                'rentals/view/<id:\d+>'             => 'rentals/view',
                'rentals/update/<id:\d+>'           => 'rentals/update',
                'rentals/delete/<id:\d+>'           => 'rentals/delete',
                'rentals/archive/<id:\d+>'          => 'rentals/archive',
                'rentals/<slug>'                    => 'rentals/slug',
                'rental/advanced-search'            => 'rentals/advanced-search',
                'rental/drop-img'                   => 'rentals/drop-img',
                'rental/make-published'             => 'rentals/make-published',
                'rental/make-unpublished'           => 'rentals/make-unpublished',
                'rental/bulk-update'                => 'rentals/bulk-update',
                'rental/save-column-filter'         => 'rentals/save-column-filter',
                'rental/grid-panel-archive'         => 'rentals/grid-panel-archive',
                'rental/grid-panel-current'         => 'rentals/grid-panel-current',
                'rental/grid-panel-pending'         => 'rentals/grid-panel-pending',
                'rental/unarchive'                  => 'rentals/unarchive',
                'rental/generate-pdf-table'         => 'rentals/generate-pdf-table',
                'rental/generate-poster'            => 'rentals/generate-poster',
                'rental/generate-brochure'          => 'rentals/generate-brochure',
                'rental/get-list-owners'            => 'rentals/get-list-owners',
                'contacts/index'                    => 'contacts/index',
                'contacts/create'                   => 'contacts/create',
                'contacts/view/<id:\d+>'            => 'contacts/view',
                'contacts/update/<id:\d+>'          => 'contacts/update',
                'contacts/delete/<id:\d+>'          => 'contacts/delete',
                'contacts/<slug>'                   => 'contacts/slug',
                'contact/get-by-ref'                => 'contacts/get-by-ref',
                'contact/save-column-filter'        => 'contacts/save-column-filter',
                'contact/grid-panel-archive'        => 'contacts/grid-panel-archive',
                'contact/grid-panel-current'        => 'contacts/grid-panel-current',
                'contact/unarchive'                 => 'contacts/unarchive',
                'leads/import'                      => 'leads/import',
                'leads/save-lead-property'          => 'leads/save-lead-property',
                'leads/index'                       => 'leads/index',
                'leads/activity'                    => 'leads/activity',
                'leads/social-media-contacts-block' => 'leads/social-media-contacts-block',
                'leads/matching-sales-list'         => 'leads/matching-sales-list',
                'leads/matching-rentals-list'       => 'leads/matching-rentals-list',
                'leads/create'                      => 'leads/create',
                'leads/view/<id:\d+>'               => 'leads/view',
                'leads/update/<id:\d+>'             => 'leads/update',
                'leads/delete/<id:\d+>'             => 'leads/delete',
                'leads/<slug>'                      => 'leads/slug',
                'lead/save-column-filter'           => 'leads/save-column-filter',
                'lead/grid-panel-archive'           => 'leads/grid-panel-archive',
                'lead/grid-panel-current'           => 'leads/grid-panel-current',
                'lead/unarchive'                    => 'leads/unarchive',
                'lead/advanced-search'              => 'leads/advanced-search',
                'lead/matching-send-links'          => 'leads/matching-send-links',
                'lead/matching-send-brochure'       => 'leads/matching-send-brochure',
                'lead/get-by-ref'                   => 'leads/get-by-ref',
                'lead/export-to-xls'                => 'leads/export-to-xls',
                'lead/export-to-pdf'                => 'leads/export-to-pdf',
                'lead/change-match-properties/<id:\d+>' => 'leads/change-match-properties',
                'preview/<slug>'                        => 'preview/slug',
                'search/search'                         => 'search/search',
                'api/feed/view/<portalId>/<token>'      => 'api/feed/view',
                'api/feed/xml/<portalId>/<token>'       => 'api/feed/xml'

            ],
        ],
        'NotificationReminder' => [
            'class' => 'app\components\NotificationReminder'
        ],
        'DocumentsClean' => [
            'class' => 'app\components\DocumentsClean'
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['bootstrap'][] = 'NotificationReminder';
    $config['bootstrap'][] = 'DocumentsClean';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        //     // uncomment the following to add your IP if you are not connecting from localhost.
        // 'allowedIPs' => ['127.0.0.1', '::1'],
    ];

}
if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
