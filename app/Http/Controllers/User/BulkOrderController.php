<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\ProductListExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\BulkOrderService;
use Illuminate\Support\Facades\Storage;

class BulkOrderController extends Controller
{
    public function downloadProductListExcel()
    {
        return Excel::download(new ProductListExport, 'product_list.xlsx');
    }

    public function downloadExampleCsv()
    {
        return response()->download(storage_path('app/example_bulk_order.csv'));
    }

    public function parseCsv(Request $request, BulkOrderService $service)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);
        $result = $service->parseCsv($request->file('csv_file'));
        return response()->json($result);
    }

    public function submit(Request $request, BulkOrderService $service)
    {
        $request->validate([
            'products' => 'required|array',
            'billing' => 'required|array',
            'shipping' => 'required|array',
            'payment' => 'required|string',
        ]);
        $order = $service->createBulkOrder(
            auth()->user(),
            $request->input('products'),
            $request->input('billing'),
            $request->input('shipping'),
            $request->input('payment')
        );
        return redirect()->route('user.orders.show', $order->id)
            ->with('success', 'Bulk order placed successfully!');
    }
} 