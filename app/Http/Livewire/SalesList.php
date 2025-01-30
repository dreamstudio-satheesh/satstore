<?php

namespace App\Http\Livewire;

use App\Models\Bill;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class SalesList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $bills = Bill::with('customer', 'user')
            ->whereHas('customer', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhere('id', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.sales-list', compact('bills'));
    }

    #[On('delete-bill')]
    public function deleteBill($billId)
    {
        $bill = Bill::find($billId);

        if ($bill) {
            $bill->delete();
            session()->flash('message', 'Bill deleted successfully.');
        }
    }

}
