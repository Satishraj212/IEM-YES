@extends('admin.layouts.app')

@section('title', 'State Branches')

@section('topbar-actions')
<a href="{{ route('admin.official-events') }}" class="btn-primary">
    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Create Event
</a>
@endsection

@section('styles')
<style>
.stat-row{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:22px}

/* ── STATE ACCORDION ── */
.state-block{background:#fff;border:1px solid var(--light);border-radius:4px;margin-bottom:12px;overflow:hidden}
.state-header{display:flex;align-items:center;gap:14px;padding:16px 20px;cursor:pointer;user-select:none;transition:background .15s}
.state-header:hover{background:#fafaf8}
.state-dot{width:11px;height:11px;border-radius:50%;flex-shrink:0}
.state-name{font-family:'Playfair Display',serif;font-size:16px;font-weight:700;color:var(--navy);flex:1}
.state-meta{display:flex;align-items:center;gap:20px;margin-right:12px}
.state-stat{text-align:right}
.state-stat-val{font-size:13px;font-weight:700;color:var(--navy)}
.state-stat-lbl{font-size:9px;color:var(--grey);text-transform:uppercase;letter-spacing:1px;margin-top:1px}
.state-chevron{width:16px;height:16px;stroke:var(--grey);fill:none;stroke-width:2;transition:transform .25s;flex-shrink:0}
.state-chevron.open{transform:rotate(180deg)}
.state-body{display:none;border-top:1px solid var(--light)}
.state-body.open{display:block}

/* ── UNIVERSITY TABLE ── */
.tbl-wrap{overflow-x:auto}
.uni-table{width:100%;border-collapse:collapse}
.uni-table th{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);text-align:left;padding:10px 20px 8px;border-bottom:1px solid var(--light);background:#fafaf8}
.uni-table td{padding:13px 20px;border-bottom:1px solid var(--light);vertical-align:middle}
.uni-table tr:last-child td{border-bottom:none}
.uni-table tr:hover td{background:#fafaf8}
.uni-num{font-size:11px;font-weight:700;color:var(--grey)}
.uni-name{font-size:13px;font-weight:600;color:var(--navy)}
.uni-abbr{font-size:11px;color:var(--grey);margin-top:2px}

/* ── STAT PILLS ── */
.stat-pill{display:inline-flex;flex-direction:column;align-items:center;background:var(--off);border:1px solid var(--light);border-radius:3px;padding:6px 12px;min-width:80px}
.sp-val{font-size:13px;font-weight:700;color:var(--navy)}
.sp-lbl{font-size:8px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-top:2px}
.budget-pill{background:var(--gold-dim);border:1px solid rgba(200,168,75,.25)}
.budget-pill .sp-val{color:#7a5b14}

/* ── ROW ACTIONS ── */
.action-group{display:flex;align-items:center;gap:6px;justify-content:flex-end}
.btn-view{display:flex;align-items:center;gap:5px;padding:7px 13px;background:var(--navy-dark);color:#fff;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;border-radius:3px;transition:background .2s;white-space:nowrap}
.btn-view:hover{background:var(--navy-mid)}
.btn-view svg{width:11px;height:11px;stroke:#fff;fill:none;stroke-width:2.5}
.btn-approve{padding:7px 13px;background:#dcfce7;color:#166534;border:1px solid #bbf7d0;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;border-radius:3px;transition:all .2s}
.btn-approve:hover{background:#16a34a;color:#fff;border-color:#16a34a}
.btn-reject{padding:7px 13px;background:var(--red-l);color:var(--red);border:1px solid rgba(192,57,43,.2);cursor:pointer;font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;border-radius:3px;transition:all .2s}
.btn-reject:hover{background:var(--red);color:#fff;border-color:var(--red)}
.status-approved{display:inline-flex;align-items:center;gap:4px;font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:#166534;background:#dcfce7;border:1px solid #bbf7d0;padding:5px 10px;border-radius:3px}
.status-rejected{display:inline-flex;align-items:center;gap:4px;font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--red);background:var(--red-l);border:1px solid rgba(192,57,43,.2);padding:5px 10px;border-radius:3px}

/* ── ORG MODAL ── */
.modal-ov{position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:900;display:none;align-items:center;justify-content:center;padding:20px}
.modal-ov.open{display:flex}
.org-modal{background:#fff;width:680px;max-height:88vh;overflow-y:auto;border-radius:6px;box-shadow:0 20px 80px rgba(0,31,69,.25)}
.omh{background:var(--navy-dark);padding:18px 24px;display:flex;align-items:flex-start;justify-content:space-between;border-radius:6px 6px 0 0}
.omh-badge{font-size:8px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:4px}
.omh h3{font-family:'Playfair Display',serif;font-size:17px;font-weight:900;color:#fff;line-height:1.3}
.omh-sub{font-size:11px;color:rgba(255,255,255,.45);margin-top:3px}
.omc-btn{background:none;border:none;color:rgba(255,255,255,.45);font-size:24px;cursor:pointer;line-height:1;transition:color .15s}
.omc-btn:hover{color:#fff}
.omb{padding:24px}
.omf{padding:14px 24px;display:flex;gap:9px;justify-content:flex-end;border-top:1px solid var(--light);background:#fafaf8;border-radius:0 0 6px 6px}
.org-sec-title{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);margin-bottom:10px;padding-bottom:6px;border-bottom:1px solid var(--light)}
.org-card{background:var(--off);border:1px solid var(--light);border-radius:4px;padding:10px 14px;text-align:center}
.org-card.gold{background:var(--gold-dim);border-color:rgba(200,168,75,.4)}
.org-card.navy{background:rgba(0,31,69,.06);border-color:rgba(0,31,69,.15)}
.org-card-role{font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:3px}
.org-card.gold .org-card-role{color:#7a5b14}
.org-card-name{font-size:12px;font-weight:600;color:var(--navy);line-height:1.3}
.org-card.gold .org-card-name{color:#5a3f08}
.org-connector{width:2px;height:24px;background:var(--light);margin:0 auto}
</style>
@endsection

@section('content')

{{-- Summary Stats --}}
<div class="stat-row">
    <div class="sc">
        <div class="sc-bar" style="background:var(--gold)"></div>
        <div class="sc-lbl">Total Institutions</div>
        <div class="sc-val">21</div>
        <div class="sc-sub">Across 3 states</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--navy)"></div>
        <div class="sc-lbl">Total Students</div>
        <div class="sc-val">14,820</div>
        <div class="sc-sub">Registered YES IEM members</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--amber)"></div>
        <div class="sc-lbl">Annual Budget Pool</div>
        <div class="sc-val">RM 231k</div>
        <div class="sc-sub">Combined yearly allocation</div>
    </div>
</div>

{{-- ── ORG CHART SUBMISSION QUEUE ── --}}
<div class="panel" id="org-queue-panel" style="margin-bottom:16px">
    <div class="ph">
        <div>
            <div class="pt">Org Chart <em>Submissions</em></div>
            <div style="font-size:11px;color:var(--grey);margin-top:3px">Chapters that have submitted an org chart for YES approval</div>
        </div>
        <div style="display:flex;align-items:center;gap:8px">
            <span class="badge b-pending" id="queue-count">3 pending</span>
            <button class="pa" onclick="toggleQueue()">Hide ↑</button>
        </div>
    </div>
    <div id="org-queue-body">
        <div style="overflow-x:auto">
            <table class="etbl" style="margin-top:0" id="org-queue-table">
                <thead>
                    <tr>
                        <th>Chapter</th>
                        <th>Submitted</th>
                        <th>File</th>
                        <th style="text-align:center">Status</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody id="org-queue-tbody">
                    {{-- Rendered by JS --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- State Accordion --}}
<div id="stateList"></div>

{{-- Org Chart Modal --}}
<div class="modal-ov" id="orgModal" onclick="if(event.target===this)closeOrgModal()">
    <div class="org-modal">
        <div class="omh">
            <div>
                <div class="omh-badge">Organisation Chart</div>
                <h3 id="modalTitle">University Name</h3>
                <div class="omh-sub" id="modalSub">YES IEM Student Chapter</div>
            </div>
            <button class="omc-btn" onclick="closeOrgModal()">×</button>
        </div>
        <div class="omb" id="modalBody"></div>
        <div class="omf">
            <button class="btn-ghost" onclick="closeOrgModal()">Close</button>
            <button class="btn-prim" onclick="closeOrgModal()">Done</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
const states = [
    {
        id: 'selangor', name: 'Selangor', color: '#1a6b3c',
        universities: [
            { id:9,  name:'Universiti Tunku Abdul Rahman',        abbr:'UTAR Sungai Long', students:820,  budget:12000, status:'pending'  },
            { id:10, name:'Monash University Malaysia',            abbr:'Monash Malaysia',   students:540,  budget:9500,  status:'approved' },
            { id:11, name:'Universiti Tenaga Nasional',            abbr:'UNITEN',            students:710,  budget:11000, status:'pending'  },
            { id:12, name:'Multimedia University',                 abbr:'MMU Cyberjaya',     students:930,  budget:13500, status:'approved' },
            { id:13, name:'Universiti Teknologi Mara',             abbr:'UiTM Shah Alam',    students:1240, budget:16000, status:'pending'  },
            { id:14, name:'Universiti Kebangsaan Malaysia',        abbr:'UKM',               students:890,  budget:12500, status:'approved' },
            { id:15, name:"Taylor's University",                   abbr:"Taylor's",          students:460,  budget:8000,  status:'rejected' },
            { id:16, name:'Universiti Malaya',                     abbr:'UM',                students:1050, budget:15000, status:'approved' },
            { id:17, name:'Infrastructure University KL',          abbr:'IUKL',              students:320,  budget:6000,  status:'pending'  },
            { id:18, name:'University of Nottingham Malaysia',     abbr:'UNMC',              students:480,  budget:8500,  status:'pending'  },
            { id:19, name:'SEGi University',                       abbr:'SEGi',              students:290,  budget:5500,  status:'pending'  },
            { id:20, name:'MAHSA University',                      abbr:'MAHSA',             students:210,  budget:4500,  status:'pending'  },
            { id:21, name:'UOW KDU University College',            abbr:'UOW KDU',           students:340,  budget:6500,  status:'pending'  },
            { id:22, name:'Universiti Putra Malaysia',             abbr:'UPM',               students:960,  budget:14000, status:'approved' },
            { id:23, name:'Xiamen University Malaysia',            abbr:'XMUM',              students:410,  budget:7500,  status:'pending'  },
            { id:24, name:'Sunway University',                     abbr:'Sunway',            students:570,  budget:9000,  status:'approved' },
        ]
    },
    {
        id: 'kl', name: 'Kuala Lumpur', color: '#003366',
        universities: [
            { id:25, name:'Asia Pacific University',                    abbr:'APU',     students:680, budget:10500, status:'approved' },
            { id:26, name:'UCSI University',                            abbr:'UCSI',    students:540, budget:9000,  status:'pending'  },
            { id:27, name:'Tunku Abdul Rahman University',              abbr:'TAR UMT', students:820, budget:12000, status:'approved' },
            { id:28, name:'International Islamic University Malaysia',  abbr:'IIUM',    students:910, budget:13000, status:'pending'  },
        ]
    },
    {
        id: 'putrajaya', name: 'Putrajaya', color: '#c8a84b',
        universities: [
            { id:29, name:'Heriot-Watt University Malaysia', abbr:'HWUM', students:350, budget:7000, status:'pending' },
        ]
    }
];

function getOrgData() {
    return {
        advisor:   { name: 'Assoc. Prof. Dr. Ahmad Fauzi' },
        president: { name: 'Muhammad Irfan Zulkifli' },
        vp: [
            { role: 'Vice President (Internal)', name: 'Nurul Syafiqah Binti Hassan' },
            { role: 'Vice President (External)', name: 'Lee Chun Wei' },
        ],
        heads: [
            { role: 'Secretary',      name: 'Siti Aisyah Ramli' },
            { role: 'Treasurer',      name: 'Rajesh Kumar'       },
            { role: 'Events Head',    name: 'Amira Najwa Azman'  },
            { role: 'Technical Head', name: 'Tan Wei Jian'       },
        ]
    };
}

/* ── RENDER ── */
function renderStates() {
    const container = document.getElementById('stateList');
    container.innerHTML = '';
    states.forEach(state => {
        const totalStudents = state.universities.reduce((a,u) => a + u.students, 0);
        const totalBudget   = state.universities.reduce((a,u) => a + u.budget,   0);
        const block = document.createElement('div');
        block.className = 'state-block';
        block.innerHTML = `
            <div class="state-header" onclick="toggleState('${state.id}')">
                <div class="state-dot" style="background:${state.color}"></div>
                <div class="state-name">${state.name}</div>
                <div class="state-meta">
                    <div class="state-stat"><div class="state-stat-val">${state.universities.length}</div><div class="state-stat-lbl">Institutions</div></div>
                    <div class="state-stat"><div class="state-stat-val">${totalStudents.toLocaleString()}</div><div class="state-stat-lbl">Students</div></div>
                    <div class="state-stat"><div class="state-stat-val">RM ${(totalBudget/1000).toFixed(0)}k</div><div class="state-stat-lbl">Budget</div></div>
                </div>
                <svg class="state-chevron" id="chev-${state.id}" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="state-body" id="body-${state.id}">
                <div class="tbl-wrap">
                    <table class="uni-table">
                        <thead><tr>
                            <th style="width:32px">#</th>
                            <th>Institution</th>
                            <th style="text-align:center">Total Students</th>
                            <th style="text-align:center">Yearly Budget</th>
                            <th style="text-align:right;padding-right:24px">Actions</th>
                        </tr></thead>
                        <tbody>${state.universities.map(u => renderRow(u, state.id)).join('')}</tbody>
                    </table>
                </div>
            </div>`;
        container.appendChild(block);
    });
}

function renderRow(u, stateId) {
    const orgBtn = `<button class="btn-view" onclick="openOrgChart(${u.id},event)"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="3"/><path d="M8 17v-1a4 4 0 0 1 8 0v1"/><circle cx="4" cy="17" r="2"/><path d="M2 21v-1a2 2 0 0 1 4 0v1"/><circle cx="20" cy="17" r="2"/><path d="M18 21v-1a2 2 0 0 1 4 0v1"/></svg>Org Chart</button>`;
    const statusHtml = u.status === 'approved'
        ? `<span class="status-approved">✓ Approved</span>`
        : u.status === 'rejected'
        ? `<span class="status-rejected">✕ Rejected</span>`
        : `<button class="btn-approve" onclick="setStatus(${u.id},'${stateId}','approved',event)">Approve</button>
           <button class="btn-reject"  onclick="setStatus(${u.id},'${stateId}','rejected',event)">Reject</button>`;
    return `
        <tr>
            <td class="uni-num">${u.id}</td>
            <td><div class="uni-name">${u.name}</div><div class="uni-abbr">${u.abbr}</div></td>
            <td style="text-align:center"><div class="stat-pill" style="margin:0 auto"><div class="sp-val">${u.students.toLocaleString()}</div><div class="sp-lbl">Students</div></div></td>
            <td style="text-align:center"><div class="stat-pill budget-pill" style="margin:0 auto"><div class="sp-val">RM ${u.budget.toLocaleString()}</div><div class="sp-lbl">/ year</div></div></td>
            <td style="padding-right:20px"><div class="action-group" id="actions-${u.id}">${orgBtn}${statusHtml}</div></td>
        </tr>`;
}

/* ── ACCORDION ── */
function toggleState(id) {
    document.getElementById('body-' + id).classList.toggle('open');
    document.getElementById('chev-' + id).classList.toggle('open');
}

/* ── APPROVE / REJECT ── */
function setStatus(uniId, stateId, newStatus, e) {
    e.stopPropagation();
    const state = states.find(s => s.id === stateId);
    const uni   = state.universities.find(u => u.id === uniId);
    uni.status  = newStatus;
    const orgBtn = `<button class="btn-view" onclick="openOrgChart(${uniId},event)"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="3"/><path d="M8 17v-1a4 4 0 0 1 8 0v1"/><circle cx="4" cy="17" r="2"/><path d="M2 21v-1a2 2 0 0 1 4 0v1"/><circle cx="20" cy="17" r="2"/><path d="M18 21v-1a2 2 0 0 1 4 0v1"/></svg>Org Chart</button>`;
    const div   = document.getElementById('actions-' + uniId);
    div.innerHTML = newStatus === 'approved'
        ? orgBtn + `<span class="status-approved">✓ Approved</span>`
        : orgBtn + `<span class="status-rejected">✕ Rejected</span>`;
    showToast(newStatus === 'approved' ? 'Chapter approved successfully' : 'Chapter rejected', newStatus === 'approved' ? 'success' : 'danger');
}

/* ── ORG CHART ── */
function openOrgChart(uniId, e) {
    if (e) e.stopPropagation();
    let uni = null, stateName = '';
    for (const s of states) {
        const found = s.universities.find(u => u.id === uniId);
        if (found) { uni = found; stateName = s.name; break; }
    }
    if (!uni) return;
    const org = getOrgData();
    document.getElementById('modalTitle').textContent = uni.name;
    document.getElementById('modalSub').textContent   = `${uni.abbr} · YES IEM Student Chapter · ${stateName}`;
    const statusColor = uni.status === 'approved' ? '#166534' : uni.status === 'rejected' ? 'var(--red)' : 'var(--amber)';
    const statusBg    = uni.status === 'approved' ? '#dcfce7' : uni.status === 'rejected' ? 'var(--red-l)' : 'var(--amber-l)';
    const statusBdr   = uni.status === 'approved' ? '#bbf7d0' : uni.status === 'rejected' ? 'rgba(192,57,43,.2)' : 'rgba(217,119,6,.2)';
    document.getElementById('modalBody').innerHTML = `
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-bottom:20px">
            <div style="background:var(--off);border:1px solid var(--light);border-radius:3px;padding:10px 14px;text-align:center">
                <div style="font-size:16px;font-weight:700;color:var(--navy)">${uni.students.toLocaleString()}</div>
                <div style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-top:2px">Students</div>
            </div>
            <div style="background:var(--gold-dim);border:1px solid rgba(200,168,75,.3);border-radius:3px;padding:10px 14px;text-align:center">
                <div style="font-size:16px;font-weight:700;color:#7a5b14">RM ${uni.budget.toLocaleString()}</div>
                <div style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#7a5b14;margin-top:2px">Budget / Year</div>
            </div>
            <div style="background:${statusBg};border:1px solid ${statusBdr};border-radius:3px;padding:10px 14px;text-align:center">
                <div style="font-size:16px;font-weight:700;color:${statusColor}">${uni.status.charAt(0).toUpperCase()+uni.status.slice(1)}</div>
                <div style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-top:2px">Status</div>
            </div>
        </div>
        <div class="org-sec-title">Organisation Structure</div>
        <div style="display:flex;flex-direction:column;align-items:center">
            <div style="background:#f0f4ff;border:1px solid rgba(0,51,102,.2);border-radius:4px;padding:10px 14px;text-align:center;min-width:200px">
                <div class="org-card-role">Faculty Advisor</div>
                <div class="org-card-name">${org.advisor.name}</div>
            </div>
            <div class="org-connector"></div>
            <div class="org-card gold" style="min-width:200px">
                <div class="org-card-role">President</div>
                <div class="org-card-name">${org.president.name}</div>
            </div>
            <div class="org-connector"></div>
            <div style="position:relative;width:100%;display:flex;justify-content:center">
                <div style="position:absolute;top:0;left:50%;transform:translateX(-50%);width:240px;height:2px;background:var(--light)"></div>
                <div style="display:flex;gap:12px">
                    ${org.vp.map(v=>`
                    <div style="display:flex;flex-direction:column;align-items:center">
                        <div style="width:2px;height:20px;background:var(--light)"></div>
                        <div class="org-card navy" style="min-width:150px">
                            <div class="org-card-role">${v.role}</div>
                            <div class="org-card-name">${v.name}</div>
                        </div>
                    </div>`).join('')}
                </div>
            </div>
            <div class="org-connector"></div>
            <div style="position:relative;width:100%;display:flex;justify-content:center">
                <div style="position:absolute;top:0;left:50%;transform:translateX(-50%);width:80%;height:2px;background:var(--light)"></div>
                <div style="display:flex;gap:10px;flex-wrap:wrap;justify-content:center">
                    ${org.heads.map(h=>`
                    <div style="display:flex;flex-direction:column;align-items:center">
                        <div style="width:2px;height:20px;background:var(--light)"></div>
                        <div class="org-card" style="min-width:130px">
                            <div class="org-card-role">${h.role}</div>
                            <div class="org-card-name">${h.name}</div>
                        </div>
                    </div>`).join('')}
                </div>
            </div>
        </div>`;
    document.getElementById('orgModal').classList.add('open');
}

function closeOrgModal() {
    document.getElementById('orgModal').classList.remove('open');
}

/* ── ORG CHART QUEUE ── */
const orgSubmissions = [
    { id: 1, chapter: 'YES UTM Johor',         uni: 'Universiti Teknologi Malaysia, Skudai', date: '24 Apr 2025', file: 'org_chart_utm_johor_2025.pdf', size: '0.8 MB', status: 'pending' },
    { id: 2, chapter: 'YES USM Penang',         uni: 'Universiti Sains Malaysia',             date: '22 Apr 2025', file: 'org_chart_usm_2025.pdf',       size: '0.6 MB', status: 'pending' },
    { id: 3, chapter: 'YES UiTM Shah Alam',     uni: 'Universiti Teknologi MARA',             date: '19 Apr 2025', file: 'org_chart_uitm_sa_2025.pdf',   size: '0.5 MB', status: 'pending' },
    { id: 4, chapter: 'YES UTM Kuala Lumpur',   uni: 'Universiti Teknologi Malaysia, KL',     date: '10 Apr 2025', file: 'org_chart_utm_kl_2025.pdf',    size: '0.9 MB', status: 'approved' },
    { id: 5, chapter: 'YES UTP Perak',          uni: 'Universiti Teknologi PETRONAS',         date: '5 Apr 2025',  file: 'org_chart_utp_2025.pdf',       size: '0.7 MB', status: 'approved' },
];

function renderOrgQueue() {
    const tbody = document.getElementById('org-queue-tbody');
    tbody.innerHTML = orgSubmissions.map(s => {
        const badge = s.status === 'approved'
            ? `<span class="badge b-approved">Approved</span>`
            : s.status === 'rejected'
            ? `<span class="badge b-rejected">Rejected</span>`
            : `<span class="badge b-pending">Pending</span>`;
        const actions = s.status === 'pending'
            ? `<div style="display:flex;gap:6px;justify-content:flex-end">
                   <button class="btn-approve" style="padding:6px 12px;font-size:9px" onclick="approveOrgChart(${s.id})">
                       <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Approve
                   </button>
                   <button class="btn-reject" style="padding:6px 12px;font-size:9px" onclick="rejectOrgChart(${s.id})">
                       <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>Reject
                   </button>
               </div>`
            : `<div style="text-align:right;font-size:11px;color:var(--grey)">No action needed</div>`;
        return `<tr id="org-row-${s.id}">
            <td>
                <div class="et-name">${s.chapter}</div>
                <div class="et-sub">${s.uni}</div>
            </td>
            <td class="et-sm">${s.date}</td>
            <td>
                <div style="display:flex;align-items:center;gap:8px">
                    <div style="width:28px;height:28px;background:var(--off);border:1px solid var(--light);border-radius:3px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--navy)" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:600;color:var(--navy)">${s.file}</div>
                        <div style="font-size:10px;color:var(--grey)">PDF · ${s.size}</div>
                    </div>
                </div>
            </td>
            <td style="text-align:center">${badge}</td>
            <td>${actions}</td>
        </tr>`;
    }).join('');
    updateQueueCount();
}

function approveOrgChart(id) {
    const sub = orgSubmissions.find(s => s.id === id);
    if (sub) sub.status = 'approved';
    renderOrgQueue();
    showToast('Org chart approved. Chapter has been notified.', 'success');
}

function rejectOrgChart(id) {
    const sub = orgSubmissions.find(s => s.id === id);
    if (sub) sub.status = 'rejected';
    renderOrgQueue();
    showToast('Org chart rejected. Chapter has been notified.', 'danger');
}

function updateQueueCount() {
    const pending = orgSubmissions.filter(s => s.status === 'pending').length;
    const el = document.getElementById('queue-count');
    el.textContent = pending > 0 ? `${pending} pending` : 'All reviewed';
    el.className   = 'badge ' + (pending > 0 ? 'b-pending' : 'b-approved');
}

let queueVisible = true;
function toggleQueue() {
    queueVisible = !queueVisible;
    document.getElementById('org-queue-body').style.display = queueVisible ? '' : 'none';
    document.querySelector('#org-queue-panel .pa').textContent = queueVisible ? 'Hide ↑' : 'Show ↓';
}

/* ── INIT ── */
renderOrgQueue();
renderStates();
toggleState('selangor');
</script>
@endsection