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
.line-item{display:grid;grid-template-columns:1fr 90px 28px;gap:6px;align-items:center}
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
    <div class="sc"><div class="sc-bar" style="background:var(--amber)"></div><div class="sc-lbl">Pending Review</div><div class="sc-val">2</div><div class="sc-sub">Awaiting YES response</div></div>
    <div class="sc"><div class="sc-bar" style="background:var(--green-a)"></div><div class="sc-lbl">Approved</div><div class="sc-val">3</div><div class="sc-sub">This academic year</div></div>
    <div class="sc"><div class="sc-bar" style="background:var(--navy)"></div><div class="sc-lbl">Total Approved (RM)</div><div class="sc-val">9.8k</div><div class="sc-sub">RM 9,800 received</div></div>
    <div class="sc"><div class="sc-bar" style="background:var(--gold)"></div><div class="sc-lbl">Budget Balance</div><div class="sc-val">RM 6.2k</div><div class="sc-sub">Available this cycle</div></div>
  </div>

  <div class="tabs">
    <button class="tab active" id="tab-history" onclick="showTab('history')">Request History</button>
    <button class="tab" id="tab-new" onclick="showTab('new')">New Request</button>
  </div>

  {{-- History Tab --}}
  <div id="pane-history">
    <div class="req-list">
      <div class="req-card">
        <div class="req-card-head" onclick="toggleReq(this)">
          <div class="rch-left">
            <div class="rch-title">STEM Career Fair 2025</div>
            <div class="rch-meta">
              <span class="rch-meta-item"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>Submitted 24 Apr 2025</span>
              <span class="rch-meta-item"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>Est. 400 attendees</span>
              <span class="badge b-pending">Pending Review</span>
            </div>
          </div>
          <div class="rch-right">
            <div class="rch-amount">RM 4,500</div>
            <svg class="rch-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
          </div>
        </div>
        <div class="req-body">
          <div class="pipeline" style="margin-bottom:20px">
            <div class="ps"><div class="ps-dot done"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><div class="ps-lbl done">Submitted</div></div>
            <div class="ps"><div class="ps-dot active"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/></svg></div><div class="ps-lbl active">YES Review</div></div>
            <div class="ps"><div class="ps-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><div class="ps-lbl">Decision</div></div>
            <div class="ps"><div class="ps-dot"><svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg></div><div class="ps-lbl">Disbursed</div></div>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
            <div>
              <div style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:8px">Budget Breakdown</div>
              <table class="blt">
                <tr><td>Venue &amp; Setup</td><td>RM 1,200</td></tr>
                <tr><td>Printing &amp; Materials</td><td>RM 600</td></tr>
                <tr><td>Catering (400 pax)</td><td>RM 1,800</td></tr>
                <tr><td>Photography</td><td>RM 500</td></tr>
                <tr><td>Miscellaneous</td><td>RM 400</td></tr>
                <tr><td><strong>Total</strong></td><td><strong>RM 4,500</strong></td></tr>
              </table>
            </div>
            <div>
              <div style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:8px">Submitted Documents</div>
              <div style="background:var(--off);border:1px solid var(--light);padding:10px 12px;display:flex;gap:8px;align-items:center;margin-bottom:6px">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--navy)" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <span style="font-size:11px;font-weight:600;color:var(--navy);flex:1">event_proposal_stem_fair_2025.pdf</span>
              </div>
              <div style="font-size:11px;color:var(--grey);margin-top:10px;line-height:1.5"><strong style="color:var(--amber)">Awaiting YES admin review.</strong> You will be notified at your registered email once a decision is made.</div>
            </div>
          </div>
        </div>
      </div>

      <div class="req-card">
        <div class="req-card-head" onclick="toggleReq(this)">
          <div class="rch-left">
            <div class="rch-title">Engineering Innovation Workshop Series</div>
            <div class="rch-meta">
              <span class="rch-meta-item"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>Submitted 10 Mar 2025 · Approved 15 Mar 2025</span>
              <span class="badge b-approved">Approved</span>
            </div>
          </div>
          <div class="rch-right">
            <div class="rch-amount" style="color:var(--green)">RM 3,200</div>
            <svg class="rch-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
          </div>
        </div>
        <div class="req-body">
          <div class="pipeline" style="margin-bottom:20px">
            <div class="ps"><div class="ps-dot done"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><div class="ps-lbl done">Submitted</div></div>
            <div class="ps"><div class="ps-dot done"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><div class="ps-lbl done">YES Review</div></div>
            <div class="ps"><div class="ps-dot done"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><div class="ps-lbl done">Approved</div></div>
            <div class="ps"><div class="ps-dot done"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><div class="ps-lbl done">Disbursed</div></div>
          </div>
          <div style="background:var(--green-bg);border:1px solid var(--green-border);padding:12px 14px;font-size:12px;color:#166534;line-height:1.6"><strong>Approved in full.</strong> Strong proposal with clear budget justification. Funds were disbursed on 18 Mar 2025.</div>
        </div>
      </div>

      <div class="req-card">
        <div class="req-card-head" onclick="toggleReq(this)">
          <div class="rch-left">
            <div class="rch-title">International Speaker — Budget Request</div>
            <div class="rch-meta">
              <span class="rch-meta-item"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>Submitted 5 Feb 2025 · Rejected 8 Feb 2025</span>
              <span class="badge b-rejected">Rejected</span>
            </div>
          </div>
          <div class="rch-right">
            <div class="rch-amount" style="color:var(--red)">RM 8,000</div>
            <svg class="rch-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
          </div>
        </div>
        <div class="req-body">
          <div style="background:var(--red-l);border:1px solid rgba(192,57,43,.2);padding:12px 14px;font-size:12px;color:var(--red);line-height:1.6"><strong>Request rejected.</strong> Exceeds single-event allocation cap (RM 6,000). International speaker fees are not covered under standard YES budget. Please resubmit with reduced scope or seek co-sponsorship from your faculty.</div>
          <div style="margin-top:10px"><button class="btn-secondary" onclick="showTab('new')" style="font-size:10px;padding:7px 14px">Resubmit Revised Request →</button></div>
        </div>
      </div>
    </div>
  </div>

  {{-- New Request Tab --}}
  <div id="pane-new" style="display:none">
    <div style="background:rgba(200,168,75,.08);border:1px solid rgba(200,168,75,.25);padding:12px 16px;font-size:12px;color:#7a5b14;line-height:1.6;margin-bottom:18px;display:flex;gap:10px;align-items:flex-start">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      Budget requests must be linked to a specific approved event. YES administrators will review your proposal and supporting documents before approving funds. Decisions are typically made within 5 working days.
    </div>

    <form id="budget-form" onsubmit="submitBudget(event)">
      <div class="form-section">
        <div class="fs-head"><div class="fs-icon"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div><div class="fs-title">Event Details</div></div>
        <div class="fs-body">
          <div class="field"><label>Event Name <span style="color:var(--red)">*</span></label><input type="text" name="event_name" placeholder="e.g. STEM Career Fair 2025" required/></div>
          <div class="grid2" style="gap:12px;margin-bottom:14px">
            <div class="field" style="margin-bottom:0"><label>Event Date <span style="color:var(--red)">*</span></label><input type="date" name="event_date" required/></div>
            <div class="field" style="margin-bottom:0"><label>Expected Attendance <span style="color:var(--red)">*</span></label><input type="number" name="attendance" placeholder="e.g. 200" min="1" required/></div>
          </div>
          <div class="field"><label>Event Venue</label><input type="text" name="venue" placeholder="e.g. UTM Faculty of Engineering, Johor Bahru"/></div>
          <div class="field"><label>Event Type <span style="color:var(--red)">*</span></label>
            <select name="event_type" required>
              <option value="">Select event type…</option>
              <option>Career Fair / Industry Networking</option>
              <option>Technical Workshop</option>
              <option>Hackathon / Competition</option>
              <option>Webinar / Online Talk</option>
              <option>Sustainability / Community Outreach</option>
              <option>Leadership / Soft Skills</option>
              <option>Other</option>
            </select>
          </div>
          <div class="field" style="margin-bottom:0"><label>Event Description</label><textarea name="description" placeholder="Brief description of the event and its objectives…"></textarea></div>
        </div>
      </div>

      <div class="form-section">
        <div class="fs-head"><div class="fs-icon"><svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg></div><div class="fs-title">Budget Breakdown</div></div>
        <div class="fs-body">
          <div style="display:grid;grid-template-columns:1fr 90px;gap:8px;margin-bottom:6px">
            <div style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey)">Item Description</div>
            <div style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey)">Amount (RM)</div>
          </div>
          <div class="line-items" id="line-items">
            <div class="line-item">
              <input type="text" name="item[]" placeholder="e.g. Venue &amp; Setup" oninput="updateTotal()"/>
              <input type="number" name="amount[]" placeholder="0.00" min="0" step="0.01" oninput="updateTotal()"/>
              <button type="button" class="li-del" onclick="removeLine(this)"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
            <div class="line-item">
              <input type="text" name="item[]" placeholder="e.g. Printing &amp; Materials" oninput="updateTotal()"/>
              <input type="number" name="amount[]" placeholder="0.00" min="0" step="0.01" oninput="updateTotal()"/>
              <button type="button" class="li-del" onclick="removeLine(this)"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
          </div>
          <button type="button" class="btn-ghost-sm" onclick="addLine()" style="margin-bottom:12px">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Line Item
          </button>
          <div class="budget-total-display"><span>Total Requested</span><span id="total-display">RM 0.00</span></div>
        </div>
      </div>

      <div class="form-section">
        <div class="fs-head"><div class="fs-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div><div class="fs-title">Supporting Documents</div></div>
        <div class="fs-body">
          <div style="font-size:12px;color:var(--grey);margin-bottom:12px;line-height:1.5">Attach your event proposal and any supporting documents. Accepted: PDF, DOCX, XLSX. Max 10 MB per file.</div>
          <div class="field">
            <label>Event Proposal (Required) <span style="color:var(--red)">*</span></label>
            <div class="upload-zone" onclick="document.getElementById('proposal-upload').click()" id="proposal-zone">
              <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
              <div class="upload-zone-text"><strong>Click to upload</strong> or drag and drop</div>
              <div class="upload-zone-text" style="font-size:10px;margin-top:4px">PDF, DOCX (max 10 MB)</div>
              <input type="file" id="proposal-upload" accept=".pdf,.docx" onchange="handleFile(this,'proposal-zone')"/>
            </div>
          </div>
          <div class="field" style="margin-bottom:0">
            <label>Additional Documents (Optional)</label>
            <div class="upload-zone" onclick="document.getElementById('extra-upload').click()" id="extra-zone">
              <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
              <div class="upload-zone-text"><strong>Click to upload</strong> or drag and drop</div>
              <div class="upload-zone-text" style="font-size:10px;margin-top:4px">PDF, DOCX, XLSX (max 10 MB)</div>
              <input type="file" id="extra-upload" accept=".pdf,.docx,.xlsx" multiple onchange="handleFile(this,'extra-zone')"/>
            </div>
          </div>
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
  </div>
@endsection

@section('scripts')
<script>
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
  div.innerHTML = `<input type="text" name="item[]" placeholder="Item description" oninput="updateTotal()"/><input type="number" name="amount[]" placeholder="0.00" min="0" step="0.01" oninput="updateTotal()"/><button type="button" class="li-del" onclick="removeLine(this)"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>`;
  wrap.appendChild(div);
}
function removeLine(btn) {
  const lines = document.querySelectorAll('.line-item');
  if (lines.length <= 1) { showToast('At least one budget line is required.',''); return; }
  btn.closest('.line-item').remove();
  updateTotal();
}
function updateTotal() {
  const amounts = [...document.querySelectorAll('.line-item input[name="amount[]"]')];
  const total   = amounts.reduce((s, i) => s + (parseFloat(i.value) || 0), 0);
  document.getElementById('total-display').textContent = 'RM ' + total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}
function handleFile(input, zoneId) {
  const zone = document.getElementById(zoneId);
  if (!input.files.length) return;
  const names = [...input.files].map(f => f.name).join(', ');
  zone.innerHTML = `<div class="uploaded-file"><div class="uf-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div><span class="uf-name">${names}</span><button type="button" class="uf-remove" onclick="clearFile('${input.id}','${zoneId}')">×</button></div>`;
}
function clearFile(inputId, zoneId) {
  document.getElementById(inputId).value = '';
  location.reload();
}
function submitBudget(e) {
  e.preventDefault();
  const name = document.querySelector('[name=event_name]').value.trim();
  if (!name) { showToast('Please enter an event name.',''); return; }
  showToast('Budget request submitted! YES will review within 5 working days.', 'success');
  setTimeout(() => showTab('history'), 1500);
}
</script>
@endsection
