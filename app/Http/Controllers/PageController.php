<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function book3D(Request $request)
    {

        return view('3d.index');
    }

    // Root page
    public function home()
    {
        return view('pages.home'); // Home page view
    }

    // Products page with AJAX support
    public function products(Request $request)
    {
        $products = Product::paginate(10); // Paginated products

        if ($request->ajax()) {
            return view('products', compact('products'))->renderSections()['content'];
        }

        return view('pages.products', compact('products'));
    }

    // Product details page
    public function productDetails($id)
    {
        $product = Product::findOrFail($id);

        return view('pages.product-details', compact('product'))->renderSections()['content'];
    }

    // API route for products
    public function getProducts(Request $request)
    {
        $products = Product::paginate(10); // Paginated products
        return response()->json($products);
    }

    // API route for product details
    public function getProductDetails($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

}
