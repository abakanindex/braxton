<?php

use \blumster\migration\generators\designer\Generator;

/* @var Generator $generator */
/* @var string $migrationName */

$parts = explode('\\', $generator->baseClass);
$baseClassName = array_pop($parts);

if (count($generator->tables) == 1 && is_null($generator->tables[0]->name)) {
    $generator->tables = [];
}

if (count($generator->indices) == 1 && is_null($generator->indices[0]->table)) {
    $generator->indices = [];
}

if (count($generator->foreignKeys) == 1 && is_null($generator->foreignKeys[0]->table)) {
    $generator->foreignKeys = [];
}

echo "<?php\n";

?>

use <?= $generator->baseClass ?>;

class <?= $migrationName ?> extends <?= $baseClassName . "\n" ?>
{
<?php if ($generator->db != 'db') { Generator::echoInheritdocBlock(); echo "    public \$db = '{$generator->db}';\n\n"; } ?>
<?php Generator::echoInheritdocBlock() ?>
    public function <?= $generator->safe ? 'safeUp' : 'up' ?>()
    {
<?php $firstTable = true; ?>
<?php foreach ($generator->tables as $table): ?>
<?php if ($firstTable) { $firstTable = false; } else { echo "\n";} ?>
        $this->createTable('<?= $generator->generateTableName($table->name) ?>', [
<?php foreach ($table->columns as $column): ?>
            '<?= $column->name ?>' => <?= Generator::generateSchema($column) ?>,
<?php endforeach ?>
<?php if (!is_null($table->compositeKey) && is_array($table->compositeKey)): ?>

            'PRIMARY KEY (<?= Generator::processArray($table->compositeKey, '`', true) ?>)'
<?php endif ?>
        ]);
<?php endforeach ?>
<?php if (!empty($generator->tables) && (!empty($generator->indices) || !empty($generator->foreignKeys))): ?>

<?php endif ?>
<?php foreach ($generator->indices as $index): ?>
        $this->createIndex('<?= $generator->generateIndexName($index) ?>', '<?= $generator->generateTableName($index->table) ?>', <?= Generator::processArray(explode(';', $index->columns), '\'', false, true) ?><?= isset($index->unique) && $index->unique ? ', true' : '' ?>);
<?php endforeach ?>
<?php if (!empty($generator->indices) && !empty($generator->foreignKeys)): ?>

<?php endif ?>
<?php foreach ($generator->foreignKeys as $fKey): ?>
        $this->addForeignKey('<?= $generator->generateForeignKeyName($fKey) ?>', '<?= $generator->generateTableName($fKey->table) ?>', <?= Generator::processArray(explode(';', $fKey->columns), '\'', false, true) ?>, '<?= $generator->generateTableName($fKey->refTable) ?>', <?= Generator::processArray(explode(';', $fKey->refColumns), '\'', false, true) ?><?= isset($fKey->delete) ? ", '{$fKey->delete}'" : '' ?><?= isset($fKey->update) ? ((isset($fKey->delete) ? '' : ', null') . ", '{$fKey->update}'") : '' ?>);
<?php endforeach ?>
    }

<?php Generator::echoInheritdocBlock() ?>
    public function <?= $generator->safe ? 'safeDown' : 'down' ?>()
    {
<?php foreach ($generator->foreignKeys as $fKey): ?>
        $this->dropForeignKey('<?= $fKey->name ?>', '<?= $generator->generateTableName($fKey->table) ?>');
<?php endforeach ?>
<?php if (!empty($generator->foreignKeys) && (!empty($generator->indices) || !empty($generator->tables))): ?>

<?php endif ?>
<?php foreach ($generator->indices as $index): ?>
        $this->dropIndex('<?= $index->name ?>', '<?= $generator->generateTableName($index->table) ?>');
<?php endforeach ?>
<?php if (!empty($generator->indices) && !empty($generator->tables)): ?>

<?php endif ?>
<?php foreach ($generator->tables as $table): ?>
        $this->dropTable('<?= $generator->generateTableName($table->name) ?>');
<?php endforeach ?>
    }
}
