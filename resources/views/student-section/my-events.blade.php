{{-- resources/views/student-section/my-events.blade.php --}}
@extends('student-section.layouts.app')

@section('title', 'My Events')

@section('styles')
<style>
/* ── EVENT LIST ── */
.ev-list{display:flex;flex-direction:column;gap:0}
.ev-row{border-bottom:1px solid var(--light)}
.ev-row:last-child{border-bottom:none}
.ev-summary{display:flex;align-items:center;gap:14px;padding:14px 20px;cursor:pointer;transition:background .15s}
.ev-summary:hover{background:var(--off)}
.ev-summary.expanded{background:var(--off)}
.ev-info-wrap{flex:1;min-width:0}
.ev-name{font-size:13px;font-weight:700;color:var(--navy);margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.ev-meta{display:flex;flex-wrap:wrap;gap:10px}
.ev-meta-item{display:flex;align-items:center;gap:4px;font-size:11px;color:var(--grey)}
.ev-meta-item svg{width:11px;height:11px;fill:none;stroke:currentColor;stroke-width:2}
.ev-right{display:flex;align-items:center;gap:8px;flex-shrink:0}
.ev-cat{display:inline-flex;align-items:center;font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;padding:3px 7px}
.b-hackathon{background:#ede9fe;color:#5b21b6}
.b-career{background:#dbeafe;color:#1e40af}
.b-sdg{background:#d1fae5;color:#065f46}
.b-workshop{background:#fef3c7;color:#92400e}
.b-webinar{background:#e0f2fe;color:#0369a1}
.b-volunteer{background:#d1fae5;color:#065f46}
.b-competition{background:#fce7f3;color:#9d174d}
.abtns{display:flex;gap:4px}
.abtn{width:28px;height:28px;display:flex;align-items:center;justify-content:center;background:var(--off);border:1px solid var(--light);cursor:pointer;transition:all .2s}
.abtn svg{width:13px;height:13px;fill:none;stroke:var(--navy);stroke-width:2}
.abtn:hover{background:var(--navy);border-color:var(--navy)}
.abtn:hover svg{stroke:#fff}
.abtn.del:hover{background:var(--red);border-color:var(--red)}
.ev-chevron{width:16px;height:16px;fill:none;stroke:var(--grey);stroke-width:2;transition:transform .2s}
.ev-chevron.open{transform:rotate(180deg)}

/* ── EVENT DETAIL EXPAND ── */
.ev-detail{max-height:0;overflow:hidden;transition:max-height .35s ease}
.ev-detail.open{max-height:800px}
.ev-detail-inner{display:grid;grid-template-columns:120px 1fr 200px;gap:20px;padding:20px;border-top:1px solid var(--light);background:#fafafa}

/* ── POSTER COL ── */
.sec-lbl{font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:8px}
.poster-box{border:2px dashed var(--light);background:#fff;aspect-ratio:3/4;overflow:hidden;cursor:pointer;position:relative;transition:border-color .2s}
.poster-box:hover{border-color:var(--navy)}
.poster-box input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.poster-box img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
.poster-box.has-poster{border-style:solid;border-color:var(--light)}
.poster-clear-btn{width:100%;margin-top:4px;padding:5px;background:none;border:1px solid var(--light);font-size:9px;font-weight:700;color:var(--red);cursor:pointer;font-family:'DM Sans',sans-serif;display:flex;align-items:center;justify-content:center}

/* ── DESC COL ── */
.desc-text{font-size:12px;color:#374151;line-height:1.65}

/* ── STATUS TRACK ── */
.status-track{display:flex;gap:0;margin:6px 0}
.st-step{display:flex;flex-direction:column;align-items:center;flex:1;position:relative}
.st-step:not(:last-child)::after{content:'';position:absolute;top:10px;left:50%;width:100%;height:1px;z-index:0}
.s-done::after{background:var(--green-a)}
.s-active::after,.s-pending::after{background:var(--light)}
.st-dot{width:20px;height:20px;border-radius:50%;display:flex;align-items:center;justify-content:center;position:relative;z-index:1;flex-shrink:0}
.s-done .st-dot{background:var(--green-a)}
.s-done .st-dot svg{width:10px;height:10px;fill:none;stroke:#fff;stroke-width:2.5}
.s-active .st-dot{background:var(--gold)}
.s-active .st-dot svg{display:none}
.s-pending .st-dot{background:var(--light)}
.s-pending .st-dot svg{display:none}
.st-lbl{font-size:9px;font-weight:600;color:var(--grey);text-align:center;margin-top:4px;white-space:nowrap}
.s-done .st-lbl{color:var(--green)}
.s-active .st-lbl{color:var(--amber);font-weight:700}

/* ── NOTES ── */
.notes-area{width:100%;border:1px solid var(--light);background:#fff;font-family:'DM Sans',sans-serif;font-size:11px;color:var(--navy);padding:8px 10px;outline:none;resize:vertical;min-height:50px;margin-top:6px}

/* ── INFO COL ── */
.ic-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:10px}
.ic{background:#fff;border:1px solid var(--light);padding:8px 10px}
.ic-full{grid-column:1/-1}
.ic-lbl{font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);margin-bottom:3px}
.ic-val{font-size:12px;font-weight:600;color:var(--navy)}
.tag-wrap{display:flex;flex-wrap:wrap;gap:4px}
.tag-pill{padding:3px 8px;background:var(--off);border:1px solid var(--light);font-size:9px;font-weight:600;color:var(--grey)}
.action-row{display:flex;gap:6px;margin-top:8px}
.btn-edit-sm{flex:1;padding:7px;background:var(--navy-dark);color:var(--gold);font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;border:none;cursor:pointer;font-family:'DM Sans',sans-serif}
.btn-del-sm{flex:1;padding:7px;background:none;color:var(--red);font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;border:1px solid rgba(192,57,43,.3);cursor:pointer;font-family:'DM Sans',sans-serif}
</style>
@endsection

@section('content')
<div class="sec-header">
  <div>
    <div class="sh-eyebrow">Event Management</div>
    <div class="sh-title">My <em style="color:var(--gold);font-style:italic">Events</em></div>
    <div class="sh-sub">Events submitted and managed by YES UTM Johor.</div>
  </div>
  <div style="display:flex;gap:10px">
    <button class="btn-secondary" onclick="exportReport()">Export Report</button>
    <button class="btn-primary" onclick="openCreateModal()">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Create Event
    </button>
  </div>
</div>

<div class="stat-row">
  <div class="sc" onclick="filterTab('all')" style="cursor:pointer"><div class="sc-bar" style="background:var(--navy)"></div><div class="sc-lbl">Total Events</div><div class="sc-val" id="stat-total">5</div><div class="sc-sub">This year</div></div>
  <div class="sc" onclick="filterTab('open')" style="cursor:pointer"><div class="sc-bar" style="background:var(--green)"></div><div class="sc-lbl">Open</div><div class="sc-val" id="stat-open">3</div><div class="sc-sub">Registration active</div></div>
  <div class="sc" onclick="filterTab('upcoming')" style="cursor:pointer"><div class="sc-bar" style="background:var(--blue)"></div><div class="sc-lbl">Upcoming / Draft</div><div class="sc-val" id="stat-draft">2</div><div class="sc-sub">Pending or not open</div></div>
  <div class="sc" onclick="filterTab('submitted')" style="cursor:pointer"><div class="sc-bar" style="background:var(--amber)"></div><div class="sc-lbl">Under Review</div><div class="sc-val" id="stat-review">1</div><div class="sc-sub">Awaiting HQ approval</div></div>
</div>

<div class="panel">
  <div class="ph">
    <div class="pt">All <em>Events</em></div>
    <div class="ph-actions">
      <select class="fsel" onchange="filterByStatus(this.value)">
        <option value="all">All Status</option>
        <option value="open">Open</option>
        <option value="upcoming">Upcoming</option>
        <option value="submitted">Under Review</option>
        <option value="draft">Draft</option>
      </select>
      <select class="fsel" onchange="filterByCategory(this.value)">
        <option value="all">All Categories</option>
        <option value="Hackathon">Hackathon</option>
        <option value="Career Fair">Career Fair</option>
        <option value="Volunteer">Volunteer</option>
        <option value="Workshop">Workshop</option>
        <option value="Webinar">Webinar</option>
      </select>
    </div>
  </div>
  <div style="padding:14px 20px 0">
    <div class="tabs">
      <button class="tab active" id="tab-all"       onclick="filterTab('all')">All (5)</button>
      <button class="tab"        id="tab-open"      onclick="filterTab('open')">Open (3)</button>
      <button class="tab"        id="tab-upcoming"  onclick="filterTab('upcoming')">Upcoming (1)</button>
      <button class="tab"        id="tab-submitted" onclick="filterTab('submitted')">Under Review (1)</button>
      <button class="tab"        id="tab-draft"     onclick="filterTab('draft')">Draft (1)</button>
    </div>
    <div class="sr">
      <div class="si">
        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <input type="text" placeholder="Search events…" oninput="searchEvents(this.value)"/>
      </div>
      <select class="fsel" onchange="sortEvents(this.value)">
        <option value="date">Sort: Date Soonest</option>
        <option value="name">Name A–Z</option>
        <option value="status">Status</option>
      </select>
    </div>
  </div>
  <div class="ev-list" id="ev-list"></div>
</div>

<!-- DIM + SLIDE PANEL -->
<div class="dim-overlay" id="dimOverlay" onclick="closePanel()"></div>
<div class="slide-panel" id="slidePanel">
  <div class="sp-head">
    <div><div class="sp-mode-badge" id="spModeBadge">View</div><h3 id="spTitle">Event Details</h3></div>
    <button class="sp-close" onclick="closePanel()">×</button>
  </div>
  <div class="sp-body" id="spBody"></div>
  <div class="sp-foot" id="spFoot"></div>
</div>

<!-- CREATE EVENT MODAL -->
<div class="modal-overlay" id="createModal" onclick="if(event.target===this)closeCreateModal()">
  <div class="modal" style="width:680px">
    <div class="modal-head">
      <h3 id="createModalTitle">Create New Event</h3>
      <button class="modal-close" onclick="closeCreateModal()">×</button>
    </div>
    <div id="createStep1" class="modal-body">
      <div style="display:grid;grid-template-columns:1fr 130px;gap:18px;align-items:start">
        <div>
          <div class="form-row"><label class="form-lbl">Event Title *</label><input class="form-inp" id="c-name" type="text" placeholder="e.g. Engineering Innovation Hackathon 2025"/></div>
          <div class="form-2">
            <div class="form-row"><label class="form-lbl">Category *</label>
              <select class="form-sel" id="c-cat"><option>Hackathon</option><option>Career Fair</option><option>Webinar</option><option>Workshop</option><option>Competition</option><option>Volunteer</option><option>SDG Event</option></select>
            </div>
            <div class="form-row"><label class="form-lbl">Visibility</label>
              <select class="form-sel" id="c-status"><option value="draft">Save as Draft</option><option value="upcoming">Mark Upcoming</option></select>
            </div>
          </div>
          <div class="form-2">
            <div class="form-row"><label class="form-lbl">Start Date *</label><input class="form-inp" id="c-date" type="date"/></div>
            <div class="form-row"><label class="form-lbl">End Date</label><input class="form-inp" id="c-date-end" type="date"/></div>
          </div>
          <div class="form-row"><label class="form-lbl">Venue *</label><input class="form-inp" id="c-loc" type="text" placeholder="e.g. UTM Skudai, Johor"/></div>
        </div>
        <div>
          <label class="form-lbl">Event Poster</label>
          <div style="border:2px dashed var(--light);background:var(--off);position:relative;aspect-ratio:3/4;overflow:hidden;cursor:pointer;transition:border-color .2s"
               id="cPosterZone" onclick="document.getElementById('cPosterInput').click()"
               ondragover="event.preventDefault()" ondrop="handleCreatePosterDrop(event)">
            <input type="file" id="cPosterInput" accept="image/*" onchange="handleCreatePoster(this)" style="display:none"/>
            <div id="cPosterPh" style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;height:100%;padding:14px;text-align:center;pointer-events:none">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
              <span style="font-size:9px;color:var(--grey);line-height:1.4">Click or drag<br>PNG · JPG</span>
            </div>
            <img id="cPosterImg" src="" style="display:none;position:absolute;inset:0;width:100%;height:100%;object-fit:cover"/>
          </div>
          <div id="cPosterClear" style="display:none;margin-top:4px">
            <button style="width:100%;padding:5px;background:none;border:1px solid var(--light);font-size:9px;font-weight:700;color:var(--red);cursor:pointer;font-family:'DM Sans',sans-serif" onclick="clearCreatePoster()">× Remove</button>
          </div>
        </div>
      </div>
      <div class="form-row"><label class="form-lbl">Description</label><textarea class="form-ta" id="c-desc" placeholder="Describe the event for attendees…" style="min-height:70px"></textarea></div>
    </div>
    <div class="modal-footer">
      <button class="btn-ghost" onclick="closeCreateModal()">Cancel</button>
      <button class="btn-primary" onclick="submitEvent()">Submit for HQ Review</button>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
const catClass={'Hackathon':'b-hackathon','Career Fair':'b-career','Webinar':'b-webinar','Workshop':'b-workshop','Competition':'b-competition','Volunteer':'b-volunteer','SDG Event':'b-sdg'};
const statusClass={'open':'pill-open','upcoming':'pill-upcoming','draft':'pill-draft','submitted':'pill-review','past':'pill-closed','approved':'pill-approved','rejected':'pill-rejected'};

const events=[
  {id:1,name:'Engineering Innovation Hackathon 2025',cat:'Hackathon',loc:'UTM Skudai, Johor',date:'2025-04-02',dateDisp:'2–4 Apr 2025',status:'open',poster:null,desc:'A 3-day hackathon for engineering students to solve real-world problems.',notes:'',tags:['Hackathon','Engineering','UTM'],
    tracking:{submitted:true,doc:true,published:true,rejected:false}},
  {id:2,name:'STEM Career Fair 2025',cat:'Career Fair',loc:'UPM Serdang, Selangor',date:'2025-04-18',dateDisp:'18 Apr 2025',status:'open',poster:null,desc:'Annual career fair connecting students with top engineering firms.',notes:'',tags:['Career','STEM','Walk-in'],
    tracking:{submitted:true,doc:true,published:true,rejected:false}},
  {id:3,name:'YES Green Campus Initiative',cat:'Volunteer',loc:'Multiple Campuses',date:'2025-04-30',dateDisp:'30 Apr 2025',status:'open',poster:null,desc:'Volunteer drive across campuses to promote sustainability.',notes:'SDG 13 aligned.',tags:['Volunteer','SDG','Green'],
    tracking:{submitted:true,doc:true,published:true,rejected:false}},
  {id:4,name:'BIM & Digital Engineering Workshop',cat:'Workshop',loc:'UM, Kuala Lumpur',date:'2025-06-07',dateDisp:'7 Jun 2025',status:'submitted',poster:null,desc:'Hands-on workshop on Building Information Modelling (BIM).',notes:'Pending HQ approval.',tags:['BIM','Workshop','Digital'],
    tracking:{submitted:true,doc:true,published:false,rejected:false}},
  {id:5,name:'UTM Freshie Engineering Talk',cat:'Webinar',loc:'UTM Skudai — Draft',date:'2025-08-01',dateDisp:'TBC',status:'draft',poster:null,desc:'Introductory talk for new engineering students.',notes:'',tags:['Freshie','Talk','UTM'],
    tracking:{submitted:false,doc:false,published:false,rejected:false}}
];

let expandedId=null,filterStatus='all',searchQ='',sortMode='date',nextId=100,createPoster=null;

function renderList(){
  let rows=[...events];
  if(filterStatus!=='all')rows=rows.filter(e=>e.status===filterStatus);
  if(searchQ)rows=rows.filter(e=>e.name.toLowerCase().includes(searchQ)||e.loc.toLowerCase().includes(searchQ));
  if(sortMode==='name')rows.sort((a,b)=>a.name.localeCompare(b.name));
  else if(sortMode==='status')rows.sort((a,b)=>a.status.localeCompare(b.status));
  else rows.sort((a,b)=>new Date(a.date)-new Date(b.date));
  const list=document.getElementById('ev-list');
  if(!rows.length){list.innerHTML='<div style="padding:40px;text-align:center;font-size:12px;color:var(--grey)">No events found.</div>';return;}
  list.innerHTML=rows.map(e=>{
    const isOpen=expandedId===e.id;
    const track=e.tracking;
    const pubHtml=track.published?`<span style="font-size:10px;font-weight:700;color:var(--green);white-space:nowrap">● Live</span>`:e.status==='submitted'?`<span style="font-size:10px;font-weight:700;color:var(--amber);white-space:nowrap">⏳ Review</span>`:`<span style="font-size:10px;font-weight:700;color:#aaa;white-space:nowrap">○ Draft</span>`;
    const trackSteps=[{k:'submitted',icon:'<polyline points="20 6 9 17 4 12"/>',l:'Submitted'},{k:'doc',icon:'<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>',l:'Doc Approval'},{k:'published',icon:'<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10A15.3 15.3 0 0 1 12 2z"/>',l:'Published'}];
    const trackHtml=`<div class="status-track">${trackSteps.map((s,i,arr)=>{const done=track[s.k];const prev=i===0?true:track[arr[i-1].k];const active=!done&&prev;return '<div class="st-step '+(done?'s-done':active?'s-active':'s-pending')+'"><div class="st-dot"><svg viewBox="0 0 24 24" fill="none" stroke="'+(done?'#fff':'currentColor')+'" stroke-width="2">'+s.icon+'</svg></div><div class="st-lbl">'+s.l+'</div></div>';}).join('')}</div>`;
    return '<div class="ev-row" id="row-'+e.id+'">'
      +'<div class="ev-summary'+(isOpen?' expanded':'')+'" onclick="toggleRow('+e.id+')">'
      +'<div class="ev-info-wrap"><div class="ev-name">'+e.name+'</div><div class="ev-meta"><div class="ev-meta-item"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>'+e.dateDisp+'</div><div class="ev-meta-item"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>'+e.loc+'</div></div></div>'
      +'<div class="ev-right"><span class="ev-cat '+(catClass[e.cat]||'b-workshop')+'">'+e.cat+'</span><span class="pill '+(statusClass[e.status]||'pill-draft')+'">'+e.status.charAt(0).toUpperCase()+e.status.slice(1)+'</span>'+pubHtml+'<div class="abtns" onclick="event.stopPropagation()"><button class="abtn" title="View" onclick="openPanel(\'view\','+e.id+')"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button><button class="abtn" title="Edit" onclick="openPanel(\'edit\','+e.id+')"><svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button><button class="abtn del" title="Delete" onclick="openPanel(\'delete\','+e.id+')"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg></button></div><svg class="ev-chevron'+(isOpen?' open':'')+'" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg></div>'
      +'</div>'
      +'<div class="ev-detail'+(isOpen?' open':'')+'" id="detail-'+e.id+'">'
      +'<div class="ev-detail-inner">'
      +'<div class="poster-col"><div class="sec-lbl">Poster</div><div class="poster-box'+(e.poster?' has-poster':'')+'" id="pbox-'+e.id+'" ondragover="event.preventDefault()" ondrop="handleInlineDrop(event,'+e.id+')"><input type="file" accept="image/*" onchange="handleInlineFile(this,'+e.id+')"/><div id="pph-'+e.id+'" style="display:'+(e.poster?'none':'flex')+';flex-direction:column;align-items:center;justify-content:center;gap:5px;height:100%;padding:12px;text-align:center;pointer-events:none"><svg viewBox="0 0 24 24" style="width:24px;height:24px;stroke:#d1d5db;fill:none;stroke-width:1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg><span style="font-size:9px;color:var(--grey);line-height:1.4">Click to upload poster</span></div><img id="pimg-'+e.id+'" src="'+(e.poster||'')+'" style="display:'+(e.poster?'block':'none')+'"/></div><button id="pclr-'+e.id+'" class="poster-clear-btn" onclick="clearInlinePoster('+e.id+')" style="display:'+(e.poster?'flex':'none')+'">× Remove</button></div>'
      +'<div class="desc-col"><div class="sec-lbl">Description</div><div class="desc-text">'+(e.desc||'<span style="color:#bbb;font-style:italic">No description yet.</span>')+'</div><div style="margin-top:14px"><div class="sec-lbl">Submission &amp; Approval Progress</div>'+(track.submitted?trackHtml:'<div style="font-size:11px;color:var(--grey);padding:10px 0;font-style:italic">Not yet submitted for review.</div>')+(track.rejected?'<div style="margin-top:8px;padding:10px 14px;background:#fee2e2;border:1px solid rgba(192,57,43,.2);font-size:12px;color:var(--red)"><strong>Rejected by HQ.</strong> Please revise and resubmit.</div>':'')+'</div><div style="margin-top:12px"><div class="sec-lbl">Admin Notes</div><textarea class="notes-area" placeholder="Add internal notes…" onchange="saveNote('+e.id+',this.value)">'+e.notes+'</textarea></div></div>'
      +'<div class="info-col"><div class="sec-lbl">Event Info</div><div class="ic-grid"><div class="ic ic-full"><div class="ic-lbl">Category</div><div class="ic-val"><span class="ev-cat '+(catClass[e.cat]||'b-workshop')+'">'+e.cat+'</span></div></div><div class="ic"><div class="ic-lbl">Date</div><div class="ic-val">'+e.dateDisp+'</div></div><div class="ic"><div class="ic-lbl">Status</div><div class="ic-val"><span class="pill '+(statusClass[e.status]||'pill-draft')+'">'+e.status+'</span></div></div><div class="ic ic-full"><div class="ic-lbl">Venue</div><div class="ic-val">'+e.loc+'</div></div></div><div class="tag-wrap" style="margin-bottom:10px">'+e.tags.map(t=>'<span class="tag-pill">'+t+'</span>').join('')+'</div><div class="action-row"><button class="btn-edit-sm" onclick="openPanel(\'edit\','+e.id+');event.stopPropagation()">Edit</button>'+(!track.submitted?'<button class="btn-edit-sm" style="background:var(--green)" onclick="submitForReview('+e.id+');event.stopPropagation()">Submit</button>':'')+'<button class="btn-del-sm" onclick="openPanel(\'delete\','+e.id+');event.stopPropagation()">Delete</button></div></div>'
      +'</div></div></div>';
  }).join('');
  updateStats();
}

function updateStats(){
  document.getElementById('stat-total').textContent=events.length;
  document.getElementById('stat-open').textContent=events.filter(e=>e.status==='open').length;
  document.getElementById('stat-draft').textContent=events.filter(e=>e.status==='upcoming'||e.status==='draft').length;
  document.getElementById('stat-review').textContent=events.filter(e=>e.status==='submitted').length;
}
renderList();

function toggleRow(id){expandedId=expandedId===id?null:id;renderList();}
function filterTab(s){filterStatus=s;['all','open','upcoming','submitted','draft'].forEach(x=>document.getElementById('tab-'+x)?.classList.remove('active'));document.getElementById('tab-'+s)?.classList.add('active');expandedId=null;renderList();}
function filterByStatus(v){filterStatus=v;expandedId=null;renderList();}
function filterByCategory(v){renderList();}
function searchEvents(q){searchQ=q.toLowerCase();expandedId=null;renderList();}
function sortEvents(v){sortMode=v;renderList();}

function handleInlineFile(input,id){const file=input.files[0];if(!file)return;const r=new FileReader();r.onload=ev=>{const e=events.find(x=>x.id===id);if(e)e.poster=ev.target.result;document.getElementById('pimg-'+id).src=ev.target.result;document.getElementById('pimg-'+id).style.display='block';document.getElementById('pph-'+id).style.display='none';document.getElementById('pclr-'+id).style.display='flex';document.getElementById('pbox-'+id).classList.add('has-poster');showToast('Poster uploaded','success');};r.readAsDataURL(file);}
function handleInlineDrop(ev,id){ev.preventDefault();const f=ev.dataTransfer.files[0];if(!f||!f.type.startsWith('image/'))return;handleInlineFile({files:[f]},id);}
function clearInlinePoster(id){const e=events.find(x=>x.id===id);if(e)e.poster=null;document.getElementById('pimg-'+id).src='';document.getElementById('pimg-'+id).style.display='none';document.getElementById('pph-'+id).style.display='flex';document.getElementById('pclr-'+id).style.display='none';document.getElementById('pbox-'+id).classList.remove('has-poster');showToast('Poster removed','');}
function saveNote(id,val){const e=events.find(x=>x.id===id);if(e)e.notes=val;}

function submitForReview(id){const e=events.find(x=>x.id===id);if(!e)return;e.status='submitted';e.tracking.submitted=true;renderList();showToast('Event submitted for HQ review','success');}

function openPanel(mode,id){const e=events.find(x=>x.id===id);if(!e)return;if(mode==='view')renderView(e);if(mode==='edit')renderEdit(e);if(mode==='delete')renderDelete(e);document.getElementById('slidePanel').classList.add('open');document.getElementById('dimOverlay').classList.add('on');}
function closePanel(){document.getElementById('slidePanel').classList.remove('open');document.getElementById('dimOverlay').classList.remove('on');}

function renderView(e){
  document.getElementById('spModeBadge').textContent='View Details';
  document.getElementById('spTitle').textContent=e.name;
  const track=e.tracking;
  const steps=['Submitted','Doc Approval','Published'];
  const keys=['submitted','doc','published'];
  const stepsHtml=steps.map((l,i)=>{const done=track[keys[i]];const active=!done&&(i===0||track[keys[i-1]]);return '<div class="st-step '+(done?'s-done':active?'s-active':'s-pending')+'"><div class="st-dot"><svg viewBox="0 0 24 24" fill="none" stroke="'+(done?'#fff':'currentColor')+'" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div><div class="st-lbl">'+l+'</div></div>';}).join('');
  document.getElementById('spBody').innerHTML=(e.poster?'<div style="margin-bottom:14px;overflow:hidden;max-height:200px"><img src="'+e.poster+'" style="width:100%;object-fit:cover"/></div>':'')
    +'<div class="info-grid"><div class="info-card"><div class="ic-lbl2">Date</div><div class="ic-val2">'+e.dateDisp+'</div></div><div class="info-card"><div class="ic-lbl2">Status</div><div class="ic-val2"><span class="pill '+(statusClass[e.status]||'pill-draft')+'">'+e.status+'</span></div></div><div class="info-card" style="grid-column:1/-1"><div class="ic-lbl2">Venue</div><div class="ic-val2">'+e.loc+'</div></div><div class="info-card" style="grid-column:1/-1"><div class="ic-lbl2">Category</div><div class="ic-val2"><span class="ev-cat '+(catClass[e.cat]||'b-workshop')+'">'+e.cat+'</span></div></div></div>'
    +'<hr class="pf-divider"/>'
    +'<div class="pf-row"><span class="pf-lbl">Approval Progress</span><div class="status-track" style="margin:10px 0">'+stepsHtml+'</div></div>'
    +'<hr class="pf-divider"/>'
    +'<div class="pf-row"><span class="pf-lbl">Description</span><div class="pf-val muted">'+(e.desc||'—')+'</div></div>'
    +'<hr class="pf-divider"/>'
    +'<div class="pf-row"><span class="pf-lbl">Tags</span><div class="tag-wrap">'+e.tags.map(t=>'<span class="tag-pill">'+t+'</span>').join('')+'</div></div>';
  document.getElementById('spFoot').innerHTML='<button class="btn-ghost" onclick="closePanel()">Close</button><button class="btn-prim" onclick="openPanel(\'edit\','+e.id+')">Edit</button>';
}

function renderEdit(e){
  document.getElementById('spModeBadge').textContent='Edit Event';
  document.getElementById('spTitle').textContent=e.name;
  const statusOpts=['open','upcoming','submitted','draft','past'].map(s=>'<option value="'+s+'"'+(e.status===s?' selected':'')+'>'+s.charAt(0).toUpperCase()+s.slice(1)+'</option>').join('');
  const catOpts=['Hackathon','Career Fair','Webinar','Workshop','Competition','Volunteer','SDG Event'].map(c=>'<option'+(e.cat===c?' selected':'')+'>'+c+'</option>').join('');
  document.getElementById('spBody').innerHTML='<div class="pf-row"><label class="pf-lbl">Event Title</label><input class="pf-input" id="ep-name" value="'+e.name+'"/></div><div class="pf-grid2"><div class="pf-row"><label class="pf-lbl">Date</label><input class="pf-input" id="ep-date" type="date" value="'+e.date+'"/></div><div class="pf-row"><label class="pf-lbl">Status</label><select class="pf-select" id="ep-status">'+statusOpts+'</select></div></div><div class="pf-row"><label class="pf-lbl">Venue</label><input class="pf-input" id="ep-loc" value="'+e.loc+'"/></div><div class="pf-row"><label class="pf-lbl">Category</label><select class="pf-select" id="ep-cat">'+catOpts+'</select></div><div class="pf-row"><label class="pf-lbl">Tags (comma separated)</label><input class="pf-input" id="ep-tags" value="'+e.tags.join(', ')+'"/></div><div class="pf-row"><label class="pf-lbl">Description</label><textarea class="pf-textarea" id="ep-desc">'+e.desc+'</textarea></div><div class="pf-row"><label class="pf-lbl">Notes (internal)</label><textarea class="pf-textarea" id="ep-notes" style="min-height:50px">'+e.notes+'</textarea></div>';
  document.getElementById('spFoot').innerHTML='<button class="btn-ghost" onclick="closePanel()">Cancel</button><button class="btn-prim" onclick="saveEdit('+e.id+')">Save Changes</button>';
}
function saveEdit(id){const e=events.find(x=>x.id===id);if(!e)return;e.name=document.getElementById('ep-name').value.trim()||e.name;e.loc=document.getElementById('ep-loc').value.trim()||e.loc;e.date=document.getElementById('ep-date').value||e.date;e.status=document.getElementById('ep-status').value;e.cat=document.getElementById('ep-cat').value;e.desc=document.getElementById('ep-desc').value;e.notes=document.getElementById('ep-notes').value;e.tags=document.getElementById('ep-tags').value.split(',').map(t=>t.trim()).filter(Boolean);try{e.dateDisp=new Date(e.date).toLocaleDateString('en-GB',{day:'numeric',month:'short',year:'numeric'});}catch(_){}closePanel();renderList();showToast('Event updated','success');}

function renderDelete(e){
  document.getElementById('spModeBadge').textContent='Delete';
  document.getElementById('spTitle').textContent='Confirm Deletion';
  document.getElementById('spBody').innerHTML='<div style="text-align:center;padding:28px 16px"><div style="width:52px;height:52px;border-radius:50%;background:#fee2e2;border:2px solid rgba(192,57,43,.15);display:flex;align-items:center;justify-content:center;margin:0 auto 14px"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg></div><div style="font-family:\'Playfair Display\',serif;font-size:17px;font-weight:700;color:var(--navy);margin-bottom:8px">Delete "'+e.name+'"?</div><div style="font-size:12px;color:var(--grey);line-height:1.7;max-width:340px;margin:0 auto">This action cannot be undone. All event data including registrations will be removed.</div></div>';
  document.getElementById('spFoot').innerHTML='<button class="btn-ghost" onclick="closePanel()">Cancel</button><button class="btn-danger" onclick="confirmDelete('+e.id+')">Delete Event</button>';
}
function confirmDelete(id){const idx=events.findIndex(x=>x.id===id);if(idx>-1)events.splice(idx,1);if(expandedId===id)expandedId=null;closePanel();renderList();showToast('Event deleted','danger');}

function openCreateModal(){document.getElementById('createModal').classList.add('open');}
function closeCreateModal(){document.getElementById('createModal').classList.remove('open');}
function handleCreatePoster(input){const file=input.files[0];if(!file)return;const r=new FileReader();r.onload=ev=>{createPoster=ev.target.result;document.getElementById('cPosterImg').src=ev.target.result;document.getElementById('cPosterImg').style.display='block';document.getElementById('cPosterPh').style.display='none';document.getElementById('cPosterClear').style.display='block';};r.readAsDataURL(file);}
function handleCreatePosterDrop(ev){ev.preventDefault();const f=ev.dataTransfer.files[0];if(!f||!f.type.startsWith('image/'))return;handleCreatePoster({files:[f]});}
function clearCreatePoster(){createPoster=null;document.getElementById('cPosterImg').src='';document.getElementById('cPosterImg').style.display='none';document.getElementById('cPosterPh').style.display='flex';document.getElementById('cPosterClear').style.display='none';}
function submitEvent(){
  const name=document.getElementById('c-name').value.trim();if(!name){showToast('Event title required','danger');return;}
  const e={id:nextId++,name,cat:document.getElementById('c-cat').value,loc:document.getElementById('c-loc').value||'TBC',date:document.getElementById('c-date').value||new Date().toISOString().split('T')[0],dateDisp:'',status:'submitted',poster:createPoster,desc:document.getElementById('c-desc').value,notes:'',tags:[],tracking:{submitted:true,doc:false,published:false,rejected:false}};
  try{e.dateDisp=new Date(e.date).toLocaleDateString('en-GB',{day:'numeric',month:'short',year:'numeric'});}catch(_){e.dateDisp=e.date;}
  events.unshift(e);
  ['c-name','c-loc','c-date','c-date-end','c-desc'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';});
  createPoster=null;clearCreatePoster();
  closeCreateModal();renderList();showToast('Event submitted for HQ review!','success');
}
function exportReport(){showToast('Exporting report…','');}
</script>
@endsection
