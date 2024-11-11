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
                        <span class="text-3xl font-semibold">PT Dharma Poliplast</span>
                        <span class="text-sm font-semibold mt-3">RTMP (Real Time Monitoring Project)</span>
                    </div>

                    <!-- Column 3: Date/Time -->
                    <div class="text-center md:text-right">
                        <!-- Tanggal -->
                        <div id="current-date" class="text-center text-xl font-medium">
                            {{ \Carbon\Carbon::now()->format('Y-m-d') }}
                        </div>
                        <!-- Waktu -->
                        <div id="current-time" class="text-center text-xl font-medium">
                            {{ \Carbon\Carbon::now()->format('H:i:s') }}
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="h-full">
                    <!-- Table Container with horizontal scroll for responsiveness -->
                    <div class="overflow-x-auto h-full">
                        <table id="part-data-table" class="min-w-full table-auto border-collapse h-full">
                            <thead>
                                <tr>
                                    <th class="border-b px-4 py-2">Customer</th>
                                    <th class="border-b px-4 py-2">Part Name</th>
                                    <th class="border-b px-4 py-2">Type</th>
                                    <th class="border-b px-4 py-2">Color</th>
                                    <th class="border-b px-4 py-2">Total</th>
                                    <th class="border-b px-4 py-2">OK</th>
                                    <th class="border-b px-4 py-2">OK Buffing</th>
                                    <th class="border-b px-4 py-2">Repaint</th>
                                    <th class="border-b px-4 py-2">Out Total</th>
                                    <th class="border-b px-4 py-2">RSP %</th>
                                    <th class="border-b px-4 py-2">FSP %</th>
                                    <th class="border-b px-4 py-2">Repaint %</th>
                                    <th class="border-b px-4 py-2">Out Total %</th>
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
            }

            function createRow(item, totalAll, rsp, fsp, repaintPercentage, outTotalPercentage) {
                const row = document.createElement('tr');
                row.innerHTML = `
                   <td class="border-b px-4 py-2 text-center">${item.Customer_Name}</td>
                    <td class="border-b px-4 py-2 text-center">${item.Item}</td>
                    <td class="border-b px-4 py-2 text-center">${item.Part_Type}</td>
                    <td class="border-b px-4 py-2 text-center">${item.Color}</td>
                    <td class="border-b px-4 py-2 text-center">${totalAll}</td>
                    <td class="border-b px-4 py-2 text-center">${item.Total_OK_Count}</td>
                    <td class="border-b px-4 py-2 text-center">${item.Total_OK_Buffing_Count}</td>
                    <td class="border-b px-4 py-2 text-center">${item.Total_Count_Repaint}</td>
                    <td class="border-b px-4 py-2 text-center">${item.Total_Count_OutTotal}</td>
                    <td class="border-b px-4 py-2 text-center">${rsp.toFixed(2)}%</td>
                    <td class="border-b px-4 py-2 text-center">${fsp.toFixed(2)}%</td>
                    <td class="border-b px-4 py-2 text-center">${repaintPercentage.toFixed(2)}%</td>
                    <td class="border-b px-4 py-2 text-center">${outTotalPercentage.toFixed(2)}%</td>
                            `;
                return row;
            }

            function fetchData() {
                fetch("http://192.168.17.138:8000/countPart")
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
