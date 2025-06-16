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
        <table class="w-full border-collapse">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 border">Customer</th>
            <th class="px-4 py-2 border">Part Type</th>
            <th class="px-4 py-2 border">Color</th>
            <th class="px-4 py-2 border">Part</th>
            <th class="px-4 py-2 border">Total</th>
            <th class="px-4 py-2 border">OK</th>
            <th class="px-4 py-2 border">OK Buffing</th>
            <th class="px-4 py-2 border">Out Total</th>
            
            <!-- Dynamic Buffing Defect Columns -->
            <th class="px-4 py-2 border">Buffing: Bintik Kotor</th>
            <th class="px-4 py-2 border">Buffing: Absorb</th>
            <th class="px-4 py-2 border">Buffing: Others</th>
            <th class="px-4 py-2 border">Buffing: Scratch</th>
            <th class="px-4 py-2 border">Buffing: Sanding Mark</th>
            <th class="px-4 py-2 border">Buffing: Orange Peel</th>
            <th class="px-4 py-2 border">Buffing: Dust Spray</th>
            
            <!-- Dynamic Repaint Defect Columns -->
            <th class="px-4 py-2 border">Repaint: Unpainting</th>
            <th class="px-4 py-2 border">Repaint: Scratch</th>
            <th class="px-4 py-2 border">Repaint: Meler</th>
            <th class="px-4 py-2 border">Repaint: Others</th>
            <th class="px-4 py-2 border">Repaint: Orange Peel</th>
            <th class="px-4 py-2 border">Repaint: Cratter Oil</th>
            <th class="px-4 py-2 border">Repaint: Bintik Kotor</th>
            <th class="px-4 py-2 border">Repaint: Absorb</th>
            <th class="px-4 py-2 border">Repaint: Tipis</th>
            <th class="px-4 py-2 border">Repaint: Dust Spray</th>
            <th class="px-4 py-2 border">Repaint: Peel Off</th>
            <th class="px-4 py-2 border">Repaint: Popping</th>
            
            <th class="px-4 py-2 border">RSP (%)</th>
            <th class="px-4 py-2 border">FSP (%)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($results as $result)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border">{{ $result->Customer_Name }}</td>
                <td class="px-4 py-2 border">{{ $result->Part_Type }}</td>
                <td class="px-4 py-2 border">{{ $result->Color }}</td>
                <td class="px-4 py-2 border">{{ $result->Part }}</td>
                <td class="px-4 py-2 border">{{ $result->Total ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->OK ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->OK_BUFFING ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->OUT_TOTAL ?? 0 }}</td>
                
                <!-- Buffing Defects -->
                <td class="px-4 py-2 border">{{ $result->BUFFING_BINTIK_KOTOR ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->BUFFING_ABSORB ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->BUFFING_OTHERS ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->BUFFING_SCRATCH ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->BUFFING_SANDING_MARK ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->BUFFING_ORANGE_PEEL ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->BUFFING_DUST_SPRAY ?? 0 }}</td>
                
                <!-- Repaint Defects -->
                <td class="px-4 py-2 border">{{ $result->REPAINT_UNPAINTING ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->REPAINT_SCRATCH ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->REPAINT_MELER ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->REPAINT_OTHERS ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->REPAINT_ORANGE_PEEL ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->REPAINT_CRATTER_OIL ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->REPAINT_BINTIK_KOTOR ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->REPAINT_ABSORB ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->REPAINT_TIPIS ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->REPAINT_DUST_SPRAY ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->REPAINT_PEEL_OFF ?? 0 }}</td>
                <td class="px-4 py-2 border">{{ $result->REPAINT_POPPING ?? 0 }}</td>
                
                <td class="px-4 py-2 border">{{ number_format($result->RSP, 2) }}%</td>
                <td class="px-4 py-2 border">{{ number_format($result->FSP, 2) }}%</td>
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
