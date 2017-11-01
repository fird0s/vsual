<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
use DB;
use Validator;
use Mail;
use Newsletter;

class SubscribeController extends Controller
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

    public function forgot_password(Request $request){

        if ($request->isMethod('post')) {

             $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:100',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = DB::table('users')->where('email', $request->input('email'))->first();
            
            if ($user){

                // send mail forgot password to user
                  

            }else {
                $request->session()->flash('error', 'Email cannot find on system');
                return redirect()->route('subscriber_forgot_password');
            }

        }        

        return view('subscriber/forgot_password');
    }

    public function logout(Request $request){

        if (! Auth::user()){
            return redirect()->route('subscriber_login');
        }

        Auth::logout();
        $request->session()->flash('success', 'Your account have logged out');
        return redirect()->route('subscriber_login');
    }

    public function login(Request $request)
    {
        if (Auth::user()){
            return redirect()->route('subscriber_account');
        }

        // echo Hash::check('aceraspire', '$2y$10$rupUTHHXUiICtKfsZvsCCeQ/5BxPtVEu2.6t.c7IXEqNKHGihpIbe');

        if ($request->input('email') && $request->input('password')){
            $user = DB::table('users')->where('email', $request->input('email'))->first();
            if ($user && Hash::check($request->input('password'), $user->password)){
                $user = Auth::loginUsingId($user->id);

                // set last_login
                DB::table('users')->where('email', Auth::user()->email)->update([
                            'updated_at' => date('Y-m-d H:i:s')
                ]);
                
                return redirect()->route('subscriber_account');
            }else{
                $request->session()->flash('error', 'Email or password invalid');
            }
        }
        return view('subscriber/login');
    }


    public function downloads(Request $request){
        if (! Auth::user()){
            return redirect()->route('subscriber_login');
        }
        $user = DB::table('users')->where('email', Auth::user()->email)->first();        
        // $downloads = DB::table('users_download')->where('user_id', $user->id)->orderBy('id', 'dsc')->paginate(10);

        $downloads = DB::table('users_download')
            ->join('author_product', 'users_download.product_id', '=', 'author_product.id')
            ->join('product_categories', 'author_product.category', '=', 'product_categories.id')
            ->select('users_download.created_at', 'author_product.title', 'author_product.slug_url', 'product_categories.name', 'product_categories.slug_name')
            ->where('user_id', $user->id)
            ->orderBy('users_download.created_at', 'asc')
            ->paginate(10);

        return view('subscriber/account/downloads', compact('downloads'));        
    }

    public function subscriptions(Request $request){
        if (! Auth::user()){
            return redirect()->route('subscriber_login');
        }
        $user = DB::table('users')->where('email', Auth::user()->email)->first();        
        $subscriptions = DB::table('users_subscription')->where('user_id', $user->id)->orderBy('created_at', 'dsc')->paginate(10);
        return view('subscriber/account/subscriptions', compact('subscriptions'));        
    }


    public function register(Request $request)
    {
        if (Auth::user()){
            return redirect()->route('subscriber_account');
        }

        if ($request->isMethod('post')) {

             $validator = Validator::make($request->all(), [
                'name' => 'required|max:100',
                'email' => 'required|email|max:100|unique:users',
                'password' => 'required|min:6|max:100',
                'password_confirmation' => 'required|same:password',
                'package' => 'required',

            ]);

            if ($validator->fails()) {
                return redirect('/membefrship/register')
                        ->withErrors($validator);
            } 


            // if type user 1 (free membership)
            if($request->input('package') == 1){

                $id = DB::table('users')->insertGetId([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                    'subscription_type' => 1,
                    'remember_token' => str_random()
                ]);
                
                // session for user
                $user = Auth::loginUsingId($id);

                // subscribe to mailchimp 
                Newsletter::subscribeOrUpdate($request->input('email'), ['FNAME'=>$request->input('name'),'lastName'=>''], 'subscribers', ['interests'=>['4db167d066'=>true]]);

                $request->session()->flash('success', 'Hi, thank you for register, please verify your email address');
                return redirect()->route('subscriber_account');

            }


            $id = DB::table('users')->insertGetId([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                    'subscription_type' => 1,
                    'remember_token' => str_random()
            ]);

            // session for user
            $user = Auth::loginUsingId($id);

            $payer = new Payer();
            $payer->setPaymentMethod('paypal');
          
            $item = new Item();
            $item->setName('Subscribe Vsual Monthly ($9)')// item name
              ->setCurrency('USD')
              ->setQuantity(1)
              ->setPrice(9); // unit price
            
            // add item to list
            $item_list = new ItemList();
            $item_list->setItems([$item]);
            
            $amount = new Amount();
            $amount->setCurrency('USD')
              ->setTotal(9);
            
            $transaction = new Transaction();
            $transaction->setAmount($amount)
              ->setItemList($item_list)
              ->setDescription('Subscribe Vsual Monthly ($9) ');
            
            $redirect_urls = new RedirectUrls();
            // Specify return & cancel URL
            $redirect_urls->setReturnUrl(url('/membership/account/payment_status'))
              ->setCancelUrl(url('/membership'));
          
            $payment = new Payment();
            $payment->setIntent('Sale')
              ->setPayer($payer)
              ->setRedirectUrls($redirect_urls)
              ->setTransactions(array($transaction));
          
            try {
              $payment->create($this->_api_context);
            } catch (\PayPal\Exception\PayPalConnectionException $ex) {
              return $ex;
              return redirect()->route('subscriber_register');
            }
          
            foreach ($payment->getLinks() as $link) {
              if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
              }
            }
          
            // add payment ID to session
            Session::put('paypal_payment_id', $payment->getId());
          
            if (isset($redirect_url)) {
              // redirect to paypal
              return redirect($redirect_url);
            }


            $request->session()->flash('error', 'Hi, something wrong with payment, please repeat');
            return redirect()->route('subscriber_account');

        }
        return view('subscriber/register');
    }


    public function account(Request $request)
    {
        if (! Auth::user()){
            return redirect()->route('subscriber_login');
        }

        $user = DB::table('users')->where('email', Auth::user()->email)->first();      
        $user_subscriber = DB::table('users_subscription')->where('user_id', $user->id)->first();      

        if ($request->isMethod('post')) {

             $validator = Validator::make($request->all(), [
                'name' => 'required|max:100',
                'email' => 'required|email|max:100',
            ]);

            if ($validator->fails()) {
                return redirect('/membership/account')
                        ->withErrors($validator);
            }

            $update = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($request->input('current_password') && $request->input('password') && $request->input('password_confirmation')){
                if (Hash::check($request->input('current_password'), $user->password) != 1) {
                    $request->session()->flash('error', 'Your password is wrong or not match');
                    return redirect()->route('subscriber_account');
                }
                $update['password'] = Hash::make($request->input('password'));
            }

            DB::table('users')->where('email', $user->email)->update($update);
            
            // subscribe to mailchimp 
            Newsletter::subscribeOrUpdate($request->input('email'), ['FNAME'=>$request->input('name'),'lastName'=>''], 'subscribers', ['interests'=>['4db167d066'=>true]]);

            $request->session()->flash('success', 'Your profile edited successfully');
            return redirect()->route('subscriber_account');
         }   

        return view('subscriber/account/account', compact('user', 'user_subscriber'));
    }

    public function getPaymentStatus(Request $request){
        // Get the payment ID before session clear

        $payment_id = Session::get('paypal_payment_id');

        // clear the session payment ID
        Session::forget('paypal_payment_id');
        
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
          $request->session()->flash('error', 'Your payment failed');
          return redirect()->route('subscriber_account');
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
            // insert to DB users_subscription 
            $user = DB::table('users')->where('email', Auth::user()->email)->first();        

            // change users type to 2
            DB::table('users')->where('email', $user->email)->update([
                'subscription_type' => 2
            ]);

            // insert users_subscription
            $started_time_stamp = date("Y-m-d H:i:s");
            $next_month = date("Y-m-d H:i:s", strtotime("$started_time_stamp +1 month"));

            // subscriber_type = 1: free, 2: monthly, 3: yearly
            $id = DB::table('users_subscription')->insertGetId([
                'user_id' => $user->id,
                'started_time_stamp' => $started_time_stamp,
                'subscriber_type' => 2,
                'status' => 1,
                'subscription_ends_time_stamp' => $next_month
            ]);

            // change users type to 2
            DB::table('users')->where('email', $user->email)->update([
                'subscription_type' => 2,
                'subscription_id' => $id
            ]);

            $request->session()->flash('success', 'Your payment has been processed successfully.');
            return redirect()->route('subscriber_account');
        }
        
        return view('subscriber/account/payment_status', compact('author'));
    }
}