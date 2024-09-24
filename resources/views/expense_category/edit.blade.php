<!-- Modal -->
<div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">

        <x-modal-header>
            <h5 class="modal-title" id="edit">@lang('lang.edit')</h5>


        </x-modal-header>
        {!! Form::open(['url' => action('ExpenseCategoryController@update', $expense_category->id), 'method' => 'put'])
        !!}
        <div class="modal-body">
            <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="@if (app()->isLocale('ar')) mb-1 label-ar @else mb-1 label-en @endif"
                            for="name">@lang('lang.name')</label>
                        <input type="text" class="form-control" value="{{$expense_category->name}}" name="name"
                            id="name">
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-6">@lang('lang.save')</button>
            <button type="button" class="btn btn-default col-6" data-dismiss="modal">@lang('lang.close')</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
