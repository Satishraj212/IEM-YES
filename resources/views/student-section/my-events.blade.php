{{-- resources/views/student-section/my-events.blade.php --}}
@extends('student-section.layouts.app')
@section('title', 'My Events')

@section('styles')
<style>
/* PPW upload + tag chips (create modal) */
.ppw-drop{display:flex;align-items:center;gap:8px;border:2px dashed var(--light);background:var(--off);padding:11px 14px;cursor:pointer;font-size:11px;color:var(--grey);transition:border-color .2s}
.ppw-drop:hover{border-color:var(--navy)}
.ppw-drop svg{stroke:var(--grey);flex-shrink:0}
.ppw-drop.has-file{border-style:solid;border-color:var(--navy);color:var(--navy);font-weight:600}
.ppw-drop.has-file svg{stroke:var(--navy)}
.tag-input{display:flex;flex-wrap:wrap;align-items:center;gap:6px;border:1px solid var(--light);background:#fff;padding:7px 10px;cursor:text;min-height:38px}
.tag-input:focus-within{border-color:var(--navy)}
.tag-input input{border:none;outline:none;flex:1;min-width:120px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);background:none}
.tag-chip{display:inline-flex;align-items:center;gap:5px;background:var(--navy-dark);color:var(--gold);font-size:11px;font-weight:600;padding:3px 4px 3px 9px}
.tag-chip button{background:none;border:none;color:var(--gold);cursor:pointer;font-size:14px;line-height:1;padding:0 3px;font-family:inherit}
.tag-chip button:hover{color:#fff}
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
.b-hackathon{background:#ede9fe;color:#5b21b6}.b-career{background:#dbeafe;color:#1e40af}
.b-sdg{background:#d1fae5;color:#065f46}.b-workshop{background:#fef3c7;color:#92400e}
.b-webinar{background:#e0f2fe;color:#0369a1}.b-volunteer{background:#d1fae5;color:#065f46}
.b-competition{background:#fce7f3;color:#9d174d}.b-talk{background:#fef9c3;color:#713f12}
.abtns{display:flex;gap:4px}
.abtn{width:28px;height:28px;display:flex;align-items:center;justify-content:center;background:var(--off);border:1px solid var(--light);cursor:pointer;transition:all .2s}
.abtn svg{width:13px;height:13px;fill:none;stroke:var(--navy);stroke-width:2}
.abtn:hover{background:var(--navy);border-color:var(--navy)}.abtn:hover svg{stroke:#fff}
.abtn.del:hover{background:var(--red);border-color:var(--red)}
.ev-chevron{width:16px;height:16px;fill:none;stroke:var(--grey);stroke-width:2;transition:transform .2s}
.ev-chevron.open{transform:rotate(180deg)}
.ev-detail{max-height:0;overflow:hidden;transition:max-height .35s ease}
.ev-detail.open{max-height:900px}
.ev-detail-inner{display:grid;grid-template-columns:120px 1fr 200px;gap:20px;padding:20px;border-top:1px solid var(--light);background:#fafafa}
.sec-lbl{font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:8px}
.poster-box{border:2px dashed var(--light);background:#fff;aspect-ratio:3/4;overflow:hidden;cursor:pointer;position:relative;transition:border-color .2s}
.poster-box:hover{border-color:var(--navy)}
.poster-box input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.poster-box img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
.poster-box.has-poster{border-style:solid;border-color:var(--light)}
.poster-clear-btn{width:100%;margin-top:4px;padding:5px;background:none;border:1px solid var(--light);font-size:9px;font-weight:700;color:var(--red);cursor:pointer;font-family:'DM Sans',sans-serif;display:flex;align-items:center;justify-content:center}
.desc-text{font-size:12px;color:#374151;line-height:1.65}
.status-track{display:flex;gap:0;margin:6px 0}
.st-step{display:flex;flex-direction:column;align-items:center;flex:1;position:relative}
.st-step:not(:last-child)::after{content:'';position:absolute;top:10px;left:50%;width:100%;height:1px;z-index:0}
.s-done::after{background:var(--green-a)}.s-active::after,.s-pending::after{background:var(--light)}
.st-dot{width:20px;height:20px;border-radius:50%;display:flex;align-items:center;justify-content:center;position:relative;z-index:1;flex-shrink:0}
.s-done .st-dot{background:var(--green-a)}.s-done .st-dot svg{width:10px;height:10px;fill:none;stroke:#fff;stroke-width:2.5}
.s-active .st-dot{background:var(--gold)}.s-active .st-dot svg{display:none}
.s-pending .st-dot{background:var(--light)}.s-pending .st-dot svg{display:none}
.st-lbl{font-size:9px;font-weight:600;color:var(--grey);text-align:center;margin-top:4px;white-space:nowrap}
.s-done .st-lbl{color:var(--green)}.s-active .st-lbl{color:var(--amber);font-weight:700}
.notes-area{width:100%;border:1px solid var(--light);background:#fff;font-family:'DM Sans',sans-serif;font-size:11px;color:var(--navy);padding:8px 10px;outline:none;resize:vertical;min-height:50px;margin-top:6px}
.ic-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:10px}
.ic{background:#fff;border:1px solid var(--light);padding:8px 10px}.ic-full{grid-column:1/-1}
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
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="sec-header">
  <div>
    <div class="sh-eyebrow">Event Management</div>
    <div class="sh-title">My <em style="color:var(--gold);font-style:italic">Events</em></div>
    <div class="sh-sub">Events submitted and managed by {{ $branch->name }}.</div>
  </div>
  <div style="display:flex;gap:10px">
    <a href="{{ route('student.events.export') }}" class="btn-secondary">Export Report</a>
    <button class="btn-primary" onclick="openCreateModal()">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Create Event
    </button>
  </div>
</div>

<div class="stat-row">
  <div class="sc" onclick="filterTab('approved')" style="cursor:pointer"><div class="sc-bar" style="background:var(--navy)"></div><div class="sc-lbl">Total Approved Events</div><div class="sc-val">{{ $stats['approved'] }}</div><div class="sc-sub">Signed off by HQ</div></div>
  <div class="sc" onclick="filterTab('published')" style="cursor:pointer"><div class="sc-bar" style="background:var(--green)"></div><div class="sc-lbl">Published Events</div><div class="sc-val">{{ $stats['published'] }}</div><div class="sc-sub">Live on public site</div></div>
  <div class="sc" onclick="filterTab('reinstate')" style="cursor:pointer"><div class="sc-bar" style="background:var(--amber)"></div><div class="sc-lbl">Reinstate Pending</div><div class="sc-val">{{ $stats['reinstate'] }}</div><div class="sc-sub">Sent back by HQ to revise</div></div>
  <div class="sc" onclick="filterTab('draft')" style="cursor:pointer"><div class="sc-bar" style="background:var(--blue)"></div><div class="sc-lbl">Draft</div><div class="sc-val">{{ $stats['draft'] }}</div><div class="sc-sub">Not yet submitted</div></div>
</div>

@if(session('success'))
<div style="padding:12px 16px;background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;font-size:12px;font-weight:600;margin-bottom:16px">{{ session('success') }}</div>
@endif

<div class="panel">
  <div class="ph">
    <div class="pt">All <em>Events</em></div>
    <div class="ph-actions">
      <select class="fsel" onchange="filterByStatus(this.value)">
        <option value="all">All Status</option>
        <option value="approved">Approved</option>
        <option value="published">Published</option>
        <option value="submitted">Under Review</option>
        <option value="reinstate">Reinstate Pending</option>
        <option value="draft">Draft</option>
        <option value="rejected">Rejected</option>
      </select>
    </div>
  </div>
  <div style="padding:14px 20px 0">
    <div class="tabs">
      <button class="tab active" id="tab-all"       onclick="filterTab('all')">All ({{ $stats['total'] }})</button>
      <button class="tab"        id="tab-approved"  onclick="filterTab('approved')">Approved ({{ $stats['approved'] }})</button>
      <button class="tab"        id="tab-published" onclick="filterTab('published')">Published ({{ $stats['published'] }})</button>
      <button class="tab"        id="tab-reinstate" onclick="filterTab('reinstate')">Reinstate Pending ({{ $stats['reinstate'] }})</button>
      <button class="tab"        id="tab-draft"     onclick="filterTab('draft')">Draft ({{ $stats['draft'] }})</button>
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
  <div class="ev-list" id="ev-list">
    @forelse($events as $ev)
    <div class="ev-row" id="row-{{ $ev->id }}" data-status="{{ $ev->status }}" data-published="{{ $ev->track_published ? 1 : 0 }}" data-revision="{{ $ev->revision_note ? 1 : 0 }}" data-cat="{{ $ev->category }}" data-name="{{ strtolower($ev->title) }}" data-date="{{ $ev->start_date?->format('Y-m-d') }}">
      <div class="ev-summary" onclick="toggleRow({{ $ev->id }})">
        <div class="ev-info-wrap">
          <div class="ev-name">{{ $ev->title }}</div>
          <div class="ev-meta">
            <div class="ev-meta-item">
              <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              {{ $ev->date_display }}
            </div>
            <div class="ev-meta-item">
              <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              {{ $ev->venue ?? '—' }}
            </div>
          </div>
        </div>
        <div class="ev-right">
          @php
            $catMap=['Hackathon'=>'b-hackathon','Career Fair'=>'b-career','Volunteer'=>'b-volunteer','Workshop'=>'b-workshop','Webinar'=>'b-webinar','SDG Event'=>'b-sdg','Competition'=>'b-competition','Talk'=>'b-talk'];
            $pillMap=['open'=>'pill-open','upcoming'=>'pill-upcoming','draft'=>'pill-draft','submitted'=>'pill-review','approved'=>'pill-approved','rejected'=>'pill-closed','past'=>'pill-closed'];
            // A draft sent back by HQ carries a revision note — surface that instead of a bare "Draft".
            $isReinstate = $ev->status === 'draft' && $ev->revision_note;
            $statusLabel = match(true) {
                (bool) $ev->track_published => 'Published',
                $ev->status === 'approved'  => 'Approved',
                $isReinstate                => 'Reinstate Pending',
                default                     => ucfirst($ev->status),
            };
            $statusPill = match(true) {
                (bool) $ev->track_published => 'pill-approved',
                $isReinstate                => 'pill-review',
                default                     => ($pillMap[$ev->status] ?? 'pill-draft'),
            };
          @endphp
          <span class="ev-cat {{ $catMap[$ev->category] ?? 'b-workshop' }}">{{ $ev->category }}</span>
          <span class="pill {{ $statusPill }}">{{ $statusLabel }}</span>
          @if($ev->track_published)
            <span style="font-size:10px;font-weight:700;color:var(--green);white-space:nowrap">● Live</span>
          @elseif($ev->status === 'approved')
            <span style="font-size:10px;font-weight:700;color:var(--green);white-space:nowrap">✓ Approved</span>
          @elseif($ev->status === 'submitted')
            <span style="font-size:10px;font-weight:700;color:var(--amber);white-space:nowrap">⏳ Review</span>
          @elseif($isReinstate)
            <span style="font-size:10px;font-weight:700;color:var(--amber);white-space:nowrap">↩ Revise</span>
          @else
            <span style="font-size:10px;font-weight:700;color:#aaa;white-space:nowrap">○ Draft</span>
          @endif
          <div class="abtns" onclick="event.stopPropagation()">
            <button class="abtn" title="Edit" onclick="openEditPanel({{ $ev->id }})">
              <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </button>
            <button class="abtn del" title="Delete" onclick="confirmDelete({{ $ev->id }}, '{{ addslashes($ev->title) }}')">
              <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
            </button>
          </div>
          <svg class="ev-chevron" id="chev-{{ $ev->id }}" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
        </div>
      </div>
      <div class="ev-detail" id="detail-{{ $ev->id }}">
        <div class="ev-detail-inner">
          {{-- Poster --}}
          <div class="poster-col">
            <div class="sec-lbl">Poster</div>
            @if($ev->poster_url)
            <div class="poster-box has-poster" id="pbox-{{ $ev->id }}">
              <img id="pimg-{{ $ev->id }}" src="{{ $ev->poster_url }}" style="display:block"/>
            </div>
            @if($ev->canBeEdited())
            <form method="POST" action="{{ route('student.events.poster.remove', $ev) }}" style="margin-top:4px">
              @csrf @method('DELETE')
              <button type="submit" class="poster-clear-btn">× Remove</button>
            </form>
            @endif
            @elseif($ev->canBeEdited())
            <form method="POST" action="{{ route('student.events.poster.upload', $ev) }}" enctype="multipart/form-data">
              @csrf
              <div class="poster-box" id="pbox-{{ $ev->id }}">
                <input type="file" name="poster" accept="image/*" onchange="this.form.submit()"/>
                <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:5px;height:100%;padding:12px;text-align:center;pointer-events:none">
                  <svg viewBox="0 0 24 24" style="width:24px;height:24px;stroke:#d1d5db;fill:none;stroke-width:1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                  <span style="font-size:9px;color:var(--grey);line-height:1.4">Click to upload poster</span>
                </div>
              </div>
            </form>
            @else
            <div class="poster-box" id="pbox-{{ $ev->id }}" style="cursor:default">
              <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:5px;height:100%;padding:12px;text-align:center">
                <svg viewBox="0 0 24 24" style="width:24px;height:24px;stroke:#d1d5db;fill:none;stroke-width:1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                <span style="font-size:9px;color:var(--grey);line-height:1.4">No poster — locked</span>
              </div>
            </div>
            @endif
          </div>
          {{-- Description + tracking --}}
          <div class="desc-col">
            <div class="sec-lbl">Description</div>
            <div class="desc-text">{{ $ev->description ?: 'No description yet.' }}</div>
            <div style="margin-top:14px">
              <div class="sec-lbl">Submission &amp; Approval Progress</div>
              @php
                $trackActiveAssigned = false;
                // Standardised 4-stage track, identical to the admin pipeline.
                // "Approved" is HQ sign-off; "Published" is the chapter's own go-live toggle.
                $trackSteps = [
                    ['Submitted',  (bool) $ev->track_submitted],
                    ['Doc Review', (bool) $ev->track_doc_approved],
                    ['Approved',   $ev->status === 'approved' || (bool) $ev->track_published],
                    ['Published',  (bool) $ev->track_published],
                ];
              @endphp
              <div class="status-track">
                @foreach($trackSteps as [$label, $done])
                @php
                  // Only the first incomplete step is "active"; none when rejected.
                  $active = false;
                  if (!$done && !$trackActiveAssigned && !$ev->track_rejected) {
                      $active = true;
                      $trackActiveAssigned = true;
                  }
                @endphp
                <div class="st-step {{ $done?'s-done':($active?'s-active':'s-pending') }}">
                  <div class="st-dot"><svg viewBox="0 0 24 24" fill="none" stroke="{{ $done?'#fff':'currentColor' }}" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div>
                  <div class="st-lbl">{{ $label }}</div>
                </div>
                @endforeach
              </div>
              @if($ev->track_rejected)
              <div style="margin-top:8px;padding:10px 14px;background:#fee2e2;border:1px solid rgba(192,57,43,.2);font-size:12px;color:var(--red)">
                <strong>Rejected by HQ.</strong> {{ $ev->rejection_reason ? 'Reason: '.$ev->rejection_reason : 'This event was not approved.' }}
              </div>
              @elseif($ev->status === 'draft' && $ev->revision_note)
              <div style="margin-top:8px;padding:10px 14px;background:var(--amber-l);border:1px solid rgba(217,119,6,.25);font-size:12px;color:var(--amber)">
                <strong>Revision requested by HQ.</strong> {{ $ev->revision_note }} — update and resubmit.
              </div>
              @endif
            </div>
          </div>
          {{-- Info + actions --}}
          <div class="info-col">
            <div class="sec-lbl">Event Info</div>
            <div class="ic-grid">
              <div class="ic ic-full"><div class="ic-lbl">Category</div><div class="ic-val"><span class="ev-cat {{ $catMap[$ev->category] ?? 'b-workshop' }}">{{ $ev->category }}</span></div></div>
              <div class="ic"><div class="ic-lbl">Date</div><div class="ic-val">{{ $ev->date_display }}</div></div>
              <div class="ic"><div class="ic-lbl">Status</div><div class="ic-val"><span class="pill {{ $statusPill }}">{{ $statusLabel }}</span></div></div>
              <div class="ic ic-full"><div class="ic-lbl">Venue</div><div class="ic-val">{{ $ev->venue ?? '—' }}</div></div>
            </div>
            @if($ev->tags)
            <div class="tag-wrap" style="margin-bottom:10px">
              @foreach($ev->tags as $tag)<span class="tag-pill">{{ $tag }}</span>@endforeach
            </div>
            @endif
            <div class="action-row">
              @if($ev->canBeEdited())
              <button class="btn-edit-sm" onclick="openEditPanel({{ $ev->id }})">Edit</button>
              @endif
              @if($ev->canBeSubmitted())
              <form method="POST" action="{{ route('student.events.submit', $ev) }}" style="flex:1">
                @csrf
                <button type="submit" class="btn-edit-sm" style="width:100%;background:var(--green)">Submit</button>
              </form>
              @endif
              @if($ev->canBeDeleted())
              <button class="btn-del-sm" onclick="confirmDelete({{ $ev->id }}, '{{ addslashes($ev->title) }}')">Delete</button>
              @endif
              @if($ev->status === 'approved')
              {{-- HQ-approved: the chapter decides whether to go live on the public site. --}}
              <form method="POST" action="{{ route('student.events.publish', $ev) }}" style="flex:1">
                @csrf
                <button type="submit" class="btn-edit-sm" style="width:100%;background:{{ $ev->track_published ? '#6b7280' : 'var(--navy)' }}">
                  {{ $ev->track_published ? 'Unpublish from Public' : 'Publish to Public' }}
                </button>
              </form>
              @elseif(!$ev->canBeEdited())
              <span style="flex:1;font-size:11px;color:var(--grey);padding:7px;text-align:center">{{ ['rejected' => 'Rejected — locked', 'submitted' => 'Under review — locked'][$ev->status] ?? 'Locked' }}</span>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    @empty
    <div style="padding:60px;text-align:center;font-size:13px;color:var(--grey)">
      No events yet. <button class="btn-primary" style="margin-left:10px" onclick="openCreateModal()">Create your first event</button>
    </div>
    @endforelse
  </div>
  {{ $events->links() }}
</div>

{{-- DIM + SLIDE PANEL --}}
<div class="dim-overlay" id="dimOverlay" onclick="closePanel()"></div>
<div class="slide-panel" id="slidePanel">
  <div class="sp-head">
    <div><div class="sp-mode-badge" id="spModeBadge">Edit</div><h3 id="spTitle">Event Details</h3></div>
    <button class="sp-close" onclick="closePanel()">×</button>
  </div>
  <div class="sp-body" id="spBody"></div>
  <div class="sp-foot" id="spFoot"></div>
</div>

{{-- CREATE EVENT MODAL --}}
<div class="modal-overlay" id="createModal" onclick="if(event.target===this)closeCreateModal()">
  <div class="modal" style="width:680px">
    <div class="modal-head">
      <h3>Create New Event</h3>
      <button class="modal-close" onclick="closeCreateModal()">×</button>
    </div>
    <form method="POST" action="{{ route('student.events.store') }}" enctype="multipart/form-data" id="createForm">
      @csrf
      <div class="modal-body">
        <div style="display:grid;grid-template-columns:1fr 130px;gap:18px;align-items:start">
          <div>
            <div class="form-row"><label class="form-lbl">Event Title *</label><input class="form-inp" name="title" type="text" placeholder="e.g. Engineering Innovation Hackathon 2025" required/></div>
            <div class="form-row"><label class="form-lbl">Category *</label>
              <select class="form-sel" name="category" required>
                @foreach(\App\Models\StudentEvent::CATEGORIES as $cat)
                <option>{{ $cat }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-2">
              <div class="form-row"><label class="form-lbl">Start Date *</label><input class="form-inp" name="start_date" type="date" required/></div>
              <div class="form-row"><label class="form-lbl">End Date</label><input class="form-inp" name="end_date" type="date"/></div>
            </div>
            <div class="form-row"><label class="form-lbl">Venue *</label><input class="form-inp" name="venue" type="text" placeholder="e.g. UTM Skudai, Johor" required/></div>
          </div>
          <div>
            <label class="form-lbl">Event Poster</label>
            <div style="border:2px dashed var(--light);background:var(--off);position:relative;aspect-ratio:3/4;overflow:hidden;cursor:pointer;transition:border-color .2s"
                 onclick="document.getElementById('cPosterInput').click()"
                 ondragover="event.preventDefault()" ondrop="handleCreatePosterDrop(event)">
              <input type="file" id="cPosterInput" name="poster" accept="image/*" onchange="handleCreatePoster(this)" style="display:none"/>
              <div id="cPosterPh" style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;height:100%;padding:14px;text-align:center;pointer-events:none">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                <span style="font-size:9px;color:var(--grey);line-height:1.4">Click or drag<br>PNG · JPG</span>
              </div>
              <img id="cPosterImg" src="" style="display:none;position:absolute;inset:0;width:100%;height:100%;object-fit:cover"/>
            </div>
            <div id="cPosterClear" style="display:none;margin-top:4px">
              <button type="button" style="width:100%;padding:5px;background:none;border:1px solid var(--light);font-size:9px;font-weight:700;color:var(--red);cursor:pointer;font-family:'DM Sans',sans-serif" onclick="clearCreatePoster()">× Remove</button>
            </div>
          </div>
        </div>
        <div class="form-row"><label class="form-lbl">Description</label><textarea class="form-ta" name="description" placeholder="Describe the event for attendees…" style="min-height:70px"></textarea></div>
        <div class="form-row">
          <label class="form-lbl">PPW Document</label>
          <div class="ppw-drop" id="cPpwDrop" onclick="document.getElementById('cPpwInput').click()" ondragover="event.preventDefault()" ondrop="handleCreatePpwDrop(event)">
            <input type="file" id="cPpwInput" name="ppw" accept=".pdf,.doc,.docx" onchange="handleCreatePpw(this)" style="display:none"/>
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            <span id="cPpwLabel">Click to upload PPW · PDF, DOC, DOCX (max 10 MB)</span>
          </div>
        </div>
        <div class="form-row">
          <label class="form-lbl">Tags</label>
          <div class="tag-input" id="cTagBox" onclick="document.getElementById('cTagEntry').focus()">
            <span id="cTagChips"></span>
            <input type="text" id="cTagEntry" list="cTagSuggest" placeholder="Type a tag, press Enter…" onkeydown="handleTagKey(event)" onblur="commitTag()" autocomplete="off"/>
          </div>
          <input type="hidden" name="tags" id="cTagHidden"/>
          <datalist id="cTagSuggest">
            <option>Engineering</option><option>Workshop</option><option>Hackathon</option><option>Career</option><option>Networking</option><option>Technical</option><option>Community</option><option>SDG</option><option>Volunteer</option><option>Competition</option><option>Seminar</option><option>Industry</option>
          </datalist>
          <div style="font-size:10px;color:var(--grey);margin-top:5px">Press Enter or comma to add each tag. Tags power event filtering &amp; tracing.</div>
        </div>
        <label style="display:flex;align-items:center;gap:8px;font-size:12px;color:var(--navy);cursor:pointer;margin-top:8px">
          <input type="checkbox" name="is_sdg" value="1"/> SDG-aligned event
        </label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-ghost" onclick="closeCreateModal()">Cancel</button>
        <button type="submit" name="action" value="draft" class="btn-secondary">Save as Draft</button>
        <button type="submit" name="action" value="submit" class="btn-primary">Submit for HQ Review</button>
      </div>
    </form>
  </div>
</div>

{{-- DELETE CONFIRM MODAL --}}
<div class="modal-overlay" id="deleteModal" onclick="if(event.target===this)closeDeleteModal()">
  <div class="modal" style="width:440px">
    <div class="modal-head"><h3>Confirm Deletion</h3><button class="modal-close" onclick="closeDeleteModal()">×</button></div>
    <div class="modal-body" style="text-align:center;padding:32px">
      <div style="width:52px;height:52px;border-radius:50%;background:#fee2e2;border:2px solid rgba(192,57,43,.15);display:flex;align-items:center;justify-content:center;margin:0 auto 14px">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
      </div>
      <div style="font-family:'Playfair Display',serif;font-size:17px;font-weight:700;color:var(--navy);margin-bottom:8px" id="deleteEventName">Delete event?</div>
      <div style="font-size:12px;color:var(--grey);line-height:1.7">This action cannot be undone. All event data will be permanently removed.</div>
    </div>
    <form method="POST" id="deleteForm">
      @csrf @method('DELETE')
      <div class="modal-footer">
        <button type="button" class="btn-ghost" onclick="closeDeleteModal()">Cancel</button>
        <button type="submit" class="btn-danger">Delete Event</button>
      </div>
    </form>
  </div>
</div>

{{-- EDIT PANEL DATA --}}
@php
$eventsJson = $events->map(fn($e) => [
  'id'                 => $e->id,
  'title'              => $e->title,
  'category'           => $e->category,
  'venue'              => $e->venue,
  'start_date'         => $e->start_date?->format('Y-m-d'),
  'end_date'           => $e->end_date?->format('Y-m-d'),
  'status'             => $e->status,
  'description'        => $e->description,
  'tags'               => $e->tags ?? [],
  'ppw_filename'       => $e->ppw_filename,
  'is_sdg'             => $e->is_sdg,
]);
@endphp
<script id="eventsData" type="application/json">@json($eventsJson)</script>
@endsection

@section('scripts')
<script>
const CSRF    = document.querySelector('meta[name="csrf-token"]').content;
const evData  = JSON.parse(document.getElementById('eventsData').textContent);
const catMap  = {Hackathon:'b-hackathon','Career Fair':'b-career',Volunteer:'b-volunteer',Workshop:'b-workshop',Webinar:'b-webinar','SDG Event':'b-sdg',Competition:'b-competition',Talk:'b-talk'};
const pillMap = {open:'pill-open',upcoming:'pill-upcoming',draft:'pill-draft',submitted:'pill-review',approved:'pill-approved',rejected:'pill-closed',past:'pill-closed'};
const categories = @json(\App\Models\StudentEvent::CATEGORIES);

let filterStatus='all', searchQ='', sortMode='date', expandedId=null;

function toggleRow(id){
  const det=document.getElementById('detail-'+id);
  const chev=document.getElementById('chev-'+id);
  const sum=det?.previousElementSibling;
  if(!det)return;
  if(expandedId===id){
    det.classList.remove('open');chev?.classList.remove('open');sum?.classList.remove('expanded');expandedId=null;
  } else {
    if(expandedId){
      document.getElementById('detail-'+expandedId)?.classList.remove('open');
      document.getElementById('chev-'+expandedId)?.classList.remove('open');
      document.getElementById('detail-'+expandedId)?.previousElementSibling?.classList.remove('expanded');
    }
    det.classList.add('open');chev?.classList.add('open');sum?.classList.add('expanded');expandedId=id;
  }
}

function filterTab(s){
  filterStatus=s;
  ['all','approved','published','reinstate','draft'].forEach(x=>document.getElementById('tab-'+x)?.classList.remove('active'));
  document.getElementById('tab-'+s)?.classList.add('active');
  applyFilters();
}
function filterByStatus(v){filterStatus=v;applyFilters();}
function searchEvents(q){searchQ=q.toLowerCase();applyFilters();}
function sortEvents(v){sortMode=v;applyFilters();}

function applyFilters(){
  document.querySelectorAll('.ev-row').forEach(row=>{
    const st=row.dataset.status;
    const nm=row.dataset.name;
    const pub=row.dataset.published==='1';
    const rev=row.dataset.revision==='1';
    let matchSt;
    switch(filterStatus){
      case 'all':       matchSt = true; break;
      case 'approved':  matchSt = (st==='approved'); break;   // includes published (still approved)
      case 'published': matchSt = pub; break;
      case 'reinstate': matchSt = (st==='draft' && rev); break;
      case 'draft':     matchSt = (st==='draft' && !rev); break;
      default:          matchSt = (st===filterStatus); break; // submitted, rejected, …
    }
    const matchQ = !searchQ || nm.includes(searchQ);
    row.style.display=(matchSt&&matchQ)?'':'none';
  });
}

// ── Create modal ────────────────────────────────────────────────────────────
function openCreateModal(){resetCreateExtras();document.getElementById('createModal').classList.add('open');}
function closeCreateModal(){document.getElementById('createModal').classList.remove('open');}

// ── PPW document upload (create) ──
function handleCreatePpw(input){
  const f=input.files&&input.files[0];
  document.getElementById('cPpwLabel').textContent=f?f.name:'Click to upload PPW · PDF, DOC, DOCX (max 10 MB)';
  document.getElementById('cPpwDrop').classList.toggle('has-file',!!f);
}
function handleCreatePpwDrop(ev){ev.preventDefault();const f=ev.dataTransfer.files[0];if(!f)return;const dt=new DataTransfer();dt.items.add(f);document.getElementById('cPpwInput').files=dt.files;handleCreatePpw(document.getElementById('cPpwInput'));}

// ── Tag chips (create) ──
let cTags=[];
function renderTags(){
  document.getElementById('cTagChips').innerHTML=cTags.map((t,i)=>`<span class="tag-chip">${t}<button type="button" onclick="removeTag(${i})">×</button></span>`).join('');
  document.getElementById('cTagHidden').value=cTags.join(',');
}
function addTag(v){
  v=(v||'').replace(/,/g,'').trim();
  if(!v)return;
  if(!cTags.some(t=>t.toLowerCase()===v.toLowerCase()))cTags.push(v);
  renderTags();
}
function removeTag(i){cTags.splice(i,1);renderTags();}
function commitTag(){const e=document.getElementById('cTagEntry');if(e.value.trim()){addTag(e.value);e.value='';}}
function handleTagKey(ev){
  if(ev.key==='Enter'||ev.key===','){ev.preventDefault();commitTag();}
  else if(ev.key==='Backspace'&&!ev.target.value&&cTags.length){removeTag(cTags.length-1);}
}
function resetCreateExtras(){
  cTags=[];renderTags();
  document.getElementById('cTagEntry').value='';
  document.getElementById('cPpwInput').value='';
  handleCreatePpw(document.getElementById('cPpwInput'));
  clearCreatePoster();
}
// Fold any half-typed tag into the chip set before the form posts.
document.getElementById('createForm').addEventListener('submit',commitTag);

function handleCreatePoster(input){
  const file=input.files[0];if(!file)return;
  const r=new FileReader();
  r.onload=ev=>{document.getElementById('cPosterImg').src=ev.target.result;document.getElementById('cPosterImg').style.display='block';document.getElementById('cPosterPh').style.display='none';document.getElementById('cPosterClear').style.display='block';};
  r.readAsDataURL(file);
}
function handleCreatePosterDrop(ev){ev.preventDefault();const f=ev.dataTransfer.files[0];if(!f||!f.type.startsWith('image/'))return;const dt=new DataTransfer();dt.items.add(f);document.getElementById('cPosterInput').files=dt.files;handleCreatePoster(document.getElementById('cPosterInput'));}
function clearCreatePoster(){document.getElementById('cPosterInput').value='';document.getElementById('cPosterImg').src='';document.getElementById('cPosterImg').style.display='none';document.getElementById('cPosterPh').style.display='flex';document.getElementById('cPosterClear').style.display='none';}

// ── Delete modal ─────────────────────────────────────────────────────────────
function confirmDelete(id, name){
  document.getElementById('deleteEventName').textContent='Delete "'+name+'"?';
  document.getElementById('deleteForm').action='/dashboard/student/events/'+id;
  document.getElementById('deleteModal').classList.add('open');
}
function closeDeleteModal(){document.getElementById('deleteModal').classList.remove('open');}

// ── Edit slide panel ─────────────────────────────────────────────────────────
function openEditPanel(id){
  const ev=evData.find(e=>e.id===id);
  if(!ev)return;
  document.getElementById('spModeBadge').textContent='Edit Event';
  document.getElementById('spTitle').textContent=ev.title;
  const catOpts=categories.map(c=>`<option${ev.category===c?' selected':''}>${c}</option>`).join('');
  document.getElementById('spBody').innerHTML=`
    <form method="POST" action="/dashboard/student/events/${id}" id="editForm" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="${CSRF}">
      <input type="hidden" name="_method" value="PUT">
      <div class="pf-row"><label class="pf-lbl">Event Title *</label><input class="pf-input" name="title" value="${ev.title||''}" required/></div>
      <div class="pf-row"><label class="pf-lbl">Category</label><select class="pf-select" name="category">${catOpts}</select></div>
      <div class="pf-grid2">
        <div class="pf-row"><label class="pf-lbl">Start Date *</label><input class="pf-input" name="start_date" type="date" value="${ev.start_date||''}" required/></div>
        <div class="pf-row"><label class="pf-lbl">End Date</label><input class="pf-input" name="end_date" type="date" value="${ev.end_date||''}"/></div>
      </div>
      <div class="pf-row"><label class="pf-lbl">Venue *</label><input class="pf-input" name="venue" value="${ev.venue||''}" required/></div>
      <div class="pf-row"><label class="pf-lbl">Description</label><textarea class="pf-textarea" name="description">${ev.description||''}</textarea></div>
      <div class="pf-row"><label class="pf-lbl">PPW Document</label>
        <div class="ppw-drop" id="ePpwDrop" onclick="document.getElementById('ePpwInput').click()" ondragover="event.preventDefault()" ondrop="handleEditPpwDrop(event)">
          <input type="file" id="ePpwInput" name="ppw" accept=".pdf,.doc,.docx" onchange="handleEditPpw(this)" style="display:none"/>
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          <span id="ePpwLabel">${ev.ppw_filename?('Current: '+ev.ppw_filename+' — click to replace'):'Click to upload PPW · PDF, DOC, DOCX'}</span>
        </div>
      </div>
      <div class="pf-row"><label class="pf-lbl">Tags</label>
        <div class="tag-input" id="eTagBox" onclick="document.getElementById('eTagEntry').focus()">
          <span id="eTagChips"></span>
          <input type="text" id="eTagEntry" list="cTagSuggest" placeholder="Type a tag, press Enter…" onkeydown="handleETagKey(event)" onblur="commitETag()" autocomplete="off"/>
        </div>
        <input type="hidden" name="tags" id="eTagHidden"/>
      </div>
      <label style="display:flex;align-items:center;gap:8px;font-size:12px;color:var(--navy);cursor:pointer;margin-top:8px">
        <input type="checkbox" name="is_sdg" value="1"${ev.is_sdg?' checked':''}/> SDG-aligned event
      </label>
    </form>`;
  eTags=(ev.tags||[]).slice();
  renderETags();
  document.getElementById('spFoot').innerHTML=`<button class="btn-ghost" onclick="closePanel()">Cancel</button><button class="btn-secondary" onclick="submitEdit('draft')">Save as Draft</button><button class="btn-prim" onclick="submitEdit('submit')">Save &amp; Submit</button>`;
  document.getElementById('slidePanel').classList.add('open');
  document.getElementById('dimOverlay').classList.add('on');
}
function submitEdit(action){
  commitETag();
  const f=document.getElementById('editForm');
  let a=f.querySelector('input[name="action"]');
  if(!a){a=document.createElement('input');a.type='hidden';a.name='action';f.appendChild(a);}
  a.value=action;
  f.submit();
}

// ── Edit-panel tag chips + PPW ──
let eTags=[];
function renderETags(){
  const c=document.getElementById('eTagChips');if(!c)return;
  c.innerHTML=eTags.map((t,i)=>`<span class="tag-chip">${t}<button type="button" onclick="removeETag(${i})">×</button></span>`).join('');
  document.getElementById('eTagHidden').value=eTags.join(',');
}
function addETag(v){v=(v||'').replace(/,/g,'').trim();if(!v)return;if(!eTags.some(t=>t.toLowerCase()===v.toLowerCase()))eTags.push(v);renderETags();}
function removeETag(i){eTags.splice(i,1);renderETags();}
function commitETag(){const e=document.getElementById('eTagEntry');if(e&&e.value.trim()){addETag(e.value);e.value='';}}
function handleETagKey(ev){if(ev.key==='Enter'||ev.key===','){ev.preventDefault();commitETag();}else if(ev.key==='Backspace'&&!ev.target.value&&eTags.length){removeETag(eTags.length-1);}}
function handleEditPpw(input){const f=input.files&&input.files[0];const l=document.getElementById('ePpwLabel');if(l)l.textContent=f?f.name:'Click to upload PPW · PDF, DOC, DOCX';document.getElementById('ePpwDrop').classList.toggle('has-file',!!f);}
function handleEditPpwDrop(ev){ev.preventDefault();const f=ev.dataTransfer.files[0];if(!f)return;const dt=new DataTransfer();dt.items.add(f);document.getElementById('ePpwInput').files=dt.files;handleEditPpw(document.getElementById('ePpwInput'));}
function closePanel(){document.getElementById('slidePanel').classList.remove('open');document.getElementById('dimOverlay').classList.remove('on');}
document.addEventListener('keydown',e=>{if(e.key==='Escape'){closePanel();closeCreateModal();closeDeleteModal();}});
</script>
@endsection
