The model generator needs an **existing database table**. The model attributes will be set based on your table fields. 

Generate a simple model: 

```
$ php cli shipyard::model Person people
```

`php cli shipyard::model <model class> <db table>`


Will create you following model class file under: `CCF/app/classes/Person.php`

```php
class Person extends \DB\Model
{
	/**
	 * Database table
	 */
	public static $_table = 'people';
	
	/**
	 * The People default properties
	 */
	public static $_defaults = array(
		'id',
		'name' => array( 'string', '' ),
		'age' => array( 'int', 0 )
	);
}
```