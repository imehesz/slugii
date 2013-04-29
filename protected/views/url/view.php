<?php
/* @var $this UrlController */
/* @var $model Url */

$this->breadcrumbs=array(
	'Urls'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Url', 'url'=>array('index')),
	array('label'=>'Create Url', 'url'=>array('create')),
	array('label'=>'Update Url', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Url', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Url', 'url'=>array('admin')),
);
?>

<h1>View Url #<?php echo $model->id; ?></h1>

<?php 
    echo 
        CHtml::link( 
            $_SERVER['SERVER_NAME'] . '/' . $model->slug, 
            $this->createUrl( '/' . $model->slug ) 
        );
?>
