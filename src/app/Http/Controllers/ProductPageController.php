<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductPageController extends Controller
{
    public function show(Request $request) {

        $product_id = $request->product_id;

        // $product = DB::table('products')
        //     ->join('subcategories', 'subcategories.subcategory_id' ,'=', 'products.subcategory_id')
        //     ->where('product_id', '=', $product_id)
        //     ->first();

        $product = DB::selectOne(
            "
            SELECT 
                p.product_id,
                p.product_name,
                p.price,
                p.description,
                p.subcategory_id,
                p.is_on_sale,
                p.is_featured,
                p.amount_in_stock,
                s.subcategory_name,
                COALESCE(SUM(uc.rating), 0) AS total_rating,
                COALESCE(AVG(uc.rating), 0) AS average_rating
            FROM products p
            JOIN subcategories s 
                ON s.subcategory_id = p.subcategory_id
            LEFT JOIN user_comments uc 
                ON uc.product_id = p.product_id
            WHERE p.product_id = ?
            GROUP BY 
                p.product_id,
                p.product_name,
                p.price,
                p.description,
                p.subcategory_id,
                p.is_on_sale,
                p.is_featured,
                p.amount_in_stock,
                s.subcategory_name;

             ", [$product_id]
        );


        
        $images = DB::select(
            "
            select * from product_images pi2
            where pi2.product_id = ?
            "
        , [$product_id]
        );

        $product_comments = DB::table('user_comments')
        ->join('users', 'users.id', '=', 'user_comments.user_id')
        ->where('product_id', '=', $product_id)
        ->get();
        
        return view('productpage', ['product' => $product, 'images' => $images, 'product_comments' => $product_comments]);
    }
}
