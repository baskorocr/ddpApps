<x-guest-layout>
<style>
    .signal {
        display: inline-block;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        margin-right: 5px;
    }
    .green { background-color: green; }
    .yellow { background-color: yellow; }
    .orange { background-color: orange; }
    .red { background-color: red; }
</style>
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
                        <label for="part_type" class="block font-medium">Part Type</label>
                        <select id="part_type" class="form-select w-full mt-2  text-black  dark:text-black"
                            onchange="fetchPartNames()">
                            <option value="">Select Part Type</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->type }}</option>
                            @endforeach
                        </select>

                        <label for="part_name" class="block font-medium mt-4">Part Name</label>
                        <select id="part_name" class="form-select w-full mt-2 text-black  dark:text-black">
                            <option value="">Select Part Name</option>
                        </select>

                        <label for="color" class="block font-medium mt-4">Color</label>
                        <select id="color" class="form-select w-full mt-2 text-black  dark:text-black">
                            <option value="">Select Color</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->color }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Center Column -->
                    <div>
                        <label for="inspector_name" class="block font-medium">Inspector Name</label>
                        <input id="inspector_name" type="text" value="{{ auth()->user()->name }}"
                            class="form-input w-full mt-2 text-black  dark:text-black" readonly>

                        <label for="shift" class="block font-medium mt-4">Shift</label>
                        <select id="shift" class="form-select w-full mt-2 text-black  dark:text-black">
                            <option value="">Select shift</option>
                            @foreach ($shifts as $shift)
                                <option value="{{ $shift->id }}">{{ $shift->shift }}</option>
                            @endforeach
                        </select>
                        <label for="line" class="block font-medium mt-4">Line</label>
                        <select id="line" class="form-select w-full mt-2 text-black  dark:text-black">
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
                            <li id="counting">Counting: <span id="count-value">0</span> </li>
                            <li id="ok-item">OK: 0 (0%)</li>
                            <li id="buffing-item">Buffing: 0 (0%)</li>
                            <li id="repaint-item">Repaint: 0 (0%)</li>
                            <li id="ot-item">OT: 0 (0%)</li>
                            <li id="signal">
                                <span class="signal"></span> Signal Strength: <span id="signal-strength">-</span>
                            </li>
                        </ul>
                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
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
                    <h2 class="text-lg font-semibold mb-4">Fixed Product</h2>

                    <form class="defact-form">
                        @csrf
                        <input type="hidden" name="idStatus" value="1">
                        <input type="hidden" name="nameTypeDefact" value="ok">
                        <button id="count-button" class="mb-4 bg-green-500 text-white text-center p-8 text-4xl font-bold rounded w-full">
                            OK
                        </button>
                    </form>
                    <h2 class="text-lg font-semibold mb-4">Buffing</h2>
                    <div class="grid grid-cols-2 md:grid-cols-2 gap-2">


                        @foreach ($group[0]->itemDefacts as $index => $defact)
                            <form class="defact-form">
                                @csrf
                                <input type="hidden" name="idItemDefact" value="{{ $idItemDefactsArray[$index] }}">

                                <input type="hidden" name="nameTypeDefact" value="{{ $group[0]->nameType }}">
                                <input type="hidden" name="itemDefact" value="{{ $defact }}">
                                <x-button id="count-button" type="submit"
                                    class="bg-blue-500 text-white hover:bg-blue-600 py-5 w-full text-base font-semibold">
                                    {{ $defact }}
                                </x-button>
                            </form>
                        @endforeach


                    </div>
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
                                <x-button id="count-button" type="submit"
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
                                <x-button id="count-button" type="submit"
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
            const partTypeId = document.getElementById('part_type').value;
            const partNameSelect = document.getElementById('part_name');
            const colorSelect = document.getElementById('color');
            const buttonCount = document.getElementById('count-button');

            // Clear previous options
            partNameSelect.innerHTML = '<option value="">Select Part Name</option>';

            const url = `{{ route('part-names', ':partTypeId') }}`.replace(':partTypeId', partTypeId);
            if (partTypeId) {
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id; // Assuming you have an 'id' for each item
                            option.textContent = item.item; // Adjust based on your actual item structure
                            partNameSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching part names:', error));
        }

        // Add event listeners to reset count when part name or color changes
        partNameSelect.addEventListener('change', function() {
            const countValueEl = document.getElementById('count-value');
            countValueEl.textContent = 0;
        });

        colorSelect.addEventListener('change', function() {
            const countValueEl = document.getElementById('count-value');
            countValueEl.textContent = 0;
        });
    }
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
                    url: 'storeReqQ1', // Route to your controller
                    method: 'POST',
                    data: combinedData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: "Insert Data Successfully",
                            timer: 300, // Auto close after 3 seconds
                            showConfirmButton: false // Hide the confirm button
                        });

                        const countValueEl = document.getElementById('count-value');
    // Ambil nilai sekarang, ubah ke number, tambah 1
                        let currentCount = parseInt(countValueEl.textContent) || 0;
                        currentCount++;
                        // Update teksnya
                        countValueEl.textContent = currentCount;

                        
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
                            timer: 500, // Auto close after 3 seconds
                            showConfirmButton: false // Hide the confirm button
                        });
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            function updateCounts() {
                const appUrl = "{{ env('APP.URL') }}";
                const appPort = "{{ config('APP.ports') }}";
                fetch(`${appUrl}/count1`)
                    .then(response => response.json())
                    .then(data => {
                       
                        document.getElementById("ok-item").textContent =
                            `OK: ${data.ok}`;
                        document.getElementById("buffing-item").textContent =
                            `Buffing: ${data.BUFFING}`;
                        document.getElementById("repaint-item").textContent =
                            `Repaint: ${data.REPAINT}`;
                        document.getElementById("ot-item").textContent =
                            `OT: ${data.OUT_TOTAL}`;
                            const signalStrength = data.Signal;
                document.getElementById("signal-strength").textContent = signalStrength.toFixed(2);

                let signal = document.querySelector(".signal");
                signal.classList.remove("green", "yellow", "orange", "red");

                if (signalStrength >= 0.8) {
                    signal.classList.add("green");
                } else if (signalStrength >= 0.5) {
                    signal.classList.add("yellow");
                } else if (signalStrength >= 0.3) {
                    signal.classList.add("orange");
                } else {
                    signal.classList.add("red");
                }
                    })
                    .catch(error => {
                        let signal = document.querySelector(".signal");
    console.error("Error fetching count data:", error);
    document.getElementById("signal-strength").textContent = "disconected";
    signal.classList.add("red");
});
            }

            // Fetch data initially and set up an interval to refresh periodically
            updateCounts();
            setInterval(updateCounts, 5000); // Refresh every 5 seconds
        });
    </script>



</x-guest-layout>
