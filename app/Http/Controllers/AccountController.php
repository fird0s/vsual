<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Core\ServiceBuilder;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use DB;
use Crypt;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function auth(Request $request){
      if (! $request->session()->get('author')){
        return redirect()->route('author_login');
      }
    }


    public function login(Request $request)
    {
        if ($request->session()->get('author')){
            return redirect()->route('author_profile');
        }

        if ($request->input('email') && $request->input('password')){
            $author = DB::table('author')->where('email', $request->input('email'))->first();
            if ($author && $author->password == $request->input('password')){
                $request->session()->put("author", $author->email);
                return redirect()->route('author_profile');
            }else{
                $request->session()->flash('error', 'Email or password invalid');
            }
        }
        return view('author/login');
    }

    public function profile(Request $request)
    {
        if (! $request->session()->get('author')){
            return redirect()->route('author_login');
        }

        $email = $request->session()->get('author');
        $author = DB::table('author')->where('email', $email)->first();

        if ($request->input('name')){
            try {
                  DB::table('author')->where('id', $author->id)->update([
                            'email' => $request->input('email'),
                            'name' => $request->input('name'),
                  ]);
                  // session
                  $request->session()->forget('author');
                  $request->session()->put('author', $request->input('email'));
                  $request->session()->flash('success', 'Your profile updated successfully ');
                } catch(\Illuminate\Database\QueryException $ex){
                $request->session()->flash('error', 'Email or Username is being used by another author');
                return redirect()->route('author_profile');
            }
        }

        return view('author/profile', compact('author'));
    }


    public function change_pwd(Request $request)
    {

        if (! $request->session()->get('author')){
            return redirect()->route('author_login');
        }

        $email = $request->session()->get('author');
        $author = DB::table('author')->where('email', $email)->first();

         if ( $request->input("current_password") && $request->input("new_password") == $request->input("re_new_password") ){
            if ($author && $author->password == $request->input('current_password')){
                DB::table('author')->where('id', $author->id)->update([
                    'password' => $request->input("new_password")
                ]);
                $request->session()->flash('success', 'Your password changed successfuly');
                return redirect()->route('author_change_pwd');
            }else{
                $request->session()->flash('error', 'Your password wrong or invalid');
                return redirect()->route('author_change_pwd');
            }
        }

        return view('author/change_pwd');
    }

    public function list_product(Request $request)
    {
        return view('author/product/list');
    }

    public function add_product(Request $request)
    {

       
        if (! $request->session()->get('author')){
            return redirect()->route('author_login');
        }

        $email = $request->session()->get('author');
        $author = DB::table('author')->where('email', $email)->first();
        $category = DB::table('product_categories')->orderBy('id', 'dsc')->get();

        Storage::disk('s3')->files();

        if ($request->input('description') && $request->hasFile('preview_image_4') && $request->hasFile('preview_image_3') && $request->hasFile('preview_image_2') &&  $request->hasFile('preview_image_1') && $request->hasFile('zip_file') && $request->hasFile('cover_image') && $request->input('title') && $request->input('item_type') && $request->input('categories')) {
            return "ok";
        }



        return view('author/product/add', compact('category'));
    }


    
}
