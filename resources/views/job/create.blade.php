<!-- Modal -->
<div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <x-modal-header>
            <h5 class="modal-title" id="add_job">@lang('lang.add_job')</h5>


        </x-modal-header>

        {!! Form::open(['url' => action('JobController@store'), 'method' => 'post']) !!}
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="job_title">@lang('lang.job_title')</label>
                        <input type="text" class="form-control" name="job_title" id="job_title" required>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-6">@lang('lang.save')</button>
            <button type="button" class="btn btn-secondary col-6" data-dismiss="modal">Close</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
