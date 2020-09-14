<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use rmrevin\yii\fontawesome\FA;
?>

<div class="box box-info">
    <div class="box-header with-border">
        <i class="fa fa-bell"></i>
        <h3 class="box-title"><?php echo Yii::t('app', 'My Viewings') ?></h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="table no-margin">
                <?php if (!empty($viewingsByUser)) : ?>
                <thead>
                <tr>
                    <th><?php echo Yii::t('app', 'Created for') ?></th>
                    <th><?php echo Yii::t('app', 'Client name') ?></th>
                    <th><?php echo Yii::t('app', 'Property') ?></th>
                    <th><?php echo Yii::t('app', 'Note') ?></th>
                    <th><?php echo Yii::t('app', 'Date') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($viewingsByUser as $v) : ?>
                    <tr>
                        <td>
                            <?= $v->getLink()?>
                        </td>
                        <td>
                            <?= $v->client_name?>
                        </td>
                        <td>
                            <?= $v->getLinkListingRef()?>
                        </td>
                        <td>
                            <?= $v->note?>
                        </td>
                        <td>
                            <?= ($v->date) ? $v->date : ''?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <?php echo Yii::t('app', 'No Data') ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
    </div>
    <!-- /.box-footer -->
</div>