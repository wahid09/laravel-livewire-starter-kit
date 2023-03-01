<?php

namespace App\Traits;

trait withDataTable
{

    public $searchTerm = null;
    public $perPage = 10;
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';

    public function sortBy($columnName)
    {
        if ($this->sortColumnName === $columnName) {
            $this->sortDirection = $this->swapSortDirection();
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortColumnName = $columnName;
    }

    public function swapSortDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }
}
