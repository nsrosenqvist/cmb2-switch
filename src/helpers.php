<?php

if (! function_exists('cmb2_set_switch_default')) {
    function cmb2_set_switch_default($default)
    {
    	return (isset($_GET['post']) || isset($_GET['page'])) ? '' : ($default ? (string) $default : '');
    }
}
