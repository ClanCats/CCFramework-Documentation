The `CCStr` class is a helper class to work with strings. It implements methods that make some string operations much easier.

## Functions

### random

```php
CCStr::random(); // generates a random string
```

{[Parser::function_info( 'CCStr::random' )]}

### charset

{[Parser::function_info( 'CCStr::charset' )]}

```php
CCStr::charset(); // return default charset
CCStr::charset( 'hex' ); // returns hex charset etc.. 
```

### capture

{[Parser::function_info( 'CCStr::capture' )]}

Simple capturing example

```php
$output = CCStr::capture( function()
{
	echo "Hello ";
	echo "CCF";
});

print $output; // Hello CCF
```

There are only closures allowed no other callbacks are valid.

You can pass arguments to your closure using the second argument.

```php
$output = CCStr::capture( function( $name )
{
	return "Hello ".$name;
}, array( 'Felix' ));

print $output; // Hello Felix
```

**If your closure does return a value, that value gets returned by the capture method!**

### htmlentities

{[Parser::function_info( 'CCStr::htmlentities' )]}

```php
CCStr::htmlentities( array(
	'message' => 'This is <b>Important!</b>',
	'comments' => array(
		'<im a happy tag>',
		'this should be <span>Foo</span>'
	),
), true );
```
**Returns:**
```json
{
	"message": "This is &lt;b&gt;Important!&lt;/b&gt;",
	"comments": [
		"&lt;im a happy tag&gt;",
		"this should be &lt;span&gt;Foo&lt;/span&gt;"
	]
}
```

### suffix

{[Parser::function_info( 'CCStr::suffix' )]}

### prefix

{[Parser::function_info( 'CCStr::prefix' )]}

### extension

{[Parser::function_info( 'CCStr::extension' )]}

### hash

{[Parser::function_info( 'CCStr::hash' )]}

```php
CCStr::hash( 'foo' ); // 0beec7b5ea3f0fdbc95d0dd47f3c5bc275da8a33
```

### clean

{[Parser::function_info( 'CCStr::clean' )]}


```php
CCStr::clean( 'Hallöle!!!!!! is^^ n(i)c\'h so =le<s>e<r>l"$ich od<<<>er\"\"' ); // Halloele is nich so leserlich oder
```

Allowing other special characters

```php
CCStr::clean( 'H(a)s"t       du hunger?', '\?' ); // Hast du hunger?
```

### clean url

{[Parser::function_info( 'CCStr::clean_url' )]}

```php
CCStr::clean_url( 'Mr. Jonny *Köppl*' ); // mr-jonny-koeppl
```

```php
CCStr::clean_url( 'Team & Address+Contact' ); // team-address-contact
```

### replace

{[Parser::function_info( 'CCStr::replace' )]}

```php
CCStr::replace( 'Hello (name).', array( '(name)' => 'Jaffy' ) ); // Hello Jaffy.
```

### upper

{[Parser::function_info( 'CCStr::upper' )]}

```php
CCStr::upper( 'äccènts cän be änöying' ); // ÄCCÈNTS CÄN BE ÄNÖYING
```

### lower

{[Parser::function_info( 'CCStr::lower' )]}

```php
CCStr::upper( 'ÄCCÈNTS CÄN BE ÄNÖYING' ); // äccènts cän be änöying
```

### replace accents

{[Parser::function_info( 'CCStr::replace_accents' )]}

```php
CCStr::replace_accents( 'äccènts cän be änöying' ); // aeccents caen be aenoeying
```

### cut

{[Parser::function_info( 'CCStr::cut' )]}

### strip

{[Parser::function_info( 'CCStr::strip' )]}

### kfloor

{[Parser::function_info( 'CCStr::kfloor' )]}

### bytes

{[Parser::function_info( 'CCStr::bytes' )]}
