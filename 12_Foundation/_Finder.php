The Finder is the CCF autoloader it's a mixture between `PSR-0` and `PSR-4` autoloading, that might sound really freaking strange and bad in first place but makes development a bit more comfortable. Using `PSR-0` autoloading inside bundles removes the namespace ghetto and forces you to build a useful structure. 

A php namespace defines a path to a bundle. The source files inside that namespace or bundle are loaded using the `underscore` seperator.
 
```
\Example\MyBundle\Driver_Interface 
```

## Usage

### bind

{[Parser::function_info( 'CCFinder::bind' )]}
