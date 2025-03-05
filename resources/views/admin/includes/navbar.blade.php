<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">{{__('messages.Home')}}</a>
      </li>
      @php
          $wallet= App\Models\Wallet::find(1);
      @endphp
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('wallets.create') }}" style="font-weight: bold" class="nav-link">{{__('messages.Wallet')}} : <span style="color: red; font-weight: bold;">{{$wallet->total}} JD</span>
        </a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.logout') }}" class="nav-link">{{__('messages.Logout')}}</a>
      </li>
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <a class="nav-link"  hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
            {{ $properties['native'] }}
        </a>
    @endforeach
    </ul>


  </nav>
