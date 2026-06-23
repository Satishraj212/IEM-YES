@extends('admin.layouts.app')

@section('title', 'Budget Requests')
@section('page-title', 'Budget')
@section('page-subtitle', 'Requests')
@section('page-desc', 'Review and action student chapter budget submissions · ' . now()->format('j F Y'))

@section('styles')
<style>
/* ── FILTER ROW ── */
.filter-row{display:flex;gap:9px;align-items:center;margin-bottom:16px;flex-wrap:wrap}
.filter-row .si-wrap{max-width:280px}

/* ── REQUEST CARDS ── */
.req-list{display:flex;flex-direction:column;gap:12px}
.req-card{background:#fff;border:1px solid var(--light);border-radius:4px;overflow:hidden;transition:box-shadow .2s}
.req-card:hover{box-shadow:0 3px 16px rgba(0,31,69,.07)}
.req-card-head{display:grid;grid-template-columns:1fr auto;gap:16px;align-items:center;padding:16px 20px;cursor:pointer;user-select:none}
.req-left{}
.req-title{font-size:13px;font-weight:700;color:var(--navy)}
.req-meta{display:flex;gap:14px;align-items:center;flex-wrap:wrap;margin-top:4px}
.req-meta-item{display:flex;align-items:center;gap:4px;font-size:11px;color:var(--grey)}
.req-meta-item svg{width:11px;height:11px;stroke:var(--grey);fill:none;stroke-width:2}
.req-right{display:flex;align-items:center;gap:8px}
.req-amount{font-family:'Playfair Display',serif;font-size:18px;font-weight:900;color:var(--navy);white-space:nowrap}
.req-chevron{width:16px;height:16px;stroke:var(--grey);fill:none;stroke-width:2;transition:transform .25s;flex-shrink:0}
.req-chevron.open{transform:rotate(180deg)}

/* ── EXPAND BODY ── */
.req-body{display:none;border-top:1px solid var(--light)}
.req-body.open{display:block}
.req-grid{display:grid;grid-template-columns:1fr 1fr 1fr;border-bottom:1px solid var(--light)}
.req-col{padding:18px 20px;border-right:1px solid var(--light)}
.req-col:last-child{border-right:none}
.rc-label{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);margin-bottom:10px}

/* ── BUDGET LINE TABLE ── */
.blt{width:100%;border-collapse:collapse;font-size:11px}
.blt td{padding:5px 0;border-bottom:1px solid var(--light);color:#444}
.blt tr:last-child td{border-bottom:none;font-weight:700;color:var(--navy);font-size:12px}
.blt td:last-child{text-align:right;font-weight:600;color:var(--navy-dark)}

/* ── REVIEW FOOTER ── */
.req-foot{padding:14px 20px;background:#fafaf8;border-top:1px solid var(--light);display:flex;align-items:flex-start;gap:14px;flex-wrap:wrap}
.req-comment{flex:1;min-width:200px}
.req-comment label{display:block;font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:5px}
.req-comment textarea{width:100%;border:1px solid var(--light);background:var(--off);padding:8px 12px;font-family:'DM Sans',sans-serif;font-size:11px;color:var(--navy);outline:none;border-radius:3px;min-height:64px;resize:vertical}
.req-comment textarea:focus{border-color:var(--navy);background:#fff}
.req-actions{display:flex;align-items:flex-end;gap:8px;flex-shrink:0;padding-top:18px}
.req-audit{border-top:1px solid var(--light);margin-top:16px;padding-top:12px}
.req-audit-link{display:inline-flex;align-items:center;gap:7px;font-size:11px;font-weight:600;color:var(--grey);text-decoration:none;transition:color .15s}
.req-audit-link:hover{color:var(--navy)}
.req-audit-link svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:1.8}

/* ── STATUS BADGE COLUMN ── */
.status-pending{background:var(--amber-l);color:var(--amber);border:1px solid var(--amber-border)}
.status-approved{background:var(--green-bg);color:#166534;border:1px solid var(--green-border)}
.status-rejected{background:var(--red-l);color:var(--red);border:1px solid rgba(192,57,43,.15)}
.status-info{background:var(--blue-l);color:var(--blue);border:1px solid rgba(29,78,216,.2)}

/* ── PIPELINE ── */
.bpipe{display:flex;align-items:flex-start;padding:18px 20px 4px}
.bp{display:flex;flex-direction:column;align-items:center;flex:1;position:relative}
.bp::after{content:'';position:absolute;top:13px;left:50%;width:100%;height:2px;background:var(--light);z-index:0}
.bp:last-child::after{display:none}
.bp-dot{width:26px;height:26px;border-radius:50%;border:2px solid var(--light);background:#fff;display:flex;align-items:center;justify-content:center;z-index:1}
.bp-dot svg{width:12px;height:12px;stroke:var(--grey);fill:none;stroke-width:2.5}
.bp-dot.done{background:var(--green);border-color:var(--green)}
.bp-dot.done svg{stroke:#fff}
.bp-dot.active{background:var(--gold);border-color:var(--gold)}
.bp-dot.active svg{stroke:var(--navy-dark)}
.bp-dot.rejected{background:var(--red);border-color:var(--red)}
.bp-dot.rejected svg{stroke:#fff}
.bp-lbl{font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--grey);margin-top:6px}
.bp-lbl.done{color:#166534}.bp-lbl.active{color:var(--amber)}.bp-lbl.rejected{color:var(--red)}

/* ── DOCUMENTS ── */
.req-docs{padding:16px 20px;border-bottom:1px solid var(--light)}
.doc-strip{display:flex;gap:10px;flex-wrap:wrap}
.doc-chip{display:flex;align-items:center;gap:9px;background:var(--off);border:1px solid var(--light);border-radius:3px;padding:9px 12px;text-decoration:none;transition:border-color .15s,background .15s}
.doc-chip:hover{border-color:var(--navy);background:#fff}
.doc-chip svg{width:15px;height:15px;stroke:var(--navy);fill:none;stroke-width:2;flex-shrink:0}
.doc-chip span{display:flex;flex-direction:column;line-height:1.3}
.doc-chip strong{font-size:11px;color:var(--navy)}
.doc-chip em{font-size:10px;color:var(--grey);font-style:normal}

/* ── REJECT MODAL ── */
.bmodal{display:none;position:fixed;inset:0;background:rgba(0,31,69,.5);z-index:1000;align-items:center;justify-content:center;padding:20px}
.bmodal.open{display:flex}
.bmodal-box{background:#fff;border-radius:6px;padding:22px;max-width:440px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.3)}

/* ── EMPTY ── */
.empty-state{text-align:center;padding:60px 20px;background:#fff;border:1px solid var(--light);border-radius:4px}
.empty-state svg{width:44px;height:44px;stroke:var(--light);fill:none;stroke-width:1.5;margin:0 auto 14px;display:block}
.empty-state p{font-size:13px;color:var(--grey)}
</style>
@endsection

@section('topbar-actions')
<a href="{{ route('admin.annual-reports') }}" class="btn-primary">
    <svg viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
    Refresh
</a>
@endsection

@section('content')

{{-- Summary Stats --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:22px">
    <div class="sc">
        <div class="sc-bar" style="background:var(--amber)"></div>
        <div class="sc-lbl">Pending Review</div>
        <div class="sc-val">{{ $stats['pending'] }}</div>
        <div class="sc-sub">Awaiting admin action</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--green)"></div>
        <div class="sc-lbl">Approved</div>
        <div class="sc-val">{{ $stats['approved'] }}</div>
        <div class="sc-sub">All time</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--red)"></div>
        <div class="sc-lbl">Rejected</div>
        <div class="sc-val">{{ $stats['rejected'] }}</div>
        <div class="sc-sub">Returned for revision</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--navy)"></div>
        <div class="sc-lbl">Total Approved (RM)</div>
        <div class="sc-val">{{ $stats['total_approved_rm'] >= 1000 ? number_format($stats['total_approved_rm'] / 1000, 1) . 'k' : number_format($stats['total_approved_rm'], 0) }}</div>
        <div class="sc-sub">RM {{ number_format($stats['unused_rm'], 2) }} unused (approved − reimbursed)</div>
    </div>
</div>

{{-- Filter Row --}}
<div class="filter-row">
    <div class="si-wrap" style="flex:1;max-width:320px">
        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Search by chapter, event name…" id="req-search" oninput="filterRequests()"/>
    </div>
    <select class="fsel" id="req-status" onchange="filterRequests()">
        <option value="">All Statuses</option>
        <option value="pending">Pending</option>
        <option value="approved">Approved</option>
        <option value="rejected">Rejected</option>
    </select>
    <select class="fsel" id="req-sort" onchange="filterRequests()">
        <option value="newest">Newest First</option>
        <option value="oldest">Oldest First</option>
        <option value="amount-high">Amount: High → Low</option>
        <option value="amount-low">Amount: Low → High</option>
    </select>
</div>

{{-- Request List --}}
<div class="req-list" id="req-list">

@forelse ($budgets as $budget)
@php
    $chapterName  = $budget->event?->branch?->identity_name ?? 'Unknown Chapter';
    $chapterInst  = $budget->event?->branch?->identity_institution;
    $chapterSlug  = strtolower(str_replace([' ', '_'], '-', $chapterName));
    $amountNum    = (float) ($budget->status === 'approved' ? ($budget->total_approved ?? $budget->total_requested) : $budget->total_requested);
    $badgeClass   = match($budget->status) { 'approved' => 'b-approved', 'rejected' => 'b-rejected', default => 'b-pending' };
    $badgeLabel   = match($budget->status) { 'approved' => 'Approved', 'rejected' => 'Rejected', default => 'Pending Review' };
    $amountColor  = match($budget->status) { 'approved' => 'color:var(--green)', 'rejected' => 'color:var(--red)', default => '' };
    $amountLabel  = $budget->status === 'approved' ? 'Approved' : 'Requested';
@endphp
<div class="req-card" data-status="{{ $budget->status }}" data-chapter="{{ $chapterSlug }}" data-amount="{{ $amountNum }}">
    <div class="req-card-head" onclick="toggleReq(this)">
        <div class="req-left">
            <div class="req-title">{{ $budget->event?->title ?? 'Untitled Event' }} — Budget Request</div>
            <div class="req-meta">
                <span class="req-meta-item">
                    <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    {{ $chapterName }}@if($chapterInst) <span style="color:var(--grey)">· {{ $chapterInst }}</span>@endif
                </span>
                <span class="req-meta-item">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Submitted {{ $budget->created_at->format('j M Y') }}
                    @if($budget->status !== 'pending') · {{ ucfirst($budget->status) }} {{ $budget->updated_at->format('j M Y') }}@endif
                </span>
                <span class="badge {{ $badgeClass }}" style="font-size:9px">{{ $badgeLabel }}</span>
            </div>
        </div>
        <div class="req-right">
            <div>
                <div style="font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);text-align:right;margin-bottom:2px">{{ $amountLabel }}</div>
                <div class="req-amount" style="{{ $amountColor }}">RM {{ number_format($amountNum, 2) }}</div>
            </div>
            <svg class="req-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
        </div>
    </div>

    <div class="req-body">
        {{-- Shared 4-stage pipeline: Submitted → Under Review → Approved → Reimbursed --}}
        @php
            $stage = $budget->stage; // 'review' | 'approved' | 'reimbursed' | 'rejected'
            $apCls = $stage==='approved' ? 'active' : (in_array($stage,['reimbursed']) ? 'done' : '');
            $rbCls = $stage==='reimbursed' ? 'done' : '';
        @endphp
        <div class="bpipe">
            <div class="bp"><div class="bp-dot done"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><div class="bp-lbl done">Submitted</div></div>
            <div class="bp"><div class="bp-dot {{ $stage==='review' ? 'active' : 'done' }}"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/></svg></div><div class="bp-lbl {{ $stage==='review' ? 'active' : 'done' }}">Under Review</div></div>
            @if($stage==='rejected')
            <div class="bp"><div class="bp-dot rejected"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div><div class="bp-lbl rejected">Rejected</div></div>
            <div class="bp"><div class="bp-dot"><svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg></div><div class="bp-lbl">Reimbursed</div></div>
            @else
            <div class="bp"><div class="bp-dot {{ $apCls }}"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><div class="bp-lbl {{ $apCls }}">Approved</div></div>
            <div class="bp"><div class="bp-dot {{ $rbCls }}"><svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg></div><div class="bp-lbl {{ $rbCls }}">Reimbursed</div></div>
            @endif
        </div>
        <div class="req-grid">
            <div class="req-col">
                <div class="rc-label">Event Details</div>
                <div style="font-size:12px;color:#444;line-height:1.65">
                    <div style="margin-bottom:6px"><strong style="color:var(--navy)">Event:</strong> {{ $budget->event?->title ?? '—' }}</div>
                    @if($budget->event?->start_date)
                    <div style="margin-bottom:6px"><strong style="color:var(--navy)">Date:</strong> {{ $budget->event->start_date->format('j M Y') }}@if($budget->event->end_date && $budget->event->end_date->ne($budget->event->start_date)) – {{ $budget->event->end_date->format('j M Y') }}@endif</div>
                    @endif
                    @if($budget->event?->venue)
                    <div style="margin-bottom:6px"><strong style="color:var(--navy)">Venue:</strong> {{ $budget->event->venue }}</div>
                    @endif
                    @if($budget->event?->category)
                    <div style="margin-bottom:6px"><strong style="color:var(--navy)">Type:</strong> {{ $budget->event->category }}</div>
                    @endif
                    @if($budget->category)
                    <div><strong style="color:var(--navy)">Budget Category:</strong> {{ $budget->category }}</div>
                    @endif
                    @if($budget->justification)
                    <div style="margin-top:8px;padding:8px;background:var(--off);border:1px solid var(--light);border-radius:3px;font-size:11px;color:#555;line-height:1.5">{{ $budget->justification }}</div>
                    @endif
                </div>
            </div>
            <div class="req-col">
                <div class="rc-label">Budget Breakdown</div>
                @php
                    $apprLabel = $budget->status === 'rejected' ? 'Willing to Fund' : 'Approved';
                    $apprColor = $budget->status === 'rejected' ? 'var(--amber)' : 'var(--green)';
                @endphp
                <table class="blt">
                    <tr style="color:var(--grey)">
                        <td style="font-size:9px;text-transform:uppercase;letter-spacing:.5px">Category</td>
                        <td style="font-size:9px;text-transform:uppercase;letter-spacing:.5px;text-align:right">Requested</td>
                        <td style="font-size:9px;text-transform:uppercase;letter-spacing:.5px;text-align:right">{{ $apprLabel }}</td>
                    </tr>
                    @foreach ($budget->items as $item)
                    @php $reqAmt = $item->quantity * $item->unit_cost; @endphp
                    <tr>
                        <td>{{ $item->name }}@if($item->quantity > 1) ×{{ $item->quantity }}@endif</td>
                        <td style="text-align:right;color:var(--grey)">RM {{ number_format($reqAmt, 2) }}</td>
                        @if($budget->status === 'pending')
                        <td style="text-align:right;padding-left:8px">
                            <input type="number" class="appr-input" data-budget="{{ $budget->id }}" data-item="{{ $item->id }}"
                                value="{{ number_format($reqAmt, 2, '.', '') }}" min="0" step="0.01" oninput="recalcAppr({{ $budget->id }})"
                                style="width:90px;border:1px solid var(--light);background:var(--off);padding:5px 7px;font-size:11px;color:var(--navy);outline:none;border-radius:3px;text-align:right"/>
                        </td>
                        @else
                        <td style="text-align:right;color:{{ $apprColor }};font-weight:600">RM {{ number_format($item->approved_amount ?? $reqAmt, 2) }}</td>
                        @endif
                    </tr>
                    @endforeach
                    <tr>
                        <td><strong>Total</strong></td>
                        <td style="text-align:right"><strong>RM {{ number_format($budget->total_requested, 2) }}</strong></td>
                        @if($budget->status === 'pending')
                        <td style="text-align:right"><strong style="color:var(--navy)">RM <span id="appr-total-{{ $budget->id }}">{{ number_format($budget->total_requested, 2) }}</span></strong></td>
                        @else
                        <td style="text-align:right"><strong style="color:{{ $apprColor }}">RM {{ number_format((float) ($budget->total_approved ?? 0), 2) }}</strong></td>
                        @endif
                    </tr>
                </table>
            </div>
            <div class="req-col">
                @if($budget->status === 'approved')
                    <div class="rc-label">Decision</div>
                    <div style="background:var(--green-bg);border:1px solid var(--green-border);padding:12px;border-radius:3px;font-size:12px;color:#166534;line-height:1.6">Approved · RM {{ number_format($amountNum, 2) }}</div>
                    <div style="margin-top:8px;font-size:10px;color:var(--grey)">Approved · {{ ($budget->decided_at ?? $budget->updated_at)->format('j M Y') }}</div>
                    @if($budget->internal_notes)
                    <div class="rc-label" style="margin:12px 0 6px">Internal Notes</div>
                    <div style="background:var(--off);border:1px dashed var(--light);padding:8px 10px;border-radius:3px;font-size:11px;color:#555;line-height:1.5">{{ $budget->internal_notes }}</div>
                    @endif
                @elseif($budget->status === 'rejected')
                    <div class="rc-label">Rejection Reason <span style="color:var(--grey);font-weight:400;text-transform:none;letter-spacing:0">(sent to chapter)</span></div>
                    <div style="background:var(--red-l);border:1px solid rgba(192,57,43,.2);padding:12px;border-radius:3px;font-size:12px;color:var(--red);line-height:1.6">{{ $budget->decision_notes ?? 'No reason provided.' }}</div>
                    <div style="margin-top:8px;font-size:10px;color:var(--grey)">Rejected · {{ ($budget->decided_at ?? $budget->updated_at)->format('j M Y') }}</div>
                    @if($budget->internal_notes)
                    <div class="rc-label" style="margin:12px 0 6px">Internal Notes</div>
                    <div style="background:var(--off);border:1px dashed var(--light);padding:8px 10px;border-radius:3px;font-size:11px;color:#555;line-height:1.5">{{ $budget->internal_notes }}</div>
                    @endif
                @else
                    <div class="rc-label">Approval Amount</div>
                    <div style="font-size:11px;color:var(--grey);margin-bottom:8px;line-height:1.5">Set each category's approved figure in the breakdown. Total to approve:</div>
                    <div style="font-family:'Playfair Display',serif;font-size:20px;font-weight:900;color:var(--navy)">RM <span id="appr-summary-{{ $budget->id }}">{{ number_format($budget->total_requested, 2) }}</span></div>
                @endif

                {{-- Event PPW — quick download for review (event was approved within the system) --}}
                <div class="rc-label" style="margin:14px 0 6px">Event PPW</div>
                @if($budget->event?->ppw_path)
                <a class="doc-chip" href="{{ asset('storage/' . $budget->event->ppw_path) }}" target="_blank" rel="noopener" style="display:inline-flex">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <span><strong>Download PPW</strong><em>{{ $budget->event->ppw_filename ?? 'event-ppw.pdf' }}</em></span>
                </a>
                @else
                <div style="font-size:11px;color:var(--grey)">No PPW on file for this event.</div>
                @endif
            </div>
        </div>

        {{-- Invoices / receipts (submitted by the chapter after approval) --}}
        @if($budget->status !== 'pending')
        <div class="req-docs">
            <div class="rc-label" style="margin-bottom:10px">Invoices / Receipts</div>
            @if($budget->receipts->count())
            <div class="doc-strip">
                @foreach($budget->receipts as $receipt)
                <a class="doc-chip" href="{{ $receipt->url }}" target="_blank" rel="noopener">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <span><strong>Receipt</strong><em>{{ $receipt->filename }}</em></span>
                </a>
                @endforeach
            </div>
            @else
            <div style="font-size:11px;color:var(--grey)">No invoices submitted yet — awaiting the chapter.</div>
            @endif
        </div>

        {{-- Reimbursement (admin reimburses against receipts, capped at the approved amount) --}}
        @if($budget->status === 'approved')
        @php $cap = (float) ($budget->total_approved ?? $budget->total_requested); @endphp
        <div class="req-foot">
            @if($budget->reimbursed_at)
            <div style="flex:1;font-size:12px;color:#166534">
                <strong>Reimbursed RM {{ number_format((float) $budget->total_reimbursed, 2) }}</strong>
                <span style="color:var(--grey)">of RM {{ number_format($cap, 2) }} approved · {{ $budget->reimbursed_at->format('j M Y') }}</span>
            </div>
            @elseif($budget->receipts->count())
            {{-- Receipts are in — reimbursement can be processed. --}}
            <form method="POST" action="{{ route('admin.budget-requests.reimburse', $budget) }}" class="req-comment" style="display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;flex:1">
                @csrf
                <div style="flex:1;min-width:160px">
                    <label>Reimbursed Amount (RM) — max {{ number_format($cap, 2) }}</label>
                    <input type="number" name="total_reimbursed" step="0.01" min="0" max="{{ $cap }}" required
                        placeholder="Amount to reimburse"
                        style="width:100%;border:1px solid var(--light);background:var(--off);padding:8px 12px;font-size:12px;color:var(--navy);outline:none;border-radius:3px"/>
                </div>
                <button type="submit" class="btn-approve">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Mark Reimbursed
                </button>
            </form>
            {{-- An approval can still be reversed to a rejection until funds are released. --}}
            <div class="req-actions">
                <button type="button" class="btn-reject" onclick="openReject({{ $budget->id }}, '{{ route('admin.budget-requests.reject', $budget) }}')">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Reject
                </button>
            </div>
            @else
            {{-- No receipts yet — reimbursement isn't available, but the admin can still reject. --}}
            <div style="flex:1;font-size:12px;color:var(--grey);align-self:center">Reimbursement opens once the chapter submits invoices / receipts.</div>
            <div class="req-actions">
                <button type="button" class="btn-reject" onclick="openReject({{ $budget->id }}, '{{ route('admin.budget-requests.reject', $budget) }}')">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Reject
                </button>
            </div>
            @endif
        </div>
        @endif
        @endif

        @if($budget->status === 'pending')
        <div class="req-foot">
            <div class="req-comment">
                <label>Internal Notes (admin only — not shown to the chapter)</label>
                <textarea id="internal-{{ $budget->id }}" placeholder="Internal remarks for the review team…"></textarea>
            </div>
            <div class="req-actions">
                <button type="button" class="btn-reject" onclick="openReject({{ $budget->id }}, '{{ route('admin.budget-requests.reject', $budget) }}')">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Reject
                </button>
                {{-- Empty form; the per-category amounts + internal notes are injected by submitApprove(). --}}
                <form method="POST" action="{{ route('admin.budget-requests.approve', $budget) }}" id="approve-form-{{ $budget->id }}">@csrf</form>
                <button type="button" class="btn-approve" onclick="submitApprove({{ $budget->id }})">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Approve
                </button>
            </div>
        </div>
        @endif

        <div class="req-audit">
            <a href="{{ route('admin.activity', ['subject_type' => 'App\\Models\\StudentEventBudget', 'subject_id' => $budget->id]) }}" class="req-audit-link">
                <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                View audit trail
            </a>
        </div>
    </div>
</div>
@empty
<div class="empty-state">
    <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
    <p>No budget requests have been submitted yet.</p>
</div>
@endforelse

</div>

<div class="empty-state" id="empty-state" style="display:none">
    <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
    <p>No budget requests match the current filters.</p>
</div>

{{-- Reject reason modal (chapter-facing) --}}
<div id="rejectModal" class="bmodal">
    <form method="POST" id="rejectForm" class="bmodal-box">
        @csrf
        <div style="font-size:14px;font-weight:700;color:var(--navy);margin-bottom:4px">Reject budget request</div>
        <div style="font-size:11px;color:var(--grey);margin-bottom:12px;line-height:1.5">This reason is sent to the chapter and recorded in the audit trail. The chapter can reinstate the request after revising.</div>
        <textarea name="feedback" id="rejectFeedback" required placeholder="Reason for rejection…"
            style="width:100%;border:1px solid var(--light);background:var(--off);padding:10px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);outline:none;border-radius:3px;min-height:90px;resize:vertical"></textarea>
        <input type="hidden" name="internal_notes" id="rejectInternalHidden">
        <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:12px">
            <button type="button" onclick="closeReject()" style="background:none;border:1px solid var(--light);color:var(--grey);padding:8px 14px;font-size:11px;font-weight:700;cursor:pointer;border-radius:3px;font-family:'DM Sans',sans-serif">Cancel</button>
            <button type="submit" class="btn-reject" onclick="injectReject()">Reject Request</button>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
function toggleReq(head) {
    const body    = head.parentElement.querySelector('.req-body');
    const chevron = head.querySelector('.req-chevron');
    const isOpen  = body.classList.contains('open');
    body.classList.toggle('open', !isOpen);
    chevron.classList.toggle('open', !isOpen);
}

// Live total of the per-category approved inputs.
function recalcAppr(id) {
    let total = 0;
    document.querySelectorAll('.appr-input[data-budget="' + id + '"]').forEach(i => total += parseFloat(i.value) || 0);
    const t = total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    const a = document.getElementById('appr-total-' + id);   if (a) a.textContent = t;
    const b = document.getElementById('appr-summary-' + id); if (b) b.textContent = t;
}

// Approve: inject per-category amounts + internal notes into the hidden form, then submit.
function submitApprove(id) {
    const form = document.getElementById('approve-form-' + id);
    form.querySelectorAll('.injected').forEach(e => e.remove());
    document.querySelectorAll('.appr-input[data-budget="' + id + '"]').forEach(inp => {
        const h = document.createElement('input');
        h.type = 'hidden'; h.className = 'injected';
        h.name = 'approved[' + inp.dataset.item + ']'; h.value = inp.value;
        form.appendChild(h);
    });
    const hn = document.createElement('input');
    hn.type = 'hidden'; hn.className = 'injected';
    hn.name = 'internal_notes'; hn.value = document.getElementById('internal-' + id)?.value || '';
    form.appendChild(hn);
    form.submit();
}

// Reject: open the chapter-facing reason modal.
let rejectBudgetId = null;
function openReject(id, action) {
    rejectBudgetId = id;
    const f = document.getElementById('rejectForm');
    f.action = action;
    document.getElementById('rejectFeedback').value = '';
    document.getElementById('rejectModal').classList.add('open');
    setTimeout(() => document.getElementById('rejectFeedback').focus(), 50);
}
function closeReject() { document.getElementById('rejectModal').classList.remove('open'); }
// On reject, also carry the per-category amounts HQ is willing to fund + internal notes.
function injectReject() {
    const form = document.getElementById('rejectForm');
    form.querySelectorAll('.injected').forEach(e => e.remove());
    document.querySelectorAll('.appr-input[data-budget="' + rejectBudgetId + '"]').forEach(inp => {
        const h = document.createElement('input');
        h.type = 'hidden'; h.className = 'injected';
        h.name = 'approved[' + inp.dataset.item + ']'; h.value = inp.value;
        form.appendChild(h);
    });
    document.getElementById('rejectInternalHidden').value = document.getElementById('internal-' + rejectBudgetId)?.value || '';
}

function filterRequests() {
    const q      = document.getElementById('req-search').value.toLowerCase();
    const status = document.getElementById('req-status').value;
    let   visible = 0;
    document.querySelectorAll('.req-card').forEach(card => {
        const matchQ = !q || card.dataset.chapter.includes(q) || card.querySelector('.req-title').textContent.toLowerCase().includes(q);
        const matchS = !status || card.dataset.status === status;
        const show   = matchQ && matchS;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    document.getElementById('empty-state').style.display = visible === 0 ? 'block' : 'none';
}
</script>
@endsection
