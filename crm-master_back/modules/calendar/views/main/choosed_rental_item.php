<?php
foreach ($rentals as $rental):
    ?>
    <li style="margin-top: 4px;margin-bottom: 4px" data-id="<?= $rental->id ?>">
        <button data-id="<?= $rental->id ?>" style="margin-right: 5px" class="remove-rentals-item btn btn-default btn-xs"
                type="button">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <?= $rental->ref ?>
    </li>
<?php
endforeach;
?>