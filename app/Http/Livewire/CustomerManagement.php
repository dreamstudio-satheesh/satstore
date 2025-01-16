<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Customer;

class CustomerManagement extends Component
{
    use WithPagination;

    public $customerId;
    public $name;
    public $mobile;
    public $address;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'mobile' => 'required|string|unique:customers,mobile|digits:10',
        'address' => 'nullable|string',
    ];

    public function render()
    {
        $customers = Customer::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('mobile', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('livewire.customer-management', compact('customers'));
    }

    public function resetInputFields()
    {
        $this->customerId = null;
        $this->name = '';
        $this->mobile = '';
        $this->address = '';
        $this->search = '';
    }

    public function store()
    {
        $this->validate();

        Customer::updateOrCreate(['id' => $this->customerId], [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'address' => $this->address,
        ]);

        session()->flash('message', 'Customer ' . ($this->customerId ? 'updated' : 'created') . ' successfully!');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $this->customerId = $customer->id;
        $this->name = $customer->name;
        $this->mobile = $customer->mobile;
        $this->address = $customer->address;
    }

    public function delete($id)
    {
        Customer::findOrFail($id)->delete();
        session()->flash('message', 'Customer deleted successfully!');
    }
}
