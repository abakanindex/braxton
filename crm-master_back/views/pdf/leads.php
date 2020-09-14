<table class="table table-bordered">
    <thead>
    <tr>
        <th><?= Yii::t('app', 'Reference')?></th>
        <th><?= Yii::t('app', 'Origin')?></th>
        <th><?= Yii::t('app', 'Last name')?></th>
        <th><?= Yii::t('app', 'First name')?></th>
        <th><?= Yii::t('app', 'Email')?></th>
        <th><?= Yii::t('app', 'Mobile number')?></th>
        <th><?= Yii::t('app', 'Source')?></th>
        <th><?= Yii::t('app', 'Type')?></th>
        <th><?= Yii::t('app', 'Status')?></th>
        <th><?= Yii::t('app', 'Sub Status')?></th>
        <th><?= Yii::t('app', 'Priority')?></th>
    </tr>
    </thead>
    <?php foreach($leads as $lead):?>
        <tr>
            <td><?= $lead->reference?></td>
            <td><?= $lead->getOrigin()?></td>
            <td><?= $lead->last_name?></td>
            <td><?= $lead->first_name?></td>
            <td><?= $lead->email?></td>
            <td><?= $lead->mobile_number?></td>
            <td><?= $lead->contactSource->source?></td>
            <td><?= $lead->typeOne->title?></td>
            <td><?= $lead->getStatus()?></td>
            <td><?= $lead->subStatus->title?></td>
            <td><?= $lead->getPriority()?></td>
        </tr>
    <?php endforeach;?>
</table>
