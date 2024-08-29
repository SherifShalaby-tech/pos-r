<!-- Modal -->
<div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <x-modal-header>

            <h5 class="modal-title" id="edit">@lang('lang.edit')</h5>

        </x-modal-header>

        {!! Form::open(['url' => action('JobController@update', $job->id), 'method' => 'put']) !!}
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="job_title">@lang('lang.job_title')</label>
                        <input type="text" class="form-control" value="{{$job->job_title}}" name="job_title"
                            id="job_title" required>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-6">@lang('lang.save')</button>
            <button type="button" class="btn btn-default col-6" data-dismiss="modal">Close</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
