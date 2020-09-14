

<?= $form->field($model, 'price')->textInput(['type' => 'number']); ?>

<?= $form->field($model, 'price_2')->textInput(['readonly' => true]); ?>

<?= $form->field($model, 'CommissionPercent')->textInput(['type' => 'string']); ?>
<?= $form->field($model, 'commission')->textInput(['type' => 'string', 'readonly' => true]); ?>

<?= $form->field($model, 'DepositPercent')->textInput(['type' => 'string']); ?>
<?= $form->field($model, 'deposit')->textInput(['type' => 'string', 'readonly' => true]); ?>


<?php 

$this->registerJs(
    "
        $(document).ready(function() {
            $('#sale-price').keyup(function() {
                var price = $('#sale-price').val();
                var percent = $('#sale-commissionpercent').val();
                var res = price*percent/100;
                $('#sale-commission').val(res);
                
                var price = $('#sale-price').val();
                var percent = $('#sale-depositpercent').val();
                var res = price*percent/100;
                $('#sale-deposit').val(res);

            });
        
            $('#sale-commissionpercent').keyup(function() {
                var price = $('#sale-price').val();
                var percent = $('#sale-commissionpercent').val();
                var res = price*percent/100;
                $('#sale-commission').val(res);
            });
            
            $('#sale-depositpercent').keyup(function() {
                var price = $('#sale-price').val();
                var percent = $('#sale-depositpercent').val();
                var res = price*percent/100;
                $('#sale-deposit').val(res);
            });
        });
    "
);

?>

