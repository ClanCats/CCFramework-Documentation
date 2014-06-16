**Don't forget to run the queries!** I don't show in every example that you have to execute the **run** function on the query.

## Update basics

Let's create a simple update:

```php
// update `people` set `age` = ?
DB::update( 'people', array( 'age' => 18 ) )->run();
```

Adding a where statement:

```php
// update `people` set `age` = ? where `age` < ?
DB::update( 'people', array( 'age' => 18 ) )
	->where( 'age', '<', 18 )
	->run();
```

Using the `set` method:

```php
// update `people` set `name` = ?, `age` = ? where `id` = ?
DB::update( 'people' )
	->set( 'name', 'Mario' )
	->set( 'age', 21 )
	->where( 'id', 12 )
	->run();
```

Example updating specific result:

```php
// update `people` set `name` = ? where `id` = ? limit 1
DB::update( 'people', array( 'name' => 'Ladina' ) )
	->where( 'id', 9 )
	->limit( 1 )
	->run();
```