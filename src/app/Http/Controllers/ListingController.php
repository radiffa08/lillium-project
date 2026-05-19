<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        if ($user != null && $user->privilege_level > 0) {
            return BaseProductController::base_show($request, 'listing', false, false);
        } else {
            return redirect('/home');
        }
    }

    public function productedit(Request $request)
    {
        $user = Auth::user();
        if ($user != null && $user->privilege_level > 0) {

            $product_id = $request->product_id;

            if ($product_id == null) {
                return redirect()->back();
            }

            $product = DB::table('products')
                ->where('product_id', '=', $product_id)
                ->first();

            $product_images = DB::table('product_images')
                ->where('product_id', '=', $product_id)
                ->get();

            $categories = DB::select(
                "
                select c.category_id, s.subcategory_id, c.category_name, s.subcategory_name from categories c 
                left join subcategories s on c.category_id = s.category_id
                "
            );

            return view('productedit', [
                'product' => $product,
                'product_images' => $product_images,
                'categories' => $categories
            ]);
        } else {
            return redirect('/home');
        }
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        if ($user != null && $user->privilege_level > 0) {
            $product_id = $request->product_id;

            $to_delete = "storage/products/$product_id";

            if (File::exists($to_delete)) {
                File::deleteDirectory($to_delete);
            }

            DB::table('products')->where('product_id', '=', $product_id)->delete();


            return redirect('/listing');
        } else {
            return redirect('/home');
        }
    }

    public function delete_image(Request $request)
    {
        $user = Auth::user();
        if ($user != null && $user->privilege_level > 0) {
            $image_id = $request->deleted_image_id;
            $is_thumbnail = $request->is_thumbnail ?? false;

            $image_row = DB::table('product_images')
                ->where('image_id', '=', $image_id)
                ->first();

            if ($image_row != null) {
                $to_delete = "storage/" . $image_row->image_directory;

                if (File::exists($to_delete)) {
                    File::delete($to_delete);
                }
            }

            // if ($is_thumbnail == true) {
            //     DB::table('product_images')
            //     ->where('image_id', '=', $image_id)
            //     ->update(['image_directory' => null]);
            // } else {
            DB::table('product_images')
                ->where('image_id', '=', $image_id)
                ->delete();
            // }


            return redirect()->back();
        } else {
            return redirect('/home');
        }
    }

    public function new(Request $request)
    {
        $user = Auth::user();
        if ($user != null && $user->privilege_level > 0) {

            $product_id = DB::table('products')
                ->insertGetId(
                    [
                        'product_name' => 'NEW PRODUCT NAME',
                        'subcategory_id' => '1',
                        'price' => 0.0,
                    ]
                );

            return redirect()->route('listing.productedit', ['product_id' => $product_id]);
        } else {
            return redirect('/home');
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if ($user != null && $user->privilege_level > 0) {
            $validated = $request->validate([
                'product_name' => 'string|max:255',
                'is_on_sale' => 'nullable|in:on,1',
                'is_featured' => 'nullable|in:on,1',
                'price' => 'decimal:0,2|between:0,9999999999.99',
                'description' => 'nullable|string',
                'category' => 'int',
                'amount_in_stock' => 'int|min:0'
            ]);

            $is_on_sale = ($validated['is_on_sale'] ?? null) === 'on' ? 1 : 0;
            $is_featured = ($validated['is_featured'] ?? null) === 'on' ? 1 : 0;

            if ($validated) {

                DB::table('products')
                    ->where('product_id', '=', $request->product_id)
                    ->update([
                        'product_name' => $validated['product_name'],
                        'is_on_sale' => $is_on_sale,
                        'is_featured' => $is_featured,
                        'description' => $validated['description'],
                        'price' => $validated['price'],
                        'subcategory_id' => $validated['category'],
                        'amount_in_stock' => $validated['amount_in_stock']
                    ]);

                if ($request->hasFile('thumbnail')) {

                    $old_thumbnail = DB::table('product_images')
                        ->where('product_id', '=', $request->product_id)
                        ->first();

                    if ($old_thumbnail != null) {
                        $to_delete = "storage/" . $old_thumbnail->image_directory;

                        if (File::exists($to_delete)) {
                            File::delete($to_delete);
                        }
                    }

                    $image_path = $request->file('thumbnail')->store("products/$request->product_id/images", 'public');

                    if ($old_thumbnail != null) {
                        DB::table('product_images')->updateOrInsert(
                            ['product_id' => $request->product_id, 'image_id' => $old_thumbnail->image_id],
                            ['image_directory' => $image_path]
                        );
                    } else {
                        DB::table('product_images')->updateOrInsert(
                            ['product_id' => $request->product_id],
                            ['image_directory' => $image_path]
                        );
                    }
                }

                if ($request->hasFile('image')) {

                    $image_path = $request->file('image')->store("products/$request->product_id/images", 'public');

                    DB::table('product_images')->insert(
                        [
                            'image_directory' => $image_path,
                            'product_id' => $request->product_id
                        ]
                    );
                }

                return redirect()->back();
            } else {
                return redirect()->back()->withErrors($validated);
            }
        } else {
            return redirect('/home');
        }
    }
}
