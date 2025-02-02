<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإشعارات | المتجر الحديث</title>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/notifications.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="glass-navbar mb-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-3">
                <h1 class="navbar-brand m-0">الإشعارات</h1>
                @if($notifications->isNotEmpty())
                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="glass-button">
                        <i class="fas fa-check-double ml-2"></i>
                        تعليم الكل كمقروء
                    </button>
                </form>
                @endif
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-4">
        <div class="glass-container">
            <div class="notifications-wrapper">
                @forelse($notifications as $notification)
                <div class="notification-item {{ $notification->read_at ? 'read' : 'unread' }}">
                    <div class="notification-icon">
                        @switch($notification->data['type'] ?? 'info')
                            @case('success')
                                <i class="fas fa-check-circle text-success"></i>
                                @break
                            @case('warning')
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                @break
                            @case('danger')
                                <i class="fas fa-times-circle text-danger"></i>
                                @break
                            @default
                                <i class="fas fa-info-circle text-info"></i>
                        @endswitch
                    </div>

                    <div class="notification-content">
                        <div class="notification-header">
                            <h3 class="notification-title">
                                {{ $notification->data['title'] ?? 'إشعار' }}
                            </h3>
                            @unless($notification->read_at)
                            <form action="{{ route('notifications.mark-read', $notification) }}" method="POST">
                                @csrf
                                <button type="submit" class="mark-read-btn">
                                    <i class="fas fa-check ml-1"></i>
                                    تعليم كمقروء
                                </button>
                            </form>
                            @endunless
                        </div>

                        <p class="notification-message">
                            {{ $notification->data['message'] ?? '' }}
                        </p>

                        <div class="notification-meta">
                            <span class="notification-time">
                                <i class="far fa-clock ml-1"></i>
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                            @if($notification->data['link'] ?? false)
                            <a href="{{ $notification->data['link'] }}" class="notification-link">
                                عرض التفاصيل
                                <i class="fas fa-chevron-left mr-1"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="far fa-bell-slash"></i>
                    </div>
                    <h3 class="empty-state-title">لا توجد إشعارات</h3>
                    <p class="empty-state-description">
                        ليس لديك أي إشعارات في الوقت الحالي
                    </p>
                </div>
                @endforelse

                @if($notifications->isNotEmpty())
                <div class="pagination-wrapper">
                    {{ $notifications->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Back to Home Button -->
    <div class="container mb-4">
        <a href="{{ route('home') }}" class="glass-button d-inline-block">
            <i class="fas fa-arrow-right ml-2"></i>
            العودة للرئيسية
        </a>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // إضافة تأثيرات حركية للإشعارات
        document.addEventListener('DOMContentLoaded', function() {
            const notifications = document.querySelectorAll('.notification-item');
            notifications.forEach((notification, index) => {
                notification.style.animationDelay = `${index * 0.1}s`;
                notification.classList.add('fade-in');
            });
        });

        // تأثير حركي عند تعليم الإشعار كمقروء
        const markReadForms = document.querySelectorAll('form[action*="mark-read"]');
        markReadForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const notification = this.closest('.notification-item');
                notification.classList.add('mark-read-animation');
                setTimeout(() => {
                    this.submit();
                }, 300);
            });
        });
    </script>
</body>
</html>

<style>
.glass-container {
  background: var(--glass-background);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border-radius: 20px;
  border: var(--glass-border);
  box-shadow: var(--card-shadow);
  overflow: hidden;
}

.glass-button {
  background: var(--glass-background);
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
  border: var(--glass-border);
  padding: 0.75rem 1.5rem;
  border-radius: 12px;
  color: var(--primary-color);
  font-weight: 600;
  transition: all 0.3s ease;
}

.glass-button:hover {
  background: var(--glass-background-dark);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(108, 92, 231, 0.2);
}

.notifications-wrapper {
  padding: 2rem;
}

.notification-item {
  display: flex;
  gap: 1.5rem;
  padding: 1.5rem;
  border-radius: 15px;
  margin-bottom: 1rem;
  transition: all 0.3s ease;
  background: rgba(255, 255, 255, 0.5);
  border: 1px solid rgba(255, 255, 255, 0.3);
}

.notification-item.unread {
  background: rgba(108, 92, 231, 0.05);
  border-color: rgba(108, 92, 231, 0.1);
}

.notification-icon {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--glass-background);
  font-size: 1.5rem;
  flex-shrink: 0;
}

.notification-content {
  flex: 1;
}

.notification-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0.75rem;
}

.notification-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: var(--text-color);
}

.mark-read-btn {
  color: var(--primary-color);
  font-size: 0.9rem;
  font-weight: 500;
  transition: all 0.2s ease;
}

.mark-read-btn:hover {
  color: var(--secondary-color);
}

.notification-message {
  color: var(--text-color);
  line-height: 1.6;
  margin-bottom: 1rem;
}

.notification-meta {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 0.9rem;
  color: var(--text-light);
}

.notification-link {
  color: var(--primary-color);
  font-weight: 500;
  transition: all 0.2s ease;
}

.notification-link:hover {
  color: var(--secondary-color);
}

.empty-state {
  text-align: center;
  padding: 4rem 2rem;
}

.empty-state-icon {
  font-size: 4rem;
  color: var(--text-light);
  margin-bottom: 1.5rem;
  opacity: 0.5;
}

.empty-state-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: var(--text-color);
  margin-bottom: 0.5rem;
}

.empty-state-description {
  color: var(--text-light);
  font-size: 1rem;
}

.pagination-wrapper {
  margin-top: 2rem;
  display: flex;
  justify-content: center;
}

/* Responsive Design */
@media (max-width: 768px) {
  .notifications-wrapper {
    padding: 1rem;
  }

  .notification-item {
    padding: 1rem;
    gap: 1rem;
  }

  .notification-icon {
    width: 40px;
    height: 40px;
    font-size: 1.25rem;
  }

  .notification-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.5rem;
  }

  .notification-meta {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.5rem;
  }
}
</style>
