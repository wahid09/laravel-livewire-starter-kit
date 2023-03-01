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
        return Module::active()->with('children')
            ->where('parent_id', 0)
            ->orderBy('sort_order', 'asc')
            ->get();
    }
}
