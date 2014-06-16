**Don't forget to run the queries!** I don't show in every example that you have to execute the **run** function on the query.

## Insert basics

Let's create a simple insert:

```php
// insert into `people` (`age`, `name`) values (?, ?)
DB::insert( 'people', array( 'name' => 'mario', 'age' => 99 )  )->run();
```

You can also add the values step by step.

```php
// insert into `people` (`age`, `name`) values (?, ?)
DB::insert( 'people' )
	->values( array( 'name' => 'tarek', 'age' => 52 ) )
	->run();
```

### Insert Ignore

You can add the ignore command.

```php
// insert ignore into `people` (`age`, `name`) values (?, ?)
DB::insert( 'people', array( 'name' => 'mario', 'age' => 99 )  )->ignore()->run();
```

### Bulk insert

You can also insert a collection of data.

```php
// insert into `people` (`age`, `name`) values (?, ?), (?, ?)
DB::insert( 'people', array( 
	array( 'name' => 'mario', 'age' => 99 ),
	array( 'name' => 'tarek', 'age' => 42 ),
))->run();
```

This can be done also using the values method.

```php
// insert into `people` (`age`, `name`) values (?, ?), (?, ?)
DB::insert( 'people' )
	->values( array( 'name' => 'mario', 'age' => 99 ) )
	->values( array( 'name' => 'tarek', 'age' => 42 ) )
	->run();
```