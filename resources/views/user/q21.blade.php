<x-app-layout>
    <x-slot name="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </x-slot>

    <!-- Main Content -->
    <div class="p-4 md:p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="p-4 md:p-6 bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4 md:gap-8">
                <!-- Left Column -->

                <div class="flex flex-col items-center">
                    <label for="line" class="block font-medium">Line</label>
                    <select id="line" class="form-select w-full mt-2">
                        <option value="">Select Line</option>
                        @foreach ($lines as $line)
                            <option value="{{ $line->id }}">{{ $line->nameLine }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="flex flex-col items-center">


                    <label for="part_type" class="block font-medium">Part Type</label>
                    <select id="part_type" class="form-select w-full mt-2" onchange="fetchPartNames()">
                        <option value="">Select Part Type</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->type }}</option>
                        @endforeach
                    </select>


                </div>
                <div class="flex flex-col items-center">
                    <label for="part_name" class="block font-medium ">Part Name</label>
                    <select id="part_name" class="form-select w-full mt-2">
                        <option value="">Select Part Name</option>
                    </select>
                </div>
                <div class="flex flex-col items-center">


                    <label for="colors" class="block font-medium">Colors</label>
                    <select id="colors" class="form-select w-full mt-2">
                        <option value="">Select Colors</option>
                        @foreach ($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->color }}</option>
                        @endforeach
                    </select>


                </div>
                <div class="flex flex-col items-center">
                    <label for="typeDefact" class="block font-medium">Type Defact</label>
                    <select id="typeDefact" class="form-select w-full mt-2">
                        <option value="">Select Type Defact</option>
                        @foreach ($typeDefacts as $typeDefact)
                            <option value="{{ $typeDefact->id }}">{{ $typeDefact->type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col items-center">
                    <label for="itemTypeDefact" class="block font-medium">Item Defact</label>
                    <select id="itemTypeDefact" class="form-select w-full mt-2">
                        <option value="">Select Item Defact</option>
                    </select>
                </div>







                <!-- Center Column -->

            </div>
        </div>
        <div id="data-container" data-group="{{ json_encode($group) }}">

        </div>

        {{-- <div x-data="{ open: false }" id="data"
            class="p-4 md:p-6 bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-6">
            <!-- Toggle Button -->
            <button @click="open = !open"
                class="text-lg font-semibold mb-4 cursor-pointer w-full flex justify-between items-center p-3 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                <span>Toggle Content</span>
                <i :class="open ? 'rotate-180' : ''" class="fas fa-chevron-down transition-transform duration-200"></i>
            </button>

            <!-- Collapsible Content -->
            <div x-show="open" x-transition>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8">
                    <!-- Buffing Section -->
                    <div>
                        <h2 class="text-lg font-semibold mb-4">Fixed Product</h2>
                        <form class="defact-form">
                            @csrf
                            <input type="hidden" name="idTypeDefact" value="4">
                            <input type="hidden" name="itemDefact" value="ok">
                            <button
                                class="mb-4 bg-green-500 text-white text-center p-8 text-4xl font-bold rounded mt-4 w-full">
                                OK
                            </button>
                        </form>

                        <h2 class="text-lg font-semibold mb-4">Buffing</h2>
                        <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
                            @foreach ($group[0]->itemDefacts as $defact)
                                <form class="defact-form">
                                    @csrf
                                    <input type="hidden" name="idTypeDefact" value="{{ $group[0]->idTypeDefact }}">
                                    <input type="hidden" name="itemDefact" value="{{ $defact }}">
                                    <x-button type="submit"
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
                            @foreach ($group[1]->itemDefacts as $defact)
                                <form class="defact-form">
                                    @csrf
                                    <input type="hidden" name="idTypeDefact" value="{{ $group[1]->idTypeDefact }}">
                                    <input type="hidden" name="itemDefact" value="{{ $defact }}">
                                    <x-button
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
                            @foreach ($group[2]->itemDefacts as $defact)
                                <form class="defact-form">
                                    @csrf
                                    <input type="hidden" name="idTypeDefact" value="{{ $group[2]->idTypeDefact }}">
                                    <input type="hidden" name="itemDefact" value="{{ $defact }}">
                                    <x-button
                                        class="bg-red-500 text-white hover:bg-red-600 py-5 w-full text-base font-semibold">
                                        {{ $defact }}
                                    </x-button>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div id="data">

        </div>

    </div>

    <script>
        function fetchPartNames() {
            const partTypeId = document.getElementById('part_type').value;
            const partNameSelect = document.getElementById('part_name');
            console.log(partTypeId, partNameSelect);
            // Clear previous options
            partNameSelect.innerHTML = '<option value="">Select Part Name</option>';

            if (partTypeId) {
                fetch(`/api/part-names/${partTypeId}`)
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
        }
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('submit', '.defact-form', function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Gather data from the form
                const formData = $(this).serializeArray();

                // Add additional data
                const additionalData = {
                    part_type: $('#part_type').val(),
                    part_name: $('#part_name').val(),
                    color: $('#color').val(),
                    line: $('#line').val(), // Added line data

                    inspector_name: {{ auth()->user()->npk }},
                    date: $('#date').val(),
                    operator: $('#operator').val(),
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
                alert(combinedData);

                // AJAX request
                $.ajax({
                    url: 'storeReqQ2', // Route to your controller
                    method: 'POST',
                    data: combinedData,
                    success: function(response) {
                        alert('Data submitted successfully: ' + response.message);
                        // Optionally, you can reset the form or perform other actions
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = 'Errors occurred:\n';
                        for (const key in errors) {
                            errorMessage += errors[key].join('\n') + '\n';
                        }
                        alert(errorMessage);
                    }
                });
            });
        });
    </script>
    <script>
        document.getElementById('typeDefact').addEventListener('change', function() {
            const typeId = this.value;
            const itemTypeDefact = document.getElementById('itemTypeDefact');

            console.log(itemTypeDefact);
            // Clear the itemDefact options
            itemTypeDefact.innerHTML = '<option value="">Select Item Defact</option>';

            if (typeId) {
                fetch(`/api/item-defacts/${typeId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(item => {
                            console.log(item);
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.itemDefact;
                            // Adjust 'name' to match the attribute you want to display
                            itemTypeDefact.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    </script>
    <script>
        document.getElementById('itemTypeDefact').addEventListener('change', function() {
            const idItemDefact = this.value;
            const itemTypeDefact = document.getElementById('data');

            const selectElement = document.getElementById('typeDefact');
            const selectedText = selectElement.options[selectElement.selectedIndex]
                .text; // Ambil teks dari opsi yang dipilih


            const idPart = document.getElementById('part_name').value;
            const idColor = document.getElementById('colors').value;
            const groupData = JSON.parse(document.getElementById('data-container').dataset.group);

            console.log('data group:', groupData);

            // Membuat objek combinedData
            const combinedData = {
                idItemDefact: idItemDefact,
                idcolor: idColor,
                idPart: idPart,
                keterangan_defact: selectedText,

            };

            console.log(combinedData);

            // Bersihkan konten sebelumnya
            itemTypeDefact.innerHTML = '';

            if (idItemDefact) {
                $.ajax({
                    url: 'getData', // Route ke controller Anda
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    data: combinedData,
                    success: function(response) {
                        let contentHtml = '';
                        const data = response.data;
                        console.log(response.data);

                        // Loop melalui setiap data item di respons
                        data.forEach((data, index) => {
                            contentHtml += `
                        <div x-data="{ open: false }" id="data-${index}" class="p-4 md:p-6 bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-6">
                            <button @click="open = !open" class="text-lg font-semibold mb-4 cursor-pointer w-full flex justify-between items-center p-3 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                <span> ${data.partName} (keterangan: ${data.keterangan_defact} - ${data.nameItemDefact} )</span>
                                <i :class="open ? 'rotate-180' : ''" class="fas fa-chevron-down transition-transform duration-200"></i>
                            </button>

                            <div x-show="open" x-transition>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8">
                                    <div>
                                       

                                        <h2 class="text-lg font-semibold mb-4">Fixed Buffing</h2>
                                        <form class="defact-form">
                                            @csrf
                                            <input type="hidden" name="idProses" value="${data.id}">
                                            <input type="hidden" name="idStatus" value="2">
                                            <input type="hidden" name="itemDefact" value="ok_buffing">
                                            <input type="hidden" name="idShift" value="${data.idShift}">
                                            <button class="mb-4 bg-green-500 text-white text-center p-8 text-4xl font-bold rounded mt-4 w-full">
                                                OK
                                            </button>
                                        </form>
                                    </div>

                                    <div>
                                        <h2 class="text-lg font-semibold mb-4">Repaint</h2>
                                        <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
                                             @foreach ($group[1]->itemDefacts as $index => $defact)
                                                <form class="defact-form">
                                                    @csrf
                                                    <input type="hidden" name="idItemDefact" value="{{ $idItemDefactsArrayGroup1[$index] }}">
                                                      <input type="hidden" name="idProses" value="${data.id}">
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

                                    <div>
                                        <h2 class="text-lg font-semibold mb-4">Out Total</h2>
                                        <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
                                             @foreach ($group[2]->itemDefacts as $index => $defact)
                                                <form class="defact-form">
                                                    @csrf
                                                    <input type="hidden" name="idItemDefact" value="{{ $idItemDefactsArrayGroup2[$index] }}">
                                                    <input type="hidden" name="idProses" value="${data.id}">
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
                    `;
                        });

                        // Menyisipkan konten HTML yang dihasilkan ke DOM
                        document.getElementById('data').innerHTML = contentHtml;
                    }
                });
            }
        });
    </script>





</x-app-layout>
