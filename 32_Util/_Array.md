The CCArr class is a helper class to work with arrays. It implements methods that make some array operations much easier.

## Functions

### First

```php
CCArr::first( array( 'foo', 'bar' ) ); // returns foo
```

{[Parser::function_info( 'CCArr::first' )]}

### Last

```php
CCArr::last( array( 'foo', 'bar' ) ); // returns bar
```

{[Parser::function_info( 'CCArr::last' )]}

### Push

{[Parser::function_info( 'CCArr::push' )]}

#### pass by reference

The array is passed by reference another example:

```php
$array = array( 'Orange', 'Banana', 'Apple' );
CCArr::push( 'Cherry', $array );

// result of $array: [ 'Orange', 'Banana', 'Apple', 'Cherry' ]
```

#### merge 

You can merge to arrays together:

```php
$array = array( 'Orange', 'Apple' );
CCArr::push( array( 'Strawberry', 'Banana' ), $array, true );

// results in one array: [ 'Orange', 'Apple', 'Strawberry', 'Banana' ]
```