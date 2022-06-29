<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sell;
use App\Models\Transaction;
use App\Models\Item;
use App\Models\Product;
use App\Models\Type;
use App\Models\ItemName;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SellController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:name,city']
        ]);

        $business_id = auth()->user()->business_id;

        $transactions = Transaction::query();
        $transactions->where('business_id', $business_id)->where('type','sell');

        if (request('search')) {
            $transactions->where('invoice_no', 'LIKE', '%' . request('search') . '%');
        }
        if (request()->has(['field', 'direction'])) {
            $transactions->orderBy(request('field'), request('direction'));
        }else{
            $transactions->orderBy('created_at', 'desc');
        }
        $transactions = $transactions->paginate(5)->withQueryString();
        foreach ($transactions as $key=>$value) {
            $transactions[$key]->sell = $value->sell;
            $transactions[$key]->item = $value->sell->item;
            $transactions[$key]->product = $value->sell->item->product;
        }
        return Inertia::render('AdminPanel/SellManagement/SellList/Index', [
            'transactions' => $transactions,
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
        $transaction = Transaction::find($id);
        if(!$transaction) return false;
        $item = $transaction->sell->item;
        $item->gold_plus_gem_weight = json_decode($item->gold_plus_gem_weight);
        $item->gem_weight = json_decode($item->gem_weight);
        $item->fee = json_decode($item->fee);

        $product = Product::find($item->product_id);
        return Inertia::render('AdminPanel/SellManagement/SellDetail/Index', [
            'transaction' => $transaction,
            'sell' => $transaction->sell,
            'item' => $item,
            'product' => $transaction->sell->item->product,
            'business' => $transaction->business,
            'businessLocation' => $transaction->businessLocation,
            'contact' => $transaction->contact,

        ]);
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
        dd("dstroy");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function productFormSave(Request $request)
    {
        $product_form = $request->product_form;
        $product = Product::find($product_form['id']);
        $product->name = $product_form['name'];
        $product->description = $product_form['description'];
        $product->draft = $product_form['approve_changes'] ? '0' : '1';
        $product->save();

        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function itemFormSave(Request $request)
    {
        $item_form = $request->item_form;
        $item = Item::find($item_form['id']);
        $item->name = $item_form['name'];
        $item->item_description = $item_form['description'];
        $item->draft = $item_form['approve_changes'] ? '0' : '1';
        $item->save();

        return back();

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function typeFormSave(Request $request)
    {
        $type_form = $request->type_form;
        $type = Type::find($type_form['id']);
        $type->name = $type_form['name'];
        $type->draft = $type_form['approve_changes'] ? '0' : '1';
        $type->save();

        return back();

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function itemNameFormSave(Request $request)
    {
        $itemname_form = $request->itemname_form;
        $item_name = ItemName::find($itemname_form['id']);
        $item_name->name = $itemname_form['name'];
        $item_name->draft = $itemname_form['approve_changes'] ? '0' : '1';
        $item_name->save();

        return back();

    }


}
