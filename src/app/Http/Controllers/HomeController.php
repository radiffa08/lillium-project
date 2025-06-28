<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function show() {

        $featured = DB::select(
            "
            select p.product_id, p.product_name, p.price, p.description, pi.image_directory from products p
            join subcategories s on s.subcategory_id  = p.subcategory_id 
            left join product_images pi on pi.product_id = p.product_id
            and pi.image_id = (
                select MIN(image_id)
                from product_images
                where product_id = p.product_id
            )
            where p.is_featured = true
            group by p.product_id, p.product_name, p.price, p.description, pi.image_directory
            order by pi.image_id
            ;
            "
        ); 

        return view('home', ['featured' => $featured]);
    }
}
