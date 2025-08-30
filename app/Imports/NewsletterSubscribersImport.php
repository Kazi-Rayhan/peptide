<?php
namespace App\Imports;

use App\Models\NewsletterSubscription;
use Maatwebsite\Excel\Concerns\ToModel;

class NewsletterSubscribersImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Expected columns: name, email, contact_number
        return NewsletterSubscription::updateOrCreate(
            ['email' => $row['email'] ?? null], // upsert by email
            [
                'name'           => $row['name'] ?? null,
                'contact_number' => $row['contact_number'] ?? null,
            ]
        );
    }
    public function rules(): array
    {
        return [
            '*.email'          => ['required', 'email'],
            '*.name'           => ['nullable', 'string', 'max:255'],
            '*.contact_number' => ['nullable', 'string', 'max:32'],
        ];
    }
}
