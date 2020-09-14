<?php
foreach ($leads as $lead):
?>
    <li style="margin-top: 4px;margin-bottom: 4px" data-id="<?= $lead->id ?>">
        <button data-id="<?= $lead->id ?>" style="margin-right: 5px" class="remove-leads-item btn btn-default btn-xs"
                type="button">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <?= $lead->reference ?>
    </li>
<?php
endforeach;
?>