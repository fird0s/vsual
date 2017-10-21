<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Response;

class HomeController extends Controller
{

    public function download(Request $request, $slug_url){
        if (Auth::user()){
            $user = DB::table('users')->where('id', Auth::user()->id)->first();  
            $product = DB::table('author_product')->where('slug_url', $slug_url)->first();  
            if ($product && $user->subscription_type == 2){
                $current_download = DB::table('users_download')
                    ->where('subscription_id', $user->subscription_id)
                    ->where('product_id', $product->id)
                    ->first();  

                $count = count($current_download);
                if ($count == ''){
                    DB::table('users_download')->insertGetId([
                       'product_id' => $product->id,
                       'subscription_id' => $user->subscription_id,
                       'user_id' => Auth::user()->id
                    ]);
                    return "true";
                }else{
                    return "Subscriber already downloaded the product";
                }
            }else {
                return "false";
            }
        }

    }


    public function view_product(Request $request, $slug_name){
         
        // $user = Auth::loginUsingId(13);
        // if (Auth::check()) {
        //    $request->session()->put("user", Auth::user()->email);
        // }

        // Auth::logout();

        $product = DB::table('author_product')->where('slug_url', $slug_name)->first();  
        if ($product){        
             DB::table('author_product')->where('slug_url', $slug_name)->update([
                'viewer' => $product->viewer + 1
            ]);
        }else {
            return redirect()->route('home');
        }
        return view('home/view_product', compact('product'));   
    }


    public function index(Request $request)
    {

        if (Auth::attempt(['email' => 'firdauskoder@gmail.com', 'password' => '123456'])) {
            // Authentication passed...
            return 'fuck';
        }

    	$products = DB::table('author_product')
            ->join('product_categories', 'author_product.category', '=', 'product_categories.id')
            ->select('author_product.id', 'author_product.cover_image', 'author_product.title', 'author_product.created_at', 'author_product.slug_url', 'product_categories.name', 'product_categories.slug_name')
            ->orderBy('id', 'dsc')
            ->paginate(10);
	

    	// $products = DB::table('author_product')->where('status', 1)->orderBy('id', 'dsc')->paginate(10);


        return view('welcome', compact('products'));
    }


    public function category(Request $request, $category_slug)
    {

    	$category = DB::table('product_categories')->where('slug_name', $category_slug)->first();  

    	$products = DB::table('author_product')
            ->join('product_categories', 'author_product.category', '=', 'product_categories.id')
            ->select('author_product.id', 'author_product.cover_image', 'author_product.title', 'author_product.created_at', 'author_product.slug_url', 'product_categories.name', 'product_categories.slug_name')
            ->where('category', $category->id)
            ->orderBy('id', 'dsc')
            ->paginate(10);

    	// $products = DB::table('author_product')->where('status', 1)->orderBy('id', 'dsc')->paginate(10);


        return view('home/category', compact('products', 'category'));
    }

    
    
}