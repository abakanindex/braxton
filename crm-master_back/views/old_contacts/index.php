<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel app\controllers\ContactsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contacts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contacts-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);?>

    <div class="container-fluid top-contact-content clearfix"><!--  Top Contact Block -->
    <div class="head-contact-property container-fluid">
        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => Yii::t('app', 'Home'), 'url' => '/'],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <h2><?=Html::encode($this->title)?></h2>
        <ul class="list-inline container-fluid">
            <li class="">
                <?= Html::a('<i class="fa fa-plus-circle"></i>' . Yii::t('app', 'New Contact'), ['create'], ['class' => 'btn green-button', 'id' => 'add-new-element']) ?>
            </li>
            <li class="">
                <a id="edit-element" class="btn red-button hidden" type="button" href="#"><i class="fa fa-pencil-square-o"></i>Edit Contact</a>
            </li>
            <li class="">
                <a id="save-edit-element" class="btn green-button hidden" type="button" href="#"><i class="fa fa-check-circle"></i>Save</a>
            </li>
            <li class="">
                <a id="cancel-edit-element" class="btn gray-button hidden" type="button" href="#"><i class="fa fa-times-circle"></i>Cancel</a>
            </li>
            <li class="pull-right">
                <a class="btn green-button" type="button" href="#"><i class="fa fa-dot-circle-o"></i>Match Properties</a>
            </li>
        </ul>
    </div>

    <div class="container-fluid content-contact-property">
    <form class="form-horizontal">

    <div class="container-fluid contact-left-block col-md-4"><!-- Left Contact part-->
    <div class="contact-top-column-height">

        <div class="contact-big-block"><!-- Owner -->
            <!--<h3>Contact</h3>-->
            <div class="owner-head">
                <!--<img alt="user image" class="owner-image img-circle " src="img/user3-128x128.jpg">-->
                <div class="owner-name">
                    <h4 id="head-info-full-name"></h4>
                    <p><?=Yii::t('app', 'Contact')?></p>
                </div>
            </div>
            <div class="owner-property property-list">
                <p><i class="fa fa-mobile"></i><span id="head-info-mobile"></span></p>
                <p><i class="fa fa-phone"></i><span id="head-info-phone"></span></p>
                <p><i class="fa fa-envelope"></i><span id="head-info-email"></span></p>

            </div>
        </div><!--/Owner-->

    </div>
    <div class="contact-bottom-column-height">

        <div class="contact-small-block"><!--Additional Information-->
            <h3>Contact information</h3>
            <div class="property-list">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="inputContactAssignedTo" class="col-sm-6 control-label"><?=Yii::t('app', 'Assigned To')?></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="info-assigned-to" id="info-assigned-to" disabled>
                                <option value="0">Select</option>
                                <?php foreach($users as $u) {?>
                                    <option value="<?=$u->id?>"><?=$u->username?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputContactReference" class="col-sm-6 control-label"><?=Yii::t('app', 'Ref')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="info-ref" id="info-ref" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactTitle" class="col-sm-6 control-label"><?=Yii::t('app', 'Title')?></label>
                        <div class="col-sm-6">
                            <select class="form-control" id="info-title" name="info-title" disabled>
                                <option value="0">Select</option>
                                <?php foreach($titles as $t) {?>
                                    <option value="<?=$t?>"><?=$t?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactFirstName" class="col-sm-6 control-label"><?=Yii::t('app', 'First Name')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="info-first-name" id="info-first-name" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactLastName" class="col-sm-6 control-label"><?=Yii::t('app', 'Last Name')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="info-last-name" id="info-last-name" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactGender" class="col-sm-6 control-label"><?=Yii::t('app', 'Gender')?></label>
                        <div class="col-sm-6">
                            <select class="form-control" id="info-gender" name="info-gender" disabled>
                                <option value="0">Select</option>
                                <?php foreach($genderList as $gS) {?>
                                    <option value="<?=$gS?>"><?=$gS?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactDateBirth" class="col-sm-6 control-label"><?=Yii::t('app', 'Date of Birth')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="info-date-of-birth" id="info-date-of-birth" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactNationalities" class="col-sm-6 control-label"><?=Yii::t('app', 'Nationalities')?></label>
                        <div class="col-sm-6">
                            <select class="form-control" id="info-nationality" name="info-nationality" disabled>
                                <option value="0">Select</option>
                                <?php foreach($nationalities as $n) {?>
                                    <option value="<?=$n?>"><?=$n?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactReligion" class="col-sm-6 control-label"><?=Yii::t('app', 'Religion')?></label>
                        <div class="col-sm-6">
                            <select class="form-control" id="info-religion" name="info-religion" disabled>
                                <option value="0">Select</option>
                                <?php foreach($religions as $r) {?>
                                    <option value="<?=$r?>"><?=$r?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactLanguage" class="col-sm-6 control-label"><?=Yii::t('app', 'Language')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="info-language" name="info-language" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactHobbies" class="col-sm-6 control-label"><?=Yii::t('app', 'Hobbies')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="info-hobbies" name="info-hobbies" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactCreatedBy" class="col-sm-6 control-label"><?=Yii::t('app', 'Created By')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="info-created-by" id="info-created-by" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactSource" class="col-sm-6 control-label"><?=Yii::t('app', 'Contact Source')?></label>
                        <div class="col-sm-6">
                            <select class="form-control" id="info-contact-source" name="info-contact-source" disabled>
                                <option value="0">Select</option>
                                <?php foreach($sources as $s) {?>
                                    <option value="<?=$s?>"><?=$s?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactType" class="col-sm-6 control-label"><?=Yii::t('app', 'Contact Type')?></label>
                        <div class="col-sm-6">
                            <select class="form-control" id="info-contact-type" name="info-contact-type" disabled>
                               <option value="0">Select</option>
                                <?php foreach($contactType as $cT) {?>
                                    <option value="<?=$cT?>"><?=$cT?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactCompanyName" class="col-sm-6 control-label"><?=Yii::t('app', 'Company Name')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="info-company-name" name="info-company-name" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactDesignation" class="col-sm-6 control-label"><?=Yii::t('app', 'Designation')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="info-designation" name="info-designation" placeholder="" disabled>
                        </div>
                    </div>

                </form>
            </div>
        </div><!-- /Additional Information-->

    </div>

    </div><!-- /Left Contact part-->
    </form>
    <form class="form-horizontal">
        <div class="container-fluid contact-middle-block col-md-4"><!-- Middle Contact part-->

            <div class="content-left-block"><!--Property Address & Detalis-->
                <h3>Contact Details</h3>
                <div class="property-list">
                    <div class="form-group">
                        <label for="inputContactMobilePersonal" class="col-sm-6 control-label"><?=Yii::t('app', 'Mobile Personal')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="info-mobile-personal" id="info-mobile-personal" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Phone Personal')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="info-phone-personal" id="info-phone-personal" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactEmailPersonal" class="col-sm-6 control-label"><?=Yii::t('app', 'Email Personal')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="info-email-personal" id="info-email-personal" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactAddressPersonal" class="col-sm-6 control-label"><?=Yii::t('app', 'Address Personal')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="info-address-personal" name="info-address-personal" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactFacebook" class="col-sm-6 control-label"><?=Yii::t('app', 'Facebook')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="info-facebook" name="info-facebook" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactTwitter" class="col-sm-6 control-label"><?=Yii::t('app', 'Twitter')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="info-twitter" name="info-twitter" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactLinkedIn" class="col-sm-6 control-label"><?=Yii::t('app', 'LinkedIn')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="info-linkedin" name="info-linkedin" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactGoogle" class="col-sm-6 control-label"><?=Yii::t('app', 'Google+')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="info-google-plus" name="info-google-plus" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactInstagram" class="col-sm-6 control-label"><?=Yii::t('app', 'Instagram')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="info-instagram" name="info-instagram" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactWeChat" class="col-sm-6 control-label"><?=Yii::t('app', 'WeChat')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="info-we-chat" name="info-we-chat" placeholder="" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputContactSkype" class="col-sm-6 control-label"><?=Yii::t('app', 'Skype')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="info-skype" name="info-skype" placeholder="" disabled>
                        </div>
                    </div>
                </div>
            </div><!-- /Property Address & Detalis-->

        </div><!-- /Middle Contact part-->
    </form>


    <div class="container-fluid col-md-4 notes-block"><!-- Right part-->
    <div id="notes-tab" >
    <ul class="nav nav-tabs">
        <li class="active"><a  href="#notes" data-toggle="tab">Notes</a></li>
        <li><a href="#viewings" data-toggle="tab">Viewings</a></li>
        <li><a href="#documents" data-toggle="tab">Documents</a></li>
        <li><a href="#history" data-toggle="tab">History</a></li>
    </ul>
    <div class="property-list">
        <div class="tab-content ">
            <div class="tab-pane active" id="notes">
                <div class="tab-header">
                    <h4>Put Note</h4>
                    <a href="#" class="pull-right"><h4></h4></a>
                    <form id="notes-form" class="form clearfix">
                        <div class="form-group">
                            <textarea rows="4" class="form-control" id="note" placeholder=""></textarea>
                        </div>
                        <button type="submit" class="btn col-md-12">Click to add your note</button>
                    </form>
                </div>
                <div class="tab-row">
                    <ul>
                        <li><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et</p></li>
                        <li><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et</p></li>
                        <li><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et</p></li>
                        <li><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et</p></li>
                        <li><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et</p></li>
                        <li><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et</p></li>
                    </ul>

                </div>
            </div>
            <div class="tab-pane" id="viewings">
                <div class="tab-header">
                    <h4>Put Viewing</h4>
                    <a href="#" class="pull-right"><h4></h4></a>
                    <form id="viewings-form" class="form-horizontal clearfix">
                        <div class="form-group">
                            <label for="viewingsListing" class="col-sm-5 control-label">Listing</label>
                            <div class="col-sm-7">
                                <select class="form-control" id="viewingsListing">
                                    <option>Select</option>
                                    <option>Option 2</option>
                                    <option>Option 3</option>
                                    <option>Option 4</option>
                                    <option>Option 5</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="viewingsDate" class="col-sm-5 control-label">Date</label>
                            <div class="col-sm-7">
                                <input type="date" class="form-control" id="viewingsDate" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="viewingsTime" class="col-sm-5 control-label">Time</label>
                            <div class="col-sm-7">
                                <input type="time" class="form-control" id="viewingsTime" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="viewingsAgent" class="col-sm-5 control-label">Agent</label>
                            <div class="col-sm-7">
                                <select class="form-control" id="viewingsAgent">
                                    <option>Select</option>
                                    <option>Option 2</option>
                                    <option>Option 3</option>
                                    <option>Option 4</option>
                                    <option>Option 5</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="viewingsStatus" class="col-sm-5 control-label">Status</label>
                            <div class="col-sm-7">
                                <select class="form-control" id="viewingsStatus">
                                    <option>Select</option>
                                    <option>Option 2</option>
                                    <option>Option 3</option>
                                    <option>Option 4</option>
                                    <option>Option 5</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="viewingsName" class="col-sm-5 control-label">Client Name</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="viewingsName" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="viewingsRequest" class="col-sm-5 control-label">Request</label>
                            <div class="col-sm-7">
                                <select class="form-control" id="viewingsRequest">
                                    <option>Select</option>
                                    <option>Option 2</option>
                                    <option>Option 3</option>
                                    <option>Option 4</option>
                                    <option>Option 5</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="viewingsNote" class="col-sm-5 control-label">Note</label>
                            <div class="col-sm-7">
                                <textarea rows="2" class="form-control" id="viewingsNote" placeholder=""></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn col-md-12">Click to add Viewing</button>
                    </form>
                </div>
                <div class="tab-row">
                    <ul class="viewings-list">
                        <li>
                            <div>
                                <p><span>Date: </span>20/13/2018</p>
                                <p><span>Time: </span>02:20 PM<p>
                                <p><span>Agent: </span>Angelica Gozum</p>
                                <p><span>Status: </span>Scheduled</p>
                                <p><span>Client Name: </span>Abdul Aziz</p>
                                <p><span>Request: </span>Waqas Ahmed</p>
                                <p><span>Note: </span>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</p>
                            </div>
                        </li>
                        <li>
                            <div>
                                <p><span>Date & Time: </span>20/13/2018</p>
                                <p><span>Time: </span>02:20 PM<p>
                                <p><span>Agent: </span>Angelica Gozum</p>
                                <p><span>Status: </span>Scheduled</p>
                                <p><span>Client Name: </span>Abdul Aziz</p>
                                <p><span>Request: </span>Waqas Ahmed</p>
                                <p><span>Note: </span>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</p>
                            </div>
                        </li>
                        <li>
                            <div>
                                <p><span>Date & Time: </span>20/13/2018</p>
                                <p><span>Time: </span>02:20 PM<p>
                                <p><span>Agent: </span>Angelica Gozum</p>
                                <p><span>Status: </span>Scheduled</p>
                                <p><span>Client Name: </span>Abdul Aziz</p>
                                <p><span>Request: </span>Waqas Ahmed</p>
                                <p><span>Note: </span>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-pane" id="documents">
                <div class="tab-header clearfix">
                    <h4>Put Document</h4>
                    <a href="#" class="pull-right"><h4></h4></a>
                    <form >
                        <div class="form-group">
                            <label for="documentsFile" class=" control-label">Document</label>
                            <div class="">
                                <input type="file" class="form-control" id="documentsFile" placeholder="">
                            </div>
                        </div>
                        <button type="submit" class="btn col-md-12">Click to add Document</button>
                    </form>
                </div>
                <div class="tab-row">
                    <ul>
                        <li>Document 1</li>
                        <li>Document 2</li>
                        <li>Document 3</li>
                        <li>Document 4</li>
                        <li>Document 5</li>
                        <li>Document 6</li>
                        <li>Document 7</li>
                        <li>Document 8</li>
                        <li>Document 9</li>
                        <li>Document 10</li>
                        <li>Document 11</li>
                        <li>Document 12</li>
                    </ul>
                </div>
            </div>
            <div class="tab-pane" id="history">
                <div class="tab-header">
                    <h4>History List</h4>
                    <a href="#" class="pull-right"><h4></h4></a>
                </div>

                <div class="tab-row">
                    <ul>
                        <li>History 1</li>
                        <li>History 2</li>
                        <li>History 3</li>
                        <li>History 4</li>
                        <li>History 5</li>
                        <li>History 6</li>
                        <li>History 7</li>
                        <li>History 8</li>
                        <li>History 9</li>
                        <li>History 10</li>
                        <li>History 11</li>
                        <li>History12</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    </div>

    </div><!-- /Right part-->

    </div>

    </div><!-- /Top Contact Block -->

    <?php

    $nationModel;
    $religionModel;
    $ContactSoursModel;
    $titleModel;

    ?>

    <div class="container-fluid  bottom-rentals-content clearfix">
        <div id="listings-tab">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a  href="#current-listings" data-toggle="tab">Current Leads</a>
                </li>
                <!--
                <li><a href="#archived-listings" data-toggle="tab">Archived Leads<span class="badge">42</span></a>
                </li>
                <li><a href="#pending-listings" data-toggle="tab">Pending Leads</a>
                </li>
                -->
            </ul>

            <div class="tab-content ">
                <div class="tab-pane active" id="current-listings">

                    <div class="pane-header container-fluid clearfix"></div>

                    <div id="customizing-block" class="container-fluid clearfix">
                        <div class="button-block first-block">
                            <div style="display: inline-block;">
                                <a class="btn" href="#"><i class="fa fa-check-circle"></i> Published</a>
                                <a class="btn red-button" href="#"><i class="fa fa-times-circle"></i> Unpublished</a>
                            </div>
                            <div style="display: inline-block;">
                                <a class="btn" href="#"><i class="fa fa-cloud-download"></i> Share Options</a>
                                <a class="btn" href="#"><i class="fa fa-search"></i> Advanced Search</a>
                            </div>
                            <div style="display: inline-block;">
                                <a class="btn" href="#"><i class="fa fa-mobile"></i> Send SMS</a>
                                <a class="btn" href="#"><i class="fa fa-th-list"></i> Bulk Update</a>
                            </div>
                        </div>
                        <div class="button-block second-block pull-right">
                            <a class="btn green-button" href="#">Actions<i class="fa fa-angle-down"></i></a>
                            <a class="btn green-button" href="#">View <i class="fa fa-angle-down"></i></a>
                            <a class="btn green-button" href="#">Columns<i class="fa fa-angle-down"></i> </a>
                        </div>
                    </div>

                    <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class=" container-fluid clearfix">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'tableOptions' => [
                                'class' => 'table table-bordered',
                                'id' => 'listings_row'
                            ],
                            'columns' => [
                                /*['class' => 'yii\grid\SerialColumn'],*/
                                ['class' => 'yii\grid\CheckboxColumn'],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'buttons'=>[
                                        'view'=>function ($url, $model) {
                                                $url = Yii::$app->getUrlManager()->createUrl(['contacts/view', 'id'=>$model['id']]); //$model->id для AR
                                                return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-eye-open"></span>', $url,
                                                    ['title' => Yii::t('app', 'View'), 'data-pjax' => '0', 'class' => 'view-contact']);
                                            }
                                    ],
                                    'template'=>'{view}',
                                ],
                                'assigned_to',
                                'ref',
                                [
                                    'label' => 'title',
                                    'value' => function ($dataProvider) use ($titleModel) {
                                            if ($dataProvider->title) {
                                                $title = $titleModel::findOne($dataProvider->title);
                                                if ($title) {
                                                    return $title->titles;
                                                } else {
                                                    return "not set";
                                                }

                                            }
                                        },
                                ],
                                'first_name',
                                'last_name',
                                'gender',
                                'date_of_birth',
                                [
                                    'label' => 'nationalities',
                                    'value' => function ($dataProvider) use ($nationModel) {
                                            if ($dataProvider->nationalities) {
                                                $nationalities = $nationModel::findOne($dataProvider->nationalities);
                                                if ($nationalities) {
                                                    return $nationalities->national;
                                                } else {
                                                    return "not set";
                                                }

                                            }
                                        },
                                ],
                                [
                                    'label' => 'religion',
                                    'value' => function ($dataProvider) use ($religionModel) {
                                            if ($dataProvider->religion) {
                                                $religion = $religionModel::findOne($dataProvider->religion);
                                                if ($religion) {
                                                    return $religion->religions;
                                                } else {
                                                    return "not set";
                                                }

                                            }

                                        },
                                ],
                                'languagesd',
                                'hobbies',
                                'mobile',
                                'phone',
                                'email:email',
                                'address',
                                'fb',
                                'tw',
                                'linkedin',
                                'skype',
                                'googlplus',
                                'wechat',
                                'in',
                                [
                                    'label' => 'contact source',
                                    'value' => function ($dataProvider) use ($ContactSoursModel) {
                                            if ($dataProvider->contact_source) {
                                                $contactSource = $ContactSoursModel::findOne($dataProvider->contact_source);
                                                if ($contactSource) {
                                                    return $contactSource->source;
                                                } else {
                                                    return "not set";
                                                }

                                            }
                                        },
                                ],
                                'company_name',
                                //'designation',
                                'contact_type',
                                'created_by',
                                //'notes',
                                //'documents',
                            ],
                        ]); ?>
                    </div>


                </div>
            </div>
        </div>
    </div>



</div>

<?php $this->registerJsFile('@web/new-design/js/listings.js', ['depends' => 'yii\web\JqueryAsset']); ?>
