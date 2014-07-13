
The CCF templating engine is designed to speed up layout creation and is inspired by Twig. The view gets converted and cached as normal php code and is blazing fast.

## Using the template engine

To make use of this feature you just have to add the suffix `view` to your view file:

Normal CCView:

```php 
// /app/views/profile/index.php
CCView::create( 'profile/index' );
```

CCView with the template engine.

```php
// /app/views/profile/index.view.php
CCView::create( 'profile/index.view' );
```

## Syntax

### printing

You can print anything out using the double curly braces: `{{$var}}`, `{{myfunction()}}`.

**View file**

```php
// $name = Tarek
Hello {{$name}}
```

**Output**

```
Hello Tarek
```

#### Expression example

**View file**

```php
// $a = 5; $b = 9;
{{$a}} + {{$b}} = {{$a + $b}}
```
**Output**
```
5 + 9 = 14
```

#### If example

**View file**

```php
// $items = array( 'foo', 'bar' );
{{empty($items) ? 'There are no items.' : count($items).' items found.'}}
```
**Output**
```
2 items found.
```

### Arrays

You can access array items using the punctuation syntax.

```php
// $post['creator']['profile']['name']
{{$post.creator.profile.name}}
```

### Loops

#### Each

The each loop is pretty much a shortcut for a normal foreach loop.

**View file**

```html
// $users = [ 
//     [ name => 'Jeff' ], 
//     [ name => 'John' ], 
//     [ name => 'Jack' ] 
// ]
<ul>
{% each $users as $user %}
	<li>{{$user.name}}</li>
{% endeach %}
</ul>
```

**Output**

```html
<ul>
	<li>Jeff</li>
	<li>John</li>
	<li>Jack</li>
</ul>
```

#### Loop

You can create a fixed index loop. You can access the current index using the `$i` var.

**View file**

```php
<ul>
{% loop 5 %}
	<li>Im number {{$i+1}}</li>
{% loop %}
</ul>
```

**Output**

```html
<ul>
	<li>Im number 1</li>
	<li>Im number 2</li>
	<li>Im number 3</li>
	<li>Im number 4</li>
	<li>Im number 5</li>
</ul>
```

### If, elseif, else

```html
{% if count( $items ) > 10 %}
	<b>There are alot of items available.</b>
{% elseif count( $items ) > 0 %}
	<b>There are some items available.</b>
{% else %}
	<b>There are no items available.</b>
{% endif %}
```
