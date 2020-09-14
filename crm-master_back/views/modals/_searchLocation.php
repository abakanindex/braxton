<?php
use yii\helpers\{Html, Url};
use yii\bootstrap\Modal;
use yii\web\View;
?>

<?php Modal::begin([
    'header' => '<h4>' . Yii::t('app', 'Search by location or building') . '</h4>',
    'id'     => 'modal-search-location',
    'footer'   => '<button type="button" class="btn btn-default" data-dismiss="modal">'
        . Yii::t('app', 'OK')
        . '</button>',
])
?>
<div>
    <h5><?= Yii::t('app', 'Please, start typing location name');?></h5>
</div>
<input type="text" class="form-control" id="searchLocation"/>
<ul id="searchLocationList">
    <?php foreach($locationsAll as $l):?>
        <li>
            <?= $l['name']?>
        </li>
    <?php endforeach;?>
</ul>
<?php Modal::end()?>

<?php
$urlFindLocation = Url::to(['/location/search']);

$script = <<<JS
$(document).ready(function() {
    var input = document.getElementById("searchLocation");
    new Awesomplete(input, {
        list: document.querySelector("#searchLocationList"),
        minChars: 1
    });

    input.addEventListener("awesomplete-select", function(event) {
        var text  = event.text.label;

        $.ajax({
            type: "POST",
            data: {
                text: text
            },
            url: "$urlFindLocation",
            async: true,
            success : function(response)
            {
                var emirateId     = response.emirateId;
                var locationId    = response.locationId;
                var subLocationId = response.subLocationId;

                if (emirateId) {
                    $("#emirateDropDown").val(emirateId).change();
                }

                if (locationId) {
                    $("#locationDropDown").val(locationId).change();
                }

                if (subLocationId) {
                    $("#subLocationDropDown").val(subLocationId).change();
                }

                $("#modal-search-location").modal("hide");
            }
        });
    });
})
JS;

$this->registerJs($script, View::POS_READY);
?>