<?php
foreach ($responsibles as $responsible):
?>
    <li style="margin-top: 4px;margin-bottom: 4px" data-id="<?= $responsible->id ?>">
        <button data-id="<?= $responsible->id ?>" style="margin-right: 5px" class="remove-responsibles-item btn btn-default btn-xs"
                type="button">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <?= $responsible->username ?>
    </li>
<?php
endforeach;
?>