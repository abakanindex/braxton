<?php

namespace blumster\migration\models;

use yii\base\Exception;
use yii\base\Model;

class Table extends Model
{
    /**
     * @var bool
     */
    public $isNewRecord = true;

    /**
     * @var string
     */
    public $name = null;

    /**
     * @var Column[]
     */
    public $columns;

    /**
     * @var array
     */
    public $compositeKey;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ [ 'name' ], 'string' ],
            [ [ 'name' ], 'required' ],
            [ [ 'name' ], 'match', 'pattern' => '/^[0-9a-zA-Z$_]+$/' ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (is_null($this->columns)) {
            $this->columns = [ new Column() ];
        }
    }

    /**
     * @inheritdoc
     */
    public function load($data, $formName = null)
    {
        if (!parent::load($data, $formName)) {
            return false;
        }

        $this->name = preg_replace('/\s+/', '_', $this->name);
        $this->name = preg_replace('/[^0-9a-zA-Z$_]+/', '', $this->name);

        return true;
    }

    /**
     * This is called before generating the code file.
     */
    public function beforeGenerate()
    {
        $keyColumns = [];

        foreach ($this->columns as $column) {
            if (in_array($column->type, Column::primaryKeyTypes())) {
                $keyColumns[] = $column;
            }
        }

        if (count($keyColumns) < 2) {
            return;
        }

        $fallback = Column::keyFallbackTypes();
        $this->compositeKey = [];

        foreach ($keyColumns as $keyColumn) {
            if (!isset($fallback[$keyColumn->type])) {
                throw new Exception("Unknown fallback for primary key type: {$keyColumn->type}");
            }

            $keyColumn->overrideType = $fallback[$keyColumn->type];
            $this->compositeKey[] = $keyColumn->name;
        }
    }

    /**
     * @return string[]
     */
    public static function stickyAttributes()
    {
        return [];
    }

    /**
     * @return string[]
     */
    public static function hints()
    {
        return [
            'name' => 'Name of the table.'
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return static::hints();
    }

    /**
     * @return string[]
     */
    public static function autoCompleteData()
    {
        return [];
    }
}
