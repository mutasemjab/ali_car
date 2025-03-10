<style>
    /* Ensure navbar items stay at the end */
    .navbar-nav.ms-auto {
        margin-left: auto !important;
        margin-right: 0 !important;
        display: flex;
        justify-content: flex-end;
        width: 100%;
    }

    /* Fix dropdown menu alignment */
    .dropdown-menu-right {
        right: 0 !important;
        left: auto !important;
        text-align: right;
    }

        .main-header.navbar {
        background: #ffffff; /* Light background */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Soft shadow */
        padding: 10px 15px;
        border-bottom: 1px solid #e3e3e3;
    }

    /* Navbar Toggle Button */
    .navbar-nav .nav-item .nav-link {
        color: #333;
        transition: all 0.3s ease;
    }

    .navbar-nav .nav-item .nav-link:hover {
        color: #007bff; /* Blue hover effect */
    }

    /* User Dropdown */
    .user-dropdown {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        background: transparent;
        border-radius: 5px;
        transition: background 0.3s ease;
        text-decoration: none;
        color: #333;
    }

    .user-dropdown:hover {
        background: #f3f3f3;
    }

    /* User Image */
    .user-image {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        object-fit: cover;
        margin-left: 10px;
        border: 2px solid #ddd;
    }

    /* Username */
    .user-name {
        font-weight: 500;
        font-size: 14px;
        margin-right: 10px;
        color: #333;
    }

    /* Dropdown Styling */
    .dropdown-menu {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: none;
        min-width: 180px;
    }

    .dropdown-item {
        font-size: 14px;
        padding: 10px 15px;
        color: #333;
        transition: background 0.3s ease;
    }

    .dropdown-item:hover {
        background: #f8f9fa;
        color: #007bff;
    }

    /* Dropdown Divider */
    .dropdown-divider {
        border-top: 1px solid #e3e3e3;
    }

    /* Navbar Responsive Design */
    @media (max-width: 768px) {
        .user-dropdown {
            flex-direction: column;
            align-items: flex-start;
        }

        .user-name {
            margin-right: 0;
            font-size: 12px;
        }

        .user-image {
            width: 30px;
            height: 30px;
        }
    }

    </style>


    <nav class="main-header navbar navbar-expand navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>

        <!-- Right navbar links (Always at the end) -->
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="user-dropdown" data-toggle="dropdown" href="#">
                    <img src="{{ url('assets/admin/dist/img/avatar.png') }}" class="user-image" alt="User Avatar">
                    <i class="fas fa-chevron-down ms-2" style="font-size: 12px; color: #64748b;"></i>
                    <span class="user-name">{{ auth()->user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- Languages -->
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a class="dropdown-item" hreflang="{{ $localeCode }}"
                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            <i class="fas fa-globe"></i>
                            {{ $properties['native'] }}
                        </a>
                    @endforeach

                    <div class="dropdown-divider"></div>

                    <a href="{{ route('admin.login.edit', auth()->user()->id) }}" class="dropdown-item">
                        <i class="fas fa-user-cog"></i>
                        {{ __('messages.My Profile') }}
                    </a>

                    <div class="dropdown-divider"></div>

                    <a href="{{ route('admin.logout') }}" class="dropdown-item">
                        <i class="fas fa-sign-out-alt"></i>
                        {{ __('messages.Logout') }}
                    </a>
                </div>
            </li>
        </ul>
    </nav>

