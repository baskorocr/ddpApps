<x-guest-layout>
    <x-slot name="header">


    </x-slot>

    <!-- Main Content -->
    <div class="p-4 md:p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div x-data="{ open: false }" id="data" class="p-4 md:p-6 bg-white rounded-md shadow-md dark:bg-dark-eval-1 ">
            <!-- Toggle Button -->
            <button @click="open = !open"
                class="text-lg font-semibold mb-4 cursor-pointer w-full flex justify-between items-center p-3 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                <span>Klik untuk membuka pilihan</span>
                <i :class="open ? 'rotate-180' : ''" class="fas fa-chevron-down transition-transform duration-200"></i>
            </button>

            <!-- Collapsible Content -->
            <div x-show="open" x-transition>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8">
                    <!-- Left Column -->
                    <div>
                        <label for="part_name" class="block font-medium mt-4">Part Name</label>
                        <select id="part_name" class="form-select w-full mt-2 text-black  dark:text-black">
                            <option value="">Select Part Name</option>
                        </select>

                        <label for="color" class="block font-medium mt-4">Color</label>
                        <select id="color" class="form-select w-full mt-2 text-black dark:text-black">
                            <option value="">Select Color</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->color }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Center Column -->
                    <div>
                        <label for="inspector_name" class="block font-medium mt-4">Inspector Name</label>
                        <input id="inspector_name" type="text" value="{{ auth()->user()->name }}"
                            class="form-input w-full mt-2 text-black dark:text-black" readonly>

                        <label for="shift" class="block font-medium mt-4">Shift</label>
                        <select id="shift" class="form-select w-full mt-2 text-black dark:text-black">
                            <option value="">Select shift</option>
                            @foreach ($shifts as $shift)
                                <option value="{{ $shift->id }}">{{ $shift->shift }}</option>
                            @endforeach
                        </select>

                        <label for="line" class="block font-medium mt-4">Line</label>
                        <select id="line" class="form-select w-full mt-2 text-black dark:text-black">
                            <option value="">Select Line</option>
                            @foreach ($lines as $line)
                                <option value="{{ $line->id }}">{{ $line->nameLine }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <h2 class="text-lg font-semibold mb-4">Data Summary</h2>
                        <ul class="list-disc list-inside space-y-1">
                            <li id="ok-item">OK: 0 (0%)</li>
                            <li id="buffing-item">Buffing: 0 (0%)</li>
                            <li id="repaint-item">Repaint: 0 (0%)</li>
                            <li id="ot-item">OT: 0 (0%)</li>
                        </ul>
                        <form method="POST" action="{{ route('logout') }}" class="mt-6">
                            @csrf
                            <button type="submit"
                                class="bg-red-500 w-200 text-white text-center py-2 px-4 rounded font-medium hover:bg-red-600">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>


        <div class="p-4 md:p-6 bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-1">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8">
                <!-- Buffing Section -->
                <div>
                    <h2 class="text-lg font-semibold mb-4">Fixed Buffing</h2>

                    <form class="defact-form">
                        @csrf

                        <input type="hidden" name="nameTypeDefact" value="ok">
                        <button class="mb-4 bg-green-500 text-white text-center p-8 text-4xl font-bold rounded  w-full">
                            OK
                        </button>
                    </form>

                </div>

                <!-- Repaint Section -->
                <div>
                    <h2 class="text-lg font-semibold mb-4">Repaint</h2>
                    <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
                        @foreach ($group[1]->itemDefacts as $index => $defact)
                            <form class="defact-form">
                                @csrf
                                <input type="hidden" name="idItemDefact"
                                    value="{{ $idItemDefactsArrayGroup1[$index] }}">
                                <input type="hidden" name="nameTypeDefact" value="{{ $group[1]->nameType }}">
                                <input type="hidden" name="itemDefact" value="{{ $defact }}">
                                <x-button type="submit"
                                    class="bg-yellow-500 text-white hover:bg-yellow-600 py-5 w-full text-base font-semibold">
                                    {{ $defact }}
                                </x-button>
                            </form>
                        @endforeach
                    </div>
                </div>

                <!-- Out Total Section -->
                <div>
                    <h2 class="text-lg font-semibold mb-4">Out Total</h2>
                    <div class="grid grid-cols-2 md:grid-cols-2 gap-2">

                        @foreach ($group[2]->itemDefacts as $index => $defact)
                            <form class="defact-form">
                                @csrf
                                <input type="hidden" name="idItemDefact"
                                    value="{{ $idItemDefactsArrayGroup2[$index] }}">

                                <input type="hidden" name="nameTypeDefact" value="{{ $group[2]->nameType }}">
                                <input type="hidden" name="itemDefact" value="{{ $defact }}">
                                <x-button type="submit"
                                    class="bg-red-500 text-white hover:bg-red-600 py-5 w-full text-base font-semibold">
                                    {{ $defact }}
                                </x-button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function fetchPartNames() {
            const partNameSelect = document.getElementById('part_name');
            const url = `{{ route('getpart2') }}`; // Ganti dengan route Laravel yang sesuai

            // Clear previous options
            partNameSelect.innerHTML = '<option value="">Select Part Name</option>';

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id; // Assuming you have an 'id' for each item
                        option.textContent = item.item; // Adjust based on your actual item structure
                        partNameSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching part names:', error));
        }

        // Fetch part names initially and set up an interval to refresh periodically
        fetchPartNames();
    </script>

    <script>
        $(document).ready(function() {
            $('.defact-form').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Gather data from the form
                const formData = $(this).serializeArray();

                // Add additional data
                const additionalData = {

                    idPart: $('#part_name').val(),
                    idColor: $('#color').val(),
                    line: $('#line').val(), // Added line data
                    idShift: $('#shift').val(), // Added shift data
                    inspector_npk: {{ auth()->user()->npk }},
                    date: $('#date').val(),

                };

                // Combine form data with additional data
                const combinedData = {};

                // Append serialized form data
                formData.forEach(item => {
                    combinedData[item.name] = item.value;
                });

                // Append additional data
                Object.keys(additionalData).forEach(key => {
                    combinedData[key] = additionalData[key];
                });

                console.log('Data that will be sent:', combinedData);

                // AJAX request
                $.ajax({
                    url: 'storeReqQ2', // Route to your controller
                    method: 'POST',
                    data: combinedData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: "Insert Data Successfully",
                            timer: 3000, // Auto close after 3 seconds
                            showConfirmButton: false // Hide the confirm button
                        });
                        fetchPartNames();
                        // Optionally, you can reset the form or perform other actions
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = 'Errors occurred:\n';
                        for (const key in errors) {
                            errorMessage += errors[key].join('\n') + '\n';
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Input Failed!',
                            text: "Make Sure All Fields Are Filled",
                            timer: 3000, // Auto close after 3 seconds
                            showConfirmButton: false // Hide the confirm button
                        });
                        fetchPartNames();
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            function updateCounts() {
                const appUrl = "{{ env('APP.URL') }}";
                fetch(`${appUrl}/count`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("ok-item").textContent =
                            `OK: ${data.totalTypeOK} (RSP: ${Math.round(data.rsp)}%)`;
                        document.getElementById("buffing-item").textContent =
                            `Buffing OK: ${data.totalTypeOkBuffing} (FSP: ${Math.round(data.fsp)}%)`;
                        document.getElementById("repaint-item").textContent =
                            `Repaint: ${data.totalTypeRepaint} (${Math.round(data.percentRepaint)}%)`;
                        document.getElementById("ot-item").textContent =
                            `OT: ${data.totalTypeOutTotal} (${Math.round(data.percentTypeOutTotal)}%)`;
                    })
                    .catch(error => console.error("Error fetching count data:", error));
            }

            // Fetch data initially and set up an interval to refresh periodically
            updateCounts();
            setInterval(updateCounts, 5000); // Refresh every 5 seconds
        });
    </script>




</x-guest-layout>
