
## Structure

Every theme is basically just an Orbit ship. So the basic theme structure looks like the following:

```
 - MyTheme/
   - blueprint.json      // Information about the theme and namespace
   
   - classes/            
     - Theme.php         // The theme class
     
   - config/
     - theme.config.php  // The theme configuration
     
   - views/
     - layout.php        // The theme base layout
```

## Types

CCF ships currently with 2 theme types: 

 * `CCTheme`: Simple theme with a view and a public namespace.
 * `\Packtacular\Theme`: CCTheme with automated asset packing.
 
## Blueprint

> More information about the blueprint and what options are available: [Building Ships](/docs/orbit/building_ships#blueprint-4)

```php
{
	"name": "My Theme",
	"version": "1.0.0",
	"description": "This is my awesome theme.",
	"homepage": "http://clancats.io",
	"keywords": [
		"theme"
	],
	"license": "MIT",
	"authors": [],

	"namespace": "MyTheme",

	"wake": false,
	"install": "Theme::install",
	"uninstall": "Theme::uninstall"
}
```