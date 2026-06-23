@extends('admin.layouts.app')

@section('title', 'Student Events Review')

@section('styles')
<style>
.review-grid{display:flex;flex-direction:column;gap:14px}
.rcard{background:#fff;border:1px solid var(--light);border-radius:4px;overflow:hidden;transition:box-shadow .2s}
.rcard:hover{box-shadow:0 4px 20px rgba(0,31,69,.08)}
.rcard-header{display:flex;align-items:center;gap:14px;padding:16px 20px;cursor:pointer;user-select:none}
.rcard-left{flex:1;min-width:0}
.rcard-title{font-size:13px;font-weight:700;color:var(--navy);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.rcard-meta{font-size:11px;color:var(--grey);margin-top:3px;display:flex;gap:14px;flex-wrap:wrap}
.rcard-meta span{display:flex;align-items:center;gap:4px}
.rcard-meta svg{width:11px;height:11px;stroke:var(--grey);fill:none;stroke-width:2;flex-shrink:0}
.rcard-badges{display:flex;align-items:center;gap:6px;flex-shrink:0}
.rcard-chevron{width:15px;height:15px;stroke:var(--grey);fill:none;stroke-width:2;transition:transform .25s;flex-shrink:0;margin-left:4px}
.rcard-chevron.open{transform:rotate(180deg)}
.rcard-body{display:none;border-top:1px solid var(--light)}
.rcard-body.open{display:block}
.review-layout{display:grid;grid-template-columns:1fr 1fr;gap:0;border-bottom:1px solid var(--light)}
.review-col{padding:20px;border-right:1px solid var(--light)}
.review-col:last-child{border-right:none}
.rc-title{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);margin-bottom:12px;display:flex;align-items:center;gap:6px}
.rc-title svg{width:12px;height:12px;stroke:var(--grey);fill:none;stroke-width:2}
.doc-box{background:var(--off);border:1px solid var(--light);border-radius:3px;padding:14px;margin-bottom:10px}
.doc-row{display:flex;align-items:center;gap:10px;margin-bottom:8px}
.doc-row:last-child{margin-bottom:0}
.doc-icon{width:32px;height:32px;background:#fff;border:1px solid var(--light);border-radius:3px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.doc-icon svg{width:14px;height:14px;stroke:var(--navy);fill:none;stroke-width:2}
.doc-name{font-size:11px;font-weight:600;color:var(--navy);flex:1}
.doc-sub{font-size:10px;color:var(--grey);margin-top:1px}
.doc-dl{display:flex;align-items:center;gap:4px;padding:5px 10px;background:var(--navy-dark);color:#fff;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:9px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;border-radius:2px;white-space:nowrap}
.doc-dl svg{width:10px;height:10px;stroke:#fff;fill:none;stroke-width:2.5}
.doc-dl:hover{background:var(--navy-mid)}
.poster-box{background:var(--off);border:1px solid var(--light);border-radius:3px;overflow:hidden;margin-bottom:10px}
.poster-thumb{width:100%;height:140px;background:linear-gradient(135deg,var(--navy-dark) 0%,var(--navy-mid) 50%,#1a3a6e 100%);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;position:relative;overflow:hidden}
.poster-thumb::before{content:'';position:absolute;inset:0;background:repeating-linear-gradient(45deg,rgba(200,168,75,.04) 0,rgba(200,168,75,.04) 1px,transparent 0,transparent 50%);background-size:14px 14px}
.poster-thumb-icon{width:40px;height:40px;background:rgba(200,168,75,.15);border:1px solid rgba(200,168,75,.3);border-radius:50%;display:flex;align-items:center;justify-content:center}
.poster-thumb-icon svg{width:18px;height:18px;stroke:var(--gold);fill:none;stroke-width:1.8}
.poster-thumb-lbl{font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,.4)}
.poster-actions{padding:10px 12px;display:flex;gap:6px}
.copy-box{background:var(--off);border:1px solid var(--light);border-radius:3px;padding:12px 14px;font-size:11px;color:#444;line-height:1.7;margin-bottom:10px;max-height:180px;overflow-y:auto}
.copy-box p{margin-bottom:8px}
.copy-box p:last-child{margin-bottom:0}
.copy-label{font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:6px}
.budget-table{width:100%;border-collapse:collapse;font-size:11px}
.budget-table tr td{padding:6px 0;border-bottom:1px solid var(--light)}
.budget-table tr:last-child td{border-bottom:none;font-weight:700;color:var(--navy)}
.budget-table td:last-child{text-align:right;font-weight:600;color:var(--navy)}
.budget-total-row td{padding:8px 6px;font-family:'Playfair Display',serif;font-size:13px}
.pipeline-section{padding:16px 20px;background:#fafaf8;border-top:1px solid var(--light)}
.pipeline-title{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);margin-bottom:12px}
.pipeline-steps{display:flex;align-items:center;gap:0;margin-bottom:16px}
.ps{display:flex;flex-direction:column;align-items:center;flex:1;position:relative}
.ps::after{content:'';position:absolute;top:14px;left:50%;width:100%;height:2px;background:var(--light);z-index:0}
.ps:last-child::after{display:none}
.ps-dot{width:28px;height:28px;border-radius:50%;border:2px solid var(--light);background:#fff;display:flex;align-items:center;justify-content:center;z-index:1;position:relative}
.ps-dot svg{width:12px;height:12px;stroke:var(--grey);fill:none;stroke-width:2.5}
.ps-dot.done{background:var(--green);border-color:var(--green)}
.ps-dot.done svg{stroke:#fff}
.ps-dot.active{background:var(--gold);border-color:var(--gold)}
.ps-dot.active svg{stroke:var(--navy-dark)}
.ps-dot.rejected{background:var(--red);border-color:var(--red)}
.ps-dot.rejected svg{stroke:#fff}
.ps-lbl{font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--grey);margin-top:6px;text-align:center;max-width:70px;line-height:1.3}
.ps-lbl.done{color:var(--green)}
.ps-lbl.active{color:var(--gold)}
.ps-lbl.rejected{color:var(--red)}
.pipeline-actions{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
.audit-link{display:inline-flex;align-items:center;gap:7px;margin-top:14px;font-size:11px;font-weight:600;color:var(--grey);text-decoration:none;transition:color .15s}
.audit-link:hover{color:var(--navy)}
.audit-link svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:1.8}
.step-label{font-size:11px;font-weight:600;color:var(--navy);margin-right:auto}
.comment-area{margin-top:10px}
.comment-area textarea{width:100%;border:1px solid var(--light);background:var(--off);padding:9px 12px;font-family:'DM Sans',sans-serif;font-size:11px;color:var(--navy);outline:none;border-radius:3px;min-height:70px;resize:vertical}
.comment-area textarea:focus{border-color:var(--navy);background:#fff}
.comment-area label{display:block;font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:5px}
.empty{text-align:center;padding:48px 20px;color:var(--grey)}
.empty svg{width:40px;height:40px;stroke:var(--light);fill:none;stroke-width:1.5;margin:0 auto 12px;display:block}
.empty p{font-size:13px}
/* Chapter-facing feedback modal */
.fb-overlay{position:fixed;inset:0;background:rgba(0,16,48,.55);z-index:1000;display:none;align-items:center;justify-content:center;padding:20px}
.fb-overlay.open{display:flex}
.fb-box{background:#fff;width:100%;max-width:460px;padding:24px;box-shadow:0 20px 60px rgba(0,0,0,.25)}
.fb-box h3{font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:var(--navy);margin:0 0 6px}
.fb-box p{font-size:12px;color:var(--grey);line-height:1.5;margin:0 0 14px}
.fb-box textarea{width:100%;min-height:110px;border:1px solid var(--light);padding:10px 12px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--navy);outline:none;resize:vertical}
.fb-box textarea:focus{border-color:var(--navy)}
.fb-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:16px}
.fb-cancel{padding:9px 18px;background:none;border:1px solid var(--light);font-size:12px;font-weight:700;color:var(--grey);cursor:pointer;font-family:'DM Sans',sans-serif}
.fb-send{padding:9px 18px;background:var(--navy-dark,#001f45);color:#fff;border:none;font-size:12px;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif}
</style>
@endsection

@section('content')

{{-- Summary Stats --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:22px">
    <div class="sc">
        <div class="sc-bar" style="background:var(--amber)"></div>
        <div class="sc-lbl">Pending Review</div>
        <div class="sc-val" id="stat-pending">{{ $counts['pending'] }}</div>
        <div class="sc-ch">Awaiting admin action</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--purple)"></div>
        <div class="sc-lbl">PPW Screening</div>
        <div class="sc-val" id="stat-ppw">{{ $counts['ppw'] }}</div>
        <div class="sc-ch">Document review stage</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--green)"></div>
        <div class="sc-lbl">Fully Approved</div>
        <div class="sc-val" id="stat-approved">{{ $counts['approved'] }}</div>
        <div class="sc-ch">This semester</div>
    </div>
</div>

{{-- Main Panel --}}
<div class="panel">
    <div class="ph">
        <div class="pt">Incoming <em>Submissions</em></div>
        <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
            <select class="fsel" id="filterUniversity" onchange="applyFilters()">
                <option value="">All Universities</option>
                @foreach($universities as $uni)
                    <option value="{{ $uni }}">{{ $uni }}</option>
                @endforeach
            </select>
            <select class="fsel" id="filterStage" onchange="applyFilters()">
                <option value="">All Stages</option>
                <option value="pending">Pending</option>
                <option value="ppw">PPW Screening</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
    </div>
    <div class="pb">
        <div class="tabs">
            <button class="tab active" data-tab="all" onclick="switchTab(this)">All Submissions</button>
            <button class="tab" data-tab="pending" onclick="switchTab(this)">Pending</button>
            <button class="tab" data-tab="ppw" onclick="switchTab(this)">PPW Screening</button>
            <button class="tab" data-tab="approved" onclick="switchTab(this)">Approved</button>
            <button class="tab" data-tab="rejected" onclick="switchTab(this)">Rejected</button>
        </div>
        <div class="sr">
            <div class="si-wrap">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" id="searchInput" placeholder="Search events, universities…" oninput="applyFilters()"/>
            </div>
        </div>
        <div class="review-grid" id="reviewGrid"></div>
    </div>
</div>

{{-- Chapter-facing feedback modal (Reinstate / Reject) --}}
<div class="fb-overlay" id="fbModal">
  <div class="fb-box">
    <h3 id="fbTitle">Send back for revision</h3>
    <p id="fbDesc">Describe the corrections the chapter must make.</p>
    <textarea id="fbText" placeholder="Corrections to be made…"></textarea>
    <div class="fb-actions">
      <button type="button" class="fb-cancel" onclick="closeFb()">Cancel</button>
      <button type="button" class="fb-send" id="fbConfirm" onclick="confirmFb()">Send Back</button>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
const SUBMISSIONS = @json($submissions);
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

const STAGES = [
    { key:'pending',  label:'Submitted',  icon:'<polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>' },
    { key:'ppw',      label:'Doc Review', icon:'<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>' },
    { key:'approved', label:'Approved',   icon:'<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>' },
    { key:'published',label:'Published',  icon:'<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>' },
];
const STAGE_BADGE  = {pending:'b-pending',ppw:'b-ppw',approved:'b-approved',published:'b-approved',rejected:'b-rejected'};
const STAGE_LABEL  = {pending:'Submitted',ppw:'Doc Review',approved:'Approved',published:'Published',rejected:'Rejected'};
const CAT_BADGE    = {hackathon:'b-hackathon',career:'b-career',webinar:'b-webinar',workshop:'b-workshop',competition:'b-competition'};

let activeTab = 'all';
let openCards = new Set();

function updateStats(){
    ['pending','ppw','approved'].forEach(s => {
        const el = document.getElementById('stat-'+s);
        if(el) el.textContent = SUBMISSIONS.filter(x=>x.stage===s).length;
    });
}

function applyFilters(){
    const uniFilter   = document.getElementById('filterUniversity').value;
    const stageFilter = document.getElementById('filterStage').value;
    const search      = document.getElementById('searchInput').value.toLowerCase();
    const filtered = SUBMISSIONS.filter(s => {
        const tabMatch   = activeTab==='all' || s.stage===activeTab || (activeTab==='approved' && s.stage==='published');
        const uniMatch   = !uniFilter || s.university===uniFilter;
        const stageMatch = !stageFilter || s.stage===stageFilter;
        const srchMatch  = !search || s.title.toLowerCase().includes(search) || s.university_full.toLowerCase().includes(search) || s.submitted_by.toLowerCase().includes(search);
        return tabMatch && uniMatch && stageMatch && srchMatch;
    });
    const grid = document.getElementById('reviewGrid');
    if(!filtered.length){
        grid.innerHTML = `<div class="empty"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg><p>No submissions match your filters.</p></div>`;
        return;
    }
    grid.innerHTML = filtered.map(s => buildCard(s)).join('');
}

function buildCard(s){
    const isOpen = openCards.has(s.id);
    const stageIdx = STAGES.findIndex(st=>st.key===s.stage);
    const isRejected = s.stage==='rejected';
    const pipelineSteps = STAGES.map((st,i)=>{
        let cls = '';
        if(isRejected && i<=s.stage_history.length) cls = i<s.stage_history.length?'done':'rejected';
        else if(i<stageIdx) cls='done';
        else if(i===stageIdx) cls='active';
        return `<div class="ps"><div class="ps-dot ${cls}"><svg viewBox="0 0 24 24">${st.icon}</svg></div><div class="ps-lbl ${cls}">${st.label}</div></div>`;
    }).join('');
    let actionHtml='';
    if(s.stage==='pending') actionHtml=`<span class="step-label">Review submission</span><button class="btn-approve" onclick="advance(${s.id},event)"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Proceed to PPW</button><button class="btn-ghost" onclick="sendBack(${s.id},event)">Reinstate (Send Back)</button><button class="btn-reject" onclick="reject(${s.id},event)"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>Reject</button>`;
    else if(s.stage==='ppw') actionHtml=`<span class="step-label">PPW review complete?</span><button class="btn-approve" onclick="advance(${s.id},event)"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Approve &amp; Fully Approve</button><button class="btn-ghost" onclick="sendBack(${s.id},event)">Reinstate (Send Back)</button><button class="btn-reject" onclick="reject(${s.id},event)"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>Reject</button>`;
    else if(s.stage==='approved') actionHtml=`<span class="step-label" style="color:var(--green)">✓ Approved — awaiting chapter publish.</span><button class="btn-reject" onclick="reject(${s.id},event)"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>Reject</button>`;
    else if(s.stage==='published') actionHtml=`<span class="step-label" style="color:var(--green)">✓ Approved &amp; published by chapter.</span><button class="btn-reject" onclick="reject(${s.id},event)"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>Reject</button>`;
    else if(s.stage==='rejected') actionHtml=`<span class="step-label" style="color:var(--red)">✕ Rejected</span><button class="btn-approve" onclick="reinstate(${s.id},event)"><svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.88"/></svg>Reopen to Pending</button>`;

    return `
    <div class="rcard" id="rcard-${s.id}">
      <div class="rcard-header" onclick="toggleCard(${s.id})">
        <div class="rcard-left">
          <div class="rcard-title">${s.title}</div>
          <div class="rcard-meta">
            <span><svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>${s.university_full}</span>
            <span><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>${s.event_date}</span>
            <span><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>${s.submitted_by}</span>
            <span>Submitted ${s.submitted_date}</span>
          </div>
        </div>
        <div class="rcard-badges">
          <span class="badge ${CAT_BADGE[s.category]||'b-workshop'}">${s.category}</span>
          <span class="badge ${STAGE_BADGE[s.stage]}">${STAGE_LABEL[s.stage]}</span>
        </div>
        <svg class="rcard-chevron ${isOpen?'open':''}" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
      </div>
      <div class="rcard-body ${isOpen?'open':''}" id="body-${s.id}">
        <div class="review-layout">
          <div class="review-col">
            <div class="rc-title"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>PPW &amp; Documents</div>
            <div class="doc-box">
              <div class="doc-row">
                <div class="doc-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                <div style="flex:1"><div class="doc-name">${s.ppw_filename||'No PPW uploaded'}</div><div class="doc-sub">${s.ppw_url?(s.ppw_size?s.ppw_size+' · ':'')+'Document':'—'}</div></div>
                ${s.ppw_url?`<a class="doc-dl" href="${s.ppw_url}" target="_blank" rel="noopener"><svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>View</a>`:''}
              </div>
            </div>
            <div class="rc-title" style="margin-top:14px"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>Poster / Artwork</div>
            <div class="poster-box">
              <div class="poster-thumb">
                ${s.poster_url
                  ? `<img src="${s.poster_url}" alt="Event poster" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover"/>`
                  : `<div class="poster-thumb-icon"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div><div class="poster-thumb-lbl">No poster uploaded</div>`}
              </div>
              ${s.poster_url?`<div class="poster-actions">
                <a class="doc-dl" style="width:100%;justify-content:center" href="${s.poster_url}" target="_blank" rel="noopener"><svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>View Poster</a>
              </div>`:''}
            </div>
          </div>
          <div class="review-col">
            <div class="rc-title"><svg viewBox="0 0 24 24"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/></svg>Event Description</div>
            <div class="copy-label">Public-facing description</div>
            <div class="copy-box">${(s.description||'').split('\\n\\n').map(p=>`<p>${p}</p>`).join('')}</div>
            <div class="comment-area">
              <label>Admin Remarks / Notes</label>
              <textarea id="comment-${s.id}" placeholder="Add internal notes or feedback…">${s.admin_notes||''}</textarea>
            </div>
          </div>
          <div class="review-col" style="border-right:none">
            <div class="rc-title"><svg viewBox="0 0 24 24"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/></svg>Event Info</div>
            <div style="background:var(--off);border:1px solid var(--light);border-radius:3px;padding:12px 14px;font-size:11px;color:#444;line-height:1.9">
              <div><span style="color:var(--grey);min-width:80px;display:inline-block">Category</span><span style="font-weight:600;color:var(--navy);text-transform:capitalize">${s.category}</span></div>
              <div><span style="color:var(--grey);min-width:80px;display:inline-block">Date</span><span style="font-weight:600;color:var(--navy)">${s.event_date}</span></div>
              <div><span style="color:var(--grey);min-width:80px;display:inline-block">University</span><span style="font-weight:600;color:var(--navy)">${s.university_full}</span></div>
              <div><span style="color:var(--grey);min-width:80px;display:inline-block">Submitted</span><span style="font-weight:600;color:var(--navy)">${s.submitted_date}</span></div>
              <div><span style="color:var(--grey);min-width:80px;display:inline-block">By</span><span style="font-weight:600;color:var(--navy)">${s.submitted_by}</span></div>
              ${(s.tags&&s.tags.length)?`<div style="margin-top:6px"><span style="color:var(--grey);min-width:80px;display:inline-block;vertical-align:top">Tags</span><span>${s.tags.map(t=>`<span style="display:inline-block;background:#fff;border:1px solid var(--light);font-size:9px;font-weight:600;color:var(--navy);padding:2px 7px;margin:0 4px 4px 0">${t}</span>`).join('')}</span></div>`:''}
            </div>
          </div>
        </div>
        <div class="pipeline-section">
          <div class="pipeline-title">Approval Pipeline</div>
          <div class="pipeline-steps">${pipelineSteps}</div>
          <div class="pipeline-actions">${actionHtml}</div>
          <a class="audit-link" href="/dashboard/admin/activity?subject_type=App%5CModels%5CEvent&subject_id=${s.id}">
            <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            View audit trail
          </a>
        </div>
      </div>
    </div>`;
}

function toggleCard(id){
    if(openCards.has(id)) openCards.delete(id);
    else openCards.add(id);
    applyFilters();
}
function switchTab(btn){
    document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));
    btn.classList.add('active');
    activeTab = btn.dataset.tab;
    applyFilters();
}

async function apiStage(id, action, notes='', feedback=''){
    const res = await fetch(`/dashboard/admin/student-events/${id}/stage`, {
        method: 'POST',
        headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':CSRF},
        body: JSON.stringify({action, admin_notes: notes, feedback})
    });
    let data={}; try{ data = await res.json(); }catch(_){}
    return {ok: res.ok, data};
}
// Admin Remarks textarea — INTERNAL only, sent as admin_notes (never shown to the chapter).
function adminNotes(id){ return (document.getElementById('comment-'+id)?.value||'').trim(); }
function recountStats(){
    const c = {pending:0, ppw:0, approved:0};
    SUBMISSIONS.forEach(s => {
        if(s.stage === 'published') c.approved++;            // published events are still approved
        else if(c[s.stage] !== undefined) c[s.stage]++;
    });
    document.getElementById('stat-pending').textContent  = c.pending;
    document.getElementById('stat-ppw').textContent      = c.ppw;
    document.getElementById('stat-approved').textContent = c.approved;
}
function afterAction(r, okMsg, type){
    if(!r.ok){ showToast(r.data.message || 'Action failed — please try again.','danger'); return false; }
    showToast(okMsg, type||'');
    // Update the card in place from the server's fresh data — no full-page reload (keeps scroll position).
    if(r.data && r.data.submission){
        const sub = r.data.submission;
        const idx = SUBMISSIONS.findIndex(x => x.id === sub.id);
        if(idx !== -1) SUBMISSIONS[idx] = sub; else SUBMISSIONS.push(sub);
        openCards.add(sub.id);   // keep the card expanded so the new stage is visible
        applyFilters();
        recountStats();
    } else {
        setTimeout(()=>location.reload(), 600);
    }
    return true;
}

async function advance(id, e){
    e.stopPropagation();
    const s = SUBMISSIONS.find(x=>x.id===id);
    const r = await apiStage(id, 'advance', adminNotes(id));
    afterAction(r, s && s.stage==='ppw' ? 'Event fully approved!' : 'Advanced to PPW screening', 'success');
}

// Reopen an already-rejected event back to Pending review.
async function reinstate(id, e){
    e.stopPropagation();
    const r = await apiStage(id, 'reinstate', adminNotes(id));
    afterAction(r, 'Reopened to Pending', 'warn');
}

// Reject and Reinstate(send-back) open the chapter-facing comment modal.
function reject(id, e){ if(e) e.stopPropagation(); openFb(id, 'reject'); }
function sendBack(id, e){ if(e) e.stopPropagation(); openFb(id, 'revision'); }

// ── Chapter-facing feedback modal ──
let fbCtx = {id:null, action:null};
function openFb(id, action){
    fbCtx = {id, action};
    const isRev = action==='revision';
    document.getElementById('fbTitle').textContent = isRev ? 'Reinstate — send back for revision' : 'Reject submission';
    document.getElementById('fbDesc').textContent  = isRev
        ? 'Describe the corrections the chapter must make. This is sent to the chapter and recorded in the audit trail.'
        : 'Optional: tell the chapter why it was rejected. Sent to the chapter and recorded.';
    const t = document.getElementById('fbText');
    t.value=''; t.placeholder = isRev ? 'Corrections to be made…' : 'Reason for rejection (optional)…';
    document.getElementById('fbConfirm').textContent = isRev ? 'Send Back' : 'Reject';
    document.getElementById('fbModal').classList.add('open');
    setTimeout(()=>t.focus(), 50);
}
function closeFb(){ document.getElementById('fbModal').classList.remove('open'); }
async function confirmFb(){
    const {id, action} = fbCtx;
    const feedback = document.getElementById('fbText').value.trim();
    if(action==='revision' && !feedback){ showToast('Write the corrections before sending back.','danger'); return; }
    const r = await apiStage(id, action, adminNotes(id), feedback);
    closeFb();
    afterAction(r, action==='revision' ? 'Sent back to chapter for revision' : 'Submission rejected', action==='revision'?'warn':'danger');
}

function viewDoc(id, type, e){
    e.stopPropagation();
    showToast(`Opening ${type} document…`);
}

applyFilters();
</script>
@endsection