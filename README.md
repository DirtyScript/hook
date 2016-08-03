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
 * @link      Incoming
 * @link      https://github.com/DirtyScript/hook
 */
```

### install with composer
Coming soon

### install as simple php script
put hook.php somewhere in your projet and call it with a require or require_once or include 
or include_once (...) the soon as possible.

### Recommendations for the use
The function called via the hook will receive an array argument, I advise you to always 
return this tabeau and if several functions are attached to a hook, you do not break the chain.
```php
function called_function( $args ){
  $args['1'] = strtolower( $args['1'] );
  return $args;
}
```

The trigger function will return all arguments as an array, always check the status of the 
table that the trigger function will return before working on the result.
```php
$returned = DS_hook_trigger('hook_test', $arg1 , $arg2 , $arg3 );
if (is_array($returned) && count( $returned ) === 4){
  // seem's valid !
}
```

   
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
	var_dump( 'function_to_call_1() is called' );
}
// the function you want to call in first
function function_to_call_2(){
	var_dump( 'function_to_call_2() is called' );
}

// hooking the function function_to_call_1() with a priority at 1
DS_hook_push( 'after_config' , 'function_to_call_1' , 1 );

// hooking the function function_to_call_2() with a priority at 10
DS_hook_push( 'after_config' , 'function_to_call_2' , 10 );
```
Done !
The function_to_call_2() has a higher priority than function_to_call_1(), so function_to_call_2() will be called before function_to_call_1()


### pass arguments to the target function
```php
// your function with "$args"
function function_to_call_3( $args ){
	var_dump( 'function_to_call_3() is called' );
	var_dump( $args );
}

DS_hook_push( 'arguments_exemple' , 'function_to_call_2' , 10 );

$argument_1 = 'toto';
$argument_2 = true;

// set the hook trigger
DS_hook_trigger('arguments_exemple' , $argument_1 , $argument_2 );
```
Done !

This exemple will show something like that : 

```php
// the first var_dump
string 'function_to_call_3() is called' (length=30)

// the second var_dump
array (size=3)
  0 => string 'addon_urlrewrite' (length=16)
  1 => string 'toto' (length=4)
  2 => boolean true
```

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

// function to change a value
function function_to_call_incrementing( $args ){
	$args['1'] = $args['1'] + 1;
	var_dump( 'function_to_call_incrementing() : '. $args['1'] );
	return $args;
}

// function echo $a
function echo_var_a( $args ){
	echo 'var $a = '. $args['1'];
}

// hooking the function function_to_call_incrementing() with a priority at 1
DS_hook_push( 'incrementing' , 'function_to_call_incrementing' , 1 );
// increment again, for the fun
DS_hook_push( 'incrementing' , 'function_to_call_incrementing' , 1 );

// hooking the function function_to_call_1() with a priority at 1
DS_hook_push( 'after_config' , 'function_to_call_1' , 1 );

// hooking the function function_to_call_2() with a priority at 10
DS_hook_push( 'after_config' , 'function_to_call_2' , 10 );

// hooking for showing $a
DS_hook_push( 'echo' , 'echo_var_a' , 1 );



// some code ...



// set config
$config = array(
		'dev' => true,
		'coffee' => true
	);

// set a hook trigger
DS_hook_trigger('after_config');


$a = 0;

// increment threw function_to_call_incrementing()
$temp = DS_hook_trigger( 'incrementing' , $a );
if (isset($temp['1'])){
	$a = $temp['1'];
}
// remember ? We make 2 push for function_to_call_incrementing(), so ...
var_dump( $a ); // will return 2 ;)

// now, we can just show a echo ...
$temp = DS_hook_trigger( 'echo' , $a );
```
