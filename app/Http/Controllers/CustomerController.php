<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Authorizable;
use Illuminate\Http\Request;
use App\Services\CustomerService;

class CustomerController extends Controller
{
    use Authorizable;
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;    
    }
    
    // ================ DEFAULT LARAVEL ================ //
    public function index()
    {
        return view('customer.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        return $this->customerService->store($request);
    }

    public function show(Customer $customer)
    {
        //
    }

    public function edit($id)
    {
        return $this->customerService->getDataById($id);
    }

    public function update(Request $request, $id)
    {
        return $this->customerService->update($request, $id);
    }

    public function destroy(Customer $customer)
    {
        //
    }
    // ================ END DEFAULT LARAVEL ================ //

    public function loadData(Request $request)
    {
        return $this->customerService->viewData($request);
    }

    public function delete(Request $request)
    {
        return $this->customerService->delete($request);
    }
}
