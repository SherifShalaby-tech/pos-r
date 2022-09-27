<?php

namespace App\Http\Controllers;

use App\Models\Extension;
use App\Models\Product;
use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExtensionController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $commonUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $extensions = Extension::get();

        return view('extension.index')->with(compact(
            'extensions'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $quick_add = request()->quick_add ?? null;
        $is_raw_material_extension = request()->is_raw_material_extension ?? 0;

        $products = Product::where('is_raw_material', 0)->orderBy('name', 'asc')->pluck('name', 'id');

        return view('extension.create')->with(compact(
            'quick_add',
            'is_raw_material_extension',
            'products'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate(
            $request,
            ['name' => ['required', 'max:255']]
        );
        try {
            $data = $request->except('_token', 'quick_add');
            $data['sell_default_price'] = !empty($data['sell_default_price']) ? $this->commonUtil->num_uf($data['sell_default_price']) : 0;

            DB::beginTransaction();
            $extension = Extension::create($data);

            $extension_id = $extension->id;

            DB::commit();
            $output = [
                'success' => true,
                'extension_id' => $extension_id,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }


        if ($request->quick_add) {
            return $output;
        }

        return redirect()->back()->with('status', $output);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $extension = Extension::find($id);

        $products = Product::where('is_raw_material', 0)->orderBy('name', 'asc')->pluck('name', 'id');

        return view('extension.edit')->with(compact(
            'extension',
            'products'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            ['name' => ['required', 'max:255']]
        );

        try {
            $data = $request->except('_token', '_method');
            $data['sell_default_price'] = !empty($data['sell_default_price']) ? $this->commonUtil->num_uf($data['sell_default_price']) : 0;

            DB::beginTransaction();
            Extension::where('id', $id)->update($data);


            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        return redirect()->back()->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Extension::find($id)->delete();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        return $output;
    }

    /**
     * get extension drop down list
     *
     * @return void
     */
    public function getDropdown()
    {
        $extension = Extension::orderBy('name', 'asc')->pluck('name', 'id');
        $extension_dp = $this->commonUtil->createDropdownHtml($extension, 'Please Select');

        return $extension_dp;
    }

    /**
     * get extension details
     *
     * @param int $id
     * @return void
     */
    public function getExtensionDetails($id)
    {
        $extension = Extension::find($id);
        return ['extension' => $extension];
    }
}
