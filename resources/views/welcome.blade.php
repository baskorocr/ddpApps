<x-guest-layout>
    <x-slot name="header">
        <!-- Empty header slot for customization if needed -->
    </x-slot>


    <!-- Main Content -->
    <div class="min-h-screen p-4 md:p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="mt-20 p-4 md:p-6 bg-white rounded-md shadow-md dark:bg-dark-eval-1 h-full">
            <div class="mt-6 grid grid-cols-1 md:grid-cols-1 gap-4 md:gap-8 h-full">

                <!-- Header Section with Logo, Text, and Date/Time -->
                <div class="flex justify-between mb-4">
                    <!-- Column 1: Logo -->
                    <div class="flex items-center text-center">
                        <img src="{{ asset('logo.png') }}" class="w-30 h-20" alt="Deskripsi Gambar">
                    </div>

                    <!-- Column 2: Text (Dharma Poliplash) -->
                    <div class="flex flex-col items-center text-center">

                        <span class="text-5xl font-semibold mt-3 text-black dark:text-yellow-500">QUALITY RATE
                            PAINTING LINE</span>
                    </div>

                    <!-- Column 3: Date/Time -->
                    <div class="text-center md:text-right">
                        <!-- Tanggal -->
                        <div id="current-date" class="text-center text-xl font-medium  text-black dark:text-yellow-500">
                            {{ \Carbon\Carbon::now()->format('Y-m-d') }}
                        </div>
                        <!-- Waktu -->
                        <div id="current-time" class="text-center text-xl font-medium ">
                            {{ \Carbon\Carbon::now()->format('H:i:s') }}
                        </div>
                    </div>
                </div>

                <div class="flex">
                    <div class="mt-4">
                        <label for="line-select" class="text-2xl font-semibold">Select Line:</label>
                        <select id="line-select"
                            class="w-full p-2 border rounded-md shadow-md dark:bg-dark-eval-1 text-2xl">
                            <option value="">-- Select a Line --</option>
                            @foreach ($lines as $line)
                                <option value="{{ $line->id }}">{{ $line->nameLine }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="h-full">
                    <!-- Table Container with horizontal scroll for responsiveness -->
                    <div class="overflow-x-auto h-full">
                        <table id="part-data-table" class="min-w-full table-auto border-collapse h-full">
                            <thead>
                                <tr>
                                    <th
                                        class="text-3xl border-b border-black px-4 py-2 text-black dark:border-yellow-500 dark:text-yellow-500">
                                        CUSTOMER</th>
                                    <th
                                        class="text-3xl border-b border-black px-4 py-2 text-black dark:border-yellow-500 dark:text-yellow-500">
                                        PART NAME</th>
                                    <th
                                        class="text-3xl border-b border-black px-4 py-2 text-black dark:border-yellow-500 dark:text-yellow-500">
                                        TYPE</th>
                                    <th
                                        class="text-3xl border-b border-black px-4 py-2 text-black dark:border-yellow-500 dark:text-yellow-500">
                                        COLOR</th>
                                    <th
                                        class="text-3xl border-b border-black px-4 py-2 text-black dark:border-yellow-500 dark:text-yellow-500">
                                        UNLOAD</th>
                                    <th hidden
                                        class="hidden border-b border-black px-4 py-2 text-black dark:border-yellow-500 dark:text-yellow-500">
                                        OK</th>
                                    <th hidden
                                        class="hidden border-b border-black px-4 py-2 text-black dark:border-yellow-500 dark:text-yellow-500">
                                        OK Buffing</th>
                                    <th hidden
                                        class="hidden border-b border-black px-4 py-2 text-black dark:border-yellow-500 dark:text-yellow-500">
                                        Repaint</th>
                                    <th hidden
                                        class="hidden border-b border-black px-4 py-2 text-black dark:border-yellow-500 dark:text-yellow-500">
                                        Out Total</th>
                                    <th
                                        class="text-3xl border-b border-black px-4 py-2 text-black dark:border-yellow-500 dark:text-yellow-500">
                                        RSP</th>
                                    <th
                                        class="text-3xl border-b border-black px-4 py-2 text-black dark:border-yellow-500 dark:text-yellow-500">
                                        FSP</th>
                                    <th
                                        class="text-3xl border-b border-black px-4 py-2 text-black dark:border-yellow-500 dark:text-yellow-500">
                                        REPAINT</th>
                                    <th
                                        class="text-3xl border-b border-black px-4 py-2 text-black dark:border-yellow-500 dark:text-yellow-500">
                                        OUT TOTAL</th>

                                    <th
                                        class="text-3xl border-b border-black px-4 py-2 text-black dark:border-yellow-500 dark:text-yellow-500">
                                        DEFACT</th>
                                </tr>



                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be inserted dynamically here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let previousData = [];

            function updateTime() {
                const timeElement = document.getElementById("current-time");
                const now = new Date();

                // Format waktu sebagai HH:MM:SS
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');

                timeElement.textContent = `${hours}:${minutes}:${seconds}`;
            }

            // Fungsi untuk memperbarui tanggal setiap hari (atau setiap 10 menit)
            function updateDate() {
                const dateElement = document.getElementById("current-date");
                const now = new Date();

                // Format tanggal sebagai YYYY-MM-DD
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
                const day = String(now.getDate()).padStart(2, '0');

                dateElement.textContent = `${year}-${month}-${day}`;
            }

            // Memperbarui waktu setiap detik
            setInterval(updateTime, 1000);

            // Memperbarui tanggal setiap 10 menit
            setInterval(updateDate, 600000);

            // Memperbarui tanggal dan waktu saat halaman dimuat
            document.addEventListener("DOMContentLoaded", () => {
                updateTime();
                updateDate();
            });

            function updateTable(data) {
                const tableBody = document.querySelector('#part-data-table tbody');


                data.forEach(item => {
                    const totalAll = item.Total_OK_Count + item.Total_OK_Buffing_Count + item
                        .Total_Count_OutTotal + item.Total_Count_Repaint;
                    const rsp = (item.Total_OK_Count / totalAll) * 100;
                    const fsp = rsp + ((item.Total_OK_Buffing_Count / totalAll) * 100);
                    const repaintPercentage = (item.Total_Count_Repaint / totalAll) * 100;
                    const outTotalPercentage = (item.Total_Count_OutTotal / totalAll) * 100;

                    const existingRow = Array.from(tableBody.querySelectorAll('tr')).find(row => {
                        const rowCells = row.querySelectorAll('td');
                        return rowCells[0].textContent === item.Customer_Name &&
                            rowCells[1].textContent === item.Item &&
                            rowCells[2].textContent === item.Part_Type &&
                            rowCells[3].textContent === item.Color;
                    });

                    if (existingRow) {
                        if (shouldUpdateRow(existingRow, item)) {
                            updateRow(existingRow, item, totalAll, rsp, fsp, repaintPercentage,
                                outTotalPercentage);
                            tableBody.insertBefore(existingRow, tableBody.firstChild);
                        }
                    } else {
                        const newRow = createRow(item, totalAll, rsp, fsp, repaintPercentage,
                            outTotalPercentage);
                        tableBody.insertBefore(newRow, tableBody.firstChild);
                    }
                });
            }

            function shouldUpdateRow(row, item) {
                const rowCells = row.querySelectorAll('td');
                return rowCells[5].textContent !== item.Total_OK_Count.toString() ||
                    rowCells[6].textContent !== item.Total_OK_Buffing_Count.toString() ||
                    rowCells[7].textContent !== item.Total_Count_Repaint.toString() ||
                    rowCells[8].textContent !== item.Total_Count_OutTotal.toString();
            }

            function updateRow(row, item, totalAll, rsp, fsp, repaintPercentage, outTotalPercentage) {
                const rowCells = row.querySelectorAll('td');
                rowCells[4].textContent = totalAll;
                rowCells[5].textContent = item.Total_OK_Count;
                rowCells[6].textContent = item.Total_OK_Buffing_Count;
                rowCells[7].textContent = item.Total_Count_Repaint;
                rowCells[8].textContent = item.Total_Count_OutTotal;
                rowCells[9].textContent = rsp.toFixed(2) + '%';
                rowCells[10].textContent = fsp.toFixed(2) + '%';
                rowCells[11].textContent = repaintPercentage.toFixed(2) + '%';
                rowCells[12].textContent = outTotalPercentage.toFixed(2) + '%';
                rowCells[13].textContent = item.Most_Frequent_Description || '-';
            }

            function createRow(item, totalAll, rsp, fsp, repaintPercentage, outTotalPercentage) {
                const row = document.createElement('tr');
                row.innerHTML = `
                   <td class="text-3xl border-b px-4 py-2 text-center">${item.Customer_Name}</td>
                    <td class="text-3xl text-black dark:text-yellow-500 border-b px-4 py-2 text-center">${item.Item}</td>
                    <td class="text-3xl border-b px-4 py-2 text-center">${item.Part_Type}</td>
                    <td class="text-3xl border-b px-4 py-2 text-center">${item.Color}</td>
                    <td class="text-3xl border-b px-4 py-2 text-center">${totalAll}</td>
                    <td hidden class="border-b px-4 py-2 text-center hidden">${item.Total_OK_Count}</td>
                    <td hidden class="border-b px-4 py-2 text-center hidden">${item.Total_OK_Buffing_Count}</td>
                    <td hidden class="border-b px-4 py-2 text-center hidden">${item.Total_Count_Repaint}</td>
                    <td hidden class="border-b px-4 py-2 text-center hidden">${item.Total_Count_OutTotal}</td>
                    <td class="text-3xl border-b px-4 py-2 text-center">${rsp.toFixed(0)}%</td>
                    <td class="text-3xl border-b px-4 py-2 text-center">${fsp.toFixed(0)}%</td>
                    <td class="text-3xl border-b px-4 py-2 text-center">${repaintPercentage.toFixed(0)}%</td>
                    <td class="text-3xl border-b px-4 py-2 text-center">${outTotalPercentage.toFixed(0)}%</td>
                      <td class="text-3xl border-b px-4 py-2 text-center">${item.Most_Frequent_Description || '-'}</td>
                            `;
                return row;
            }

            const lineSelect = document.getElementById("line-select");
            let selectedLineId = lineSelect.value;

            // Update table when line selection changes
            lineSelect.addEventListener("change", () => {
                const tableBody = document.querySelector('#part-data-table tbody');
                tableBody.innerHTML = ''; // 
                selectedLineId = lineSelect.value;
                fetchData();
            });



            function fetchData() {
                const countPartUrl = "{{ route('count-parts') }}";
                const url = selectedLineId ?
                    `${countPartUrl}?lines=${selectedLineId}` :
                    countPartUrl;

                console.log(url);

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        updateTable(data);
                        previousData = data;
                    })
                    .catch(error => console.error("Error fetching part data:", error));
            }

            fetchData();
            setInterval(fetchData, 2000); // Refresh every 20 seconds
        });
    </script>
</x-guest-layout>
