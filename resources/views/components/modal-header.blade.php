<div
    class="modal-header py-2 align-items-center text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

    {{$slot}}

    <button type="button"
        class="btn text-primary rounded-circle d-flex justify-content-center align-items-center modal-close-btn"
        data-dismiss="modal">&times;</button>
</div>
