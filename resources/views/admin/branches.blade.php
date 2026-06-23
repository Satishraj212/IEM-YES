@extends('admin.layouts.app')

@section('title', 'Student Chapters')

@section('topbar-actions')
<button class="btn-primary" onclick="openCreateChapter()">
    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Create Chapter
</button>
@endsection

@section('styles')
<style>
/* ── STATE ACCORDION ── */
#stateList{display:flex;flex-direction:column;gap:22px}
.state-block{background:#fff;border:1px solid var(--light);border-radius:10px;overflow:hidden;box-shadow:0 2px 6px rgba(0,31,69,.05);transition:box-shadow .2s,transform .2s;border-left:6px solid var(--accent,var(--light))}
.state-block:hover{box-shadow:0 10px 30px rgba(0,31,69,.1);transform:translateY(-1px)}
.state-header{display:flex;align-items:center;gap:18px;padding:24px 28px;cursor:pointer;user-select:none;transition:background .15s;position:relative}
.state-header:hover{background:#fafaf8}
.state-dot{width:14px;height:14px;border-radius:50%;flex-shrink:0;box-shadow:0 0 0 4px var(--dot-ring,rgba(0,0,0,.04))}
.state-name{font-family:'Playfair Display',serif;font-size:24px;font-weight:900;color:var(--navy);flex:1;letter-spacing:-.3px}
.state-meta{display:flex;align-items:center;gap:14px;margin-right:14px}
.state-stat{text-align:center;background:var(--off);border:1px solid var(--light);border-radius:6px;padding:8px 16px;min-width:74px}
.state-stat-val{font-family:'Playfair Display',serif;font-size:20px;font-weight:900;color:var(--navy);line-height:1}
.state-stat-lbl{font-size:8px;color:var(--grey);text-transform:uppercase;letter-spacing:1.5px;margin-top:3px;font-weight:700}
.state-chevron{width:20px;height:20px;stroke:var(--grey);fill:none;stroke-width:2.5;transition:transform .25s;flex-shrink:0}
.state-chevron.open{transform:rotate(180deg)}
.state-body{display:none;border-top:1px solid var(--light);background:#fcfcfb}
.state-body.open{display:block}

/* ── CHAPTER TABLE ── */
.tbl-wrap{overflow-x:auto;padding:6px 14px 14px}
.uni-table{width:100%;border-collapse:separate;border-spacing:0 6px}
.uni-table th{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);text-align:left;padding:8px 18px}
.uni-table tbody tr{background:#fff;box-shadow:0 1px 2px rgba(0,31,69,.05);transition:box-shadow .15s,transform .15s}
.uni-table tbody tr:hover{box-shadow:0 4px 16px rgba(0,31,69,.09)}
.uni-table td{padding:15px 18px;vertical-align:middle;border-top:1px solid var(--light);border-bottom:1px solid var(--light)}
.uni-table td:first-child{border-left:1px solid var(--light);border-radius:6px 0 0 6px}
.uni-table td:last-child{border-right:1px solid var(--light);border-radius:0 6px 6px 0}
.uni-num{font-size:12px;font-weight:700;color:var(--grey)}
.uni-name{font-size:13.5px;font-weight:700;color:var(--navy)}
.uni-abbr{font-size:11px;color:var(--grey);margin-top:2px}

/* ── MEMBER PILL ── */
.stat-pill{display:inline-flex;flex-direction:column;align-items:center;background:var(--off);border:1px solid var(--light);border-radius:3px;padding:6px 12px;min-width:80px}
.sp-val{font-size:13px;font-weight:700;color:var(--navy)}
.sp-lbl{font-size:8px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-top:2px}

/* ── YEAR DROPDOWN ── */
.year-sel{border:1px solid var(--light);background:#fff;padding:7px 10px;font-family:'DM Sans',sans-serif;font-size:12px;font-weight:600;color:var(--navy);cursor:pointer;outline:none;border-radius:3px;min-width:110px}
.year-sel:focus{border-color:var(--navy)}
.year-none{font-size:11px;color:var(--grey);font-style:italic}

/* ── ROW ACTIONS ── */
.action-group{display:flex;align-items:center;gap:6px;justify-content:flex-end;flex-wrap:wrap}
.btn-view{display:flex;align-items:center;gap:5px;padding:7px 13px;background:var(--navy-dark);color:#fff;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;border-radius:3px;transition:background .2s;white-space:nowrap;text-decoration:none}
.btn-view:hover{background:var(--navy-mid)}
.btn-view svg{width:11px;height:11px;stroke:#fff;fill:none;stroke-width:2.5}
.btn-approve{display:inline-flex;align-items:center;gap:4px;padding:7px 13px;background:#dcfce7;color:#166534;border:1px solid #bbf7d0;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;border-radius:3px;transition:all .2s}
.btn-approve:hover{background:#16a34a;color:#fff;border-color:#16a34a}
.btn-approve svg{width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5}
.btn-reject{display:inline-flex;align-items:center;gap:4px;padding:7px 13px;background:var(--red-l);color:var(--red);border:1px solid rgba(192,57,43,.2);cursor:pointer;font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;border-radius:3px;transition:all .2s}
.btn-reject:hover{background:var(--red);color:#fff;border-color:var(--red)}
.btn-reject svg{width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5}
.btn-request{display:inline-flex;align-items:center;gap:5px;padding:7px 12px;background:var(--gold-dim);color:#7a5b14;border:1px solid rgba(200,168,75,.35);cursor:pointer;font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;border-radius:3px;transition:all .2s;white-space:nowrap}
.btn-request:hover{background:var(--gold);color:var(--navy-dark)}
.btn-request svg{width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5}
.status-approved{display:inline-flex;align-items:center;gap:4px;font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:#166534;background:#dcfce7;border:1px solid #bbf7d0;padding:5px 10px;border-radius:3px}
.status-rejected{display:inline-flex;align-items:center;gap:4px;font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--red);background:var(--red-l);border:1px solid rgba(192,57,43,.2);padding:5px 10px;border-radius:3px}
.status-pending{display:inline-flex;align-items:center;gap:4px;font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--amber);background:var(--amber-l);border:1px solid rgba(217,119,6,.2);padding:5px 10px;border-radius:3px}
.review-note{font-size:10px;color:var(--grey);margin-top:5px;max-width:260px;line-height:1.5}
.req-flag{font-size:10px;color:#7a5b14;margin-top:4px}

/* ── REVIEW MODAL ── */
.modal-ov{position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:900;display:none;align-items:center;justify-content:center;padding:20px}
.modal-ov.open{display:flex}
.org-modal{background:#fff;width:520px;max-height:88vh;overflow-y:auto;border-radius:6px;box-shadow:0 20px 80px rgba(0,31,69,.25)}
.omh{background:var(--navy-dark);padding:18px 24px;display:flex;align-items:flex-start;justify-content:space-between;border-radius:6px 6px 0 0}
.omh-badge{font-size:8px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:4px}
.omh h3{font-family:'Playfair Display',serif;font-size:17px;font-weight:900;color:#fff;line-height:1.3}
.omh-sub{font-size:11px;color:rgba(255,255,255,.45);margin-top:3px}
.omc-btn{background:none;border:none;color:rgba(255,255,255,.45);font-size:24px;cursor:pointer;line-height:1;transition:color .15s}
.omc-btn:hover{color:#fff}
.omb{padding:24px}
.omf{padding:14px 24px;display:flex;gap:9px;justify-content:flex-end;border-top:1px solid var(--light);background:#fafaf8;border-radius:0 0 6px 6px}
.rv-lbl{display:block;font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:6px}
.rv-area{width:100%;border:1px solid var(--light);background:var(--off);padding:10px 12px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--navy);outline:none;border-radius:3px;min-height:90px;resize:vertical;line-height:1.6}
.rv-area:focus{border-color:var(--navy);background:#fff}

/* ── CREATE CHAPTER FORM ── */
.cc-lbl{display:block;font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:6px}
.cc-input{width:100%;border:1px solid var(--light);background:var(--off);padding:10px 12px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--navy);outline:none;border-radius:3px;transition:border-color .15s}
.cc-input:focus{border-color:var(--navy);background:#fff}
</style>
@endsection

@section('content')

{{-- Page heading --}}
<div style="margin-bottom:22px">
    <h1 style="font-family:'Playfair Display',serif;font-size:30px;font-weight:900;color:var(--navy);line-height:1.1">Student <em style="color:var(--gold);font-style:normal">Chapters</em></h1>
    <p style="font-size:13px;color:var(--grey);margin-top:4px">Manage student chapters and review their yearly organisation charts</p>
</div>

{{-- Summary Stats --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:24px">
    <div class="sc">
        <div class="sc-bar" style="background:var(--gold)"></div>
        <div class="sc-lbl">Student Chapters</div>
        <div class="sc-val" id="chaptersStat">{{ $totalChapters }}</div>
        <div class="sc-sub">Listed in the system</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--navy)"></div>
        <div class="sc-lbl">Total Members</div>
        <div class="sc-val" id="membersStat">{{ number_format($totalStudents) }}</div>
        <div class="sc-sub">Registered YES IEM members</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--amber)"></div>
        <div class="sc-lbl">Org Charts Pending</div>
        <div class="sc-val" id="pendingStat">{{ $pendingCharts }}</div>
        <div class="sc-sub">Awaiting HQ review</div>
    </div>
</div>

{{-- State Accordion --}}
<div id="stateList"></div>

{{-- Review Modal --}}
<div class="modal-ov" id="reviewModal" onclick="if(event.target===this)closeReview()">
    <div class="org-modal">
        <div class="omh">
            <div>
                <div class="omh-badge">Review Org Chart</div>
                <h3 id="rvTitle">Chapter</h3>
                <div class="omh-sub" id="rvSub">Academic year</div>
            </div>
            <button class="omc-btn" onclick="closeReview()">×</button>
        </div>
        <div class="omb">
            <a id="rvViewLink" href="#" target="_blank" rel="noopener" class="btn-view" style="margin-bottom:16px">
                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Open submitted chart
            </a>
            <label class="rv-lbl">Comment to chapter (optional for approve, recommended for reject)</label>
            <textarea class="rv-area" id="rvComment" placeholder="e.g. Please correct the Treasurer's name and re-upload…"></textarea>
        </div>
        <div class="omf">
            <button class="btn-reject" style="padding:9px 16px" onclick="submitReview('rejected')">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>Reject
            </button>
            <button class="btn-approve" style="padding:9px 16px" onclick="submitReview('approved')">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Approve
            </button>
        </div>
    </div>
</div>

{{-- Create Chapter Modal --}}
<div class="modal-ov" id="createModal" onclick="if(event.target===this)closeCreateChapter()">
    <div class="org-modal" style="width:560px">
        <div class="omh">
            <div>
                <div class="omh-badge">New Student Chapter</div>
                <h3>Create Chapter</h3>
                <div class="omh-sub">Register a new YES IEM student chapter account</div>
            </div>
            <button class="omc-btn" onclick="closeCreateChapter()">×</button>
        </div>
        <div class="omb">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div style="grid-column:1/-1">
                    <label class="cc-lbl">Institution <span style="color:var(--red)">*</span></label>
                    <input class="cc-input" id="cc-institution" type="text" placeholder="e.g. Universiti Malaya"/>
                </div>
                <div>
                    <label class="cc-lbl">Chapter Name <span style="color:var(--red)">*</span></label>
                    <input class="cc-input" id="cc-name" type="text" placeholder="e.g. YES UM"/>
                </div>
                <div>
                    <label class="cc-lbl">Chapter Code <span style="color:var(--red)">*</span></label>
                    <input class="cc-input" id="cc-code" type="text" placeholder="e.g. UM"/>
                </div>
                <div>
                    <label class="cc-lbl">State <span style="color:var(--red)">*</span></label>
                    <select class="cc-input" id="cc-state">
                        <option value="" disabled selected>Select state…</option>
                        @foreach($stateOptions as $st)
                            <option value="{{ $st }}">{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="cc-lbl">Location</label>
                    <input class="cc-input" id="cc-location" type="text" placeholder="e.g. Gombak"/>
                </div>
                <div>
                    <label class="cc-lbl">Academic Year</label>
                    <input class="cc-input" id="cc-year" type="text" placeholder="e.g. 2025/2026"/>
                </div>
                <div>
                    <label class="cc-lbl">Total Members</label>
                    <input class="cc-input" id="cc-members" type="number" min="0" placeholder="e.g. 0"/>
                </div>
                <div>
                    <label class="cc-lbl">Status</label>
                    <select class="cc-input" id="cc-status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div style="margin-top:14px;font-size:11px;color:var(--grey);line-height:1.6;background:var(--off);border:1px solid var(--light);border-radius:4px;padding:10px 12px">
                The chapter profile appears in its state group immediately. Login credentials for the chapter can be issued later.
            </div>
        </div>
        <div class="omf">
            <button class="btn-ghost" onclick="closeCreateChapter()">Cancel</button>
            <button class="btn-prim" id="ccSubmit" onclick="submitCreateChapter()">Create Chapter</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
const CSRF   = document.querySelector('meta[name="csrf-token"]').content;
const STATES = @json($states);

/* ── RENDER ── */
function renderStates() {
    const container = document.getElementById('stateList');
    if (!STATES.length) {
        container.innerHTML = '<div class="panel" style="padding:60px;text-align:center;color:var(--grey);font-size:13px">No student chapters listed yet.</div>';
        return;
    }
    container.innerHTML = STATES.map((state, i) => {
        const slug = state.name.toLowerCase().replace(/\s+/g,'-');
        return `
        <div class="state-block" style="--accent:${state.color};--dot-ring:${state.color}1f">
            <div class="state-header" onclick="toggleState('${slug}')">
                <div class="state-dot" style="background:${state.color}"></div>
                <div class="state-name">${state.name}</div>
                <div class="state-meta">
                    <div class="state-stat"><div class="state-stat-val">${state.chapters.length}</div><div class="state-stat-lbl">Chapters</div></div>
                    <div class="state-stat"><div class="state-stat-val">${Number(state.students).toLocaleString()}</div><div class="state-stat-lbl">Members</div></div>
                </div>
                <svg class="state-chevron" id="chev-${slug}" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="state-body" id="body-${slug}">
                <div class="tbl-wrap">
                    <table class="uni-table">
                        <thead><tr>
                            <th style="width:32px">#</th>
                            <th>Institution</th>
                            <th style="text-align:center">Total Members</th>
                            <th>Org Chart Year</th>
                            <th style="text-align:right;padding-right:24px">Actions</th>
                        </tr></thead>
                        <tbody>${state.chapters.map((c,idx) => renderRow(c, idx+1)).join('')}</tbody>
                    </table>
                </div>
            </div>
        </div>`;
    }).join('');
}

function renderRow(c, num) {
    const yearCell = c.org_charts.length
        ? `<select class="year-sel" id="yr-${c.id}" onchange="onYearChange(${c.id})">
             ${c.org_charts.map(oc => `<option value="${oc.id}">${oc.academic_year}</option>`).join('')}
           </select>`
        : `<span class="year-none">No submissions yet</span>`;
    return `
        <tr>
            <td class="uni-num">${num}</td>
            <td><div class="uni-name">${c.name}</div><div class="uni-abbr">${c.abbr}</div></td>
            <td style="text-align:center"><div class="stat-pill" style="margin:0 auto"><div class="sp-val">${Number(c.members).toLocaleString()}</div><div class="sp-lbl">Members</div></div></td>
            <td>${yearCell}</td>
            <td style="padding-right:20px"><div class="action-group" id="act-${c.id}">${chartActionsHtml(c, currentChart(c))}</div></td>
        </tr>`;
}

/* Selected chart for a chapter (from its dropdown, or latest) */
function currentChart(c) {
    if (!c.org_charts.length) return null;
    const sel = document.getElementById('yr-' + c.id);
    const id  = sel ? parseInt(sel.value) : c.org_charts[0].id;
    return c.org_charts.find(o => o.id === id) || c.org_charts[0];
}

function chapterById(id) {
    for (const s of STATES) { const c = s.chapters.find(x => x.id === id); if (c) return c; }
    return null;
}

function chartActionsHtml(c, chart) {
    const requestBtn = `<button class="btn-request" onclick="requestUpload(${c.id})">
        <svg viewBox="0 0 24 24"><path d="M4 4v5h5"/><path d="M4 9a9 9 0 1 1 2.6 6.4"/></svg>Request Upload</button>`;

    if (!chart) {
        const flag = c.requested_at ? `<div class="req-flag">Requested ${c.requested_at}</div>` : '';
        return `${requestBtn}${flag}`;
    }

    const view = `<a class="btn-view" href="${chart.url}" target="_blank" rel="noopener">
        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>View</a>`;

    let decision;
    if (chart.status === 'approved') {
        decision = `<span class="status-approved">✓ Approved${chart.reviewed_at ? ' · '+chart.reviewed_at : ''}</span>`;
    } else if (chart.status === 'rejected') {
        decision = `<span class="status-rejected">✕ Rejected${chart.reviewed_at ? ' · '+chart.reviewed_at : ''}</span>`;
    } else {
        decision = `<button class="btn-approve" onclick="openReview(${c.id},${chart.id})"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Approve</button>
                    <button class="btn-reject"  onclick="openReview(${c.id},${chart.id})"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>Reject</button>`;
    }
    const note = chart.comment ? `<div class="review-note"><strong>Note:</strong> ${escapeHtml(chart.comment)}</div>` : '';
    return `<div style="display:flex;flex-direction:column;align-items:flex-end;gap:6px">
              <div class="action-group">${view}${decision}${requestBtn}</div>${note}
            </div>`;
}

function onYearChange(chapterId) {
    const c = chapterById(chapterId);
    document.getElementById('act-' + chapterId).innerHTML = chartActionsHtml(c, currentChart(c));
}

/* ── ACCORDION ── */
function toggleState(slug) {
    document.getElementById('body-' + slug).classList.toggle('open');
    document.getElementById('chev-' + slug).classList.toggle('open');
}

/* ── REQUEST UPLOAD ── */
async function requestUpload(chapterId) {
    const c = chapterById(chapterId);
    try {
        const res = await api(`/dashboard/admin/branches/${chapterId}/request-org-chart`, {});
        if (res.success) {
            c.requested_at = res.requested_at;
            document.getElementById('act-' + chapterId).innerHTML = chartActionsHtml(c, currentChart(c));
            showToast(`${c.abbr} notified to upload their org chart`, 'success');
        }
    } catch (e) { showToast('Could not send request.', 'danger'); }
}

/* ── REVIEW (approve / reject + comment) ── */
let reviewing = { chapterId: null, chartId: null };
function openReview(chapterId, chartId) {
    const c = chapterById(chapterId);
    const chart = c.org_charts.find(o => o.id === chartId);
    if (!chart) return;
    reviewing = { chapterId, chartId };
    document.getElementById('rvTitle').textContent = c.abbr;
    document.getElementById('rvSub').textContent   = `${c.name} · ${chart.academic_year}`;
    document.getElementById('rvViewLink').href     = chart.url;
    document.getElementById('rvComment').value     = chart.comment || '';
    document.getElementById('reviewModal').classList.add('open');
}
function closeReview() {
    document.getElementById('reviewModal').classList.remove('open');
}

async function submitReview(decision) {
    const { chapterId, chartId } = reviewing;
    if (!chartId) return;
    const comment = document.getElementById('rvComment').value.trim();
    if (decision === 'rejected' && !comment) {
        if (!confirm('Reject without a comment? A note helps the chapter fix it.')) return;
    }
    try {
        const res = await api(`/dashboard/admin/branches/org-charts/${chartId}/review`, { decision, comment });
        if (res.success) {
            const c = chapterById(chapterId);
            const chart = c.org_charts.find(o => o.id === chartId);
            chart.status = res.status; chart.comment = res.comment; chart.reviewed_at = res.reviewed_at;
            onYearChange(chapterId);
            adjustPending(decision);
            closeReview();
            showToast(decision === 'approved' ? 'Org chart approved — chapter notified' : 'Org chart rejected — chapter notified', decision === 'approved' ? 'success' : 'danger');
        }
    } catch (e) { showToast('Could not save review.', 'danger'); }
}

function adjustPending(decision) {
    const el = document.getElementById('pendingStat');
    const n  = Math.max(0, parseInt(el.textContent || '0') - 1);
    el.textContent = n;
}

/* ── CREATE CHAPTER ── */
function openCreateChapter() {
    ['cc-institution','cc-name','cc-code','cc-location','cc-year','cc-members'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('cc-state').selectedIndex = 0;
    document.getElementById('cc-status').value = 'active';
    document.getElementById('createModal').classList.add('open');
}
function closeCreateChapter() {
    document.getElementById('createModal').classList.remove('open');
}

async function submitCreateChapter() {
    const payload = {
        institution:   document.getElementById('cc-institution').value.trim(),
        name:          document.getElementById('cc-name').value.trim(),
        code:          document.getElementById('cc-code').value.trim(),
        state:         document.getElementById('cc-state').value,
        location:      document.getElementById('cc-location').value.trim() || null,
        academic_year: document.getElementById('cc-year').value.trim() || null,
        member_count:  parseInt(document.getElementById('cc-members').value) || 0,
        status:        document.getElementById('cc-status').value,
    };
    if (!payload.institution || !payload.name || !payload.code || !payload.state) {
        showToast('Institution, name, code and state are required.', 'danger');
        return;
    }
    const btn = document.getElementById('ccSubmit');
    btn.disabled = true; btn.textContent = 'Creating…';
    try {
        const res = await api('{{ route('admin.branches.store') }}', payload);
        if (res.success) {
            addChapterToView(res.state, res.color, res.chapter);
            closeCreateChapter();
            showToast(`${res.chapter.abbr} created`, 'success');
        }
    } catch (e) {
        showToast(e.message || 'Could not create chapter.', 'danger');
    } finally {
        btn.disabled = false; btn.textContent = 'Create Chapter';
    }
}

function addChapterToView(stateName, color, chapter) {
    let st = STATES.find(s => s.name === stateName);
    if (!st) { st = { name: stateName, color: color, chapters: [], students: 0 }; STATES.push(st); }
    st.chapters.push(chapter);
    st.chapters.sort((a, b) => a.name.localeCompare(b.name));
    st.students = st.chapters.reduce((a, c) => a + Number(c.members || 0), 0);
    STATES.sort((a, b) => b.chapters.length - a.chapters.length);

    renderStates();

    // Update header stats
    const totalC = STATES.reduce((a, s) => a + s.chapters.length, 0);
    const totalM = STATES.reduce((a, s) => a + Number(s.students || 0), 0);
    document.getElementById('chaptersStat').textContent = totalC;
    document.getElementById('membersStat').textContent  = totalM.toLocaleString();

    // Open the state the new chapter landed in
    toggleState(stateName.toLowerCase().replace(/\s+/g,'-'));
}

/* ── helpers ── */
async function api(url, body) {
    const r = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept':'application/json' },
        body: JSON.stringify(body),
    });
    const json = await r.json();
    if (!r.ok) {
        const msg = json.errors ? Object.values(json.errors)[0]?.[0] : (json.message || 'Server error');
        throw new Error(msg);
    }
    return json;
}
function escapeHtml(s){ const d=document.createElement('div'); d.textContent=s; return d.innerHTML; }

/* ── INIT ── */
renderStates();
if (STATES.length) toggleState(STATES[0].name.toLowerCase().replace(/\s+/g,'-'));
</script>
@endsection
