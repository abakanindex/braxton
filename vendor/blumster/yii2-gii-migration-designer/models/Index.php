<?php

namespace blumster\migration\models;

use yii\base\Model;

class Index extends Model
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
     * @var bool
     */
    public $unique = null;

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
            [ [ 'table', 'columns', 'unique' ], 'required' ],
            [ [ 'table', 'columns' ], 'string' ],
            [ [ 'unique' ], 'boolean' ]
        ];
    }

    /**
     * Returns the formatted name of this Index.
     *
     * @param string $format
     * @return string
     */
    public function formattedName($format)
    {
        if (!is_null($this->name)) {
            return $this->name;
        }

        $name = '';
        $columns = explode(';', $this->columns);

        foreach ($columns as $col) {
            if ($name != '') {
                $name .= '_';
            }

            $name .= $col;
        }

        return ($this->name = (preg_replace('/{{index}}/', $name, preg_replace('/{{table}}/', $this->table, $format)) ?: 'Invalid_Name!'));
    }

    /**
     * @return string[]
     */
    public static function stickyAttributes()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'table' => 'The target table of the index',
            'unique' => 'Determines, if the index should be unique.',
            'columns' => 'The name of the columns this index should contain. Separate with semicolon (;), if you want multiple.'
        ];
    }

    /**
     * @return string[]
     */
    public function hints()
    {
        return static::attributeHints();
    }

    /**
     * @return string[]
     */
    public static function autoCompleteData()
    {
        return [];
    }
}
