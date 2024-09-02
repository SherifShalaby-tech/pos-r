@props([
'button'=>"",
])

<div class=" {{ $groupClass }}">

    <button class="btn text-white {{ $buttonClass }}"
        style="background: linear-gradient(to right, var(--primary-color), var(--primary-color-hover));" type="button"
        data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="false"
        aria-controls="{{ $collapseId }}">

        {{ $button }}

    </button>

    <div class="collapse {{ $bodyClass }}" style="width:100%" id="{{ $collapseId }}">

        <div class="card mb-0 card-body">
            {{ $slot }}
        </div>

    </div>

</div>



{{-- <x-collapse collapse-id="Filter">
    <x-slot name="button">
        button
    </x-slot>
    test
</x-collapse> --}}
