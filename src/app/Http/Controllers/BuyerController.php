<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BuyerController extends Controller
{
    public function buy_product(Request $request) {


        $validated = $request->validate([
            'amount_bought' => 'required|int|min:0'
        ]);
        
        $user = Auth::user();
        if ($user != null) {
            $product_id = $request->get('product_id');
            $amount_bought = $validated['amount_bought'];

            if ($product_id == null || $amount_bought == null) {
                return redirect('/home');
            }

            $product = DB::table('products')->where('product_id', '=', $product_id)->first();

            if ($product != null) {

                $amount_in_stock = $product->amount_in_stock;

                if($amount_bought > $amount_in_stock) {
                    return redirect()->back()->withErrors(
                        ['amount_bought' => 'Insufficient stock for order amount']
                    );
                }

                DB::table('products')->update(
                    ['amount_in_stock' => $product->amount_in_stock - $amount_bought]
                );

                return view('successbought', ['product' => $product]);


            } else {
                return redirect('/home');
            }

        } else {
            return redirect('/home');
        }
    }
}
