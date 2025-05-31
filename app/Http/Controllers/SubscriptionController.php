<?php

namespace App\Http\Controllers;

use App\Http\Middleware\isEmployer;
use App\Http\Middleware\donotAllowUserToMakePayment;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Mail\PurchaseMail;
use Illuminate\Support\Facades\Mail;

class SubscriptionController extends Controller
{
    const  WEEKLY_AMOUNT = 20;
    const  MONTHLY_AMOUNT = 80;
    const  YEARLY_AMOUNT = 200;
    const CURRENCY = 'USD';



    public function __construct()
    {
        $this->middleware(['auth', isEmployer::class]);
         $this->middleware(['auth', donotAllowUserToMakePayment::class])->except('subscribe');

    }
 

    public function subscribe()
    {

        return view('subscription.index');
    }

    public function initiatePayment(Request $request)
    {
        $plans = [
            'weekly' => [
                'name' => 'Weekly',
                'description' => 'Weekly subscription plan',
                'amount' => self::WEEKLY_AMOUNT,
                'currency' => self::CURRENCY,
                'quantity' => 1,
            ],
            'monthly' => [
                'name' => 'Monthly',
                'description' => 'Monthly subscription plan',
                'amount' => self::MONTHLY_AMOUNT,
                'currency' => self::CURRENCY,
                'quantity' => 1,
            ],
            'yearly' => [
                'name' => 'Yearly',
                'description' => 'Yearly subscription plan',
                'amount' => self::YEARLY_AMOUNT,
                'currency' => self::CURRENCY,
                'quantity' => 1,
            ]
        ];

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $selectedPlan = null;
            $billingEnd = null;

            if ($request->is('pay/weekly')) {
                $selectedPlan = $plans['weekly'];
                $billingEnd = now()->addWeek()->startOfDay()->toDateString();
            } elseif ($request->is('pay/monthly')) {
                $selectedPlan = $plans['monthly'];
                $billingEnd = now()->addMonth()->startOfDay()->toDateString();
            } elseif ($request->is('pay/yearly')) {
                $selectedPlan = $plans['yearly'];
                $billingEnd = now()->addYear()->startOfDay()->toDateString();
            }

            if ($selectedPlan) {
                $successURL = URL::signedRoute('payment.success', [
                    'plan' => $selectedPlan['name'],
                    'billing_end' => $billingEnd,
                ]);
                $session = Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [
                            'currency' => $selectedPlan['currency'],
                            'unit_amount' => $selectedPlan['amount'] * 100, // Stripe uses cents
                            'product_data' => [
                                'name' => $selectedPlan['name'],
                                'description' => $selectedPlan['description'],
                            ],
                        ],
                        'quantity' => $selectedPlan['quantity'],
                    ]],
                    'mode' => 'payment',
                    'success_url' => $successURL,
                    'cancel_url' => route('payment.cancel'),
                ]);
                return redirect($session->url);
            }
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }



    public function paymentSuccess(Request $request)
    {
        $plan = $request->plan;
        $billingEnd = $request->billing_end;
        User::where('id', auth()->id())->update([
            'plan' => $plan,
            'billing_ends' => $billingEnd,
            'status' => 'paid',
        ]);

        try {
            Mail::to(auth()->user())->queue(new PurchaseMail($plan, $billingEnd));
        } catch (\Exception $e) {
            return response()->json($e);
        }



        return redirect()->route('dashboard')->with('success', 'Payment was successfully processed .');
    }
    public function cancel(Request $request)
    {
        return redirect()->route('dashboard')->with('error', 'Payment was unsuccessful! .');
    }
}
