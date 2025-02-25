@extends('layouts.customer')

@section('title', 'الإشعارات')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('assets/css/customer/notifications.css') }}">
<style>
    .appointment-details {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 12px;
        margin-top: 10px;
    }
    .appointment-item {
        border-bottom: 1px solid #dee2e6;
        padding: 8px 0;
    }
    .appointment-item:last-child {
        border-bottom: none;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">الإشعارات</h2>
        @if($notifications->count() > 0)
        <form action="{{ route('notifications.mark-all-read') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-primary">
                <i class="bi bi-check2-all me-2"></i>
                تحديد الكل كمقروء
            </button>
        </form>
        @endif
    </div>

    <div class="notifications-container">
        @forelse($notifications as $notification)
        <div class="notification-item {{ $notification->read_at ? '' : 'unread' }}">
            <div class="d-flex gap-3">
                <div class="notification-icon">
                    <i class="bi bi-bell"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h5 class="mb-1">{{ $notification->data['title'] ?? 'إشعار جديد' }}</h5>
                            <p class="mb-0">{{ $notification->data['message'] ?? '' }}</p>

                            @if(isset($notification->data['appointments']) && count($notification->data['appointments']) > 0)
                            <div class="appointment-details mt-3">
                                <h6 class="mb-2"><i class="bi bi-calendar-check me-2"></i>مواعيد المقاسات:</h6>
                                @foreach($notification->data['appointments'] as $appointment)
                                <div class="appointment-item">
                                    <div><strong>المنتج:</strong> {{ $appointment['product_name'] }}</div>
                                    <div><strong>الموعد:</strong> {{ $appointment['date'] }}</div>
                                    <div><strong>رقم المرجع:</strong> {{ $appointment['reference_number'] }}</div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @if(!$notification->read_at)
                        <form action="{{ route('notifications.mark-as-read', $notification) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-check2"></i>
                                تحديد كمقروء
                            </button>
                        </form>
                        @endif
                    </div>
                    <div class="notification-time">
                        <i class="bi bi-clock me-1"></i>
                        {{ $notification->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="bi bi-bell-slash"></i>
            </div>
            <h3>لا توجد إشعارات</h3>
            <p class="text-muted">ليس لديك أي إشعارات جديدة في الوقت الحالي</p>
        </div>
        @endforelse

        <div class="mt-4">
            @if ($notifications->hasPages())
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($notifications->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="bi bi-chevron-right"></i>
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $notifications->previousPageUrl() }}" rel="prev">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($notifications->render()->elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <li class="page-item disabled">
                                    <span class="page-link">{{ $element }}</span>
                                </li>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $notifications->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($notifications->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $notifications->nextPageUrl() }}" rel="next">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="bi bi-chevron-left"></i>
                                </span>
                            </li>
                        @endif
                    </ul>
                </nav>
            @endif
        </div>
    </div>
</div>
@endsection
