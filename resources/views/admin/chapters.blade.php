@extends('admin.layouts.app')

@section('title', 'Chapter Accounts')

@section('topbar-actions')
<button class="btn-primary" onclick="openCreateModal()">
    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    New Chapter Account
</button>
@endsection

@section('styles')
<style>
/* ── STAT CARDS ── */
.sc{background:#fff;border:1px solid var(--light);border-radius:4px;padding:16px 18px;position:relative;overflow:hidden;cursor:pointer;transition:box-shadow .2s}
.sc:hover{box-shadow:0 2px 12px rgba(0,31,69,.08)}
.sc-bar{position:absolute;top:0;left:0;right:0;height:3px}
.sc-lbl{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);margin-bottom:6px}
.sc-val{font-size:28px;font-weight:700;color:var(--navy);line-height:1}
.sc-sub{font-size:10px;color:var(--grey);margin-top:5px}

/* ── PANEL ── */
.panel{background:#fff;border:1px solid var(--light);border-radius:4px;margin-bottom:18px}
.ph{padding:16px 20px;border-bottom:1px solid var(--light);display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
.pt{font-family:'Playfair Display',serif;font-size:16px;font-weight:700;color:var(--navy)}
.pt em{color:var(--gold);font-style:normal}

/* ── SEARCH / FILTER ROW ── */
.sr{display:flex;gap:8px;align-items:center;flex-wrap:wrap;padding:12px 20px;border-bottom:1px solid var(--light);background:#fafaf8}
.si-wrap{position:relative;flex:1;min-width:200px}
.si-wrap svg{position:absolute;left:10px;top:50%;transform:translateY(-50%);width:13px;height:13px;stroke:var(--grey);fill:none;stroke-width:2}
.si-wrap input{width:100%;border:1px solid var(--light);background:#fff;padding:8px 12px 8px 32px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy-dark);outline:none;border-radius:3px}
.si-wrap input:focus{border-color:var(--navy)}
.fsel{border:1px solid var(--light);background:#fff;padding:7px 10px;font-family:'DM Sans',sans-serif;font-size:11px;color:var(--navy-dark);outline:none;border-radius:3px;cursor:pointer}

/* ── TABLE ── */
.tbl-wrap{overflow-x:auto}
.ch-table{width:100%;border-collapse:collapse}
.ch-table th{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);text-align:left;padding:10px 20px 8px;border-bottom:1px solid var(--light);background:#fafaf8;white-space:nowrap}
.ch-table td{padding:13px 20px;border-bottom:1px solid var(--light);vertical-align:middle}
.ch-table tr:last-child td{border-bottom:none}
.ch-table tr:hover td{background:#fafaf8}
.ch-num{font-size:11px;font-weight:700;color:var(--grey);width:36px}
.ch-name{font-size:13px;font-weight:600;color:var(--navy)}
.ch-uni{font-size:11px;color:var(--grey);margin-top:2px}
.ch-email{font-size:11px;color:var(--grey)}

/* ── STATUS BADGES ── */
.badge{display:inline-flex;align-items:center;gap:4px;font-size:9px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;padding:4px 9px;border-radius:3px;white-space:nowrap}
.badge-active{color:#166534;background:#dcfce7;border:1px solid #bbf7d0}
.badge-inactive{color:var(--grey);background:var(--off);border:1px solid var(--light)}
.badge-pending{color:var(--amber);background:var(--amber-l);border:1px solid var(--amber-border)}
.badge-suspended{color:var(--red);background:var(--red-l);border:1px solid rgba(192,57,43,.2)}
.badge svg{width:7px;height:7px;border-radius:50%;fill:currentColor}

/* ── ROW ACTIONS ── */
.act-group{display:flex;gap:6px;justify-content:flex-end;align-items:center}
.btn-sm{padding:6px 11px;border:1px solid var(--light);background:#fff;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:10px;font-weight:600;letter-spacing:.4px;border-radius:3px;transition:all .2s;white-space:nowrap}
.btn-sm:hover{border-color:var(--navy);color:var(--navy)}
.btn-sm.danger{color:var(--red);border-color:rgba(192,57,43,.25)}
.btn-sm.danger:hover{background:var(--red);color:#fff;border-color:var(--red)}
.btn-sm.success{color:#166534;border-color:#bbf7d0}
.btn-sm.success:hover{background:#16a34a;color:#fff;border-color:#16a34a}
.btn-sm.primary{background:var(--navy-dark);color:#fff;border-color:var(--navy-dark)}
.btn-sm.primary:hover{background:var(--navy-mid)}

/* ── EMPTY STATE ── */
.empty-state{padding:48px 20px;text-align:center}
.empty-state svg{width:40px;height:40px;stroke:var(--grey);fill:none;stroke-width:1.5;margin-bottom:12px;opacity:.4}
.empty-title{font-size:14px;font-weight:600;color:var(--navy);margin-bottom:6px}
.empty-sub{font-size:12px;color:var(--grey)}

/* ── MODAL ── */
.modal-ov{position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:900;display:none;align-items:center;justify-content:center;padding:20px}
.modal-ov.open{display:flex}
.modal{background:#fff;width:520px;max-height:90vh;overflow-y:auto;border-radius:6px;box-shadow:0 20px 80px rgba(0,31,69,.25)}
.mh{background:var(--navy-dark);padding:18px 24px;display:flex;align-items:center;justify-content:space-between;border-radius:6px 6px 0 0}
.mh-badge{font-size:8px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(200,168,75,.6);margin-bottom:4px}
.mh h3{font-family:'Playfair Display',serif;font-size:17px;font-weight:900;color:#fff}
.mc-btn{background:none;border:none;color:rgba(255,255,255,.45);font-size:24px;cursor:pointer;line-height:1;transition:color .15s}
.mc-btn:hover{color:#fff}
.mb{padding:22px 24px}
.mf{padding:14px 24px;display:flex;gap:9px;justify-content:flex-end;border-top:1px solid var(--light);background:#fafaf8;border-radius:0 0 6px 6px}
.fg{margin-bottom:16px}
.fl{display:block;font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:6px}
.fi{width:100%;border:1px solid var(--light);background:var(--off);padding:9px 12px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--navy-dark);outline:none;border-radius:3px;transition:border-color .2s}
.fi:focus{border-color:var(--navy);background:#fff}
.fsel2{width:100%;border:1px solid var(--light);background:var(--off);padding:9px 12px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--navy-dark);outline:none;border-radius:3px}
.f2{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.form-note{font-size:11px;color:var(--grey);line-height:1.5;margin-top:-8px;margin-bottom:16px;background:var(--gold-dim);border:1px solid rgba(200,168,75,.25);padding:8px 12px;border-radius:3px}
.btn-cxl{padding:8px 16px;background:#fff;color:var(--grey);border:1px solid var(--light);cursor:pointer;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:600;border-radius:3px;transition:all .2s}
.btn-cxl:hover{border-color:var(--navy);color:var(--navy)}
.btn-sub{padding:8px 20px;background:var(--navy-dark);color:var(--gold);border:none;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.5px;border-radius:3px;transition:background .2s}
.btn-sub:hover{background:var(--navy-mid)}

/* ── SLIDE PANEL ── */
.dim-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:400;display:none}
.dim-overlay.open{display:block}
.slide-panel{position:fixed;top:0;right:0;width:420px;height:100vh;background:#fff;z-index:500;transform:translateX(100%);transition:transform .3s cubic-bezier(.4,0,.2,1);display:flex;flex-direction:column;box-shadow:-4px 0 32px rgba(0,31,69,.12)}
.slide-panel.open{transform:translateX(0)}
.sp-head{background:var(--navy-dark);padding:18px 22px;display:flex;align-items:flex-start;justify-content:space-between;flex-shrink:0}
.sp-head h3{font-family:'Playfair Display',serif;font-size:16px;font-weight:900;color:#fff;line-height:1.3}
.sp-sub{font-size:11px;color:rgba(255,255,255,.45);margin-top:3px}
.sp-close{background:none;border:none;color:rgba(255,255,255,.45);font-size:22px;cursor:pointer;line-height:1;transition:color .15s}
.sp-close:hover{color:#fff}
.sp-body{flex:1;overflow-y:auto;padding:20px 22px}
.sp-foot{padding:12px 22px;border-top:1px solid var(--light);background:#fafaf8;display:flex;gap:8px;flex-shrink:0}
.sp-row{display:flex;justify-content:space-between;align-items:flex-start;padding:10px 0;border-bottom:1px solid var(--light);gap:12px}
.sp-row:last-child{border-bottom:none}
.sp-label{font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);flex-shrink:0;margin-top:1px}
.sp-val{font-size:12px;font-weight:600;color:var(--navy);text-align:right}
.sp-sec-title{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);margin:18px 0 10px;padding-bottom:6px;border-bottom:1px solid var(--light)}
.log-item{display:flex;gap:10px;padding:8px 0;border-bottom:1px solid var(--light)}
.log-item:last-child{border-bottom:none}
.log-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0;margin-top:4px}
.log-body{flex:1}
.log-action{font-size:11px;font-weight:600;color:var(--navy)}
.log-time{font-size:10px;color:var(--grey);margin-top:2px}

/* ── PAGINATION ── */
.pag{display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-top:1px solid var(--light);font-size:11px;color:var(--grey)}
.pag-btns{display:flex;gap:4px}
.pag-btn{padding:5px 10px;border:1px solid var(--light);background:#fff;cursor:pointer;font-size:11px;font-family:'DM Sans',sans-serif;border-radius:3px;transition:all .2s}
.pag-btn:hover{border-color:var(--navy);color:var(--navy)}
.pag-btn.active{background:var(--navy-dark);color:#fff;border-color:var(--navy-dark)}
</style>
@endsection

@section('content')

{{-- Stat Cards --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:22px" id="stat-grid">
    <div class="sc" onclick="filterStatus('')">
        <div class="sc-bar" style="background:var(--navy)"></div>
        <div class="sc-lbl">Total Chapters</div>
        <div class="sc-val" id="stat-total">0</div>
        <div class="sc-sub">Registered accounts</div>
    </div>
    <div class="sc" onclick="filterStatus('active')">
        <div class="sc-bar" style="background:var(--green)"></div>
        <div class="sc-lbl">Active</div>
        <div class="sc-val" id="stat-active">0</div>
        <div class="sc-sub">Portal access enabled</div>
    </div>
    <div class="sc" onclick="filterStatus('pending')">
        <div class="sc-bar" style="background:var(--amber)"></div>
        <div class="sc-lbl">Pending Setup</div>
        <div class="sc-val" id="stat-pending">0</div>
        <div class="sc-sub">Awaiting onboarding</div>
    </div>
    <div class="sc" onclick="filterStatus('inactive')">
        <div class="sc-bar" style="background:var(--grey)"></div>
        <div class="sc-lbl">Inactive</div>
        <div class="sc-val" id="stat-inactive">0</div>
        <div class="sc-sub">Access suspended</div>
    </div>
</div>

{{-- Main Panel --}}
<div class="panel">
    <div class="ph">
        <div class="pt">Student Chapter <em>Accounts</em></div>
        <span style="font-size:11px;color:var(--grey)" id="result-count"></span>
    </div>

    <div class="sr">
        <div class="si-wrap">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" id="search-input" placeholder="Search chapters, universities…" oninput="applyFilters()"/>
        </div>
        <select class="fsel" id="filter-status" onchange="applyFilters()">
            <option value="">All Statuses</option>
            <option value="active">Active</option>
            <option value="pending">Pending</option>
            <option value="inactive">Inactive</option>
            <option value="suspended">Suspended</option>
        </select>
        <select class="fsel" id="filter-state" onchange="applyFilters()">
            <option value="">All States</option>
            <option>Kuala Lumpur</option>
            <option>Selangor</option>
            <option>Johor</option>
            <option>Penang</option>
            <option>Perak</option>
            <option>Pahang</option>
            <option>Sabah</option>
            <option>Sarawak</option>
        </select>
    </div>

    <div class="tbl-wrap">
        <table class="ch-table">
            <thead>
                <tr>
                    <th class="ch-num">#</th>
                    <th>Chapter / Institution</th>
                    <th>Contact</th>
                    <th>State</th>
                    <th>Members</th>
                    <th>Last Login</th>
                    <th>Status</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody id="chapter-tbody"></tbody>
        </table>
        <div id="empty-state" class="empty-state" style="display:none">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <div class="empty-title">No chapters found</div>
            <div class="empty-sub">Try adjusting your search or filter criteria.</div>
        </div>
    </div>

    <div class="pag">
        <span id="pag-info"></span>
        <div class="pag-btns" id="pag-btns"></div>
    </div>
</div>

{{-- Slide-out Detail Panel --}}
<div class="dim-overlay" id="dimOverlay" onclick="closePanel()"></div>
<div class="slide-panel" id="slidePanel">
    <div class="sp-head">
        <div>
            <div style="font-size:8px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(200,168,75,.6);margin-bottom:4px">Chapter Account</div>
            <h3 id="sp-name">Chapter Details</h3>
            <div class="sp-sub" id="sp-uni"></div>
        </div>
        <button class="sp-close" onclick="closePanel()">×</button>
    </div>
    <div class="sp-body" id="sp-body"></div>
    <div class="sp-foot" id="sp-foot"></div>
</div>

{{-- Create Modal --}}
<div class="modal-ov" id="createModal" onclick="if(event.target===this)closeCreateModal()">
    <div class="modal" onclick="event.stopPropagation()">
        <div class="mh">
            <div>
                <div class="mh-badge">New Account</div>
                <h3>Create Chapter Account</h3>
            </div>
            <button class="mc-btn" onclick="closeCreateModal()">×</button>
        </div>
        <div class="mb">
            <div class="form-note">
                An email with login credentials will be sent to the chapter liaison upon creation.
            </div>
            <div class="f2">
                <div class="fg">
                    <label class="fl">Chapter Code</label>
                    <input class="fi" id="m-code" type="text" placeholder="e.g. UTM-YES"/>
                </div>
                <div class="fg">
                    <label class="fl">State</label>
                    <select class="fsel2" id="m-state">
                        <option>Kuala Lumpur</option>
                        <option>Selangor</option>
                        <option>Johor</option>
                        <option>Penang</option>
                        <option>Perak</option>
                        <option>Pahang</option>
                        <option>Sabah</option>
                        <option>Sarawak</option>
                    </select>
                </div>
            </div>
            <div class="fg">
                <label class="fl">Chapter / Institution Name</label>
                <input class="fi" id="m-name" type="text" placeholder="e.g. Universiti Teknologi Malaysia YES Chapter"/>
            </div>
            <div class="f2">
                <div class="fg">
                    <label class="fl">Liaison Name</label>
                    <input class="fi" id="m-liaison" type="text" placeholder="Full name"/>
                </div>
                <div class="fg">
                    <label class="fl">Liaison Email</label>
                    <input class="fi" id="m-email" type="email" placeholder="liaison@university.edu.my"/>
                </div>
            </div>
            <div class="f2">
                <div class="fg">
                    <label class="fl">Academic Year</label>
                    <input class="fi" id="m-year" type="text" placeholder="e.g. 2024/2025"/>
                </div>
                <div class="fg">
                    <label class="fl">Year Founded</label>
                    <input class="fi" id="m-founded" type="number" placeholder="e.g. 2018"/>
                </div>
            </div>
        </div>
        <div class="mf">
            <button class="btn-cxl" onclick="closeCreateModal()">Cancel</button>
            <button class="btn-sub" onclick="createAccount()">Create &amp; Send Credentials</button>
        </div>
    </div>
</div>

<script>
const CHAPTERS = [
    { id:1, code:'UTM-YES',  name:'UTM YES Chapter',              institution:'Universiti Teknologi Malaysia',     liaison:'Ahmad Razif',   email:'razif@utm.edu.my',    state:'Johor',          members:87, lastLogin:'2 hours ago',   status:'active',    founded:2016, year:'2024/2025' },
    { id:2, code:'UM-YES',   name:'UM YES Chapter',               institution:'Universiti Malaya',                liaison:'Sarah Lim',     email:'sarah@um.edu.my',     state:'Kuala Lumpur',   members:64, lastLogin:'Yesterday',      status:'active',    founded:2014, year:'2024/2025' },
    { id:3, code:'UTP-YES',  name:'UTP YES Chapter',              institution:'Universiti Teknologi PETRONAS',    liaison:'Hafiz Nordin',  email:'hafiz@utp.edu.my',    state:'Perak',          members:52, lastLogin:'3 days ago',     status:'active',    founded:2017, year:'2024/2025' },
    { id:4, code:'USM-YES',  name:'USM YES Chapter',              institution:'Universiti Sains Malaysia',        liaison:'Wong Jia Hui',  email:'jiahui@usm.edu.my',   state:'Penang',         members:43, lastLogin:'1 week ago',     status:'active',    founded:2015, year:'2024/2025' },
    { id:5, code:'UKM-YES',  name:'UKM YES Chapter',              institution:'Universiti Kebangsaan Malaysia',   liaison:'Nurul Ain',     email:'ain@ukm.edu.my',      state:'Selangor',       members:39, lastLogin:'2 weeks ago',    status:'active',    founded:2018, year:'2024/2025' },
    { id:6, code:'UITM-KL',  name:'UiTM KL YES Chapter',         institution:'UiTM Kuala Lumpur',                liaison:'Faizal Hamid',  email:'faizal@uitm.edu.my',  state:'Kuala Lumpur',   members:55, lastLogin:'5 days ago',     status:'active',    founded:2019, year:'2024/2025' },
    { id:7, code:'UNIMAS',   name:'UNIMAS YES Chapter',           institution:'Universiti Malaysia Sarawak',      liaison:'Ester Anak',    email:'ester@unimas.edu.my', state:'Sarawak',        members:28, lastLogin:'Never',          status:'pending',   founded:2023, year:'2024/2025' },
    { id:8, code:'UMS-YES',  name:'UMS YES Chapter',              institution:'Universiti Malaysia Sabah',        liaison:'Daniel Chin',   email:'daniel@ums.edu.my',   state:'Sabah',          members:31, lastLogin:'1 month ago',    status:'inactive',  founded:2020, year:'2023/2024' },
    { id:9, code:'UTHM-YES', name:'UTHM YES Chapter',             institution:'Universiti Tun Hussein Onn',       liaison:'Norzaidi',      email:'zaidi@uthm.edu.my',   state:'Johor',          members:22, lastLogin:'Never',          status:'pending',   founded:2024, year:'2024/2025' },
    { id:10,code:'MMU-YES',  name:'MMU YES Chapter',              institution:'Multimedia University',            liaison:'Priya Nair',    email:'priya@mmu.edu.my',    state:'Selangor',       members:0,  lastLogin:'Never',          status:'suspended', founded:2021, year:'2023/2024' },
];

const STATUS_BADGE = {
    active:    '<span class="badge badge-active"><svg viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>Active</span>',
    pending:   '<span class="badge badge-pending"><svg viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>Pending</span>',
    inactive:  '<span class="badge badge-inactive"><svg viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>Inactive</span>',
    suspended: '<span class="badge badge-suspended"><svg viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>Suspended</span>',
};

let filtered = [...CHAPTERS];
const PER_PAGE = 8;
let currentPage = 1;

function updateStats() {
    document.getElementById('stat-total').textContent   = CHAPTERS.length;
    document.getElementById('stat-active').textContent  = CHAPTERS.filter(c => c.status === 'active').length;
    document.getElementById('stat-pending').textContent = CHAPTERS.filter(c => c.status === 'pending').length;
    document.getElementById('stat-inactive').textContent= CHAPTERS.filter(c => c.status === 'inactive').length;
}

function applyFilters() {
    const q    = document.getElementById('search-input').value.toLowerCase();
    const st   = document.getElementById('filter-status').value;
    const state= document.getElementById('filter-state').value;
    filtered = CHAPTERS.filter(c =>
        (!q    || c.name.toLowerCase().includes(q) || c.institution.toLowerCase().includes(q) || c.code.toLowerCase().includes(q) || c.liaison.toLowerCase().includes(q)) &&
        (!st   || c.status === st) &&
        (!state|| c.state === state)
    );
    currentPage = 1;
    renderTable();
}

function filterStatus(s) {
    document.getElementById('filter-status').value = s;
    applyFilters();
}

function renderTable() {
    const tbody = document.getElementById('chapter-tbody');
    const empty = document.getElementById('empty-state');
    const total = filtered.length;
    const start = (currentPage - 1) * PER_PAGE;
    const page  = filtered.slice(start, start + PER_PAGE);

    document.getElementById('result-count').textContent = total + ' chapter' + (total !== 1 ? 's' : '');

    if (!total) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        document.querySelector('.pag').style.display = 'none';
        return;
    }
    empty.style.display = 'none';
    document.querySelector('.pag').style.display = 'flex';

    tbody.innerHTML = page.map((c, i) => `
        <tr>
            <td class="ch-num">${start + i + 1}</td>
            <td>
                <div class="ch-name">${c.name}</div>
                <div class="ch-uni">${c.code} · ${c.institution}</div>
            </td>
            <td>
                <div class="ch-name" style="font-weight:500">${c.liaison}</div>
                <div class="ch-email">${c.email}</div>
            </td>
            <td><span style="font-size:12px;color:var(--navy)">${c.state}</span></td>
            <td><span style="font-size:13px;font-weight:700;color:var(--navy)">${c.members}</span></td>
            <td><span style="font-size:11px;color:var(--grey)">${c.lastLogin}</span></td>
            <td>${STATUS_BADGE[c.status] || ''}</td>
            <td>
                <div class="act-group">
                    <button class="btn-sm primary" onclick="openDetail(${c.id})">View</button>
                    ${c.status === 'active'
                        ? `<button class="btn-sm danger" onclick="toggleStatus(${c.id},'inactive')">Disable</button>`
                        : `<button class="btn-sm success" onclick="toggleStatus(${c.id},'active')">Enable</button>`
                    }
                </div>
            </td>
        </tr>
    `).join('');

    renderPagination(total);
    document.getElementById('pag-info').textContent =
        `Showing ${start + 1}–${Math.min(start + PER_PAGE, total)} of ${total}`;
}

function renderPagination(total) {
    const pages = Math.ceil(total / PER_PAGE);
    const btns  = document.getElementById('pag-btns');
    if (pages <= 1) { btns.innerHTML = ''; return; }
    btns.innerHTML = Array.from({length: pages}, (_, i) =>
        `<button class="pag-btn ${i + 1 === currentPage ? 'active' : ''}" onclick="goPage(${i+1})">${i+1}</button>`
    ).join('');
}

function goPage(p) { currentPage = p; renderTable(); }

function openDetail(id) {
    const c = CHAPTERS.find(x => x.id === id);
    if (!c) return;
    document.getElementById('sp-name').textContent = c.name;
    document.getElementById('sp-uni').textContent  = c.institution;

    const logs = [
        { action: 'Annual report submitted', time: '3 days ago', color: 'var(--blue)' },
        { action: 'Budget request #BR-014 submitted', time: '1 week ago', color: 'var(--amber)' },
        { action: 'Org chart updated', time: '2 weeks ago', color: 'var(--navy)' },
        { action: 'Account activated', time: c.founded + '/01/01', color: 'var(--green)' },
    ];

    document.getElementById('sp-body').innerHTML = `
        <div class="sp-row"><span class="sp-label">Code</span><span class="sp-val">${c.code}</span></div>
        <div class="sp-row"><span class="sp-label">State</span><span class="sp-val">${c.state}</span></div>
        <div class="sp-row"><span class="sp-label">Status</span><span class="sp-val">${STATUS_BADGE[c.status]}</span></div>
        <div class="sp-row"><span class="sp-label">Liaison</span><span class="sp-val">${c.liaison}</span></div>
        <div class="sp-row"><span class="sp-label">Email</span><span class="sp-val" style="word-break:break-all">${c.email}</span></div>
        <div class="sp-row"><span class="sp-label">Members</span><span class="sp-val">${c.members}</span></div>
        <div class="sp-row"><span class="sp-label">Academic Year</span><span class="sp-val">${c.year}</span></div>
        <div class="sp-row"><span class="sp-label">Founded</span><span class="sp-val">${c.founded}</span></div>
        <div class="sp-row"><span class="sp-label">Last Login</span><span class="sp-val">${c.lastLogin}</span></div>
        <div class="sp-sec-title">Recent Activity</div>
        ${logs.map(l => `
            <div class="log-item">
                <div class="log-dot" style="background:${l.color};margin-top:5px"></div>
                <div class="log-body">
                    <div class="log-action">${l.action}</div>
                    <div class="log-time">${l.time}</div>
                </div>
            </div>
        `).join('')}
    `;

    document.getElementById('sp-foot').innerHTML = `
        <button class="btn-sm primary" onclick="resetPassword(${c.id})" style="flex:1;justify-content:center">Reset Password</button>
        ${c.status === 'active'
            ? `<button class="btn-sm danger" onclick="toggleStatus(${c.id},'inactive');closePanel()" style="flex:1;justify-content:center">Disable Access</button>`
            : `<button class="btn-sm success" onclick="toggleStatus(${c.id},'active');closePanel()" style="flex:1;justify-content:center">Enable Access</button>`
        }
    `;

    document.getElementById('dimOverlay').classList.add('open');
    document.getElementById('slidePanel').classList.add('open');
}

function closePanel() {
    document.getElementById('dimOverlay').classList.remove('open');
    document.getElementById('slidePanel').classList.remove('open');
}

function toggleStatus(id, newStatus) {
    const c = CHAPTERS.find(x => x.id === id);
    if (!c) return;
    c.status    = newStatus;
    c.lastLogin = newStatus === 'active' ? 'Just now' : c.lastLogin;
    updateStats();
    applyFilters();
}

function resetPassword(id) {
    alert('Password reset email sent to the chapter liaison.');
}

function openCreateModal()  { document.getElementById('createModal').classList.add('open'); }
function closeCreateModal() { document.getElementById('createModal').classList.remove('open'); }

function createAccount() {
    const code    = document.getElementById('m-code').value.trim();
    const name    = document.getElementById('m-name').value.trim();
    const liaison = document.getElementById('m-liaison').value.trim();
    const email   = document.getElementById('m-email').value.trim();
    const state   = document.getElementById('m-state').value;
    const year    = document.getElementById('m-year').value.trim();
    const founded = parseInt(document.getElementById('m-founded').value) || new Date().getFullYear();
    if (!code || !name || !liaison || !email) { alert('Please fill in all required fields.'); return; }
    CHAPTERS.push({ id: CHAPTERS.length + 1, code, name, institution: name, liaison, email, state, members: 0, lastLogin: 'Never', status: 'pending', founded, year });
    updateStats();
    applyFilters();
    closeCreateModal();
    document.getElementById('m-code').value = document.getElementById('m-name').value =
    document.getElementById('m-liaison').value = document.getElementById('m-email').value =
    document.getElementById('m-year').value = document.getElementById('m-founded').value = '';
}

updateStats();
applyFilters();
</script>
@endsection
