<x-app-layout>
    <x-slot name="header">
        <!-- Empty header slot for customization if needed -->
    </x-slot>

    <!-- Main Content -->
    <div class="p-4 md:p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="p-4 md:p-6 bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4 md:gap-8">

                <!-- Header Section with Logo, Text, and Date/Time -->
                <div class="flex justify-between mb-4">
                    <!-- Column 1: Logo -->
                    <div class="flex items-center">
                        <x-application-logo class="w-10 h-10" />
                    </div>

                    <!-- Column 2: Text (Dharma Poliplash) -->
                    <div class="flex items-center">
                        <span class="text-xl font-semibold">Dharma Poliplash</span>
                    </div>

                    <!-- Column 3: Date/Time -->
                    <div class="text-center md:text-right">
                        <span id="current-date-time" class="text-sm font-medium">
                            {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}
                        </span>
                    </div>
                </div>

                <!-- Table Section -->
                <div>
                    <h2 class="text-lg font-semibold mb-4">Part Data Summary</h2>

                    <!-- Table Container with horizontal scroll for responsiveness -->
                    <div class="overflow-x-auto">
                        <table id="part-data-table" class="min-w-full table-auto border-collapse">
                            <thead>
                                <tr>
                                    <th class="border-b px-4 py-2">Customer</th>
                                    <th class="border-b px-4 py-2">Part Name</th>
                                    <th class="border-b px-4 py-2">Type</th>
                                    <th class="border-b px-4 py-2">Color</th>
                                    <th class="border-b px-4 py-2">Total</th>
                                    <th class="border-b px-4 py-2">OK</th>
                                    <th class="border-b px-4 py-2">Buffing</th>
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

            function updateDateTime() {
                const dateTimeElement = document.getElementById('current-date-time');
                const currentDateTime = new Date();
                const year = currentDateTime.getFullYear();
                const month = ('0' + (currentDateTime.getMonth() + 1)).slice(-2);
                const day = ('0' + currentDateTime.getDate()).slice(-2);
                const hours = ('0' + currentDateTime.getHours()).slice(-2);
                const minutes = ('0' + currentDateTime.getMinutes()).slice(-2);
                const seconds = ('0' + currentDateTime.getSeconds()).slice(-2);
                const formattedDateTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
                dateTimeElement.textContent = formattedDateTime;
            }

            setInterval(updateDateTime, 1000);

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
                    <td class="border-b px-4 py-2">${item.Customer_Name}</td>
                    <td class="border-b px-4 py-2">${item.Item}</td>
                    <td class="border-b px-4 py-2">${item.Part_Type}</td>
                    <td class="border-b px-4 py-2">${item.Color}</td>
                    <td class="border-b px-4 py-2">${totalAll}</td>
                    <td class="border-b px-4 py-2">${item.Total_OK_Count}</td>
                    <td class="border-b px-4 py-2">${item.Total_OK_Buffing_Count}</td>
                    <td class="border-b px-4 py-2">${item.Total_Count_Repaint}</td>
                    <td class="border-b px-4 py-2">${item.Total_Count_OutTotal}</td>
                    <td class="border-b px-4 py-2">${rsp.toFixed(2)}%</td>
                    <td class="border-b px-4 py-2">${fsp.toFixed(2)}%</td>
                    <td class="border-b px-4 py-2">${repaintPercentage.toFixed(2)}%</td>
                    <td class="border-b px-4 py-2">${outTotalPercentage.toFixed(2)}%</td>
                `;
                return row;
            }

            function fetchData() {
                fetch("http://127.0.0.1:8000/countPart")
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
</x-app-layout>
