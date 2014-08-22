The database model is the `\DB\Model` class wich extends the `CCModel`. A database model must be linked to an existing database table supported by the CCF Database bundle.

## Model class

You still have to set the available properties but you can generate them using the [shipyard](/docs/shipyard/model/) if the _table_ already exists in your database.

We need the database table first so im going to continue with the person example:

```sql
CREATE TABLE IF NOT EXISTS `people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `hobbies` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
```

Then by running the following shipyard command we can generate the `Person` model.

```
$ php cli shipyard::model Person people
```

The newly generated model should look like this:

```php
class Person extends \DB\Model
{
	protected static $_table = 'people';

	protected static $_defaults = array(
		'id',
		'firstname' => array( 'string', '' ),
		'lastname' => array( 'string', '' ),
		'age' => array( 'int', 0 ),
		'hobbies' => array( 'string', '' )
	);
}
```

Now we want that hobbies is an json array so we change the property type to json:

```php
'hobbies' => array( 'json', '' )
```

---

## CRUD ( Create, Read, Update, Delete )

Our database model follows the _CRUD_ design.

### Basic usage 

#### Create

Creating new model instances just works like in the normal [CCModel](/docs/model/#creating-instances-2). But keep in mind the create command does not save your record to database.

```php
$person = new Person;

$person->firstname = "Stan";
$person->lastname = "Lee";
$person->age = 91;
```

Now if we want to save this record to the database we just have to run the `save` method.

```php
$person->save();
```

#### Update

`$person` automatically receives the primary key so we can continue using that object and updating it.

```php
$person->hobbies[] = 'Comics';
$person->save();
```

#### Delete

If we don't want our record anymore we can simply run the delete method on it.

```php
$person->delete();
```

---

## Reading

The usage to select data is pretty much the same as the select query builder. In the model we can make use of 2 methods for this task `find` and `select`.

### Find

Find is default and most common reading method. So to select all items in the table just make a find without arguments.

```php
Person::find();
```

Will return the an associative array where the _array key_ is the _primary key_ of the record and the value the model.

```php
array(
	5 => class Person
	{
	  'id' => 5
	  'firstname' => "Stan"
	  'lastname' => "Lee"
	  'age' => 91
	  'hobbies' => array( 'Comics' )
	}
	6 => ...
	7 => ...
)
```

#### Specific record

You can select a specific record by its primary key setting the first argument to an string or integer. This will directly return the object. 

```php
$person = Person::find( 5 );
```

> **Note:** *When the limit argument is 1 the object is always returned directly and not inside an array.*

#### Specific record by key

If you wish to select a specific record by another key you can do that like this:

```php
$person = Person::find( 'firstname', 'Stan' );
```

### Filtering

If you want to modify the query by your own you can pass a callback to the find method.

```php
$person = Person::find( function( $q )
{
	$q->where( 'id', 123 );
	$q->limit( 1 );
});
```

or a more complex example:

```php
$people = Person::find( function( $q )
{
	// closed where on age between 18 and 99
	$q->where( function( $q ) 
	{
		$q->where( 'age', '>', 18 );
		$q->where( 'age', '<', 99 );
	});
	
	// or these special ids
	$q->or_where( 'id', 'in', array( 42, 102, 512 ) );
	
	// lets order the results
	$q->order_by( array( 'lastname', 'firstname' ) );
});
```

The executed query will look like this then:

```sql
select * from `people` where ( `age` > ? and `age` < ? ) or `id` in (?, ?, ?) order by `lastname` asc, `firstname` asc
```

And will return an array of model objects because no _limit_ is set.

### Select

The select method returns a query object wich can be modified and has to be executed to receive the model results.

```php
Person::select()
	->where( 'age', '>', 18 )
	->run();
```

Or a single object:

```php
Person::select()
	->where( 'id', 42 )
	->limit(1)
	->run();
```

> **Note:** *The select method returns a `DB\Query` object check out the [select query documentaion](/docs/database/select/) for more information.*

---

## Static properties

There are some static properties that can be configured for each model individually.

### Table

```php
public static $_table = null;
```

If you do not define the table property the class name gets used and formatted.

---

### Primary Key

```php
public static $_primary_key = null;
```

You can define a custom primary key the default is configured under: `main.config` -> `database.default_primary_key`.

---

### Find modifier

```php
public static $_find_modifier = null;
```

You can define a callback that is executed before every select or find. This way you can for example configure a default order for your model.


---

### Timestamps

```php
public static $_timestamps = false;
```

By setting this little property to `true` the model is going to automatically set the properties `created_at` and `modified_at`.

---

## Events

There are some event callbacks where you can modify data or do some other tasks.

### Before assign

This method gets executed before the data gets passed to the model. Here you can modify data for example decode values.

```php
protected function _before_assign( $data ) 
{
	if ( isset( $data['secret_information'] ) )
	{
		$data['secret_information'] = super_secret_decoder( $data['secret_information'] );
	}
	
	return $data; 
}
```

---

### Before save

This method gets executed before the data gets saved again to the database. Also here you can modify the data.

```php
protected function _before_save( $data ) 
{
	if ( isset( $data['secret_information'] ) )
	{
		$data['secret_information'] = super_secret_encoder( $data['secret_information'] );
	}

	return $data; 
}
```

---

### After save

This method gets executed after the data has been saved. No data is passed here but you can make of course use of the object itslef.

```php
protected function _after_save() 
{
	$this->update_children();
}
```