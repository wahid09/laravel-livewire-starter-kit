@props(['sortColumnName' => $sortColumnName, 'sortDirection'=>$sortDirection])
<span {{$attributes}} class="float-right text-sm" style="cursor: pointer">
    <i class="fa fa-arrow-up {{ $sortColumnName === $sortColumnName && $sortDirection === 'asc' ? '' : 'text-muted' }}"></i>
    <i class="fa fa-arrow-down {{ $sortColumnName === $sortColumnName && $sortDirection === 'desc' ? '' : 'text-muted' }}"></i>
</span>
