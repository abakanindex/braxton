

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
            $('#rentals-price').keyup(function() {
                var price = $('#rentals-price').val();
                var percent = $('#rentals-commissionpercent').val();
                var res = price*percent/100;
                $('#rentals-commission').val(res);
                
                var price = $('#rentals-price').val();
                var percent = $('#rentals-depositpercent').val();
                var res = price*percent/100;
                $('#rentals-deposit').val(res);

            });
        
            $('#rentals-commissionpercent').keyup(function() {
                var price = $('#rentals-price').val();
                var percent = $('#rentals-commissionpercent').val();
                var res = price*percent/100;
                $('#rentals-commission').val(res);
            });
            
            $('#rentals-depositpercent').keyup(function() {
                var price = $('#rentals-price').val();
                var percent = $('#rentals-depositpercent').val();
                var res = price*percent/100;
                $('#rentals-deposit').val(res);
            });
        });
    "
);

?>

