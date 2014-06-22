**Don't forget to run the queries!** I don't show in every example that you have to execute the **run** function on the query.

## Delete basics

The delete query does not implement any special functionality. You can make use of the **where** and **limit** functionality.

```php
// delete from `people` where `id` = ?
DB::delete( 'people' )->where( 'id', 12 )->run();
```

With limit:

```php
// delete from `people` where `id` = ? limit 1
DB::delete( 'people' )
	->where( 'id', 9 )
	->limit( 1 )
	->run();
```