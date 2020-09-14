<?php

namespace blumster\migration\models;

use yii\base\Model;

class Column extends Model
{
    /**
     * @var bool
     */
    public $isNewRecord = true;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $type;

    /**
     * @var bool
     */
    public $unique;

    /**
     * @var bool
     */
    public $notNull;

    /**
     * @var bool
     */
    public $unsigned;

    /**
     * @var string
     */
    public $defaultValue;

    /**
     * @var array
     */
    public $schema;

    /**
     * @var int
     */
    public $length = null;

    /**
     * @var bool
     */
    public $autoIncrement; // TODO later

    /**
     * @var string
     */
    public $overrideType = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ [ 'name', 'type', 'defaultValue' ], 'string' ],
            [ [ 'name', 'type', 'unique', 'unsigned', 'notNull' ], 'required' ],
            [ [ 'unique', 'unsigned', 'notNull', 'autoIncrement' ], 'boolean' ],
            [ [ 'length' ], 'integer', 'skipOnEmpty' => true ]
        ];
    }

    /**
     * Returns the array of the built in Yii2 primary key types.
     *
     * @return string[] the array of types
     */
    public static function primaryKeyTypes()
    {
        return [
            'primaryKey', 'bigPrimaryKey'
        ];
    }

    /**
     * Returns an array of the built in Yii2 integer column types.
     *
     * @return string[] the array of types
     */
    public static function integerTypes()
    {
        return [
            'bigInteger',
            'decimal',
            'double',
            'float',
            'integer',
            'money',
            'smallInteger',
        ];
    }

    /**
     * Returns the fallback types of the primary keys.
     *
     * @return string[]
     */
    public static function keyFallbackTypes()
    {
        return [
            'bigPrimaryKey' => 'bigInteger',
            'primaryKey' => 'integer'
        ];
    }

    /**
     * @inheritdoc
     */
    public function load($data, $formName = null)
    {
        if (!parent::load($data, $formName)) {
            return false;
        }

        $this->schema = [];
        if (empty($this->length)) {
            $this->schema[] = $this->type;
        } else {
            $this->schema[$this->type] = $this->length;
        }

        if ($this->autoIncrement && !in_array($this->type, static::integerTypes())) {
            $this->autoIncrement = false;
        }

        if ($this->unique && !in_array($this->type, static::primaryKeyTypes())) {
            $this->schema[] = 'unique';
        } else {
            $this->unique = false;
        }

        if ($this->notNull && !in_array($this->type, static::primaryKeyTypes())) {
            $this->schema[] = 'notNull';
        } else {
            $this->notNull = false;
        }

        if ($this->unsigned && in_array($this->type, static::integerTypes())) {
            $this->schema[] = 'unsigned';
        } else {
            $this->unsigned = false;
        }

        if (!is_null($this->defaultValue) && strlen($this->defaultValue) > 0 && !in_array($this->type, static::primaryKeyTypes())) {
            $this->schema['defaultValue'] = $this->defaultValue;
        } else {
            $this->defaultValue = null;
        }

        return true;
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
            'name' => 'Name of the column',
            'type' => 'Type of the column',
            'defaultValue' => 'Default value of the column',
            'unique' => 'Check, if you want a unique index on this column. (Specifying a dedicated unique index has the same effect.)',
            'unsigned' => 'Check, if the column should only contain positive numbers.',
            'notNull' => 'Check, if the column should not hold a NULL value.',
            'autoIncrement' => 'Check, if the column should be AUTO_INCREMENT.',
            'length' => 'Length of the field.'
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return static::hints();
    }

    public static function autoCompleteData()
    {
        return [];
    }
}
