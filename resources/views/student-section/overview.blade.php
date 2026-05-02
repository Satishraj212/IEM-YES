@extends('student-section.layouts.app')
@section('title', 'Student Section')

@section('content')
  <div class="sec-header">
    <div>
      <div class="sh-eyebrow">YES UTM Johor · Academic Year 2024/25</div>
      <div class="sh-title">Student Section</div>
      <div class="sh-sub">Overview of YES UTM Johor student branch activity and engagement.</div>
    </div>
  </div>

  <div class="stat-row">
    <div class="sc">
      <div class="sc-bar" style="background:var(--gold)"></div>
      <div class="sc-lbl">Total Members</div>
      <div class="sc-val">84</div>
      <div class="sc-sub">Registered this year</div>
      <div class="sc-trend trend-up">↑ 12 from last year</div>
    </div>
    <div class="sc">
      <div class="sc-bar" style="background:var(--navy)"></div>
      <div class="sc-lbl">Events Organised</div>
      <div class="sc-val">11</div>
      <div class="sc-sub">Since Sep 2024</div>
      <div class="sc-trend trend-up">↑ 3 vs last cycle</div>
    </div>
    <div class="sc">
      <div class="sc-bar" style="background:var(--green-a)"></div>
      <div class="sc-lbl">SDG Events</div>
      <div class="sc-val">6</div>
      <div class="sc-sub">Sustainability-aligned</div>
      <div class="sc-trend trend-up">↑ 2 this term</div>
    </div>
    <div class="sc">
      <div class="sc-bar" style="background:var(--amber)"></div>
      <div class="sc-lbl">Branch Ranking</div>
      <div class="sc-val">#3</div>
      <div class="sc-sub">Among YES Johor chapters</div>
      <div class="sc-trend" style="color:var(--amber)">↑ from #5 last year</div>
    </div>
  </div>

  <div class="g2">
    <div class="panel">
      <div class="ph">
        <div class="pt">Upcoming <em>Events</em></div>
        <a href="{{ route('student.events') }}" class="pa">Manage All →</a>
      </div>
      <div class="pb" style="padding:0">
        <table class="ev-table">
          <thead><tr><th>Event</th><th>Date</th><th>Status</th><th>Reg.</th></tr></thead>
          <tbody>
            <tr>
              <td><div class="ev-title">Engineering Innovation Hackathon</div><span class="ev-cat b-hackathon">Hackathon</span></td>
              <td style="font-size:12px;color:var(--grey);white-space:nowrap">2–4 Apr 2025</td>
              <td><span class="pill pill-open">Open</span></td>
              <td><div class="prog-wrap"><div class="prog-bar"><div class="prog-fill" style="width:30%"></div></div><span class="prog-txt">36/120</span></div></td>
            </tr>
            <tr>
              <td><div class="ev-title">STEM Career Fair 2025</div><span class="ev-cat b-career">Career Fair</span></td>
              <td style="font-size:12px;color:var(--grey);white-space:nowrap">18 Apr 2025</td>
              <td><span class="pill pill-open">Open</span></td>
              <td style="font-size:11px;color:var(--grey)">Walk-in</td>
            </tr>
            <tr>
              <td><div class="ev-title">YES Green Campus Initiative</div><span class="ev-cat b-sdg">SDG · Volunteer</span></td>
              <td style="font-size:12px;color:var(--grey);white-space:nowrap">30 Apr 2025</td>
              <td><span class="pill pill-open">Open</span></td>
              <td><div class="prog-wrap"><div class="prog-bar"><div class="prog-fill" style="width:44%"></div></div><span class="prog-txt">88/200</span></div></td>
            </tr>
            <tr>
              <td><div class="ev-title">BIM &amp; Digital Engineering Workshop</div><span class="ev-cat b-workshop">Workshop</span></td>
              <td style="font-size:12px;color:var(--grey);white-space:nowrap">7 Jun 2025</td>
              <td><span class="pill pill-upcoming">Upcoming</span></td>
              <td style="font-size:11px;color:var(--grey)">Not open yet</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="panel">
      <div class="ph"><div class="pt">Recent <em>Activity</em></div></div>
      <div class="pb">
        <div class="activity-feed">
          <div class="af-item"><div class="af-dot" style="background:var(--green-a)"></div><div class="af-content"><div class="af-text"><strong>Izzatul Husna</strong> registered for Engineering Innovation Hackathon</div><div class="af-time">2 hours ago</div></div></div>
          <div class="af-item"><div class="af-dot" style="background:var(--gold)"></div><div class="af-content"><div class="af-text"><strong>4 new membership requests</strong> received — awaiting your approval</div><div class="af-time">5 hours ago</div></div></div>
          <div class="af-item"><div class="af-dot" style="background:var(--navy)"></div><div class="af-content"><div class="af-text">Event <strong>STEM Career Fair 2025</strong> published and open for registration</div><div class="af-time">Yesterday, 3:40 PM</div></div></div>
          <div class="af-item"><div class="af-dot" style="background:var(--green-a)"></div><div class="af-content"><div class="af-text"><strong>Mohamad Faiz</strong> submitted the March volunteer hours report</div><div class="af-time">2 days ago</div></div></div>
          <div class="af-item"><div class="af-dot" style="background:#5b21b6"></div><div class="af-content"><div class="af-text">Branch Sustainability Pledge <strong>renewed</strong> for 2025</div><div class="af-time">12 Mar 2025</div></div></div>
          <div class="af-item"><div class="af-dot" style="background:var(--amber)"></div><div class="af-content"><div class="af-text">Hackathon event draft <strong>approved by YES HQ</strong> and published</div><div class="af-time">28 Feb 2025</div></div></div>
        </div>
      </div>
    </div>
  </div>

  <div class="panel" style="margin-bottom:16px">
    <div class="ph">
      <div class="pt">Submissions &amp; <em>Approvals</em></div>
      <span style="font-size:11px;color:var(--grey)">Live status of your chapter's pending items</span>
    </div>
    <div class="pb" style="padding:0">
      <table class="ev-table">
        <thead>
          <tr>
            <th>Submission</th>
            <th>Type</th>
            <th>Submitted</th>
            <th>Pipeline Stage</th>
            <th style="text-align:right">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <div class="ev-title">Budget Request — Engineering Innovation Hackathon</div>
              <div style="font-size:10px;color:var(--grey);margin-top:2px">BR-2025-014 · RM 4,200 requested</div>
            </td>
            <td><span class="ev-cat b-workshop">Budget</span></td>
            <td style="font-size:11px;color:var(--grey);white-space:nowrap">22 Mar 2025</td>
            <td>
              <div style="display:flex;align-items:center;gap:0;min-width:160px">
                <div style="display:flex;flex-direction:column;align-items:center;flex:1;position:relative">
                  <div style="position:absolute;top:9px;left:50%;width:100%;height:2px;background:var(--green-a);z-index:0"></div>
                  <div style="width:18px;height:18px;border-radius:50%;background:var(--green-a);display:flex;align-items:center;justify-content:center;z-index:1;position:relative"><svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg></div>
                  <div style="font-size:8px;font-weight:700;color:var(--green-a);margin-top:3px;text-align:center">Submitted</div>
                </div>
                <div style="display:flex;flex-direction:column;align-items:center;flex:1;position:relative">
                  <div style="position:absolute;top:9px;left:50%;width:100%;height:2px;background:var(--light);z-index:0"></div>
                  <div style="width:18px;height:18px;border-radius:50%;background:var(--amber);display:flex;align-items:center;justify-content:center;z-index:1;position:relative"><svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><circle cx="12" cy="12" r="3"/></svg></div>
                  <div style="font-size:8px;font-weight:700;color:var(--amber);margin-top:3px;text-align:center">Review</div>
                </div>
                <div style="display:flex;flex-direction:column;align-items:center;flex:1;position:relative">
                  <div style="width:18px;height:18px;border-radius:50%;background:var(--light);display:flex;align-items:center;justify-content:center;z-index:1;position:relative"><svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="var(--grey)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg></div>
                  <div style="font-size:8px;font-weight:700;color:var(--grey);margin-top:3px;text-align:center">Decision</div>
                </div>
              </div>
            </td>
            <td style="text-align:right"><span class="pill pill-review">Under Review</span></td>
          </tr>
          <tr>
            <td>
              <div class="ev-title">STEM Career Fair 2025 — Event Proposal</div>
              <div style="font-size:10px;color:var(--grey);margin-top:2px">EVT-2025-007 · 240 expected attendees</div>
            </td>
            <td><span class="ev-cat b-career">Event</span></td>
            <td style="font-size:11px;color:var(--grey);white-space:nowrap">10 Mar 2025</td>
            <td>
              <div style="display:flex;align-items:center;gap:0;min-width:160px">
                <div style="display:flex;flex-direction:column;align-items:center;flex:1;position:relative">
                  <div style="position:absolute;top:9px;left:50%;width:100%;height:2px;background:var(--green-a);z-index:0"></div>
                  <div style="width:18px;height:18px;border-radius:50%;background:var(--green-a);display:flex;align-items:center;justify-content:center;z-index:1;position:relative"><svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg></div>
                  <div style="font-size:8px;font-weight:700;color:var(--green-a);margin-top:3px;text-align:center">Submitted</div>
                </div>
                <div style="display:flex;flex-direction:column;align-items:center;flex:1;position:relative">
                  <div style="position:absolute;top:9px;left:50%;width:100%;height:2px;background:var(--green-a);z-index:0"></div>
                  <div style="width:18px;height:18px;border-radius:50%;background:var(--green-a);display:flex;align-items:center;justify-content:center;z-index:1;position:relative"><svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg></div>
                  <div style="font-size:8px;font-weight:700;color:var(--green-a);margin-top:3px;text-align:center">Review</div>
                </div>
                <div style="display:flex;flex-direction:column;align-items:center;flex:1;position:relative">
                  <div style="width:18px;height:18px;border-radius:50%;background:var(--green-a);display:flex;align-items:center;justify-content:center;z-index:1;position:relative"><svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg></div>
                  <div style="font-size:8px;font-weight:700;color:var(--green-a);margin-top:3px;text-align:center">Decision</div>
                </div>
              </div>
            </td>
            <td style="text-align:right"><span class="pill pill-approved">Approved</span></td>
          </tr>
          <tr>
            <td>
              <div class="ev-title">Annual Report AY 2024/25</div>
              <div style="font-size:10px;color:var(--grey);margin-top:2px">RPT-2025-001 · 55 pages · 5.2 MB</div>
            </td>
            <td><span class="ev-cat b-sdg">Report</span></td>
            <td style="font-size:11px;color:var(--grey);white-space:nowrap">18 Apr 2025</td>
            <td>
              <div style="display:flex;align-items:center;gap:0;min-width:160px">
                <div style="display:flex;flex-direction:column;align-items:center;flex:1;position:relative">
                  <div style="position:absolute;top:9px;left:50%;width:100%;height:2px;background:var(--green-a);z-index:0"></div>
                  <div style="width:18px;height:18px;border-radius:50%;background:var(--green-a);display:flex;align-items:center;justify-content:center;z-index:1;position:relative"><svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg></div>
                  <div style="font-size:8px;font-weight:700;color:var(--green-a);margin-top:3px;text-align:center">Uploaded</div>
                </div>
                <div style="display:flex;flex-direction:column;align-items:center;flex:1;position:relative">
                  <div style="position:absolute;top:9px;left:50%;width:100%;height:2px;background:var(--light);z-index:0"></div>
                  <div style="width:18px;height:18px;border-radius:50%;background:var(--blue);display:flex;align-items:center;justify-content:center;z-index:1;position:relative"><svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"><circle cx="12" cy="12" r="3"/></svg></div>
                  <div style="font-size:8px;font-weight:700;color:var(--blue);margin-top:3px;text-align:center">Admin Review</div>
                </div>
                <div style="display:flex;flex-direction:column;align-items:center;flex:1;position:relative">
                  <div style="width:18px;height:18px;border-radius:50%;background:var(--light);display:flex;align-items:center;justify-content:center;z-index:1;position:relative"><svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="var(--grey)" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg></div>
                  <div style="font-size:8px;font-weight:700;color:var(--grey);margin-top:3px;text-align:center">Archived</div>
                </div>
              </div>
            </td>
            <td style="text-align:right"><span class="pill" style="background:var(--blue-l);color:var(--blue)">Under Review</span></td>
          </tr>
        </tbody>
      </table>
      <div style="padding:12px 20px;border-top:1px solid var(--light);display:flex;gap:10px">
        <a href="{{ route('student.budget') }}" class="btn-secondary" style="font-size:10px;padding:7px 14px">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          New Budget Request
        </a>
        <a href="{{ route('student.reports') }}" class="btn-secondary" style="font-size:10px;padding:7px 14px">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
          Submit Annual Report
        </a>
      </div>
    </div>
  </div>

  <div class="panel">
    <div class="ph">
      <div class="pt">Organisation <em>Chart</em></div>
      <div class="ph-actions">
        <span style="font-size:11px;color:var(--grey)">AY 2024/25</span>
        <button class="pa" onclick="document.getElementById('orgChartInput').click()">Upload New →</button>
      </div>
    </div>
    <div class="pb">
      <div id="orgChartEmpty">
        <div class="chart-upload-zone" id="orgChartZone"
             ondragover="event.preventDefault();this.style.borderColor='var(--navy)'"
             ondragleave="this.style.borderColor=''"
             ondrop="handleOrgChartDrop(event)">
          <input type="file" id="orgChartInput" accept="image/*,.pdf" onchange="handleOrgChartFile(this)"/>
          <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5" style="margin-bottom:12px"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
          <div style="font-size:14px;font-weight:600;color:var(--navy);margin-bottom:6px">Upload Organisation Chart</div>
          <div style="font-size:12px;color:var(--grey);line-height:1.6">Drag &amp; drop or click to upload your branch org chart.<br>Supports PNG, JPG, PDF — max 10 MB</div>
          <div style="margin-top:14px;display:inline-flex;align-items:center;gap:6px;background:var(--navy);color:var(--gold);padding:9px 18px;font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;pointer-events:none">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Choose File
          </div>
        </div>
      </div>
      <div id="orgChartPreview" style="display:none">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
          <div>
            <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:3px">Uploaded Chart</div>
            <div id="orgChartName" style="font-size:13px;font-weight:600;color:var(--navy)">org-chart.png</div>
          </div>
          <div style="display:flex;gap:8px">
            <button class="btn-secondary" style="font-size:10px;padding:7px 14px" onclick="document.getElementById('orgChartInput2').click()">Replace<input type="file" id="orgChartInput2" accept="image/*,.pdf" onchange="handleOrgChartFile(this)" style="display:none"/></button>
            <button class="btn-secondary" style="font-size:10px;padding:7px 14px;color:var(--red);border-color:var(--red)" onclick="removeOrgChart()">Remove</button>
          </div>
        </div>
        <div style="border:1px solid var(--light);overflow:hidden;max-height:480px;text-align:center;background:#f9f9f9">
          <img id="orgChartImg" src="" alt="Organisation Chart" style="max-width:100%;max-height:480px;object-fit:contain"/>
        </div>
        <div style="margin-top:10px;padding:10px 14px;background:var(--off);border:1px solid var(--light);font-size:11px;color:var(--grey);display:flex;align-items:center;gap:8px">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          Last updated <span id="orgChartDate" style="font-weight:600;color:var(--navy);margin-left:3px">just now</span>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
function handleOrgChartFile(input) {
  const file = input.files[0]; if (!file) return;
  if (file.size > 10*1024*1024) { showToast('File too large (max 10 MB)', 'danger'); return; }
  if (file.type === 'application/pdf') {
    document.getElementById('orgChartImg').style.display = 'none';
    const old = document.getElementById('pdfPh'); if(old) old.remove();
    document.getElementById('orgChartImg').insertAdjacentHTML('afterend',
      `<div id="pdfPh" style="padding:48px;text-align:center;font-size:13px;color:var(--grey)">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="1.5" style="margin-bottom:12px;display:block;margin-left:auto;margin-right:auto"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        PDF uploaded: <strong>${file.name}</strong>
      </div>`);
  } else {
    const el = document.getElementById('pdfPh'); if(el) el.remove();
    const reader = new FileReader();
    reader.onload = ev => { const img = document.getElementById('orgChartImg'); img.src = ev.target.result; img.style.display = 'block'; };
    reader.readAsDataURL(file);
  }
  document.getElementById('orgChartName').textContent = file.name;
  document.getElementById('orgChartDate').textContent = new Date().toLocaleDateString('en-GB',{day:'numeric',month:'short',year:'numeric'});
  document.getElementById('orgChartEmpty').style.display = 'none';
  document.getElementById('orgChartPreview').style.display = 'block';
  showToast('Organisation chart uploaded', 'success');
}
function handleOrgChartDrop(e) {
  e.preventDefault(); document.getElementById('orgChartZone').style.borderColor = '';
  const file = e.dataTransfer.files[0]; if(!file) return;
  handleOrgChartFile({files: [file]});
}
function removeOrgChart() {
  document.getElementById('orgChartEmpty').style.display = 'block';
  document.getElementById('orgChartPreview').style.display = 'none';
  document.getElementById('orgChartImg').src = '';
  document.getElementById('orgChartInput').value = '';
  const el = document.getElementById('pdfPh'); if(el) el.remove();
  showToast('Organisation chart removed', '');
}
</script>
@endsection
