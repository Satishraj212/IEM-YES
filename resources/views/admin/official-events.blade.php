@extends('admin.layouts.app')

@section('title', 'Official Events')

@section('topbar-actions')
<button class="btn-primary" onclick="openCreateModal()">
    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Create Event
</button>
@endsection

@section('styles')
<style>
/* ── EXPANDED ROW ── */
.ev-list{display:flex;flex-direction:column}
.ev-row{border-bottom:1px solid var(--light)}
.ev-row:last-child{border-bottom:none}
.ev-summary{display:flex;align-items:center;padding:14px 20px;cursor:pointer;gap:12px}
.ev-summary:hover{background:#fafaf8}
.ev-summary.expanded{background:#f5f4f0}
.ev-chevron{width:16px;height:16px;flex-shrink:0;stroke:var(--grey);fill:none;stroke-width:2;transition:transform .2s;margin-left:6px}
.ev-chevron.open{transform:rotate(180deg)}
.ev-info-wrap{flex:1;min-width:0}
.ev-name{font-size:13px;font-weight:600;color:var(--navy)}
.ev-meta{display:flex;align-items:center;gap:12px;margin-top:4px;flex-wrap:wrap}
.ev-meta-item{display:flex;align-items:center;gap:4px;font-size:11px;color:var(--grey)}
.ev-meta-item svg{width:11px;height:11px;stroke:var(--grey);fill:none;stroke-width:2;flex-shrink:0}
.ev-right{display:flex;align-items:center;gap:10px;flex-shrink:0}
.ev-detail{display:none;background:#f9f8f6;border-top:1px solid var(--light)}
.ev-detail.open{display:block}
.ev-detail-inner{padding:20px;display:grid;grid-template-columns:160px 1fr 240px;gap:20px}

/* poster col */
.poster-col .sec-lbl,.desc-col .sec-lbl,.info-col .sec-lbl{font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:8px;display:flex;align-items:center;gap:5px}
.poster-col .sec-lbl svg,.desc-col .sec-lbl svg,.info-col .sec-lbl svg{width:11px;height:11px;stroke:var(--grey);fill:none;stroke-width:2}
.poster-box{border:2px dashed var(--light);border-radius:3px;background:#fff;overflow:hidden;position:relative;aspect-ratio:3/4;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:border-color .2s}
.poster-box:hover{border-color:var(--navy)}
.poster-box.has-poster{border-style:solid;border-color:var(--light)}
.poster-box input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;z-index:2}
.poster-box img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;pointer-events:none}
.poster-ph{display:flex;flex-direction:column;align-items:center;gap:6px;padding:12px;text-align:center;pointer-events:none}
.poster-ph svg{width:26px;height:26px;stroke:#d1d5db;fill:none;stroke-width:1.5}
.poster-ph span{font-size:10px;color:var(--grey);line-height:1.5}
.poster-clear-btn{width:100%;padding:7px;background:var(--navy-dark);color:var(--gold);border:none;font-family:'DM Sans',sans-serif;font-size:9px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:4px}
.poster-clear-btn svg{width:10px;height:10px;stroke:var(--gold);fill:none;stroke-width:2}

/* desc col */
.desc-text{font-size:12px;color:#444;line-height:1.75;background:#fff;border:1px solid var(--light);border-radius:3px;padding:12px 14px;min-height:110px}
.notes-area{width:100%;border:1px solid var(--light);background:#fff;padding:9px 12px;font-family:'DM Sans',sans-serif;font-size:12px;color:#444;outline:none;border-radius:3px;min-height:68px;resize:vertical;line-height:1.65}
.notes-area:focus{border-color:var(--navy)}

/* info col */
.ic-grid{display:grid;grid-template-columns:1fr 1fr;gap:7px;margin-bottom:12px}
.ic{background:#fff;border:1px solid var(--light);border-radius:3px;padding:8px 10px}
.ic-lbl{font-size:8px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:2px}
.ic-val{font-size:12px;font-weight:600;color:var(--navy)}
.ic-full{grid-column:1/-1}
.seat-prog{height:4px;background:var(--light);border-radius:3px;margin-top:5px;overflow:hidden}
.seat-fill-bar{height:100%;border-radius:3px;background:var(--gold)}
.seat-fill-bar.warn{background:var(--amber)}
.seat-fill-bar.crit{background:var(--red)}
.pub-row{display:flex;align-items:center;gap:8px;padding:8px 10px;background:#fff;border:1px solid var(--light);border-radius:3px;margin-bottom:10px}
.toggle-lbl{font-size:11px;font-weight:600;color:var(--navy)}
.toggle-sub-txt{font-size:10px;color:var(--grey)}
.tag-row{margin-bottom:10px}
.tag-row-lbl{font-size:8px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:5px}
.tag-wrap{display:flex;flex-wrap:wrap;gap:5px}
.tag-pill{background:var(--gold-dim);color:#7a5b14;font-size:10px;font-weight:600;padding:2px 8px;border-radius:2px}
.action-row{display:flex;gap:7px;margin-top:4px}
.btn-edit-sm{flex:1;background:var(--navy-dark);color:#fff;border:none;padding:8px;font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;cursor:pointer;border-radius:3px}
.btn-del-sm{background:transparent;color:var(--red);border:1px solid rgba(192,57,43,.3);padding:8px;font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;cursor:pointer;border-radius:3px}
.btn-del-sm:hover{background:var(--red-l)}

/* pipeline */
.pipeline{display:flex;align-items:center;padding:16px 0 4px}
.pip-step{display:flex;flex-direction:column;align-items:center;flex:1;position:relative}
.pip-step:not(:last-child)::after{content:'';position:absolute;top:16px;left:50%;width:100%;height:2px;background:var(--light);z-index:0}
.pip-step.done::after{background:var(--gold)}
.pip-dot{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;position:relative;z-index:1;border:2px solid var(--light);background:#fff}
.pip-dot svg{width:13px;height:13px;stroke:var(--grey);fill:none;stroke-width:2}
.pip-step.done .pip-dot{background:var(--navy-dark);border-color:var(--navy-dark)}
.pip-step.done .pip-dot svg{stroke:var(--gold)}
.pip-step.current .pip-dot{background:var(--gold);border-color:var(--gold)}
.pip-step.current .pip-dot svg{stroke:#fff}
.pip-lbl{font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);margin-top:7px;text-align:center}
.pip-step.done .pip-lbl{color:var(--navy)}
.pip-step.current .pip-lbl{color:var(--gold)}

/* create modal */
.modal-ov{position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:900;display:none;align-items:center;justify-content:center}
.modal-ov.open{display:flex}
.modal{background:#fff;width:640px;max-height:92vh;overflow-y:auto;border-radius:4px;box-shadow:0 24px 60px rgba(0,31,69,.3)}
.mh{background:var(--navy-dark);padding:18px 24px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:10}
.mh h3{font-family:'Playfair Display',serif;font-size:17px;font-weight:900;color:#fff}
.mc-btn{background:none;border:none;color:rgba(255,255,255,.45);font-size:22px;cursor:pointer;line-height:1;transition:color .15s}
.mc-btn:hover{color:#fff}
.mb{padding:22px 24px}
.fg{margin-bottom:14px}
.fl{display:block;font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:5px}
.fi,.fsel2,.fta{width:100%;border:1px solid var(--light);background:var(--off);padding:9px 12px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);outline:none;transition:border-color .2s;border-radius:2px}
.fi:focus,.fsel2:focus,.fta:focus{border-color:var(--navy);background:#fff}
.fta{min-height:80px;resize:vertical}
.f2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.f3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px}
.mf{padding:12px 24px 20px;display:flex;gap:9px;justify-content:flex-end;border-top:1px solid var(--light);position:sticky;bottom:0;background:#fff;z-index:5}
.btn-sub{background:var(--navy-dark);color:#fff;border:none;padding:9px 22px;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;cursor:pointer;border-radius:2px}
.btn-cxl{background:transparent;color:var(--grey);border:1px solid var(--light);padding:9px 18px;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:600;cursor:pointer;border-radius:2px}
.modal-toggle-row{display:flex;align-items:center;gap:10px;padding:10px 12px;background:var(--off);border:1px solid var(--light);border-radius:3px}
.modal-toggle-lbl{font-size:12px;font-weight:600;color:var(--navy)}
.modal-toggle-sub{font-size:10px;color:var(--grey);margin-top:1px}
.modal-section-div{border-top:1px solid var(--light);margin:16px 0 14px;padding-top:14px}
.modal-section-lbl{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);margin-bottom:12px}
.modal-poster-zone{border:2px dashed var(--light);border-radius:3px;background:var(--off);cursor:pointer;position:relative;overflow:hidden;aspect-ratio:3/4}
.modal-poster-zone:hover{border-color:var(--navy)}
.modal-poster-zone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;z-index:2}
.modal-poster-zone img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;pointer-events:none}
.modal-poster-ph{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;height:100%;padding:16px;pointer-events:none}
.modal-poster-ph svg{width:28px;height:28px;stroke:#d1d5db;fill:none;stroke-width:1.5}
.modal-poster-ph .ph-title{font-size:11px;font-weight:600;color:var(--grey)}
.modal-poster-ph .ph-sub{font-size:9px;color:#bbb;text-transform:uppercase;letter-spacing:.5px;font-weight:700}
.del-center{text-align:center;padding:32px 20px}
.del-icon-circle{width:56px;height:56px;border-radius:50%;background:var(--red-l);border:2px solid rgba(192,57,43,.15);display:flex;align-items:center;justify-content:center;margin:0 auto 16px}
.del-icon-circle svg{width:24px;height:24px;stroke:var(--red);fill:none;stroke-width:2}
.del-title{font-family:'Playfair Display',serif;font-size:17px;font-weight:700;color:var(--navy);margin-bottom:8px}
.del-msg{font-size:12px;color:var(--grey);line-height:1.7;max-width:340px;margin:0 auto}
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:16px}
.info-card{background:var(--off);border:1px solid var(--light);border-radius:3px;padding:11px 14px}
.ic-lbl2{font-size:8px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:3px}
.ic-val2{font-size:13px;font-weight:600;color:var(--navy)}
</style>
@endsection

@section('content')

{{-- Stat Pills --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:22px">
    <div class="sc" onclick="filterTabGlobal('all')">
        <div class="sc-bar" style="background:var(--navy)"></div>
        <div class="sc-lbl">Total Events</div><div class="sc-val">{{ $counts['all'] }}</div><div class="sc-sub">This year</div>
    </div>
    <div class="sc" onclick="filterTabGlobal('open')">
        <div class="sc-bar" style="background:var(--green)"></div>
        <div class="sc-lbl">Open</div><div class="sc-val">{{ $counts['open'] }}</div><div class="sc-sub">Registration active</div>
    </div>
    <div class="sc" onclick="filterTabGlobal('upcoming')">
        <div class="sc-bar" style="background:var(--blue)"></div>
        <div class="sc-lbl">Upcoming</div><div class="sc-val">{{ $counts['upcoming'] }}</div><div class="sc-sub">Registration not open</div>
    </div>
    <div class="sc" onclick="filterTabGlobal('past')">
        <div class="sc-bar" style="background:var(--grey)"></div>
        <div class="sc-lbl">Past</div><div class="sc-val">{{ $counts['past'] }}</div><div class="sc-sub">Completed</div>
    </div>
</div>

{{-- Main Panel --}}
<div class="panel">
    <div class="ph">
        <div class="pt">Official Board <em>Events</em></div>
        <button class="btn-primary" onclick="openCreateModal()" style="font-size:10px;padding:7px 13px">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>New Event
        </button>
    </div>
    <div style="padding:16px 20px 0">
        <div class="tabs">
            <button class="tab active" id="tab-all"      onclick="filterTabGlobal('all')">All ({{ $counts['all'] }})</button>
            <button class="tab"        id="tab-open"     onclick="filterTabGlobal('open')">Open ({{ $counts['open'] }})</button>
            <button class="tab"        id="tab-upcoming" onclick="filterTabGlobal('upcoming')">Upcoming ({{ $counts['upcoming'] }})</button>
            <button class="tab"        id="tab-past"     onclick="filterTabGlobal('past')">Past ({{ $counts['past'] }})</button>
        </div>
        <div class="sr">
            <div class="si-wrap">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" placeholder="Search events, locations…" oninput="searchList(this)"/>
            </div>
            <select class="fsel" onchange="sortList(this)">
                <option value="date">Sort: Date Soonest</option>
                <option value="name">Name A–Z</option>
            </select>
        </div>
    </div>
    <div class="ev-list" id="ev-list"></div>
</div>

{{-- Slide-out Panel --}}
<div class="dim-overlay" id="dimOverlay" onclick="closePanel()"></div>
<div class="slide-panel" id="slidePanel">
    <div class="sp-head">
        <div><div class="sp-mode-badge" id="spModeBadge">View</div><h3 id="spTitle">Event Details</h3></div>
        <button class="sp-close" onclick="closePanel()">×</button>
    </div>
    <div class="sp-body" id="spBody"></div>
    <div class="sp-foot" id="spFoot"></div>
</div>

{{-- Create Modal --}}
<div class="modal-ov" id="cm" onclick="if(event.target===this)closeCreateModal()">
    <div class="modal" onclick="event.stopPropagation()">
        <div class="mh">
            <h3>Create Official Event</h3>
            <button class="mc-btn" onclick="closeCreateModal()">×</button>
        </div>
        <div class="mb">
            <div style="display:grid;grid-template-columns:1fr 148px;gap:20px;align-items:start">
                <div>
                    <div class="fg"><label class="fl">Event Title</label><input class="fi" id="m-name" type="text" placeholder="e.g. YES Leadership Forum 2025"/></div>
                    <div class="f2">
                        <div class="fg"><label class="fl">Category</label>
                            <select class="fsel2" id="m-cat">
                                @foreach($categories as $cat)<option>{{ $cat }}</option>@endforeach
                            </select></div>
                        <div class="fg"><label class="fl">Branch</label>
                            <select class="fsel2" id="m-branch">
                                @foreach($branches as $branch)<option>{{ $branch->name }}</option>@endforeach
                            </select></div>
                    </div>
                    <div class="f2">
                        <div class="fg"><label class="fl">Start Date</label><input class="fi" id="m-date" type="date"/></div>
                        <div class="fg"><label class="fl">End Date (optional)</label><input class="fi" id="m-date-end" type="date"/></div>
                    </div>
                    <div class="fg"><label class="fl">Location</label><input class="fi" id="m-loc" type="text" placeholder="e.g. KL Convention Centre"/></div>
                </div>
                <div>
                    <label class="fl" style="margin-bottom:8px">Event Poster</label>
                    <div class="modal-poster-zone" id="m-poster-zone">
                        <input type="file" id="m-poster-input" accept="image/*" onchange="handleModalFile(this)"/>
                        <div class="modal-poster-ph" id="m-poster-ph">
                            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <span class="ph-title">Click or drag to upload</span>
                            <span class="ph-sub">PNG · JPG · max 5 MB</span>
                        </div>
                        <img id="m-poster-img" src="" alt="" style="display:none"/>
                    </div>
                </div>
            </div>
            <div class="f3" style="margin-top:4px">
                <div class="fg"><label class="fl">Total Seats</label><input class="fi" id="m-seats" type="number" placeholder="Unlimited"/></div>
                <div class="fg"><label class="fl">Registered</label><input class="fi" id="m-reg" type="number" placeholder="0"/></div>
                <div class="fg"><label class="fl">Status</label>
                    <select class="fsel2" id="m-status">
                        <option value="upcoming">Upcoming</option><option value="open">Open</option><option value="past">Past</option>
                    </select></div>
            </div>
            <div class="fg"><label class="fl">Organiser / Contact Person</label><input class="fi" id="m-organiser" type="text" placeholder="e.g. Ahmad Razif Hakim"/></div>
            <div class="fg"><label class="fl">Tags (comma separated)</label><input class="fi" id="m-tags" type="text" placeholder="e.g. Annual, Board, Strategy"/></div>
            <div class="modal-section-div">
                <div class="modal-section-lbl">Description &amp; Notes</div>
                <div class="fg"><label class="fl">Public-Facing Description</label><textarea class="fta" id="m-desc" placeholder="Describe the event for attendees…"></textarea></div>
                <div class="fg"><label class="fl">Admin Notes (internal)</label><textarea class="fta" id="m-notes" placeholder="Internal remarks, logistics, budget notes…" style="min-height:60px"></textarea></div>
            </div>
            <div class="fg">
                <div class="modal-toggle-row">
                    <button class="toggle" id="m-pub-toggle" onclick="togglePub()" type="button"><div class="toggle-knob"></div></button>
                    <div>
                        <div class="modal-toggle-lbl" id="m-pub-lbl">Draft — not yet published</div>
                        <div class="modal-toggle-sub" id="m-pub-sub">Toggle to make this event live on the site</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mf">
            <button class="btn-cxl" onclick="closeCreateModal()">Cancel</button>
            <button class="btn-sub" onclick="submitModal()">Create Event</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
const EVENTS = @json($events);
const CAT_CLASS = @json($catClasses);
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

let expandedId = null, currentFilter = 'all', currentSearch = '', currentSort = 'date';
let pubState = false, modalPoster = null;

/* ── RENDER ── */
function renderList() {
    let rows = [...EVENTS];
    if (currentFilter !== 'all') rows = rows.filter(e => e.status === currentFilter);
    if (currentSearch) rows = rows.filter(e =>
        e.name.toLowerCase().includes(currentSearch) || e.location.toLowerCase().includes(currentSearch));
    if (currentSort === 'name') rows.sort((a,b) => a.name.localeCompare(b.name));
    else rows.sort((a,b) => new Date(a.start_date) - new Date(b.start_date));

    const list = document.getElementById('ev-list');
    if (!rows.length) {
        list.innerHTML = '<div style="padding:40px;text-align:center;font-size:12px;color:var(--grey)">No events found.</div>';
        return;
    }
    list.innerHTML = rows.map(e => buildRow(e)).join('');
}

function buildRow(e) {
    const p = e.total_seats ? Math.round(e.registered_count / e.total_seats * 100) : 0;
    const fillCls = p >= 100 ? 'full' : (p >= 75 ? 'warn' : '');
    const stCls = {open:'b-open',upcoming:'b-upcoming',past:'b-past'}[e.status] || 'b-past';
    const isOpen = expandedId === e.id;
    const pubHtml = e.is_published
        ? `<span style="font-size:10px;font-weight:700;color:var(--green);white-space:nowrap">● Live</span>`
        : `<span style="font-size:10px;font-weight:700;color:#aaa;white-space:nowrap">○ Draft</span>`;
    const catClass = CAT_CLASS[e.category] || 'b-board';

    return `
    <div class="ev-row" id="row-${e.id}">
      <div class="ev-summary${isOpen?' expanded':''}" onclick="toggleRow(${e.id})">
        <div class="ev-info-wrap">
          <div class="ev-name">${e.name}</div>
          <div class="ev-meta">
            <div class="ev-meta-item"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>${formatDate(e.start_date)}</div>
            <div class="ev-meta-item"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>${e.location}</div>
            <div class="ev-meta-item"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>${e.organiser || '—'}</div>
          </div>
        </div>
        <div class="ev-right">
          <span class="badge ${catClass}">${e.category}</span>
          <span class="badge ${stCls}">${cap(e.status)}</span>
          ${pubHtml}
          <div class="abtns" onclick="event.stopPropagation()">
            <button class="abtn" title="View"   onclick="openPanel('view',${e.id})"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
            <button class="abtn" title="Edit"   onclick="openPanel('edit',${e.id})"><svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>
            <button class="abtn del" title="Delete" onclick="openPanel('delete',${e.id})"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg></button>
          </div>
          <svg class="ev-chevron${isOpen?' open':''}" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
        </div>
      </div>
      <div class="ev-detail${isOpen?' open':''}" id="detail-${e.id}">
        <div class="ev-detail-inner">
          <div class="poster-col">
            <div class="sec-lbl"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>Poster / Artwork</div>
            <div class="poster-box${e.poster_url?' has-poster':''}" id="pbox-${e.id}">
              <input type="file" accept="image/*" onchange="handleInlineFile(this,${e.id})"/>
              <div id="pph-${e.id}" style="display:${e.poster_url?'none':'flex'};flex-direction:column;align-items:center;justify-content:center;gap:6px;height:100%;padding:12px;text-align:center;pointer-events:none">
                <svg viewBox="0 0 24 24" style="width:28px;height:28px;stroke:#d1d5db;fill:none;stroke-width:1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                <span style="font-size:10px;color:var(--grey);line-height:1.5">Click or drag to upload poster</span>
              </div>
              <img id="pimg-${e.id}" src="${e.poster_url||''}" alt="" style="display:${e.poster_url?'block':'none'}"/>
            </div>
            <button id="pclr-${e.id}" class="poster-clear-btn" onclick="clearInlinePoster(${e.id})" style="display:${e.poster_url?'flex':'none'}">
              <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>Remove
            </button>
          </div>
          <div class="desc-col">
            <div class="sec-lbl"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>Public Description</div>
            <div class="desc-text">${e.description || '<span style="color:#bbb;font-style:italic">No description added yet.</span>'}</div>
            <div class="sec-lbl" style="margin-top:14px"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>Admin Notes</div>
            <textarea class="notes-area" placeholder="Add internal notes…" onchange="saveNote(${e.id},this.value)">${e.admin_notes || ''}</textarea>
          </div>
          <div class="info-col">
            <div class="sec-lbl"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>Event Info</div>
            <div class="ic-grid">
              <div class="ic ic-full"><div class="ic-lbl">Category</div><div class="ic-val"><span class="badge ${CAT_CLASS[e.category]||'b-board'}">${e.category}</span></div></div>
              <div class="ic"><div class="ic-lbl">Date</div><div class="ic-val">${formatDate(e.start_date)}</div></div>
              <div class="ic"><div class="ic-lbl">Branch</div><div class="ic-val">${e.branch_name || 'National'}</div></div>
              <div class="ic ic-full"><div class="ic-lbl">Location</div><div class="ic-val">${e.location}</div></div>
              <div class="ic ic-full"><div class="ic-lbl">Organiser</div><div class="ic-val">${e.organiser || '—'}</div></div>
              ${e.total_seats ? `<div class="ic ic-full"><div class="ic-lbl">Registration</div><div class="ic-val">${e.registered_count} / ${e.total_seats} <span style="font-weight:400;color:var(--grey);font-size:10px">(${Math.round(e.registered_count/e.total_seats*100)}%)</span></div><div class="seat-prog"><div class="seat-fill-bar${e.registered_count/e.total_seats>=1?' crit':e.registered_count/e.total_seats>=.75?' warn':''}" style="width:${Math.min(100,Math.round(e.registered_count/e.total_seats*100))}%"></div></div></div>` : `<div class="ic ic-full"><div class="ic-lbl">Seats</div><div class="ic-val" style="color:var(--grey);font-weight:400">No limit</div></div>`}
            </div>
            <div class="pub-row">
              <button class="toggle${e.is_published?' on':''}" id="rpub-${e.id}" onclick="toggleInlinePub(${e.id})" type="button"><div class="toggle-knob"></div></button>
              <div>
                <div class="toggle-lbl" id="rpub-lbl-${e.id}">${e.is_published?'Published (Live)':'Draft (Not visible)'}</div>
                <div class="toggle-sub-txt">Visible on public site</div>
              </div>
            </div>
            <div class="tag-row">
              <div class="tag-row-lbl">Tags</div>
              <div class="tag-wrap">${(e.tags||[]).map(t=>`<span class="tag-pill">${t}</span>`).join('') || '<span style="font-size:11px;color:#bbb">None</span>'}</div>
            </div>
            <div class="action-row">
              <button class="btn-edit-sm" onclick="openPanel('edit',${e.id});event.stopPropagation()">Edit Event</button>
              <button class="btn-del-sm"  onclick="openPanel('delete',${e.id});event.stopPropagation()">Delete</button>
            </div>
          </div>
        </div>
      </div>
    </div>`;
}

/* ── UTILS ── */
function cap(s){ return s.charAt(0).toUpperCase() + s.slice(1); }
function formatDate(d){ if(!d) return '—'; return new Date(d).toLocaleDateString('en-GB',{day:'numeric',month:'short',year:'numeric'}); }

/* ── TOGGLE ROW ── */
function toggleRow(id){ expandedId = expandedId === id ? null : id; renderList(); }

/* ── FILTERS ── */
function filterTabGlobal(s){
    currentFilter = s;
    ['all','open','upcoming','past'].forEach(x => document.getElementById('tab-'+x)?.classList.remove('active'));
    document.getElementById('tab-'+s)?.classList.add('active');
    expandedId = null; renderList();
}
function searchList(inp){ currentSearch = inp.value.toLowerCase(); expandedId = null; renderList(); }
function sortList(sel){ currentSort = sel.value; renderList(); }

/* ── INLINE POSTER ── */
function handleInlineFile(input, id){
    const file = input.files[0];
    if(!file) return;
    if(file.size > 5*1024*1024){ showToast('File too large (max 5 MB)','danger'); return; }
    const reader = new FileReader();
    reader.onload = ev => {
        const idx = EVENTS.findIndex(x=>x.id===id);
        if(idx > -1) EVENTS[idx].poster_url = ev.target.result;
        const img = document.getElementById('pimg-'+id);
        const ph  = document.getElementById('pph-'+id);
        const clr = document.getElementById('pclr-'+id);
        const box = document.getElementById('pbox-'+id);
        if(img){ img.src=ev.target.result; img.style.display='block'; }
        if(ph)  ph.style.display='none';
        if(clr) clr.style.display='flex';
        if(box) box.classList.add('has-poster');
        apiPatch(id, {poster_data: ev.target.result});
        showToast('Poster uploaded','success');
    };
    reader.readAsDataURL(file);
}
function clearInlinePoster(id){
    const idx = EVENTS.findIndex(x=>x.id===id);
    if(idx > -1) EVENTS[idx].poster_url = null;
    ['pimg-'+id,'pph-'+id,'pclr-'+id,'pbox-'+id].forEach(elId => {
        const el = document.getElementById(elId);
        if(!el) return;
        if(elId.startsWith('pimg')) { el.src=''; el.style.display='none'; }
        else if(elId.startsWith('pph')) el.style.display='flex';
        else if(elId.startsWith('pclr')) el.style.display='none';
        else el.classList.remove('has-poster');
    });
    apiPatch(id, {remove_poster: true});
    showToast('Poster removed');
}

/* ── INLINE PUBLISH ── */
function toggleInlinePub(id){
    const idx = EVENTS.findIndex(x=>x.id===id);
    if(idx < 0) return;
    EVENTS[idx].is_published = !EVENTS[idx].is_published;
    const btn = document.getElementById('rpub-'+id);
    const lbl = document.getElementById('rpub-lbl-'+id);
    if(btn) btn.classList.toggle('on', EVENTS[idx].is_published);
    if(lbl) lbl.textContent = EVENTS[idx].is_published ? 'Published (Live)' : 'Draft (Not visible)';
    apiPatch(id, {is_published: EVENTS[idx].is_published});
    showToast(EVENTS[idx].is_published ? 'Event published' : 'Event unpublished', EVENTS[idx].is_published ? 'success' : '');
    renderList();
}
function saveNote(id, val){
    const idx = EVENTS.findIndex(x=>x.id===id);
    if(idx > -1) EVENTS[idx].admin_notes = val;
    apiPatch(id, {admin_notes: val});
}

/* ── API CALLS ── */
async function apiPatch(id, data){
    try {
        await fetch(`/dashboard/admin/official-events/${id}`, {
            method: 'PATCH',
            headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
            body: JSON.stringify(data)
        });
    } catch(e) { console.error(e); }
}
async function apiDelete(id){
    return fetch(`/dashboard/admin/official-events/${id}`, {
        method: 'DELETE',
        headers: {'X-CSRF-TOKEN':CSRF}
    });
}
async function apiCreate(data){
    return fetch('/dashboard/admin/official-events', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
        body: JSON.stringify(data)
    });
}

/* ── SLIDE-OUT PANEL ── */
function openPanel(mode, id){
    const e = EVENTS.find(x=>x.id===id);
    if(!e) return;
    if(mode==='view')   renderView(e);
    if(mode==='edit')   renderEditPanel(e);
    if(mode==='delete') renderDeletePanel(e);
    document.getElementById('slidePanel').classList.add('open');
    document.getElementById('dimOverlay').classList.add('on');
}
function closePanel(){
    document.getElementById('slidePanel').classList.remove('open');
    document.getElementById('dimOverlay').classList.remove('on');
}

function renderView(e){
    document.getElementById('spModeBadge').textContent = 'View Details';
    document.getElementById('spTitle').textContent = e.name;
    const p = e.total_seats ? Math.round(e.registered_count/e.total_seats*100) : 0;
    document.getElementById('spBody').innerHTML = `
        ${e.poster_url?`<div style="margin-bottom:16px;border-radius:3px;overflow:hidden;max-height:200px"><img src="${e.poster_url}" style="width:100%;object-fit:cover"/></div>`:''}
        <div class="info-grid">
            <div class="info-card"><div class="ic-lbl2">Date</div><div class="ic-val2">${formatDate(e.start_date)}</div></div>
            <div class="info-card"><div class="ic-lbl2">Status</div><div class="ic-val2"><span class="badge ${{open:'b-open',upcoming:'b-upcoming',past:'b-past'}[e.status]||'b-past'}">${cap(e.status)}</span></div></div>
            <div class="info-card" style="grid-column:1/-1"><div class="ic-lbl2">Location</div><div class="ic-val2">${e.location}</div></div>
            <div class="info-card"><div class="ic-lbl2">Category</div><div class="ic-val2"><span class="badge ${CAT_CLASS[e.category]||'b-board'}">${e.category}</span></div></div>
            <div class="info-card"><div class="ic-lbl2">Organiser</div><div class="ic-val2">${e.organiser||'—'}</div></div>
            <div class="info-card"><div class="ic-lbl2">Visibility</div><div class="ic-val2">${e.is_published?'<span style="color:var(--green);font-weight:700">● Live</span>':'<span style="color:#aaa">○ Draft</span>'}</div></div>
        </div>
        ${e.total_seats?`<div class="pf-row"><span class="pf-lbl">Registration</span><div style="display:flex;align-items:baseline;gap:8px"><span style="font-size:16px;font-weight:600;color:var(--navy)">${e.registered_count}</span><span style="font-size:12px;color:var(--grey)">/ ${e.total_seats} (${p}%)</span></div><div style="height:5px;background:var(--light);border-radius:3px;margin-top:7px;overflow:hidden"><div style="height:100%;border-radius:3px;background:var(--gold);width:${p}%"></div></div></div>`
        :'<div class="pf-row"><span class="pf-lbl">Registration</span><div class="pf-val muted">No seat limit</div></div>'}
        <hr class="pf-divider"/>
        <div class="pf-row"><span class="pf-lbl">Description</span><div class="pf-val muted">${e.description||'—'}</div></div>
        ${e.admin_notes?`<hr class="pf-divider"/><div class="pf-row"><span class="pf-lbl">Admin Notes</span><div style="background:var(--amber-l);border:1px solid rgba(217,119,6,.2);border-radius:3px;padding:10px 14px;font-size:12px;color:#78350f;line-height:1.65">${e.admin_notes}</div></div>`:''}
        <hr class="pf-divider"/>
        <div class="pf-row"><span class="pf-lbl">Tags</span><div class="tag-wrap">${(e.tags||[]).map(t=>`<span class="tag-pill">${t}</span>`).join('')||'<span style="font-size:11px;color:#bbb">None</span>'}</div></div>
        <hr class="pf-divider"/>
        <div class="pf-row"><span class="pf-lbl">Pipeline</span>
          <div class="pipeline">
            <div class="pip-step done"><div class="pip-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><div class="pip-lbl">Created</div></div>
            <div class="pip-step ${e.is_published?'done':'current'}"><div class="pip-dot"><svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></div><div class="pip-lbl">Reviewed</div></div>
            <div class="pip-step ${e.is_published?'current':''}"><div class="pip-dot"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></div><div class="pip-lbl">Published</div></div>
          </div>
        </div>`;
    document.getElementById('spFoot').innerHTML = `<button class="btn-ghost" onclick="closePanel()">Close</button><button class="btn-prim" onclick="openPanel('edit',${e.id})">Edit Event</button>`;
}

function renderEditPanel(e){
    document.getElementById('spModeBadge').textContent = 'Edit Event';
    document.getElementById('spTitle').textContent = e.name;
    const catOpts = @json($categories);
    const branchOpts = @json($branches->pluck('name'));
    document.getElementById('spBody').innerHTML = `
        <div class="pf-row"><label class="pf-lbl">Event Title</label><input class="pf-input" id="ep-name" type="text" value="${e.name}"/></div>
        <div class="pf-grid2">
            <div class="pf-row"><label class="pf-lbl">Date</label><input class="pf-input" id="ep-date" type="date" value="${e.start_date?.split('T')[0]||''}"/></div>
            <div class="pf-row"><label class="pf-lbl">Status</label>
                <select class="pf-select" id="ep-status">
                    <option value="upcoming" ${e.status==='upcoming'?'selected':''}>Upcoming</option>
                    <option value="open" ${e.status==='open'?'selected':''}>Open</option>
                    <option value="past" ${e.status==='past'?'selected':''}>Past</option>
                </select></div>
        </div>
        <div class="pf-row"><label class="pf-lbl">Location</label><input class="pf-input" id="ep-loc" type="text" value="${e.location}"/></div>
        <div class="pf-grid2">
            <div class="pf-row"><label class="pf-lbl">Category</label>
                <select class="pf-select" id="ep-cat">${catOpts.map(c=>`<option ${e.category===c?'selected':''}>${c}</option>`).join('')}</select></div>
            <div class="pf-row"><label class="pf-lbl">Branch</label>
                <select class="pf-select" id="ep-branch">${branchOpts.map(b=>`<option ${e.branch_name===b?'selected':''}>${b}</option>`).join('')}</select></div>
        </div>
        <div class="pf-grid2">
            <div class="pf-row"><label class="pf-lbl">Total Seats</label><input class="pf-input" id="ep-seats" type="number" value="${e.total_seats||''}"/></div>
            <div class="pf-row"><label class="pf-lbl">Registered</label><input class="pf-input" id="ep-reg" type="number" value="${e.registered_count||0}"/></div>
        </div>
        <div class="pf-row"><label class="pf-lbl">Organiser</label><input class="pf-input" id="ep-org" type="text" value="${e.organiser||''}"/></div>
        <div class="pf-row"><label class="pf-lbl">Tags (comma separated)</label><input class="pf-input" id="ep-tags" type="text" value="${(e.tags||[]).join(', ')}"/></div>
        <div class="pf-row"><label class="pf-lbl">Description</label><textarea class="pf-textarea" id="ep-desc">${e.description||''}</textarea></div>
        <div class="pf-row"><label class="pf-lbl">Admin Notes</label><textarea class="pf-textarea" id="ep-notes" style="min-height:60px">${e.admin_notes||''}</textarea></div>
        <div class="pf-row">
            <div style="display:flex;align-items:center;gap:10px;padding:10px 12px;background:var(--off);border:1px solid var(--light);border-radius:3px">
                <button class="toggle${e.is_published?' on':''}" id="ep-pub" onclick="this.classList.toggle('on');document.getElementById('ep-pub-lbl').textContent=this.classList.contains('on')?'Published (Live)':'Draft (Not visible)'" type="button"><div class="toggle-knob"></div></button>
                <div><div class="toggle-lbl" id="ep-pub-lbl">${e.is_published?'Published (Live)':'Draft (Not visible)'}</div><div class="toggle-sub-txt">Toggle to publish or unpublish</div></div>
            </div>
        </div>`;
    document.getElementById('spFoot').innerHTML = `<button class="btn-ghost" onclick="closePanel()">Cancel</button><button class="btn-prim" onclick="savePanelEdit(${e.id})">Save Changes</button>`;
}

async function savePanelEdit(id){
    const idx = EVENTS.findIndex(x=>x.id===id);
    if(idx < 0) return;
    const payload = {
        name:         document.getElementById('ep-name').value.trim(),
        location:     document.getElementById('ep-loc').value.trim(),
        start_date:   document.getElementById('ep-date').value,
        status:       document.getElementById('ep-status').value,
        category:     document.getElementById('ep-cat').value,
        branch_name:  document.getElementById('ep-branch').value,
        organiser:    document.getElementById('ep-org').value.trim(),
        description:  document.getElementById('ep-desc').value.trim(),
        admin_notes:  document.getElementById('ep-notes').value.trim(),
        is_published: document.getElementById('ep-pub').classList.contains('on'),
        total_seats:  document.getElementById('ep-seats').value || null,
        registered_count: document.getElementById('ep-reg').value || 0,
        tags:         document.getElementById('ep-tags').value.split(',').map(t=>t.trim()).filter(Boolean),
    };
    await apiPatch(id, payload);
    Object.assign(EVENTS[idx], payload);
    closePanel(); renderList();
    showToast('Event updated successfully','success');
}

function renderDeletePanel(e){
    document.getElementById('spModeBadge').textContent = 'Delete Event';
    document.getElementById('spTitle').textContent = 'Confirm Deletion';
    document.getElementById('spBody').innerHTML = `
        <div class="del-center">
            <div class="del-icon-circle"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg></div>
            <div class="del-title">Delete "${e.name}"?</div>
            <div class="del-msg">This will permanently remove the event and all associated data. This cannot be undone.</div>
        </div>
        <div style="margin:0 16px;background:var(--red-l);border:1px solid rgba(192,57,43,.15);border-radius:3px;padding:12px 16px">
            <div style="font-size:11px;font-weight:700;color:var(--red);margin-bottom:4px;letter-spacing:.5px">EVENT DETAILS</div>
            <div style="font-size:12px;color:#555;line-height:1.7">
                <b style="color:#333">Date:</b> ${formatDate(e.start_date)}<br>
                <b style="color:#333">Location:</b> ${e.location}<br>
                <b style="color:#333">Status:</b> ${cap(e.status)}
                ${e.total_seats?`<br><b style="color:#333">Registrations:</b> ${e.registered_count} registered`:''}
            </div>
        </div>`;
    document.getElementById('spFoot').innerHTML = `<button class="btn-ghost" onclick="closePanel()">Cancel</button><button class="btn-danger" onclick="confirmDelete(${e.id})">Delete Event</button>`;
}

async function confirmDelete(id){
    const idx = EVENTS.findIndex(x=>x.id===id);
    if(idx < 0) return;
    await apiDelete(id);
    EVENTS.splice(idx,1);
    if(expandedId===id) expandedId=null;
    closePanel(); renderList();
    showToast('Event deleted','danger');
}

/* ── CREATE MODAL ── */
function openCreateModal(){ document.getElementById('cm').classList.add('open'); }
function closeCreateModal(){ document.getElementById('cm').classList.remove('open'); }

function togglePub(){
    pubState = !pubState;
    document.getElementById('m-pub-toggle').classList.toggle('on', pubState);
    document.getElementById('m-pub-lbl').textContent = pubState ? 'Published (Live)' : 'Draft — not yet published';
}

function handleModalFile(input){
    const file = input.files[0];
    if(!file) return;
    if(file.size > 5*1024*1024){ showToast('File too large (max 5 MB)','danger'); return; }
    const reader = new FileReader();
    reader.onload = ev => {
        modalPoster = ev.target.result;
        document.getElementById('m-poster-img').src = ev.target.result;
        document.getElementById('m-poster-img').style.display = 'block';
        document.getElementById('m-poster-ph').style.display = 'none';
    };
    reader.readAsDataURL(file);
}

async function submitModal(){
    const name = document.getElementById('m-name').value.trim();
    if(!name){ showToast('Event title is required','danger'); return; }
    const payload = {
        name,
        category:    document.getElementById('m-cat').value,
        location:    document.getElementById('m-loc').value.trim()||'TBC',
        start_date:  document.getElementById('m-date').value||new Date().toISOString().split('T')[0],
        end_date:    document.getElementById('m-date-end').value||null,
        status:      document.getElementById('m-status').value,
        total_seats: document.getElementById('m-seats').value?parseInt(document.getElementById('m-seats').value):null,
        registered_count: parseInt(document.getElementById('m-reg').value)||0,
        branch_name: document.getElementById('m-branch').value,
        organiser:   document.getElementById('m-organiser').value.trim()||'Super Admin',
        tags:        document.getElementById('m-tags').value.split(',').map(t=>t.trim()).filter(Boolean),
        is_published: pubState,
        poster_data: modalPoster,
        admin_notes: document.getElementById('m-notes').value.trim(),
        description: document.getElementById('m-desc').value.trim(),
    };
    const res = await apiCreate(payload);
    const data = await res.json();
    EVENTS.unshift(data.event || {...payload, id: Date.now()});
    ['m-name','m-loc','m-seats','m-reg','m-organiser','m-tags','m-desc','m-notes','m-date','m-date-end']
        .forEach(id => { const el=document.getElementById(id); if(el) el.value=''; });
    pubState = false; modalPoster = null;
    document.getElementById('m-pub-toggle').classList.remove('on');
    document.getElementById('m-pub-lbl').textContent = 'Draft — not yet published';
    document.getElementById('m-poster-img').style.display = 'none';
    document.getElementById('m-poster-ph').style.display = 'flex';
    closeCreateModal(); renderList();
    showToast('Event created successfully','success');
}

renderList();
</script>
@endsection