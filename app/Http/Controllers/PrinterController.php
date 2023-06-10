<?php

namespace App\Http\Controllers;


use App\Http\Requests\Printers\Update;
use App\Models\Printer;
use App\Models\Product;
use App\Models\Store;
use COM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Symfony\Component\Process\Process;

class PrinterController extends Controller
{
    public function index(){
        $printers = Printer::get();
        return view('printers.index',compact('printers'));
    }


    public function create(){
        $products = Product::get(['id','name']);
        $stores = Store::get(['id','name']);
        return view('printers.create',compact('products','stores'));
    }

    public function store(Request $request){
        DB::beginTransaction();
        // create new printer
        $printer_create = Printer::create([
            'name' => $request->name,
            'is_active' => $request->is_active,
            'is_cashier' => $request->is_cashier,
            'store_id' => $request->store_id,
        ]);
        // check products
        if($request->products){
            // loop products
            foreach ($request->products as $product){
                $data = [
                  'printer_id' => $printer_create['id'],
                  'product_id' => $product
                ];
                $insert_data[] = $data;
                $insert_data = collect($insert_data);
                $chunks = $insert_data->chunk(100);
                foreach ($chunks as $chunk)
                {
                    DB::table('printer_product')->insert($chunk->toArray());
                }
            }
        }
        DB::commit();
        return redirect(route('printers.index'));
    }

    public function edit($id){
        $printer = Printer::where('id',$id)->first();
        $products = Product::get(['id','name']);
        return view('printers.edit',compact('printer','products'));
    }

    public function update(Update $request){
        $data = $request->except('_token', '_method');
        $printer = Printer::where('id', $request->id)->update($data);
        $output = [
            'success' => true,
            'msg' => __('lang.printer_updated')
        ];

        return redirect()->back()->with('status',$output);
    }

    public function destroy($id){
        $printer = Printer::where('id',$id)->delete();
        $output = [
            'success' => true,
            'msg' => __('lang.printer_deleted')
        ];
        return $output;
    }

    public function getPrinters(Request $request)
    {
        exec('wmic printer get Name', $output);
        $printerNames = array_filter($output, function ($value) {
            return !empty(trim($value)) && $value !== 'Name';
        });
        foreach ($printerNames as $printerName) {
            // echo $printerName . "\n";
            $printer_create = Printer::firstOrCreate([
                'name' => $printerName,
                'store_id' => $request->printer_store_id
            ]);
            
        }
        $printers = Printer::where('store_id', $request->printer_store_id)->get();
        return $printers;

    }
}
