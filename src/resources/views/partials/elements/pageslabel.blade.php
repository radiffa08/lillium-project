@php
    $count = isset($paginator) ? $paginator->count() : 0;
    $total = isset($paginator) ? $paginator->total() : 0;
    $current_page = isset($paginator) ? $paginator->currentPage() : 1;
    $last_page = isset($paginator) ? $paginator->lastPage() : 1;
@endphp

<span> Showing </span> {{ $count }} <span> of </span> {{ $paginator->total() }} |
<span> Page </span>
{{ $current_page }}
<span> of </span>
{{ $last_page }}
