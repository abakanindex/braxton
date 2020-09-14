<?php

use app\models\Company;
use app\models\Leads;
use app\models\reference_books\PropertyCategory;
use app\models\User;
use app\models\UserProfile;
use app\modules\lead\models\CompanySource;
use app\modules\lead\models\LeadSubStatus;
use app\modules\lead\models\LeadType;
use kartik\grid\GridView;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


?>

<div class="container-fluid  bottom-rentals-content clearfix"><!--    Bottom Rentals Block      -->
    <div id="listings-tab">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#current-listings" data-toggle="tab">
                    <?= Yii::t('app', 'Current Leads') ?></a>
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
                <div class="pane-header container-fluid clearfix">
                    <!--<form class="form-horizontal" id="filterBlock">
                        <div>

                        </div>
                        <div class="col-sm-12">
                            <div class="form-group col-sm-4">
                                <label for="filterAgentListings" class="control-label col-sm-5">Agent Listings</label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="filterAgentListings">
                                        <option>Agent 1</option>
                                        <option>Agent 2</option>
                                        <option>Agent 3</option>
                                        <option>Agent 4</option>
                                        <option>Agent 5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="filterCategoryDist" class="control-label col-sm-5">Category Dist.</label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="filterCategoryDist">
                                        <option>Category 1</option>
                                        <option>Category 2</option>
                                        <option>Category 3</option>
                                        <option>Category 4</option>
                                        <option>Category 5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="filterStatusDist" class="control-label col-sm-5">Status Dist.</label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="filterStatusDist">
                                        <option>Status 1</option>
                                        <option>Status 2</option>
                                        <option>Status 3</option>
                                        <option>Status 4</option>
                                        <option>Status 5</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group col-sm-4">
                                <label for="filterPriceRange" class="control-label col-sm-5">Price Range</label>
                                <div class=" col-sm-7">
                                    <input id="filterPriceRange" type="text" class="span2 " value="" style="width: 100%;" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[250,450]"/>
                                    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css" rel="stylesheet">
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
                                    <script>var slider = new Slider('#filterPriceRange', {});</script>
                                </div>

                            </div>
                            <div class="form-group col-sm-4">
                                <label for="filterLastUpdated" class="control-label col-sm-5">Last Updated</label>
                                <div class=" col-sm-7">
                                    <input id="filterLastUpdated" class="form-control" type="date">
                                </div>

                            </div>
                            <div class="form-group col-sm-4">
                                <label for="filterTopLocations" class="control-label col-sm-5">Top Locations</label>
                                <div class="col-sm-7">
                                    <select class="form-control" id="filterTopLocations">
                                        <option>Top Locations 1</option>
                                        <option>Top Locations 2</option>
                                        <option>Top Locations 3</option>
                                        <option>Top Locations 4</option>
                                        <option>Top Locations 5</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </form>-->
                </div>
                <div id="customizing-block" class="container-fluid clearfix">
                    <div class="button-block first-block">
                        <p>
                            <?= Html::a(Yii::t('app', 'Create Lead'), ['create'], ['class' => 'btn btn-success']) ?>
                        </p>
                        <!--<div style="display: inline-block;">
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
                    </div>-->


                </div>


                <!-- BIG listings Table-->
                <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class=" container-fluid clearfix">
                    <table id="listings_row" class="table table-bordered" align="center">
                        <thead align="left" class="header-table">
                        <tr role="row">
                            <th><input style="width:15px; margin-right:-10px;" onclick="toggleChecked(this.checked)" id="check_all_checkboxes" value="" type="checkbox"></th>
                            <th><div style="min-width: 8px;"></div></th>
                            <th><div title="Color code">CC</div></th>

                            <th><div>Ref</div></th>
                            <th><div>Type</div></th>
                            <th><div>Status</div></th>
                            <th><div>Sub Status</div></th>
                            <th><div>Priority</div></th>
                            <th><div>Hot</div></th>
                            <th><div>First Name</div></th>
                            <th><div>Last Name</div></th>
                            <th><div>Mobile No</div></th>
                            <th><div>Category</div></th>
                            <th><div>Emirate</div></th>
                            <th><div>Location</div></th>
                            <th><div>Sub-location</div></th>
                            <th><div>Unit Type</div></th>
                            <th><div>Unit No</div></th>
                            <th><div>Min Beds</div></th>
                            <th><div>Max Beds</div></th>
                            <th><div>Min Price</div></th>
                            <th><div>Max Price</div></th>
                            <th><div>Min Area</div></th>
                            <th><div>Max Area</div></th>
                            <th><div>Listing Ref</div></th>
                            <th><div>Source</div></th>
                            <th><div>Agent 1</div></th>
                            <th><div>Agent 2</div></th>
                            <th><div>Agent 3</div></th>
                            <th><div>Agent 4</div></th>
                            <th><div>Agent 5</div></th>
                            <th><div>Created By</div></th>
                            <th><div>Finance</div></th>
                            <th><div>Enquiry Date</div></th>
                            <th><div>Updated</div></th>
                            <th><div>Agent Referral</div></th>
                            <th><div>Shared Lead</div></th>
                            <th><div>Contact Company</div></th>
                            <th><div>Email Address</div></th>
                        </tr>
                        </thead>

                        <thead id="searchbox">
                        <tr class="search_box">
                            <form id="LeadForm" class="form-inline"></form>
                            <td><a id="reset_filter" style="display:none;" href="#"><i class="fa fa-redo"></i></a></td>
                            <td></td>
                            <td>
                                <div class="form-group">
                                    <select id="columnColorCode" class="form-control" style="font-family: FontAwesome, sans-serif;">
                                        <option>Select</option>
                                        <option class="lead-color-code-red">■</option>
                                        <option class="lead-color-code-green">■</option>
                                        <option class="lead-color-code-blue">■</option>
                                    </select>
                                </div>
                            </td>

                            <td>
                                <div class="form-group">
                                    <input id="columnLeadRef" type="text" class="form-control" placeholder="Min 3 chars">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="form-group">
                                        <select class="form-control" id="columnLeadType">
                                            <option>Select</option>
                                            <option>Tenant</option>
                                            <option>Buyer</option>
                                            <option>Landlord</option>
                                            <option>Seller</option>
                                            <option>Landlord+Seller</option>
                                            <option>Not Specified</option>
                                            <option>Investor</option>
                                            <option>Agent</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="form-group">
                                        <select class="form-control" id="columnLeadStatus">
                                            <option>Select</option>
                                            <option>Open</option>
                                            <option>Closed</option>
                                            <option>Not Specified</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="form-group">
                                        <select class="form-control" id="columnLeadSubStatus">
                                            <option>Select</option>
                                            <option>Open</option>
                                            <option>Closed</option>
                                            <option>Not Specified</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select class="form-control" id="columnLeadPriority">
                                        <option>Select</option>
                                        <option>Urgent</option>
                                        <option>High</option>
                                        <option>Low</option>
                                        <option>Normal</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select class="form-control" id="columnLeadHot">
                                        <option>Select</option>
                                        <option>Yes</option>
                                        <option>No</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input id="columnLeadFirstName" type="text" class="form-control">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input id="columnLeadLastName" type="text" class="form-control">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input id="columnLeadMobile" class="form-control" type="text" placeholder="">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select id="columnLeadCategory" class="form-control">
                                        <option value="" selected="">Select</option>
                                        <option value="1">Apartment</option>
                                        <option value="2">Villa</option>
                                        <option value="3">Office</option>
                                        <option value="4">Retail</option>
                                        <option value="5">Hotel Apartment</option>
                                        <option value="6">Warehouse</option>
                                        <option value="7">Land Commercial</option>
                                        <option value="8">Labour Camp</option>
                                        <option value="9">Residential Building</option>
                                        <option value="10">Multiple Sale Units</option>
                                        <option value="11">Land Residential</option>
                                        <option value="12">Commercial Full Building</option>
                                        <option value="13">Penthouse</option>
                                        <option value="14">Duplex</option>
                                        <option value="15">Loft Apartment</option>
                                        <option value="16">Townhouse</option>
                                        <option value="17">Hotel</option>
                                        <option value="18">Land Mixed Use</option>
                                        <option value="21">Compound</option>
                                        <option value="24">Half Floor</option>
                                        <option value="27">Full Floor</option>
                                        <option value="30">Commercial Villa</option>
                                        <option value="48">Bungalow</option>
                                        <option value="50">Factory</option>
                                        <option value="52">Staff Accommodation</option>
                                        <option value="55">Multiple Rental Units</option>
                                        <option value="58">Residential Full Floor</option>
                                        <option value="61">Commercial Full Floor</option>
                                        <option value="64">Residential Half Floor</option>
                                        <option value="67">Commercial Half Floor</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select class="form-control" id="columnLeadEmirate">
                                        <option value="" selected="">Select</option>
                                        <option value="2">Abu Dhabi</option>
                                        <option value="4">Ajman</option>
                                        <option value="8">Al Ain</option>
                                        <option value="1">Dubai</option>
                                        <option value="7">Fujairah</option>
                                        <option value="6">Ras Al Khaimah</option>
                                        <option value="3">Sharjah</option>
                                        <option value="5">Umm Al Quwain</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input id="columnLeadLocation" type="text" class="form-control" placeholder="">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input id="columnLeadSub-location" type="text" class="form-control" placeholder="">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input id="columnLeadUnitType" type="text" class="form-control" placeholder="">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input id="columnLeadUnitNo" type="text" class="form-control">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input id="columnLeadMinBeds" type="text" class="form-control">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input id="columnLeadMaxBeds" type="text" class="form-control">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input id="columnLeadMinPrice" type="text" class="form-control">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input id="columnLeadMaxPrice" type="text" class="form-control">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input id="columnLeadMinArea" type="text" class="form-control">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input id="columnLeadMaxArea" type="text" class="form-control">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input id="columnLeadListingRef" type="text" class="form-control">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select id="columnLeadSource" class="form-control">
                                        <option value="" selected="">Select</option>
                                        <option value="7 days">7 days</option>
                                        <option value="Abu Dhabi week">Abu Dhabi week</option>
                                        <option value="abudhabi.classonet.com">abudhabi.classonet.com</option>
                                        <option value="Agent">Agent</option>
                                        <option value="Agent External">Agent External</option>
                                        <option value="Agent Internal">Agent Internal</option>
                                        <option value="Al Ayam">Al Ayam</option>
                                        <option value="Al Bayan">Al Bayan</option>
                                        <option value="Al Futtaim">Al Futtaim</option>
                                        <option value="Al Ittihad News paper">Al Ittihad News paper</option>
                                        <option value="Al Khaleej">Al Khaleej</option>
                                        <option value="Al Rai">Al Rai</option>
                                        <option value="AL Watan">AL Watan</option>
                                        <option value="Arab Times">Arab Times</option>
                                        <option value="Asharq Al Awsat">Asharq Al Awsat</option>
                                        <option value="Bank Referral">Bank Referral</option>
                                        <option value="Bayut.com">Bayut.com</option>
                                        <option value="Blackberry SMS">Blackberry SMS</option>
                                        <option value="Business Card">Business Card</option>
                                        <option value="Client referral">Client referral</option>
                                        <option value="Cold Call">Cold Call</option>
                                        <option value="Colours TV">Colours TV</option>
                                        <option value="Company Email">Company Email</option>
                                        <option value="Database">Database</option>
                                        <option value="Developer">Developer</option>
                                        <option value="Direct Call">Direct Call</option>
                                        <option value="Direct Client">Direct Client</option>
                                        <option value="Drive around">Drive around</option>
                                        <option value="Dubizzle Feature">Dubizzle Feature</option>
                                        <option value="Dubizzle.com">Dubizzle.com</option>
                                        <option value="Dzooom.com">Dzooom.com</option>
                                        <option value="Email campaign">Email campaign</option>
                                        <option value="Ertebat">Ertebat</option>
                                        <option value="Exhibition Stand">Exhibition Stand</option>
                                        <option value="Existing client">Existing client</option>
                                        <option value="EzEstate">EzEstate</option>
                                        <option value="EzHeights.com">EzHeights.com</option>
                                        <option value="Facebook">Facebook</option>
                                        <option value="Flyers">Flyers</option>
                                        <option value="Forbes Mailer">Forbes Mailer</option>
                                        <option value="Friend or Relative">Friend or Relative</option>
                                        <option value="Google">Google</option>
                                        <option value="Gulf Daily News">Gulf Daily News</option>
                                        <option value="Gulf News">Gulf News</option>
                                        <option value="Gulf News Mailer">Gulf News Mailer</option>
                                        <option value="Gulf Newspaper Freehold">Gulf Newspaper Freehold</option>
                                        <option value="Gulf Newspaper Residential">Gulf Newspaper Residential</option>
                                        <option value="Gulf Times">Gulf Times</option>
                                        <option value="Gulfnews Freehold">Gulfnews Freehold</option>
                                        <option value="Gulfpropertyportal.com">Gulfpropertyportal.com</option>
                                        <option value="Hut.ae">Hut.ae</option>
                                        <option value="Instagram">Instagram</option>
                                        <option value="JustProperty.com">JustProperty.com</option>
                                        <option value="JustRentals.com">JustRentals.com</option>
                                        <option value="JUWAI">JUWAI</option>
                                        <option value="Khaleej Times">Khaleej Times</option>
                                        <option value="LinkedIn">LinkedIn</option>
                                        <option value="Listanza">Listanza</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select id="columnLeadAgent1" class="form-control">
                                        <option value="" selected="">Select</option>
                                        <option value="1456980">Abduvoris Abdukhalilov</option>
                                        <option value="1456135">Ahmed Teddy Samir</option>
                                        <option value="1457128">Amelia Quaye</option>
                                        <option value="1459191">Andreas  Malmestedt</option>
                                        <option value="14227">Angelica Gozum</option>
                                        <option value="1459851">Anna Szabunia</option>
                                        <option value="1458061">Arnd Hannecke</option>
                                        <option value="1466578">Arslan Afzal</option>
                                        <option value="1459843">Ashley Brown</option>
                                        <option value="1457138">Benjamin Ray</option>
                                        <option value="1466188">Bilal Zafar</option>
                                        <option value="1453866">Camelia Savoye</option>
                                        <option value="1459301">Charu Gupta</option>
                                        <option value="775">Christoph Engels</option>
                                        <option value="1464877">Collins Kodjou</option>
                                        <option value="1467305">Demetrios Nikolaou</option>
                                        <option value="1462306">Deoclecio Junior</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select id="columnLeadAgent2" class="form-control">
                                        <option value="" selected="">Select</option>
                                        <option value="1456980">Abduvoris Abdukhalilov</option>
                                        <option value="1456135">Ahmed Teddy Samir</option>
                                        <option value="1457128">Amelia Quaye</option>
                                        <option value="1459191">Andreas  Malmestedt</option>
                                        <option value="14227">Angelica Gozum</option>
                                        <option value="1459851">Anna Szabunia</option>
                                        <option value="1458061">Arnd Hannecke</option>
                                        <option value="1466578">Arslan Afzal</option>
                                        <option value="1459843">Ashley Brown</option>
                                        <option value="1457138">Benjamin Ray</option>
                                        <option value="1466188">Bilal Zafar</option>
                                        <option value="1453866">Camelia Savoye</option>
                                        <option value="1459301">Charu Gupta</option>
                                        <option value="775">Christoph Engels</option>
                                        <option value="1464877">Collins Kodjou</option>
                                        <option value="1467305">Demetrios Nikolaou</option>
                                        <option value="1462306">Deoclecio Junior</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select id="columnLeadAgent3" class="form-control">
                                        <option value="" selected="">Select</option>
                                        <option value="1456980">Abduvoris Abdukhalilov</option>
                                        <option value="1456135">Ahmed Teddy Samir</option>
                                        <option value="1457128">Amelia Quaye</option>
                                        <option value="1459191">Andreas  Malmestedt</option>
                                        <option value="14227">Angelica Gozum</option>
                                        <option value="1459851">Anna Szabunia</option>
                                        <option value="1458061">Arnd Hannecke</option>
                                        <option value="1466578">Arslan Afzal</option>
                                        <option value="1459843">Ashley Brown</option>
                                        <option value="1457138">Benjamin Ray</option>
                                        <option value="1466188">Bilal Zafar</option>
                                        <option value="1453866">Camelia Savoye</option>
                                        <option value="1459301">Charu Gupta</option>
                                        <option value="775">Christoph Engels</option>
                                        <option value="1464877">Collins Kodjou</option>
                                        <option value="1467305">Demetrios Nikolaou</option>
                                        <option value="1462306">Deoclecio Junior</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select id="columnLeadAgent4" class="form-control">
                                        <option value="" selected="">Select</option>
                                        <option value="1456980">Abduvoris Abdukhalilov</option>
                                        <option value="1456135">Ahmed Teddy Samir</option>
                                        <option value="1457128">Amelia Quaye</option>
                                        <option value="1459191">Andreas  Malmestedt</option>
                                        <option value="14227">Angelica Gozum</option>
                                        <option value="1459851">Anna Szabunia</option>
                                        <option value="1458061">Arnd Hannecke</option>
                                        <option value="1466578">Arslan Afzal</option>
                                        <option value="1459843">Ashley Brown</option>
                                        <option value="1457138">Benjamin Ray</option>
                                        <option value="1466188">Bilal Zafar</option>
                                        <option value="1453866">Camelia Savoye</option>
                                        <option value="1459301">Charu Gupta</option>
                                        <option value="775">Christoph Engels</option>
                                        <option value="1464877">Collins Kodjou</option>
                                        <option value="1467305">Demetrios Nikolaou</option>
                                        <option value="1462306">Deoclecio Junior</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select id="columnLeadAgent5" class="form-control">
                                        <option value="" selected="">Select</option>
                                        <option value="1456980">Abduvoris Abdukhalilov</option>
                                        <option value="1456135">Ahmed Teddy Samir</option>
                                        <option value="1457128">Amelia Quaye</option>
                                        <option value="1459191">Andreas  Malmestedt</option>
                                        <option value="14227">Angelica Gozum</option>
                                        <option value="1459851">Anna Szabunia</option>
                                        <option value="1458061">Arnd Hannecke</option>
                                        <option value="1466578">Arslan Afzal</option>
                                        <option value="1459843">Ashley Brown</option>
                                        <option value="1457138">Benjamin Ray</option>
                                        <option value="1466188">Bilal Zafar</option>
                                        <option value="1453866">Camelia Savoye</option>
                                        <option value="1459301">Charu Gupta</option>
                                        <option value="775">Christoph Engels</option>
                                        <option value="1464877">Collins Kodjou</option>
                                        <option value="1467305">Demetrios Nikolaou</option>
                                        <option value="1462306">Deoclecio Junior</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select id="columnLeadCreatedBy" class="form-control">
                                        <option value="" selected="">Select</option>
                                        <option value="1456980">Abduvoris Abdukhalilov</option>
                                        <option value="1456135">Ahmed Teddy Samir</option>
                                        <option value="1457128">Amelia Quaye</option>
                                        <option value="1459191">Andreas  Malmestedt</option>
                                        <option value="14227">Angelica Gozum</option>
                                        <option value="1459851">Anna Szabunia</option>
                                        <option value="1458061">Arnd Hannecke</option>
                                        <option value="1466578">Arslan Afzal</option>
                                        <option value="1459843">Ashley Brown</option>
                                        <option value="1457138">Benjamin Ray</option>
                                        <option value="1466188">Bilal Zafar</option>
                                        <option value="1453866">Camelia Savoye</option>
                                        <option value="1459301">Charu Gupta</option>
                                        <option value="775">Christoph Engels</option>
                                        <option value="1464877">Collins Kodjou</option>
                                        <option value="1467305">Demetrios Nikolaou</option>
                                        <option value="1462306">Deoclecio Junior</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select id="columnLeadFinance" class="form-control">
                                        <option value="" selected="">Select</option>
                                        <option value="1">Cash</option>
                                        <option value="2">Loan (approved)</option>
                                        <option value="3">Loan (not approved)</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select id="columnLeadEnquiryDate" class="form-control" style="font-family: FontAwesome, sans-serif;">
                                        <option value="" selected="">Select</option>
                                        <option value="0" style="color: #6eb52c;"></option>
                                        <option value="1" style="color: #6eb52c;"></option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select id="columnLeadUpdated" class="form-control" style="font-family: FontAwesome, sans-serif;">
                                        <option value="" selected="">Select</option>
                                        <option value="0" style="color: #6eb52c;"></option>
                                        <option value="1" style="color: #6eb52c;"></option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select id="columnLeadAgentReferral" class="form-control" style="font-family: FontAwesome, sans-serif;">
                                        <option value="" selected="">Select</option>
                                        <option value="0" style="color: #6eb52c;"></option>
                                        <option value="1" style="color: #6eb52c;"></option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select id="columnLeadShare" class="form-control" style="font-family: FontAwesome, sans-serif;">
                                        <option value="" selected="">Select</option>
                                        <option value="0" style="color: #6eb52c;"></option>
                                        <option value="1" style="color: #6eb52c;"></option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input id="columnLeadContactCompany" type="text" class="form-control">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input id="columnLeadEmailAddress" type="text" class="form-control">
                                </div>
                            </td>


                        </tr>
                        </thead>

                        <tbody>
                        <tr id="1576257625436385" class="">
                            <td class="cell-in-row"><div><input type="checkbox"></div></td>
                            <td class="cell-in-row"><a href="#" class="scroll-up"><i class="fa fa-eye"></i></a></td>
                            <td class="cell-in-row"><i class="lead-color-code-red">■</i></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">KI-L-27142</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Tenant</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Open</div></td>
                            <td class="cell-in-row">Not yet contacted</td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Normal</div></td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Mattia</div></td>
                            <td class="cell-in-row">Sterbizzi</td>
                            <td class="cell-in-row">+971621564476</td>
                            <td class="cell-in-row">Apartment</td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Dubai</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">DIFC</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Sky Gardens</div></td>
                            <td class="cell-in-row">17</td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row">1</td>
                            <td class="cell-in-row">0</td>
                            <td class="cell-in-row">119,990</td>
                            <td class="cell-in-row">0</td>
                            <td class="cell-in-row">789</td>
                            <td class="cell-in-row">0</td>
                            <td class="cell-in-row">KI-R-4183</td>
                            <td class="cell-in-row">JustProperty.com</td>
                            <td class="cell-in-row">Deoclecio Junior</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">Deoclecio Junior</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">14-02-2018 13:40</td>
                            <td class="cell-in-row">14-02-2018</td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row">mattia.sterbizzi@gmail.com</td>
                        </tr>
                        <tr id="1576257625436386" class="">
                            <td class="cell-in-row"><div><input type="checkbox"></div></td>
                            <td class="cell-in-row"><a href="#" class="scroll-up"><i class="fa fa-eye"></i></a></td>
                            <td class="cell-in-row"><i class="lead-color-code-green">■</i></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">KI-L-27142</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Tenant</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Open</div></td>
                            <td class="cell-in-row">Not yet contacted</td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Normal</div></td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Mattia</div></td>
                            <td class="cell-in-row">Sterbizzi</td>
                            <td class="cell-in-row">+971621564476</td>
                            <td class="cell-in-row">Apartment</td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Dubai</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">DIFC</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Sky Gardens</div></td>
                            <td class="cell-in-row">17</td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row">1</td>
                            <td class="cell-in-row">0</td>
                            <td class="cell-in-row">119,990</td>
                            <td class="cell-in-row">0</td>
                            <td class="cell-in-row">789</td>
                            <td class="cell-in-row">0</td>
                            <td class="cell-in-row">KI-R-4183</td>
                            <td class="cell-in-row">JustProperty.com</td>
                            <td class="cell-in-row">Deoclecio Junior</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">Deoclecio Junior</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">14-02-2018 13:40</td>
                            <td class="cell-in-row">14-02-2018</td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row">mattia.sterbizzi@gmail.com</td>
                        </tr>
                        <tr id="1576257625436387" class="">
                            <td class="cell-in-row"><div><input type="checkbox"></div></td>
                            <td class="cell-in-row"><a href="#" class="scroll-up"><i class="fa fa-eye"></i></a></td>
                            <td class="cell-in-row"><i class="lead-color-code-blue">■</i></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">KI-L-27142</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Tenant</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Open</div></td>
                            <td class="cell-in-row">Not yet contacted</td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Normal</div></td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Mattia</div></td>
                            <td class="cell-in-row">Sterbizzi</td>
                            <td class="cell-in-row">+971621564476</td>
                            <td class="cell-in-row">Apartment</td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Dubai</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">DIFC</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Sky Gardens</div></td>
                            <td class="cell-in-row">17</td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row">1</td>
                            <td class="cell-in-row">0</td>
                            <td class="cell-in-row">119,990</td>
                            <td class="cell-in-row">0</td>
                            <td class="cell-in-row">789</td>
                            <td class="cell-in-row">0</td>
                            <td class="cell-in-row">KI-R-4183</td>
                            <td class="cell-in-row">JustProperty.com</td>
                            <td class="cell-in-row">Deoclecio Junior</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">Deoclecio Junior</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">14-02-2018 13:40</td>
                            <td class="cell-in-row">14-02-2018</td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row">mattia.sterbizzi@gmail.com</td>
                        </tr>
                        <tr id="1576257625436388" class="">
                            <td class="cell-in-row"><div><input type="checkbox"></div></td>
                            <td class="cell-in-row"><a href="#" class="scroll-up"><i class="fa fa-eye"></i></a></td>
                            <td class="cell-in-row"><i class="lead-color-code-red">■</i></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">KI-L-27142</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Tenant</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Open</div></td>
                            <td class="cell-in-row">Not yet contacted</td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Normal</div></td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Mattia</div></td>
                            <td class="cell-in-row">Sterbizzi</td>
                            <td class="cell-in-row">+971621564476</td>
                            <td class="cell-in-row">Apartment</td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Dubai</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">DIFC</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Sky Gardens</div></td>
                            <td class="cell-in-row">17</td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row">1</td>
                            <td class="cell-in-row">0</td>
                            <td class="cell-in-row">119,990</td>
                            <td class="cell-in-row">0</td>
                            <td class="cell-in-row">789</td>
                            <td class="cell-in-row">0</td>
                            <td class="cell-in-row">KI-R-4183</td>
                            <td class="cell-in-row">JustProperty.com</td>
                            <td class="cell-in-row">Deoclecio Junior</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">Deoclecio Junior</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">14-02-2018 13:40</td>
                            <td class="cell-in-row">14-02-2018</td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row">mattia.sterbizzi@gmail.com</td>
                        </tr>
                        <tr id="1576257625436389" class="">
                            <td class="cell-in-row"><div><input type="checkbox"></div></td>
                            <td class="cell-in-row"><a href="#" class="scroll-up"><i class="fa fa-eye"></i></a></td>
                            <td class="cell-in-row"><i class="lead-color-code-blue">■</i></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">KI-L-27142</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Tenant</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Open</div></td>
                            <td class="cell-in-row">Not yet contacted</td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Normal</div></td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Mattia</div></td>
                            <td class="cell-in-row">Sterbizzi</td>
                            <td class="cell-in-row">+971621564476</td>
                            <td class="cell-in-row">Apartment</td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Dubai</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">DIFC</div></td>
                            <td class="cell-in-row"><div class="overflow" rel="1576257625436389">Sky Gardens</div></td>
                            <td class="cell-in-row">17</td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row">1</td>
                            <td class="cell-in-row">0</td>
                            <td class="cell-in-row">119,990</td>
                            <td class="cell-in-row">0</td>
                            <td class="cell-in-row">789</td>
                            <td class="cell-in-row">0</td>
                            <td class="cell-in-row">KI-R-4183</td>
                            <td class="cell-in-row">JustProperty.com</td>
                            <td class="cell-in-row">Deoclecio Junior</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">Deoclecio Junior</td>
                            <td class="cell-in-row">- -</td>
                            <td class="cell-in-row">14-02-2018 13:40</td>
                            <td class="cell-in-row">14-02-2018</td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row"></td>
                            <td class="cell-in-row">mattia.sterbizzi@gmail.com</td>
                        </tr>
                        </tbody>

                    </table>

                    <?php Pjax::begin(); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            [
                                'attribute' => 'reference',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Html::a($model->reference, ['leads/' . $model->slug]);
                                },
                            ],
                            ['attribute' => 'type',
                                'value' => 'leadType.title',
                                'filter' => ArrayHelper::map(LeadType::find()->asArray()->all(), 'id', 'title'),
                                'contentOptions' => ['style' => 'min-width:170px;'],
                                'headerOptions' => ['style' => 'min-width:170px;'],
                            ],
                            [
                                'attribute' => 'status',
                                'value' => function ($model) {
                                    return $model->getStatus();
                                },
                                'filter' => Leads::getStatuses(),
                                'contentOptions' => ['style' => 'min-width:150px;'],
                                'headerOptions' => ['style' => 'min-width:150px;'],
                            ],
                            [
                                'attribute' => 'subStatus',
                                'value' => 'subStatus.title',
                                'filter' => ArrayHelper::map(LeadSubStatus::find()->asArray()->all(), 'id', 'title'),
                                'headerOptions' => ['style' => 'min-width:180px;'],
                            ],
                            [
                                'attribute' => 'priority',
                                'value' => function ($model) {
                                    return $model->getPriority();
                                },
                                'filter' => Leads::getPriorities(),
                                'headerOptions' => ['style' => 'min-width:120px;'],
                            ],
                            [
                                'attribute' => 'first_name',
                                'headerOptions' => ['style' => 'min-width:100px;'],
                            ],
                            [
                                'attribute' => 'last_name',
                                'headerOptions' => ['style' => 'min-width:100px;'],
                            ],
                            [
                                'attribute' => 'mobile_number',
                                'headerOptions' => ['style' => 'min-width:100px;'],
                            ],
                            [
                                'attribute' => 'category',
                                'value' => 'category.title',
                                'filter' => ArrayHelper::map(PropertyCategory::find()->asArray()->all(), 'id', 'title'),
                                'headerOptions' => ['style' => 'min-width:140px;'],
                            ],
                            [
                                'attribute' => 'location',
                                'headerOptions' => ['style' => 'min-width:100px;'],
                            ],
                            [
                                'attribute' => 'sub_location',
                                'headerOptions' => ['style' => 'min-width:100px;'],
                            ],
                            [
                                'attribute' => 'unit_type',
                                'headerOptions' => ['style' => 'min-width:100px;'],
                            ],
                            [
                                'attribute' => 'unit_number',
                                'headerOptions' => ['style' => 'min-width:100px;'],
                            ],
                            [
                                'attribute' => 'beds',
                                'headerOptions' => ['style' => 'min-width:100px;'],
                            ],
                            [
                                'attribute' => 'price',
                                'headerOptions' => ['style' => 'min-width:100px;'],
                            ],
                            [
                                'attribute' => 'area',
                                'headerOptions' => ['style' => 'min-width:100px;'],
                            ],
                            [
                                'attribute' => 'source',
                                'value' => 'source.title',
                                'filter' => ArrayHelper::map(CompanySource::find()->asArray()->all(), 'id', 'title'),
                            ],
                            [
                                'attribute' => 'created_by_user',
                                'headerOptions' => ['style' => 'width:100%'],
                                'value' => 'createdByUser.username',
                                'filter' => $userCreatedFilter,
                                'headerOptions' => ['style' => 'min-width:150px;'],
                            ],
                            [
                                'attribute' => 'agent',
                                'format' => 'raw',
                                'label'  => Yii::t('app', 'Agents'),
                                'headerOptions' => ['style' => 'width:100%'],
                                'value' => function ($model, $index, $widget) {
                                    $agentsList = '<ul style="list-style: none">';
                                    foreach ($model->leadAgents as $agent)
                                        $agentsList .= '<li>' . $agent->agent->username . '</li>';
                                    $agentsList .= '</ul>';
                                    return $agentsList;
                                },
                                'filter' => $userCreatedFilter,
                            ],
                            [
                                'attribute' => 'finance_type',
                                'value' => function ($model) {
                                    return $model->getFinanceType();
                                },
                                'filter' => Leads::getFinanceTypes(),
                                'headerOptions' => ['style' => 'min-width:150px;'],
                            ],
                            [
                                'attribute' => 'enquiry_time',
                                'value' => function ($model, $index, $widget) {
                                    if ($model->enquiry_time)
                                        return Yii::$app->formatter->asDate($model->enquiry_time);
                                    else
                                        return '';
                                },
                                'filterType' => GridView::FILTER_DATE,
                                'filterWidgetOptions' => [
                                    'pluginOptions' => [
                                        'format' => 'dd-mm-yyyy',
                                        'autoclose' => true,
                                        'todayHighlight' => true,
                                    ]
                                ],
                                'headerOptions' => ['style' => 'min-width:200px;'],
                                'hAlign' => 'center',
                            ],
                            [
                                'attribute' => 'updated_time',
                                'value' => function ($model, $index, $widget) {
                                    return Yii::$app->formatter->asDate($model->updated_time);
                                },
                                'filterType' => GridView::FILTER_DATE,
                                'filterWidgetOptions' => [
                                    'pluginOptions' => [
                                        'format' => 'dd-mm-yyyy',
                                        'autoclose' => true,
                                        'todayHighlight' => true,
                                    ]
                                ],
                                'headerOptions' => ['style' => 'min-width:200px;'],
                                'hAlign' => 'center',
                            ],
                            [
                                'attribute' => 'contract_company',
                                'headerOptions' => ['style' => 'min-width:140px;'],
                            ],
                            [
                                'attribute' => 'email',
                                'headerOptions' => ['style' => 'min-width:140px;'],
                            ],
                            [
                                'attribute' => 'additionalEmails',
                                'format' => 'raw',
                                'value' => function ($model, $index, $widget) {
                                    $additionalEmailsList = '<ul style="list-style: none">';
                                    foreach ($model->additionalEmailsList as $additionalEmails)
                                        $additionalEmailsList .= '<li>' . $additionalEmails->email . '</li>';
                                    $additionalEmailsList .= '</ul>';
                                    return $additionalEmailsList;
                                },
                                'headerOptions' => ['style' => 'min-width:140px;'],
                            ],
                            [
                                'attribute' => 'socialMediaContacts',
                                'format' => 'raw',
                                'value' => function ($model, $index, $widget) {
                                    $socialMediaContactsList = '<ul style="list-style: none">';
                                    foreach ($model->leadSocialMeadiaContacts as $socialMediaContact) {
                                        $socialMediaContactsList .= '<li>' . Html::a(FA::icon($socialMediaContact->getBtnClass()), $socialMediaContact->link, ['target' => '_blank']) . '</li>';
                                    }
                                    $socialMediaContactsList .= '</ul>';
                                    return $socialMediaContactsList;
                                },
                                'headerOptions' => ['style' => 'min-width:140px;'],
                            ],
                            [
                                'attribute' => 'email_opt_out',
                                'value' => function ($model, $index, $widget) {
                                    if ($model->email_opt_out)
                                        $email_opt_out = Yii::t('app', 'yes');
                                    else
                                        $email_opt_out = '';
                                    return $email_opt_out;
                                },
                            ],
                            [
                                'attribute' => 'phone_opt_out',
                                'value' => function ($model, $index, $widget) {
                                    if ($model->phone_opt_out)
                                        $phone_opt_out = Yii::t('app', 'yes');
                                    else
                                        $phone_opt_out = '';
                                    return $phone_opt_out;
                                },
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => '',
                                'template' => '{view}{update}{delete}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['leads/' . $model->slug]);
                                    },
                                    'delete' => function ($url, $model) {
                                        $activityUrl = Url::to(['/leads/activity', 'id' => $model->id]);
                                        if ($model->activity == Leads::ACTIVITY_ACTIVE) {
                                            $glyphiconColor = 'color: #008000;';
                                            $btnText = Yii::t('yii', 'Deactivate');
                                        } else {
                                            $glyphiconColor = 'color: #FF0000';
                                            $btnText = Yii::t('yii', 'Activate');
                                        }
                                        return Html::a('<span style=" ' . $glyphiconColor . ' " class="activity-btn glyphicon glyphicon-off"></span>', '#', [
                                            'title' => $btnText,
                                            'aria-label' => $btnText,
                                            'onclick' => "  
                                var thItem = $(this).closest('tr'); 
                                $.ajax({ 
                                url: '$activityUrl',  
                                 type: 'GET',
                                 dataType: 'json',
                                 success: function(data) {
                                      if ( data.result == 'success' ) {
                                        if ( data.activity == 'not_active' )
                                            thItem.find('.activity-btn').css('color', '#FF0000');
                                            else
                                            thItem.find('.activity-btn').css('color', '#008000');
                                        }                                        
                                  }   
                                });     
                                return false;
                            ",
                                        ]);
                                    },
                                ]
                            ]
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
                <div class="page-selector">

                    <nav aria-label="...">
                        <div class="select-page">
                            <label for="filterPageCount" class="col-sm-6">Show</label>

                            <select class="form-control" id="filterPageCount">
                                <option>5</option>
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                            </select>

                        </div>
                        <ul class="pagination pull-right">
                            <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li class="active"><a href="#">3<span class="sr-only">(current)</span></a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                        </ul>
                    </nav>

                </div>
                <!-- /BIG listings Table-->
            </div>
            <!--
            <div class="tab-pane" id="archived-listings">
                <p style="font-size: 56px; color: red;">Put The Archived Listings Table HERE</p>
            </div>
            <div class="tab-pane" id="pending-listings">
                <p style="font-size: 56px; color: red;">Put The Pending Listings Table HERE</p>
            </div>
            -->
        </div>
    </div>

</div>