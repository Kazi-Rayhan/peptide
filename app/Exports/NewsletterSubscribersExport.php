<?php
namespace App\Exports;

use App\Models\NewsletterSubscription;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NewsletterSubscribersExport implements FromArray, WithHeadings
{
    protected $ids;

    public function __construct($ids = null)
    {
        $this->ids = $ids;
    }

    public function array(): array
    {
        $query = NewsletterSubscription::query();

        if ($this->ids && count($this->ids) > 0) {
            $query->whereIn('id', $this->ids);
        }

        $subscriptions = $query->get();

        $rows = [];
        foreach ($subscriptions as $sub) {
            $rows[] = [
                'name'           => $sub->name,
                'email'          => $sub->email,
                'contact_number' => $sub->contact_number,
                'subscribed_at'  => $sub->created_at->format('Y-m-d H:i:s'),
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Contact Number',
            'Subscribed At',
        ];
    }
}
