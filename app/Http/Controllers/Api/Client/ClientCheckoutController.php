<?php

namespace Delivery\Http\Controllers\Api\Client;

use Delivery\Http\Controllers\Api\Client;
use Delivery\Http\Controllers\Controller;
use Delivery\Http\Requests;
use Delivery\Repositories\OrderRepository;
use Delivery\Repositories\ProductRepository;
use Delivery\Repositories\UserRepository;
use Delivery\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ClientCheckoutController extends Controller
{
    private $orderRepository;
    private $userRepository;
    private $productRepository;
    private $orderService;

    public function __construct(OrderRepository $orderRepository, UserRepository $userRepository, ProductRepository $productRepository, OrderService $orderService)
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $id = Authorizer::getResourceOwnerId();
        $clientId = $this->userRepository->find($id)->client->id;
        $orders = $this->orderRepository->with('items')->scopeQuery(function($query) use($clientId){
            //with(['items']) retorna os items junto com as ordens
            return $query->where('client_id', '=',$clientId);
        })->paginate();

        return $orders;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $id = Authorizer::getResourceOwnerId();
        $clientId = $this->userRepository->find($id)->client->id;
        $data['client_id'] = $clientId;
        $orders = $this->orderService->create($data);
        $o = $this->orderRepository->with('items')->find($orders->id);
        return $o;
    }

    public function show($id)
    {
        $o = $this->orderRepository->with(['client','items','cupom'])->find($id);
        $o->items->each(function($item){
            //nesse caso o item será uma coleção do laravel vindo da model order
            $item->product;
        });
        return $o;
    }
}