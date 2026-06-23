@extends('student-section.layouts.app')
@section('title', 'Budget Requests')

@section('styles')
<style>
:root {
  --green-bg:#dcfce7;--green-border:#bbf7d0;
  --amber-border:rgba(217,119,6,.25);
  --red-l:#fdecea;
}

/* ── BUDGET TABS ── */
.tabs{display:flex;border-bottom:2px solid var(--light);margin-bottom:20px}
.tab{padding:9px 16px;background:none;border:none;border-bottom:2px solid transparent;margin-bottom:-2px;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--grey);cursor:pointer;transition:all .2s;white-space:nowrap}
.tab:hover{color:var(--navy)}
.tab.active{color:var(--navy);border-bottom-color:var(--gold)}

/* ── REQUEST CARDS ── */
.req-list{display:flex;flex-direction:column;gap:12px}
.req-card{background:#fff;border:1px solid var(--light);overflow:hidden}
.req-card-head{display:flex;align-items:center;gap:14px;padding:14px 18px;cursor:pointer;user-select:none;transition:background .15s}
.req-card-head:hover{background:#fafaf8}
.rch-left{flex:1;min-width:0}
.rch-title{font-size:13px;font-weight:700;color:var(--navy);margin-bottom:3px}
.rch-meta{display:flex;gap:12px;flex-wrap:wrap;align-items:center}
.rch-meta-item{display:flex;align-items:center;gap:4px;font-size:10px;color:var(--grey)}
.rch-meta-item svg{width:10px;height:10px;stroke:var(--grey);fill:none;stroke-width:2}
.rch-right{display:flex;align-items:center;gap:10px;flex-shrink:0}
.rch-amount{font-family:'Playfair Display',serif;font-size:17px;font-weight:900;color:var(--navy)}
.rch-chevron{width:14px;height:14px;stroke:var(--grey);fill:none;stroke-width:2;transition:transform .2s}
.rch-chevron.open{transform:rotate(180deg)}
.req-body{display:none;border-top:1px solid var(--light);padding:16px 18px}
.req-body.open{display:block}

/* ── PIPELINE ── */
.pipeline{display:flex;align-items:flex-start;gap:0;margin-bottom:16px}
.ps{display:flex;flex-direction:column;align-items:center;flex:1;position:relative}
.ps::after{content:'';position:absolute;top:14px;left:50%;width:100%;height:2px;background:var(--light);z-index:0}
.ps:last-child::after{display:none}
.ps-dot{width:28px;height:28px;border-radius:50%;border:2px solid var(--light);background:#fff;display:flex;align-items:center;justify-content:center;z-index:1;position:relative}
.ps-dot svg{width:12px;height:12px;stroke:var(--grey);fill:none;stroke-width:2.5}
.ps-dot.done{background:var(--green-a);border-color:var(--green-a)}
.ps-dot.done svg{stroke:#fff}
.ps-dot.active{background:var(--gold);border-color:var(--gold)}
.ps-dot.active svg{stroke:var(--navy-dark)}
.ps-dot.rejected{background:var(--red);border-color:var(--red)}
.ps-dot.rejected svg{stroke:#fff}
.ps-lbl{font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--grey);margin-top:6px;text-align:center;max-width:70px;line-height:1.3}
.ps-lbl.done{color:var(--green-a)}
.ps-lbl.active{color:var(--amber)}
.ps-lbl.rejected{color:var(--red)}

/* ── BUDGET LINE TABLE ── */
.blt{width:100%;border-collapse:collapse;font-size:11px;margin-top:8px}
.blt td{padding:5px 0;border-bottom:1px solid var(--light);color:#444}
.blt tr:last-child td{border-bottom:none;font-weight:700;color:var(--navy)}
.blt td:last-child{text-align:right;color:var(--navy-dark)}

/* ── FORM SECTIONS ── */
.form-section{background:#fff;border:1px solid var(--light);padding:0;margin-bottom:16px}
.fs-head{padding:14px 18px;border-bottom:1px solid var(--light);display:flex;align-items:center;gap:10px}
.fs-icon{width:30px;height:30px;background:var(--navy-dark);display:flex;align-items:center;justify-content:center;flex-shrink:0}
.fs-icon svg{width:14px;height:14px;stroke:var(--gold);fill:none;stroke-width:2}
.fs-title{font-size:13px;font-weight:700;color:var(--navy)}
.fs-body{padding:16px 18px}
.field{margin-bottom:14px}
.field label{display:block;font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:5px}
.field input,.field select,.field textarea{width:100%;border:1px solid var(--light);background:var(--off);padding:9px 12px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);outline:none;transition:border-color .2s}
.field input:focus,.field select:focus,.field textarea:focus{border-color:var(--navy);background:#fff}
.field textarea{min-height:70px;resize:vertical}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:12px}

/* ── LINE ITEMS ── */
.line-items{display:flex;flex-direction:column;gap:6px;margin-bottom:8px}
.line-item{display:grid;grid-template-columns:1fr 60px 96px 28px;gap:6px;align-items:center}
.line-item input{border:1px solid var(--light);background:var(--off);padding:7px 10px;font-family:'DM Sans',sans-serif;font-size:11px;color:var(--navy);outline:none}
.line-item input:focus{border-color:var(--navy);background:#fff}
.li-del{width:28px;height:28px;background:none;border:1px solid var(--light);color:var(--red);cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.li-del svg{width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2}
.li-del:hover{background:var(--red-l);border-color:var(--red)}
.budget-total-display{display:flex;justify-content:space-between;padding:10px 0;border-top:2px solid var(--light);font-weight:700;font-size:13px;color:var(--navy);margin-top:4px}

/* ── UPLOAD ZONE ── */
.upload-zone{border:2px dashed var(--light);padding:22px;text-align:center;cursor:pointer;transition:border-color .2s;background:var(--off)}
.upload-zone:hover{border-color:var(--navy)}
.upload-zone svg{width:28px;height:28px;stroke:var(--grey);fill:none;stroke-width:1.5;margin:0 auto 8px;display:block}
.upload-zone-text{font-size:12px;color:var(--grey)}
.upload-zone-text strong{color:var(--navy)}
.upload-zone input[type=file]{display:none}
.uploaded-file{display:flex;align-items:center;gap:10px;background:var(--green-bg);border:1px solid var(--green-border);padding:10px 12px;margin-top:8px}
.uf-icon svg{width:14px;height:14px;stroke:var(--green);fill:none;stroke-width:2}
.uf-name{font-size:12px;font-weight:600;color:var(--green-dark);flex:1}
.uf-remove{background:none;border:none;color:var(--red);cursor:pointer;font-size:18px;line-height:1;padding:2px}

/* ── BADGES ── */
.badge{display:inline-flex;align-items:center;font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;padding:3px 8px}
.b-pending{background:var(--amber-l);color:var(--amber);border:1px solid var(--amber-border)}
.b-approved{background:var(--green-bg);color:#166534;border:1px solid var(--green-border)}
.b-rejected{background:var(--red-l);color:var(--red);border:1px solid rgba(192,57,43,.15)}
.b-review{background:var(--blue-l);color:var(--blue);border:1px solid rgba(29,78,216,.2)}

/* ── EXTRA BUTTON ── */
.btn-ghost-sm{display:inline-flex;align-items:center;gap:5px;background:none;border:1px solid var(--light);color:var(--grey);padding:5px 10px;font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .2s}
.btn-ghost-sm:hover{border-color:var(--navy);color:var(--navy)}
</style>
@endsection

@section('content')
  <div class="sec-header">
    <div>
      <div class="sh-eyebrow">Financial Management</div>
      <div class="sh-title">Budget <em>Requests</em></div>
      <div class="sh-sub">Submit event-based budget requests to YES for approval. Track the status of existing requests below.</div>
    </div>
    <button class="btn-primary" onclick="showTab('new')">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      New Request
    </button>
  </div>

  <div class="stat-row">
    <div class="sc"><div class="sc-bar" style="background:var(--amber)"></div><div class="sc-lbl">Pending Review</div><div class="sc-val">{{ $stats['pending'] }}</div><div class="sc-sub">Awaiting YES response</div></div>
    <div class="sc"><div class="sc-bar" style="background:var(--green-a)"></div><div class="sc-lbl">Approved</div><div class="sc-val">{{ $stats['approved'] }}</div><div class="sc-sub">All time</div></div>
    <div class="sc"><div class="sc-bar" style="background:var(--red)"></div><div class="sc-lbl">Reinstate</div><div class="sc-val">{{ $stats['reinstate'] }}</div><div class="sc-sub">Rejected — reinstate to revise</div></div>
    <div class="sc"><div class="sc-bar" style="background:var(--navy)"></div><div class="sc-lbl">Total Approved (RM)</div><div class="sc-val">{{ $stats['total_approved'] >= 1000 ? number_format($stats['total_approved'] / 1000, 1) . 'k' : number_format($stats['total_approved'], 0) }}</div><div class="sc-sub">RM {{ number_format($stats['unused'], 2) }} unused (approved − reimbursed)</div></div>
  </div>

  <div class="tabs">
    <button class="tab active" id="tab-history" onclick="showTab('history')">Request History</button>
    <button class="tab" id="tab-new" onclick="showTab('new')">New Request</button>
  </div>

  {{-- History Tab --}}
  <div id="pane-history">
    <div class="req-list">
      @forelse($budgets as $budget)
      @php
        $stage      = $budget->stage; // 'draft' | 'review' | 'approved' | 'reimbursed' | 'rejected'
        $badgeClass = ['draft'=>'b-review','review'=>'b-pending','approved'=>'b-approved','reimbursed'=>'b-approved','rejected'=>'b-rejected'][$stage];
        $badgeLabel = ['draft'=>'Draft','review'=>'Under Review','approved'=>'Approved','reimbursed'=>'Reimbursed','rejected'=>'Rejected'][$stage];
        $amountColor= ['draft'=>'','review'=>'','approved'=>'color:var(--green)','reimbursed'=>'color:var(--green)','rejected'=>'color:var(--red)'][$stage];
      @endphp
      <div class="req-card">
        <div class="req-card-head" onclick="toggleReq(this)">
          <div class="rch-left">
            <div class="rch-title">{{ $budget->event?->title ?? 'Untitled Event' }}</div>
            <div class="rch-meta">
              <span class="rch-meta-item"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>Submitted {{ $budget->created_at->format('j M Y') }}@if($budget->decided_at) · {{ ucfirst($budget->status) }} {{ $budget->decided_at->format('j M Y') }}@endif</span>
              <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
            </div>
          </div>
          <div class="rch-right">
            <div class="rch-amount" style="{{ $amountColor }}">RM {{ number_format($budget->effective_total, 0) }}</div>
            <svg class="rch-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
          </div>
        </div>
        <div class="req-body">
          @if($stage==='draft')
          {{-- Reinstated: an editable draft. Must revise & resubmit; HQ can't see it yet. --}}
          <div style="background:var(--amber-l);border:1px solid var(--amber-border);padding:10px 14px;font-size:12px;color:var(--amber);line-height:1.5;margin-bottom:14px"><strong>Sent back for revision.</strong>@if($budget->decision_notes) HQ note: {{ $budget->decision_notes }}.@endif Revise the breakdown and resubmit — once resubmitted you can no longer edit it.</div>
          <form method="POST" action="{{ route('student.budget.update', $budget) }}">
            @csrf
            <div style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:8px">Edit Budget Breakdown</div>
            <div style="display:grid;grid-template-columns:1fr 56px 90px 26px;gap:6px;margin-bottom:6px">
              <div style="font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey)">Item</div>
              <div style="font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey)">Qty</div>
              <div style="font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey)">Unit</div>
              <div></div>
            </div>
            <div class="line-items bedit-items">
              @foreach($budget->items as $i => $item)
              <div class="line-item">
                <input type="text" name="items[{{ $i }}][name]" value="{{ $item->name }}" required/>
                <input type="number" name="items[{{ $i }}][quantity]" value="{{ $item->quantity }}" min="1" required/>
                <input type="number" name="items[{{ $i }}][unit_cost]" value="{{ number_format($item->unit_cost, 2, '.', '') }}" min="0" step="0.01" required/>
                <button type="button" class="li-del" onclick="budgetRemoveLine(this)"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
              </div>
              @endforeach
            </div>
            <button type="button" class="btn-ghost-sm" onclick="budgetAddLine(this)" style="margin:6px 0 10px">+ Add Line</button>
            <div class="field" style="margin-bottom:10px"><label>Justification</label><textarea name="justification">{{ $budget->justification }}</textarea></div>
            <button type="submit" class="btn-primary" style="font-size:11px;padding:8px 16px">↑ Resubmit to HQ</button>
          </form>
          @else
          @php
            $apCls = $stage==='approved' ? 'active' : ($stage==='reimbursed' ? 'done' : '');
            $rbCls = $stage==='reimbursed' ? 'done' : '';
          @endphp
          <div class="pipeline" style="margin-bottom:20px">
            <div class="ps"><div class="ps-dot done"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><div class="ps-lbl done">Submitted</div></div>
            <div class="ps"><div class="ps-dot {{ $stage==='review'?'active':'done' }}"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/></svg></div><div class="ps-lbl {{ $stage==='review'?'active':'done' }}">Under Review</div></div>
            @if($stage==='rejected')
            <div class="ps"><div class="ps-dot rejected"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div><div class="ps-lbl rejected">Rejected</div></div>
            <div class="ps"><div class="ps-dot"><svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg></div><div class="ps-lbl">Reimbursed</div></div>
            @else
            <div class="ps"><div class="ps-dot {{ $apCls }}"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><div class="ps-lbl {{ $apCls }}">Approved</div></div>
            <div class="ps"><div class="ps-dot {{ $rbCls }}"><svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg></div><div class="ps-lbl {{ $rbCls }}">Reimbursed</div></div>
            @endif
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
            <div>
              <div style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:8px">Budget Breakdown</div>
              @php
                $decided   = in_array($stage, ['approved','reimbursed','rejected']);
                $apprLabel = $stage==='rejected' ? 'Willing to Fund' : 'Approved';
                $apprColor = $stage==='rejected' ? 'var(--amber)' : 'var(--green)';
              @endphp
              <table class="blt">
                @if($decided)
                <tr style="color:var(--grey)"><td style="font-size:9px;text-transform:uppercase;letter-spacing:.5px">Category</td><td style="font-size:9px;text-transform:uppercase;letter-spacing:.5px;text-align:right">Requested</td><td style="font-size:9px;text-transform:uppercase;letter-spacing:.5px;text-align:right">{{ $apprLabel }}</td></tr>
                @endif
                @foreach($budget->items as $item)
                @php $reqAmt = $item->quantity * $item->unit_cost; @endphp
                <tr>
                  <td>{{ $item->name }}@if($item->quantity > 1) ×{{ $item->quantity }}@endif</td>
                  <td style="text-align:right;{{ $decided ? 'color:var(--grey)' : '' }}">RM {{ number_format($reqAmt, 2) }}</td>
                  @if($decided)<td style="text-align:right;color:{{ $apprColor }};font-weight:600">RM {{ number_format($item->approved_amount ?? $reqAmt, 2) }}</td>@endif
                </tr>
                @endforeach
                <tr>
                  <td><strong>Total</strong></td>
                  <td style="text-align:right"><strong>RM {{ number_format($budget->total_requested, 2) }}</strong></td>
                  @if($decided)<td style="text-align:right"><strong style="color:{{ $apprColor }}">RM {{ number_format((float) ($budget->total_approved ?? 0), 2) }}</strong></td>@endif
                </tr>
              </table>
              @if($budget->justification)
              <div style="margin-top:10px;font-size:11px;color:#555;line-height:1.5"><strong style="color:var(--navy)">Justification:</strong> {{ $budget->justification }}</div>
              @endif
            </div>
            <div>
              @if($stage==='review')
              <div style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:8px">Decision</div>
              <div style="font-size:11px;color:var(--grey);line-height:1.5"><strong style="color:var(--amber)">Awaiting YES admin review.</strong> You will be notified once a decision is made.</div>

              @elseif($stage==='rejected')
              <div style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:8px">Decision</div>
              <div style="background:var(--red-l);border:1px solid rgba(192,57,43,.2);padding:10px 12px;font-size:11px;color:var(--red);line-height:1.6"><strong>Rejected.</strong> {{ $budget->decision_notes ?: 'No reason provided.' }}</div>
              <form method="POST" action="{{ route('student.budget.reinstate', $budget) }}" style="margin-top:8px">
                @csrf
                <button type="submit" class="btn-secondary" style="font-size:10px;padding:7px 14px">↩ Reinstate Request</button>
              </form>

              @else
              {{-- Approved or reimbursed: show the reimbursement claim --}}
              <div style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:8px">Reimbursement</div>
              <div style="background:var(--green-bg);border:1px solid var(--green-border);padding:10px 12px;font-size:11px;color:#166534;line-height:1.6;margin-bottom:10px"><strong>Approved: RM {{ number_format($budget->effective_total, 2) }}.</strong> {{ $budget->decision_notes ?: 'Submit your invoices/receipts to claim reimbursement.' }}</div>

              {{-- Uploaded receipts --}}
              @foreach($budget->receipts as $receipt)
              <a href="{{ $receipt->url }}" target="_blank" rel="noopener" style="background:var(--off);border:1px solid var(--light);padding:9px 12px;display:flex;gap:8px;align-items:center;margin-bottom:6px;text-decoration:none">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--navy)" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <span style="font-size:11px;color:var(--navy);flex:1">{{ $receipt->filename }}</span>
              </a>
              @endforeach

              @if($stage==='reimbursed')
              <div style="margin-top:8px;background:var(--green-bg);border:1px solid var(--green-border);padding:10px 12px;font-size:11px;color:#166534;line-height:1.6"><strong>Reimbursed RM {{ number_format((float) $budget->total_reimbursed, 2) }}</strong> on {{ $budget->reimbursed_at->format('j M Y') }}.</div>
              @else
              {{-- Approved, not yet reimbursed: allow the chapter to submit receipts --}}
              <form method="POST" action="{{ route('student.budget.receipts', $budget) }}" enctype="multipart/form-data" style="margin-top:8px">
                @csrf
                <label class="btn-ghost-sm" style="cursor:pointer;width:100%;justify-content:center">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                  Choose invoices / receipts
                  <input type="file" name="receipts[]" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" multiple style="display:none" onchange="this.form.querySelector('.rcpt-go').style.display=this.files.length?'inline-flex':'none';this.form.querySelector('.rcpt-cnt').textContent=this.files.length?this.files.length+' file(s) selected':''"/>
                </label>
                <div class="rcpt-cnt" style="font-size:10px;color:var(--grey);margin-top:4px;text-align:center"></div>
                <button type="submit" class="btn-primary rcpt-go" style="display:none;width:100%;justify-content:center;margin-top:6px;font-size:10px;padding:7px">Submit for Reimbursement</button>
              </form>
              @endif
              @endif
            </div>
          </div>
          @endif
        </div>
      </div>
      @empty
      <div style="padding:50px 20px;text-align:center;font-size:13px;color:var(--grey);background:#fff;border:1px solid var(--light)">
        No budget requests yet. @if($approvedEvents->count())<button class="btn-secondary" style="margin-left:8px;font-size:11px;padding:6px 12px" onclick="showTab('new')">Create one →</button>@else Approve an event first to request a budget.@endif
      </div>
      @endforelse
    </div>
  </div>

  {{-- New Request Tab --}}
  <div id="pane-new" style="display:none">
    <div style="background:rgba(200,168,75,.08);border:1px solid rgba(200,168,75,.25);padding:12px 16px;font-size:12px;color:#7a5b14;line-height:1.6;margin-bottom:18px;display:flex;gap:10px;align-items:flex-start">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      A budget request is raised against one of your approved events. List the budget breakdown below — YES administrators review the figures and approve a budget. After approval, you'll be able to submit invoices/receipts for reimbursement.
    </div>

    @if($errors->any())
    <div style="background:var(--red-l);border:1px solid rgba(192,57,43,.25);padding:12px 16px;font-size:12px;color:var(--red);margin-bottom:16px">
      Please complete all required fields: <strong>{{ $errors->first() }}</strong>
    </div>
    @endif

    @if($approvedEvents->isEmpty())
    <div style="padding:40px 20px;text-align:center;font-size:13px;color:var(--grey);background:#fff;border:1px solid var(--light)">
      No approved events are available for a new request. A budget request needs an <strong>approved</strong> event that doesn't already have one — to change an existing request, reinstate it from the history.
    </div>
    @else
    <form method="POST" action="{{ route('student.budget.submit') }}">
      @csrf
      <div class="form-section">
        <div class="fs-head"><div class="fs-icon"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div><div class="fs-title">Event</div></div>
        <div class="fs-body">
          <div class="field" style="margin-bottom:0"><label>Approved Event <span style="color:var(--red)">*</span></label>
            <select name="event_id" required>
              <option value="">Select an approved event…</option>
              @foreach($approvedEvents as $ev)
              <option value="{{ $ev->id }}" {{ (string) old('event_id') === (string) $ev->id ? 'selected' : '' }}>{{ $ev->title }}@if($ev->start_date) — {{ $ev->start_date->format('j M Y') }}@endif</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <div class="form-section">
        <div class="fs-head"><div class="fs-icon"><svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg></div><div class="fs-title">Budget Breakdown</div></div>
        <div class="fs-body">
          <div style="display:grid;grid-template-columns:1fr 60px 96px 28px;gap:6px;margin-bottom:6px">
            <div style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey)">Item Description</div>
            <div style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey)">Qty</div>
            <div style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey)">Unit (RM)</div>
            <div></div>
          </div>
          <div class="line-items" id="line-items">
            <div class="line-item">
              <input type="text" name="items[0][name]" placeholder="e.g. Venue &amp; Setup"/>
              <input type="number" name="items[0][quantity]" value="1" min="1" oninput="updateTotal()"/>
              <input type="number" name="items[0][unit_cost]" placeholder="0.00" min="0" step="0.01" oninput="updateTotal()"/>
              <button type="button" class="li-del" onclick="removeLine(this)"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
          </div>
          <button type="button" class="btn-ghost-sm" onclick="addLine()" style="margin-bottom:12px">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Line Item
          </button>
          <div class="budget-total-display"><span>Total Requested</span><span id="total-display">RM 0.00</span></div>
          <div class="field" style="margin-top:14px;margin-bottom:0"><label>Justification</label><textarea name="justification" placeholder="Explain how this budget supports the event…">{{ old('justification') }}</textarea></div>
        </div>
      </div>

      <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:4px">
        <button type="button" class="btn-secondary" onclick="showTab('history')">Cancel</button>
        <button type="submit" class="btn-primary">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
          Submit Budget Request
        </button>
      </div>
    </form>
    @endif
  </div>
@endsection

@section('scripts')
<script>
let lineIdx = 1;   // items[0] is rendered server-side; new rows start at 1
function showTab(tab) {
  document.getElementById('pane-history').style.display = tab === 'history' ? 'block' : 'none';
  document.getElementById('pane-new').style.display     = tab === 'new'     ? 'block' : 'none';
  document.getElementById('tab-history').classList.toggle('active', tab === 'history');
  document.getElementById('tab-new').classList.toggle('active', tab === 'new');
}
function toggleReq(head) {
  const body    = head.parentElement.querySelector('.req-body');
  const chevron = head.querySelector('.rch-chevron');
  const open    = body.classList.contains('open');
  body.classList.toggle('open', !open);
  chevron.classList.toggle('open', !open);
}
function addLine() {
  const wrap = document.getElementById('line-items');
  const div  = document.createElement('div');
  div.className = 'line-item';
  const i = lineIdx++;
  div.innerHTML = `<input type="text" name="items[${i}][name]" placeholder="Item description"/><input type="number" name="items[${i}][quantity]" value="1" min="1" oninput="updateTotal()"/><input type="number" name="items[${i}][unit_cost]" placeholder="0.00" min="0" step="0.01" oninput="updateTotal()"/><button type="button" class="li-del" onclick="removeLine(this)"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>`;
  wrap.appendChild(div);
}
function removeLine(btn) {
  const lines = document.querySelectorAll('.line-item');
  if (lines.length <= 1) { showToast('At least one budget line is required.',''); return; }
  btn.closest('.line-item').remove();
  updateTotal();
}
function updateTotal() {
  let total = 0;
  document.querySelectorAll('.line-item').forEach(row => {
    const q = parseFloat(row.querySelector('input[name*="[quantity]"]')?.value) || 0;
    const u = parseFloat(row.querySelector('input[name*="[unit_cost]"]')?.value) || 0;
    total += q * u;
  });
  document.getElementById('total-display').textContent = 'RM ' + total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}
function handleFile(input, zoneId) {
  const zone = document.getElementById(zoneId);
  const ph = zone.querySelector('.uz-placeholder');
  const fl = zone.querySelector('.uz-file');
  if (input.files.length) {
    const names = [...input.files].map(f => f.name).join(', ');
    fl.innerHTML = `<div class="uploaded-file" style="margin:0"><div class="uf-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div><span class="uf-name">${names}</span><button type="button" class="uf-remove" onclick="clearFile(event,'${input.id}','${zoneId}')">×</button></div>`;
    ph.style.display = 'none'; fl.style.display = 'block';
  } else {
    ph.style.display = ''; fl.style.display = 'none';
  }
}
function clearFile(e, inputId, zoneId) {
  e.stopPropagation();
  document.getElementById(inputId).value = '';
  handleFile(document.getElementById(inputId), zoneId);
}

// ── Inline edit of a reinstated draft ──
function budgetAddLine(btn) {
  const wrap = btn.closest('form').querySelector('.bedit-items');
  const i = 'n' + Date.now();
  const div = document.createElement('div');
  div.className = 'line-item';
  div.innerHTML = `<input type="text" name="items[${i}][name]" placeholder="Item description" required/><input type="number" name="items[${i}][quantity]" value="1" min="1" required/><input type="number" name="items[${i}][unit_cost]" placeholder="0.00" min="0" step="0.01" required/><button type="button" class="li-del" onclick="budgetRemoveLine(this)"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>`;
  wrap.appendChild(div);
}
function budgetRemoveLine(btn) {
  const items = btn.closest('.bedit-items');
  if (items.querySelectorAll('.line-item').length <= 1) { showToast('At least one budget line is required.',''); return; }
  btn.closest('.line-item').remove();
}
</script>
@endsection
