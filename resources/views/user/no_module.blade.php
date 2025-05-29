<div class="flex items-center justify-center min-h-[calc(100vh-150px)] py-12 px-4 sm:px-6 lg:px-8 bg-gray-100 dark:bg-gray-900">
    <div class="max-w-md w-full space-y-8 p-10 bg-white dark:bg-gray-800 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300 ease-in-out border border-gray-200 dark:border-gray-700">
        <div class="text-center">
            {{-- Icon atau Ilustrasi --}}
            <svg class="mx-auto h-16 w-16 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13.5m0-13.5c-4.142 0-7.5 3.167-7.5 7.056s3.358 7.055 7.5 7.055S19.5 17.023 19.5 13.134 16.142 6.253 12 6.253z"></path>
            </svg>
            <h3 class="mt-4 text-3xl font-extrabold text-gray-900 dark:text-white">
                Mulai Petualangan Belajarmu!
            </h3>
            <p class="mt-2 text-md text-gray-600 dark:text-gray-400">
                Sepertinya Anda belum memilih modul kursus apapun. Pilih modul pertama Anda dan mulailah perjalanan belajar yang menarik!
            </p>
        </div>
        <div class="mt-6 flex justify-center">
            <a href="{{ route('select_module') }}"
               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150 transform hover:scale-105">
                <svg class="-ml-1 mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V6a1 1 0 112 0v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3z" clip-rule="evenodd"></path>
                </svg>
                Pilih Modul Sekarang
            </a>
        </div>
    </div>
</div>