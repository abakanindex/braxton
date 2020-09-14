<?php

namespace blumster\migration\models;

use yii\base\Model;

class ForeignKey extends Model
{
    /**
     * @var bool
     */
    public $isNewRecord = true;

    /**
     * @var string
     */
    public $table = null;

    /**
     * @var string
     */
    public $columns = null;

    /**
     * @var string
     */
    public $refTable = null;

    /**
     * @var string
     */
    public $refColumns = null;

    /**
     * @var string
     */
    public $delete = null;

    /**
     * @var string
     */
    public $update = null;

    /**
     * @var string
     */
    public $name = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ [ 'table', 'columns', 'refTable', 'refColumns' ], 'required' ],
            [ [ 'table', 'refTable', 'columns', 'refColumns', 'delete', 'update' ], 'string' ],
            [ [ 'delete', 'update' ], 'in', 'range' => [ 'RESTRICT', 'CASCADE', 'SET NULL', 'NO ACTION', 'SET DEFAULT' ], 'skipOnEmpty' => true, ]
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

        if (in_array($this->delete, [ '', 'RESTRAINT', 'NO ACTION' ])) {
            $this->delete = null;
        }

        if (in_array($this->update, [ '', 'RESTRAINT', 'NO ACTION' ])) {
            $this->update = null;
        }

        return true;
    }

    /**
     * Returns the formatted name of this ForeignKey.
     *
     * @param string $format
     * @return string
     */
    public function formattedName($format)
    {
        if (!is_null($this->name)) {
            return $this->name;
        }

        return ($this->name = preg_replace('/{{ref_table}}/', $this->refTable, preg_replace('/{{table}}/', $this->table, $format)));
    }

    /**
     * @return string[]
     */
    public static function constraintOptions()
    {
        return [
            'RESTRICT' => 'RESTRICT',
            'CASCADE' => 'CASCADE',
            'SET NULL' => 'SET NULL',
            'NO ACTION' => 'NO ACTION',
            'SET DEFAULT' => 'SET DEFAULT'
        ];
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
            'table' => 'The referencing table.',
            'columns' => 'The referencing columns.',
            'refTable' => 'The referenced table.',
            'refColumns' => 'The referenced columns',
            'delete' => 'ON DELETE constraint.',
            'update' => 'ON UPDATE constraint.'
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
