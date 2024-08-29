<!-- Modal -->
<div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <x-modal-header>

            <h5 class="modal-title" id="edit">@lang('lang.edit')</h5>

        </x-modal-header>

        {!! Form::open(['url' => action('ExpenseBeneficiaryController@update', $expense_beneficiary->id), 'method' =>
        'put']) !!}
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="expense_category_id">@lang('lang.expense_category')</label>
                        {!! Form::select('expense_category_id', $expense_categories,
                        $expense_beneficiary->expense_category_id, ['class' => 'form-control', 'required', 'placeholder'
                        => __('lang.please_select')]) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">@lang('lang.beneficiary_name')</label>
                        <input type="text" class="form-control" value="{{$expense_beneficiary->name}}" name="name"
                            id="name" required>
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
