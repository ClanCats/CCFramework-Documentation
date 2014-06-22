Generate a simple controller: 

```
$ php cli shipyard::controller ToDo
```

Will create you following class file under: `CCF/app/controllers/ToDoController.php`

```php
class ToDoController extends \CCController
{
	/**
	 * controller wake
	 * 
	 * @return void|CCResponse
	 */
	public function wake()
	{
		// Do stuff
	}

	/**
	 * index action
	 * 
	 * @return void|CCResponse
	 */
	public function action_index()
	{
		echo "ToDoController";
	}

	/**
	 * controller sleep
	 * 
	 * @return void
	 */
	public function sleep()
	{
		// Do stuff
	}
}
```

### view controller

Add the view parameter to generate a view controller.

```
$ php cli shipyard::controller ToDo -view 
```

You could also set the superclass manual.

```
$ php cli shipyard::controller ToDo CCViewController 
```

Or an example using a namespace and a superclass.

```
$ php cli shipyard::controller Newsletter::Mail -view 
```