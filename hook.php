<?php
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
 * @version   0.03.002 beta
 * @link      Incoming
 * @link      https://github.com/DirtyScript/hook
 */

/**
 * TO DO
 * 
 * - more test
 * - push to composer
 * - improve README
 * - add an "exemple.php"
 */



/**
 * hook system
 * push a new hook
 * 
 * @param string $hook_name, the hook name
 * @param string $function, the function to call
 * @param int $priority, in case of you have multiple callback function
 *                       who need to run in specific order (1 < 10)
 */
function DS_hook_push($hook_name, $function, $priority = 10){
	global $DS_hooks;

	if (!is_array($DS_hooks)){
		$DS_hooks = array();
	}
	$DS_hooks[$hook_name][$priority][] = $function;
}


/**
 * remove all function for a hook
 */
function DS_hook_clean( $hook_name ){
	global $DS_hooks;

	if (isset($DS_hooks[$hook_name])){
		unset( $DS_hooks[$hook_name] );
	}
}


/**
 * the hook trigger
 * call the functions who have a call pushed
 * 
 * @param string $hook_name, the hook name, required
 * @param mixed ... , you can push all the params you want
 * @return array, the returns of the functions to call 
 */
function DS_hook_trigger( $hook_name ){
	global $DS_hooks;

	$args = func_get_args();

	if (!isset($DS_hooks)
	 || !is_array($DS_hooks)
	 || !isset($DS_hooks[$hook_name])
	 || !is_array($DS_hooks[$hook_name])
	 || count($DS_hooks[$hook_name]) < 1
	){
		return $args;
	}

	foreach ($DS_hooks[$hook_name] as $functions){
		// sort by priority
		krsort( $functions );
		foreach ($functions as $function){
			if (function_exists( $function )){
				$args = call_user_func( $function , $args );
			}
		}
	}

	return $args;
}


/**
 * check if the return of a hook seem's valid
 * 
 * @param string $hook_name  
 * @param int    $args_count the total count of hook_trigger() args
 * @param array  $args       the var returned by hook_trigger()
 * @param bool   $must_die   if true, use DIE(), else return bool
 * @return bool||die()
 */
function hook_check( $hook_name , $args_count , $args , $must_die = true ){
	if (!is_array($args)){
		if ($must_die){
			die( 'hook : '. $hook_name .', must return an array.');
		} else {
			return false;
		}
	}

	if ($args_count !== count($args)){
		if ($must_die){
			die( 'hook : '. $hook_name .', does not return the correct number of arguments.');
		} else {
			return false;
		}
	}

	if (!isset($args['0'])
	 || $args['0'] != $hook_name
	){
		if ($must_die){
			die( 'hook : '. $hook_name .', the first element of the array must be the name of the hook.');
		} else {
			return false;
		}
	}

	// check the args key
	while( --$args_count ){
		if (!isset($args[$args_count])){
			if ($must_die){
				die( 'hook : '. $hook_name .', missing $args['.$args_count.'] .');
			} else {
				return false;
			}
		}
	}

	return true;
}
