@props([
'button'=>"",
])

<div class=" {{ $groupClass }}">

    <button class="btn text-white {{ $buttonClass }}" type="button" data-bs-toggle="collapse"
        data-bs-target="#{{ $collapseId }}" aria-expanded="false" aria-controls="{{ $collapseId }}">

        {{ $button }}

    </button>

    <div class="collapse py-1 {{ $bodyClass }}" style="width:100%" id="{{ $collapseId }}">

        <div class="card py-2 mb-0">
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