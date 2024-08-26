@props([
'button'=>"",
])
<div>
    <button {{ $attributes->merge(['class' => 'btn btn-primary']) }} style="width:fit-content" type="button"
        data-bs-toggle="collapse"
        data-bs-target="#{{ $collapseId }}"
        aria-expanded="false" aria-controls="{{ $collapseId }}" {{ $attributes }}>
        {{ $button ?? $button }}
    </button>

    <div {{ $attributes->merge(['class' => 'collapse ']) }} style="width:100%" id="{{ $collapseId }}">

        <div class="card mb-0 card-body">
            {{ $slot }}
        </div>
    </div>
</div>




{{-- <x-collapse color="primary" collapse-id="Filter">
    <x-slot name="button">
        button
    </x-slot>
    test
</x-collapse> --}}