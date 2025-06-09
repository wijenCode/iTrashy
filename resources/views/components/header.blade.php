<!-- resources/views/layouts/header.blade.php -->
<header class="sticky top-0 bg-white shadow-md z-40">
    <div class="flex items-center justify-between p-4">
        <div class="flex items-center space-x-4">
            <button id="menuToggle" class="lg:hidden">
                <svg class="w-6 h-6" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
            <h2 id="pageTitle" class="text-lg font-semibold">
                <!-- Dynamic Title -->
                @yield('page-title', 'Dashboard')
            </h2>
        </div>
        
        <div class="flex items-center space-x-4 relative">
            <!-- Notifikasi -->
            <div class="relative" x-data="{ openNotif: false }">
                <button id="notifIcon" class="focus:outline-none" @click="openNotif = !openNotif">
                    <img src="{{ asset('storage/images/notifikasi.png') }}" alt="Notifications" class="w-8 h-8">
                    <!-- Badge -->
                    <span id="notifBadge" class="absolute top-0 right-0 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center hidden">
                        0
                    </span>
                </button>
                <!-- Dropdown Notifikasi -->
                <div x-show="openNotif" @click.away="openNotif = false" x-transition class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50 border border-gray-100">
                    <div class="p-4 border-b font-bold text-gray-700 flex justify-between items-center">
                        <span>Notifikasi</span>
                        <button type="button" onclick="markAllAsRead()" class="text-sm text-blue-600 hover:underline">Tandai semua dibaca</button>
                            </div>
                    <ul id="notificationsList" class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                        <!-- Notifications will be loaded here -->
                    </ul>
                    <div class="p-2 text-center border-t">
                        <a href="/riwayat" class="text-blue-600 text-sm hover:underline">Lihat Semua Riwayat</a>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="w-px h-10 bg-black"></div>
            
            <!-- Profile Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <!-- Profile Image -->
                <button @click="open = ! open" class="focus:outline-none">
                    <img src="{{ asset('storage/images/profile.jpg') }}" alt="Profile" class="w-10 h-10 rounded-full">
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-10">
                    <div class="py-1">
                        <!-- Profile Link -->
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Profile') }}
                        </a>

                        <!-- Logout Form -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@include('user.notifikasi.index')

@push('scripts')
<script>
// Fungsi untuk memuat notifikasi
function loadNotifications() {
    console.log('Loading notifications...');
    fetch('/notifications', {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Received notifications:', data);
        const notificationsList = document.getElementById('notificationsList');
        notificationsList.innerHTML = '';
        
        if (data.length === 0) {
            notificationsList.innerHTML = `
                <div class="p-4 text-center text-gray-500">
                    Tidak ada notifikasi
                </div>
            `;
        } else {
            data.forEach(notification => {
                const div = document.createElement('div');
                div.className = `p-4 border-b ${notification.is_read ? 'bg-white' : 'bg-blue-50'}`;
                
                let iconClass = '';
                let iconColor = '';
                
                switch(notification.type) {
                    case 'success':
                        iconClass = 'fas fa-check-circle';
                        iconColor = 'text-green-500';
                        break;
                    case 'info':
                        iconClass = 'fas fa-info-circle';
                        iconColor = 'text-blue-500';
                        break;
                    case 'warning':
                        iconClass = 'fas fa-exclamation-circle';
                        iconColor = 'text-yellow-500';
                        break;
                    case 'error':
                        iconClass = 'fas fa-times-circle';
                        iconColor = 'text-red-500';
                        break;
                }
                
                div.innerHTML = `
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="${iconClass} ${iconColor} text-lg"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900">${notification.title}</p>
                            <p class="text-sm text-gray-500">${notification.message}</p>
                            <p class="text-xs text-gray-400 mt-1">${formatTimeAgo(notification.created_at)}</p>
                        </div>
                        ${!notification.is_read ? `
                            <button type="button" onclick="markAsRead(${notification.id})" class="ml-2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-circle text-xs"></i>
                            </button>
                        ` : ''}
                    </div>
                `;
                
                if (notification.link) {
                    div.onclick = (e) => {
                        // Prevent click if clicking the mark as read button
                        if (e.target.closest('button')) return;
                        
                        if (!notification.is_read) {
                            markAsRead(notification.id);
                        }
                        window.location.href = notification.link;
                    };
                    div.style.cursor = 'pointer';
                }
                
                notificationsList.appendChild(div);
            });
        }
        
        updateNotificationBadge();
    })
    .catch(error => {
        console.error('Error loading notifications:', error);
        const notificationsList = document.getElementById('notificationsList');
        notificationsList.innerHTML = `
            <div class="p-4 text-center text-red-500">
                Gagal memuat notifikasi. Silakan coba lagi.
            </div>
        `;
    });
}

// Fungsi untuk menandai notifikasi sebagai sudah dibaca
function markAsRead(id) {
    console.log('Marking notification as read:', id);
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    fetch(`/notifications/${id}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Mark as read response status:', response.status);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Mark as read response:', data);
        if (data.success) {
            loadNotifications();
            updateNotificationBadge();
        } else {
            console.error('Failed to mark notification as read:', data.message);
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

// Fungsi untuk menandai semua notifikasi sebagai sudah dibaca
function markAllAsRead() {
    console.log('Marking all notifications as read');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    fetch('/notifications/mark-all-as-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Mark all as read response status:', response.status);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Mark all as read response:', data);
        if (data.success) {
            loadNotifications();
            updateNotificationBadge();
        } else {
            console.error('Failed to mark all notifications as read:', data.message);
        }
    })
    .catch(error => {
        console.error('Error marking all notifications as read:', error);
    });
}

// Fungsi untuk memperbarui badge notifikasi
function updateNotificationBadge() {
    console.log('Updating notification badge');
    fetch('/notifications/unread-count', {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Unread count response status:', response.status);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Unread count:', data);
        const badge = document.getElementById('notifBadge');
        if (data.count > 0) {
            badge.textContent = data.count;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    })
    .catch(error => {
        console.error('Error updating notification badge:', error);
    });
}

// Fungsi untuk memformat waktu
function formatTimeAgo(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffInSeconds = Math.floor((now - date) / 1000);
    
    if (diffInSeconds < 60) {
        return 'Baru saja';
    }
    
    const diffInMinutes = Math.floor(diffInSeconds / 60);
    if (diffInMinutes < 60) {
        return `${diffInMinutes} menit yang lalu`;
    }
    
    const diffInHours = Math.floor(diffInMinutes / 60);
    if (diffInHours < 24) {
        return `${diffInHours} jam yang lalu`;
    }
    
    const diffInDays = Math.floor(diffInHours / 24);
    if (diffInDays < 7) {
        return `${diffInDays} hari yang lalu`;
    }
    
    return date.toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

// Load notifications when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded, initializing notifications');
    loadNotifications();
    // Refresh notifications every 30 seconds
    setInterval(loadNotifications, 30000);
});
</script>
@endpush
