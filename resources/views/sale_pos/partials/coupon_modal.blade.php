<!-- coupon modal -->
<div id="coupon_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <x-modal-header>

                <h5 class="modal-title">{{__('lang.coupon')}}</h5>

            </x-modal-header>

            <div class="modal-body">
                <div class="form-group mb-0">
                    <input type="text" id="coupon-code" class="form-control" placeholder="Type Coupon Code...">
                    <span class="coupon_error" style="color: red;"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary col-12 coupon-check">{{__('lang.submit')}}</button>
            </div>
        </div>
    </div>
</div>