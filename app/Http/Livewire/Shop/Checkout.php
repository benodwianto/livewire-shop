<?php

namespace App\Http\Livewire\Shop;

use App\Facades\Cart;
use Livewire\Component;

class Checkout extends Component
{
    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $address;
    public $city;
    public $postalCode;
    public $checkoutForm;
    public $snapToken;

    protected $listeners = [
        'emptyCart' => 'emptyCartHandler'
    ];
    public function mount()
    {
        $this->checkoutForm = true;
    }
    public function render()
    {
        return view('livewire.shop.checkout');
    }

    public function checkout()
    {
        $this->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postalCode' => 'required',

        ]);

        $cart = Cart::get()['products'];
        $amount = array_sum(
            array_column($cart, 'price')
        );

        $transactionDetails = [
            'order_id' => uniqid(),
            'gross_amount' => $amount
        ];

        $customerDetails = [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'postal_code' => $this->postalCode
        ];

        $payLoad = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails
        ];

        $this->checkoutForm = false;

        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');

        $snapToken = \Midtrans\Snap::getSnapToken($payLoad);
        $this->snapToken = $snapToken;
    }

    public function emptyCartHandler()
    {
        Cart::clear();
        $this->emit('cartClear');
    }
}
