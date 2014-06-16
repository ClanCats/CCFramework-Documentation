Using the query builder makes your life as a developer much easier. No more caring about _Sql injection_ and syntax errors.

## Select basics

Let's create a simple select:

```php
DB::select( 'people' )->run();
```

This will run the following query:

```sql
select * from `people`
```

### Helpers

Often you just need the last or first result of table or the count.

Getting the first or last result of a query simply orders by a specified key.<br>
( by default `id` see: `main::database.default_primary_key` ).

```php
DB::first( 'people' );
DB::last( 'people' );
```

You can pass a different key. 

```php
// First result of people ordered by name
DB::first( 'people', 'name' );
```

Getting the table count:

```php
$count = DB::count( 'people' ); // return int
```

All these functions are just shortcuts you they are also available on the normal query object. This way you can also use them with an existing query.

```php
DB::select( 'people' )
	->where( 'age', '>', 18 )
	->count();
	
DB::select( 'posts' )
	->where( 'user_id', 'in', array( 1, 2, 3 ) )
	->last( 'created_at' );
```

### Execution ( run, find, one etc.. ) 

**Don't forget** that you have to **run** queries. Just executing `DB::select( 'cars' );` will return a `DB\Query` object.

These functions will execute your query and return the results:

 * `run( '<handler>' )`
 * `first( '<key>', '<handler>' )`
 * `last( '<key>', '<handler>' )`
 * `count( '<key>', '<handler>' )`
 * `find( '<id>', '<key>', '<handler>' )`
 * `one( '<handler>' )`
 * `column( '<column>', '<handler>' )`

### Fields

Select a special field

```php
// select `name` from `people`
DB::select( 'people', 'name' );
```

or mulitple fields:

```php
// select `name`, `age` from `people`
DB::select( 'people', array( 'name', 'age' ) );
```

You can reset the fields any time. For example when you got an callback that modifies the query: 

```php
// select `id` from `people`
DB::select( 'people', array( 'name', 'age' ) )->fields( 'id' );
```

Or you can add fields:

```php
// select `name`, `age`, `id` from `people`
DB::select( 'people', array( 'name', 'age' ) )->add_fields( 'id' );
```

**Note:** The query escapes column names etc. if you wish to execute an expression you have to create one using raw.

```php
DB::select( 'people', DB::raw( 'COUNT(*)' ) );
```

### Where 

Simple where equal's operator:

```php
// select * from `people` where `id` = ?
DB::select( 'people' )->where( 'id', 22 );
```

Using another operator:

```php
// select * from `people` where `id` != ?
DB::select( 'people' )->where( 'id', '!=', 22 );
```

In array:

```php
// select * from `people` where `id` in (?, ?, ?)
DB::select( 'people' )->where( 'id', 'in', array( 1, 2, 3 ) );
```

Or where:

```php
// select * from `people` where `id` in (?, ?, ?) or `name` = ?
DB::select( 'people' )
	->where( 'id', 'in', array( 1, 2, 3 ) )
	->or_where( 'name', 'mario' );
```

Nested wheres:

```php
// select * from `people` where ( `age` > ? and `age` < ? ) or `name` = ?
DB::select( 'people' )
	->where( function( $q )
	{
		$q->where( 'age', '>', 18 );
		$q->where( 'age', '<', 99 );
	})
	->or_where( 'name', 'mario' );
```

### Ordering 

Adding an order by:

```php
// select * from `people` order by `age` asc
DB::select( 'people' )->order_by( 'age' );
```

Descending:

```php
// select * from `people` order by `age` desc
DB::select( 'people' )->order_by( 'age', 'desc' );
```

More columns:

```php
// select * from `people` order by `age` desc, `name` asc, `created_at` asc
DB::select( 'people' )
	->order_by( array( 
		'age' => 'desc', 
		'name', 
		'created_at' => 'asc' 
	) );
```

### Groups 

Adding an group by:

```php
// select * from `people` group by `age`
DB::select( 'people' )->group_by( 'age' );
```

and multiple groups

```php
// select * from `people` group by `age`, `name`
DB::select( 'people' )->group_by( array( 'age', 'name' ) );
```

### Limit, Offset and Page 

When setting the limit to just one entry you will receive your single result and not an array of them.

```php
// select * from `people` limit 0, 1
DB::select( 'people' )->limit( 1 ); // returns stdClass of the single result
```

```php
// select * from `people` limit 0, 2
DB::select( 'people' )->limit( 2 ); // returns an array of stdClasses.
```

with offset:

```php
// select * from `people` limit 25, 10
DB::select( 'people' )->limit( 25, 10 );
```

simple paging:

```php
// select * from `people` limit 0, 25
DB::select( 'people' )->page( 1 );
```

The default page size is 25 entries.

```php
// select * from `people` limit 30, 15
DB::select( 'people' )->page( 3, 15 );
```

