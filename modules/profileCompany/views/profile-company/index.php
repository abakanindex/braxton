<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Profile of Company');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id' => 'result']); ?>

    <?php echo Html::hiddenInput('companyId', $model->company_id); ?>

    <div class="container-fluid top-contact-content clearfix">
		<!--  Top Contact Block -->
		<div id="result">
			<div class="head-contact-property container-fluid">
                <?= Breadcrumbs::widget([
                    'homeLink' => ['label' => Yii::t('app', 'Home'), 'url' => '/'],
                    'links'    => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
     
				<h2><?= Html::encode($this->title) ?></h2>
				<ul class="list-inline container-fluid">
					<li class="">
                        <?= Html::submitButton(
                            '<i class="fa fa-check-circle"></i>' . Yii::t('app', ' Save'),
                            [
                                'class'     => 'btn red-button',
                                'id'        => 'save-edit-element',
                                'form'      => 'profile-company-form',
                                'data-pjax' => '1',
                            ]
                        ) ?>
					</li>
				</ul>
                <b><?= Yii::t('app', 'Company token')?>:</b> <?= $companyToken?>
			</div>
			<div class="container-fluid content-contact-property">
            <?php 
                $form = ActiveForm::begin([
                    'options' => [
                        'enctype'   => 'multipart/form-data',
                        'id'        => 'profile-company-form',
                        'class'     => 'form-horizontal',
                        'data-pjax' =>  true
                    ]
                ]); 
            ?>
					<div class="container-fluid contact-middle-block col-md-4">
						<!-- Middle Contact part-->
						<div class="content-left-block">
							<!--Property Address & Detalis-->
							<h3>Contact Details</h3>
							<div class="property-list">
								<div class="form-group">
									<label class="col-sm-6 control-label" for="">Company Name</label>
									<div class="col-sm-6">
                                        <?= $form->field($model, 'company_name')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false); ?>
									</div>
								</div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label" for="">Company Prefix</label>
                                    <div class="col-sm-6">
                                        <?= $form->field($model, 'prefix')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false); ?>
                                    </div>
                                </div>
								<div class="form-group">
									<label class="col-sm-6 control-label" for="">Rera Orn</label>
									<div class="col-sm-6">
                                        <?= $form->field($model, 'rera_orn')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-6 control-label" for="">Trn</label>
									<div class="col-sm-6">
                                        <?= $form->field($model, 'trn')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-6 control-label" for="">Address</label>
									<div class="col-sm-6">
                                        <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-6 control-label" for="">Office Tel</label>
									<div class="col-sm-6">
                                        <?= $form->field($model, 'office_tel')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-6 control-label" for="">Office Fax</label>
									<div class="col-sm-6">
                                        <?= $form->field($model, 'office_fax')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-6 control-label" for="">Primary Email</label>
									<div class="col-sm-6">
                                        <?= $form->field($model, 'primary_email')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-6 control-label" for="">Website</label>
									<div class="col-sm-6">
                                        <?= $form->field($model, 'website')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-6 control-label" for="">Company Profile</label>
									<div class="col-sm-6">
                                        <?= $form->field($model, 'company_profile')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false); ?>
									</div>
								</div>
							</div>
						</div><!-- /Property Address & Detalis-->
					</div><!-- /Middle Contact part-->
				<div class="container-fluid col-md-8 notes-block">
					<!-- Right part-->
					<div id="notes-tab">
						<div class="property-list">
							<div class="tab-content">
								<div class="tab-pane active">
									<div class="tab-header">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="">Logo</label>
                                            <div class="col-sm-6 profile-company-input-block" data-type="logo">
                                                <?php 
                                                    echo kartik\file\FileInput::widget([
                                                        'model'     => $model,
                                                        'attribute' => 'logo',
                                                        'language'  => 'en',
                                                        'options' => [
                                                            'accept'   => 'image/*',
                                                            'multiple' => false,
                                                        ],
                                                        'pluginOptions' => [
                                                            'showPreview'          => true,
                                                            'initialPreviewAsData' => true,
                                                            'overwriteInitial'     => true,
                                                            'showUpload'           => false,
                                                            'initialPreview'       => $model->logo ? $model->logo : true,
                                                            'showCaption'          => false,
                                                            'showRemove'           => false,
                                                            'browseClass'          => 'btn btn-primary btn-block',
                                                            'browseIcon'           => '<i class="glyphicon glyphicon-camera" ></i> ',
                                                            'browseLabel'          => 'Select Logo',
                                                            'uploadUrl'            => \yii\helpers\Url::to(['/site/file-upload']),
                                                        ]
                                                    ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="">Watermark</label>
                                            <div class="col-sm-6 profile-company-input-block" data-type="watermark">
                                                <?php 
                                                    echo kartik\file\FileInput::widget([
                                                        'model'     => $model,
                                                        'attribute' => 'watermark',
                                                        'language'  => 'en',
                                                        'options' => [
                                                            'accept'   => 'image/*',
                                                            'multiple' => false,
                                                        ],
                                                        'pluginOptions' => [
                                                            'showPreview'          => true,
                                                            'initialPreviewAsData' => true,
                                                            'overwriteInitial'     => true,
                                                            'showUpload'           => false,
                                                            'initialPreview'       => $model->watermark ? $model->watermark : true,
                                                            'showCaption'          => false,
                                                            'showRemove'           => false,
                                                            'browseClass'          => 'btn btn-primary btn-block',
                                                            'browseIcon'           => '<i class="glyphicon glyphicon-camera" ></i> ',
                                                            'browseLabel'          => 'Select Logo',
                                                            'uploadUrl'            => \yii\helpers\Url::to(['/site/file-upload']),
                                                        ]
                                                    ]);
                                                ?>
                                            </div>
                                        </div>
									</div>
								</div>
							</div>
						</div>
					</div>
                    <?php ActiveForm::end(); ?>
				</div><!-- /Right part-->
			</div>
		</div>
	</div>
<?php Pjax::end(); ?>

<?php $this->registerJsFile('@web/js/profileCompany/profileCompany.js', ['depends' => 'yii\web\JqueryAsset']);?>
