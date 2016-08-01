  Dirty Script > hook
==========================

Very light hook system

This system works well for small projects that do not require a large hook system.

need more test and improvements, so use it for fun/test/debug/small project...

```php
/**
 * DS hook - Dirty Script, a light hook system
 * 
 * Very light hook system
 * 
 * This is a BETA, so, please, don't use this script in production.
 * If you want to impove, debug (...), go to the github of this project.
 * Thanks
 * 
 * @package   DirtyScript
 * @author    RemRem <remrem@dirty-script.com>
 * @copyright Copyright (C) dirty-script.com,  All rights reserved.
 * @licence   MIT
 * @version   0.01.000 beta
 * @link      Incoming
 * @link      https://github.com/DirtyScript/hook
 */
```

### install with composer
Coming soon

### install as simple php script
put hook.php somewhere in your projet 
and call it with a require or require_once or include or include_once (...)
the soon as possible



### Set a hook trigger
Imagine you call a config file in your project and you want a hook just after
```php
// call to your config file
require 'path/to/your/config.php';

// set a hook trigger
DS_hook_trigger('after_config');
```
Done !

### Hooking a function to a hook
Always in the same project, before your call to the config file...
```php
// the function you want to call
function function_to_call(){
	var_dump('function_to_call() is called');
}

// hooking the function
DS_hook_push( 'after_config' , 'function_to_call' );
```
Done !

### Hooking a function to a hook and set a priority
```php
// the function you want to call in last
function function_to_call_1(){
	var_dump('function_to_call_1() is called');
}
// the function you want to call in first
function function_to_call_2(){
	var_dump('function_to_call_2() is called');
}

// hooking the function function_to_call_1() with a priority at 1
DS_hook_push( 'after_config' , 'function_to_call_1' , 1 );

// hooking the function function_to_call_2() with a priority at 10
DS_hook_push( 'after_config' , 'function_to_call_2' , 10 );
```
Done !
The function_to_call_2() has a higher priority than function_to_call_1(), so function_to_call_2() will be called before function_to_call_1()

### The full exemple
```php
// the function you want to call in last
function function_to_call_1(){
	var_dump('function_to_call_1() is called');
}
// the function you want to call in first
function function_to_call_2(){
	var_dump('function_to_call_2() is called');
}

// hooking the function function_to_call_1() with a priority at 1
DS_hook_push( 'after_config' , 'function_to_call_1' , 1 );

// hooking the function function_to_call_2() with a priority at 10
DS_hook_push( 'after_config' , 'function_to_call_2' , 10 );


// some code ...


// call to your config file
require 'path/to/your/config.php';

// set a hook trigger
DS_hook_trigger('after_config');
```