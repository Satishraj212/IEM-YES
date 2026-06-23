@extends('admin.layouts.app')

@section('title', 'State Branches')

@section('styles')
<style>
/* ── STATE BRANCH CARDS ── */
#sbList{display:flex;flex-direction:column;gap:14px}
.sb-card{background:#fff;border:1px solid var(--light);border-radius:10px;border-left:6px solid var(--accent,var(--light));box-shadow:0 2px 6px rgba(0,31,69,.05);transition:box-shadow .2s,transform .2s;display:flex;align-items:center;justify-content:space-between;gap:18px;padding:20px 26px;flex-wrap:wrap}
.sb-card:hover{box-shadow:0 10px 30px rgba(0,31,69,.1);transform:translateY(-1px)}
.sb-main{display:flex;align-items:center;gap:16px;min-width:240px;flex:1}
.sb-dot{width:14px;height:14px;border-radius:50%;background:var(--accent);box-shadow:0 0 0 4px var(--accent)1f;flex-shrink:0}
.sb-name{font-family:'Playfair Display',serif;font-size:21px;font-weight:900;color:var(--navy);line-height:1.1;letter-spacing:-.3px}
.sb-sub{font-size:11px;color:var(--grey);margin-top:3px;text-transform:uppercase;letter-spacing:1px;font-weight:700}
.sb-right{display:flex;align-items:center;gap:12px;flex-wrap:wrap;justify-content:flex-end}

/* year dropdown */
.year-sel{border:1px solid var(--light);background:#fff;padding:8px 11px;font-family:'DM Sans',sans-serif;font-size:12px;font-weight:600;color:var(--navy);cursor:pointer;outline:none;border-radius:4px;min-width:120px}
.year-sel:focus{border-color:var(--navy)}
.year-none{font-size:12px;color:var(--grey);font-style:italic;min-width:120px}

/* action buttons */
.btn-view{display:inline-flex;align-items:center;gap:5px;padding:8px 14px;background:var(--navy-dark);color:#fff;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;border-radius:4px;transition:background .2s;white-space:nowrap}
.btn-view:hover{background:var(--navy-mid)}
.btn-view svg{width:12px;height:12px;stroke:#fff;fill:none;stroke-width:2.5}
.btn-upload{display:inline-flex;align-items:center;gap:5px;padding:8px 14px;background:var(--gold-dim);color:#7a5b14;border:1px solid rgba(200,168,75,.4);cursor:pointer;font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;border-radius:4px;transition:all .2s;white-space:nowrap}
.btn-upload:hover{background:var(--gold);color:var(--navy-dark)}
.btn-upload svg{width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2.5}
.btn-remove{display:inline-flex;align-items:center;gap:5px;padding:8px 14px;background:var(--red-l);color:var(--red);border:1px solid rgba(192,57,43,.2);cursor:pointer;font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;border-radius:4px;transition:all .2s;white-space:nowrap}
.btn-remove:hover{background:var(--red);color:#fff;border-color:var(--red)}
.btn-remove svg{width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2.5}

/* ── MODALS ── */
.modal-ov{position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:900;display:none;align-items:center;justify-content:center;padding:20px}
.modal-ov.open{display:flex}
.org-modal{background:#fff;width:520px;max-width:95vw;max-height:90vh;overflow-y:auto;border-radius:6px;box-shadow:0 20px 80px rgba(0,31,69,.25)}
.org-modal.wide{width:760px}
.omh{background:var(--navy-dark);padding:18px 24px;display:flex;align-items:flex-start;justify-content:space-between;border-radius:6px 6px 0 0}
.omh-badge{font-size:8px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:4px}
.omh h3{font-family:'Playfair Display',serif;font-size:17px;font-weight:900;color:#fff;line-height:1.3}
.omh-sub{font-size:11px;color:rgba(255,255,255,.45);margin-top:3px}
.omc-btn{background:none;border:none;color:rgba(255,255,255,.45);font-size:24px;cursor:pointer;line-height:1;transition:color .15s}
.omc-btn:hover{color:#fff}
.omb{padding:24px}
.omf{padding:14px 24px;display:flex;gap:9px;justify-content:flex-end;border-top:1px solid var(--light);background:#fafaf8;border-radius:0 0 6px 6px}
.cc-lbl{display:block;font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:6px}
.cc-input{width:100%;border:1px solid var(--light);background:var(--off);padding:10px 12px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--navy);outline:none;border-radius:3px;transition:border-color .15s}
.cc-input:focus{border-color:var(--navy);background:#fff}

/* drop zone */
.drop-zone{border:2px dashed var(--light);border-radius:6px;background:var(--off);padding:28px;text-align:center;cursor:pointer;transition:all .2s;position:relative}
.drop-zone:hover{border-color:var(--navy);background:#fff}
.drop-zone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer}
.drop-zone svg{width:34px;height:34px;stroke:#d1d5db;fill:none;stroke-width:1.5;margin-bottom:10px}
.drop-zone .dz-title{font-size:13px;font-weight:600;color:var(--navy)}
.drop-zone .dz-sub{font-size:11px;color:var(--grey);margin-top:4px}
.dz-file{font-size:12px;font-weight:600;color:var(--navy);margin-top:10px}

/* preview */
.preview-img{max-width:100%;border:1px solid var(--light);border-radius:4px;display:block;margin:0 auto}
.preview-frame{width:100%;height:62vh;border:1px solid var(--light);border-radius:4px}
</style>
@endsection

@section('content')

{{-- Page heading --}}
<div style="margin-bottom:22px">
    <h1 style="font-family:'Playfair Display',serif;font-size:30px;font-weight:900;color:var(--navy);line-height:1.1">State <em style="color:var(--gold);font-style:normal">Branches</em></h1>
    <p style="font-size:13px;color:var(--grey);margin-top:4px">Each Malaysian state is a YES branch account — upload and manage their yearly organisation charts</p>
</div>

{{-- Summary Stats --}}
<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:14px;margin-bottom:24px">
    <div class="sc">
        <div class="sc-bar" style="background:var(--gold)"></div>
        <div class="sc-lbl">State Branches</div>
        <div class="sc-val">{{ $totalBranches }}</div>
        <div class="sc-sub">States &amp; federal territories</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--green)"></div>
        <div class="sc-lbl">Org Charts Uploaded</div>
        <div class="sc-val" id="uploadedStat">{{ $totalUploaded }}</div>
        <div class="sc-sub">Across all years</div>
    </div>
</div>

{{-- State branch cards --}}
<div id="sbList"></div>

{{-- Upload Modal --}}
<div class="modal-ov" id="uploadModal" onclick="if(event.target===this)closeUpload()">
    <div class="org-modal">
        <div class="omh">
            <div>
                <div class="omh-badge">Upload Org Chart</div>
                <h3 id="upTitle">State Branch</h3>
                <div class="omh-sub">Image or PDF — replaces any chart for the same year</div>
            </div>
            <button class="omc-btn" onclick="closeUpload()">×</button>
        </div>
        <div class="omb">
            <div style="margin-bottom:16px">
                <label class="cc-lbl">Academic Year <span style="color:var(--red)">*</span></label>
                <input class="cc-input" id="up-year" type="text" placeholder="e.g. 2025/2026"/>
            </div>
            <label class="cc-lbl">Organisation Chart File <span style="color:var(--red)">*</span></label>
            <div class="drop-zone" id="dropZone">
                <input type="file" id="up-file" accept="image/*,application/pdf" onchange="onFilePicked()"/>
                <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                <div class="dz-title">Click or drop a file to upload</div>
                <div class="dz-sub">PNG · JPG · WEBP · PDF — max 8 MB</div>
                <div class="dz-file" id="dz-file"></div>
            </div>
        </div>
        <div class="omf">
            <button class="btn-ghost" onclick="closeUpload()">Cancel</button>
            <button class="btn-prim" id="upSubmit" onclick="submitUpload()">Upload Chart</button>
        </div>
    </div>
</div>

{{-- Preview Modal --}}
<div class="modal-ov" id="previewModal" onclick="if(event.target===this)closePreview()">
    <div class="org-modal wide">
        <div class="omh">
            <div>
                <div class="omh-badge">Organisation Chart</div>
                <h3 id="pvTitle">State Branch</h3>
                <div class="omh-sub" id="pvSub">Academic year</div>
            </div>
            <button class="omc-btn" onclick="closePreview()">×</button>
        </div>
        <div class="omb" id="pvBody"></div>
        <div class="omf">
            <a id="pvOpen" href="#" target="_blank" rel="noopener" class="btn-ghost">Open in new tab ↗</a>
            <button class="btn-prim" onclick="closePreview()">Done</button>
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
    document.getElementById('sbList').innerHTML = STATES.map(s => {
        const yearCell = s.org_charts.length
            ? `<select class="year-sel" id="yr-${s.id}" onchange="onYearChange(${s.id})">
                 ${s.org_charts.map(oc => `<option value="${oc.id}">${oc.academic_year}</option>`).join('')}
               </select>`
            : `<span class="year-none">No org chart uploaded</span>`;
        return `
        <div class="sb-card" style="--accent:${s.color}">
            <div class="sb-main">
                <div class="sb-dot"></div>
                <div class="sb-info">
                    <div class="sb-name">${s.name}</div>
                </div>
            </div>
            <div class="sb-right">
                ${yearCell}
                <div class="sb-actions" id="act-${s.id}" style="display:flex;gap:8px;flex-wrap:wrap;justify-content:flex-end">${actionsHtml(s, currentChart(s))}</div>
            </div>
        </div>`;
    }).join('');
}

function currentChart(s) {
    if (!s.org_charts.length) return null;
    const sel = document.getElementById('yr-' + s.id);
    const id  = sel ? parseInt(sel.value) : s.org_charts[0].id;
    return s.org_charts.find(o => o.id === id) || s.org_charts[0];
}
function stateById(id){ return STATES.find(s => s.id === id); }

function actionsHtml(s, chart) {
    const upload = `<button class="btn-upload" onclick="openUpload(${s.id})">
        <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>Upload</button>`;
    if (!chart) return upload;
    const view = `<button class="btn-view" onclick="openPreview(${s.id},${chart.id})">
        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>View</button>`;
    const remove = `<button class="btn-remove" onclick="removeChart(${s.id},${chart.id})">
        <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>Remove</button>`;
    return view + remove + upload;
}

function onYearChange(id) {
    const s = stateById(id);
    document.getElementById('act-' + id).innerHTML = actionsHtml(s, currentChart(s));
}

/* ── UPLOAD ── */
let uploadTarget = null;
function openUpload(id) {
    uploadTarget = id;
    const s = stateById(id);
    document.getElementById('upTitle').textContent = s.name + ' State Branch';
    document.getElementById('up-year').value = '';
    document.getElementById('up-file').value = '';
    document.getElementById('dz-file').textContent = '';
    document.getElementById('uploadModal').classList.add('open');
}
function closeUpload(){ document.getElementById('uploadModal').classList.remove('open'); }
function onFilePicked(){
    const f = document.getElementById('up-file').files[0];
    document.getElementById('dz-file').textContent = f ? ('Selected: ' + f.name) : '';
}
async function submitUpload() {
    const year = document.getElementById('up-year').value.trim();
    const file = document.getElementById('up-file').files[0];
    if (!year || !file) { showToast('Academic year and a file are required.', 'danger'); return; }

    const fd = new FormData();
    fd.append('academic_year', year);
    fd.append('chart', file);

    const btn = document.getElementById('upSubmit');
    btn.disabled = true; btn.textContent = 'Uploading…';
    try {
        const r = await fetch(`/dashboard/admin/chapters/${uploadTarget}/org-chart`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: fd,
        });
        const json = await r.json();
        if (!r.ok) { throw new Error(json.errors ? Object.values(json.errors)[0][0] : (json.message || 'Upload failed')); }

        const s = stateById(uploadTarget);
        const existed = s.org_charts.some(o => o.academic_year === json.chart.academic_year);
        s.org_charts = s.org_charts.filter(o => o.academic_year !== json.chart.academic_year);
        s.org_charts.push(json.chart);
        s.org_charts.sort((a, b) => b.academic_year.localeCompare(a.academic_year));
        renderStates();
        const sel = document.getElementById('yr-' + s.id); if (sel) sel.value = json.chart.id;
        onYearChange(s.id);
        if (!existed) bumpUploaded(1);
        closeUpload();
        showToast('Org chart uploaded', 'success');
    } catch (e) {
        showToast(e.message || 'Upload failed', 'danger');
    } finally {
        btn.disabled = false; btn.textContent = 'Upload Chart';
    }
}

/* ── REMOVE ── */
async function removeChart(stateId, chartId) {
    const s = stateById(stateId);
    const chart = s.org_charts.find(o => o.id === chartId);
    if (!confirm(`Remove ${s.name}'s ${chart.academic_year} org chart?`)) return;
    try {
        const r = await fetch(`/dashboard/admin/chapters/org-charts/${chartId}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });
        if (!r.ok) throw new Error('Could not remove');
        s.org_charts = s.org_charts.filter(o => o.id !== chartId);
        renderStates();
        bumpUploaded(-1);
        showToast('Org chart removed', 'danger');
    } catch (e) { showToast('Could not remove chart.', 'danger'); }
}

/* ── PREVIEW ── */
function openPreview(stateId, chartId) {
    const s = stateById(stateId);
    const chart = s.org_charts.find(o => o.id === chartId);
    if (!chart) return;
    document.getElementById('pvTitle').textContent = s.name + ' State Branch';
    document.getElementById('pvSub').textContent   = 'Academic Year ' + chart.academic_year;
    document.getElementById('pvOpen').href         = chart.url;
    document.getElementById('pvBody').innerHTML = chart.is_pdf
        ? `<iframe class="preview-frame" src="${chart.url}"></iframe>`
        : `<img class="preview-img" src="${chart.url}" alt="Org chart"/>`;
    document.getElementById('previewModal').classList.add('open');
}
function closePreview(){ document.getElementById('previewModal').classList.remove('open'); }

/* ── helpers ── */
function bumpUploaded(delta){
    const el = document.getElementById('uploadedStat');
    el.textContent = Math.max(0, parseInt(el.textContent || '0') + delta);
}

/* ── INIT ── */
renderStates();
</script>
@endsection
