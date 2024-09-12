@props([
'buttons'=>"",
])
<div class="card mb-1 @if (app()->isLocale('ar')) page-title-ar @else page-title-en @endif">
    <div
        class="card-header py-2 d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
        {{ $slot }}

        {{ $buttons ?? $buttons }}
    </div>
</div>
