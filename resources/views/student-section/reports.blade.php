@extends('student-section.layouts.app')
@section('title', 'Reports & Analytics')

@section('content')
  <div class="sec-header">
    <div>
      <div class="sh-eyebrow">Branch Performance</div>
      <div class="sh-title">Reports &amp; <em>Analytics</em></div>
      <div class="sh-sub">Branch statistics for the 2024/25 academic year.</div>
    </div>
    <div style="display:flex;gap:9px;align-items:center;flex-wrap:wrap">
      <button class="btn-secondary" onclick="showToast('Generating PDF…','success')">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Download Report
      </button>
      <button class="btn-primary" onclick="openReportModal()">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
        Submit Annual Report
      </button>
    </div>
  </div>

  <div class="stat-row">
    <div class="sc"><div class="sc-bar" style="background:var(--gold)"></div><div class="sc-lbl">Events Organised</div><div class="sc-val">11</div><div class="sc-sub">Full year total</div></div>
    <div class="sc"><div class="sc-bar" style="background:var(--navy)"></div><div class="sc-lbl">Total Attendees</div><div class="sc-val">642</div><div class="sc-sub">Across all events</div></div>
    <div class="sc"><div class="sc-bar" style="background:var(--green-a)"></div><div class="sc-lbl">SDG Events</div><div class="sc-val">6</div><div class="sc-sub">Sustainability-aligned</div></div>
    <div class="sc"><div class="sc-bar" style="background:var(--amber)"></div><div class="sc-lbl">Branch Ranking</div><div class="sc-val">#3</div><div class="sc-sub">Among YES Johor branches</div></div>
  </div>

  <div class="g2">
    <div class="panel">
      <div class="ph"><div class="pt">Events by <em>Category</em></div></div>
      <div class="pb">
        <div style="display:flex;flex-direction:column;gap:14px">
          <div><div style="display:flex;justify-content:space-between;margin-bottom:5px"><span style="font-size:12px;color:var(--navy);font-weight:600">Hackathon</span><span style="font-size:12px;color:var(--grey)">2 events · 180 attendees</span></div><div class="prog-bar" style="height:8px"><div class="prog-fill" style="width:65%;background:#5b21b6"></div></div></div>
          <div><div style="display:flex;justify-content:space-between;margin-bottom:5px"><span style="font-size:12px;color:var(--navy);font-weight:600">Career Fair</span><span style="font-size:12px;color:var(--grey)">2 events · 240 attendees</span></div><div class="prog-bar" style="height:8px"><div class="prog-fill" style="width:85%;background:#1d4ed8"></div></div></div>
          <div><div style="display:flex;justify-content:space-between;margin-bottom:5px"><span style="font-size:12px;color:var(--navy);font-weight:600">Volunteer / SDG</span><span style="font-size:12px;color:var(--grey)">3 events · 130 attendees</span></div><div class="prog-bar" style="height:8px"><div class="prog-fill" style="width:48%;background:var(--green-a)"></div></div></div>
          <div><div style="display:flex;justify-content:space-between;margin-bottom:5px"><span style="font-size:12px;color:var(--navy);font-weight:600">Workshop / Webinar</span><span style="font-size:12px;color:var(--grey)">4 events · 92 attendees</span></div><div class="prog-bar" style="height:8px"><div class="prog-fill" style="width:34%;background:var(--amber)"></div></div></div>
        </div>
      </div>
    </div>
    <div class="panel">
      <div class="ph"><div class="pt">Membership <em>Growth</em></div></div>
      <div class="pb">
        <div style="display:flex;flex-direction:column;gap:10px">
          <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--light)"><span style="font-size:12px;color:var(--grey)">Sep 2024 (Start)</span><span style="font-size:14px;font-weight:700;color:var(--navy)">72 members</span></div>
          <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--light)"><span style="font-size:12px;color:var(--grey)">Dec 2024</span><span style="font-size:14px;font-weight:700;color:var(--navy)">78 members</span></div>
          <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--light)"><span style="font-size:12px;color:var(--grey)">Mar 2025</span><span style="font-size:14px;font-weight:700;color:var(--navy)">82 members</span></div>
          <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0"><span style="font-size:12px;color:var(--navy);font-weight:700">Apr 2025 (Current)</span><span style="font-size:14px;font-weight:900;color:var(--green)">84 members ↑</span></div>
          <div style="padding:10px 14px;background:var(--off);border:1px solid var(--light);font-size:12px;color:var(--grey)">+12 members year-on-year · 4 pending approval</div>
        </div>
      </div>
    </div>
  </div>

  <div class="panel">
    <div class="ph"><div class="pt">Top <em>Contributors</em></div></div>
    <div class="pb" style="padding:0">
      <table class="ev-table">
        <thead><tr><th>#</th><th>Member</th><th>Faculty</th><th>Events</th><th>SDG / Volunteer Hours</th><th>CPD Points</th></tr></thead>
        <tbody>
          <tr><td style="font-family:'Playfair Display',serif;font-weight:900;color:var(--gold)">1</td><td><div class="ev-title">Nurul Ain Binti Zain</div></td><td style="font-size:12px;color:var(--grey)">Electrical</td><td style="font-weight:700">9</td><td style="font-weight:700;color:var(--green)">18 hrs</td><td style="font-weight:700;color:var(--navy)">14 pts</td></tr>
          <tr><td style="font-family:'Playfair Display',serif;font-weight:900;color:var(--grey)">2</td><td><div class="ev-title">Lee Kai Xin</div></td><td style="font-size:12px;color:var(--grey)">Chemical</td><td style="font-weight:700">8</td><td style="font-weight:700;color:var(--green)">15 hrs</td><td style="font-weight:700;color:var(--navy)">12 pts</td></tr>
          <tr><td style="font-family:'Playfair Display',serif;font-weight:900;color:var(--grey)">3</td><td><div class="ev-title">Ahmad Razif Hakim</div></td><td style="font-size:12px;color:var(--grey)">Civil</td><td style="font-weight:700">7</td><td style="font-weight:700;color:var(--green)">12 hrs</td><td style="font-weight:700;color:var(--navy)">8 pts</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="panel">
    <div class="ph"><div class="pt">Monthly <em>Attendance</em> Trend</div><span style="font-size:11px;color:var(--grey)">Sep 2024 – Apr 2025</span></div>
    <div class="pb">
      <div style="display:flex;align-items:flex-end;gap:10px;height:140px">
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px"><span style="font-size:10px;color:var(--grey)">48</span><div style="width:100%;height:48px;background:var(--gold);opacity:.8"></div><span style="font-size:9px;color:var(--grey);font-weight:600">Sep</span></div>
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px"><span style="font-size:10px;color:var(--grey)">62</span><div style="width:100%;height:62px;background:var(--gold);opacity:.8"></div><span style="font-size:9px;color:var(--grey);font-weight:600">Oct</span></div>
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px"><span style="font-size:10px;color:var(--grey)">38</span><div style="width:100%;height:38px;background:var(--gold);opacity:.8"></div><span style="font-size:9px;color:var(--grey);font-weight:600">Nov</span></div>
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px"><span style="font-size:10px;color:var(--grey)">75</span><div style="width:100%;height:75px;background:var(--green-a);opacity:.9"></div><span style="font-size:9px;color:var(--grey);font-weight:600">Dec</span></div>
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px"><span style="font-size:10px;color:var(--grey)">55</span><div style="width:100%;height:55px;background:var(--gold);opacity:.8"></div><span style="font-size:9px;color:var(--grey);font-weight:600">Jan</span></div>
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px"><span style="font-size:10px;color:var(--grey)">90</span><div style="width:100%;height:90px;background:var(--green-a);opacity:.9"></div><span style="font-size:9px;color:var(--grey);font-weight:600">Feb</span></div>
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px"><span style="font-size:10px;color:var(--grey)">112</span><div style="width:100%;height:112px;background:var(--gold);opacity:.8"></div><span style="font-size:9px;color:var(--grey);font-weight:600">Mar</span></div>
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px"><span style="font-size:10px;color:var(--grey)">162</span><div style="width:100%;height:130px;background:var(--navy-mid)"></div><span style="font-size:9px;color:var(--navy);font-weight:700">Apr ↑</span></div>
      </div>
      <div style="margin-top:12px;padding:10px 14px;background:var(--off);border:1px solid var(--light);font-size:11px;color:var(--grey);display:flex;align-items:center;justify-content:space-between">
        <span>April includes 3 concurrent open events with active registrations.</span>
        <span style="font-weight:700;color:var(--navy)">Total YTD: 642 attendees</span>
      </div>
    </div>
  </div>

  <div class="panel">
    <div class="ph"><div class="pt">SDG <em>Alignment</em> Breakdown</div><span style="font-size:11px;color:var(--grey)">AY 2024/25</span></div>
    <div class="pb">
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px">
        <div style="padding:16px;background:var(--off);border:1px solid var(--light);text-align:center"><div style="font-size:24px;margin-bottom:8px">🌍</div><div style="font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);margin-bottom:4px">SDG 13</div><div style="font-family:'Playfair Display',serif;font-size:22px;font-weight:900;color:var(--green)">3</div><div style="font-size:11px;color:var(--grey)">Climate Action events</div></div>
        <div style="padding:16px;background:var(--off);border:1px solid var(--light);text-align:center"><div style="font-size:24px;margin-bottom:8px">🎓</div><div style="font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);margin-bottom:4px">SDG 4</div><div style="font-family:'Playfair Display',serif;font-size:22px;font-weight:900;color:var(--blue)">2</div><div style="font-size:11px;color:var(--grey)">Quality Education events</div></div>
        <div style="padding:16px;background:var(--off);border:1px solid var(--light);text-align:center"><div style="font-size:24px;margin-bottom:8px">🏗️</div><div style="font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);margin-bottom:4px">SDG 9</div><div style="font-family:'Playfair Display',serif;font-size:22px;font-weight:900;color:var(--amber)">1</div><div style="font-size:11px;color:var(--grey)">Industry &amp; Innovation event</div></div>
      </div>
    </div>
  </div>

  {{-- Annual Report Modal --}}
  <div id="reportModalOv" style="position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:900;display:none;align-items:center;justify-content:center;padding:20px" onclick="if(event.target===this)closeReportModal()">
    <div style="background:#fff;width:540px;max-width:100%;border-radius:6px;box-shadow:0 20px 80px rgba(0,31,69,.25);overflow:hidden">
      <div style="background:var(--navy-dark);padding:18px 24px;display:flex;align-items:flex-start;justify-content:space-between">
        <div>
          <div style="font-size:8px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(200,168,75,.6);margin-bottom:4px">Annual Submission</div>
          <div style="font-family:'Playfair Display',serif;font-size:17px;font-weight:900;color:#fff">Submit Annual Report</div>
          <div style="font-size:11px;color:rgba(255,255,255,.45);margin-top:3px">YES UTM Johor · Academic Year 2024/25</div>
        </div>
        <button onclick="closeReportModal()" style="background:none;border:none;color:rgba(255,255,255,.45);font-size:22px;cursor:pointer;line-height:1" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,.45)'">×</button>
      </div>
      <div style="padding:14px 24px;background:var(--off);border-bottom:1px solid var(--light);display:flex;gap:0">
        <div style="display:flex;flex-direction:column;align-items:center;flex:1"><div style="width:26px;height:26px;border-radius:50%;background:var(--navy-dark);color:var(--gold);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700">1</div><div style="font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--navy);margin-top:5px">Checklist</div></div>
        <div style="flex:1;display:flex;align-items:center;padding-bottom:18px"><div style="flex:1;height:2px;background:var(--light)"></div></div>
        <div style="display:flex;flex-direction:column;align-items:center;flex:1"><div style="width:26px;height:26px;border-radius:50%;background:var(--light);color:var(--grey);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700" id="rms2dot">2</div><div style="font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--grey);margin-top:5px" id="rms2lbl">Upload</div></div>
        <div style="flex:1;display:flex;align-items:center;padding-bottom:18px"><div style="flex:1;height:2px;background:var(--light)"></div></div>
        <div style="display:flex;flex-direction:column;align-items:center;flex:1"><div style="width:26px;height:26px;border-radius:50%;background:var(--light);color:var(--grey);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700" id="rms3dot">3</div><div style="font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--grey);margin-top:5px" id="rms3lbl">Confirm</div></div>
      </div>
      <div id="rmStep1" style="padding:22px 24px">
        <div style="font-size:12px;color:#444;line-height:1.7;margin-bottom:16px">Before submitting, confirm your report includes all required sections:</div>
        <div style="display:flex;flex-direction:column;gap:9px" id="checklist">
          <label style="display:flex;align-items:center;gap:10px;cursor:pointer;padding:10px 14px;border:1px solid var(--light);border-radius:3px;background:var(--off)"><input type="checkbox" onchange="checkAll()" style="width:15px;height:15px;accent-color:var(--navy-dark);flex-shrink:0"/><div><div style="font-size:12px;font-weight:600;color:var(--navy)">Branch Profile &amp; Member List</div><div style="font-size:11px;color:var(--grey)">Updated member register with roles</div></div></label>
          <label style="display:flex;align-items:center;gap:10px;cursor:pointer;padding:10px 14px;border:1px solid var(--light);border-radius:3px;background:var(--off)"><input type="checkbox" onchange="checkAll()" style="width:15px;height:15px;accent-color:var(--navy-dark);flex-shrink:0"/><div><div style="font-size:12px;font-weight:600;color:var(--navy)">Events Summary (min. 4 events)</div><div style="font-size:11px;color:var(--grey)">List of events with attendance data</div></div></label>
          <label style="display:flex;align-items:center;gap:10px;cursor:pointer;padding:10px 14px;border:1px solid var(--light);border-radius:3px;background:var(--off)"><input type="checkbox" onchange="checkAll()" style="width:15px;height:15px;accent-color:var(--navy-dark);flex-shrink:0"/><div><div style="font-size:12px;font-weight:600;color:var(--navy)">SDG &amp; Sustainability Activities</div><div style="font-size:11px;color:var(--grey)">At least 2 SDG-aligned activities documented</div></div></label>
          <label style="display:flex;align-items:center;gap:10px;cursor:pointer;padding:10px 14px;border:1px solid var(--light);border-radius:3px;background:var(--off)"><input type="checkbox" onchange="checkAll()" style="width:15px;height:15px;accent-color:var(--navy-dark);flex-shrink:0"/><div><div style="font-size:12px;font-weight:600;color:var(--navy)">Budget &amp; Financial Summary</div><div style="font-size:11px;color:var(--grey)">Income, expenses, and fund balance</div></div></label>
          <label style="display:flex;align-items:center;gap:10px;cursor:pointer;padding:10px 14px;border:1px solid var(--light);border-radius:3px;background:var(--off)"><input type="checkbox" onchange="checkAll()" style="width:15px;height:15px;accent-color:var(--navy-dark);flex-shrink:0"/><div><div style="font-size:12px;font-weight:600;color:var(--navy)">Chairperson's Endorsement</div><div style="font-size:11px;color:var(--grey)">Signed declaration page included</div></div></label>
        </div>
        <div style="margin-top:14px;padding:10px 14px;border:1px solid rgba(200,168,75,.25);border-radius:3px;font-size:11px;color:#7a5b14;line-height:1.55;background:rgba(200,168,75,.06)"><strong>Submission deadline:</strong> 30 April 2025. Late submissions require national board approval.</div>
      </div>
      <div style="padding:12px 24px;border-top:1px solid var(--light);display:flex;justify-content:flex-end;background:#fafaf8" id="rmFoot1">
        <button class="btn-secondary" onclick="closeReportModal()" style="margin-right:8px;font-size:11px">Cancel</button>
        <button id="rmNext1" class="btn-primary" style="font-size:11px;opacity:.4;cursor:not-allowed" disabled onclick="goRmStep(2)">Next: Upload →</button>
      </div>
      <div id="rmStep2" style="padding:22px 24px;display:none">
        <div style="margin-bottom:16px"><label style="display:block;font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:6px">Academic Year</label><select style="width:100%;border:1px solid var(--light);background:var(--off);padding:9px 12px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--navy);outline:none;border-radius:3px"><option>2024/2025</option><option>2023/2024</option></select></div>
        <div><label style="display:block;font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:6px">Report File (PDF only, max 20 MB)</label>
          <div id="rmDropZone" style="border:2px dashed var(--light);border-radius:3px;padding:32px 20px;text-align:center;cursor:pointer;background:var(--off)" onclick="document.getElementById('rmFileInput').click()" ondragover="event.preventDefault();this.style.borderColor='var(--navy)'" ondragleave="this.style.borderColor=''" ondrop="handleRmDrop(event)">
            <input type="file" id="rmFileInput" accept=".pdf" style="display:none" onchange="handleRmFile(this)"/>
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--grey)" stroke-width="1.5" style="margin-bottom:10px"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            <div style="font-size:13px;font-weight:600;color:var(--navy);margin-bottom:4px">Drop PDF here or click to browse</div>
            <div style="font-size:11px;color:var(--grey)">PDF · max 20 MB</div>
          </div>
          <div id="rmFilePreview" style="display:none;margin-top:10px;padding:10px 14px;background:var(--off);border:1px solid var(--light);border-radius:3px;align-items:center;gap:10px">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            <div style="flex:1"><div id="rmFileName" style="font-size:12px;font-weight:600;color:var(--navy)"></div><div id="rmFileSize" style="font-size:10px;color:var(--grey);margin-top:1px"></div></div>
            <button onclick="removeRmFile()" style="background:none;border:none;cursor:pointer;color:var(--grey);font-size:18px;line-height:1">×</button>
          </div>
        </div>
      </div>
      <div id="rmFoot2" style="padding:12px 24px;border-top:1px solid var(--light);display:none;justify-content:space-between;background:#fafaf8">
        <button class="btn-secondary" onclick="goRmStep(1)" style="font-size:11px">← Back</button>
        <button id="rmNext2" class="btn-primary" style="font-size:11px;opacity:.4;cursor:not-allowed" disabled onclick="goRmStep(3)">Review &amp; Submit →</button>
      </div>
      <div id="rmStep3" style="padding:22px 24px;display:none">
        <div style="background:var(--off);border:1px solid var(--light);border-radius:3px;padding:16px;margin-bottom:16px">
          <div style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:10px">Submission Summary</div>
          <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--light)"><span style="font-size:11px;color:var(--grey)">Chapter</span><span style="font-size:12px;font-weight:600;color:var(--navy)">YES UTM Johor</span></div>
          <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--light)"><span style="font-size:11px;color:var(--grey)">Academic Year</span><span style="font-size:12px;font-weight:600;color:var(--navy)">2024/2025</span></div>
          <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--light)"><span style="font-size:11px;color:var(--grey)">Report File</span><span id="rmConfirmFile" style="font-size:12px;font-weight:600;color:var(--navy)">—</span></div>
          <div style="display:flex;justify-content:space-between;padding:8px 0"><span style="font-size:11px;color:var(--grey)">Submitted By</span><span style="font-size:12px;font-weight:600;color:var(--navy)">Ahmad Razif (Chapter Lead)</span></div>
        </div>
        <div style="padding:10px 14px;border:1px solid rgba(200,168,75,.25);border-radius:3px;font-size:11px;color:#7a5b14;line-height:1.55;background:rgba(200,168,75,.06)">By submitting, you confirm this report is complete and endorsed by your chapter chairperson. The YES national board will review it within <strong>14 working days</strong>.</div>
      </div>
      <div id="rmFoot3" style="padding:12px 24px;border-top:1px solid var(--light);display:none;justify-content:space-between;background:#fafaf8">
        <button class="btn-secondary" onclick="goRmStep(2)" style="font-size:11px">← Back</button>
        <button class="btn-primary" style="font-size:11px;background:var(--green)" onclick="submitReport()">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
          Submit Report
        </button>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
let _rmStep = 1, _rmFile = null;
function openReportModal() {
  _rmStep = 1; _rmFile = null;
  document.getElementById('reportModalOv').style.display = 'flex';
  goRmStep(1);
}
function closeReportModal() {
  document.getElementById('reportModalOv').style.display = 'none';
}
function goRmStep(n) {
  _rmStep = n;
  [1,2,3].forEach(i => {
    document.getElementById('rmStep'+i).style.display = i===n ? 'block' : 'none';
    document.getElementById('rmFoot'+i).style.display = i===n ? 'flex' : 'none';
  });
  const dots = { 2: document.getElementById('rms2dot'), 3: document.getElementById('rms3dot') };
  const lbls = { 2: document.getElementById('rms2lbl'), 3: document.getElementById('rms3lbl') };
  [2,3].forEach(i => {
    const active = n >= i;
    dots[i].style.background = active ? 'var(--navy-dark)' : 'var(--light)';
    dots[i].style.color = active ? 'var(--gold)' : 'var(--grey)';
    lbls[i].style.color = active ? 'var(--navy)' : 'var(--grey)';
  });
  if (n === 3 && _rmFile) document.getElementById('rmConfirmFile').textContent = _rmFile.name;
}
function checkAll() {
  const all = [...document.querySelectorAll('#checklist input[type=checkbox]')];
  const btn = document.getElementById('rmNext1');
  btn.disabled = !all.every(c => c.checked);
  btn.style.opacity = btn.disabled ? '.4' : '1';
  btn.style.cursor = btn.disabled ? 'not-allowed' : 'pointer';
}
function handleRmFile(input) {
  const f = input.files[0]; if (!f) return;
  if (f.size > 20*1024*1024) { showToast('File too large (max 20 MB)','danger'); return; }
  _rmFile = f;
  document.getElementById('rmDropZone').style.display = 'none';
  document.getElementById('rmFilePreview').style.display = 'flex';
  document.getElementById('rmFileName').textContent = f.name;
  document.getElementById('rmFileSize').textContent = (f.size/1024/1024).toFixed(1) + ' MB';
  const btn = document.getElementById('rmNext2');
  btn.disabled = false; btn.style.opacity = '1'; btn.style.cursor = 'pointer';
}
function handleRmDrop(e) {
  e.preventDefault(); document.getElementById('rmDropZone').style.borderColor = '';
  handleRmFile({files: e.dataTransfer.files});
}
function removeRmFile() {
  _rmFile = null;
  document.getElementById('rmDropZone').style.display = 'block';
  document.getElementById('rmFilePreview').style.display = 'none';
  document.getElementById('rmFileInput').value = '';
  const btn = document.getElementById('rmNext2');
  btn.disabled = true; btn.style.opacity = '.4'; btn.style.cursor = 'not-allowed';
}
function submitReport() {
  closeReportModal();
  showToast('Annual report submitted successfully!', 'success');
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeReportModal(); });
</script>
@endsection
