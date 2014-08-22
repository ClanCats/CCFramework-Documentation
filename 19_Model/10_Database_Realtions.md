
The `DB\Model` supports model relations, you can define them simply by creating a function that returns the relationship query.

## Basics

Lets say our model belongs to a user:

```php
public function user()
{
	return $this->belongs_to( 'User' );
}
```

So the link that here basically happens works like this:

The current model _belongs to_ a model called `User`, so we assume that the local key is going to be `user_id` and the foreign_key  is `id`.

Of course we also could set them manually:

```php
public function user()
{
	// <model>, <foreign key>, <local key>
	return $this->belongs_to( 'User', 'user_id', 'id' );
}
```

### Selecting

There are again 2 ways on how to select the data from the relationship.

#### As propety

By selecting the data as property you simply use your function name as key:

```php
$item->user; // returns User model
```

#### As query

Or you can execute your function wich will return you the relation object. This is especially useful if you want to filter your results for example in a has many relationship.

```php
$item->user()->run(); // returns User model
```

## Relationship types

### has one

For a `has_one` relationship we need a table structure like this:

```
+------+--------+
| Car  | Engine |  // Car has one Engine 
+------+--------+  // Engine belongs to Car
| id   | id     | 
| name | name   |
|      | car_id |
+------+--------+
```

#### Car model

```php
public function engine()
{
	return $this->has_one( 'Engine' );
}
```

```php
$car = Car::find(325);
$car->engine->name;
```

#### Engine model

```php
public function car()
{
	return $this->belongs_to( 'Car' );
}
```

```php
$engine = Engine::find(42);
$engine->car->name;
```

### has many

In the has many relationship we have can make use of a query callback to filter the results.

_Example structure:_

```
+------+---------+
| User | Post    |  // User has many Post
+------+---------+  // Post belongs to user
| id   | id      | 
| name | name    |
|      | user_id |
+------+---------+
```

#### User model

```php
public function posts()
{
	return $this->has_many( 'Post' );
}
```

After we created that function we should be able to work with that relationship.

```php
$user = User::find( 'name', 'Jeff' );

$user->posts; // returns all posts related with the user 
```

```php
// receive the relation object and add statements
$user->posts()
	->where( 'name', 'like', '%yeah%' )
	->page(1, 25)
	->run();
```

---

## mass selecting ( with selection )

If you have something like posts and comments you don't wont to select all comments for each post individually.

You can select them in one operation using the `with` method.

```php
Posts::with( 'comments' );
```

Or multiple:

```php
Posts::with( array( 'comments', 'user' ) );
```

The second argument of the with method is a callback like for the find method.

```php
$posts = Posts::with( array( 'comments', 'user' ), function( $q ) 
{
	$q->order_by( 'created_at', 'desc' );
	$q->page(1);
});
```

By using the `.` separator you can also mass select into deeper dimensions of the relation.

```php
Posts::with( array( 'comments', 'comments.user', 'user' ) );
```

And of course you can add callbacks for the relation queries as well:

```php
Posts::with( array( 
	'comments' => function( $q )
	{
		$q->where( 'created_at', '>', time() - 3600 );
		$q->page(1);
	},
));
```