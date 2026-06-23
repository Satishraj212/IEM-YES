@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('styles')
<style>
.oc-actions{display:flex;align-items:center;justify-content:flex-end;gap:5px;flex-shrink:0;white-space:nowrap}
.oc-btn-view{display:flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:4px;background:var(--navy-dark);color:#fff;text-decoration:none;transition:background .15s}
.oc-btn-view:hover{background:var(--navy-mid)}
.oc-btn-view svg{width:11px;height:11px;stroke:#fff;fill:none;stroke-width:2}
.oc-btn-audit{display:flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:4px;background:#fff;color:var(--grey);border:1px solid var(--light);text-decoration:none;transition:all .15s}
.oc-btn-audit:hover{border-color:var(--navy);color:var(--navy);background:#f0f4ff}
.oc-btn-audit svg{width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2}
.oc-btn-approve{display:flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:4px;background:#dcfce7;color:#166534;border:1px solid #bbf7d0;cursor:pointer;transition:all .15s}
.oc-btn-approve:hover{background:#16a34a;color:#fff;border-color:#16a34a}
.oc-btn-approve svg{width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5}
.oc-btn-reject{display:flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:4px;background:var(--red-l);color:var(--red);border:1px solid rgba(192,57,43,.2);cursor:pointer;transition:all .15s}
.oc-btn-reject:hover{background:var(--red);color:#fff;border-color:var(--red)}
.oc-btn-reject svg{width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5}
</style>
@endsection

@section('topbar-actions')
<a href="{{ route('admin.official-events') }}" class="btn-primary">
    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Create Event
</a>
@endsection

@section('content')

{{-- ── QUICK NAV CARDS (3) ── --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:22px">
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
    <a href="{{ route('admin.budget-requests') }}" style="text-decoration:none">
        <div class="sc">
            <div class="sc-bar" style="background:var(--amber)"></div>
            <div class="sc-lbl">Budget Requests</div>
            <div class="sc-val">{{ $counts['budget_pending'] }}</div>
            <div class="sc-sub">pending review</div>
        </div>
    </a>
</div>

{{-- ── ROW 1: Recent Official Events + Budget Stats ── --}}
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
                    <th style="width:44%">Event</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr></thead>
                <tbody>
                @forelse($recentEvents as $event)
                    @php
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
                        <td><span class="badge {{ $statusBadge }}">{{ ucfirst($event->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;color:var(--grey);padding:24px 0;font-size:12px">No events yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Incoming Org Charts --}}
    <div class="panel">
        <div class="ph">
            <div class="pt">Incoming <em>Org Charts</em></div>
            <a href="{{ route('admin.branches') }}" class="pa">Manage All →</a>
        </div>
        <div class="pb" style="padding:0 20px">
            @if($pendingOrgCharts->isEmpty())
                <div style="text-align:center;color:var(--grey);font-size:12px;padding:28px 20px">
                    <svg viewBox="0 0 24 24" style="width:28px;height:28px;stroke:var(--light);fill:none;stroke-width:1.5;display:block;margin:0 auto 8px"><polyline points="20 6 9 17 4 12"/></svg>
                    No pending submissions.
                </div>
            @else
                <table class="etbl" style="margin-top:4px">
                    <thead><tr>
                        <th>Branch</th>
                        <th style="width:64px">Year</th>
                        <th style="width:140px;text-align:right">Review</th>
                    </tr></thead>
                    <tbody>
                    @foreach($pendingOrgCharts as $chart)
                        <tr id="ocrow-{{ $chart->id }}">
                            <td>
                                <div class="et-name">{{ $chart->branch?->name ?? '—' }}</div>
                                <div class="et-sub">submitted {{ $chart->created_at->format('j M') }}</div>
                            </td>
                            <td class="et-sm">{{ $chart->academic_year }}</td>
                            <td style="white-space:nowrap">
                                <div class="oc-actions">
                                    <a href="{{ $chart->url }}" target="_blank" rel="noopener" class="oc-btn-view" title="View chart">
                                        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    @if($chart->branch_id)
                                    <a href="{{ route('admin.activity', ['branch' => $chart->branch_id]) }}" class="oc-btn-audit" title="View audit trail">
                                        <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                    </a>
                                    @endif
                                    <button class="oc-btn-approve" onclick="quickOcReview({{ $chart->id }},'approved')" title="Approve">
                                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                    </button>
                                    <button class="oc-btn-reject" onclick="quickOcReview({{ $chart->id }},'rejected')" title="Reject">
                                        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($counts['org_charts_pending'] > $pendingOrgCharts->count())
                    <div style="text-align:center;padding:10px;font-size:11px;color:var(--grey);border-top:1px solid var(--light)">
                        +{{ $counts['org_charts_pending'] - $pendingOrgCharts->count() }} more —
                        <a href="{{ route('admin.branches') }}" style="color:var(--navy);font-weight:600">view all</a>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

{{-- ── ROW 2: Student Submissions + Recent Budget Requests ── --}}
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
                            @if($sub->university_full && $sub->university_full !== $sub->university)
                            <div class="et-sub" style="font-size:10px;color:var(--grey)">{{ Str::limit($sub->university_full, 32) }}</div>
                            @endif
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

    {{-- Recent Budget Requests --}}
    <div class="panel">
        <div class="ph">
            <div class="pt">Budget <em>Requests</em></div>
            <a href="{{ route('admin.budget-requests') }}" class="pa">Review All →</a>
        </div>
        <div class="pb" style="padding:0 20px">
            @php
                $budgetStatusBadge  = ['pending'=>'b-pending','approved'=>'b-approved','rejected'=>'b-rejected'];
                $budgetStatusLabel  = ['pending'=>'Pending','approved'=>'Approved','rejected'=>'Rejected'];
            @endphp
            <table class="etbl" style="margin-top:4px">
                <thead><tr>
                    <th style="width:40%">Event</th>
                    <th>Requested</th>
                    <th>Status</th>
                    <th>Submitted</th>
                </tr></thead>
                <tbody>
                @forelse($recentBudgets as $budget)
                    <tr>
                        <td>
                            <div class="et-name">{{ Str::limit($budget->event?->title ?? '—', 28) }}</div>
                            <div class="et-sub">{{ $budget->event?->branch?->identity_name ?? '—' }}</div>
                            @if($budget->event?->branch?->identity_institution)
                            <div class="et-sub" style="font-size:10px;color:var(--grey)">{{ Str::limit($budget->event->branch->identity_institution, 32) }}</div>
                            @endif
                        </td>
                        <td class="et-sm" style="font-weight:600;color:var(--navy)">RM {{ number_format($budget->total_requested, 0) }}</td>
                        <td><span class="badge {{ $budgetStatusBadge[$budget->status] ?? 'b-pending' }}">{{ $budgetStatusLabel[$budget->status] ?? $budget->status }}</span></td>
                        <td class="et-sm">{{ $budget->created_at->format('j M') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;color:var(--grey);padding:24px 0;font-size:12px">No budget requests yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

async function quickOcReview(chartId, decision) {
    const row = document.getElementById('ocrow-' + chartId);
    if (!row) return;
    try {
        const r = await fetch(`/dashboard/admin/branches/org-charts/${chartId}/review`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ decision, comment: '' }),
        });
        if (!r.ok) throw new Error();
        row.style.transition = 'opacity .25s';
        row.style.opacity = '0';
        setTimeout(() => row.remove(), 260);
        showToast(
            decision === 'approved' ? 'Org chart approved' : 'Org chart rejected',
            decision === 'approved' ? 'success' : 'danger'
        );
    } catch {
        showToast('Could not save review — try from the Branches page.', 'danger');
    }
}
</script>
@endsection
