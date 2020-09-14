<?php

namespace blumster\migration\generators\designer;

use blumster\migration\models\Column;
use blumster\migration\models\ForeignKey;
use blumster\migration\models\Index;
use blumster\migration\models\Table;

use Yii;

use yii\base\Exception;
use yii\gii\CodeFile;
use yii\helpers\ArrayHelper;

class Generator extends \yii\gii\Generator
{
    /**
     * @var string
     */
    public $indexFormat = '{{table}}_index_{{index}}';

    /**
     * @var string
     */
    public $foreignKeyFormat = '{{table}}_FK_{{ref_table}}';

    /**
     * @var string
     */
    public $migrationPath = '@app/migrations';

    /**
     * @var string
     */
    public $baseClass = 'yii\db\Migration';

    /**
     * @var string
     */
    public $db = 'db';

    /**
     * @var bool
     */
    public $usePrefix = true;

    /**
     * @var bool
     */
    public $safe = true;

    /**
     * @var string
     */
    public $migrationName = null;

    /**
     * @var \blumster\migration\models\Table[]
     */
    public $tables = [];

    /**
     * @var \blumster\migration\models\Index[]
     */
    public $indices = [];

    /**
     * @var \blumster\migration\models\ForeignKey[]
     */
    public $foreignKeys = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [ [ 'indexFormat', 'foreignKeyFormat', 'migrationPath', 'db', 'baseClass', 'migrationName' ], 'string' ],
            [ [ 'migrationName' ], 'required' ],
            [ [ 'usePrefix', 'safe' ], 'boolean' ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'indexFormat' => 'Index Format',
            'foreignKeyFormat' => 'Foreign Key Format',
            'migrationPath' => 'Migration Path',
            'db' => 'Database Connection Id',
            'baseClass' => 'Base Class',
            'usePrefix' => 'Use Table Prefix',
            'safe' => 'Use Safe Functions',
            'migrationName' => 'Migration Name',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return ArrayHelper::merge(parent::attributeHints(), [
            'indexFormat' => 'The format for naming the indices. <br />Keys: <ul><li>{{table}}: the table the index is created on</li><li>{{index}}: the unique name of the index, made up from the column names</li></ul>',
            'foreignKeyFormat' => 'The format for naming the foreign keys. <br />Keys: <ul><li>{{table}}: the table the foreign key is created on</li><li>{{ref_table}}: the unique name of the foreign key, made up from the referenced table and column name</li></ul>',
            'db' => 'The name of the Database component',
            'baseClass' => 'The is the base class of the new migration. It should be a fully qualified namespaced class name.',
            'usePrefix' => 'This indicates whether the table name returned by the generated ActiveRecord class should consider the <code>tablePrefix</code> setting of the DB connection. For example, if the table name is <code>tbl_post</code> and <code>tablePrefix=tbl_</code>, the ActiveRecord class will return the table name as <code>{{%post}}</code>.',
            'safe' => 'If checked, the migration will use the <code>safeUp(); safeDown();</code> functions, instead of <code>up(); down();</code> ones.',
            'migrationName' => 'Short name for the migration.',
            'migrationPath' => 'Path of the folder containing the migrations.'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function stickyAttributes()
    {
        return ArrayHelper::merge(parent::stickyAttributes(), [
            'indexFormat',
            'foreignKeyFormat',
            'migrationPath',
            'db',
            'baseClass'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function requiredTemplates()
    {
        return [ 'migration.php' ];
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Migration Designer';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This tool lets you design your database, then generate the migrations for it.';
    }

    /**
     * Returns the array of the available column types for the dropdown list.
     *
     * @return array the available column types
     */
    public static function columnTypes()
    {
        return [
            'bigInteger'    => 'Bigint',
            'bigPrimaryKey' => 'BigPK',
            'binary'        => 'Binary',
            'boolean'       => 'Boolean',
            'date'          => 'Date',
            'dateTime'      => 'Datetime',
            'decimal'       => 'Decimal',
            'double'        => 'Double',
            'float'         => 'Float',
            'integer'       => 'Integer',
            'money'         => 'Money',
            'primaryKey'    => 'PK',
            'smallInteger'  => 'Smallint',
            'string'        => 'String',
            'text'          => 'Text',
            'time'          => 'Time',
            'timestamp'     => 'Timestamp',
        ];
    }

    /**
     * Returns the default value's type for every schema.
     *
     * @return array the types for the schema
     */
    public static function defaultValueTypes()
    {
        return [
            'bigInteger'    => 'int',
            'bigPrimaryKey' => 'int',
            'binary'        => 'string',
            'boolean'       => 'int',
            'date'          => 'string',
            'dateTime'      => 'string',
            'decimal'       => 'int',
            'double'        => 'int',
            'float'         => 'int',
            'integer'       => 'int',
            'money'         => 'int',
            'primaryKey'    => 'int',
            'smallInteger'  => 'int',
            'string'        => 'string',
            'text'          => 'string',
            'time'          => 'string',
            'timestamp'     => 'string',
        ];
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        if (isset($_POST['generate'])) {
            $migrationName = 'm' . gmdate('ymd_His') . '_' . $this->migrationName;
        } else {
            $migrationName = 'm{date_time}_' . $this->migrationName;
        }

        foreach ($this->tables as $table) {
            $table->beforeGenerate();
        }

        $file = new CodeFile(Yii::getAlias($this->migrationPath) . '/' . $migrationName . '.php', $this->render('migration.php', [
            'migrationName' => $migrationName
        ]));
        $file->id = 'migration_file';

        return [ $file ];
    }

    /**
     * @param \blumster\migration\models\Index $index
     * @return string
     */
    public function generateIndexName($index)
    {
        return $index->formattedName($this->indexFormat);
    }

    /**
     * @param \blumster\migration\models\ForeignKey $fKey
     * @return string
     */
    public function generateForeignKeyName($fKey)
    {
        return $fKey->formattedName($this->foreignKeyFormat);
    }

    /**
     * @param string $tableName
     * @return string
     */
    public function generateTableName($tableName)
    {
        if ($this->usePrefix) {
            return '{{%' . $tableName . '}}';
        }

        return $tableName;
    }

    /**
     * Converts the element of the array
     * @param array $value the source array
     * @param string $char the element separator character
     * @param bool $list if true, array characters ([, ]) will be omitted
     * @param bool $canBeSingle if true, it can be rendered as a normal value, instead of a single element array
     * @return string the generated string
     */
    public static function processArray($value, $char = '\'', $list = false, $canBeSingle = false) {
        if (!is_array($value)) {
            return $char . $value . $char;
        }

        if ($canBeSingle && count($value) == 1) {
            return $char . $value[0] . $char;
        }

        return (!$list ? '[ ' : '') . $char . implode($char . ', ' . $char, $value) . $char . (!$list ? ' ]' : '');
    }

    /**
     * Escapes a string's apostrophes with a \ character.
     *
     * @param string $string the source string
     * @return string the escaped string
     */
    public static function escapeApostrophe($string)
    {
        return str_replace('\'', '\\\'', $string);
    }

    /**
     * Generates schema definition calls based on the column's data.
     *
     * @param \blumster\migration\models\Column $column
     * @return string the generated definition
     * @throws Exception
     */
    public static function generateSchema($column)
    {
        if (is_null($column) || empty($column->name) || empty($column->schema)) {
            throw new Exception('Invalid column: ' . (!is_null($column) ? $column->name : 'null') . '!');
        }

        $schema = '$this';
        $baseType = null;
        $defaultValueTypes = static::defaultValueTypes();

        foreach ($column['schema'] as $type => $param) {
            if (is_int($type) && is_string($param)) {
                $type = $param;
                $param = null;
            }

            if (is_null($baseType)) {
                $type = $column->overrideType ?: $type;
                $baseType = $type;
            }

            $char = '';
            if (in_array($type, [ 'check', 'defaultExpression' ])) {
                $char = '\'';
            } elseif ($type == 'defaultValue' && isset($defaultValueTypes[$baseType]) && $defaultValueTypes[$baseType] == 'string') {
                if ($baseType == 'timestamp' && $param == '0') {
                    $char = '';
                } else {
                    $char = '\'';
                }
            }

            $schema .= '->' . $type . '(' . static::processArray($param, $char, true) . ')';
        }

        return $schema;
    }

    /**
     * Echoes the inheritdoc doc block.
     */
    public static function echoInheritdocBlock()
    {
        echo "    /**\n";
        echo "     * @inheritdoc\n";
        echo "     */\n";
    }

    /**
     * @inheritdoc
     */
    public function load($data, $formName = null)
    {
        if (!parent::load($data, $formName)) {
            return false;
        }

        $this->migrationName = preg_replace('/\s+/', '_', $this->migrationName);

        $dataFix = [
            'Table' => [],
            'Column' => []
        ];

        if (isset($data['Table'])) {
            foreach ($data['Table'] as $temp) {
                $dataFix['Table'][] = $temp;
            }
        }

        if (isset($data['Column'])) {
            foreach ($data['Column'] as $temp) {
                $columnFix = [];

                foreach ($temp as $colTemp) {
                    $columnFix[] = $colTemp;
                }

                $temp = $columnFix;

                $dataFix['Column'][] = $temp;
            }
        }

        if (isset($data['Index'])) {
            foreach ($data['Index'] as $temp) {
                $dataFix['Index'][] = $temp;
            }
        }

        if (isset($data['ForeignKey'])) {
            foreach ($data['ForeignKey'] as $temp) {
                $dataFix['ForeignKey'][] = $temp;
            }
        }

        $data = $dataFix;

        if (isset($data['Table'])) {
            $this->tables = static::createMultiple(Table::className(), [], $data);
            Table::loadMultiple($this->tables, $data);

            $loadData = [];

            for ($i = 0; $i < count($this->tables); ++$i) {
                $loadData['Column'] = $data['Column'][$i];

                $this->tables[$i]->columns = static::createMultiple(Column::className(), [], $loadData);
                $this->tables[$i]->isNewRecord = false;
                Column::loadMultiple($this->tables[$i]->columns, $loadData);
            }
        } else {
            $this->tables = [ new Table() ];
        }

        if (isset($data['Index'])) {
            $this->indices = static::createMultiple(Index::className(), [], $data);

            Index::loadMultiple($this->indices, $data);

            foreach ($this->indices as $index) {
                $index->isNewRecord = false;
            }
        } else {
            $this->indices = [ new Index() ];
        }

        if (isset($data['ForeignKey'])) {
            $this->foreignKeys = static::createMultiple(ForeignKey::className(), [], $data);

            ForeignKey::loadMultiple($this->foreignKeys, $data);

            foreach ($this->foreignKeys as $fKey) {
                $fKey->isNewRecord = false;
            }
        } else {
            $this->foreignKeys = [ new ForeignKey() ];
        }

        return true;
    }

    /**
     * Creates and populates a set of models.
     *
     * @param string $modelClass
     * @param array $multipleModels
     * @param array $data
     * @return array
     */
    public static function createMultiple($modelClass, $multipleModels = [], $data = null)
    {
        /* @var \yii\base\Model $model */
        $model    = new $modelClass;
        $formName = $model->formName();
        // added $data=null to function arguments
        // modified the following line to accept new argument
        $post     = empty($data) ? Yii::$app->request->post($formName) : $data[$formName];
        $models   = [];

        if (!empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']])) {
                    $models[] = $multipleModels[$item['id']];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }
}
