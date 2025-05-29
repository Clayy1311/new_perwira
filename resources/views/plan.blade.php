
   
   <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#021028] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="max-w-md mx-auto mt-20 p-6 bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-4 text-center">Pilih Membership</h2>

    <form id="membershipForm">
        <div class="space-y-4">
            <label class="flex items-center space-x-3">
                <input type="radio" name="plan" value="wolfpack" checked>
                <span>🐺 Wolfpack - 1 Tahun (Rp 1.000.000)</span>
            </label>
            <label class="flex items-center space-x-3">
                <input type="radio" name="plan" value="eternal">
                <span>♾️ Eternal - Seumur Hidup (Rp 3.000.000)</span>
            </label>

            <button type="submit" class="w-full mt-6 font-bold bg-gradient-to-r from-blue-500 to-blue-800 text-white px-4 py-2 rounded">
                Bayar Sekarang
            </button>
        </div>
    </form>
</div>

<!-- Midtrans Snap.js -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
document.getElementById('membershipForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const selectedPlan = document.querySelector('input[name="plan"]:checked').value;

    fetch("{{ route('payment') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ plan: selectedPlan })
    })
    .then(res => res.json())
    .then(data => {
        snap.pay(data.snap_token, {
            onSuccess: function(result) {
                alert("Pembayaran berhasil! 🎉");
                window.location.href = "/dashboard"; // redirect setelah bayar
            },
            onPending: function(result) {
                alert("Menunggu pembayaran...");
            },
            onError: function(result) {
                alert("Pembayaran gagal ❌");
            },
            onClose: function() {
                alert("Anda menutup popup tanpa menyelesaikan pembayaran.");
            }
        });
    })
    .catch(err => {
        console.error(err);
        alert("Terjadi kesalahan saat memproses transaksi.");
    });
});
</script>
       

                </div>
            </div>
        </div>
    </div>

