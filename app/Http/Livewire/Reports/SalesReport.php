<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;
use App\Models\Bill;
use Carbon\Carbon;

class SalesReport extends Component
{
    public $todayBills;

    public function mount()
    {
        // Fetch all bills created today
        $this->todayBills = Bill::with('customer')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.reports.sales-report');
    }
}
