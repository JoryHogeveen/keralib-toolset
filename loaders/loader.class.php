<?php
/**
 * @package Loader
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'KERALIB_TOOLSET_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! class_exists( 'KeralibToolset_Loader' ) ) {
class KeralibToolset_Loader 
{
	
	protected $actions;
	protected $filters;
	
	public function __construct()
	{
		$this->actions = array();
		$this->filters = array();
	}
	
    public function add_action( $hook, $component, $priority, $accepted_args, $callback )
	{
        $this->actions = $this->add( $this->actions, $hook, $component, $priority, $accepted_args, $callback );
    }
 
    public function add_filter( $hook, $component, $priority, $accepted_args, $callback )
	{
        $this->filters = $this->add( $this->filters, $hook, $component, $priority, $accepted_args, $callback );
    }	   
	
	private function add( $hooks, $hook, $component, $priority = 10, $accepted_args = 1, $callback )
	{
        $hooks[] = array(
            'hook'      => $hook,
            'component' => $component,
            'priority'      => $priority,
            'accepted_args' => $accepted_args,
            'callback'  => $callback
        );
 
        return $hooks;
    }
	
    public function run()
	{
        foreach ( $this->filters as $hook ) {
            add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
        }
 
        foreach ( $this->actions as $hook ) {
            add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
        }
    }
}
}
