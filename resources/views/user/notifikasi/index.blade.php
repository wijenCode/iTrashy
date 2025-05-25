<div id="floating-notification" class="fixed top-6 right-6 z-50 hidden">
    <a id="notif-link" href="#" class="block" style="pointer-events: none;">
        <div id="notif-content" class="bg-white shadow-lg rounded-lg px-6 py-4 flex items-center gap-4 border-l-4 border-green-500 animate-slide-in">
            <div id="notif-icon">
                <!-- Icon will be injected here -->
            </div>
            <div>
                <div id="notif-title" class="font-bold text-lg mb-1">Notifikasi</div>
                <div id="notif-message" class="text-gray-700 text-sm"></div>
            </div>
            <button type="button" onclick="document.getElementById('floating-notification').classList.add('hidden')" class="ml-4 text-gray-400 hover:text-gray-700"><i class="fas fa-times"></i></button>
        </div>
    </a>
</div>

@push('scripts')
<script>
function showNotification({title, message, type = 'success', link = null}) {
    const notif = document.getElementById('floating-notification');
    const notifTitle = document.getElementById('notif-title');
    const notifMsg = document.getElementById('notif-message');
    const notifIcon = document.getElementById('notif-icon');
    const notifLink = document.getElementById('notif-link');
    notifTitle.textContent = title;
    notifMsg.textContent = message;
    let iconHtml = '';
    let border = 'border-green-500';
    if(type === 'success') {
        iconHtml = '<span class="bg-green-100 text-green-600 rounded-full p-2"><i class="fas fa-check-circle fa-lg"></i></span>';
        border = 'border-green-500';
    } else if(type === 'info') {
        iconHtml = '<span class="bg-blue-100 text-blue-600 rounded-full p-2"><i class="fas fa-info-circle fa-lg"></i></span>';
        border = 'border-blue-500';
    } else if(type === 'warning') {
        iconHtml = '<span class="bg-yellow-100 text-yellow-600 rounded-full p-2"><i class="fas fa-exclamation-circle fa-lg"></i></span>';
        border = 'border-yellow-500';
    } else if(type === 'error') {
        iconHtml = '<span class="bg-red-100 text-red-600 rounded-full p-2"><i class="fas fa-times-circle fa-lg"></i></span>';
        border = 'border-red-500';
    }
    notifIcon.innerHTML = iconHtml;
    notif.querySelector('div').className = `bg-white shadow-lg rounded-lg px-6 py-4 flex items-center gap-4 border-l-4 ${border} animate-slide-in`;
    if(link) {
        notifLink.href = link;
        notifLink.style.pointerEvents = 'auto';
        notifLink.style.cursor = 'pointer';
    } else {
        notifLink.href = '#';
        notifLink.style.pointerEvents = 'none';
        notifLink.style.cursor = 'default';
    }
    notif.classList.remove('hidden');
    setTimeout(() => {
        notif.classList.add('hidden');
    }, 4000);
}

// Example usage (uncomment to test):
// showNotification({title: 'Setor Sampah Diterima', message: 'Setoran sampah kamu sudah diterima dan sedang diproses.', type: 'info'});
// showNotification({title: 'Tukar Voucher Berhasil', message: 'Penukaran voucher berhasil! Silakan cek riwayat.', type: 'success'});
</script>
<style>
@keyframes slide-in {
    from { transform: translateX(100px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
.animate-slide-in { animation: slide-in 0.4s cubic-bezier(.4,2,.6,1) both; }
#notif-link { text-decoration: none; }
</style>
@endpush
