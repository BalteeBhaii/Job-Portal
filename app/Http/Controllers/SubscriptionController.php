<?php

namespace App\Http\Controllers;


use App\Http\Middleware\donotAllowUserToMakePayment;
use App\Http\Middleware\isEmployer;
use App\Mail\PurchaseMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Stripe\Checkout\Session;
use Stripe\Stripe;



class SubscriptionController extends Controller
{

    const WEEKLY_AMOUNT = 20;
    const MONTHLY_AMOUNT = 80;
    const YEARLY_AMOUNT = 200;
    const CURRENCY = 'USD';
    public function __construct(){
        $this->middleware(['auth', isEmployer::class]);
        // this will apply all the method inside that class except subscribe
        $this->middleware(['auth', doNotAllowUserToMakePayment::class])->except('subscribe');
    }

    public function subscribe(){
        return view('subscription.index');
    }

    public function initiatePayment(Request $request)
    {
        $plans = [
            'weekly' => [
                'name' => 'weekly',
                'description' => 'weekly payment',
                'amount' => self::WEEKLY_AMOUNT,
                'currency' => self::CURRENCY,
                'quantity' => 1,
            ],
            'monthly' => [
                'name' => 'monthly',
                'description' => 'monthly payment',
                'amount' => self::MONTHLY_AMOUNT,
                'currency' => self::CURRENCY,
                'quantity' => 1,
            ],
            'yearly' => [
                'name' => 'yearly',
                'description' => 'yearly payment',
                'amount' => self::YEARLY_AMOUNT,
                'currency' => self::CURRENCY,
                'quantity' => 1,
            ],
        ];

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $selectPlan = null;
            $billingEnds = null;

            if($request->is('pay/weekly')) {

                $selectPlan = $plans['weekly'];
                $billingEnds = now()->addWeek()->startOfDay()->toDateString();

            }elseif($request->is('pay/monthly')) {

                $selectPlan = $plans['monthly'];
                $billingEnds = now()->addMonth()->startOfDay()->toDateString();

            }elseif($request->is('pay/yearly')) {

                $selectPlan = $plans['yearly'];
                $billingEnds = now()->addYear()->startOfDay()->toDateString();

            }

            if($selectPlan) {

                $successURl = URL::signedRoute('payment.success',[
                    'plan' => $selectPlan['name'],
                    'billing_ends' => $billingEnds
                ]);

                $session = Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [
                            'currency' => $selectPlan['currency'],
                            'product_data' => [
                                'name' => $selectPlan['name'],
                                'description' => $selectPlan['description'],
                            ],
                            'unit_amount' => $selectPlan['amount'] * 100,
                        ],
                        'quantity' => $selectPlan['quantity']
                    ]],
                    'mode' => 'payment',
                    // here we can define url if payment wa sucessfully then it will call success_url and if it is not then it will call
                    // cancel_url and in success_url we used signedRoute and we pass two parameter here like billing type and billings end
                    // becuase we want to store  that data into user table
                    'success_url' => $successURl,
                    'cancel_url' => route('payment.cancel')
                ]);

                return redirect($session->url);
            }

        } catch (\Exception $e) {
            return response()->json($e);
        }
    }


    public function paymentSuccess(Request $request){
        // here we updated user table if payment was succesfull.
        $plan = $request->plan;
        $billingEnds = $request->billing_ends;
        User::where('id', auth()->user()->id)->update([
            'plan' => $plan,
            'billing_ends' => $billingEnds,
            'status' => 'paid'
        ]);
        try{
            Mail::to(auth()->user()->email)->queue(new PurchaseMail($plan, $billingEnds) );
        }catch(\Exception $e){
            return response()->json($e);
        }

        return redirect()->route('dashboard')->with('success', 'Payment was successfully processed..');
    }
    public function cancel(Request $request){
        // redirect
        return redirect()->route('dashboard')->with('error', 'Payment was unsuccessfull ..');

    }
}
