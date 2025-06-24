<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Report Detail Defact') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <!-- Filter Form -->
        <form id="filter-form" method="GET" action="{{ route('defact.report') }}"
            class="flex justify-between items-center gap-3 mb-4">
            <!-- Filter options (date inputs) -->
            <div class="flex gap-3">
                <span>From:</span>
                <input type="date" name="date_from" id="date_from" class="form-input w-auto text-black dark:text-black" value="{{ request('date_from') ?? date('Y-m-01') }}">
                <span>To:</span>
                <input type="date" name="date_to" id="date_to" class="form-input w-auto text-black dark:text-black" value="{{ request('date_to') ?? date('Y-m-t') }}">
            </div>

            <!-- Download Button (aligned to the right) -->
            <div class="ml-auto">
                <a href="{{ route('reports.defact', ['date_from' => request('date_from'), 'date_to' => request('date_to')]) }}"
                    class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                    {{ __('Download Excel') }}
                </a>

            </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const filterForm = document.getElementById('filter-form');
                const dateFromInput = document.getElementById('date_from');
                const dateToInput = document.getElementById('date_to');

                // Set default values if not present in request
                if (!dateFromInput.value) {
                    dateFromInput.value = '{{ date('Y-m-01') }}';
                }
                if (!dateToInput.value) {
                    dateToInput.value = '{{ date('Y-m-t') }}';
                }

                // Add event listeners to submit form on date change
                dateFromInput.addEventListener('change', function() {
                    filterForm.submit();
                });

                dateToInput.addEventListener('change', function() {
                    filterForm.submit();
                });
            });
        </script>

        <!-- Data Table -->
        <div class="overflow-x-auto">
    <div class="bg-blue-50 p-3 mb-2 border-b border-blue-200">
        <h3 class="text-lg font-semibold text-blue-800">RSP</h3>
       
    </div>

    @if(count($results) > 0)
        <table class="w-full border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    @foreach(array_keys((array) $results[0]) as $col)
                        <th class="px-4 py-2 border">
                            {{ ucwords(str_replace('_', ' ', preg_replace('/(BUFFING|REPAINT|TOTAL|OK BUFFING|OUT TOTAL|RSP)/i', '$0', $col))) }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($results as $row)
                    <tr class="hover:bg-gray-50">
                        @foreach((array) $row as $val)
                            <td class="px-4 py-2 border">{{ $val ?? 0 }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center p-4 text-gray-500">No data available</div>
    @endif
</div>

        <div class="overflow-x-auto">
    <div class="bg-blue-50 p-3 mb-2 border-b border-blue-200">
        <h3 class="text-lg font-semibold text-blue-800">FSP</h3>
       
    </div>

    @if(count($fsp) > 0)
        <table class="w-full border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    @foreach(array_keys((array) $fsp[0]) as $col)
                        <th class="px-4 py-2 border">
                            {{ ucwords(str_replace(['_', 'BUFFING:', 'REPAINT:'], [' ', 'Buffing: ', 'Repaint: '], str_replace(['BUFFING_', 'REPAINT_', 'TOTAL_', 'OK_BUFFING', 'OUT_TOTAL'], ['Buffing: ', 'Repaint: ', 'Total ', 'OK Buffing', 'NG'], strtoupper($col)))) }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($fsp as $row)
                    <tr class="hover:bg-gray-50">
                        @foreach ((array) $row as $value)
                            <td class="px-4 py-2 border">{{ $value ?? 0 }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center p-4 text-gray-500">No data available</div>
    @endif
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
