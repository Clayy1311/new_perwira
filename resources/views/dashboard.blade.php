<x-app-layout>
   

    <div class="">
        <div class="max-w-9xl">
            <div class="bg-black text-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900 dark:text-gray-100">

                    {{-- Pesan sukses/error --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    {{-- Tampilkan view sesuai kondisi --}}
                    @if($approvedModules->isNotEmpty())
                    @include('user.approved_module', ['approvedModules' => $approvedModules])
                    
                    @elseif($noModuleSelected)
                        @include('user.no_module')
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
