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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>


{{-- <x-collapse collapse-id="Filter">
    <x-slot name="button">
        button
    </x-slot>
    test
</x-collapse> --}}
