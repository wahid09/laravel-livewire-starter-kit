<?php

use App\Models\Module;

if (!function_exists('getSidebar')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function getSidebar()
    {
        return Module::with('children')->where('parent_id', 0)->get();
    }
}
