This little tutorial should give you a little view on how CCF works. 

In this short example we are going build a simple Blog. 

So lets get startet with the core of our core.

## The CCF bundles

The core construct of CCF is the bundle.
A bundle is a namespace for resources like classes, views, etc.<br />
The Core `CCF/core/` or the app `CCF/app/` are both bundles, also every theme or orbit ship and many more are bundles.


So lets take a look at the most important one, your application:

```
 - app/
   - classes/            // Your Application classes
   - config/             // Configuration files
   - console/            // Console scripts
   - controllers/        // Controllers
   - views/              // Views
```

These are the most common bundle components, of course there are more and you can define your own ones.

## Preparing 

### Application name

First of all we are going to setup the application name. Open your application class under: `CCF/app/App.php`

There you will see a static property called name. Change it to what ever you like in this example im going to use CCNews.

```php
public static $name = 'CCNews';
```

### Router

For our little blog we are going to use the url pattern `news/`. So open your **router.config.php** in this file you can define routes that get added on application _wake_ to the router.

**File:** `CCF/app/config/router.config.php`

In this file you will see the base routes for your application.
Just like #root, #404 etc. add your new route at the end of the array.

_example.com/news/ -> alias blog -> execute BlogController_

```php
'news@blog'	=> 'Blog',
```

### Controller

In the next step we have to create the `BlogController`. You can create a controller manually or by using the _command line interface_ just like every other class.

`shipyard::controller [name] [superclass]`

```
$ php cli shipyard::controller Blog CCViewController
```

> **Note:** you might want to change the shipyard configuration first so that CCF generates the correct headers. [shipyard configuration](/docs/shipyard/)

Will create the following class at `CCF/app/controllers/BlogController.php`.

```php
class BlogController extends \CCViewController
{
   /**
    * controller wake
    * 
    * @return void|CCResponse
    */
   public function wake()
   {
      // Do stuff
   }

   /**
    * index action
    * 
    * @return void|CCResponse
    */
   public function action_index()
   {
      echo "BlogController";
   }

   /**
    * controller sleep
    * 
    * @return void
    */
   public function sleep()
   {
      // Do stuff
   }
}
```

Now we can open execute our blog by opening `/news/` and we should see the default output: `BlogController`.

### Migration ( Database )

Now we are going to link the database, run the migrations and create the blog table.

#### configure the database

Your database configuration is located under `CCF/app/config/database.config.php`. If the file doesn't exist, create it.

By default the database configuration is going to use the application name for the database name. So in my case it would be `db_ccnews`.

But this is just the default setting so change the database configuration to your needs.

```php
/*
 *---------------------------------------------------------------
 * Database configuration
 *---------------------------------------------------------------
 */
return array(
   'main' => array(
      'driver'    => 'mysql',
      
      'db'        => 'my_database_name',
      
      'host'      => '127.0.0.1',
      'user'      => '<database username>',
      'pass'      => '<database password>',
      'charset'   => 'utf8'
   ),
);
```

_CCF will **not** create the database, you have to create it your own using phpmyadmin, cli or what every prefer._

> **Note:** The full documentation about the database configuration. [database configuration](/docs/database/)

#### run the migrations

Now we can run the migrations this allows us to use the built in user system and the database sessions.

```
$ php cli migrator::migrate
```

_You can but your really should not do this step manually._

#### blog migration ( table )

Now we have to create a new migration to create our blog table.

```
php cli migrator::create bloginit
```

Will generate an file under: `CCF/app/database/bloginit_1401381259.sql`

Now open that file and add the SQL queries you would like to run. For the blog example we add something like:

```sql
# ---> up

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `modified_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

# ---> down

DROP TABLE `blog_posts`;
````

Now we can run the migrator again to run our newly created blog table migration.

```
$ php cli migrator::migrate
```

### Model

Because we have now our `blog_posts` table we can generate a model out of it.

```
php cli shipyard::model Post blog_posts
```

This creates the model class for us. You can find it under: `CCF/app/classes/Post.php`

```php
class Post extends \DB\Model
{
   public static $_defaults = array(
      'id',
      'title'        => array( 'string', '' ),
      'content'      => array( 'string', '' ),
      'created_by'   => array( 'int', 0 ),
      'created_at'   => array( 'int', 0 ),
      'modified_at'  => array( 'int', 0 )
   );
}
```

Because we want the `created_at` and `modified_at` field to be set automatically we have to add the timestamps property.

```php
protected static $_timestamps = true;
```