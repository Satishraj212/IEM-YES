@php
    $sbPendingEvents   = \App\Models\StudentEventSubmission::where('stage','pending')->count();
    $sbPendingActivity = \App\Models\ActivityLog::latest()->take(1)->count() ? \App\Models\ActivityLog::count() : 0;
    $sbPendingBudget   = \App\Models\StudentEventBudget::count();
@endphp
<aside class="sb">
    <div class="sb-brand">
        <div class="sb-logo">YES</div>
        <div>
            <div class="sb-title">YES IEM</div>
            <div class="sb-sub">Admin Panel</div>
        </div>
    </div>

    <div class="sb-sec">
        <div class="sb-lbl">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="ni {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg class="ni-icon" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>
        <a href="{{ route('admin.activity') }}" class="ni {{ request()->routeIs('admin.activity') ? 'active' : '' }}">
            <svg class="ni-icon" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            Activity Feed
            @if($sbPendingActivity > 0)<span class="nb red">{{ $sbPendingActivity > 99 ? '99+' : $sbPendingActivity }}</span>@endif
        </a>
    </div>

    <div class="sb-sec">
        <div class="sb-lbl">Events</div>
        <a href="{{ route('admin.official-events') }}" class="ni {{ request()->routeIs('admin.official-events') ? 'active' : '' }}">
            <svg class="ni-icon" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Official Events
        </a>
        <a href="{{ route('admin.student-section-events-admin') }}" class="ni {{ request()->routeIs('admin.student-section-events-admin') ? 'active' : '' }}">
            <svg class="ni-icon" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            Student Events
        </a>
        <a href="{{ route('admin.flagship-events') }}" class="ni {{ request()->routeIs('admin.flagship-events*') ? 'active' : '' }}">
            <svg class="ni-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            Flagship Events
        </a>
    </div>

    <div class="sb-sec">
        <div class="sb-lbl">Submissions</div>
        <a href="{{ route('admin.budget-requests') }}" class="ni {{ request()->routeIs('admin.budget-requests') ? 'active' : '' }}">
            <svg class="ni-icon" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            Budget Requests
            @if($sbPendingBudget > 0)<span class="nb amber">{{ $sbPendingBudget > 99 ? '99+' : $sbPendingBudget }}</span>@endif
        </a>
        <a href="{{ route('admin.annual-reports') }}" class="ni {{ request()->routeIs('admin.annual-reports') ? 'active' : '' }}">
            <svg class="ni-icon" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><polyline points="16 13 12 17 8 13"/><line x1="12" y1="17" x2="12" y2="7"/></svg>
            Annual Reports
        </a>
    </div>

    <div class="sb-sec">
        <div class="sb-lbl">Recognition</div>
        <a href="{{ route('admin.awards') }}" class="ni {{ request()->routeIs('admin.awards') ? 'active' : '' }}">
            <svg class="ni-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            Award Management
        </a>
    </div>

    <div class="sb-sec">
        <div class="sb-lbl">Network</div>
        <a href="{{ route('admin.branches') }}" class="ni {{ request()->routeIs('admin.branches') ? 'active' : '' }}">
            <svg class="ni-icon" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            State Branches
        </a>
        <a href="{{ route('admin.chapters') }}" class="ni {{ request()->routeIs('admin.chapters') ? 'active' : '' }}">
            <svg class="ni-icon" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Chapter Accounts
        </a>
    </div>

    <div class="sb-foot">
        <div class="av">{{ strtoupper(substr(auth()->user()->name ?? 'SA', 0, 2)) }}</div>
        <div style="flex:1">
            <div class="av-name">{{ auth()->user()->name ?? 'Super Admin' }}</div>
            <div class="av-role">{{ auth()->user()->role ?? 'National Board' }}</div>
        </div>
        <a href="{{ route('home') }}" title="Log out"
           style="color:rgba(255,255,255,.3);flex-shrink:0;display:flex;align-items:center;transition:color .2s"
           onmouseover="this.style.color='#f87171'" onmouseout="this.style.color='rgba(255,255,255,.3)'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        </a>
    </div>
</aside>