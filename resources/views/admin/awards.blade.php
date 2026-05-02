@extends('admin.layouts.app')

@section('title', 'Award Management')
@section('page-title', 'Award')
@section('page-subtitle', 'Management')
@section('page-desc', 'Assign points and awards to student chapters · ' . now()->format('j F Y'))

@section('styles')
<style>
/* ── TWO-COL LAYOUT ── */
.aw-layout{display:grid;grid-template-columns:1fr 360px;gap:16px;align-items:start}

/* ── CHAPTER TABLE ── */
.aw-table{width:100%;border-collapse:collapse}
.aw-table th{font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);text-align:left;padding:10px 18px;border-bottom:2px solid var(--light);background:var(--off)}
.aw-table td{padding:13px 18px;border-bottom:1px solid var(--light);vertical-align:middle}
.aw-table tr:last-child td{border-bottom:none}
.aw-table tr:hover td{background:#fafaf8;cursor:pointer}
.aw-table tr.selected td{background:rgba(200,168,75,.05);border-left:3px solid var(--gold)}
.ch-name{font-size:13px;font-weight:700;color:var(--navy)}
.ch-uni{font-size:11px;color:var(--grey);margin-top:2px}
.pts-val{font-family:'Playfair Display',serif;font-size:16px;font-weight:900;color:var(--navy)}
.rank-badge{display:inline-flex;align-items:center;justify-content:center;width:24px;height:24px;border-radius:50%;font-size:11px;font-weight:700}
.rank-1{background:rgba(200,168,75,.2);color:#7a5b14}
.rank-2{background:rgba(170,170,170,.2);color:#555}
.rank-3{background:rgba(184,115,51,.15);color:#7c3a00}
.rank-n{background:var(--off);border:1px solid var(--light);color:var(--grey)}

/* ── AWARD FORM PANEL ── */
.aw-form-panel{background:#fff;border:1px solid var(--light);border-radius:4px;position:sticky;top:82px}
.afp-head{background:var(--navy-dark);padding:16px 20px;border-radius:4px 4px 0 0}
.afp-title{font-family:'Playfair Display',serif;font-size:15px;font-weight:700;color:#fff}
.afp-sub{font-size:11px;color:rgba(255,255,255,.4);margin-top:3px}
.afp-body{padding:18px 20px}
.selected-chip{display:flex;align-items:center;gap:8px;background:var(--gold-dim);border:1px solid rgba(200,168,75,.3);padding:10px 14px;border-radius:3px;margin-bottom:16px}
.sc-logo{width:28px;height:28px;background:var(--gold);border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:10px;font-weight:900;color:var(--navy-dark);flex-shrink:0}
.sc-info{}
.sc-name{font-size:12px;font-weight:700;color:var(--navy-dark)}
.sc-pts{font-size:10px;color:#7a5b14;margin-top:1px}
.no-select{font-size:12px;color:var(--grey);text-align:center;padding:14px 0}

/* ── ACTIVITY TYPE GRID ── */
.act-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:16px}
.act-tile{border:1px solid var(--light);padding:10px 12px;cursor:pointer;transition:all .15s;border-radius:3px}
.act-tile:hover{border-color:var(--navy)}
.act-tile.selected{border-color:var(--gold);background:var(--gold-dim)}
.at-icon{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:6px}
.at-icon svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2}
.at-name{font-size:11px;font-weight:700;color:var(--navy);margin-bottom:2px}
.at-pts{font-size:10px;color:var(--grey)}

/* ── HISTORY TABLE ── */
.hist-table{width:100%;border-collapse:collapse;font-size:11px}
.hist-table td{padding:8px 18px;border-bottom:1px solid var(--light)}
.hist-table tr:last-child td{border-bottom:none}
.hist-chapter{font-weight:600;color:var(--navy)}
.hist-act{color:var(--grey)}
.hist-pts{font-weight:700;color:var(--gold);text-align:right;white-space:nowrap}
.hist-date{color:var(--grey);white-space:nowrap}
</style>
@endsection

@section('topbar-actions')
<button class="btn-primary" onclick="openAssign()">
    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Assign Points
</button>
@endsection

@section('content')

{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:22px">
    <div class="sc">
        <div class="sc-bar" style="background:var(--gold)"></div>
        <div class="sc-lbl">Total Assignments</div>
        <div class="sc-val">87</div>
        <div class="sc-sub">This academic year</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--navy)"></div>
        <div class="sc-lbl">Points Distributed</div>
        <div class="sc-val">14.2k</div>
        <div class="sc-sub">Across all chapters</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--green)"></div>
        <div class="sc-lbl">Chapters Awarded</div>
        <div class="sc-val">32</div>
        <div class="sc-sub">Of 38 active chapters</div>
    </div>
    <div class="sc">
        <div class="sc-bar" style="background:var(--amber)"></div>
        <div class="sc-lbl">NATSUM Countdown</div>
        <div class="sc-val" id="days-left">—</div>
        <div class="sc-sub">Days to award ceremony</div>
    </div>
</div>

<div class="aw-layout">

    {{-- Left: Chapter Leaderboard --}}
    <div>
        <div class="panel">
            <div class="ph">
                <div class="pt">Chapter <em>Leaderboard</em></div>
                <div style="display:flex;gap:8px">
                    <div class="si-wrap" style="min-width:180px">
                        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" placeholder="Search chapter…" oninput="filterChapters(this.value)"/>
                    </div>
                    <select class="fsel" onchange="sortChapters(this.value)">
                        <option value="pts">Sort: Points</option>
                        <option value="alpha">Sort: A–Z</option>
                        <option value="recent">Most Recent</option>
                    </select>
                </div>
            </div>
            <div style="overflow-x:auto">
                <table class="aw-table" id="chapter-table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Chapter</th>
                            <th style="text-align:center">Total Points</th>
                            <th style="text-align:center">Awards</th>
                            <th>Last Activity</th>
                            <th style="text-align:right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach([
                        [1,'YES UTM Kuala Lumpur','Universiti Teknologi Malaysia, KL','1,240',3,'24 Apr 2025','rank-1'],
                        [2,'YES USM Penang','Universiti Sains Malaysia','1,105',2,'22 Apr 2025','rank-2'],
                        [3,'YES UTM Johor','Universiti Teknologi Malaysia, Skudai','980',1,'18 Apr 2025','rank-3'],
                        [4,'YES UTP Perak','Universiti Teknologi PETRONAS','855',0,'15 Apr 2025','rank-n'],
                        [5,'YES UNITEN KL','Universiti Tenaga Nasional','810',0,'12 Apr 2025','rank-n'],
                        [6,'YES UiTM Shah Alam','Universiti Teknologi MARA','760',0,'9 Apr 2025','rank-n'],
                        [7,'YES UMP Gambang','Universiti Malaysia Pahang','680',0,'5 Apr 2025','rank-n'],
                        [8,'YES UNIMAS Sarawak','Universiti Malaysia Sarawak','640',0,'2 Apr 2025','rank-n'],
                    ] as [$rank,$chapter,$uni,$pts,$awards,$last,$rankClass])
                    <tr onclick="selectChapter(this,'{{ $chapter }}','{{ $uni }}','{{ $pts }}')" data-chapter="{{ strtolower($chapter) }}">
                        <td><span class="rank-badge {{ $rankClass }}">{{ $rank }}</span></td>
                        <td>
                            <div class="ch-name">{{ $chapter }}</div>
                            <div class="ch-uni">{{ $uni }}</div>
                        </td>
                        <td style="text-align:center"><div class="pts-val">{{ $pts }}</div></td>
                        <td style="text-align:center">
                            @if($awards > 0)
                                <span class="badge badge-gold" style="background:rgba(200,168,75,.15);color:#7a5b14;border:1px solid rgba(200,168,75,.3)">{{ $awards }} award{{ $awards > 1 ? 's' : '' }}</span>
                            @else
                                <span style="font-size:11px;color:var(--grey)">—</span>
                            @endif
                        </td>
                        <td class="et-sm">{{ $last }}</td>
                        <td style="text-align:right">
                            <button class="btn-primary" style="font-size:9px;padding:6px 12px" onclick="event.stopPropagation(); selectChapter(this.closest('tr'),'{{ $chapter }}','{{ $uni }}','{{ $pts }}'); openAssign()">
                                Assign
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="panel" style="margin-top:16px">
            <div class="ph">
                <div class="pt">Recent Point <em>Assignments</em></div>
            </div>
            <div style="overflow-x:auto">
                <table class="hist-table">
                    <tbody>
                    @foreach([
                        ['YES UTM KL','YES Collaboration Event','+ 150 pts','24 Apr'],
                        ['YES USM Penang','Annual Report Approved','+ 50 pts','22 Apr'],
                        ['YES UTM Johor','Sustainability Campaign','+ 80 pts','18 Apr'],
                        ['YES UTP Perak','Industry Webinar','+ 40 pts','15 Apr'],
                        ['YES UNITEN KL','Org Chart Approved','+ 25 pts','12 Apr'],
                        ['YES UiTM Shah Alam','NATSUM Participation','+ 100 pts','9 Apr'],
                    ] as [$chapter,$activity,$pts,$date])
                    <tr>
                        <td><span class="hist-chapter">{{ $chapter }}</span></td>
                        <td><span class="hist-act">{{ $activity }}</span></td>
                        <td><span class="hist-pts">{{ $pts }}</span></td>
                        <td><span class="hist-date">{{ $date }}</span></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Right: Assignment Form --}}
    <div class="aw-form-panel">
        <div class="afp-head">
            <div class="afp-title">Assign Points</div>
            <div class="afp-sub">Select a chapter from the table then fill in the form</div>
        </div>
        <div class="afp-body">

            <div id="selected-chapter-chip">
                <div class="no-select">← Select a chapter to begin</div>
            </div>

            <div id="assign-form" style="display:none">
                <div class="pf-row">
                    <label class="pf-lbl">Activity Type</label>
                    <div class="act-grid">
                        @foreach([
                            ['event','var(--navy)','rgba(0,31,69,.06)','YES Collaboration Event','100–200 pts','<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>'],
                            ['sustainability','var(--green-a)','rgba(76,175,125,.1)','Sustainability Activity','50–150 pts','<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>'],
                            ['report','var(--amber)','var(--amber-l)','Annual Report','50 pts','<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>'],
                            ['orgchart','#7c3aed','#ede9fe','Org Chart Approved','25 pts','<circle cx="12" cy="5" r="3"/><line x1="12" y1="8" x2="12" y2="19"/>'],
                            ['natsum','var(--gold)','var(--gold-dim)','NATSUM Participation','100 pts','<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>'],
                            ['cafeo','#0891b2','#e0f2fe','CAFEO Delegation','150 pts','<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/>'],
                            ['webinar','#5b21b6','#ede9fe','Industry Talk / Webinar','30–80 pts','<polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/>'],
                            ['other','var(--grey)','var(--off)','Other Activity','Custom pts','<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>'],
                        ] as [$key,$color,$bg,$name,$pts,$icon])
                        <div class="act-tile" onclick="selectActivity(this,'{{ $key }}','{{ $name }}')" data-activity="{{ $key }}">
                            <div class="at-icon" style="background:{{ $bg }};color:{{ $color }}">
                                <svg viewBox="0 0 24 24">{!! $icon !!}</svg>
                            </div>
                            <div class="at-name">{{ $name }}</div>
                            <div class="at-pts">{{ $pts }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="pf-row">
                    <label class="pf-lbl" for="pts-input">Points to Assign</label>
                    <input type="number" id="pts-input" class="pf-input" placeholder="e.g. 150" min="1" max="500"/>
                </div>

                <div class="pf-row">
                    <label class="pf-lbl" for="ref-input">Event / Activity Reference</label>
                    <input type="text" id="ref-input" class="pf-input" placeholder="e.g. STEM Career Fair 2025"/>
                </div>

                <div class="pf-row">
                    <label class="pf-lbl" for="note-input">Notes (shown in chapter history)</label>
                    <textarea id="note-input" class="pf-textarea" placeholder="Optional internal notes…"></textarea>
                </div>

                <div style="display:flex;gap:8px">
                    <button class="btn-ghost" style="flex:1" onclick="clearForm()">Clear</button>
                    <button class="btn-prim" style="flex:2" onclick="submitAssignment()">
                        Assign Points →
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
let selectedChapter = null;
let selectedActivity = null;

// Countdown to NATSUM 2025 (14 Aug 2025)
const natsum = new Date('2025-08-14');
const today  = new Date();
const diff   = Math.ceil((natsum - today) / 86400000);
document.getElementById('days-left').textContent = diff > 0 ? diff : '—';

function selectChapter(row, name, uni, pts) {
    document.querySelectorAll('.aw-table tr').forEach(r => r.classList.remove('selected'));
    row.classList.add('selected');
    selectedChapter = {name, uni, pts};

    document.getElementById('selected-chapter-chip').innerHTML = `
        <div class="selected-chip">
            <div class="sc-logo">${name.split(' ').slice(1,3).map(w=>w[0]).join('')}</div>
            <div class="sc-info">
                <div class="sc-name">${name}</div>
                <div class="sc-pts">Current: ${pts} pts</div>
            </div>
        </div>`;
    document.getElementById('assign-form').style.display = 'block';
}

function selectActivity(tile, key, name) {
    document.querySelectorAll('.act-tile').forEach(t => t.classList.remove('selected'));
    tile.classList.add('selected');
    selectedActivity = key;

    const defaults = {event:150,sustainability:80,report:50,orgchart:25,natsum:100,cafeo:150,webinar:50,other:''};
    const ptsInput = document.getElementById('pts-input');
    if (defaults[key]) ptsInput.value = defaults[key];
    else ptsInput.value = '';
    ptsInput.focus();
}

function openAssign() {
    if (!selectedChapter) {
        showToast('Select a chapter from the table first.', 'warn');
        return;
    }
    document.getElementById('assign-form').scrollIntoView({behavior:'smooth',block:'start'});
}

function clearForm() {
    document.querySelectorAll('.act-tile').forEach(t => t.classList.remove('selected'));
    document.getElementById('pts-input').value  = '';
    document.getElementById('ref-input').value  = '';
    document.getElementById('note-input').value = '';
    selectedActivity = null;
}

function submitAssignment() {
    if (!selectedChapter) { showToast('Select a chapter first.','warn'); return; }
    if (!selectedActivity) { showToast('Select an activity type.','warn'); return; }
    const pts = parseInt(document.getElementById('pts-input').value);
    if (!pts || pts < 1) { showToast('Enter a valid point value.','warn'); return; }
    const ref = document.getElementById('ref-input').value.trim();
    if (!ref) { showToast('Enter an activity reference.','warn'); return; }

    showToast(`${pts} points assigned to ${selectedChapter.name}.`, 'success');
    clearForm();
    document.querySelectorAll('.aw-table tr').forEach(r => r.classList.remove('selected'));
    selectedChapter = null;
    document.getElementById('assign-form').style.display = 'none';
    document.getElementById('selected-chapter-chip').innerHTML = '<div class="no-select">← Select a chapter to begin</div>';
}

function filterChapters(q) {
    document.querySelectorAll('#chapter-table tbody tr').forEach(row => {
        row.style.display = !q || row.dataset.chapter.includes(q.toLowerCase()) ? '' : 'none';
    });
}

function sortChapters(by) {
    // In a real app this would re-sort the data; stub for UI demo.
}
</script>
@endsection
