<?php
	use machour\yii2\notifications\widgets\NotificationsWidget;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use app\modules\admin\Rbac;
	use app\models\User;
	
?>
<!---     Content       -->
<div id="content" class="container-fluid clearfix">

    <!--    Info Blocks      -->
    <div class="container-fluid content">
        <div class="col-xs-11 col-sm-5 col-md-5 col-lg-3 info-block " >
            <div class="icon-info-block">
                <i class="fa fa-archive" aria-hidden="true"></i>
            </div>
            <div class="data-info-block">
                <p class="info-block-count">150</p>
                <p class="info-block-text">New Product</p>
                <a href="#">More info <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="col-xs-11 col-sm-5 col-md-5 col-lg-3 info-block" >
            <div class="icon-info-block">
                <i class="fa fa-users" aria-hidden="true"></i>

            </div>
            <div class="data-info-block">
                <p class="info-block-count">44</p>
                <p class="info-block-text">User Registration</p>
                <a href="#">More info <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="col-xs-11 col-sm-5 col-md-5 col-lg-3 info-block" >
            <div class="icon-info-block">
                <i class="fa fa-comment-o" aria-hidden="true"></i>

            </div>
            <div class="data-info-block">
                <p class="info-block-count">65</p>
                <p class="info-block-text">Messages</p>
                <a href="#">More info <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </div><!--    /Info Blocks      -->


    <!--    Action Blocks      -->
    <div class="container-fluid content">

        <!--    Tasks Block      -->
        <div class="col-xs-11 col-sm-5 col-md-5 action-block" >
            <div class="headline">
                <div>Showing 1-4 of 4 items</div>
                <a class="btn btn-default pull-right" type="button" href="/web/task-manager/create"><i class="fa fa-plus"></i> Add task</a>
            </div>
            <table class="table table-striped task-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><a class="table-sort" href="#">Title</a></th>
                        <th><a class="table-sort" href="#">Deadline</a></th>
                        <th class="action-column">&nbsp;</th>
                    </tr>

                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>sdfsdf</td>
                    <td>2018-01-03 06:30</td>
                    <td>
                        <a href="#" title="View"><i class="fa fa-eye"></i></a>
                        <a href="#" title="Update"><i class="fa fa-pencil"></i></a>
                        <a href="#" title="Delete"><i class="fa fa-trash-o"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>sdfdsfds</td>
                    <td>2018-01-10 10:50</td>
                    <td>
                        <a href="#" title="View"><i class="fa fa-eye"></i></a>
                        <a href="#" title="Update"><i class="fa fa-pencil"></i></a>
                        <a href="#" title="Delete"><i class="fa fa-trash-o"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>new</td>
                    <td></td>
                    <td>
                        <a href="#" title="View"><i class="fa fa-eye"></i></a>
                        <a href="#" title="Update"><i class="fa fa-pencil"></i></a>
                        <a href="#" title="Delete"><i class="fa fa-trash-o"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>sdfdsfsdfsd</td>
                    <td>2018-01-18 10:50</td>
                    <td>
                        <a href="#" title="View"><i class="fa fa-eye"></i></a>
                        <a href="#" title="Update"><i class="fa fa-pencil"></i></a>
                        <a href="#" title="Delete"><i class="fa fa-trash-o"></i></a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div><!--    /Tasks Block      -->

        <!--    Email Block      -->
        <div class="col-xs-11 col-sm-5 col-md-5 action-block" >
            <div class="headline">
                <div>Quick Email</div>
                <a class="pull-right" href="#"><i class="fa fa-times"></i></a>
            </div>
            <form id="mailer-form" class="">
                <div class="form-group">
                    <label for="mailerform-fromname">From Name</label>
                    <input type="text" class="form-control" id="mailerform-fromname" placeholder="">
                    <p class="help-block help-block-error">Example error</p>
                </div>
                <div class="form-group col-xs-6 padding-right">
                    <label for="mailerform-fromemail">From Email</label>
                    <input type="email" class="form-control" id="mailerform-fromemail" placeholder="">
                    <p class="help-block help-block-error">Example error</p>
                </div>
                <div class="form-group col-xs-6 padding-left">
                    <label for="mailerform-toemail">To Email</label>
                    <input type="email" class="form-control" id="mailerform-toemail" placeholder="">
                    <p class="help-block help-block-error">Example error</p>
                </div>
                <div class="form-group">
                    <label for="mailerform-subject">Subject</label>
                    <input type="text" class="form-control" id="mailerform-subject" placeholder="">
                    <p class="help-block help-block-error">Example error</p>
                </div>
                <div class="form-group">
                    <label for="mailerform-body">Body</label>
                    <textarea rows="3" class="form-control" id="mailerform-body" placeholder=""></textarea>
                    <p class="help-block help-block-error">Example error</p>
                </div>

                <button type="submit" class="btn btn-default pull-right">Submit</button>
            </form>
        </div><!--    /Email Blocks      -->

    </div><!--    /Action Blocks      -->


    <!--    Chat Block      -->
    <div class="container-fluid content">
        <div class="col-xs-11 col-sm-10 col-md-10 chat-block" >
            <div class="headline">
                <div>Quick Email</div>
                <a class="pull-right" href="#"><i class="fa fa-times"></i></a>
            </div>
            <div class="box-body chat" id="chat-box">
                <!-- chat item -->
                <div class="item">
                    <img alt="user image" class="online img-circle" src="<?= Url::to('@web/new-design/img/user3-128x128.jpg') ?>">
                    <div class="message">
                        <a class="name" href="#"> Mike Doe<small class="text-muted"> 2:15</small></a>
                        <p> I would like to meet you to discuss the latest news about the arrival of the new theme. They say it is going to be one the best themes on the market</p>

                        <!-- attachment -->
                        <div class="attachment">
                            <h4>Attachments:</h4>
                            <p class="filename">Theme-thumbnail-image.jpg</p>
                            <div class="pull-right">
                                <button class="btn btn-primary btn-sm btn-flat" type="button">Open</button>
                            </div>
                        </div><!-- /attachment -->
                    </div>
                </div><!-- /item -->

                <!-- chat item -->
                <div class="item">
                    <img alt="user image" class="online img-circle" src="<?= Url::to('@web/new-design/img/user3-128x128.jpg') ?>">
                    <div class="message">
                        <a class="name" href="#"> Mike Doe<small class="text-muted"> 2:15</small></a>
                        <p> I would like to meet you to discuss the latest news about the arrival of the new theme. They say it is going to be one the best themes on the market</p>

                    </div>
                </div><!-- /item -->

                <!-- chat item -->
                <div class="item">
                    <img alt="user image" class="online img-circle" src="<?= Url::to('@web/new-design/img/user3-128x128.jpg') ?>">
                    <div class="message">
                        <a class="name" href="#"> Mike Doe<small class="text-muted"> 2:15</small></a>
                        <p> I would like to meet you to discuss the latest news about the arrival of the new theme. They say it is going to be one the best themes on the market</p>

                    </div>
                </div><!-- /item -->
            </div>
            <form id="chat-message" class="">
                <div class="form-group">
                    <textarea rows="3" class="form-control" id="chat-message-text" placeholder="Type message"></textarea>
                </div>
                <button type="submit" class="btn btn-default pull-right">Send</button>
            </form>
        </div>
    </div><!--    /Chat Block      -->


</div><!---     Content       -->