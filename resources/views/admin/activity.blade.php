@extends('admin.layouts.app')

@section('title', 'Activity Feed')

@section('topbar-actions')
<button class="btn-primary" onclick="markAllRead()">
    Mark All Read
</button>
@endsection

@section('content')

<div class="panel">
    <div class="ph">
        <div class="pt">Activity <em>Feed</em></div>
        <select class="fsel" id="typeFilter" onchange="filterLogs()">
            <option value="all">All Types</option>
            <option value="events">Events</option>
            <option value="members">Members</option>
            <option value="network">Network</option>
        </select>
    </div>
    <div class="pb" id="logList">

        <div class="act-item" data-type="events" data-read="false">
            <div class="act-dot" style="background:var(--green)">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div style="flex:1">
                <div class="act-txt"><strong>Nurul Ain Zainudin</strong> registered for Engineering Innovation Hackathon 2025</div>
                <span class="act-time">2 min ago · Student Events</span>
            </div>
            <div class="unread-dot"></div>
        </div>

        <div class="act-item" data-type="members" data-read="false">
            <div class="act-dot" style="background:var(--navy)">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div style="flex:1">
                <div class="act-txt"><strong>Ahmad Razif Hakim</strong> joined as Student Member — UTM Skudai</div>
                <span class="act-time">14 min ago · Members</span>
            </div>
            <div class="unread-dot"></div>
        </div>

        <div class="act-item" data-type="events" data-read="false">
            <div class="act-dot" style="background:var(--gold)">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div style="flex:1">
                <div class="act-txt">New event <strong>BIM &amp; Digital Engineering Workshop</strong> published</div>
                <span class="act-time">1 hour ago · Student Events</span>
            </div>
            <div class="unread-dot"></div>
        </div>

        <div class="act-item" data-type="events" data-read="false">
            <div class="act-dot" style="background:var(--red)">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div style="flex:1">
                <div class="act-txt"><strong>Renewable Energy Outreach Camp</strong> passed 50% capacity — 15 slots remaining</div>
                <span class="act-time">3 hours ago · Official Events</span>
            </div>
            <div class="unread-dot"></div>
        </div>

        <div class="act-item" data-type="members" data-read="false">
            <div class="act-dot" style="background:var(--navy)">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div style="flex:1">
                <div class="act-txt"><strong>Sabah Branch</strong> added 12 new student members</div>
                <span class="act-time">Yesterday 4:12 PM · Members</span>
            </div>
            <div class="unread-dot"></div>
        </div>

        <div class="act-item" data-type="network" data-read="false">
            <div class="act-dot" style="background:var(--green)">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div style="flex:1">
                <div class="act-txt"><strong>Johor Chapter</strong> endorsed the YES Declaration 2024</div>
                <span class="act-time">Yesterday 9:30 AM · Network</span>
            </div>
            <div class="unread-dot"></div>
        </div>

        <div class="act-item" data-type="events" data-read="true">
            <div class="act-dot" style="background:var(--gold)">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div style="flex:1">
                <div class="act-txt">Event <strong>STEM Career Fair 2025</strong> registration opened</div>
                <span class="act-time">2 days ago · Student Events</span>
            </div>
        </div>

        <div class="act-item" data-type="events" data-read="true">
            <div class="act-dot" style="background:var(--amber)">
                <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div style="flex:1">
                <div class="act-txt"><strong>Industry Collaboration Summit</strong> — seats filling fast (42% registered)</div>
                <span class="act-time">2 days ago · Official Events</span>
            </div>
        </div>

    </div>
</div>

@endsection

@section('styles')
<style>
.unread-dot{width:6px;height:6px;border-radius:50%;background:var(--gold);flex-shrink:0;margin-top:6px;align-self:flex-start}
.act-item[data-read="true"]{opacity:.65}
.act-item{transition:background .15s}
.act-item.read-now{opacity:.65}
</style>
@endsection

@section('scripts')
<script>
function filterLogs() {
    const val  = document.getElementById('typeFilter').value;
    document.querySelectorAll('.act-item').forEach(item => {
        item.style.display = (val === 'all' || item.dataset.type === val) ? 'flex' : 'none';
    });
}

function markAllRead() {
    document.querySelectorAll('.unread-dot').forEach(dot => dot.remove());
    document.querySelectorAll('.act-item[data-read="false"]').forEach(item => {
        item.dataset.read = 'true';
        item.classList.add('read-now');
    });
    showToast('All logs marked as read', 'success');
}
</script>
@endsection