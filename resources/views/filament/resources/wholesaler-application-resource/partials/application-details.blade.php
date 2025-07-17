<div class="space-y-6">
    <!-- Applicant Information -->
    <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-gray-900">Applicant Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-500">Name</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Application Date</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M j, Y g:i A') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Status</dt>
                <dd class="mt-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Pending Approval
                    </span>
                </dd>
            </div>
        </div>
    </div>

    <!-- Company Information -->
    <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-gray-900">Company Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-50">Company Name</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $details['company_name'] ?? 'N/A' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Company Registration Number</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $details['company_registration'] ?? 'N/A' }}</dd>
            </div>
            <div class="md:col-span-2">
                <dt class="text-sm font-medium text-gray-500">Company Address</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $details['company_address'] ?? 'N/A' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Company Phone</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $details['company_phone'] ?? 'N/A' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Company Website</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    @if(isset($details['company_website']) && $details['company_website'])
                        <a href="{{ $details['company_website'] }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                            {{ $details['company_website'] }}
                        </a>
                    @else
                        N/A
                    @endif
                </dd>
            </div>
        </div>
    </div>

    <!-- Business Details -->
    <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-gray-900">Business Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-500">Business Type</dt>
                <dd class="mt-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ ucfirst(str_replace('_', ' ', $details['business_type'] ?? 'N/A')) }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Industry</dt>
                <dd class="mt-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        {{ ucfirst(str_replace('_', ' ', $details['industry'] ?? 'N/A')) }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Expected Monthly Order Volume</dt>
                <dd class="mt-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        {{ ucfirst($details['expected_volume'] ?? 'N/A') }}
                    </span>
                </dd>
            </div>
        </div>
    </div>

    <!-- Volume Details -->
    <div class="bg-blue-50 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-blue-900 mb-2">Order Volume Breakdown</h3>
        <div class="text-sm text-blue-800">
            @switch($details['expected_volume'] ?? 'N/A')
                @case('small')
                    <p><strong>Small (1-10):</strong> Suitable for individual researchers or small laboratories.</p>
                    @break
                @case('medium')
                    <p><strong>Medium (11-50s):</strong> Ideal for research institutes or medium-sized organizations.</p>
                    @break
                @case('large')
                    <p><strong>Large (51-100):</strong> Perfect for hospitals, universities, or large research facilities.</p>
                    @break
                @case('enterprise')
                    <p><strong>Enterprise (100+ units):</strong> Designed for pharmaceutical companies, large distributors, or major research organizations.</p>
                    @break
                @default
                    <p>Volume information not specified.</p>
            @endswitch
        </div>
    </div>
</div> 