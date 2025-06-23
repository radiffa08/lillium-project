<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function show(Request $request)
    {
        $search_query = $request->get('search_query') ?? "";  
        $subcats = explode(",", $request->get('subcats')) ?? [];
        $page = $request->get('page') ?? 1;

        $categories = array_filter($subcats);
        $category_question_marks = implode(", ", array_fill(0, count($categories), "?"));
        $category_selector = count($categories) > 0 ? "and s.subcategory_id in ($category_question_marks)" : "";

        $bindings = $categories;
        array_unshift($bindings, "%" . $search_query . "%");
        
        $products = DB::select(
            "
            select p.product_id, c.category_id, p.product_name, c.category_name, p.price, p.description, pi.image_directory from products p
            join categories c on c.category_id = p.category_id
            join subcategories s on s.subcategory_id  = p.subcategory_id 
            left join product_images pi on pi.product_id = p.product_id
            where p.product_name like ?
            $category_selector
            group by p.product_id, c.category_id, p.product_name, c.category_name, p.price, p.description, pi.image_directory
            order by pi.image_id
            ;
            "
            ,$bindings
        );  

        $collection = collect($products);
        $paginator = new LengthAwarePaginator($collection->forPage($page, 12), count($collection), 12, $page);


        $categories = DB::select(
            "
            select c.category_id, s.subcategory_id, c.category_name, s.subcategory_name from categories c 
            left join subcategories s on c.category_id = s.category_id
            "
        );

        $categories_map = [];

        foreach($categories as $c) {
            $key = ['key' => $c->category_id, 'value' => $c->category_name];

            if (array_key_exists(serialize($key), $categories_map) === false) {
                $categories_map[serialize($key)] = [['key' => $c->subcategory_id, 'value'=> $c->subcategory_name]];
            } else {
                array_push($categories_map[serialize($key)], ['key' => $c->subcategory_id, 'value'=> $c->subcategory_name]);
            }
        }

        return view(
            'store',
            [
                'search_query' => $search_query,
                'active_subcats' => $subcats,
                // 'products' => $products,
                'categories_map' => $categories_map,
                'paginator' => $paginator
            ]
        );
    }
}
