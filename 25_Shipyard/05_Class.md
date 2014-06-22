To get startet lets generate some simple Classes:

```
$ php cli shipyard::class Person
```

Will create you following class file under: `CCF/app/classes/Person.php`

```php
class Person
{
	/**
	 * static class initialisation
	 * @return void
	 */
	public static function _init()
	{
		// Do stuff
	}
}
```


### namespaces

You want to create a class in a namespace? The shipyard uses CCPath with the double double point `::` to resolve ship paths and their namespaces.If the namespace belongs to an ship the shipyard automatically uses the the version, package ect. from the ship defaults.

Examples:

_lets say we have an orbit package with the namespace `Contacts` at `CCF/orbit/Contacts/`_

```
$ php cli shipyard::class Contacts::Person
```

Will create the `Person` class with the namespace `Contacts` at `CCF/orbit/Contacts/classes/Person.php`

```
$ php cli shipyard::class Contacts::Person_Picture
```

Will create the `Person_Picture` class with the namespace `Contacts` at `CCF/orbit/Contacts/classes/Person/Picture.php`