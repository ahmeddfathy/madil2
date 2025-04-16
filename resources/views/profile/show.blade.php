@extends('layouts.customer')

@section('content')
<div class="profile-page-container">
    <!-- User Profile Card -->

    <!-- Profile Content Area -->
    <div class="profile-content">
        <!-- Profile Information Section -->
        <div class="content-section">
            <div class="section-header">
                <i class="fas fa-user section-icon"></i>
                <h2 class="section-title">Profile Information</h2>
            </div>
            <p class="section-description">Update your account's profile information and email address</p>
            
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                <div class="livewire-form">
                    @livewire('profile.update-profile-information-form')
                </div>
            @endif
        </div>

        <!-- Password Update Section -->
        <div class="content-section">
            <div class="section-header">
                <i class="fas fa-lock section-icon"></i>
                <h2 class="section-title">Update Password</h2>
            </div>
            <p class="section-description">Ensure your account is using a long, random password to stay secure</p>
            
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="livewire-form">
                    @livewire('profile.update-password-form')
                </div>
            @endif
        </div>

        <!-- Two-Factor Authentication Section -->
        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
        <div class="content-section">
            <div class="section-header">
                <i class="fas fa-shield-alt section-icon"></i>
                <h2 class="section-title">Two Factor Authentication</h2>
            </div>
            <div class="livewire-form">
                @livewire('profile.two-factor-authentication-form')
            </div>
        </div>
        @endif

        <!-- Other Sections -->
        <div class="content-section">
            <div class="livewire-form">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>
        </div>

        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
        <div class="content-section danger-zone">
            <div class="section-header">
                <i class="fas fa-exclamation-triangle section-icon"></i>
                <h2 class="section-title">Delete Account</h2>
            </div>
            <div class="livewire-form">
                @livewire('profile.delete-user-form')
            </div>
        </div>
        @endif
    </div>
</div>

<style>
:root {
    --primary-color: #009245;
    --border-color: #e0e0e0;
    --text-muted: #777;
}

.profile-page-container {
    display: flex;
    gap: 2rem;
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
    min-height: calc(100vh - 160px);
}

/* Profile Card Styles */
.profile-card {
    width: 320px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 2rem;
    position: sticky;
    top: 120px;
    height: fit-content;
}

.profile-header {
    text-align: center;
    margin-bottom: 2rem;
}

.avatar {
    width: 100px;
    height: 100px;
    margin: 0 auto 1rem;
    border-radius: 50%;
    background: rgba(0, 146, 69, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.5rem;
    color: var(--primary-color);
}

.user-name {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: #333;
}

.user-email {
    color: var(--text-muted);
    font-size: 0.9rem;
}

.profile-details {
    margin: 2rem 0;
    border-top: 1px solid var(--border-color);
    border-bottom: 1px solid var(--border-color);
    padding: 1.5rem 0;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.detail-item:last-child {
    margin-bottom: 0;
}

.detail-icon {
    color: var(--primary-color);
    font-size: 1.1rem;
    width: 24px;
    text-align: center;
}

.detail-content {
    display: flex;
    flex-direction: column;
}

.detail-label {
    font-size: 0.8rem;
    color: var(--text-muted);
    margin-bottom: 0.25rem;
}

.detail-value {
    font-size: 0.95rem;
    color: #333;
    font-weight: 500;
}

.profile-menu {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.menu-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    color: #555;
    text-decoration: none;
    transition: all 0.2s ease;
}

.menu-item:hover {
    background: rgba(0, 146, 69, 0.05);
    color: var(--primary-color);
}

.menu-item.active {
    background: rgba(0, 146, 69, 0.1);
    color: var(--primary-color);
    font-weight: 500;
}

.menu-item i {
    width: 20px;
    text-align: center;
}

/* Profile Content Styles */
.profile-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.content-section {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 2rem;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.section-icon {
    color: var(--primary-color);
    font-size: 1.5rem;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #333;
    margin: 0;
}

.section-description {
    color: var(--text-muted);
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
}

/* Form Input Styles */
.livewire-form input:not([type="checkbox"]):not([type="radio"]),
.livewire-form textarea,
.livewire-form select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.2s ease;
    margin-bottom: 1rem;
}

.livewire-form input:focus,
.livewire-form textarea:focus,
.livewire-form select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(0, 146, 69, 0.1);
}

.livewire-form label {
    display: block;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: #555;
}

/* Button Styles */
.livewire-form button {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.livewire-form button:hover {
    background-color: #008a4f;
}

/* Form Group Styling */
.form-group {
    margin-bottom: 1.5rem;
}

/* Error Message Styling */
.text-sm.text-red-600 {
    font-size: 0.85rem;
    color: #e74c3c;
    margin-top: -0.5rem;
    margin-bottom: 1rem;
    display: block;
}

.danger-zone {
    border-left: 4px solid #e74c3c;
}

.danger-zone .section-icon {
    color: #e74c3c;
}

/* Responsive Design */
@media (max-width: 992px) {
    .profile-page-container {
        flex-direction: column;
    }
    
    .profile-card {
        width: 100%;
        position: static;
    }
}

@media (max-width: 576px) {
    .profile-page-container {
        padding: 1rem;
    }
    
    .profile-card,
    .content-section {
        padding: 1.5rem;
    }
}
</style>
@endsection