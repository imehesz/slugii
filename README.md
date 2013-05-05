slugii
======

step-0
------

Initial Yii 1.1.13 skeleton

step-1
------

add Url model and generate default CRUD with Gii

step-2
------

update Url model

```php

public function rules() {
	...
	array('url,slug', 'required'),
	...
}

public function beforeValidate() {
   $this->slug = $this->createSlug();
   $this->created = time();
   return parent::beforeValidate();
}

public function createSlug() {
   $got_slug = Url::model()->find( array( 'order' => 'slug DESC' ) );
   return ! empty( $got_slug ) ? ++$got_slug->slug : 'AA';
}

```

step-3
------

update UrlController 

```php

public function accessRules()
{
	return array(
		array('allow',  // allow all users to perform 'index' and 'view' actions
			'actions'=>array('index','view', 'create', 'redirect'),
			'users'=>array('*'),
		),
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
			'actions'=>array('update'),
			'users'=>array('@'),
	 	),
		array('allow', // allow admin user to perform 'admin' and 'delete' actions
			'actions'=>array('admin','delete'),
			'users'=>array('admin'),
		),
		array('deny',  // deny all users
			'users'=>array('*'),
	 	)
	);
}

public function actionRedirect() {
	$slug = Yii::app()->request->getParam( 'slug', null );
	if( $slug ) {
	$url = Url::model()->findByAttributes( array( 'slug' => $slug ) );
		if( $url ) {
			$this->redirect( Url::model()->findByAttributes( array( 'slug' => $slug ) )->url );
		}
	}

	throw new CHttpException( '404', 'hmmm ... slug not found!' );
}
```

update views/url/_form.php

```php

<div class="row">
	<?php echo $form->labelEx($model,'url'); ?>
	<?php echo $form->textField($model,'url'); ?>
	<?php echo $form->error($model,'url'); ?>
</div>
```

update views/url/view.php

```php

<?php 
	echo 
		CHtml::link( 
			$_SERVER['SERVER_NAME'] . '/' . $model->slug, 
			$this->createUrl( '/' . $model->slug ) 
		);
?>
```

update main.php config file

```php

	'defaultController' => 'url/create'

	'rules'=>array(
		'/<slug:[A-Z]+>' => 'url/redirect',
		'<controller:\w+>/<id:\d+>'=>'<controller>/view',
		'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
		'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
	 ),
```

add .htaccess to make everything pretty 

```

Options +FollowSymLinks
IndexIgnore */*
RewriteEngine on

#Uncomment "RewriteBase /" when you upload this .htaccess to your web server, and comment it when on local web server

#NOTE: 

#If your application is in a folder, for example "application". Then, changing the "application" folder name, will require you to reset the RewriteBase /[your app folder]

#RewriteBase /[your app folder - optional]

# if a directory or a file exists, use it directly
RewriteCond %{REQUEST_FILENAME} -s [OR]
RewriteCond %{REQUEST_FILENAME} -l [OR]
RewriteCond %{REQUEST_FILENAME} -d

# otherwise forward it to index.php 
RewriteRule ^.*$ - [NC,L]
RewriteRule ^.*$ index.php [NC,L]
```
