
The main configuration contains most of the ClanCatsFramework settings.

> If you are not already familiar how to use CCConfig: [Configuration](/docs/core/configuration/)

## Settings

The code snippet is always the configuration default.

### Charset

The charset used in your apllication. The default is `utf-8`.

```php
'charset'	=> 'utf-8',
```

---

### Timezone

The timezone used in this project. If `null` the php default timezone will be used.

[List of available timezones](http://php.net/manual/en/timezones.php)

```php
'timezone'	=> null,
```

---

### Locale

The locale used in this project. This has no effect to the CCF translation engine.

[More information](http://php.net/manual/de/function.setlocale.php)

```php
'locale'		=> null,
```

---

### Output buffering

Enables, disables the main output buffer. On the command line this is alway `false`.

```php
'output_buffering' => true,
```

---

### App wake responses

When enabled you can return a `CCResponse` from your application wake. That response will overwrite any other action.

```php
'send_app_wake_response' => true,
```

---

### Error handling

You can customise how CCF handles errors. 

#### Fatal levels

Define what error levels are fatal and will exit the application.

```php
'error' => array(
	'fatal_levels' => array(
		E_ERROR,
		E_PARSE,
		E_CORE_ERROR,
		E_CORE_WARNING,
		E_COMPILE_ERROR,
		E_COMPILE_WARNING,
		E_DEPRECATED
	),
),
```
#### Error handler

You can extend or replace the CCF error handler. 

```php
'error' => array(
	'handler'		=> "\\".CCCORE_NAMESPACE."\\CCError_Handler_Pretty",
),
```

#### Command line error handler

You can extend or replace the command line CCF error handler. 

```php
'error' => array(
	'cli_handler'		=> null,
),
```

#### Error inspector

You can extend or replace the CCF error inspector. The error inspector get's additional information about a thrown exception.

```php
'error' => array(
	'inpector'		=> null,
),
```

---

### Profiler

You can disable the CCF profiler in development. The profiler is disabled in production by default.

```php
'profiler' => array(
	'enabled'	=> true,
),
```

---

### Database bundle

These are the settings that don't depend on a specific DB instance and act global.

#### Primary Key

The default primary key ( probably 'id' ) is used when you do for example an find opertation:

```php
// WHERE <default primary key> = 4
DB::select( 'people' )->find( '4' ); 
```

In the main configuration file:

```php
'database' => array(
	'default_primary_key' => 'id',
),
```

---

### Session bundle

These are the settings that don't depend on a specific Session instance and act global.

#### Data provider

The session sets some data automatically like: last active timestamp, client ip or the client language. You can define your own callback to set different data or add more.

```php
'session' => array(
	'default_data_provider' => '\\Session\\Manager::default_data_provider',
),
```

#### Fingerprint parameter

CCF can validate a fingerprint automatically for CSRF protection. You can change the parameter the session fingerprint gets passed.

```php
'session' => array(
	'default_fingerprint_parameter' => 's',
),
```

---

### URL configuration

If your application is not in the root directory of it's domain, you should change the url path that the router can work properly.

```php
'url'	=> array(
	'path'		=> '/',
),
```

---

### User interface helper

You can replace or extend the Uiify builder for your needs. By default we implemented the Bootstrap builder.

```php
'ui' => array(
	'builder' => "\\UI\\Builder_Bootstrap",
),

```

---

### Validation 

If you want to customise all the validation error messages you can replace the language prefix.

```php
'validation' => array(
	'language_prefix' => 'Core::validation',
),
```

---

### Storage 

If you have more storage directories and public urls to write and access files you can add them. 

#### Paths

Add more storage directories to store files.

```php
'storage' => array(
	'paths' => array(
		'main'		=> CCROOT.'storage/',
		'public'		=> PUBLICPATH.'storage/',
	),
),
```

#### URLS

If these are public accessible you can add the url where the browser should be able to find them.

```php
'storage' => array(
	'urls' => array(
		'public'		=> '/storage/',
	),
),
```

---

### Orbit 

Defines where the orbit data json file is located. The orbit.json file contains the information wich packages are installed and where they are.

```php
'orbit' => array(
	'data'	=> ORBITPATH.'orbit.json',
),
```

---

### Security 

#### Salt

A salt used by your application to crypt data. When you install CCF using composer this salt is set automatically.

```php
'security' => array(
	'salt' => 'ThisAintGoodBro',
),
```

#### Hash

Defines the default hashing function used by CCStr.

To use the builtin (PHP>=5.5) password hashing functions set this to the contant `PASSWORD_DEFAULT` or `PASSWORD_BCRYPT`.

If the function password_hash isn't available, you can add the password-compat patch using composer: `composer require ircmaxell/password-compat:1.0.*`

To make use of any other hashing algorithm simply set a string like `md5`, `sha1` or simply create a function that handles the string to be hashed.

```php
'security' => array(
	'hash' => function( $str ) 
	{
		return sha1( $str );
	}
),
```

---

### Controller arguments

Add or remove controller arguments. These arguments are needed for the HMVC layer so you can change the behaviour of a `CCRequest`.

```php
'controller' => array(
	'default_args' => array(
	
		// forces a view controller to render without the template
		'force_modal' => false,
	
		// force a theme
		'force_theme' => false,
	),
),
```

---

### Theme & View Controller

Set up your default theme and layout.

#### Default theme

Set the name of the orbit package containing your default theme.

```php
'viewcontroller' => array(
	'theme' 	=> array(
		'default' => 'Bootstrap',
	),
),
```

#### Default layout

Set the name of the view wich should contain the theme's layout.

```php
'viewcontroller' => array(
	'theme' 	=> array(
		'default_layout' => 'layout',	
	),
),
```

---

### Router configuration

These are some settings for the `CCRouter`.

#### Dynamic route any allowed characters

You can add more special characters that should be accepted in the `:any` parameter in a route.

```php
'router' => array(
	'allowed_special_chars' => '-_.:',
),
```

#### Flatten routes

Disable or enable if routes should be flatten. If enabled you can create an array hierarchy in your `router.config.php` file.

```php
'router' => array(
	'flatten_routes' => true,
),
```

#### Map file

Set the name of the default router map file.

```php
'router' => array(
	'map' => 'router', // router.config.php
),
```

---

### Language configuration

Set the default language and add more languages.

#### default

Set the default language used in your application.

```php
'language' => array(
	'default'	=> 'en-us',
),
```

#### available

Add more languages that are available in your application.

```php
'language' => array(
	'available'	=> array(),
),
```

Example with more languages:

```php
'language' => array(
	'available'	=> array(
		'de' => array(
			'de', 'ch'
		),
		'en' => array(
			'en', 'us'
		),
		'fr' => array(
			'fr'
		),
	),
),
```

---