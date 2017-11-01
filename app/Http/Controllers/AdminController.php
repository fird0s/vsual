<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use DB;
use Crypt;
use Validator;
use Illuminate\Support\Facades\Hash;

/** All Paypal Details class **/
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Session;
use Newsletter;


class AdminController extends Controller
{

    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        /** setup PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function admin_delete_category(Request $request, $id)
    {
        $email = $request->session()->get('admin');
        $admin = DB::table('admin_users')->where('email', $email)->first();
        $category = DB::table('product_categories')->where('id', $id)->first();        

        if ($category){

            // set new category for product whoose deleted category
            $another_category = DB::table('product_categories')->first();
            DB::table('author_product')->where('category', $id)->update(['category' => $another_category->id]);

            // ready to delete category
            $category = DB::table('product_categories')->where('id', $id)->delete();        
            $request->session()->flash('success', 'The category deleted successfuly');
            return redirect()->route('admin_list_category');
        }else {
            $request->session()->flash('error', 'The category is not found');
            return redirect()->route('admin_list_category');
        }
    }   

    public function admin_edit_category(Request $request, $id)
    {


        $email = $request->session()->get('admin');
        $admin = DB::table('admin_users')->where('email', $email)->first();
        $category = DB::table('product_categories')->where('id', $id)->first();

        if ($category){

        }else {
            $request->session()->flash('error', 'The category is not found');
            return redirect()->route('admin_list_category');
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2|max:100|unique:product_categories,name,'.$category->id,
                'slug_name' => 'required|max:100|alpha_dash|unique:product_categories,slug_name,'.$category->id,
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $update_category = [
                   'name' => ucwords($request->input('name')),
                   'slug_name' => str_slug($request->input('name')),
            ];

            DB::table('product_categories')->where('id', $id)->update($update_category);
            
            $request->session()->flash('success', 'You have successfully edit category');
            return redirect()->route('admin_edit_category', ['id' => $id]);

        }
                    
        return view('admin/category/edit', compact('admin', 'category'));
    }


    public function admin_list_category(Request $request)
    {
        $email = $request->session()->get('admin');
        $admin = DB::table('admin_users')->where('email', $email)->first();

        $category = DB::table('product_categories')
                    ->orderBy('created_at', 'dsc')->get();

        return view('admin/category/list', compact('admin', 'category'));
    }

    public function admin_add_category(Request $request)
    {
        $email = $request->session()->get('admin');
        $admin = DB::table('admin_users')->where('email', $email)->first();

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2|max:100|unique:product_categories',
                'slug_name' => 'required|max:100|alpha_dash|unique:product_categories',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $add_category = [
                   'name' => ucwords($request->input('name')),
                   'slug_name' => str_slug($request->input('name')),
            ];

            $id = DB::table('product_categories')->insertGetId($add_category);
            
            $request->session()->flash('success', 'You have successfully add new category');
            return redirect()->route('admin_list_category');

        }

        return view('admin/category/add', compact('admin'));
    }


    public function admin_pay_request(Request $request, $id)
    {
        $email = $request->session()->get('admin');
        $admin = DB::table('admin_users')->where('email', $email)->first();

        // get author_withdrawal 
        try {
            $author_withdrawal = DB::table('author_withdrawal')
                                    ->join('author', 'author_withdrawal.author_id', '=', 'author.id')
                                    ->select('author.name', 'author_withdrawal.id', 'author_withdrawal.amount', 'author_withdrawal.status')
                                    ->where('author_withdrawal.id', $id)
                                    ->first();

            if ($author_withdrawal->status == 2){
                 $request->session()->flash('error', 'The request cannot processed because the payment have already paid');
                 return redirect()->route('admin_payment_request');
            }

            if ($author_withdrawal->status == 1){

                // payment with paypal

                $payer = new Payer();
                $payer->setPaymentMethod('paypal');
              
                $item = new Item();
                $item->setName($author_withdrawal->name)// item name
                  ->setCurrency('USD')
                  ->setQuantity(1)
                  ->setPrice($author_withdrawal->amount); // unit price
                
                // add item to list
                $item_list = new ItemList();
                $item_list->setItems([$item]);
                
                $amount = new Amount();
                $amount->setCurrency('USD')
                  ->setTotal($author_withdrawal->amount);
                
                $transaction = new Transaction();
                $transaction->setAmount($amount)
                  ->setItemList($item_list)
                  ->setDescription('Author Withdraw');
                
                $redirect_urls = new RedirectUrls();

                // Specify return & cancel URL
                $redirect_urls->setReturnUrl(url('/admin/payment/status'))
                  ->setCancelUrl(url('/admin/payment/status'));
              
                $payment = new Payment();
                $payment->setIntent('Sale')
                  ->setPayer($payer)
                  ->setRedirectUrls($redirect_urls)
                  ->setTransactions(array($transaction));
              
                try {
                  $payment->create($this->_api_context);
                } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                  return $ex;
                  return redirect()->route('admin_payment_request');
                }
              
                foreach ($payment->getLinks() as $link) {
                  if ($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                  }
                }
              
                // add payment ID to session
                Session::put('admin_paypal_payment_id', $payment->getId());

                // add author_withdrawal ID to session
                Session::put('admin_paypal_author_withdrawal', $author_withdrawal->id);
              
                if (isset($redirect_url)) {
                  // redirect to paypal
                  return redirect($redirect_url);
                }

            // end payment with paypal

            }


        } catch(Exception $e){
            $request->session()->flash('error', $e);
            return redirect()->route('admin_payment_request');
        }   


    }

    public function admin_payment_status(Request $request){
        // Get the payment ID before session clear

        $payment_id = Session::get('admin_paypal_payment_id');
        $payment_request_id = Session::get('admin_paypal_author_withdrawal');

        // clear the session payment ID
        Session::forget('admin_paypal_payment_id');
        Session::forget('admin_paypal_author_withdrawal');
        
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
          $request->session()->flash('error', 'Your payment failed');
          return redirect()->route('admin_pay_request');
        }
        
        $payment = Payment::get($payment_id, $this->_api_context);
        
        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        
        //Execute the payment
        $result = $payment->execute($execution, $this->_api_context);
        
        if ($result->getState() == 'approved') { // payment made      
           
            // change users type to 2
            DB::table('author_withdrawal')->where('id', $payment_request_id)->update([
                'status' => 2,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            $request->session()->flash('success', 'The author payment request has been processed successfully.');
            return redirect()->route('admin_payment_request');
        }
    }    

    public function admin_payment_request(Request $request)
    {


        $email = $request->session()->get('admin');
        $admin = DB::table('admin_users')->where('email', $email)->first();

        $author_withdrawal = DB::table('author_withdrawal')
                            ->join('author', 'author_withdrawal.author_id', '=', 'author.id')
                            ->select('author_withdrawal.id', 'author_withdrawal.ref', 'author_withdrawal.status', 'author.name', 'author.email', 'author_withdrawal.amount', 'author_withdrawal.created_at')
                            ->orderBy('author_withdrawal.created_at', 'dsc')->get();

    return view('admin/payment_request/payment_request', compact('admin', 'author_withdrawal'));
    }




    public function admin_author_add(Request $request)
    {
        $email = $request->session()->get('admin');
        $admin = DB::table('admin_users')->where('email', $email)->first();


        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4|max:100',
                'email' => 'required|email|max:100|unique:author',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $add_author = [
                   'name' => $request->input('name'),
                   'username' => $request->input('email'),
                   'email' => $request->input('email'),
                   'password' => Hash::make($request->input('password')),
                   'revenue' => 0,
                   'remember_token' => str_random(),
                   'updated_at' => date('Y-m-d H:i:s')
            ];

            $id = DB::table('author')->insertGetId($add_author);
            
            // subscribe to mailchimp
            Newsletter::subscribeOrUpdate($request->input('email'), ['FNAME'=> $request->input('name'),'lastName'=>''], 'subscribers', ['interests'=>['2def5ac0f6'=>true]]);
            
            $request->session()->flash('success', 'You have successfully add an author');
            return redirect()->route('admin_author');
        }

        return view('admin/author/add', compact('admin'));
    }

    public function admin_author_detail(Request $request, $id)
    {
        
        $email = $request->session()->get('admin');
        $admin = DB::table('admin_users')->where('email', $email)->first();

        $author = DB::table('author')->where('id', $id)->first();

        $author_revenue = DB::table('author_revenue')
                                ->join('users_subscription', 'author_revenue.subscription_id', '=', 'users_subscription.id')
                                ->join('users', 'users_subscription.user_id', '=', 'users.id')
                                ->select('author_revenue.revenue', 'users.name', 'users_subscription.subscription_ends_time_stamp', 'users_subscription.status')
                                ->where('author_id', $author->id)
                                ->selectRaw('SUM(author_revenue.revenue) as sum')
                                ->groupBy('users_subscription.user_id')
                                ->get();

        $product = DB::table('author_product')
                    ->join('author', 'author_product.author_id', '=', 'author.id')
                    ->join('product_categories', 'author_product.category', '=', 'product_categories.id')
                    ->where('author_product.author_id', $id)
                    ->select('author_product.id', 'author_product.slug_url', 'author_product.title', 'author_product.created_at', 'author.name', 'product_categories.name as category_name')
                    ->orderBy('author_product.created_at', 'dsc')->get();


        $author_withdrawal = DB::table('author_withdrawal')->where('author_id', $id)->get();                        


        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4|max:100',
                'email' => 'required|email|max:100|unique:author,email,'.$author->id
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

           DB::table('author')->where('id', $author->id)->update
              ([
                    'email' => $request->input('email'),
                    'name' => $request->input('name'),
              ]);
            $request->session()->flash('success', 'You have successfully edit author');
            return redirect()->route('admin_author_detail', ['id' => $id]);
        }


        return view('admin/author/detail_author', compact('admin', 'author', 'author_revenue', 'author_withdrawal', 'product'));
    }


    public function admin_edit_product(Request $request, $id)
    {
        $email = $request->session()->get('admin');
        $admin = DB::table('admin_users')->where('email', $email)->first();

        $product = DB::table('author_product')->where('id', $id)->first();        
        $category = DB::table('product_categories')->orderBy('id', 'dsc')->get();
        $file_type = DB::table('product_file_type')->orderBy('id', 'dsc')->get();

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                    'title' => 'required|max:200',
                    'cover_image' => 'image|mimes:jpeg,jpg,png',
                    'zip_file' => 'mimes:zip',
                    'file_type' => 'max:200',
                    'requirements' => 'max:500',
                    'description' => 'required|max:2000',
                    'tag' => 'max:100',
            ]);

            if ($validator->fails()) {
                return redirect()->route('admin_edit_product',  ['id' => $id])->withErrors($validator);
            }

            $update = [
                'title' => $request->input('title'),
                // 'slug_url' => str_slug(time()."-".$request->input('title'), '-'),
                'tag_line' => $request->input('tag_line'),
                'category' => $request->input('category'),
                'tag' => $request->input('tag'),
                'description' => $request->input('description'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($request->input('file_type')){
                $update['file_type'] = implode(", ", $request->file_type);
            }

            if ($request->input('requirements')){
                $update['requirements'] = implode(", ", $request->requirements);
            }

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
                return redirect()->route('admin_edit_product', ['id' => $id]);

        }
        return view('admin/product/edit', compact('admin', 'product', 'category', 'file_type'));
    }    


    public function admin_profile_edit(Request $request)
    {
        $request->session()->put("admin", "firdauskoder@gmail.com");
        $email = $request->session()->get('admin');
        $admin = DB::table('admin_users')->where('email', $email)->first();

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4|max:50',
                'email' => 'required|email|max:100|unique:admin_users,email,'.$admin->id,
                'photo_profile' => 'image|mimes:jpeg,gif,jpg,png',
            ]);
    
            $update = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // change password
            if (Hash::check($request->input('current_password'), $admin->password) && $request->input('new_password') && $request->input('re_new_password')){
                $validator = Validator::make($request->all(), [
                    'current_password' => 'required|max:100',
                    'new_password' => 'required|min:6|max:100',
                    're_new_password' => 'same:new_password',

                ]);
                $update['password'] = Hash::make($request->input('password'));
            }else {
                $request->session()->flash('error', 'Your current password wrong or invalid');
                return redirect()->route('admin_profile_edit');
            }

            // validation form
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // upload photo profile
            if ($request->file('photo_profile')){ 
                 $photo_profile = time()."-".$request->file('photo_profile')->getClientOriginalName();
                 Storage::disk('s3')->files();
                 Storage::put('admin/profile/'.$photo_profile, file_get_contents($request->file('photo_profile')), 'public');
                 $update['photo_profile']  = $photo_profile;
            }


            $request->session()->forget('admin');
            $request->session()->put('admin', $request->input('email'));
            DB::table('admin_users')->where('email', $admin->email)->update($update);

            // subscribe to mailchimp 
            Newsletter::subscribeOrUpdate($request->input('email'), ['FNAME'=>$request->input('name'),'lastName'=>''], 'subscribers', ['interests'=>['281538d14e'=>true]]);

            $request->session()->flash('success', 'Your profile edited successfully');
            return redirect()->route('admin_profile_edit');

        }

        return view('admin/profile/edit', compact('admin'));
    }
    
    public function admin_add_admin(Request $request)
    {

        // check auth
        if (! Session::get('admin')){
            $request->session()->flash('error', 'Please Login');
            return redirect()->route('admin_login');
        }

        $email = $request->session()->get('admin');
        $admin = DB::table('admin_users')->where('email', $email)->first();

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4|max:100',
                'email' => 'required|email|max:100|unique:admin_users',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $register = [
                   'name' => $request->input('name'),
                   'email' => $request->input('email'),
                   'password' => $request->input('password'),
            ];

            $id = DB::table('admin_users')->insertGetId($register);
            
            // subscribe to mailchimp 
            Newsletter::subscribeOrUpdate($request->input('email'), ['FNAME'=>$request->input('name'),'lastName'=>''], 'subscribers', ['interests'=>['281538d14e'=>true]]);

            $request->session()->flash('success', 'You have successfully add new admin');
            return redirect()->route('admin_admin');

        }
        return view('admin/admin/add', compact('admin'));
    }

    public function admin_admin(Request $request)
    {

        // check auth
        if (! Session::get('admin')){
            $request->session()->flash('error', 'Please Login');
            return redirect()->route('admin_login');
        }

        $email = $request->session()->get('admin');
        $admin = DB::table('admin_users')->where('email', $email)->first();

        $admin_list = DB::table('admin_users')->orderBy('created_at', 'dsc')->get();

        return view('admin/admin/list', compact('admin', 'admin_list'));
    }


    public function admin_product(Request $request)
    {

        // check auth
        if (! Session::get('admin')){
            $request->session()->flash('error', 'Please Login');
            return redirect()->route('admin_login');
        }

        $email = $request->session()->get('admin');
        $admin = DB::table('admin_users')->where('email', $email)->first();

        $product = DB::table('author_product')
                    ->join('author', 'author_product.author_id', '=', 'author.id')
                    ->join('product_categories', 'author_product.category', '=', 'product_categories.id')
                    ->select('author_product.viewer', 'author_product.id', 'author_product.slug_url', 'author_product.title', 'author_product.created_at', 'author.name', 'product_categories.name as category_name')
                    ->orderBy('author_product.created_at', 'dsc')->get();

        return view('admin/product/list', compact('admin', 'product'));
    }

    public function admin_membership_detail(Request $request, $id)
    {

        // check auth
        if (! Session::get('admin')){
            $request->session()->flash('error', 'Please Login');
            return redirect()->route('admin_login');
        }
        
        $email = $request->session()->get('admin');
        $admin = DB::table('admin_users')->where('email', $email)->first();

        $membership = DB::table('users')->where('id', $id)->first();


        $subscription_history = DB::table('users_subscription')->where('user_id', $membership->id)->orderBy('created_at', 'dsc')->get();

        $downloads = DB::table('users_download')
            ->join('author_product', 'users_download.product_id', '=', 'author_product.id')
            ->join('product_categories', 'author_product.category', '=', 'product_categories.id')
            ->select('users_download.created_at', 'author_product.title', 'author_product.slug_url', 'product_categories.name', 'product_categories.slug_name')
            ->where('user_id', $membership->id)
            ->selectRaw('SUM(author_product.author_id) as sum')
            ->orderBy('users_download.created_at', 'asc')
            ->get();

        // user edit handler 
        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4|max:100',
                'email' => 'required|email|max:100|unique:users,email,'.$membership->id
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::table('users')->where('id', $membership->id)->update
              ([
                'email' => $request->input('email'),
                'name' => $request->input('name'),
              ]);

            $request->session()->flash('success', 'You have successfully edit membership');
            return redirect()->route('admin_membership_detail', ['id' => $id]);

        } 

        return view('admin/membership/detail_membership', compact('admin', 'membership', 'subscription_history', 'downloads'));
    }

    public function admin_membership(Request $request)
    {
        // check auth
        if (! Session::get('admin')){
            $request->session()->flash('error', 'Please Login');
            return redirect()->route('admin_login');
        }
        
        $email = $request->session()->get('admin');
        $admin = DB::table('admin_users')->where('email', $email)->first();

        $membership = DB::table('users')->orderBy('created_at', 'dsc')->get();

        return view('admin/membership/membership', compact('admin', 'membership'));
    }


    public function admin_forgot_password(Request $request)
    {

        if ($request->isMethod('post')) {

             $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:100',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $admin_users = DB::table('admin_users')->where('email', $request->input('email'))->first();
            
            if ($admin_users){

                // send mail forgot password to admin
                  
                $request->session()->flash('success', 'Your password has been sent to email, please check your email.');
                return redirect()->route('admin_forgot_password');
            }else {
                $request->session()->flash('error', 'Email cannot find on the system');
                return redirect()->route('admin_forgot_password');
            }

        }        



        return view('admin/profile/forgot_password');
    }

    public function admin_login(Request $request)
    {
        if ($request->session()->get('admin')){
            return redirect()->route('admin_dashboard');
        }

        // echo Hash::make('admin');

        if ($request->input('email') && $request->input('password')){
            $admin = DB::table('admin_users')->where('email', $request->input('email'))->first();
            if ($admin && Hash::check($request->input('password'), $admin->password)) {
                $request->session()->put("admin", $admin->email);

                // set last_login
                DB::table('admin_users')->where('email', $admin->email)->update([
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                return redirect()->route('admin_dashboard');
            }else{
                $request->session()->flash('error', 'Email or password invalid');
                return redirect()->route('admin_login');
            }
        }
        return view('admin/profile/login');
    }

	public function admin_logout(Request $request)
    {
        
        $request->session()->forget('admin');
        $request->session()->flash('success', 'Your have logged out');
        return redirect()->route('admin_login');
    }


    public function admin_dashboard(Request $request)
    {
        if (! Session::get('admin')){
            $request->session()->flash('error', 'Please Login');
            return redirect()->route('admin_login');
        }

    	$email = $request->session()->get('admin');
        $admin = DB::table('admin_users')->where('email', $email)->first();

        // sum query for number_of_people
        $author = DB::table('author')->count();
        $free_users = DB::table('users')->where('subscription_type', 1)->count();
        $premium_users = DB::table('users')->where('subscription_type', 2)->count();

        // sum query for number_of_product
        $free_product = DB::table('author_product')->where('free', 1)->count();
        $non_free_product = DB::table('author_product')->where('free', 0)->count();
        $product_categories = DB::table('product_categories')->count();

        $statistics = array(

        	"author" => $author,
		    "free_users" => $free_users,
		    "premium_users" => $premium_users,

		    "free_product" => $free_product,
		    "non_free_product" => $non_free_product,
		    "product_categories" => $product_categories,
		);

		// $new_author = DB::table('author')
		// 		->join('author_product', 'author.id', '=', 'author_product.author_id')
		// 		->select('author.name', 'author.email', DB::raw('count(author_product.author_id) as count'))
		// 		->paginate(5);
    	return view('admin/dashboard/dashboard', compact('admin', 'statistics', 'new_author'));
    }

    public function admin_author(Request $request)
    {
        
        if (! Session::get('admin')){
            $request->session()->flash('error', 'Please Login');
            return redirect()->route('admin_login');
        }

    	$email = $request->session()->get('admin');
        $admin = DB::table('admin_users')->where('email', $email)->first();

        // this query for author whoose have product, so this not show the author who have no product
        $author = DB::table('author')
                    ->join('author_product', 'author.id', '=', 'author_product.author_id')
                    ->select('author.id', 'author.name', 'author.email', 'author.created_at', 'author.updated_at')
                    ->selectRaw('count(author_product.author_id) as sum')
                    ->groupBy('author.id')
                    ->orderBy('author.created_at', 'dsc')->get();


        // query for author who have no product 
        $not_in_id = [];            
        foreach ($author as $key) {
           array_push($not_in_id, $key->id);
        }

        $author_null_product = DB::table('author')
                    ->whereNotIn('id', $not_in_id)
                    ->orderBy('created_at', 'dsc')->get();

        return view('admin/author/list', compact('admin', 'author', 'author_null_product'));
    }
   
}