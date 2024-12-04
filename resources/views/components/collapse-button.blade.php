<button class="btn text-white {{ $buttonClass }}" type="button" data-bs-toggle="collapse"
    data-bs-target="#{{ $collapseId }}" aria-expanded="false" aria-controls="{{ $collapseId }}">

    {{ $slot }}

</button>