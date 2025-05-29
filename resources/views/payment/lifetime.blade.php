<x-app-layout>
       <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Pembayaran Modul Lifetime
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mb-4">Anda memilih Modul Lifetime</h3>
                    <p class="mb-4">Harga: <span class="font-bold text-lg">Rp 500.000</span></p>

                    <form action="{{ route('payment.process') }}" method="POST">
                        @csrf
                        {{-- Ini adalah hidden field yang meneruskan tipe modul ke controller --}}
                        <input type="hidden" name="module_type" value="{{ $moduleType }}">

                        <div class="mb-4">
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Metode Pembayaran:</label>
                            <select name="payment_method" id="payment_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="bank_transfer">Transfer Bank</option>
                                <option value="gopay">GoPay</option>
                                {{-- Tambahkan metode pembayaran lain jika ada --}}
                            </select>
                            @error('payment_method')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                       <div class="div">
                        anda akan membayar sejumlah <span class="tex-bolder">Rp 1.200.0000</span>
                       </div>

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                            Konfirmasi Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>