<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use DB;
use Crypt;
use Validator;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function expired_subscription($id=NULL){
        /**
            This function is to change user_subscription->status to 2. 
        **/
        // subscription->status = 1: ongoing, 2: expired, 3: calculated  

        $now = date("Y-m-d");

        $subscription = DB::table('users_subscription')
                        ->where('id', 4)
                        ->where('status', 1)
                        ->first();

        if ($subscription){                
          $end_subscribtion = date("Y-m-d", strtotime($subscription->subscription_ends_time_stamp));
          if ($now > $end_subscribtion && $subscription->status == 1){
              DB::table('users_subscription')->where('id', 4)->update([
                  'status' => 2
                ]);
              return "change from ongoing to expired";
          }else{
              return "false";
          }
        }else {
          echo "no record";
        }

    }

    public function calculate_revenue($id=NULL){
        /**
            This function to divided the user subscription with author revenue
        **/

        $subscription = DB::table('users_subscription')->where('id', 4)->first();      
        $now = date("Y-m-d");
        $end_subscribtion = date("Y-m-d", strtotime($subscription->subscription_ends_time_stamp));
        
        if ($now > $end_subscribtion && $subscription->status == 2){
            $get_user_download = DB::table('users_download')
                                ->join('author_product', 'users_download.product_id', '=', 'author_product.id')
                                ->select('author_product.author_id')
                                ->where('subscription_id', $subscription->id)
                                ->get();      
            
            $num_download = count($get_user_download);
            $revenue = 4.5/count($get_user_download);

            // code divided revenue to author
            $set_revenue = json_decode($get_user_download, true);
            foreach($set_revenue as $item) {
            
              // get author
              $get_author = DB::table('author')->where('id', $item['author_id'])->first();
              
              // divided revenue and record to database
              DB::table('author')->where('id', $item['author_id'])->update([
                'revenue' => $get_author->revenue + $revenue
              ]);
              
            }

            $subscription = DB::table('users_subscription')->where('id', 4)->update([
                'status' => 3
            ]);

            echo "success divided revenue";

        }elseif ($now > $end_subscribtion && $subscription->status == 1) {
            return "ongoing";
        }else {
            return "unknown";
        }

    }    

    public function auth(Request $request){
      if (! $request->session()->get('author')){
        return redirect()->route('author_login');
      }
    }

    public function author_register(Request $request)
    {
        if ($request->session()->get('author')){
            return redirect()->route('author_profile');
        }

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4|max:100',
                'username' => 'required|min:4|max:30|unique:author',
                'email' => 'required|email|max:100|unique:author',
                'password' => 'required|min:6',
                'password_confirmation' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $register = [
                   'name' => $request->input('name'),
                   'username' => $request->input('username'),
                   'email' => $request->input('email'),
                   'password' => $request->input('password'),
                    'remember_token' => str_random()
            ];

            $id = DB::table('author')->insertGetId($register);
            $request->session()->flash('success', 'You have successfully registered please confirm your email');
            return redirect()->route('author_login');

        }

        return view('author/register');

    }


    public function author_logout(Request $request)
    {
        if (! $request->session()->get('author')){
            return redirect()->route('author_login');
        }
        $request->session()->forget('author');
        $request->session()->flash('success', 'Your have logged out');
        return redirect()->route('author_login');

    }

    public function author_report(Request $request)
    {
        
        
        return view('author/report/report');
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

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4|max:100',
                'username' => 'required|min:4|max:20',
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                return redirect()->route('author_profile')->withErrors($validator);
            }

            try {
                  DB::table('author')->where('id', $author->id)->update
                  ([
                        'email' => $request->input('email'),
                        'name' => $request->input('name'),
                        'username' => $request->input('username'),
                  ]);
                  // session
                  $request->session()->forget('author');
                  $request->session()->put('author', $request->input('email'));
                  $request->session()->flash('success', 'Your profile updated successfully ');
                  return redirect()->route('author_profile');
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

         if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'new_password' => 'required|min:4|max:100',
                're_new_password' => 'required|same:new_password',
            ]);

            if ($validator->fails()) {
                return redirect()->route('author_change_pwd')->withErrors($validator);
            }    

            if ($author && $author->password == $request->input('current_password')){
                DB::table('author')->where('id', $author->id)->update([
                    'password' => $request->input("new_password")
                ]);
                $request->session()->flash('success', 'Your password changed successfuly');
                return redirect()->route('author_change_pwd');
            }else{
                $request->session()->flash('error', 'Your current password wrong or invalid');
                return redirect()->route('author_change_pwd');
            }
        }

        return view('author/change_pwd');
    }

    public function list_product(Request $request)
    { 
        if (! $request->session()->get('author')){
            return redirect()->route('author_login');
        }

        $email = $request->session()->get('author');
        $author = DB::table('author')->where('email', $email)->first();
        $products = DB::table('author_product')->where('author_id', $author->id)->orderBy('id', 'dsc')->paginate(10);
        return view('author/product/list', compact('products'));
    }

    public function add_product(Request $request)
    {

       
        if (! $request->session()->get('author')){
            return redirect()->route('author_login');
        }


        $email = $request->session()->get('author');
        $author = DB::table('author')->where('email', $email)->first();
        $category = DB::table('product_categories')->orderBy('id', 'dsc')->get();

        if ($request->isMethod('post')) {
            // $request->input('description') && $request->hasFile('preview_image_4') && $request->hasFile('preview_image_3') && $request->hasFile('preview_image_2') &&  $request->hasFile('preview_image_1') && $request->hasFile('zip_file') && $request->hasFile('cover_image') && $request->input('title') && $request->input('item_type') && $request->input('categories')

            $validator = Validator::make($request->all(), [
                'title' => 'required|max:200',
                'cover_image' => 'required|image|mimes:jpg,png',
                'zip_file' => 'required|mimes:zip',
                'file_type' => 'required|max:200',
                'requirements' => 'required|max:200',
                'description' => 'required|max:2000',
            ]);

            if ($validator->fails()) {
                return redirect()->route('author_add_product')->withErrors($validator);
            }

               try { 
                
                $add = [
                    'author_id' => $author->id,
                    'title' => $request->input('title'),
                    'tag_line' => $request->input('tag_line'),
                    'category' => $request->input('category'),
                    'file_type' => $request->input('file_type'),
                    'requirements' => $request->input('requirements'),
                    'tag' => $request->input('tag'),
                    'description' => $request->input('description'),
                    'status' => 1,  // status = 1: approved, 2: draft, 3: banned
                    'viewer' => 1  
                ];

                 // Cover Image 
                 $cover_image = time()."-".$request->file('cover_image')->getClientOriginalName();
                 Storage::disk('s3')->files();
                 Storage::put('cover_image/'.$cover_image, file_get_contents($request->file('cover_image')), 'public');
                 $add['cover_image']  = $cover_image;

                 // Item Zip
                 $zip_file = time()."-".$request->file('zip_file')->getClientOriginalName();
                 Storage::disk('s3')->files();
                 Storage::put('zip_file/'.$zip_file, file_get_contents($request->file('zip_file')), 'public');                 
                 $add['zip_file']  = $zip_file;

                // Preview Image 1
                if ($request->file('preview_image_1')){ 
                    
                     $preview_image_1 = time()."-".$request->file('preview_image_1')->getClientOriginalName();
                     Storage::disk('s3')->files();
                     Storage::put('preview_image/'.$preview_image_1, file_get_contents($request->file('preview_image_1')), 'public');
                     $add['preview_image_1']  = $preview_image_1;
                }

                // Preview Image 2
                if ($request->file('preview_image_2')){ 
                    
                     $preview_image_2 = time()."-".$request->file('preview_image_2')->getClientOriginalName();
                     Storage::disk('s3')->files();
                     Storage::put('preview_image/'.$preview_image_1, file_get_contents($request->file('preview_image_2')), 'public');
                     $add['preview_image_2']  = $preview_image_2;
                }

                // Preview Image 3
                if ($request->file('preview_image_3')){ 
                     $preview_image_3 = time()."-".$request->file('preview_image_3')->getClientOriginalName();
                     Storage::disk('s3')->files();
                     Storage::put('preview_image/'.$preview_image_3, file_get_contents($request->file('preview_image_3')), 'public');
                     $add['preview_image_3']  = $preview_image_3;
                }


                // Preview Image 4
                if ($request->file('preview_image_4')){ 
                     $preview_image_4 = time()."-".$request->file('preview_image_4')->getClientOriginalName();
                     Storage::disk('s3')->files();
                     Storage::put('preview_image/'.$preview_image_4, file_get_contents($request->file('preview_image_4')), 'public');
                     $add['preview_image_4']  = $preview_image_4;
                }
                 
                 $id = DB::table('author_product')->insertGetId($add);

                 $request->session()->flash('success', 'The product added successfully');
                 return redirect()->route('author_list_product');

               } catch (Exception $e){
                  return "some problem with token";
               } 
            
        }
        return view('author/product/add', compact('category'));
    }

    public function delete_product(Request $request, $id){
    
        if (! $request->session()->get('author')){
            return redirect()->route('author_login');
        }

        $email = $request->session()->get('author');
        $author = DB::table('author')->where('email', $email)->first();

        $product = DB::table('author_product')->where('id', $id)->first();  


        if ($product){

              if ($author->id != $product->author_id){
                  $request->session()->flash('error', 'You dont have permission to delete the product');
                  return redirect()->route('author_list_product');
              }    

             // delete cover image on AWS 
             Storage::disk('s3')->delete("cover_image/".$product->cover_image);

             // delete zip file on AWS 
             Storage::disk('s3')->delete("zip_file/".$product->zip_file);

             // delete preview image 1 on AWS 
             Storage::disk('s3')->delete("preview_image/".$product->preview_image_1);

             // delete preview image 2 on AWS 
             Storage::disk('s3')->delete("preview_image/".$product->preview_image_2);

             // delete preview image 3 on AWS 
             Storage::disk('s3')->delete("preview_image/".$product->preview_image_3);

             // delete preview image 4 on AWS 
             Storage::disk('s3')->delete("preview_image/".$product->preview_image_4);

             $product = DB::table('author_product')->where('id', $id)->delete();
             $request->session()->flash('success', 'The product deleted successfuly');
             return redirect()->route('author_list_product');
         }else{
           $request->session()->flash('error', 'The product is not exists');
           return redirect()->route('author_list_product');
         }

    }

    public function edit_product(Request $request, $id)
    {
       if (! $request->session()->get('author')){
            return redirect()->route('author_login');
        }

        if (! $request->session()->get('author')){
            return redirect()->route('author_login');
        }

        $email = $request->session()->get('author');
        $author = DB::table('author')->where('email', $email)->first();

        $product = DB::table('author_product')->where('id', $id)->first();  
        $category = DB::table('product_categories')->orderBy('id', 'dsc')->get();

        if ($product){
           if ($author->id != $product->author_id){
                  $request->session()->flash('error', 'You dont have permission to edit the product');
                  return redirect()->route('author_list_product');
            }  
        }

            if ($request->isMethod('post')) {

                $validator = Validator::make($request->all(), [
                    'title' => 'required|max:200',
                    'cover_image' => 'image|mimes:jpg,png',
                    'zip_file' => 'mimes:zip',
                    'file_type' => 'required|max:200',
                    'requirements' => 'required|max:500',
                    'description' => 'required|max:2000',
                ]);

                if ($validator->fails()) {
                    return redirect()->route('author_edit_product',  ['id' => $id])->withErrors($validator);
                }


                $update = [
                    'title' => $request->input('title'),
                    // 'slug_url' => str_slug(time()."-".$request->input('title'), '-'),
                    'tag_line' => $request->input('tag_line'),
                    'category' => $request->input('category'),
                    'file_type' => $request->input('file_type'),
                    'requirements' => $request->input('requirements'),
                    'tag' => $request->input('tag'),
                    'description' => $request->input('description'),
                ];

                if ($request->file('cover_image')){
                    // Cover Image 
                    Storage::disk('s3')->delete("cover_image/".$product->cover_image);
                    $cover_image = time()."-".$request->file('cover_image')->getClientOriginalName();
                    $update['cover_image']  = $cover_image;
                    Storage::put('cover_image/'.$cover_image, file_get_contents($request->file('cover_image')), 'public');

                }

                if ($request->file('zip_file')){
                    // ZIP Item 
                    Storage::disk('s3')->delete("zip_file/".$product->zip_file);
                    $zip_file = time()."-".$request->file('zip_file')->getClientOriginalName();
                    $update['zip_file']  = $zip_file;
                    Storage::put('zip_file/'.$zip_file, file_get_contents($request->file('zip_file')), 'public');
                }

                if ($request->file('preview_image_1')){
                    // Preview Image 1
                     Storage::disk('s3')->delete("preview_image/".$product->preview_image_1);
                     $preview_image_1 = time()."-".$request->file('preview_image_1')->getClientOriginalName();
                     $update['preview_image_1']  = $preview_image_1;
                     Storage::put('preview_image/'.$preview_image_1, file_get_contents($request->file('preview_image_1')), 'public');
                }

                if ($request->file('preview_image_2')){
                    // Preview Image 2
                     Storage::disk('s3')->delete("preview_image/".$product->preview_image_2);
                     $preview_image_2 = time()."-".$request->file('preview_image_2')->getClientOriginalName();
                     $update['preview_image_2']  = $preview_image_2;
                     Storage::put('preview_image/'.$preview_image_2, file_get_contents($request->file('preview_image_2')), 'public');
                }

                if ($request->file('preview_image_3')){
                    // Preview Image 2
                     Storage::disk('s3')->delete("preview_image/".$product->preview_image_3);
                     $preview_image_3 = time()."-".$request->file('preview_image_3')->getClientOriginalName();
                     $update['preview_image_3']  = $preview_image_3;
                     Storage::put('preview_image/'.$preview_image_3, file_get_contents($request->file('preview_image_3')), 'public');
                }

                if ($request->file('preview_image_4')){
                    // Preview Image 2
                     Storage::disk('s3')->delete("preview_image/".$product->preview_image_4);
                     $preview_image_4 = time()."-".$request->file('preview_image_4')->getClientOriginalName();
                     $update['preview_image_4']  = $preview_image_4;
                     Storage::put('preview_image/'.$preview_image_4, file_get_contents($request->file('preview_image_4')), 'public');
                }

                DB::table('author_product')->where('id', $id)->update($update);


                $request->session()->flash('success', 'The product has been successfully edited');
                return redirect()->route('author_edit_product', ['id' => $id]);
            } 
        

        return view('author/product/edit', compact('product', 'category'));


    }

    
}