# Laravel meta

### Instalation
You can use the `composer` package manager to install. From console run:

```
  $ php composer.phar require parfumix/laravel-meta "dev-master"
```

or add to your composer.json file

    "parfumix/laravel-meta": "dev-master"

You have to publish package files using

```
  $ php artisan vendor:publish
```

And run :

```
  $ php artisan migrate
```  

### Configuration

To regiter package you have to follow standart procedure registering serviceProvider class and Facade. But for the first open your configuration file located in **config/app.php** and search for array of providers:

```php
  'providers' => [
        // Add that line at the end of array ..
        'Terranet\Metaable\MetaServiceProvider'
      ]  
```

And you can create an alias for that in the same file but looking for **aliases** array:

```php
  'aliases' => [
        // Add that line at the end of array ..
         'Meta' => 'Terranet\Metaable\MetaFacade',
      ]  
```

### Usage

The benefits of that component is that you can use it separate from laravel or use **HasTrait** trait to store all the meta in database.

Let me show you the tips and tricks you can use to generate meta tags for one of the page.

```php

use Meta;

class PageController extends Controller {

    public function index(PageRepository $pageRepository) {
    
        //set the meta using an array
        Meta::fromArray([
            'title'       => 'Meta title',
            'description' => 'Meta description'
            'keywords'    => ['keword', 'best site', 'bla bla']
        ]);
        
        // or you can add using set 
        Meta::set('title', 'Meta title');
        Meta::set('description', 'Meta description');
        Meta::set('keywords', ['keword', 'best site', 'bla bla']);
        
        // to delete some meta tags you have to use clear method. Be careful if you will not send any argument will 
        // be remove all meta tags ..
        Meta::clear('title');
        
        // use toArray method to get dump of meta tags
        print( Meta::toArray() ) 
        
        /**
            array:2 [
              "description" => "<description>Meta description</description>"
              "keywords" => "<meta name="keywords" content="keword, best site, bla bla]"/>"
            ]
        */
        
        // if you want to flush all meta tags use 
        Meta::flush();
    }

}

```

If you want use meta with eloquent open your model you want to use and follow code below

```php
<?php namespace App;

use Terranet\Metaable\Entity\HasMeta;
use Terranet\Metaable\Entity\Metaable;

class Page extends Repository implements Metaable {

    use HasMeta;

    protected $table = "pages";
}
```

And add your meta tags use **fromEloquent** method


```php

use Meta;

class PageController extends Controller {

    public function index(PageRepository $pageRepository) {

         $page = $pageRepository->findBySlug('main-page');

         // here you have to send eloquent instance which implements Metaable contract .
         Meta::fromEloquent($page)
    }

}

```

and if you want to rendering meta attributes you have just opening your default layout and paste that code

```blade
<!DOCTYPE html>
<html lang="ru">
<head>
    @meta
</head>
<body>
  @yield('content')
</body>
</html>
```

