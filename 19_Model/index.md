{
	"topic": "Model"
}

The base model is the `CCModel` wich does not implement any read or write functions. It can be used as a simple very extensible data model.

_There is also a Database model wich allows ORM abstraction in a CRUD style pattern._

## A Basic model

To create a Basic model you just have to define the properties. For our example lets create a simple Person model.

```php
class Person extends CCModel 
{
	protected static $_defaults = array(
		'firstname', 'lastname', 'age'
	);
}
```

### Creating instances

Now we can create `Person` instances. The properties just act like normal properties. You can use them just as you are used to.

```php
$person = new Person;

$person->firstname = "Stan";
$person->lastname = "Lee";
$person->age = 91;

// prints: Stan Lee / 91
echo $person->firstname.' '.$person->lastname.' / '.$person->age;
```

We also can directly assign data:

```php
$person = new Person( array(
	'firstname' => 'Jonathan',
	'lastname' => 'Frakes',
));
```

Or by using the assign method even create a collection of models.

```php
$people = Person::assign( array(
	array(
		'firstname' => 'George',
		'lastname' => 'Takei',
	),
	array( 
		'firstname' => 'Patrick',
		'lastname' => 'Stewart',
	),
));
```

---

### Property defaults

If can add default values to your properties just like this:

```php
class Person extends CCModel 
{
	protected static $_defaults = array(
		'firstname',
		'lastname',
		// set default age to 18.
		'age' => 18
	);
}
```

Now lets create a new instance of that person.

```php
$person = new Person;

// prints: 18
echo $person->age;
```

As we can see without setting the age for this person we got the default age 18.

---

### Property type assignments

To keep your data clean you can even set a type for each property:

```php
class Person extends CCModel 
{
	protected static $_defaults = array(
		'firstname' => array( 'string', 'unknown' ),
		'lastname' => array( 'string', 'unknown' ),
		'age' => array( 'int', 18 ),
		'hobbies' => array( 'json', array() )
	);
}
```

The type assignment forces initial passed data to be of that type.

```php
$person = new Person( array(
	'firstname' => 'Jaffy',
));

// string(5) "Jaffy"
var_dump( $person->firstname );

$person = new Person( array(
	// we are passing an integer here
	'firstname' => 12345,
));

// string(5) "12345"
var_dump( $person->firstname );
```

Or more useful example is serialised json data:

```php
$person = new Person( array(
	'firstname' => 'Jennifer',
	'lastname' => 'Le',
	// JSON type assignment over here
	'hobbies' => '["Gaming", "Music"]'
));

// array(2) 
// {
//  [0] => string(6) "Gaming"
//  [1] => string(5) "Music"
// }
var_dump( $person->hobbies );
```

---

### Set and Get modifiers

Set and get modifiers are a great way to create virtual properties or catch data assignment events.

#### Get modifier

A get modifier is a function callback that is called when something is getting the data with the specified key.

Just create a protected or public function in you Model called `_get_modifier_<your key>`.

```php
protected function _get_modifier_firstname( $firstname )
{
	return ucfirst( $firstname );
}
```

Now lets assign a name to our person instance.

```php
$person->firstname = "jane";
```

The property `firstname` contains now the string jane just in lowercase characters. But if we get that property now the model is going to execute our modifier first and we will receive the modified string.

```php
// prints: Jane
echo $person->firstname;
```

#### Virtual property

In the same way these modifiers can also be used to create virtual properties.

```php
protected function _get_modifier_fullname()
{
	return $this->firstname.' '.$this->lastname;
}
```

Because of the modifier fullname is now an accessable but not writable property.

```php
$person->firstname = "Johnny";
$person->lastname = "Depp";

// prints: Johnny Depp
echo $person->fullname;
```

#### Set modifier

In the other way there are also set modifiers wich modify the data before getting stored in the model.

_For this example lets say our person model also has the property password._

```php
class Person extends CCModel 
{
	protected static $_defaults = array(
		'firstname' => array( 'string', 'unknown' ),
		'lastname' => array( 'string', 'unknown' ),
		'age' => array( 'int', 18 ),
		'hobbies' => array( 'json', array() ),
		'password' => array( 'string' ),
	);
}
```
So lets create a set modifier wich will hash every passed password before storing it in the model.

```php
protected function _set_modifier_password( $password )
{
	return \CCStr::hash( $password );
}
```

Now if we set the password property, the passed value gets hashed .

```php
$person->password = "BadPassword";

// string(40) "58fef0c34f52cb5c51188ddfa96a8ee9a5fe4f25"
var_dump( $person->password );
```

---

### Strict assigns

{[Parser::function_info( 'CCModel::strict_assign' )]}

---

### Raw data

Sometimes its needed to access or set data without using any modifiers type assignments etc. for that we have the raw methods.

#### Getting raw data

{[Parser::function_info( 'CCModel::raw' )]}

#### Setting raw data

{[Parser::function_info( 'CCModel::raw_set' )]}