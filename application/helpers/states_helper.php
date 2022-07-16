<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Get all states stored in database
 * @return array
 */
function get_all_states($country_id="")
{
	if($country_id!=""){
		return hooks()->apply_filters('all_states', get_instance()->db->where('country_id',$country_id)->order_by('short_name', 'asc')->get(db_prefix().'states')->result_array());
	}
	else{
		return hooks()->apply_filters('all_states', get_instance()->db->order_by('short_name', 'asc')->get(db_prefix().'states')->result_array());
	}
}
/**
 * Get state row from database based on passed state id
 * @param  mixed $id
 * @return object
 */
function get_state($id)
{
    $CI = & get_instance();

    $state = $CI->app_object_cache->get('db-state-' . $id);

    if (!$state) {
        $CI->db->where('state_id', $id);
        $state = $CI->db->get(db_prefix().'states')->row();
        $CI->app_object_cache->add('db-state-' . $id, $state);
    }

    return $state;
}
/**
 * Get state short name by passed id
 * @param  mixed $id county id
 * @return mixed
 */
function get_state_short_name($id)
{
    $state = get_state($id);
    if ($state) {
        return $state->iso2;
    }

    return '';
}
/**
 * Get state name by passed id
 * @param  mixed $id county id
 * @return mixed
 */
function get_state_name($id)
{
    $state = get_state($id);
    if ($state) {
        return $state->short_name;
    }

    return '';
}
