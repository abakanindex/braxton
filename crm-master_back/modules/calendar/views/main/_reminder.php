<?php

use yii\helpers\ArrayHelper;
use \app\modules\calendar\models\EventReminder;

$selectedInterval = '';
if (isset($reminder)) {
    $selectedInterval = $reminder->getViewReminderInterval();
    echo '<div class="new-reminder">';
}
?>
    <div class="form-group field-event-reminder">
        <label class="control-label col-sm-3" for="event-type">Reminder</label>
        <div class="col-sm-6">
            <div class="form-group row">
                <div class="col-sm-4">
                    <input type="text"
                           <?php if (isset($reminder)) echo 'value="' . $reminder->getViewReminderTime() . '"'; ?>class="reminder-time form-control"
                           name="Reminder[time]" aria-invalid="false">
                </div>
                <div class="col-sm-5">
                    <select class="form-control reminder-interval" name="reminder-interval">
                        <?php
                        $intervalTypes = EventReminder::$intervalTypes;
                        foreach ($intervalTypes as $intervalTypeKey => $intervalType) {
                            $intervalTypeName = EventReminder::getIntervalTypeTitle($intervalType);
                            if ($selectedInterval) {
                                if ($selectedInterval == $intervalTypeKey)
                                    echo "<option selected value='$intervalTypeKey'>$intervalTypeName</option>";
                                else
                                    echo "<option value='$intervalTypeKey'>$intervalTypeName</option>";
                            } else
                            echo "<option value='$intervalTypeKey'>$intervalTypeName</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <a href="#" class="remove-reminder btn btn-default" aria-label="Left Align">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php
if (isset($reminder))
    echo '</div>';