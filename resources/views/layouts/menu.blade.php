<li class="nav-item">
    <a href="{{ route('users.index') }}"
       class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
        <i class="fas fa-question"></i>
        <p>@lang('models/users.plural')</p>
    </a>
</li>