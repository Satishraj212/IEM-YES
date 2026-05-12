@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('topbar-actions')
<a href="{{ route('admin.official-events') }}" class="btn-primary">
    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Create Event
</a>
@endsection

@section('content')

{{-- ── QUICK NAV CARDS ── --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:22px">
    <a href="{{ route('admin.official-events') }}" style="text-decoration:none">
        <div class="sc">
            <div class="sc-bar" style="background:var(--navy)"></div>
            <div class="sc-lbl">Official Events</div>
            <div class="sc-val">{{ $counts['official'] }}</div>
            <div class="sc-sub">{{ $counts['official_open'] }} open now</div>
        </div>
    </a>
    <a href="{{ route('admin.student-section-events-admin') }}" style="text-decoration:none">
        <div class="sc">
            <div class="sc-bar" style="background:var(--gold)"></div>
            <div class="sc-lbl">Student Submissions</div>
            <div class="sc-val">{{ $counts['student_pending'] }}</div>
            <div class="sc-sub">awaiting review</div>
        </div>
    </a>
    <a href="{{ route('admin.flagship-events') }}" style="text-decoration:none">
        <div class="sc">
            <div class="sc-bar" style="background:var(--amber)"></div>
            <div class="sc-lbl">Flagship Events</div>
            <div class="sc-val">{{ $counts['flagship'] }}</div>
            <div class="sc-sub">active this year</div>
        </div>
    </a>
    <a href="{{ route('admin.activity') }}" style="text-decoration:none">
        <div class="sc">
            <div class="sc-bar" style="background:var(--red)"></div>
            <div class="sc-lbl">Activity Feed</div>
            <div class="sc-val">8</div>
            <div class="sc-sub">unread events</div>
        </div>
    </a>
</div>

{{-- ── ROW 1: Recent Official Events + Activity Feed ── --}}
<div style="display:grid;grid-template-columns:1.6fr 1fr;gap:16px;margin-bottom:16px">

    {{-- Recent Official Events --}}
    <div class="panel">
        <div class="ph">
            <div class="pt">Recent <em>Official Events</em></div>
            <a href="{{ route('admin.official-events') }}" class="pa">Manage All →</a>
        </div>
        <div class="pb" style="padding:0 20px">
            <table class="etbl" style="margin-top:4px">
                <thead><tr>
                    <th style="width:40%">Event</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Seats</th>
                    <th>Status</th>
                </tr></thead>
                <tbody>
                @forelse($recentEvents as $event)
                    @php
                        $pct        = $event->total_seats ? round($event->registered_count / $event->total_seats * 100) : 0;
                        $fillClass  = $pct >= 100 ? 'full' : ($pct >= 75 ? 'warn' : '');
                        $statusBadge = ['open' => 'b-open', 'upcoming' => 'b-upcoming', 'past' => 'b-past'][$event->status] ?? 'b-past';
                        $catClasses  = ['Board Meeting'=>'b-board','Retreat'=>'b-retreat','Summit'=>'b-summit','Forum'=>'b-forum','Gala / Dinner'=>'b-gala','Review'=>'b-review'];
                        $catBadge    = $catClasses[$event->category] ?? 'b-board';
                    @endphp
                    <tr>
                        <td>
                            <div class="et-name">{{ $event->name }}</div>
                            <div class="et-sub">{{ $event->location }}</div>
                        </td>
                        <td><span class="badge {{ $catBadge }}">{{ $event->category }}</span></td>
                        <td class="et-sm">{{ $event->start_date->format('j M Y') }}</td>
                        <td>
                            @if($event->total_seats)
                                <div style="font-size:11px;font-weight:600;color:var(--navy)">{{ $event->registered_count }} / {{ $event->total_seats }}</div>
                                <div class="sbar"><div class="sfill {{ $fillClass }}" style="width:{{ $pct }}%"></div></div>
                            @else
                                <div style="font-size:11px;color:var(--grey)">—</div>
                            @endif
                        </td>
                        <td><span class="badge {{ $statusBadge }}">{{ ucfirst($event->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;color:var(--grey);padding:24px 0;font-size:12px">No events yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Activity Feed preview --}}
    <div class="panel">
        <div class="ph">
            <div class="pt">Activity <em>Feed</em></div>
            <a href="{{ route('admin.activity') }}" class="pa">View All →</a>
        </div>
        <div class="pb">
            @forelse($recentActivity as $log)
                <div class="act-item">
                    <div class="act-dot" style="background:{{ $log->dot_colour }}">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/></svg>
                    </div>
                    <div>
                        <div class="act-txt">{{ $log->title }}</div>
                        <span class="act-time">{{ $log->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @empty
                <div style="text-align:center;color:var(--grey);font-size:12px;padding:20px 0">No recent activity.</div>
            @endforelse
        </div>
    </div>
</div>

{{-- ── ROW 2: Student Submissions preview + Flagship Events ── --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">

    {{-- Student Submissions --}}
    <div class="panel">
        <div class="ph">
            <div class="pt">Student <em>Submissions</em></div>
            <a href="{{ route('admin.student-section-events-admin') }}" class="pa">Review All →</a>
        </div>
        <div class="pb" style="padding:0 20px">
            @php
                $stageBadge = ['pending'=>'b-pending','ppw'=>'b-ppw','budget'=>'b-budget','approved'=>'b-approved','rejected'=>'b-rejected'];
                $stageLabel = ['pending'=>'Pending','ppw'=>'PPW Screen','budget'=>'Budget','approved'=>'Approved','rejected'=>'Rejected'];
                $catBadges  = ['hackathon'=>'b-hackathon','career'=>'b-career','webinar'=>'b-webinar','workshop'=>'b-workshop','competition'=>'b-competition'];
            @endphp
            <table class="etbl" style="margin-top:4px">
                <thead><tr>
                    <th style="width:44%">Event</th>
                    <th>Category</th>
                    <th>Stage</th>
                    <th>Submitted</th>
                </tr></thead>
                <tbody>
                @forelse($recentSubmissions as $sub)
                    <tr>
                        <td>
                            <div class="et-name">{{ Str::limit($sub->title, 32) }}</div>
                            <div class="et-sub">{{ $sub->university }}</div>
                        </td>
                        <td><span class="badge {{ $catBadges[$sub->category] ?? 'b-workshop' }}">{{ $sub->category }}</span></td>
                        <td><span class="badge {{ $stageBadge[$sub->stage] ?? 'b-pending' }}">{{ $stageLabel[$sub->stage] ?? $sub->stage }}</span></td>
                        <td class="et-sm">{{ $sub->created_at->format('j M') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;color:var(--grey);padding:24px 0;font-size:12px">No submissions yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Flagship Events --}}
    <div class="panel">
        <div class="ph">
            <div class="pt">Flagship <em>Events</em></div>
            <a href="{{ route('admin.flagship-events') }}" class="pa">Manage →</a>
        </div>
        <div class="pb">
            @forelse($flagshipEvents as $flagship)
            @php
                $fStatusBadge = ['planning'=>'b-upcoming','upcoming'=>'b-upcoming','open'=>'b-open','past'=>'b-past'][$flagship->status] ?? 'b-upcoming';
                $accentColor  = $loop->first ? 'var(--gold)' : 'var(--navy)';
            @endphp
            <div style="padding:12px 0;border-bottom:1px solid var(--light);{{ $loop->last ? 'border-bottom:none' : '' }}">
                <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:6px">
                    <div style="font-size:13px;font-weight:700;color:var(--navy)">
                        <span style="color:{{ $accentColor }}">{{ $flagship->short_name }}</span>
                        {{ $flagship->year }}
                    </div>
                    <span class="badge {{ $fStatusBadge }}">{{ ucfirst($flagship->status) }}</span>
                </div>
                <div style="font-size:11px;color:var(--grey);line-height:1.7">
                    {{ $flagship->full_name }}<br>
                    @if($flagship->event_date)
                        <span style="font-weight:600;color:var(--navy)">{{ $flagship->event_date }}</span> ·
                    @endif
                    {{ number_format($flagship->expected_delegates) }} delegates expected
                </div>
            </div>
            @empty
                <div style="text-align:center;color:var(--grey);font-size:12px;padding:24px 0">No flagship events yet.</div>
            @endforelse
        </div>
    </div>
</div>

{{-- ── ROW 3: Top Branches + Settings quick links ── --}}
<div style="display:grid;grid-template-columns:1.6fr 1fr;gap:16px">

    {{-- Top Branches --}}
    <div class="panel">
        <div class="ph">
            <div class="pt">Top <em>Branches</em></div>
            <a href="{{ route('admin.branches') }}" class="pa">All Branches →</a>
        </div>
        <div class="pb">
            @php $maxMembers = $topBranches->max('member_count') ?: 1; @endphp
            @foreach($topBranches as $branch)
            <div class="br-item">
                <div class="br-dot" style="background:{{ $branch->color ?? 'var(--navy)' }}"></div>
                <div class="br-name">{{ $branch->name }}</div>
                <div class="br-bar">
                    <div class="br-fill" style="width:{{ round($branch->member_count / $maxMembers * 100) }}%;background:{{ $branch->color ?? 'var(--navy)' }}"></div>
                </div>
                <div class="br-cnt">{{ number_format($branch->member_count) }} members</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="panel">
        <div class="ph">
            <div class="pt">Quick <em>Links</em></div>
        </div>
        <div class="pb" style="padding:10px 20px">
            @php
                $links = [
                    [
                        'route' => 'admin.activity',
                        'icon'  => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
                        'label' => 'Activity Feed',
                        'sub'   => '8 unread events',
                        'color' => 'var(--red)',
                    ],
                    [
                        'route' => 'admin.official-events',
                        'icon'  => '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>',
                        'label' => 'Official Events',
                        'sub'   => $counts['official'] . ' total · ' . $counts['official_open'] . ' open',
                        'color' => 'var(--navy)',
                    ],
                    [
                        'route' => 'admin.student-section-events-admin',
                        'icon'  => '<path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>',
                        'label' => 'Student Events',
                        'sub'   => $counts['student_pending'] . ' pending review',
                        'color' => 'var(--gold)',
                    ],
                    [
                        'route' => 'admin.flagship-events',
                        'icon'  => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
                        'label' => 'Flagship Events',
                        'sub'   => $counts['flagship'] . ' active',
                        'color' => 'var(--amber)',
                    ],
                    [
                        'route' => 'admin.branches',
                        'icon'  => '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
                        'label' => 'State Branches',
                        'sub'   => '21 institutions across 3 states',
                        'color' => 'var(--green)',
                    ],
                ];
            @endphp
            @foreach($links as $link)
            <a href="{{ route($link['route']) }}" style="display:flex;align-items:center;gap:12px;padding:9px 0;border-bottom:1px solid var(--light);text-decoration:none;{{ $loop->last ? 'border-bottom:none' : '' }}">
                <div style="width:30px;height:30px;border-radius:50%;background:{{ $link['color'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:#fff;fill:none;stroke-width:1.8">{!! $link['icon'] !!}</svg>
                </div>
                <div>
                    <div style="font-size:12px;font-weight:600;color:var(--navy)">{{ $link['label'] }}</div>
                    <div style="font-size:10px;color:var(--grey);margin-top:1px">{{ $link['sub'] }}</div>
                </div>
                <svg viewBox="0 0 24 24" style="width:12px;height:12px;stroke:var(--grey);fill:none;stroke-width:2;margin-left:auto;flex-shrink:0"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
            @endforeach
        </div>
    </div>

</div>

@endsection