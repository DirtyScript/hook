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
 * @version   0.01.000 beta
 * @link      Incoming
 * @link      https://github.com/DirtyScript/hook
 */

/**
 * TO DO
 * 
 * - set a possibility to push parameter
 * - more test
 * - push to composer
 * - improve README
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
 * the hook trigger
 * 
 * @param string $hook_name, the hook name
 * @return array, the returns of the functions to call 
 */
function DS_hook_trigger($hook_name){
	global $DS_hooks,;

	$DS_hooks_return = array();

	if (!is_array($DS_hooks)){return false;}
	if (!isset($DS_hooks[$hook_name]) || !is_array($DS_hooks[$hook_name]) || count($DS_hooks[$hook_name]) < 1){return true;}
	foreach ($DS_hooks[$hook_name] as $functions){
		krsort( $functions );
		foreach ($functions as $f){
			if (function_exists( $f['function'] )){
				$DS_hooks_return[$f['function']][] = call_user_func( $f['function'] );
			} else {
				$DS_hooks_return[$f['function']][] = 'Fail! This function doesn\t exists !';
			}
		}
	}

	return $DS_hooks_return;
}
