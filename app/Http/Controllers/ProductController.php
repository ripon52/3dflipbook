<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function products(Request $request)
    {

        $products = Product::paginate(10); // ✅ Always load products

        if ($request->ajax()) {
            // Return only the "content" section from the view
            return view('pages.products', compact('products'))->renderSections()['content'];
        }

        // Also return the full view for non-AJAX (initial load or browser refresh)
        return view('pages.products', compact('products'));
    }
}
