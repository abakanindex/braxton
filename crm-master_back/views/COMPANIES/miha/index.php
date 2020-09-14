<?php

/* @var $this yii\web\View */

$this->title = 'SystaVision CRM';
?>
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>150</h3>
                <p>New Products</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div><a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>44</h3>
                <p>User Registrations</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div><a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>65</h3>
                <p>Messege</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div><a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
</div><!-- /.row -->
<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-7 connectedSortable">
        <!-- Chat box -->
        <div class="box box-success">
            <div class="box-header">
                <i class="fa fa-comments-o"></i>
                <h3 class="box-title">Chat</h3>
                <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
                    <div class="btn-group" data-toggle="btn-toggle">
                        <button class="btn btn-default btn-sm active" type="button"><i class="fa fa-square text-green"></i></button> <button class="btn btn-default btn-sm" type="button"><i class="fa fa-square text-red"></i></button>
                    </div>
                </div>
            </div>
            <div class="box-body chat" id="chat-box">
                <!-- chat item -->
                <div class="item">
                    <img alt="user image" class="online" src="dist/img/user4-128x128.jpg">
                    <p class="message"><a class="name" href="#"><small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small> Mike Doe</a> I would like to meet you to discuss the latest news about the arrival of the new theme. They say it is going to be one the best themes on the market</p>
                    <div class="attachment">
                        <h4>Attachments:</h4>
                        <p class="filename">Theme-thumbnail-image.jpg</p>
                        <div class="pull-right">
                            <button class="btn btn-primary btn-sm btn-flat" type="button">Open</button>
                        </div>
                    </div><!-- /.attachment -->
                </div><!-- /.item -->
                <!-- chat item -->
                <div class="item">
                    <img alt="user image" class="offline" src="dist/img/user3-128x128.jpg">
                    <p class="message"><a class="name" href="#"><small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:15</small> Alexander Pierce</a> I would like to meet you to discuss the latest news about the arrival of the new theme. They say it is going to be one the best themes on the market</p>
                </div><!-- /.item -->
                <!-- chat item -->
                <div class="item">
                    <img alt="user image" class="offline" src="dist/img/user2-160x160.jpg">
                    <p class="message"><a class="name" href="#"><small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:30</small> Susan Doe</a> I would like to meet you to discuss the latest news about the arrival of the new theme. They say it is going to be one the best themes on the market</p>
                </div><!-- /.item -->
            </div><!-- /.chat -->
            <div class="box-footer">
                <div class="input-group">
                    <input class="form-control" placeholder="Type message...">
                    <div class="input-group-btn">
                        <button class="btn btn-success" type="button"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
        </div><!-- /.box (chat box) -->
        <!-- TO DO List -->
        <div class="box box-primary">
            <div class="box-header">
                <i class="ion ion-clipboard"></i>
                <h3 class="box-title">To Do List</h3>
                <div class="box-tools pull-right">
                    <ul class="pagination pagination-sm inline">
                        <li>
                            <a href="#">&laquo;</a>
                        </li>
                        <li>
                            <a href="#">1</a>
                        </li>
                        <li>
                            <a href="#">2</a>
                        </li>
                        <li>
                            <a href="#">3</a>
                        </li>
                        <li>
                            <a href="#">&raquo;</a>
                        </li>
                    </ul>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                <ul class="todo-list">
                    <li>
                        <!-- drag handle -->
                         <span class="handle"><i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i></span> <!-- checkbox -->
                         <input type="checkbox" value=""> <!-- todo text -->
                         <span class="text">Design a nice theme</span> <!-- Emphasis label -->
                         <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small> <!-- General tools such as edit or delete-->
                        <div class="tools">
                            <i class="fa fa-edit"></i> <i class="fa fa-trash-o"></i>
                        </div>
                    </li>
                    <li>
                        <span class="handle"><i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i></span> <input type="checkbox" value=""> <span class="text">Make the theme responsive</span> <small class="label label-info"><i class="fa fa-clock-o"></i> 4 hours</small>
                        <div class="tools">
                            <i class="fa fa-edit"></i> <i class="fa fa-trash-o"></i>
                        </div>
                    </li>
                    <li>
                        <span class="handle"><i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i></span> <input type="checkbox" value=""> <span class="text">Let theme shine like a star</span> <small class="label label-warning"><i class="fa fa-clock-o"></i> 1 day</small>
                        <div class="tools">
                            <i class="fa fa-edit"></i> <i class="fa fa-trash-o"></i>
                        </div>
                    </li>
                    <li>
                        <span class="handle"><i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i></span> <input type="checkbox" value=""> <span class="text">Let theme shine like a star</span> <small class="label label-success"><i class="fa fa-clock-o"></i> 3 days</small>
                        <div class="tools">
                            <i class="fa fa-edit"></i> <i class="fa fa-trash-o"></i>
                        </div>
                    </li>
                    <li>
                        <span class="handle"><i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i></span> <input type="checkbox" value=""> <span class="text">Check your messages and notifications</span> <small class="label label-primary"><i class="fa fa-clock-o"></i> 1 week</small>
                        <div class="tools">
                            <i class="fa fa-edit"></i> <i class="fa fa-trash-o"></i>
                        </div>
                    </li>
                    <li>
                        <span class="handle"><i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i></span> <input type="checkbox" value=""> <span class="text">Let theme shine like a star</span> <small class="label label-default"><i class="fa fa-clock-o"></i> 1 month</small>
                        <div class="tools">
                            <i class="fa fa-edit"></i> <i class="fa fa-trash-o"></i>
                        </div>
                    </li>
                </ul>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix no-border">
                <button class="btn btn-default pull-right" type="button"><i class="fa fa-plus"></i> Add item</button>
            </div>
        </div><!-- /.box -->
    </section><!-- /.Left col -->
    <!-- right col (We are only adding the ID to make the widgets sortable)-->
    <section class="col-lg-5 connectedSortable">
        <!-- Map box -->
        <div class="box box-solid bg-light-blue-gradient">
            <!-- quick email widget -->
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-envelope"></i>
                    <h3 class="box-title">Quick Email</h3><!-- tools box -->
                    <div class="pull-right box-tools">
                        <button class="btn btn-info btn-sm" data-toggle="tooltip" data-widget="remove" title="Remove" type="button"><i class="fa fa-times"></i></button>
                    </div><!-- /. tools -->
                </div>
                <div class="box-body">
                    <form action="#" method="post">
                        <div class="form-group">
                            <input class="form-control" name="emailto" placeholder="Email to:" type="email">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="subject" placeholder="Subject" type="text">
                        </div>
                        <div>
                            <textarea class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                    </form>
                </div>
                <div class="box-footer clearfix">
                    <button class="pull-right btn btn-default" id="sendEmail" type="button">Send <i class="fa fa-arrow-circle-right"></i></button>
                </div>
            </div>
        </div><!-- /.box -->
        <!-- /.box -->
    </section><!-- right col -->
</div><!-- /.row (main row) -->