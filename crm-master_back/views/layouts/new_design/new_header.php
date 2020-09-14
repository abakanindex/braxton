<?php

    use machour\yii2\notifications\widgets\NotificationsWidget;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use app\modules\admin\Rbac;
    use app\models\User;
	
?>

<?php $profileLink = Url::toRoute(['/profile/view', 'id' => Yii::$app->user->getId()]) ?>
<?php $logoutLink = Url::toRoute(['/site/logout']) ?>
<?php $menuEditLink = Url::toRoute(['/menu/default/index']) ?>
<?php $adminPaymentPlansLink = Url::toRoute(['/payment-plan/index']) ?>
<?php $menuAccessRoleLink = Url::toRoute(['/roles/roles-settings/']) ?>
<?php $userList = Url::toRoute(['/users/user-settings/']) ?>


    <!---     Top Menu       -->

<div class="top-menu">
    <a class="logo" href="/web/">
        <span class="logo-lg"><img src="<?= Url::to('@web/new-design/img/logo-lg.png') ?>"></span>
        <span class="logo-sm"><img src="<?= Url::to('@web/new-design/img/logo-sm.png') ?>"></span>
    </a>
    <a href="#" id="sidebar-toggle"><i class="fa fa-bars" aria-hidden="true"></i></a>

    <form action="#" method="get" class="form-inline search-form">
        <div class="form-group">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </div>
    </form>

    <div class="right-part">
        <a href="#" id="notification" class="">
            <?php
                // NotificationsWidget::widget([
                //     'theme' => NotificationsWidget::THEME_TOASTR,
                //     'clientOptions' => [
                //         'size' => 'large',
                //         'location' => 'br',
                //     ],
                //     'counters' => [
                //         '.notifications-header-count',
                //         '.notifications-icon-count'
                //     ],
                //     'markAllSeenSelector' => '#notification-seen-all',
                //     'listSelector' => '#notifications',
                // ]);
            ?>
            <i class="fa fa-bell-o" aria-hidden="true">
                <i id="notification-count">0</i>
            </i>
        </a>
        <ul class="menu" id="notification-menu">
            <li>You have <span class="notifications-menu-count">0</span> notifications</li>
            <li><div id="notification-string"></div></li>
            <li><a href="#">View all</a></li>
            <li><a href="#" id="notification-seen-all">Mark all as seen</a></li>
        </ul>

        <a href="#" id="items" class=""><i class="fa fa-cog" aria-hidden="true"></i></a>
        <?php if (Yii::$app->user->can(Rbac::ROLE_DEVELOPER) || Yii::$app->user->can(Rbac::ROLE_ADMIN)) : ?>
        <ul class="menu" id="items-menu">
            <li><a href="<?= $menuEditLink ?>">Menu</a></li>
            <li><a href="<?= $adminPaymentPlansLink ?>">Company payments</a></li>
        </ul>

        <a href="#" id="settings" class=""><i class="fa fa-gavel" aria-hidden="true"></i></a>
        <ul class="menu" id="settings-menu">
            <li><a href="<?= $menuAccessRoleLink ?>">Roles settings</a></li>
            <li><a href="<?= $userList ?>">Users settings</a></li>
            <li><a href="/web/company/index">Company list</a></li>
        </ul>
        <?php ENDIF ?>
        <div class="login">
            <a href="<?= $profileLink ?>" id="login">
                <img src="<?= Url::to('@web/new-design/img/user3-128x128.jpg') ?>" alt="..." class="img-circle">
                <p><?= \app\components\rbac\AuthManager::getUsername(Yii::$app->user->getId()) ?></p><!--<span><i class="fa fa-angle-down" aria-hidden="true"></i></span>-->
            </a>
            <a href="<?= $logoutLink ?>" class="button"><i class="fa fa-sign-out"></i></a>
        </div>
    </div>
</div><!---     /Top Menu       -->

<!---     Left Menu       -->
<div id="left-menu">
    <ul class="sidebar-menu">
        <li><a href="/web/leads/index"><i class="fa fa-filter"></i>  <span>Leads</span></a></li>
        <li><a href="/web/contacts/index"><i class="fa fa-address-book-o"></i>  <span>Contacts</span></a></li>
        <li><a href="/web/sale/index"><i class="fa fa-pie-chart"></i>  <span>Sales</span></a></li>
        <li><a href="/web/rentals/index"><i class="icon-key-outline"></i>  <span>Rentals</span></a></li>
        <li><a href="/web/calendar/main/index"><i class="fa fa-calendar"></i>  <span>Calendar</span></a></li>
        <li><a href="/web/commercial-sales/index"><i class="fa fa-tag"></i>  <span>Commercial Sales</span></a></li>
        <li><a href="/web/commercial-rentals/index"><i class="fa fa-building-o"></i>  <span>Commercial Rentals</span></a></li>
        <li><a href="/web/import_export/import/index"><i class="fa fa-cloud-upload"></i>  <span>Import</span></a></li>
       <!-- <li><a href="/web/reports/main/dashboard"><i class="fa fa-area-chart"></i>  <span>Reports</span></a></li>-->
        <li><a href="/web/task-manager/index"><i class="fa fa-user-o"></i>  <span>Task Manager</span></a></li>
        <li><a href="/web/emails/index"><i class="fa fa-envelope-o"></i>  <span>Emails </span></a></li>
    </ul>
</div><!---     /Left Menu       -->