@extends('filament::page')

@section('title', 'Wholesaler Application Details')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Applicant Information</h2>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
            <div>
                <dt class="font-semibold">Full Name</dt>
                <dd>{{ $record->name }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Email</dt>
                <dd>{{ $record->email }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Application Date</dt>
                <dd>{{ $record->created_at->format('M j, Y g:i A') }}</dd>
            </div>
        </dl>

        <h2 class="text-2xl font-bold mt-8 mb-4">Company Information</h2>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
            <div>
                <dt class="font-semibold">Company Name</dt>
                <dd>{{ $details['company_name'] ?? 'N/A' }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Registration Number</dt>
                <dd>{{ $details['company_registration'] ?? 'N/A' }}</dd>
            </div>
            <div class="md:col-span-2">
                <dt class="font-semibold">Company Address</dt>
                <dd>{{ $details['company_address'] ?? 'N/A' }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Company Phone</dt>
                <dd>{{ $details['company_phone'] ?? 'N/A' }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Company Website</dt>
                <dd>{{ $details['company_website'] ?? 'N/A' }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Business Type</dt>
                <dd>{{ ucfirst(str_replace('_', ' ', $details['business_type'] ?? 'N/A')) }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Industry</dt>
                <dd>{{ ucfirst(str_replace('_', ' ', $details['industry'] ?? 'N/A')) }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Expected Monthly Order Volume</dt>
                <dd>{{ ucfirst($details['expected_volume'] ?? 'N/A') }}</dd>
            </div>
        </dl>
    </div>
</div>
@endsection 