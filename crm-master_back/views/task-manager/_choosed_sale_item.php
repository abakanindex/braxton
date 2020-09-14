<?php
foreach ($sales as $sale):
?>
    <li style="margin-top: 4px;margin-bottom: 4px" data-id="<?= $sale->id ?>">
        <button data-id="<?= $sale->id ?>" style="margin-right: 5px" class="remove-sales-item btn btn-default btn-xs"
                type="button">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <?= $sale->ref ?>
    </li>
<?php
endforeach;
?>