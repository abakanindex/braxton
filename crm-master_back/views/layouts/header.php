<?php

use app\modules\notifications\widgets\NotificationsWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\admin\Rbac;
use app\models\User;
use app\models\Company;
use app\modules\profileCompany\models\ProfileCompany;
use yii;

?>
<?php 
     $companyId    = Company::getCompanyIdBySubdomain();
     $modelProfile = ProfileCompany::findOne(['company_id' => $companyId]);
?>
<?php $profileLink = Url::toRoute(['/users/user-settings/view', 'id' => Yii::$app->user->getId()]) ?>
<?php $logoutLink = Url::toRoute(['/site/logout']) ?>
<?php $menuEditLink = Url::toRoute(['/menu/default/index']) ?>
<?php $adminPaymentPlansLink = Url::toRoute(['/payment-plan/index']) ?>
<?php $menuAccessRoleLink = Url::toRoute(['/roles/roles-settings/']) ?>
<?php $userList = Url::toRoute(['/users/user-settings/']) ?>


<!---     Top Menu       -->
<div class="top-menu">
    <a class="logo" href="/web/">
        <span class="logo-lg"><img src="<?= $modelProfile->logo ?>"></span>
    </a>
    <a href="#" id="sidebar-toggle"><i class="fa fa-bars" aria-hidden="true"></i></a>

    <form method="post" class="form-inline search-form" action="<?= Url::to(['search/search'])?>">
        <div class="form-group" id="show-search-box">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" name="search-value" autocomplete="off">
                <span class="input-group-btn">
                    <button type="button" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </div>
        <div id="search-menu-header">
            <div>
                <div class="search-menu-item" data-value="1">Rentals</div>
                <div class="search-menu-item" data-value="2">Sales</div>
                <div class="search-menu-item" data-value="3">Contacts</div>
                <div class="search-menu-item" data-value="4">Leads</div>
            </div>
            <div>
                <input type="submit" value="<?= Yii::t('app', 'Search')?>" class="btn btn-info" id="submit-search">
                <input type="hidden" value="" id="search-in-objects" name="search-in-objects">
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
            </div>
        </div>
    </form>

    <div class="right-part">
        <?php
        NotificationsWidget::widget([
            'theme' => NotificationsWidget::THEME_TOASTR,
            'clientOptions' => [
                'size' => 'large',
                'location' => 'br',
            ],
            'xhrTimeout' => 10000,
            'pollInterval'=> 10000,
            'counters' => [
                '.notifications-header-count',
                '.notifications-icon-count'
            ],
            'markAllSeenSelector' => '#notification-seen-all',
            'listSelector' => '#notifications',
        ]);
        ?>
        <a href="#" id="notification" class="">

            <i class="fa fa-bell-o" aria-hidden="true">
                <i id="notification-count" class="notifications-icon-count">0</i>
            </i>
        </a>
        <ul class="menu" id="notification-menu" style="right: 260px;" >
            <li>You have <span class="notifications-header-count">0</span> notifications</li>
            <li>
                <div id="notifications"></div>
            </li>
            <li><a href="<?= Url::to(['/notifications/notifications/view-all']) ?>">View all</a></li>
            <li><a href="#" id="notification-seen-all">Mark all as seen</a></li>
        </ul>

        
        <a href="#" id="items" class="" style="display:none;" ><i class="fa fa-cog" aria-hidden="true"></i></a>
            <!-- <ul class="menu" id="items-menu">
                <li><a href="<?= $menuEditLink ?>">Menu</a></li>
                <li><a href="<?= $adminPaymentPlansLink ?>">Company payments</a></li>
            </ul> -->
            <?php if(Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>        
                <a href="#" id="settings" class=""><i class="fa fa-gavel" aria-hidden="true"></i></a>
                <ul class="menu" id="settings-menu">
                    <li><a href="/web/profileCompany/profile-company/index">Profile of Company</a></li>
                    <li><a href="<?= $userList ?>">Users settings</a></li>
                    <!-- <li><a href="/web/company/index">Company list</a></li> -->
                </ul>
            <?php endif; ?>
        <div class="login">
            <?php $user = User::findOne(Yii::$app->user->identity->id); ?>
            <a href="<?= $profileLink ?>" id="login">
                <img src="<?= $user->img_user_profile ?>" alt="..." class="img-circle">
                <p>
                    <?php echo $user->username; ?>                       
                 </p>
                <!--<span><i class="fa fa-angle-down" aria-hidden="true"></i></span>-->
            </a>
            <a href="<?= $logoutLink ?>" data-method="post" class="button"><i class="fa fa-sign-out"></i></a>
        </div>
    </div>
</div><!---     /Top Menu       -->

<!---     Left Menu       -->
<div id="left-menu">
    <ul class="sidebar-menu">
        <li>
            <a href="/web/leads/index">
                <i class="fa fa-filter"></i> 
                <span>Leads</span> 
                <?php if(Yii::$app->user->can('leadsView') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>        
                     <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                <?php else: ?>
                     <i class="fa fa-lock" aria-hidden="true"></i>
                <?php endif;?>
            </a> 
        </li>
        <li>
            <a href="/web/contacts/index">
                <i class="fa fa-address-book-o"></i> 
                <span>Contacts</span>
                <?php if(Yii::$app->user->can('contactsView') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>        
                     <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                <?php else: ?>
                     <i class="fa fa-lock" aria-hidden="true"></i>
                <?php endif;?>
            </a>
        </li>
        <li>
            <a href="<?= Url::toRoute(['/sales/sale/'])?>">
                <i class="fa fa-pie-chart"></i> 
                <span>Sales</span>
                <?php if(Yii::$app->user->can('saleView') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>        
                        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                <?php else: ?>
                        <i class="fa fa-lock" aria-hidden="true"></i>
                <?php endif;?>
            </a>
        </li>
        <li>
            <a href="<?= Url::toRoute(['/rentals/rentals/index'])?>">
                <i class="icon-key-outline"></i> 
                <span>Rentals</span>
                <?php if(Yii::$app->user->can('rentalsView') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>        
                     <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                <?php else: ?>
                        <i class="fa fa-lock" aria-hidden="true"></i>
                <?php endif;?>
            </a>
        </li>
        <li>
            <a href="<?= Url::to(['/deals/deals/index']) ?>">
                <i class="fa fa-handshake-o"></i>
                <span><?= Yii::t('app', 'Deals') ?></span>
                <?php if(Yii::$app->user->can('dealsView') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>        
                     <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                <?php else: ?>
                    <i class="fa fa-lock" aria-hidden="true"></i>
                <?php endif;?>
            </a>
        </li>
        <li>
            <a href="/web/calendar/main/index">
                <i class="fa fa-calendar"></i> 
                <span>Calendar</span>
                <?php if(Yii::$app->user->can('calendarView') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>        
                     <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                <?php else: ?>
                        <i class="fa fa-lock" aria-hidden="true"></i>
                <?php endif;?>
            </a>
        </li>
        <!-- <li><a href="/web/commercial-sales/index"><i class="fa fa-tag"></i> <span>Commercial Sales</span></a></li>
        <li><a href="/web/commercial-rentals/index"><i class="fa fa-building-o"></i> <span>Commercial Rentals</span></a> -->
        <!-- </li> -->
        <!--      <li><a href="/web/import_export/import/index"><i class="fa fa-cloud-upload"></i>  <span>Import</span></a></li> -->
        <li>
            <a href="/web/reports/main/dashboard">
                <i class="fa fa-area-chart"></i> 
                <span>Reports</span>
                <?php if(Yii::$app->user->can('reportsCreate') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>        
                     <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                <?php else: ?>
                        <i class="fa fa-lock" aria-hidden="true"></i>
                <?php endif;?>
            </a>
        </li>
        <li>
            <a href="/web/task-manager/index">
                <i class="fa fa-user-o"></i>
                <span>Task Manager </span>
                <?php if(Yii::$app->user->can('taskmanagerView') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>        
                     <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                <?php else: ?>
                        <i class="fa fa-lock" aria-hidden="true"></i>
                <?php endif;?>
            </a>
        </li>
        <!-- <li><a href="/web/emails/index"><i class="fa fa-envelope-o"></i> <span>Emails </span></a></li> -->
        <li>
            <a href="/web/reminder/index">
                <i class="fa fa-bell"></i>
                <span>My Reminders </span>
                <?php if(Yii::$app->user->can('myremindersView') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>        
                     <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                <?php else: ?>
                        <i class="fa fa-lock" aria-hidden="true"></i>
                <?php endif;?>
            </a>
        </li>
        <li>
            <a href="<?=Url::to(['/viewing/index'])?>">
                <i class="fa fa-eye"></i>
                <span><?= Yii::t('app', 'Viewings') ?></span>
                <i class="fa fa-unlock-alt" aria-hidden="true"></i>
            </a>
        </li>
    </ul>
</div><!---     /Left Menu       -->