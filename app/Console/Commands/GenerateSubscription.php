<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class GenerateSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Subscription Check Expired and Calculated Revenue ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function expired_subscription($id){
        /**
            This function is to change user_subscription->status to 2. 
        **/
        // subscription->status = 1: ongoing, 2: expired, 3: calculated  

        $now = date("Y-m-d");

        $subscription = DB::table('users_subscription')
                        ->where('id', $id)
                        ->first();

        if ($subscription){                
          $end_subscribtion = date("Y-m-d", strtotime($subscription->subscription_ends_time_stamp));
          if ($end_subscribtion > $now && $subscription->status == 1){
              DB::table('users_subscription')->where('id', $id)->update([
                  'status' => 2
                ]);
              echo "change from ongoing to expired";

          // already calculated and runned calculate_revenue
          }elseif ($subscription->status == 3){
              echo "calculated ";

          // on goin
          }elseif ($subscription->status == 1){
              echo "ongoing";
          }
        }else {
          echo "norecord";
        }

    }

    public function calculate_revenue($id){
        /**
            This function to divided the user subscription with author revenue
        **/

        $subscription = DB::table('users_subscription')->where('id', $id)->first();      
        $now = date("Y-m-d");
        $end_subscribtion = date("Y-m-d", strtotime($subscription->subscription_ends_time_stamp));
        
        if ($end_subscribtion > $now && $subscription->status == 2){
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

              // insert to author revenue
              DB::table('author_revenue')->insertGetId([
                    'revenue' => $revenue,
                    'subscription_id' => $subscription->id,
                    'author_id' => $item['author_id']
              ]);

            }

            // to change users subscription status 3 (divided calculated to all author)
            DB::table('users_subscription')->where('id', $id)->update([
                'status' => 3
            ]);

            // if the users end the subscription, subscription_type will change to 1 (free member)
            DB::table('users')->where('subscription_id', $subscription->id)->update([
                  'subscription_type' => 1,
                  'subscription_id' => 0
            ]);

            echo "success divided revenue";

        }elseif ($now > $end_subscribtion && $subscription->status == 1) {
            echo "ongoing";
        }elseif ($subscription->status == 3) {
            echo "calculated";    
        }else {
            echo "unknown or divided";
        }

    }    


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Generator running, please wait ....\n\n";

        $this->expired_subscription($id=7);
        $this->calculate_revenue($id=7);
        
        echo "\n\n";        

    }
}
