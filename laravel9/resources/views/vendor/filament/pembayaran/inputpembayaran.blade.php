<x-filament::page>

    <form action="" wire:submit.prevet="save">
        <div class="p-4 space-y-4">
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200" id="payment-table">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uraian</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <input type="number" name="id[]" class="block w-16 rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 disabled:bg-gray-50 disabled:text-gray-500" value="1" readonly>
                            </td>
                            <td class="px-6 py-4">
                                <input type="date" name="tanggal_dokumen[]" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                            </td>
                            <td class="px-6 py-4">
                                <input type="text" name="uraian[]" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                            </td>
                            <td class="px-6 py-4">
                                <input type="number" name="jumlah[]" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                            </td>
                            <td class="px-6 py-4">
                                <input type="text" name="keterangan[]" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            </td>
                            <td class="px-6 py-4">
                                <button type="button" class="delete-row inline-flex items-center justify-center w-9 h-9 text-danger-600 hover:text-danger-500 hover:bg-danger-50 rounded-lg transition">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="button" id="add-row" class="inline-flex items-center justify-center gap-1 px-4 py-2 font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Baris
            </button>
        </div>
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let rowCount = 1;

        // Add new row
        document.getElementById('add-row').addEventListener('click', function() {
            rowCount++;
            const tbody = document.querySelector('#payment-table tbody');
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50';
            tr.innerHTML = `
                <td class="px-6 py-4">
                    <input type="number" name="id[]" class="block w-16 rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 disabled:bg-gray-50 disabled:text-gray-500" value="${rowCount}" readonly>
                </td>
                <td class="px-6 py-4">
                    <input type="date" name="tanggal_dokumen[]" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                </td>
                <td class="px-6 py-4">
                    <input type="text" name="uraian[]" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                </td>
                <td class="px-6 py-4">
                    <input type="number" name="jumlah[]" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                </td>
                <td class="px-6 py-4">
                    <input type="text" name="keterangan[]" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </td>
                <td class="px-6 py-4">
                    <button type="button" class="delete-row inline-flex items-center justify-center w-9 h-9 text-danger-600 hover:text-danger-500 hover:bg-danger-50 rounded-lg transition">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        // Delete row
        document.querySelector('#payment-table').addEventListener('click', function(e) {
            if (e.target.closest('.delete-row')) {
                const tbody = document.querySelector('#payment-table tbody');
                if (tbody.children.length > 1) {
                    e.target.closest('tr').remove();
                    // Update row numbers
                    document.querySelectorAll('input[name="id[]"]').forEach((input, index) => {
                        input.value = index + 1;
                    });
                    rowCount = tbody.children.length;
                } else {
                    alert('Minimal harus ada satu baris!');
                }
            }
        });
    });
    </script>

</x-filament::page>