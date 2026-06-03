<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function show() {

        $featured = DB::select(
            "
            SELECT 
                p.product_id, 
                p.product_name, 
                p.price, 
                p.description, 
                pi.image_directory,
                pi.image_id
            FROM products p
            JOIN subcategories s 
                ON s.subcategory_id = p.subcategory_id 
            LEFT JOIN product_images pi 
                ON pi.product_id = p.product_id
                AND pi.image_id = (
                    SELECT MIN(image_id)
                    FROM product_images
                    WHERE product_id = p.product_id
                )
            WHERE p.is_featured = TRUE
            AND p.is_on_sale = TRUE
            GROUP BY 
                p.product_id, 
                p.product_name, 
                p.price, 
                p.description, 
                pi.image_directory,
                pi.image_id
            ORDER BY pi.image_id;
            "
        ); 

        return view('home', ['featured' => $featured]);
    }
}
