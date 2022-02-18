<?php

namespace App\Http\Controllers;

use App\Payment\PagSeguro\CreditCard;
use Illuminate\Http\Request;
use Illuminate\View\ViewServiceProvider;

class CheckoutController extends Controller
{
    
    public function index()
    {
       // session()->forget('pagseguro_session_code');
        if(!auth()->check()){
            return redirect()->route('login');
        }

        $this->makePagSeguroSession();
        
       // var_dump(session()->get('pagseguro_session_code'));
       //$total = 0;
       $cardItems = array_map(function($line){
            return $line['amount'] * $line['price'];
       }, session()->get('cart'));

       $cartItems = array_sum($cardItems);

        return view('checkout', compact('cartItems'));
    }


    public function proccess(Request $request)
    {
        
        $dataPost = $request->all();
        $cartItems = session()->get('cart');
        $user = auth()->user();
        $reference = 'XPTO';
       
        $creditCardPayment = new CreditCard($cartItems, $user, $dataPost, $reference);
        $result = $creditCardPayment.doPayment();
        

            $userOrder = [
                'reference' => $reference,
                'pagseguro_code' => $result->getCode(),
                'pagseguro_status' => $result->getStatus(),
                'items' => serialize($cartItems),
                'store_id' => 42
            ];

            $user->orders()->create($userOrder);

            return response()->json([
                'data' => [
                    'status' => true,
                    'message' => 'Peidido Criado com sucesso!'
                ]
            ]);
           
    }

    private function makePagSeguroSession()
    {
       if(!session()->has('pagseguro_session_code')){
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            session()->put('pagseguro_session_code', $sessionCode->getResult());
       }
       

        

    }

}
