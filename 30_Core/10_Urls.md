
Not using hardcoded urls has many benefits like parameter overwriting, parameter keeping, route aliasing etc
 
## Shortcut

There is a shortcut function `to` so don't get confused it does exactly the same as `CCUrl::to`.

```php
to( 'some/uri/to/my/target/' );
// equals
CCUrl::to( 'some/uri/to/my/target/' );
```

## Usage

### Current

In tons of situations you have to know the current url, the current function should help you out.

URL in the browser: `http://example.com/user/settings/?action=change_avatar`

```php
CCUrl::current(); 
```
`/user/settings/`

Adding parameters:

```php
CCUrl::current( array( 'fingerprint' => 'E343A8' ) ); 
```
`/user/settings/?fingerprint=E343A8`

Keeping the parameters

```php
CCUrl::current( array( 'fingerprint' => 'E343A8' ), true ); 
```
`/user/settings/?action=change_avatar&fingerprint=E343A8`

---

### Get parameters

You can really play with the get parameters ccf takes care itself that a correct url is generated.

```php
CCUrl::to( 'contacts/', array( 'page' => 14, 'city' => 'zurich' ) ); 
```
`/contacts/?page=14&city=zurich`


#### Overwriting parameters

CCUrl parses the given uri this way you can overwrite get parameters.

```php
CCUrl::to( '/contacts/?page=14&city=zurich', array( 'page' => 2 ) ); 
```
`/contacts/?page=2&city=zurich`

This also works of course with full urls:

```php
CCUrl::to( 'http://clancats.io/no/existing/?page=14&city=zurich', array( 'city' => 'chur' ) ); 
```
`http://clancats.io/no/existing/?page=14&city=chur`


#### uri parameters

You might also want to have a dynamic uri, you can pass them also as get parameters.

```php
to( 'user/:username/', array( 'username' => 'jeff', 'page' => 2 ) ); 
```
`/user/jeff/?page=2`

#### route parameters

When using automatic route aliases you have unnamed uri parameters you can pass them like this.

```php
// @article = articles/[any]/[num]
to( '@article', array( 'new', 50, 'page' => 2 ) ); 
```
`/articles/new/50/?page=2`

#### keeping get parameters

Often when parameters come together from multiple sources and you want to keep them all in your url. 

URL in the browser: `http://example.com/foo/?filter_name=john&filter_min_age=18`

```php
to( 'foo/search/', array( 'ref' => 'detail' ), true ); 
```
`/foo/search/?filter_name=john&filter_min_age=18&ref=detail`

And of course you can also overwrite these parameters and add new ones.

---

### Aliases

You can create links directly to an route alias wich keeps you application nicely linked.

```php
CCRouter::on( 'profile/[any]/', array( 'alias' => 'profile' ), function( $username )
{
	echo "Hallöchen ".$username;
});

// returns = /profile/john/
CCUrl::alias( 'profile', array( 'john' ) );
```

**Note:** when using the `@` character is a shortcut for `CCUrl::alias`.

```php
to( '@profile', array( 'john' ) );
```

---

### Full urls

Because you don't always need just the uri. You can of course generate full urls the same way.

```php
CCUrl::full( '/some/uri/to/something/', array( 'action' => 'delete' ) );
```
`http://example.com/some/uri/to/something/?action=delete`


```php
CCUrl::full( '@profile', array( 'john' ) );
```
`http://example.com/profile/john/`

---

### Secure ( HTTPS )

```php
CCUrl::secure( '/some/https/link/' );
```
`https://example.com/some/https/link/`

---

### Controller Action

When you currently in a Controller you can create url's to another action of that controller.

**Example:**

```php
class UserController extends \CCController
{
	public function action_profile()
	{
		echo CCUrl::action( 'settings' );
	}
	
	public function action_settings()
	{
		echo CCUrl::action( 'profile' );
	}
}
```
