<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Report Data') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <!-- Filter Form -->
        <form id="filter-form" method="GET" action="{{ route('reports.index') }}"
            class="flex justify-between items-center gap-3 mb-4">
            <!-- Filter options (dropdowns) -->
            <div class="flex gap-3">
                <select name="data_type" id="data_type" class="form-select w-auto">
                    <option value="monthly" {{ request('data_type') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                    <option value="yearly" {{ request('data_type') == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                </select>
                <select name="month" id="month" class="form-select w-auto"
                    {{ request('data_type') == 'yearly' ? 'disabled' : '' }}>
                    @foreach (range(1, 12) as $month)
                        <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                        </option>
                    @endforeach
                </select>
                <select name="year" id="year" class="form-select w-auto">
                    @foreach (range(date('Y'), date('Y') - 10) as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Download Button (aligned to the right) -->
            <div class="ml-auto">
                <a href="{{ route('reports.export', ['data_type' => request('data_type'), 'month' => request('month'), 'year' => request('year')]) }}"
                    class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                    {{ __('Download Excel') }}
                </a>

            </div>
        </form>

        <!-- Data Table -->
        <div class="overflow-x-auto">
            <table class="table-auto min-w-full text-left text-sm">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2">{{ __('Customer Name') }}</th>
                        <th class="px-4 py-2">{{ __('Part Type') }}</th>
                        <th class="px-4 py-2">{{ __('Color') }}</th>
                        <th class="px-4 py-2">{{ __('Item') }}</th>
                        <th class="px-4 py-2">{{ __('Total OK') }}</th>
                        <th class="px-4 py-2">{{ __('Total OK Buffing') }}</th>
                        <th class="px-4 py-2">{{ __('Total Out Total') }}</th>
                        <th class="px-4 py-2">{{ __('Total Repaint') }}</th>
                        <th class="px-4 py-2">{{ __('Total All') }}</th>
                        <th class="px-4 py-2">{{ __('RSP') }}</th>
                        <th class="px-4 py-2">{{ __('FSP') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td class="px-4 py-2">{{ $result->Customer_Name }}</td>
                            <td class="px-4 py-2">{{ $result->Part_Type }}</td>
                            <td class="px-4 py-2">{{ $result->Color }}</td>
                            <td class="px-4 py-2">{{ $result->Item }}</td>
                            <td class="px-4 py-2">{{ $result->Total_OK_Count }}</td>
                            <td class="px-4 py-2">{{ $result->Total_OK_Buffing_Count }}</td>
                            <td class="px-4 py-2">{{ $result->Total_Count_OutTotal }}</td>
                            <td class="px-4 py-2">{{ $result->Total_Count_Repaint }}</td>
                            <td class="px-4 py-2">{{ $result->TotalAll }}</td>
                            <td class="px-4 py-2">{{ number_format($result->rsp, 2) }}%</td>
                            <td class="px-4 py-2">{{ number_format($result->fsp, 2) }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Toggle month dropdown based on the selected data type
        document.getElementById('data_type').addEventListener('change', function() {
            const dataType = this.value;
            const monthSelect = document.getElementById('month');

            if (dataType === 'yearly') {
                monthSelect.disabled = true;
                monthSelect.value = ''; // Clear the month selection
            } else {
                monthSelect.disabled = false;
            }

            // Trigger the form submit
            document.getElementById('filter-form').submit();
        });

        // Automatically fetch and update data when the year or month changes
        document.getElementById('month').addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });

        document.getElementById('year').addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });
    </script>
</x-app-layout>
