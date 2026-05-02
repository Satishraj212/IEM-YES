@extends('admin.layouts.app')

@section('title', 'Annual Reports')
@section('page-title', 'Annual')
@section('page-subtitle', 'Reports')
@section('page-desc', 'Review and approve student chapter annual report submissions · ' . now()->format('j F Y'))

@section('styles')
<style>
/* ── FILTER ── */
.filter-row{display:flex;gap:9px;align-items:center;margin-bottom:16px;flex-wrap:wrap}

/* ── REPORT TABLE ── */
.report-panel{background:#fff;border:1px solid var(--light);border-radius:4px;overflow:hidden}
.report-table{width:100%;border-collapse:collapse}
.report-table th{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);text-align:left;padding:11px 20px;border-bottom:2px solid var(--light);background:var(--off)}
.report-table td{padding:14px 20px;border-bottom:1px solid var(--light);vertical-align:middle}
.report-table tr:last-child td{border-bottom:none}
.report-table tr:hover td{background:#fafaf8}
.chapter-name{font-size:13px;font-weight:700;color:var(--navy)}
.chapter-uni{font-size:11px;color:var(--grey);margin-top:2px}

/* ── FILE PREVIEW ── */
.file-info{display:flex;align-items:center;gap:9px}
.fi-icon{width:32px;height:32px;background:var(--off);border:1px solid var(--light);border-radius:3px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.fi-icon svg{width:14px;height:14px;stroke:var(--navy);fill:none;stroke-width:2}
.fi-name{font-size:11px;font-weight:600;color:var(--navy)}
.fi-meta{font-size:10px;color:var(--grey);margin-top:2px}

/* ── ACTION CELL ── */
.act-cell{display:flex;gap:6px;align-items:center;justify-content:flex-end}

/* ── SLIDE PANEL OVERRIDES ── */
.rp-field{margin-bottom:14px}
.rp-lbl{font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:5px}
.rp-val{font-size:12px;color:#333;line-height:1.55}

/* ── PROGRESS PIPELINE ── */
.pipeline-steps{display:flex;align-items:center;gap:0;margin:16px 0}
.ps{display:flex;flex-direction:column;align-items:center;flex:1;position:relative}
.ps::after{content:'';position:absolute;top:14px;left:50%;width:100%;height:2px;background:var(--light);z-index:0}
.ps:last-child::after{display:none}
.ps-dot{width:28px;height:28px;border-radius:50%;border:2px solid var(--light);background:#fff;display:flex;align-items:center;justify-content:center;z-index:1;position:relative}
.ps-dot svg{width:12px;height:12px;stroke:var(--grey);fill:none;stroke-width:2.5}
.ps-dot.done{background:var(--green);border-color:var(--green)}
.ps-dot.done svg{stroke:#fff}
.ps-dot.active{background:var(--gold);border-color:var(--gold)}
.ps-dot.active svg{stroke:var(--navy-dark)}
.ps-lbl{font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--grey);margin-top:6px;text-align:center;max-width:72px;line-height:1.3}
.ps-lbl.done{color:var(--green)}
.ps-lbl.active{color:var(--gold)}
</style>
@endsection

@section('topbar-actions')
<button class="btn-primary" onclick="showToast('Reminder emails sent to all pending chapters.','success')">
    <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
    Send Reminders
</button>
@endsection

@section('content')

{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:22px">
    <div class="sc">
        <div class="sc-bar" style="background:var(--amber)"></div>
        <div class="sc-lbl">Pending Upload</div>
        <div class="sc-val">14</div>
        <div class="sc-sub">Chapters not yet submitted</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--blue)"></div>
        <div class="sc-lbl">Under Review</div>
        <div class="sc-val">5</div>
        <div class="sc-sub">Awaiting admin approval</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--green)"></div>
        <div class="sc-lbl">Approved & Stored</div>
        <div class="sc-val">19</div>
        <div class="sc-sub">Archived reports</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--navy)"></div>
        <div class="sc-lbl">Submission Rate</div>
        <div class="sc-val">63%</div>
        <div class="sc-sub">24 of 38 chapters done</div>
    </div>
</div>

{{-- Cycle selector --}}
<div class="filter-row">
    <select class="fsel" id="cycle-sel" onchange="filterTable()">
        <option value="2025">Academic Year 2024/25</option>
        <option value="2024">Academic Year 2023/24</option>
        <option value="2023">Academic Year 2022/23</option>
    </select>
    <div class="si-wrap" style="flex:1;max-width:300px">
        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Search chapter…" oninput="filterTable()"/>
    </div>
    <select class="fsel" onchange="filterTable()">
        <option value="">All Statuses</option>
        <option value="pending">Pending Upload</option>
        <option value="review">Under Review</option>
        <option value="approved">Approved</option>
        <option value="rejected">Returned</option>
    </select>
</div>

{{-- Reports Table --}}
<div class="report-panel">
    <table class="report-table" id="report-table">
        <thead>
            <tr>
                <th>Chapter</th>
                <th>Submitted</th>
                <th>Report File</th>
                <th>Pages / Size</th>
                <th style="text-align:center">Status</th>
                <th style="text-align:right">Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach([
            ['YES UTM Kuala Lumpur','Universiti Teknologi Malaysia, KL','24 Apr 2025','annual_report_utm_kl_2025.pdf','42 pp · 4.1 MB','review'],
            ['YES USM Penang','Universiti Sains Malaysia','22 Apr 2025','annual_report_usm_2025.pdf','38 pp · 3.8 MB','review'],
            ['YES UTM Johor','Universiti Teknologi Malaysia, Skudai','18 Apr 2025','annual_report_utm_johor_2025.pdf','55 pp · 5.2 MB','approved'],
            ['YES UTP Perak','Universiti Teknologi PETRONAS','12 Apr 2025','annual_report_utp_2025.pdf','31 pp · 2.9 MB','approved'],
            ['YES UiTM Shah Alam','Universiti Teknologi MARA','8 Apr 2025','annual_report_uitm_sa_2025.pdf','28 pp · 2.4 MB','approved'],
            ['YES UNITEN KL','Universiti Tenaga Nasional','3 Apr 2025','annual_report_uniten_2025.pdf','22 pp · 1.8 MB','rejected'],
            ['YES UMP Gambang','Universiti Malaysia Pahang','—','—','—','pending'],
            ['YES UNIMAS Sarawak','Universiti Malaysia Sarawak','—','—','—','pending'],
        ] as [$chapter,$uni,$date,$file,$meta,$status])
        @php
            $badges = [
                'review'   => ['b-upcoming', 'Under Review'],
                'approved' => ['b-approved', 'Approved'],
                'rejected' => ['b-rejected', 'Returned'],
                'pending'  => ['b-pending',  'Pending Upload'],
            ];
            [$badgeClass, $badgeText] = $badges[$status];
        @endphp
        <tr data-status="{{ $status }}">
            <td>
                <div class="chapter-name">{{ $chapter }}</div>
                <div class="chapter-uni">{{ $uni }}</div>
            </td>
            <td class="et-sm">{{ $date }}</td>
            <td>
                @if($file !== '—')
                <div class="file-info">
                    <div class="fi-icon">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div>
                        <div class="fi-name">{{ $file }}</div>
                        <div class="fi-meta">PDF</div>
                    </div>
                </div>
                @else
                <span style="font-size:11px;color:var(--grey)">Not submitted yet</span>
                @endif
            </td>
            <td class="et-sm">{{ $meta }}</td>
            <td style="text-align:center">
                <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
            </td>
            <td>
                <div class="act-cell">
                    @if($file !== '—')
                    <button class="abtn" title="Preview" onclick="openPreview('{{ $chapter }}','{{ $uni }}','{{ $file }}','{{ $meta }}','{{ $status }}')">
                        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                    <button class="abtn" title="Download">
                        <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    </button>
                    @endif
                    @if($status === 'review')
                    <button class="btn-approve" style="padding:6px 12px;font-size:9px" onclick="approveReport(this)">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Approve
                    </button>
                    <button class="btn-reject" style="padding:6px 12px;font-size:9px" onclick="rejectReport(this)">
                        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Return
                    </button>
                    @elseif($status === 'pending')
                    <button class="btn-primary" style="font-size:9px;padding:6px 12px" onclick="showToast('Reminder sent to chapter.','success')">
                        <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Remind
                    </button>
                    @endif
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{-- Preview Slide Panel --}}
<div class="dim-overlay" id="dim" onclick="closePreview()"></div>
<div class="slide-panel" id="preview-panel">
    <div class="sp-head">
        <div>
            <div class="sp-mode-badge">Annual Report</div>
            <h3 id="sp-title">Chapter Name</h3>
            <div style="font-size:11px;color:rgba(255,255,255,.4);margin-top:3px" id="sp-uni"></div>
        </div>
        <button class="sp-close" onclick="closePreview()">×</button>
    </div>
    <div class="sp-body">

        {{-- Pipeline --}}
        <div style="margin-bottom:20px">
            <div class="pf-lbl">Review Pipeline</div>
            <div class="pipeline-steps" id="sp-pipeline">
                <div class="ps"><div class="ps-dot done"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><div class="ps-lbl done">Submitted</div></div>
                <div class="ps"><div class="ps-dot active"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div><div class="ps-lbl active">Admin Review</div></div>
                <div class="ps"><div class="ps-dot"><svg viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg></div><div class="ps-lbl">Archived</div></div>
            </div>
        </div>

        <div class="pf-row">
            <div class="pf-lbl">File</div>
            <div id="sp-file" class="pf-val"></div>
        </div>
        <div class="pf-row">
            <div class="pf-lbl">Size / Pages</div>
            <div id="sp-meta" class="pf-val muted"></div>
        </div>
        <hr class="pf-divider"/>
        <div class="pf-row">
            <label class="pf-lbl" for="sp-note">Admin Notes (sent to chapter on action)</label>
            <textarea id="sp-note" class="pf-textarea" placeholder="Optional notes or feedback for the chapter…"></textarea>
        </div>
    </div>
    <div class="sp-foot" id="sp-foot">
        <button class="btn-ghost" onclick="closePreview()">Cancel</button>
        <button class="btn-reject" onclick="rejectFromPanel()">
            <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            Return to Chapter
        </button>
        <button class="btn-approve" onclick="approveFromPanel()">
            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            Approve & Archive
        </button>
    </div>
</div>

@endsection

@section('scripts')
<script>
let activeRow = null;

function openPreview(chapter, uni, file, meta, status) {
    document.getElementById('sp-title').textContent = chapter;
    document.getElementById('sp-uni').textContent   = uni;
    document.getElementById('sp-file').textContent  = file;
    document.getElementById('sp-meta').textContent  = meta;
    document.getElementById('sp-note').value        = '';

    const foot = document.getElementById('sp-foot');
    if (status !== 'review') {
        foot.querySelector('.btn-reject').style.display  = 'none';
        foot.querySelector('.btn-approve').style.display = 'none';
    } else {
        foot.querySelector('.btn-reject').style.display  = 'flex';
        foot.querySelector('.btn-approve').style.display = 'flex';
    }

    document.getElementById('dim').classList.add('on');
    document.getElementById('preview-panel').classList.add('open');
}

function closePreview() {
    document.getElementById('dim').classList.remove('on');
    document.getElementById('preview-panel').classList.remove('open');
}

function approveReport(btn) {
    const row     = btn.closest('tr');
    const chapter = row.querySelector('.chapter-name')?.textContent || 'this chapter';
    showConfirm({
        title: 'Approve Annual Report',
        msg:   'This will mark the report as approved and archive it. The chapter will be notified.',
        chip:  chapter,
        type:  'approve',
        onConfirm: () => {
            const badge = row.querySelector('.badge');
            badge.className = 'badge b-approved'; badge.textContent = 'Approved';
            btn.closest('.act-cell').querySelector('.btn-reject')?.remove();
            btn.closest('.act-cell').querySelector('.btn-approve')?.remove();
            showToast('Annual report approved and archived.', 'success');
        }
    });
}

function rejectReport(btn) {
    const row     = btn.closest('tr');
    const chapter = row.querySelector('.chapter-name')?.textContent || 'this chapter';
    showConfirm({
        title:        'Return Report to Chapter',
        msg:          'The report will be returned to the chapter for revision. Please provide feedback so they know what to correct.',
        chip:         chapter,
        type:         'reject',
        requireNotes: true,
        onConfirm: (notes) => {
            const badge = row.querySelector('.badge');
            badge.className = 'badge b-rejected'; badge.textContent = 'Returned';
            btn.closest('.act-cell').querySelector('.btn-reject')?.remove();
            btn.closest('.act-cell').querySelector('.btn-approve')?.remove();
            showToast('Report returned to chapter with feedback.', 'danger');
        }
    });
}

function approveFromPanel() {
    const chapter = document.getElementById('sp-title').textContent;
    showConfirm({
        title: 'Approve Annual Report',
        msg:   'This will mark the report as approved and archive it. The chapter will be notified.',
        chip:  chapter,
        type:  'approve',
        onConfirm: () => { closePreview(); showToast('Annual report approved and archived.', 'success'); }
    });
}

function rejectFromPanel() {
    const chapter = document.getElementById('sp-title').textContent;
    showConfirm({
        title:        'Return Report to Chapter',
        msg:          'The report will be returned to the chapter for revision. Please provide feedback.',
        chip:         chapter,
        type:         'reject',
        requireNotes: true,
        onConfirm: (notes) => { closePreview(); showToast('Report returned with feedback.', 'danger'); }
    });
}

function filterTable() {
    const q      = document.querySelector('.si-wrap input').value.toLowerCase();
    const status = document.querySelectorAll('.fsel')[1].value;
    document.querySelectorAll('#report-table tbody tr').forEach(row => {
        const matchQ = !q || row.querySelector('.chapter-name').textContent.toLowerCase().includes(q);
        const matchS = !status || row.dataset.status === status;
        row.style.display = (matchQ && matchS) ? '' : 'none';
    });
}
</script>
@endsection
