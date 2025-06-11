<!-- TopBar -->
<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                @php
                    $notifications = getUnreadNotifications();
                    $notificationCount = count($notifications);
                @endphp
                @if ($notificationCount > 0)
                    <span class="badge badge-danger badge-counter">
                        {{ $notificationCount > 9 ? '9+' : $notificationCount }}
                    </span>
                @endif
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Notifikasi
                </h6>

                @forelse($notifications as $notification)
                    @if(!$notification['is_read'])
                        <a class="dropdown-item d-flex align-items-center notification-item" 
                           href="{{ $notification['url'] }}"
                           data-notification-id="{{ $notification['id'] }}"
                           data-notification-url="{{ $notification['url'] }}"
                           onclick="markAsRead({{ $notification['id'] }}, '{{ $notification['url'] }}'); return false;">
                            <div class="mr-3">
                                <div class="icon-circle {{ $notification['icon_bg'] }}">
                                    <i class="{{ $notification['icon'] }} text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">{{ $notification['created_at'] }}</div>
                                <span class="font-weight-bold">
                                    {{ $notification['message'] }}
                                </span>
                            </div>
                        </a>
                    @endif
                @empty
                    <div class="dropdown-item text-center" id="no-notifications">
                        <span class="text-gray-500">Tidak ada notifikasi</span>
                    </div>
                @endforelse

            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="{{ getUserProfilePhoto() }}" alt="Profile Image">
                <span class="ml-2 d-none d-lg-inline text-white small">{{ getUserDisplayName() }}</span>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ getUserProfileRoute() }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profil
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>

<script>
    function markAsRead(notificationId, notificationUrl) {
        // Mark notification as read
        fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hide the notification immediately
                    const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
                    if (notificationElement) {
                        notificationElement.style.display = 'none';
                    }

                    // Update the notification counter
                    updateNotificationCounter();
                    
                    // Navigate to the URL after a short delay
                    setTimeout(() => {
                        if (notificationUrl && notificationUrl !== '#') {
                            window.location.href = notificationUrl;
                        }
                    }, 100);
                }
            })
            .catch(error => {
                console.error('Error marking notification as read:', error);
                // Still redirect even if marking as read fails
                if (notificationUrl && notificationUrl !== '#') {
                    window.location.href = notificationUrl;
                }
            });
    }

    function updateNotificationCounter() {
        const counter = document.querySelector('.badge-counter');
        const dropdown = document.querySelector('.dropdown-list');
        const visibleNotifications = dropdown.querySelectorAll('.notification-item:not([style*="display: none"])');
        const remainingNotifications = visibleNotifications.length;

        if (remainingNotifications === 0) {
            // Remove counter badge
            if (counter) counter.remove();
            
            // Show "no notifications" message
            const dropdownHeader = dropdown.querySelector('.dropdown-header');
            if (dropdownHeader) {
                dropdown.innerHTML = '';
                dropdown.appendChild(dropdownHeader);
                
                const noNotificationsDiv = document.createElement('div');
                noNotificationsDiv.className = 'dropdown-item text-center';
                noNotificationsDiv.id = 'no-notifications';
                noNotificationsDiv.innerHTML = '<span class="text-gray-500">Tidak ada notifikasi</span>';
                dropdown.appendChild(noNotificationsDiv);
            }
        } else {
            // Update counter
            if (counter) {
                counter.textContent = remainingNotifications > 9 ? '9+' : remainingNotifications;
            }
        }
    }

    setInterval(function() {
    }, 1000);
</script>
<!-- End of Topbar -->