@extends('admin.layouts.app')

@section('title', 'Annual Reports')
@section('page-title', 'Annual')
@section('page-subtitle', 'Reports')
@section('page-desc', 'Review and approve student chapter annual report submissions · ' . now()->format('j F Y'))

@section('styles')
<style>
/* ── RETURN MODAL ── */
.bmodal-ar{display:none;position:fixed;inset:0;background:rgba(0,31,69,.5);z-index:1000;align-items:center;justify-content:center;padding:20px}
.bmodal-ar.open{display:flex}
.bmodal-ar-box{background:#fff;border-radius:6px;padding:22px;max-width:440px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.3)}

/* ── FILTER ── */
.filter-row{display:flex;gap:9px;align-items:center;margin-bottom:16px;flex-wrap:wrap}

/* ── REPORT TABLE ── */
.report-panel{background:#fff;border:1px solid var(--light);border-radius:4px;overflow:hidden}
.report-table{width:100%;border-collapse:collapse}
.report-table th{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);text-align:left;padding:11px 20px;border-bottom:2px solid var(--light);background:var(--off)}
.report-table td{padding:14px 20px;border-bottom:1px solid var(--light);vertical-align:middle}
.report-table tr:last-child td{border-bottom:none}
.report-table tr:hover td{background:#fafaf8}
.chapter-name{font-size:13px;font-weight:700;color:var(--navy)}
.chapter-uni{font-size:11px;color:var(--grey);margin-top:2px}

/* ── FILE PREVIEW ── */
.file-info{display:flex;align-items:center;gap:9px}
.fi-icon{width:32px;height:32px;background:var(--off);border:1px solid var(--light);border-radius:3px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.fi-icon svg{width:14px;height:14px;stroke:var(--navy);fill:none;stroke-width:2}
.fi-name{font-size:11px;font-weight:600;color:var(--navy)}
.fi-meta{font-size:10px;color:var(--grey);margin-top:2px}

/* ── ACTION CELL ── */
.act-cell{display:flex;gap:6px;align-items:center;justify-content:flex-end}

/* ── SLIDE PANEL OVERRIDES ── */
.rp-field{margin-bottom:14px}
.rp-lbl{font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:5px}
.rp-val{font-size:12px;color:#333;line-height:1.55}

/* ── PROGRESS PIPELINE ── */
.pipeline-steps{display:flex;align-items:center;gap:0;margin:16px 0}
.ps{display:flex;flex-direction:column;align-items:center;flex:1;position:relative}
.ps::after{content:'';position:absolute;top:14px;left:50%;width:100%;height:2px;background:var(--light);z-index:0}
.ps:last-child::after{display:none}
.ps-dot{width:28px;height:28px;border-radius:50%;border:2px solid var(--light);background:#fff;display:flex;align-items:center;justify-content:center;z-index:1;position:relative}
.ps-dot svg{width:12px;height:12px;stroke:var(--grey);fill:none;stroke-width:2.5}
.ps-dot.done{background:var(--green);border-color:var(--green)}
.ps-dot.done svg{stroke:#fff}
.ps-dot.active{background:var(--gold);border-color:var(--gold)}
.ps-dot.active svg{stroke:var(--navy-dark)}
.ps-lbl{font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--grey);margin-top:6px;text-align:center;max-width:72px;line-height:1.3}
.ps-lbl.done{color:var(--green)}
.ps-lbl.active{color:var(--gold)}
</style>
@endsection

@section('topbar-actions')
<button class="btn-primary" onclick="showToast('Reminder emails sent to all pending chapters.','success')">
    <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
    Send Reminders
</button>
@endsection

@section('content')

{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:22px">
    <div class="sc">
        <div class="sc-bar" style="background:var(--blue)"></div>
        <div class="sc-lbl">Under Review</div>
        <div class="sc-val">{{ $counts['pending'] }}</div>
        <div class="sc-sub">Awaiting admin decision</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--green)"></div>
        <div class="sc-lbl">Approved</div>
        <div class="sc-val">{{ $counts['approved'] }}</div>
        <div class="sc-sub">Signed off</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--red)"></div>
        <div class="sc-lbl">Returned</div>
        <div class="sc-val">{{ $counts['rejected'] }}</div>
        <div class="sc-sub">Sent back to chapter</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--navy)"></div>
        <div class="sc-lbl">Total Submitted</div>
        <div class="sc-val">{{ $counts['pending'] + $counts['approved'] + $counts['rejected'] }}</div>
        <div class="sc-sub">All reports received</div>
    </div>
</div>

{{-- Cycle selector --}}
<div class="filter-row">
    <select class="fsel" id="cycle-sel" onchange="filterTable()">
        <option value="2025">Academic Year 2024/25</option>
        <option value="2024">Academic Year 2023/24</option>
        <option value="2023">Academic Year 2022/23</option>
    </select>
    <div class="si-wrap" style="flex:1;max-width:300px">
        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Search chapter…" oninput="filterTable()"/>
    </div>
    <select class="fsel" onchange="filterTable()">
        <option value="">All Statuses</option>
        <option value="pending">Pending Upload</option>
        <option value="review">Under Review</option>
        <option value="approved">Approved</option>
        <option value="rejected">Returned</option>
    </select>
</div>

{{-- Reports Table --}}
<div class="report-panel">
    <table class="report-table" id="report-table">
        <thead>
            <tr>
                <th>Chapter</th>
                <th>Year</th>
                <th>Submitted</th>
                <th style="text-align:center">Status</th>
                <th style="text-align:right">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($reports as $report)
        @php
            $badges = [
                'pending'  => ['b-pending',  'Under Review'],
                'approved' => ['b-approved', 'Approved'],
                'rejected' => ['b-rejected', 'Returned'],
            ];
            [$badgeClass, $badgeText] = $badges[$report->status] ?? ['b-pending', ucfirst($report->status)];
        @endphp
        <tr data-status="{{ $report->status }}">
            <td>
                <div class="chapter-name">{{ $report->branch?->identity_name ?? $report->branch?->name ?? '—' }}</div>
                <div class="chapter-uni">{{ $report->branch?->institution }}</div>
            </td>
            <td class="et-sm">{{ $report->year }}</td>
            <td class="et-sm">{{ optional($report->submitted_at ?? $report->created_at)->format('j M Y') }}</td>
            <td style="text-align:center">
                <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
            </td>
            <td>
                <div class="act-cell">
                    <a class="abtn" title="View report" href="{{ route('admin.annual-reports.view', $report) }}">
                        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </a>
                    @if($report->status === 'pending')
                    <form method="POST" action="{{ route('admin.annual-reports.approve', $report) }}" style="display:inline">
                        @csrf
                        <button type="submit" class="btn-approve" style="padding:6px 12px;font-size:9px"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg> Approve</button>
                    </form>
                    <button class="btn-reject" style="padding:6px 12px;font-size:9px" onclick="openReturn('{{ route('admin.annual-reports.reject', $report) }}', @js($report->branch?->name))"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Return</button>
                    @elseif($report->status === 'rejected')
                    <span style="font-size:10px;color:var(--grey)">Returned · awaiting resubmission</span>
                    @else
                    <span style="font-size:10px;color:var(--grey)">Approved {{ optional($report->reviewed_at)->format('j M Y') }}</span>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:40px;color:var(--grey);font-size:13px">No annual reports submitted yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:14px">{{ $reports->links() }}</div>

{{-- Return-to-chapter modal --}}
<div id="returnModal" class="bmodal-ar">
    <form method="POST" id="returnForm" class="bmodal-ar-box">
        @csrf
        <div style="font-size:14px;font-weight:700;color:var(--navy);margin-bottom:4px" id="returnTitle">Return report to chapter</div>
        <div style="font-size:11px;color:var(--grey);margin-bottom:12px">This feedback is sent to the chapter so they can revise the stats and resubmit.</div>
        <textarea name="notes" id="returnNotes" required placeholder="What needs to be corrected?…" style="width:100%;border:1px solid var(--light);background:var(--off);padding:10px;font-family:inherit;font-size:12px;color:var(--navy);outline:none;border-radius:3px;min-height:90px;resize:vertical"></textarea>
        <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:12px">
            <button type="button" onclick="closeReturn()" style="background:none;border:1px solid var(--light);color:var(--grey);padding:8px 14px;font-size:11px;font-weight:700;cursor:pointer;border-radius:3px">Cancel</button>
            <button type="submit" class="btn-reject">Return Report</button>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
function openReturn(action, chapter) {
    const f = document.getElementById('returnForm');
    f.action = action;
    document.getElementById('returnTitle').textContent = 'Return report' + (chapter ? ' to ' + chapter : '');
    document.getElementById('returnNotes').value = '';
    document.getElementById('returnModal').classList.add('open');
    setTimeout(() => document.getElementById('returnNotes').focus(), 50);
}
function closeReturn() { document.getElementById('returnModal').classList.remove('open'); }

function filterTable() {
    const q      = document.querySelector('.si-wrap input').value.toLowerCase();
    const status = document.querySelectorAll('.fsel')[1].value;
    document.querySelectorAll('#report-table tbody tr').forEach(row => {
        const name = row.querySelector('.chapter-name');
        if (!name) return;
        const matchQ = !q || name.textContent.toLowerCase().includes(q);
        const matchS = !status || row.dataset.status === status;
        row.style.display = (matchQ && matchS) ? '' : 'none';
    });
}
</script>
@endsection
