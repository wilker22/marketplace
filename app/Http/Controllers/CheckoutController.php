<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use App\Models\UserOrder;
use App\Payment\PagSeguro\CreditCard;
use App\Payment\PagSeguro\Notification;
use Illuminate\Http\Request;
use Illuminate\View\ViewServiceProvider;
use PhpParser\Node\Stmt\TryCatch;
use Ramsey\Uuid\Uuid;

class CheckoutController extends Controller
{
    
    public function index()
    {
       // session()->forget('pagseguro_session_code');
        if(!auth()->check()){
            return redirect()->route('login');
        }

        if(!session()->has('cart')) return redirect()->route('home');
        
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
        
        try{
            $dataPost = $request->all();
            $user = auth()->user();
            $cartItems = session()->get('cart');
            $stores = array_unique(array_column($cartItems, 'store_id'));
            $reference = Uuid::uuid4();
       
            $creditCardPayment = new CreditCard($cartItems, $user, $dataPost, $reference);
            
            $result = $creditCardPayment->doPayment();
        

            $userOrder = [
                'reference' => $reference,
                'pagseguro_code' => $result->getCode(),
                'pagseguro_status' => $result->getStatus(),
                'items' => serialize($cartItems),
                
            ];

          $userOrder = $user->orders()->create($userOrder);
          $userOrder->stores()->sync($stores);

          //Notificar loja de novo pedido
          $store = (new Store())->notifyStoreOwners($stores);

            session()->forget('cart');
            session()->forget('pagseguro_session_code');

            return response()->json([
                'data' => [
                    'status' => true,
                    'message' => 'Pedido Criado com sucesso!',
                    'order' => $reference
                ]
            ]);
           

        }catch (\Exception $e){
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar pedido!';
            return response()->json([
                'data' => [
                    'status' => false,
                    'message' => $message
                ]
            ], 401);
           
        }   
    }


    public function thanks()
    {
        return view('thanks');
    }

    public function notification()
    {
        try{
            $notification = new Notification();
            $notification->getTransaction();
    
            //Atualizar o pedido do usuário
            $reference = base64_decode($notification->getReference());
            $userOrder = UserOrder::whereReference($reference);
            $userOrder->update([
                'pagseguro_status' => $notification->getStatus()
            ]);
    
            //comentários sobre o pedido pago..
            if($notification->getStatus == 3){
                //liberar o pedido do usuário..., atualizar o pedido para separação logistica
                //Notificar o usuário que o pedido foi pago , usando e-mail ou sms
                //notificar a loja da confirmação do pedido
    
    
            }
    
            return response()->json([], 204);

        }catch (\Exception $e){
            $message = env('APP_DEBUG') ? $e->getMessage() : '';
            return response()->json(['error' => $message], 500);
        }

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
