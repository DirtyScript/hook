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
 * @version   0.02.000 beta
 * @link      Incoming
 * @link      https://github.com/DirtyScript/hook
 */

/**
 * TO DO
 * 
 * - more test
 * - push to composer
 * - improve README
 * - add a "exemple.php"
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
 * @param string $hook_name, the hook name
 * @return array, the returns of the functions to call 
 */
function DS_hook_trigger($hook_name){
	global $DS_hooks;

	if (!is_array($DS_hooks)){return false;}
	if (!isset($DS_hooks[$hook_name])
	 || !is_array($DS_hooks[$hook_name])
	 || count($DS_hooks[$hook_name]) < 1
	){
		return true;
	}

	$args = func_get_args();
	$DS_hooks_return = array();

	foreach ($DS_hooks[$hook_name] as $functions){
		krsort( $functions );
		foreach ($functions as $function){
			if (function_exists( $function )){
				$DS_hooks_return[$function][] = call_user_func( $function , $args );
			} else {
				$DS_hooks_return[$function][] = 'Fail! This function doesn\t exists !';
			}
		}
	}

	return $DS_hooks_return;
}



