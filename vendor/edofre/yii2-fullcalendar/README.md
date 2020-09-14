# Yii2 fullcalendar component

[![Latest Stable Version](https://poser.pugx.org/edofre/yii2-fullcalendar/v/stable)](https://packagist.org/packages/edofre/yii2-fullcalendar)
[![Total Downloads](https://poser.pugx.org/edofre/yii2-fullcalendar/downloads)](https://packagist.org/packages/edofre/yii2-fullcalendar)
[![Latest Unstable Version](https://poser.pugx.org/edofre/yii2-fullcalendar/v/unstable)](https://packagist.org/packages/edofre/yii2-fullcalendar)
[![License](https://poser.pugx.org/edofre/yii2-fullcalendar/license)](https://packagist.org/packages/edofre/yii2-fullcalendar)
[![composer.lock](https://poser.pugx.org/edofre/yii2-fullcalendar/composerlock)](https://packagist.org/packages/edofre/yii2-fullcalendar)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

To install, either run

```
$ php composer.phar require edofre/yii2-fullcalendar "V1.0.10"
```

or add

```
"edofre/yii2-fullcalendar": "V1.0.10"
```

to the ```require``` section of your `composer.json` file.

## Usage

### Fullcalendar can be created as following, all options are optional, below is just an example of most options
```php
<?= edofre\fullcalendar\Fullcalendar::widget([
        'options'       => [
            'id'       => 'calendar',
            'language' => 'nl',
        ],
        'clientOptions' => [
            'weekNumbers' => true,
            'selectable'  => true,
            'defaultView' => 'agendaWeek',
            'eventResize' => new JsExpression("
                function(event, delta, revertFunc, jsEvent, ui, view) {
                    console.log(event);
                }
            "),

        ],
        'events'        => Url::to(['calendar/events', 'id' => $uniqid]),
    ]);
?>
```

### Events can be added in three ways, PHP array, Javascript array or JSON feed

#### PHP array
```php
<?php
    $events = [
        new Event([
            'title' => 'Appointment #' . rand(1, 999),
            'start' => '2016-03-18T14:00:00',
        ]),
        // Everything editable
        new Event([
            'id'               => uniqid(),
            'title'            => 'Appointment #' . rand(1, 999),
            'start'            => '2016-03-17T12:30:00',
            'end'              => '2016-03-17T13:30:00',
            'editable'         => true,
            'startEditable'    => true,
            'durationEditable' => true,
        ]),
        // No overlap
        new Event([
            'id'               => uniqid(),
            'title'            => 'Appointment #' . rand(1, 999),
            'start'            => '2016-03-17T15:30:00',
            'end'              => '2016-03-17T19:30:00',
            'overlap'          => false, // Overlap is default true
            'editable'         => true,
            'startEditable'    => true,
            'durationEditable' => true,
        ]),
        // Only duration editable
        new Event([
            'id'               => uniqid(),
            'title'            => 'Appointment #' . rand(1, 999),
            'start'            => '2016-03-16T11:00:00',
            'end'              => '2016-03-16T11:30:00',
            'startEditable'    => false,
            'durationEditable' => true,
        ]),
        // Only start editable
        new Event([
            'id'               => uniqid(),
            'title'            => 'Appointment #' . rand(1, 999),
            'start'            => '2016-03-15T14:00:00',
            'end'              => '2016-03-15T15:30:00',
            'startEditable'    => true,
            'durationEditable' => false,
        ]),
    ];
?>

<?= edofre\fullcalendar\Fullcalendar::widget([
        'events'        => $events
    ]);
?>
```

#### Javascript array
```php
<?= edofre\fullcalendar\Fullcalendar::widget([
       'events'        => new JsExpression('[
            {
                "id":null,
                "title":"Appointment #776",
                "allDay":false,
                "start":"2016-03-18T14:00:00",
                "end":null,
                "url":null,
                "className":null,
                "editable":false,
                "startEditable":false,
                "durationEditable":false,
                "rendering":null,
                "overlap":true,
                "constraint":null,
                "source":null,
                "color":null,
                "backgroundColor":"grey",
                "borderColor":"black",
                "textColor":null
            },
            {
                "id":"56e74da126014",
                "title":"Appointment #928",
                "allDay":false,
                "start":"2016-03-17T12:30:00",
                "end":"2016-03-17T13:30:00",
                "url":null,
                "className":null,
                "editable":true,
                "startEditable":true,
                "durationEditable":true,
                "rendering":null,
                "overlap":true,
                "constraint":null,
                "source":null,
                "color":null,
                "backgroundColor":"grey",
                "borderColor":"black",
                "textColor":null
            },
            {
                "id":"56e74da126050",
                "title":"Appointment #197",
                "allDay":false,
                "start":"2016-03-17T15:30:00",
                "end":"2016-03-17T19:30:00",
                "url":null,
                "className":null,
                "editable":true,
                "startEditable":true,
                "durationEditable":true,
                "rendering":null,
                "overlap":false,
                "constraint":null,
                "source":null,
                "color":null,
                "backgroundColor":"grey",
                "borderColor":"black",
                "textColor":null
            },
            {
                "id":"56e74da126080",
                "title":"Appointment #537",
                "allDay":false,
                "start":"2016-03-16T11:00:00",
                "end":"2016-03-16T11:30:00",
                "url":null,
                "className":null,
                "editable":false,
                "startEditable":false,
                "durationEditable":true,
                "rendering":null,
                "overlap":true,
                "constraint":null,
                "source":null,
                "color":null,
                "backgroundColor":"grey",
                "borderColor":"black",
                "textColor":null
            },
            {
                "id":"56e74da1260a7",
                "title":"Appointment #465",
                "allDay":false,
                "start":"2016-03-15T14:00:00",
                "end":"2016-03-15T15:30:00",
                "url":null,
                "className":null,
                "editable":false,
                "startEditable":true,
                "durationEditable":false,
                "rendering":null,
                "overlap":true,
                "constraint":null,
                "source":null,
                "color":null,
                "backgroundColor":"grey",
                "borderColor":"black",
                "textColor":null
            },
        ]'),
    ]);
?>
```

#### JSON feed
```php
<?= edofre\fullcalendar\Fullcalendar::widget([
        'events'        => Url::to(['calendar/events', 'id' => $uniqid]),
    ]);
?>
```

Your controller action would then return an array as following
```php
    /**
	 * @param $id
	 * @param $start
	 * @param $end
	 * @return array
	 */
	public function actionEvents($id, $start, $end)
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		return [
			// minimum
			new Event([
				'title' => 'Appointment #' . rand(1, 999),
				'start' => '2016-03-18T14:00:00',
			]),
			// Everything editable
			new Event([
				'id'               => uniqid(),
				'title'            => 'Appointment #' . rand(1, 999),
				'start'            => '2016-03-17T12:30:00',
				'end'              => '2016-03-17T13:30:00',
				'editable'         => true,
				'startEditable'    => true,
				'durationEditable' => true,
			]),
			// No overlap
			new Event([
				'id'               => uniqid(),
				'title'            => 'Appointment #' . rand(1, 999),
				'start'            => '2016-03-17T15:30:00',
				'end'              => '2016-03-17T19:30:00',
				'overlap'          => false, // Overlap is default true
				'editable'         => true,
				'startEditable'    => true,
				'durationEditable' => true,
			]),
			// Only duration editable
			new Event([
				'id'               => uniqid(),
				'title'            => 'Appointment #' . rand(1, 999),
				'start'            => '2016-03-16T11:00:00',
				'end'              => '2016-03-16T11:30:00',
				'startEditable'    => false,
				'durationEditable' => true,
			]),
			// Only start editable
			new Event([
				'id'               => uniqid(),
				'title'            => 'Appointment #' . rand(1, 999),
				'start'            => '2016-03-15T14:00:00',
				'end'              => '2016-03-15T15:30:00',
				'startEditable'    => true,
				'durationEditable' => false,
			]),
		];
	}
```

### Callbacks

Callbacks have to be wrapped in a JsExpression() object. For example if you want to use the eventResize you would add the following to the fullcalendar clientOptions
```php
<?= edofre\fullcalendar\Fullcalendar::widget([
        'clientOptions' => [
            'eventResize' => new JsExpression("
                function(event, delta, revertFunc, jsEvent, ui, view) {
                    console.log(event.id);
                    console.log(delta);
                }
            "),
        ],
    ]);
?>
```
