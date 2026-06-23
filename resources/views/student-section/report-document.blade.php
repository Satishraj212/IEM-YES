<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
@php
    $m   = $d['meta'] ?? [];
    $ev  = $d['eventsSummary'] ?? [];
    $bg  = $d['budgetSummary'] ?? [];
    $rm  = fn ($v) => 'RM ' . number_format((float) $v, 2);
@endphp
<title>{{ $m['branch'] ?? 'Branch' }} — Annual Report {{ $m['report_year'] ?? $m['academic_year'] ?? '' }}</title>
<style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'DM Sans',Arial,sans-serif;color:#1a2332;background:#eef0f3;padding:24px;font-size:13px;line-height:1.5}
    .sheet{max-width:820px;margin:0 auto;background:#fff;padding:48px 56px;box-shadow:0 4px 24px rgba(0,0,0,.08)}
    .topbar{display:flex;justify-content:space-between;align-items:flex-start;border-bottom:3px solid #001f45;padding-bottom:18px;margin-bottom:28px}
    .eyebrow{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#c8a84b}
    h1{font-family:'Playfair Display',Georgia,serif;font-size:26px;color:#001f45;margin:4px 0}
    .sub{font-size:12px;color:#6b7280}
    .status-pill{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:4px 10px;border-radius:3px}
    .s-review{background:#fef3c7;color:#92400e}.s-approved{background:#dcfce7;color:#166534}.s-returned{background:#fee2e2;color:#991b1b}
    h2{font-family:'Playfair Display',Georgia,serif;font-size:16px;color:#001f45;margin:26px 0 12px;border-bottom:1px solid #e5e7eb;padding-bottom:6px}
    .grid{display:grid;gap:12px}
    .g4{grid-template-columns:repeat(4,1fr)}.g3{grid-template-columns:repeat(3,1fr)}.g2{grid-template-columns:repeat(2,1fr)}
    .kpi{border:1px solid #e5e7eb;padding:14px 16px;border-radius:4px;background:#fafafa}
    .kpi .lbl{font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#6b7280}
    .kpi .val{font-family:'Playfair Display',Georgia,serif;font-size:24px;font-weight:900;color:#001f45;margin-top:4px}
    .kpi .val.g{color:#166534}.kpi .val.a{color:#c8a84b}
    table{width:100%;border-collapse:collapse;font-size:12px;margin-top:6px}
    th{text-align:left;font-size:9px;text-transform:uppercase;letter-spacing:.5px;color:#6b7280;border-bottom:2px solid #e5e7eb;padding:6px 4px}
    td{padding:7px 4px;border-bottom:1px solid #f0f0f0}
    td.r,th.r{text-align:right}
    .bar{height:7px;background:#eef0f3;border-radius:4px;overflow:hidden}
    .bar > div{height:100%;background:#1d4ed8}
    .foot{margin-top:34px;border-top:1px solid #e5e7eb;padding-top:12px;font-size:10px;color:#9ca3af;display:flex;justify-content:space-between}
    .toolbar{max-width:820px;margin:0 auto 16px;display:flex;justify-content:flex-end;gap:8px}
    .btn{font-family:inherit;font-size:12px;font-weight:700;padding:8px 16px;border:none;border-radius:4px;cursor:pointer}
    .btn-print{background:#001f45;color:#fff}.btn-back{background:#fff;color:#001f45;border:1px solid #d1d5db}
    @media print{body{background:#fff;padding:0}.sheet{box-shadow:none;max-width:none;padding:28px}.toolbar{display:none}}
</style>
</head>
<body>
    <div class="toolbar">
        <a class="btn btn-back" href="{{ $back ?? route('student.reports') }}">← Back</a>
        <button class="btn btn-print" onclick="window.print()">Save as PDF / Print</button>
    </div>

    <div class="sheet">
        <div class="topbar">
            <div>
                <div class="eyebrow">YES IEM · Annual Chapter Report</div>
                <h1>{{ $m['branch'] ?? 'Branch' }}</h1>
                <div class="sub">{{ $m['institution'] ?? '' }} · Academic Year {{ $m['academic_year'] ?? '—' }}</div>
            </div>
            @isset($m['report_status'])
            @php $rs = $m['report_status']; @endphp
            <span class="status-pill {{ ['pending'=>'s-review','approved'=>'s-approved','rejected'=>'s-returned'][$rs] ?? 's-review' }}">
                {{ ['pending'=>'Under Review','approved'=>'Approved','rejected'=>'Returned'][$rs] ?? ucfirst($rs) }}
            </span>
            @endisset
        </div>

        <h2>At a Glance</h2>
        <div class="grid g4">
            <div class="kpi"><div class="lbl">Events Organised</div><div class="val">{{ $d['totalEvents'] ?? 0 }}</div></div>
            <div class="kpi"><div class="lbl">SDG Events</div><div class="val g">{{ $d['sdgEvents'] ?? 0 }}</div></div>
            <div class="kpi"><div class="lbl">Total Members</div><div class="val">{{ $d['totalMembers'] ?? 0 }}</div></div>
            <div class="kpi"><div class="lbl">Published Events</div><div class="val a">{{ $ev['published'] ?? 0 }}</div></div>
        </div>

        <h2>Events Pipeline</h2>
        <div class="grid g4">
            <div class="kpi"><div class="lbl">Approved</div><div class="val g">{{ $ev['approved'] ?? 0 }}</div></div>
            <div class="kpi"><div class="lbl">Past Events</div><div class="val">{{ $ev['past'] ?? 0 }}</div></div>
            <div class="kpi"><div class="lbl">Rejected</div><div class="val">{{ $ev['rejected'] ?? 0 }}</div></div>
            <div class="kpi"><div class="lbl">Drafts</div><div class="val">{{ $ev['draft'] ?? 0 }}</div></div>
        </div>

        @if(!empty($d['byCategory']))
        <h2>Events by Category</h2>
        @php $maxCat = max($d['byCategory']) ?: 1; @endphp
        <table>
            <tr><th>Category</th><th style="width:45%">Share</th><th class="r">Events</th></tr>
            @foreach($d['byCategory'] as $cat => $count)
            <tr><td>{{ $cat }}</td><td><div class="bar"><div style="width:{{ round($count / $maxCat * 100) }}%"></div></div></td><td class="r">{{ $count }}</td></tr>
            @endforeach
        </table>
        @endif

        <h2>Budget &amp; Funding</h2>
        <div class="grid g3">
            <div class="kpi"><div class="lbl">Requested</div><div class="val">{{ $rm($bg['requested'] ?? 0) }}</div></div>
            <div class="kpi"><div class="lbl">Approved</div><div class="val g">{{ $rm($bg['approved'] ?? 0) }}</div></div>
            <div class="kpi"><div class="lbl">Reimbursed</div><div class="val">{{ $rm($bg['reimbursed'] ?? 0) }}</div></div>
        </div>
        <table>
            <tr><th>Budget requests</th><td class="r">{{ $bg['requests'] ?? 0 }} total · {{ $bg['pending'] ?? 0 }} pending · {{ $bg['rejected'] ?? 0 }} rejected</td></tr>
            <tr><th>Unused (approved − reimbursed)</th><td class="r">{{ $rm($bg['unused'] ?? 0) }}</td></tr>
        </table>

        @if(!empty($d['membershipGrowth']))
        <h2>Membership Growth</h2>
        <table>
            <tr><th>Month</th><th class="r">Members</th><th class="r">New</th></tr>
            @foreach($d['membershipGrowth'] as $mm)
            <tr><td>{{ $mm['label'] }}</td><td class="r">{{ $mm['member_count'] }}</td><td class="r">{{ !is_null($mm['new_members'] ?? null) ? ($mm['new_members'] >= 0 ? '+'.$mm['new_members'] : $mm['new_members']) : '—' }}</td></tr>
            @endforeach
        </table>
        @endif

        @if(!empty($d['sdgBreakdown']))
        <h2>SDG Alignment</h2>
        <table>
            <tr><th>Goal</th><th class="r">Events</th></tr>
            @foreach($d['sdgBreakdown'] as $goal => $count)
            <tr><td>SDG {{ $goal }}</td><td class="r">{{ $count }}</td></tr>
            @endforeach
        </table>
        @endif

        <div class="foot">
            <span>Generated {{ isset($m['generated_at']) ? \Carbon\Carbon::parse($m['generated_at'])->format('j M Y, g:i a') : now()->format('j M Y') }}</span>
            <span>YES IEM Section Hub</span>
        </div>
    </div>
</body>
</html>
