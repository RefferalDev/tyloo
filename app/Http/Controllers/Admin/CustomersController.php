<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use Intervention\Image\Facades\Image;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $customers = Customer::all();

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CustomerRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CustomerRequest $request)
    {
        $this->saveCustomer($request->all());

        return redirect()->route('admin.customers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);

        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);

        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerRequest $request
     * @param int             $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CustomerRequest $request, $id)
    {
        $this->saveCustomer($request->all(), $id);

        return redirect()->route('admin.customers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Customer::delete($id);

        return redirect()->route('admin.customers.index');
    }

    /**
     * We create or update the Customer.
     *
     * @param array    $data
     * @param int|null $id
     *
     * @return Customer
     */
    protected function saveCustomer(array $data = [], $id = null)
    {
        // Image Handling
        if (isset($data['image'])) {
            $data['image'] = $this->buildImage(str_slug($data['label']), $data['image']);
        }

        // We create the Customer
        if (null === $id) {
            return Customer::create($data);
        }

        return Customer::update($data, $id);
    }

    /**
     * Build the image.
     *
     * @param string       $slug
     * @param UploadedFile $image
     *
     * @return string
     */
    protected function buildImage($slug, $image)
    {
        $filePath = 'uploads/customers/'.$slug.'.'.$image->getClientOriginalExtension();
        Image::make($image)->save(public_path($filePath));

        return '/'.$filePath;
    }
}
