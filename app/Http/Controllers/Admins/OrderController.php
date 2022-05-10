<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Item;
use App\Models\Product;
use App\Models\Type;
use App\Models\ItemName;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business_id = Auth::user()->business_id;
        $business_location_id = Auth::user()->business_location_id;

        $orders = Order::where('business_id',$business_id)
                ->where('business_location_id', $business_location_id)
                ->with('item')
                ->with('transaction')
                ->paginate(5);

        return Inertia::render('AdminPanel/OrderManagement/OrderList/Index', [
            'orders' => $orders,
            'filters' => request()->all(['search', 'field', 'direction'])
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function detail($id)
    {
        $order = Order::find($id);
        if($order == null) return false;
        $order->total_weight = json_decode($order->total_weight);
        $transaction = Transaction::where('id',$order->transaction_id)
                    ->with('business')
                    ->with('businessLocation')
                    ->with('contact')
                    ->first();

        $item = Item::find($order->item_id);
        $item->gold_weight = json_decode($item->gold_weight);
        $item->gem_weight = json_decode($item->gem_weight);
        $item->fee = json_decode($item->fee);

        $product = Product::find($item->product_id);
        $type = Type::where('key',$product->product_sku[2])
                ->first();
        $itemname = ItemName::where('key',$product->product_sku[3])
                ->first();

        return Inertia::render('AdminPanel/OrderManagement/OrderDetail/Index', [
            'order' => $order,
            'transaction' => $transaction,
            'item' => $item,
            'product' => $product,
            'type' => $type,
            'itemname' => $itemname
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
            $this->validate($request, [
                'name' => ['required', 'max:50'],
                'quality' => ['required'],
                'type' => ['required'],
                'item_name' => ['required'],
                'w_kyat' => ['required'],
                'w_pal' => ['required'],
                'w_yway' => ['required'],
            ]);
            // return $request;
            try {
                if ($file = $request->file('image')) {
                    $image_name = uniqid() . str_replace(' ', '', $file->getClientOriginalName());
                    $path = '/images/products/';
                    $file->move(public_path($path), $image_name);
                    $image_name_path = $path . $image_name;
                } else {
                    $image_name_path = null;
                }
                $product_sku = $request->quality["quality"] . $request->type["key"] . $request->item_name["key"] . $request->w_kyat["name"] . $request->w_pal["name"] . $request->w_yway["name"];
                Product::create([
                    'name' => $request->name,
                    'product_sku' => $product_sku,
                    'description' => $request->description,
                    'tax' => $request->tax,
                    'alert_quantity' => $request->alert_quantity,
                    'business_id' => auth()->user()->business_id,
                    'created_by' => auth()->user()->id,
                    'image' => $image_name_path,
                ]);
                return back();
            } catch (\Exception $e) {
                return back()->with('fail', 'Fail to Create New Product Type');
            }
        }
        return back()->with('fail', 'No permission');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
