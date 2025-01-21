<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\PaymentMethodType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentMethodTypeController extends Controller
{
    public function addType($payment_method_id)
    {
        $payment_method = PaymentMethod::findOrFail($payment_method_id);

        return view('payment_method_types.create', compact('payment_method'));
    }
    // public function storeType(Request $request)
    // {

    //     $this->validate(
    //         $request,
    //         ['name' => ['required', 'max:255']],
    //     );

    //     try {
    //         $data = $request->except('_token');


    //         if ($request->is_active === null) {
    //             $data['is_active'] = 0;
    //         } else {
    //             $data['is_active'] = 1;
    //         }

    //         DB::beginTransaction();
    //         PaymentMethodType::create($data);

    //         DB::commit();
    //         $output = [
    //             'success' => true,
    //             'msg' => __('lang.success')
    //         ];
    //     } catch (\Exception $e) {
    //         Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
    //         $output = [
    //             'success' => false,
    //             'msg' => __('lang.something_went_wrong')
    //         ];
    //     }
    //     return redirect()->back()->with('status', $output);
    // }


    public function storeType(Request $request)
    {
        $this->validate(
            $request,
            ['name.*' => ['required', 'max:255']]
        );

        try {
            $data = $request->all();

            DB::beginTransaction();

            foreach ($data['name'] as $index => $name) {
                PaymentMethodType::create([
                    'payment_method_id' => $data['payment_method_id'],
                    'name' => $name,
                    'is_active' => isset($data['is_active'][$index]) ? 1 : 0,
                ]);
            }

            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return redirect()->back()->with('status', $output);
    }


    public function getTypes($payment_method_id)
    {
        $payment_method = PaymentMethod::with('paymentMethodTypes')->findOrFail($payment_method_id);

        return view('payment_method_types.show', compact('payment_method'));
    }

    public function updateTypes(Request $request, $payment_method_id)
    {
        $validated = $request->validate([
            'types' => 'required|array',
            'types.*.name' => 'required|string|max:255',
            'types.*.is_active' => 'required|boolean', // Accepts both 0 and 1 as valid
        ]);

        try {
            DB::beginTransaction();

            $types = $validated['types'];

            foreach ($types as $type_id => $type_data) {
                $paymentMethodType = PaymentMethodType::find($type_id);

                if (!$paymentMethodType) {
                    continue;
                }

                $paymentMethodType->update([
                    'name' => $type_data['name'],
                    'is_active' => $type_data['is_active'], // Use directly from the form
                ]);
            }

            $existing_type_ids = array_keys($types);
            PaymentMethodType::where('payment_method_id', $payment_method_id)
                ->whereNotIn('id', $existing_type_ids)
                ->delete();

            DB::commit();

            return redirect()->back()->with('status', [
                'success' => true,
                'msg' => __('lang.success'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            return redirect()->back()->with('status', [
                'success' => false,
                'msg' => __('lang.something_went_wrong'),
            ]);
        }
    }
}
