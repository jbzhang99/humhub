<h1><?php echo Yii::t('AdminModule.space', 'Manage spaces'); ?></h1>

<?php
$visibilities = array(
    0 => 'Invisible',
    1 => 'Registered Users',
    3 => 'All',
);

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'space-grid',
    'dataProvider' => $model->resetScope()->search(),
    'filter' => $model,
    'itemsCssClass' => 'table table-hover',
    /* 'loadingCssClass' => 'loader', */
    'columns' => array(
        array(
            'value' => 'CHtml::image($data->profileImage->getUrl())',
            'type' => 'raw',
            'htmlOptions' => array('class' => 'img-rounded', 'style' => 'width: 24px; height: 24px;'),
        ),
        array(
            'name' => 'name',
            'filter' => CHtml::activeTextField($model, 'name', array('placeholder' => Yii::t('AdminModule.space', 'Search for space name'))),
            'header' => Yii::t('AdminModule.space', 'Space name'),
        ),
        array(
            'name' => 'visibility',
            'filter' => array("" => Yii::t('AdminModule.space', 'All'), 0 => Yii::t('AdminModule.space', 'Invisible'), 1 => Yii::t('AdminModule.space', 'Registrated only'), 2 => Yii::t('AdminModule.space', 'All')),
            'value' => function($data, $row) {
                if ($data->visibility == Space::VISIBILITY_NONE)
                    return Yii::t('AdminModule.space', 'Invisible');
                else if ($data->visibility == Space::VISIBILITY_REGISTERED_ONLY)
                    return Yii::t('AdminModule.space', 'Registrated only');
                else if ($data->visibility == Space::VISIBILITY_ALL)
                    return Yii::t('AdminModule.space', 'Visible');

                return $data->visibility;
            }
        ),
        array(
            'name' => 'join_policy',
            'filter' => array("" => Yii::t('AdminModule.space', 'All'), 0 => Yii::t('AdminModule.space', 'By Invite'), 1 => Yii::t('AdminModule.space', 'Invite / Request'), 2 => Yii::t('AdminModule.space', 'Everbody')),
            'value' => function($data, $row) {
                if ($data->join_policy == Space::JOIN_POLICY_NONE)
                    return Yii::t('AdminModule.space', 'By invite');
                else if ($data->join_policy == Space::JOIN_POLICY_APPLICATION)
                    return Yii::t('AdminModule.space', 'Invite & Request');
                else if ($data->join_policy == Space::JOIN_POLICY_FREE)
                    return Yii::t('AdminModule.space', 'Free');

                return $data->join_policy;
            }
        ),
        array(
            'name' => 'ownerUsernameSearch',
            'header' => Yii::t('AdminModule.space', 'Space owner'),
            'filter' => CHtml::activeTextField($model, 'ownerUsernameSearch', array('placeholder' => Yii::t('AdminModule.space', 'Search for space owner'))),
            'value' => function($data, $row) {
                if (!$data->owner)
                    return "-";
                
                return $data->owner->username;
            }
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}{update}{deleteOwn}',
            'viewButtonUrl' => 'Yii::app()->createUrl("//space/space", array("sguid"=>$data->guid));',
            'updateButtonUrl' => 'Yii::app()->createUrl("//space/admin/edit", array("sguid"=>$data->guid));',
            
            'htmlOptions' => array('width' => '90px'),
            'buttons' => array
                (
                'view' => array
                    (
                    'label' => '<i class="fa fa-eye"></i>',
                    'imageUrl' => false,
                    'options' => array(
                        'style' => 'margin-right: 3px',
                        'class' => 'btn btn-primary btn-xs tt',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'top',
                        'title' => '',
                        'data-original-title' => Yii::t('AdminModule.space', 'View space'),
                    ),
                ),
                'update' => array
                    (
                    'label' => '<i class="fa fa-pencil"></i>',
                    'imageUrl' => false,
                    'options' => array(
                        'style' => 'margin-right: 3px',
                        'class' => 'btn btn-primary btn-xs tt',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'top',
                        'title' => '',
                        'data-original-title' => Yii::t('AdminModule.space', 'Edit space'),
                    ),
                ),
                'deleteOwn' => array
                    (
                    'label' => '<i class="fa fa-times"></i>',
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("//space/admin/delete", array("sguid"=>$data->guid));',
                    'deleteConfirmation' => false,
                    'options' => array(
                        'class' => 'btn btn-danger btn-xs tt',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'top',
                        'title' => '',
                        'data-original-title' => Yii::t('AdminModule.user', 'Delete space'),
                    ),
                ),
            ),
        ),                
                
    ),
    'pager' => array(
        'class' => 'CLinkPager',
        'maxButtonCount' => 5,
        'nextPageLabel' => '<i class="fa fa-step-forward"></i>',
        'prevPageLabel' => '<i class="fa fa-step-backward"></i>',
        'firstPageLabel' => '<i class="fa fa-fast-backward"></i>',
        'lastPageLabel' => '<i class="fa fa-fast-forward"></i>',
        'header' => '',
        'htmlOptions' => array('class' => 'pagination'),
    ),
    'pagerCssClass' => 'pagination-container',
));
?>

<script type="text/javascript">
    $( document ).ready(function() {
        $('.grid-view-loading').show();
        $('.grid-view-loading').css('display', 'block !important');
        $('.grid-view-loading').css('opacity', '1 !important');
    });

</script>
