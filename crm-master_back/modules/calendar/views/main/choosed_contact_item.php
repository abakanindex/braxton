<?php
foreach ($contacts as $contact):
    ?>
    <li style="margin-top: 4px;margin-bottom: 4px" data-id="<?= $contact->id ?>">
        <button data-id="<?= $contact->id ?>" style="margin-right: 5px" class="remove-contacts-item btn btn-default btn-xs"
                type="button">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <?= $contact->ref ?>
    </li>
<?php
endforeach;
?>