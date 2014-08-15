The command line interface can be used in 2 ways in _runtime mode_ or in _controller mode_. 

## controller mode

The script mode is simply the normal thing, you run the cli file with some arguments passed wich will execute a console controller.

The syntax is simple:

```
$ php cli <controller>::<action>
```

So for example lets print the application infos:

```
$ php cli app::info
```

<img src="/assets/images/command_line/app_info.png" style="max-width: 604px;" class="box-shadow-light" />


### Help

If the console controller implements the help action you can run that just as above using `<controller>::help` or just without passing an action.

```
$ php cli shipyard
```

<img src="/assets/images/command_line/help.png" style="max-width: 604px;" class="box-shadow-light" />

---

## Runtime mode

The runtime mode is a bit different, it acts like a shell inside CCF. You can enter the runtime cli by simply running the cli file.

```
$ php cli
```

Here you can actually write php code, make use of vars, executing CCF functions etc..

Test it by doing for example something like this:

```php
$a = 3600
$b = 3210
$a / $b 
```

<img src="/assets/images/command_line/calc.png" style="max-width: 604px;" class="box-shadow-light" />

--- 

Of course you can also run console controllers from the runtime mode.

Simple prefix `run`.

```
> run doctor::help
```