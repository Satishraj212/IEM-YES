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

/* ── STATUS BADGE COLUMN ── */
.status-pending{background:var(--amber-l);color:var(--amber);border:1px solid var(--amber-border)}
.status-approved{background:var(--green-bg);color:#166534;border:1px solid var(--green-border)}
.status-rejected{background:var(--red-l);color:var(--red);border:1px solid rgba(192,57,43,.15)}
.status-info{background:var(--blue-l);color:var(--blue);border:1px solid rgba(29,78,216,.2)}

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
        <div class="sc-val">7</div>
        <div class="sc-sub">Awaiting admin action</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--green)"></div>
        <div class="sc-lbl">Approved</div>
        <div class="sc-val">12</div>
        <div class="sc-sub">This academic year</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--red)"></div>
        <div class="sc-lbl">Rejected</div>
        <div class="sc-val">3</div>
        <div class="sc-sub">Returned for revision</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--navy)"></div>
        <div class="sc-lbl">Total Approved (RM)</div>
        <div class="sc-val">48k</div>
        <div class="sc-sub">RM 48,250 disbursed</div>
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
        <option value="more-info">More Info Needed</option>
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

    {{-- Request 1 - Pending --}}
    <div class="req-card" data-status="pending" data-chapter="yes utm johor" data-amount="4500">
        <div class="req-card-head" onclick="toggleReq(this)">
            <div class="req-left">
                <div class="req-title">STEM Career Fair 2025 — Budget Request</div>
                <div class="req-meta">
                    <span class="req-meta-item">
                        <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                        YES UTM Johor
                    </span>
                    <span class="req-meta-item">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Submitted 24 Apr 2025
                    </span>
                    <span class="req-meta-item">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        Est. 400 attendees
                    </span>
                    <span class="badge b-pending" style="font-size:9px">Pending Review</span>
                </div>
            </div>
            <div class="req-right">
                <div>
                    <div style="font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);text-align:right;margin-bottom:2px">Requested</div>
                    <div class="req-amount">RM 4,500</div>
                </div>
                <svg class="req-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
        </div>

        <div class="req-body">
            <div class="req-grid">
                <div class="req-col">
                    <div class="rc-label">Event Details</div>
                    <div style="font-size:12px;color:#444;line-height:1.65">
                        <div style="margin-bottom:6px"><strong style="color:var(--navy)">Event:</strong> STEM Career Fair 2025</div>
                        <div style="margin-bottom:6px"><strong style="color:var(--navy)">Date:</strong> 14 Jun 2025</div>
                        <div style="margin-bottom:6px"><strong style="color:var(--navy)">Venue:</strong> UTM Faculty of Engineering, Johor Bahru</div>
                        <div style="margin-bottom:6px"><strong style="color:var(--navy)">Type:</strong> Career Fair / Industry Networking</div>
                        <div><strong style="color:var(--navy)">Industry Partners:</strong> 12 companies confirmed</div>
                    </div>
                </div>
                <div class="req-col">
                    <div class="rc-label">Budget Breakdown</div>
                    <table class="blt">
                        <tr><td>Venue & Setup</td><td>RM 1,200</td></tr>
                        <tr><td>Printing & Materials</td><td>RM 600</td></tr>
                        <tr><td>Catering (400 pax)</td><td>RM 1,800</td></tr>
                        <tr><td>Photography</td><td>RM 500</td></tr>
                        <tr><td>Miscellaneous</td><td>RM 400</td></tr>
                        <tr><td><strong>Total Requested</strong></td><td><strong>RM 4,500</strong></td></tr>
                    </table>
                </div>
                <div class="req-col">
                    <div class="rc-label">Supporting Documents</div>
                    <div style="display:flex;flex-direction:column;gap:8px">
                        <div style="display:flex;align-items:center;gap:10px;background:var(--off);border:1px solid var(--light);padding:10px 12px;border-radius:3px">
                            <div style="width:30px;height:30px;background:#fff;border:1px solid var(--light);border-radius:3px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--navy)" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <div style="flex:1;min-width:0">
                                <div style="font-size:11px;font-weight:600;color:var(--navy);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">event_proposal_stem_fair_2025.pdf</div>
                                <div style="font-size:10px;color:var(--grey)">PDF · 1.2 MB</div>
                            </div>
                            <button style="padding:5px 10px;background:var(--navy-dark);color:#fff;border:none;cursor:pointer;font-size:9px;font-weight:700;border-radius:2px">View</button>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;background:var(--off);border:1px solid var(--light);padding:10px 12px;border-radius:3px">
                            <div style="width:30px;height:30px;background:#fff;border:1px solid var(--light);border-radius:3px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--navy)" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <div style="flex:1;min-width:0">
                                <div style="font-size:11px;font-weight:600;color:var(--navy);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">budget_breakdown_detailed.xlsx</div>
                                <div style="font-size:10px;color:var(--grey)">XLSX · 84 KB</div>
                            </div>
                            <button style="padding:5px 10px;background:var(--navy-dark);color:#fff;border:none;cursor:pointer;font-size:9px;font-weight:700;border-radius:2px">View</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="req-foot">
                <div class="req-comment">
                    <label>Admin Notes (optional — sent to chapter)</label>
                    <textarea placeholder="Add a note or reason for rejection…"></textarea>
                </div>
                <div class="req-actions">
                    <button class="btn-reject" onclick="updateStatus(this,'rejected')">
                        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Reject
                    </button>
                    <button class="btn-approve" onclick="updateStatus(this,'approved')">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Approve
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Request 2 - Pending --}}
    <div class="req-card" data-status="pending" data-chapter="yes usm penang" data-amount="3200">
        <div class="req-card-head" onclick="toggleReq(this)">
            <div class="req-left">
                <div class="req-title">Engineering Innovation Workshop Series — Budget Request</div>
                <div class="req-meta">
                    <span class="req-meta-item">
                        <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                        YES USM Penang
                    </span>
                    <span class="req-meta-item">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Submitted 22 Apr 2025
                    </span>
                    <span class="req-meta-item">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        Est. 120 attendees
                    </span>
                    <span class="badge b-pending" style="font-size:9px">Pending Review</span>
                </div>
            </div>
            <div class="req-right">
                <div>
                    <div style="font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);text-align:right;margin-bottom:2px">Requested</div>
                    <div class="req-amount">RM 3,200</div>
                </div>
                <svg class="req-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
        </div>
        <div class="req-body">
            <div class="req-grid">
                <div class="req-col">
                    <div class="rc-label">Event Details</div>
                    <div style="font-size:12px;color:#444;line-height:1.65">
                        <div style="margin-bottom:6px"><strong style="color:var(--navy)">Event:</strong> Engineering Innovation Workshop (3-session series)</div>
                        <div style="margin-bottom:6px"><strong style="color:var(--navy)">Dates:</strong> 5, 12, 19 Jul 2025</div>
                        <div style="margin-bottom:6px"><strong style="color:var(--navy)">Venue:</strong> USM Engineering Campus, Nibong Tebal</div>
                        <div style="margin-bottom:6px"><strong style="color:var(--navy)">Type:</strong> Technical Workshop Series</div>
                        <div><strong style="color:var(--navy)">Speakers:</strong> 3 industry engineers</div>
                    </div>
                </div>
                <div class="req-col">
                    <div class="rc-label">Budget Breakdown</div>
                    <table class="blt">
                        <tr><td>Speaker Honorarium (×3)</td><td>RM 900</td></tr>
                        <tr><td>Workshop Materials</td><td>RM 1,200</td></tr>
                        <tr><td>Refreshments (×3 sessions)</td><td>RM 700</td></tr>
                        <tr><td>Certificates & Printing</td><td>RM 400</td></tr>
                        <tr><td><strong>Total Requested</strong></td><td><strong>RM 3,200</strong></td></tr>
                    </table>
                </div>
                <div class="req-col">
                    <div class="rc-label">Supporting Documents</div>
                    <div style="display:flex;flex-direction:column;gap:8px">
                        <div style="display:flex;align-items:center;gap:10px;background:var(--off);border:1px solid var(--light);padding:10px 12px;border-radius:3px">
                            <div style="width:30px;height:30px;background:#fff;border:1px solid var(--light);border-radius:3px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--navy)" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <div style="flex:1;min-width:0">
                                <div style="font-size:11px;font-weight:600;color:var(--navy)">workshop_proposal.pdf</div>
                                <div style="font-size:10px;color:var(--grey)">PDF · 0.9 MB</div>
                            </div>
                            <button style="padding:5px 10px;background:var(--navy-dark);color:#fff;border:none;cursor:pointer;font-size:9px;font-weight:700;border-radius:2px">View</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="req-foot">
                <div class="req-comment">
                    <label>Admin Notes (optional — sent to chapter)</label>
                    <textarea placeholder="Add a note or reason for rejection…"></textarea>
                </div>
                <div class="req-actions">
                    <button class="btn-reject" onclick="updateStatus(this,'rejected')">
                        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Reject
                    </button>
                    <button class="btn-approve" onclick="updateStatus(this,'approved')">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Approve
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Request 3 - Approved --}}
    <div class="req-card" data-status="approved" data-chapter="yes utm kl" data-amount="5800">
        <div class="req-card-head" onclick="toggleReq(this)">
            <div class="req-left">
                <div class="req-title">National Hackathon 2025 — Budget Request</div>
                <div class="req-meta">
                    <span class="req-meta-item">
                        <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                        YES UTM Kuala Lumpur
                    </span>
                    <span class="req-meta-item">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Submitted 10 Mar 2025 · Approved 15 Mar 2025
                    </span>
                    <span class="badge b-approved" style="font-size:9px">Approved</span>
                </div>
            </div>
            <div class="req-right">
                <div>
                    <div style="font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);text-align:right;margin-bottom:2px">Approved</div>
                    <div class="req-amount" style="color:var(--green)">RM 5,800</div>
                </div>
                <svg class="req-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
        </div>
        <div class="req-body">
            <div class="req-grid">
                <div class="req-col">
                    <div class="rc-label">Event Details</div>
                    <div style="font-size:12px;color:#444;line-height:1.65">
                        <div style="margin-bottom:6px"><strong style="color:var(--navy)">Event:</strong> National Engineering Hackathon 2025</div>
                        <div style="margin-bottom:6px"><strong style="color:var(--navy)">Date:</strong> 22–23 Mar 2025 (completed)</div>
                        <div style="margin-bottom:6px"><strong style="color:var(--navy)">Venue:</strong> UTM KL City Campus</div>
                        <div><strong style="color:var(--navy)">Attendance:</strong> 340 participants · 68 teams</div>
                    </div>
                </div>
                <div class="req-col">
                    <div class="rc-label">Budget Breakdown</div>
                    <table class="blt">
                        <tr><td>Prize Money</td><td>RM 2,500</td></tr>
                        <tr><td>Venue & AV Equipment</td><td>RM 1,500</td></tr>
                        <tr><td>Catering (2 days)</td><td>RM 1,200</td></tr>
                        <tr><td>Marketing & Materials</td><td>RM 600</td></tr>
                        <tr><td><strong>Total Approved</strong></td><td><strong>RM 5,800</strong></td></tr>
                    </table>
                </div>
                <div class="req-col">
                    <div class="rc-label">Admin Notes</div>
                    <div style="background:var(--green-bg);border:1px solid var(--green-border);padding:12px;border-radius:3px;font-size:12px;color:#166534;line-height:1.6">
                        Approved in full. Strong proposal with clear budget justification and confirmed industry sponsors. Well within per-event allocation for Klang Valley.
                    </div>
                    <div style="margin-top:8px;font-size:10px;color:var(--grey)">Reviewed by Admin · 15 Mar 2025</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Request 4 - Rejected --}}
    <div class="req-card" data-status="rejected" data-chapter="yes unikl" data-amount="8000">
        <div class="req-card-head" onclick="toggleReq(this)">
            <div class="req-left">
                <div class="req-title">International Speaker Series — Budget Request</div>
                <div class="req-meta">
                    <span class="req-meta-item">
                        <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                        YES UniKL
                    </span>
                    <span class="req-meta-item">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Submitted 5 Apr 2025 · Rejected 8 Apr 2025
                    </span>
                    <span class="badge b-rejected" style="font-size:9px">Rejected</span>
                </div>
            </div>
            <div class="req-right">
                <div>
                    <div style="font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);text-align:right;margin-bottom:2px">Requested</div>
                    <div class="req-amount" style="color:var(--red)">RM 8,000</div>
                </div>
                <svg class="req-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
        </div>
        <div class="req-body">
            <div class="req-grid">
                <div class="req-col">
                    <div class="rc-label">Event Details</div>
                    <div style="font-size:12px;color:#444;line-height:1.65">
                        <div style="margin-bottom:6px"><strong style="color:var(--navy)">Event:</strong> International Engineering Speaker Series</div>
                        <div style="margin-bottom:6px"><strong style="color:var(--navy)">Proposed Date:</strong> Aug 2025</div>
                        <div><strong style="color:var(--navy)">Type:</strong> Speaker event with international guests</div>
                    </div>
                </div>
                <div class="req-col">
                    <div class="rc-label">Budget Breakdown</div>
                    <table class="blt">
                        <tr><td>Speaker Fees (×2 intl.)</td><td>RM 5,000</td></tr>
                        <tr><td>Travel & Accommodation</td><td>RM 2,000</td></tr>
                        <tr><td>Venue & Catering</td><td>RM 1,000</td></tr>
                        <tr><td><strong>Total Requested</strong></td><td><strong>RM 8,000</strong></td></tr>
                    </table>
                </div>
                <div class="req-col">
                    <div class="rc-label">Rejection Notes</div>
                    <div style="background:var(--red-l);border:1px solid rgba(192,57,43,.2);padding:12px;border-radius:3px;font-size:12px;color:var(--red);line-height:1.6">
                        Request exceeds single-event allocation cap (RM 6,000). International speaker fees not covered by standard YES budget. Please resubmit with reduced scope or seek co-sponsorship from faculty.
                    </div>
                    <div style="margin-top:8px;font-size:10px;color:var(--grey)">Reviewed by Admin · 8 Apr 2025</div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="empty-state" id="empty-state" style="display:none">
    <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
    <p>No budget requests match your current filters.</p>
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

function updateStatus(btn, status) {
    const card  = btn.closest('.req-card');
    const badge = card.querySelector('.badge');
    const foot  = btn.closest('.req-foot');
    const note  = foot.querySelector('textarea').value.trim();

    card.dataset.status = status;
    badge.className     = 'badge ' + (status === 'approved' ? 'b-approved' : 'b-rejected');
    badge.textContent   = status === 'approved' ? 'Approved' : 'Rejected';

    foot.querySelector('.req-actions').innerHTML =
        `<span style="font-size:11px;font-weight:600;color:var(--grey)">Status updated to <strong>${status}</strong></span>`;

    showToast(status === 'approved' ? 'Budget request approved. Chapter notified.' : 'Budget request rejected. Chapter notified.', status === 'approved' ? 'success' : 'danger');
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
