@extends('student-section.layouts.app')
@section('title', 'Awards')

@section('styles')
<style>
/* ── AWARDS HERO ── */
.awards-hero{background:linear-gradient(135deg,var(--navy-dark) 0%,var(--navy-mid) 60%,#0a3d6b 100%);padding:36px 32px;position:relative;overflow:hidden;margin-bottom:24px}
.awards-hero::before{content:'★';position:absolute;right:-20px;top:-20px;font-size:180px;color:rgba(200,168,75,.05);line-height:1;pointer-events:none}
.awards-hero::after{content:'';position:absolute;inset:0;background:repeating-linear-gradient(45deg,transparent,transparent 20px,rgba(200,168,75,.015) 20px,rgba(200,168,75,.015) 21px);pointer-events:none}
.awards-hero-eyebrow{font-size:9px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:rgba(200,168,75,.6);margin-bottom:10px}
.awards-hero-title{font-family:'Playfair Display',serif;font-size:28px;font-weight:900;color:#fff;line-height:1.1;margin-bottom:10px}
.awards-hero-title em{color:var(--gold);font-style:normal}
.awards-hero-sub{font-size:13px;color:rgba(255,255,255,.6);line-height:1.75;max-width:540px}
.awards-hero-actions{margin-top:20px;display:flex;gap:10px;flex-wrap:wrap}

/* ── AWARD GRID ── */
.award-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px}
.award-card{background:#fff;border:1px solid var(--light);position:relative;overflow:hidden;cursor:pointer;transition:all .25s}
.award-card:hover{box-shadow:0 8px 32px rgba(0,31,69,.1);transform:translateY(-2px)}
.award-card-ribbon{position:absolute;top:0;left:0;right:0;height:4px}
.award-card-icon{width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:22px;margin:0 auto 14px;border:2px solid rgba(200,168,75,.2)}
.award-card-title{font-family:'Playfair Display',serif;font-size:15px;font-weight:700;color:var(--navy);text-align:center;margin-bottom:6px}
.award-card-sub{font-size:11px;color:var(--grey);text-align:center;line-height:1.6}
.award-card-body{padding:22px}
.award-card-meta{display:flex;justify-content:center;gap:12px;margin-top:14px;padding-top:12px;border-top:1px solid var(--light)}
.award-meta-item{text-align:center}
.award-meta-val{font-family:'Playfair Display',serif;font-size:16px;font-weight:900;color:var(--navy)}
.award-meta-lbl{font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-top:2px}
.award-card-actions{padding:0 22px 18px;display:flex;gap:8px}
.award-status-badge{display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;padding:4px 10px;margin:0 auto 10px;width:fit-content}
.asb-open{background:#d1fae5;color:#065f46}
.asb-closed{background:var(--light);color:var(--grey)}
.asb-voting{background:#ede9fe;color:#5b21b6}
.asb-coming{background:#dbeafe;color:#1e40af}

/* ── WINNER CARDS ── */
.winner-card{background:linear-gradient(135deg,var(--navy-dark),var(--navy-mid));border:1px solid rgba(200,168,75,.25);padding:20px 22px;position:relative;overflow:hidden;display:flex;align-items:center;gap:18px}
.winner-card::before{content:'🏆';position:absolute;right:16px;top:50%;transform:translateY(-50%);font-size:60px;opacity:.08;pointer-events:none}
.winner-rank{font-family:'Playfair Display',serif;font-size:36px;font-weight:900;color:var(--gold);min-width:48px;text-align:center;line-height:1}
.winner-av{width:48px;height:48px;border-radius:50%;background:var(--gold);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:16px;font-weight:900;color:var(--navy-dark);flex-shrink:0}
.winner-info{flex:1}
.winner-name{font-size:15px;font-weight:700;color:#fff}
.winner-award{font-size:11px;color:rgba(200,168,75,.8);margin-top:2px}
.winner-year{font-size:11px;color:rgba(255,255,255,.4);margin-top:2px}

/* ── APPLICATIONS ── */
.my-app-row{display:flex;align-items:center;gap:14px;padding:14px 16px;background:#fff;border:1px solid var(--light)}
.my-app-icon{width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
.my-app-info{flex:1}
.my-app-name{font-size:13px;font-weight:600;color:var(--navy)}
.my-app-sub{font-size:11px;color:var(--grey);margin-top:2px}

/* ── TIMELINE ── */
.tl-item{display:flex;gap:16px;padding:12px 0;border-bottom:1px solid var(--light)}
.tl-item:last-child{border-bottom:none}
.tl-dot-wrap{display:flex;flex-direction:column;align-items:center;flex-shrink:0;width:20px}
.tl-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0;margin-top:3px}
.tl-line{flex:1;width:1px;background:var(--light);margin-top:4px}
.tl-title{font-size:13px;font-weight:600;color:var(--navy)}
.tl-date{font-size:11px;color:var(--grey);margin-top:2px}
.tl-note{font-size:11px;color:var(--grey);margin-top:3px;line-height:1.5}

/* ── STAR RATING ── */
.star-rating{display:flex;gap:4px;cursor:pointer}
.star-rating span{font-size:22px;color:var(--light);transition:color .15s;user-select:none}
.star-rating span.active{color:var(--gold)}

/* ── VOTE ── */
.vote-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.vote-card{background:#fff;border:2px solid var(--light);padding:16px;cursor:pointer;transition:all .2s;position:relative}
.vote-card:hover{border-color:var(--navy);box-shadow:0 4px 16px rgba(0,31,69,.07)}
.vote-card.voted{border-color:var(--gold);background:rgba(200,168,75,.04)}
.vote-card.voted::after{content:'✓ Voted';position:absolute;top:10px;right:10px;font-size:9px;font-weight:700;color:var(--gold);letter-spacing:1px}
.vote-av{width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:16px;font-weight:900;color:#fff;margin:0 auto 10px}
.vote-name{font-size:13px;font-weight:700;color:var(--navy);text-align:center}
.vote-branch{font-size:10px;color:var(--grey);text-align:center;margin-top:2px}
.vote-bar-wrap{margin-top:10px}
.vote-bar{height:4px;background:var(--light);overflow:hidden}
.vote-bar-fill{height:100%;background:var(--gold);transition:width .6s ease}
.vote-pct{font-size:10px;font-weight:700;color:var(--navy);text-align:center;margin-top:4px}
</style>
@endsection

@section('content')
  <div class="awards-hero">
    <div class="awards-hero-eyebrow">YES IEM Malaysia · Recognition Programme</div>
    <div class="awards-hero-title">Branch <em>Awards</em> &amp; Honours</div>
    <div class="awards-hero-sub">Celebrate excellence in engineering, leadership, and sustainability. Nominate outstanding peers, vote for category winners, or apply directly for YES recognition awards.</div>
    <div class="awards-hero-actions">
      <button class="btn-gold" onclick="openNominate()">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        Nominate Someone
      </button>
      <button class="btn-outline-white" onclick="openApply()">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        Apply for Award
      </button>
    </div>
  </div>

  <div class="sec-header">
    <div>
      <div style="font-size:9px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--gold);margin-bottom:4px">2025 Award Cycle</div>
      <div style="font-family:'Playfair Display',serif;font-size:20px;font-weight:900;color:var(--navy)">Award <em style="color:var(--gold);font-style:italic">Categories</em></div>
    </div>
    <div style="font-size:12px;color:var(--grey)">Nomination deadline: <strong style="color:var(--navy)">30 May 2025</strong></div>
  </div>

  <div class="award-grid">
    <div class="award-card" onclick="openAwardDetail('young-engineer')">
      <div class="award-card-ribbon" style="background:linear-gradient(90deg,var(--gold),var(--gold-light))"></div>
      <div class="award-card-body">
        <div class="award-card-icon" style="background:rgba(200,168,75,.1);border-color:rgba(200,168,75,.3)">🏆</div>
        <div class="award-status-badge asb-open">● Nominations Open</div>
        <div class="award-card-title">Young Engineer Award</div>
        <div class="award-card-sub">Recognises outstanding achievement in engineering practice, innovation, and professional development among YES members.</div>
        <div class="award-card-meta">
          <div class="award-meta-item"><div class="award-meta-val">12</div><div class="award-meta-lbl">Nominations</div></div>
          <div class="award-meta-item"><div class="award-meta-val">3</div><div class="award-meta-lbl">Finalists</div></div>
          <div class="award-meta-item"><div class="award-meta-val">30 May</div><div class="award-meta-lbl">Deadline</div></div>
        </div>
      </div>
      <div class="award-card-actions">
        <button class="btn-mini btn-mini-navy" onclick="event.stopPropagation();openNominate('young-engineer')">Nominate</button>
        <button class="btn-mini btn-mini-outline" onclick="event.stopPropagation();openVote('young-engineer')">View &amp; Vote</button>
      </div>
    </div>
    <div class="award-card" onclick="openAwardDetail('best-branch')">
      <div class="award-card-ribbon" style="background:linear-gradient(90deg,var(--blue),#3b82f6)"></div>
      <div class="award-card-body">
        <div class="award-card-icon" style="background:var(--blue-l);border-color:rgba(29,78,216,.2)">🎓</div>
        <div class="award-status-badge asb-voting">★ Voting Active</div>
        <div class="award-card-title">Best Student Branch</div>
        <div class="award-card-sub">Awarded to the YES student branch demonstrating the highest impact in events, membership growth, and sustainability initiatives.</div>
        <div class="award-card-meta">
          <div class="award-meta-item"><div class="award-meta-val">8</div><div class="award-meta-lbl">Branches</div></div>
          <div class="award-meta-item"><div class="award-meta-val">247</div><div class="award-meta-lbl">Votes Cast</div></div>
          <div class="award-meta-item"><div class="award-meta-val">15 Jun</div><div class="award-meta-lbl">Closes</div></div>
        </div>
      </div>
      <div class="award-card-actions">
        <button class="btn-mini btn-mini-navy" onclick="event.stopPropagation();openVote('best-branch')">Vote Now</button>
        <button class="btn-mini btn-mini-outline" onclick="event.stopPropagation();openAwardDetail('best-branch')">View Details</button>
      </div>
    </div>
    <div class="award-card" onclick="openAwardDetail('sdg')">
      <div class="award-card-ribbon" style="background:linear-gradient(90deg,var(--green),var(--green-a))"></div>
      <div class="award-card-body">
        <div class="award-card-icon" style="background:rgba(26,107,60,.08);border-color:rgba(76,175,125,.2)">🌿</div>
        <div class="award-status-badge asb-open">● Nominations Open</div>
        <div class="award-card-title">SDG Leadership Award</div>
        <div class="award-card-sub">Honours individuals or branches leading the way in Sustainable Development Goals through engineering initiatives and volunteer work.</div>
        <div class="award-card-meta">
          <div class="award-meta-item"><div class="award-meta-val">6</div><div class="award-meta-lbl">Nominations</div></div>
          <div class="award-meta-item"><div class="award-meta-val">2</div><div class="award-meta-lbl">Finalists</div></div>
          <div class="award-meta-item"><div class="award-meta-val">30 May</div><div class="award-meta-lbl">Deadline</div></div>
        </div>
      </div>
      <div class="award-card-actions">
        <button class="btn-mini btn-mini-navy" onclick="event.stopPropagation();openNominate('sdg')">Nominate</button>
        <button class="btn-mini btn-mini-outline" onclick="event.stopPropagation();openAwardDetail('sdg')">View Details</button>
      </div>
    </div>
    <div class="award-card" onclick="openAwardDetail('innovation')">
      <div class="award-card-ribbon" style="background:linear-gradient(90deg,#7c3aed,#a78bfa)"></div>
      <div class="award-card-body">
        <div class="award-card-icon" style="background:#ede9fe;border-color:rgba(124,58,237,.2)">💡</div>
        <div class="award-status-badge asb-coming">Coming Soon</div>
        <div class="award-card-title">Innovation Excellence Award</div>
        <div class="award-card-sub">Recognises groundbreaking engineering projects, research contributions, or technological innovations by YES members.</div>
        <div class="award-card-meta">
          <div class="award-meta-item"><div class="award-meta-val">—</div><div class="award-meta-lbl">Nominations</div></div>
          <div class="award-meta-item"><div class="award-meta-val">—</div><div class="award-meta-lbl">Finalists</div></div>
          <div class="award-meta-item"><div class="award-meta-val">Jul 2025</div><div class="award-meta-lbl">Opens</div></div>
        </div>
      </div>
      <div class="award-card-actions"><button class="btn-mini btn-mini-outline" style="flex:1;opacity:.5" disabled>Opens Jul 2025</button></div>
    </div>
    <div class="award-card" onclick="openAwardDetail('leadership')">
      <div class="award-card-ribbon" style="background:linear-gradient(90deg,var(--amber),#fbbf24)"></div>
      <div class="award-card-body">
        <div class="award-card-icon" style="background:var(--amber-l);border-color:rgba(217,119,6,.2)">👑</div>
        <div class="award-status-badge asb-open">● Apply Now</div>
        <div class="award-card-title">YES Leadership Award</div>
        <div class="award-card-sub">For branch officers who have demonstrated exceptional leadership in growing their YES student section and professional development activities.</div>
        <div class="award-card-meta">
          <div class="award-meta-item"><div class="award-meta-val">4</div><div class="award-meta-lbl">Applications</div></div>
          <div class="award-meta-item"><div class="award-meta-val">1</div><div class="award-meta-lbl">From Branch</div></div>
          <div class="award-meta-item"><div class="award-meta-val">15 Jun</div><div class="award-meta-lbl">Deadline</div></div>
        </div>
      </div>
      <div class="award-card-actions">
        <button class="btn-mini btn-mini-navy" onclick="event.stopPropagation();openApply('leadership')">Apply</button>
        <button class="btn-mini btn-mini-outline" onclick="event.stopPropagation();openNominate('leadership')">Nominate Peer</button>
      </div>
    </div>
    <div class="award-card" onclick="openAwardDetail('event')">
      <div class="award-card-ribbon" style="background:linear-gradient(90deg,#0ea5e9,#38bdf8)"></div>
      <div class="award-card-body">
        <div class="award-card-icon" style="background:#e0f2fe;border-color:rgba(14,165,233,.2)">📅</div>
        <div class="award-status-badge asb-open">● Nominations Open</div>
        <div class="award-card-title">Event of the Year</div>
        <div class="award-card-sub">Celebrating the most impactful, well-organised, and highly attended YES student section event of the academic year.</div>
        <div class="award-card-meta">
          <div class="award-meta-item"><div class="award-meta-val">9</div><div class="award-meta-lbl">Nominations</div></div>
          <div class="award-meta-item"><div class="award-meta-val">3</div><div class="award-meta-lbl">Finalists</div></div>
          <div class="award-meta-item"><div class="award-meta-val">30 May</div><div class="award-meta-lbl">Deadline</div></div>
        </div>
      </div>
      <div class="award-card-actions">
        <button class="btn-mini btn-mini-navy" onclick="event.stopPropagation();openNominate('event')">Nominate</button>
        <button class="btn-mini btn-mini-outline" onclick="event.stopPropagation();openVote('event')">View &amp; Vote</button>
      </div>
    </div>
  </div>

  <div class="g2">
    <div class="panel">
      <div class="ph"><div class="pt">My <em>Applications</em></div><button class="pa" onclick="openApply()">+ Apply →</button></div>
      <div class="pb">
        <div style="display:flex;flex-direction:column;gap:8px">
          <div class="my-app-row"><div class="my-app-icon" style="background:rgba(200,168,75,.12)">🏆</div><div class="my-app-info"><div class="my-app-name">Young Engineer Award 2025</div><div class="my-app-sub">Submitted 10 Apr 2025 · Self-application</div></div><span class="pill pill-review">Under Review</span></div>
          <div class="my-app-row"><div class="my-app-icon" style="background:rgba(217,119,6,.1)">👑</div><div class="my-app-info"><div class="my-app-name">YES Leadership Award 2025</div><div class="my-app-sub">Submitted 2 Apr 2025 · Self-application</div></div><span class="pill pill-review">Under Review</span></div>
          <div class="my-app-row"><div class="my-app-icon" style="background:rgba(26,107,60,.08)">🌿</div><div class="my-app-info"><div class="my-app-name">SDG Leadership — Nominated Nurul Ain Binti Zain</div><div class="my-app-sub">Nomination sent 1 Apr 2025</div></div><span class="pill pill-open">Accepted</span></div>
          <div style="padding:12px 0;text-align:center;font-size:11px;color:var(--grey)"><button onclick="openApply()" style="background:none;border:none;color:var(--navy);font-weight:700;cursor:pointer;font-size:11px;text-decoration:underline;font-family:'DM Sans',sans-serif">Apply for another award →</button></div>
        </div>
      </div>
    </div>
    <div class="panel">
      <div class="ph"><div class="pt">Past <em>Winners</em></div><span style="font-size:11px;color:var(--grey)">2024 Cycle</span></div>
      <div class="pb" style="padding:14px">
        <div style="display:flex;flex-direction:column;gap:8px">
          <div class="winner-card"><div class="winner-rank">#1</div><div class="winner-av">NA</div><div class="winner-info"><div class="winner-name">Nurul Ain Binti Zain</div><div class="winner-award">Young Engineer Award 2024</div><div class="winner-year">YES UTM Johor · 2024</div></div></div>
          <div class="winner-card" style="background:linear-gradient(135deg,var(--green-dark),var(--green))"><div class="winner-rank" style="color:var(--green-l)">#1</div><div class="winner-av" style="background:var(--green-a)">JB</div><div class="winner-info"><div class="winner-name">YES UTM Johor Branch</div><div class="winner-award" style="color:rgba(168,230,193,.8)">Best Student Branch 2024</div><div class="winner-year" style="color:rgba(255,255,255,.35)">YES Johor Chapter · 2024</div></div></div>
        </div>
      </div>
    </div>
  </div>

  <div class="panel">
    <div class="ph"><div class="pt">Award <em>Timeline</em> 2025</div></div>
    <div class="pb">
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">
        <div>
          <div class="tl-item"><div class="tl-dot-wrap"><div class="tl-dot" style="background:var(--green)"></div><div class="tl-line"></div></div><div><div class="tl-title">Nominations Open</div><div class="tl-date">1 April 2025</div><div class="tl-note">Nomination portal opens for all YES members</div></div></div>
          <div class="tl-item"><div class="tl-dot-wrap"><div class="tl-dot" style="background:var(--gold)"></div><div class="tl-line"></div></div><div><div class="tl-title">Nomination Deadline</div><div class="tl-date">30 May 2025</div><div class="tl-note">Last day to submit nominations and self-applications</div></div></div>
          <div class="tl-item"><div class="tl-dot-wrap"><div class="tl-dot" style="background:var(--blue)"></div><div class="tl-line"></div></div><div><div class="tl-title">Voting Period</div><div class="tl-date">1 – 15 June 2025</div><div class="tl-note">Members vote for shortlisted candidates</div></div></div>
          <div class="tl-item"><div class="tl-dot-wrap"><div class="tl-dot" style="background:var(--navy)"></div></div><div><div class="tl-title">Awards Ceremony</div><div class="tl-date">28 June 2025</div><div class="tl-note">Annual YES Gala &amp; Awards Night, KL</div></div></div>
        </div>
        <div>
          <div style="font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);margin-bottom:14px">Nomination Criteria</div>
          <div style="display:flex;flex-direction:column;gap:9px">
            <div style="display:flex;align-items:flex-start;gap:10px;padding:10px 12px;background:var(--off);border:1px solid var(--light)"><span style="font-size:16px">📋</span><div><div style="font-size:12px;font-weight:700;color:var(--navy)">Active YES Member</div><div style="font-size:11px;color:var(--grey);margin-top:2px">Registered YES IEM member for at least 6 months</div></div></div>
            <div style="display:flex;align-items:flex-start;gap:10px;padding:10px 12px;background:var(--off);border:1px solid var(--light)"><span style="font-size:16px">🎯</span><div><div style="font-size:12px;font-weight:700;color:var(--navy)">Demonstrated Achievement</div><div style="font-size:11px;color:var(--grey);margin-top:2px">Clear evidence of contributions in the relevant category</div></div></div>
            <div style="display:flex;align-items:flex-start;gap:10px;padding:10px 12px;background:var(--off);border:1px solid var(--light)"><span style="font-size:16px">📄</span><div><div style="font-size:12px;font-weight:700;color:var(--navy)">Supporting Documents</div><div style="font-size:11px;color:var(--grey);margin-top:2px">CV, recommendation letter, and portfolio where applicable</div></div></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Nominate Modal --}}
  <div class="modal-overlay" id="nominateModal" onclick="if(event.target===this)this.classList.remove('open')">
    <div class="modal" style="width:580px">
      <div class="modal-head"><h3>Submit Nomination</h3><button class="modal-close" onclick="document.getElementById('nominateModal').classList.remove('open')">×</button></div>
      <div class="modal-body">
        <div style="padding:12px 16px;background:rgba(200,168,75,.08);border:1px solid rgba(200,168,75,.2);margin-bottom:18px;font-size:12px;color:var(--navy);line-height:1.65"><strong>Nomination Guidelines:</strong> Nominations must be genuine and supported by evidence. To apply for yourself, use the Apply pathway instead.</div>
        <div class="form-row"><label class="form-lbl">Award Category *</label><select class="form-sel" id="nom-cat"><option>Young Engineer Award</option><option>Best Student Branch</option><option>SDG Leadership Award</option><option>YES Leadership Award</option><option>Event of the Year</option></select></div>
        <div class="form-section-lbl" style="margin-top:16px">Nominee Information</div>
        <div class="form-2">
          <div class="form-row"><label class="form-lbl">Nominee Full Name *</label><input class="form-inp" id="nom-name" type="text" placeholder="Full name as per IEM membership"/></div>
          <div class="form-row"><label class="form-lbl">Member ID</label><input class="form-inp" id="nom-id" type="text" placeholder="YES-STU-2024-XXXX"/></div>
        </div>
        <div class="form-2">
          <div class="form-row"><label class="form-lbl">Branch / Institution</label><input class="form-inp" id="nom-branch" type="text" placeholder="e.g. YES UTM Johor"/></div>
          <div class="form-row"><label class="form-lbl">Email</label><input class="form-inp" id="nom-email" type="email" placeholder="nominee@email.com"/></div>
        </div>
        <div class="form-section-lbl" style="margin-top:16px">Supporting Statement</div>
        <div class="form-row"><label class="form-lbl">Why do you nominate this person? *</label><textarea class="form-ta" id="nom-reason" placeholder="Describe their achievements and contributions… (min. 100 words)" style="min-height:100px"></textarea></div>
        <div class="form-2">
          <div class="form-row"><label class="form-lbl">Your Name *</label><input class="form-inp" id="nom-from" type="text" placeholder="Your full name"/></div>
          <div class="form-row"><label class="form-lbl">Relationship to Nominee</label><input class="form-inp" id="nom-rel" type="text" placeholder="e.g. Branch Vice Chair"/></div>
        </div>
        <div class="form-row" style="margin-top:4px"><label class="form-lbl">Overall Rating</label>
          <div class="star-rating" id="nomStars" onmouseleave="resetStarHover()">
            <span onclick="setRating(1)" onmouseover="hoverStar(1)">★</span>
            <span onclick="setRating(2)" onmouseover="hoverStar(2)">★</span>
            <span onclick="setRating(3)" onmouseover="hoverStar(3)">★</span>
            <span onclick="setRating(4)" onmouseover="hoverStar(4)">★</span>
            <span onclick="setRating(5)" onmouseover="hoverStar(5)">★</span>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn-ghost" onclick="document.getElementById('nominateModal').classList.remove('open')">Cancel</button>
        <button class="btn-primary" onclick="submitNomination()">Submit Nomination</button>
      </div>
    </div>
  </div>

  {{-- Apply Modal --}}
  <div class="modal-overlay" id="applyModal" onclick="if(event.target===this)this.classList.remove('open')">
    <div class="modal" style="width:580px">
      <div class="modal-head"><h3>Apply for Award</h3><button class="modal-close" onclick="document.getElementById('applyModal').classList.remove('open')">×</button></div>
      <div class="modal-body">
        <div class="form-row"><label class="form-lbl">Award Category *</label><select class="form-sel" id="app-cat"><option>Young Engineer Award</option><option>YES Leadership Award</option><option>SDG Leadership Award</option><option>Event of the Year</option></select></div>
        <div class="form-section-lbl" style="margin-top:16px">Applicant Details</div>
        <div class="form-2">
          <div class="form-row"><label class="form-lbl">Full Name *</label><input class="form-inp" id="app-name" type="text" placeholder="Ahmad Razif Hakim"/></div>
          <div class="form-row"><label class="form-lbl">Member ID</label><input class="form-inp" id="app-id" type="text" placeholder="YES-STU-2024-4821"/></div>
        </div>
        <div class="form-2">
          <div class="form-row"><label class="form-lbl">Branch</label><input class="form-inp" id="app-branch" type="text" value="YES UTM Johor"/></div>
          <div class="form-row"><label class="form-lbl">Current Role</label><input class="form-inp" id="app-role" type="text" placeholder="e.g. Branch Chair"/></div>
        </div>
        <div class="form-section-lbl" style="margin-top:16px">Personal Statement</div>
        <div class="form-row"><label class="form-lbl">Why are you applying? *</label><textarea class="form-ta" id="app-statement" placeholder="Describe your achievements and contributions to YES IEM… (min. 150 words)" style="min-height:110px"></textarea></div>
        <div class="form-2">
          <div class="form-row"><label class="form-lbl">Key Achievement 1</label><input class="form-inp" id="app-a1" type="text" placeholder="e.g. Organised 7 branch events"/></div>
          <div class="form-row"><label class="form-lbl">Key Achievement 2</label><input class="form-inp" id="app-a2" type="text" placeholder="e.g. 18 volunteer hours logged"/></div>
        </div>
        <div class="form-row"><label class="form-lbl">Supporting Documents</label>
          <div class="chart-upload-zone" onclick="document.getElementById('appDocsInput').click()">
            <input type="file" id="appDocsInput" accept=".pdf,.doc,.docx" multiple onchange="handleAppDocs(this)"/>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5" style="margin-bottom:8px"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
            <div style="font-size:12px;color:var(--grey)">Upload CV, recommendation letter, or portfolio<br><span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px">PDF · DOC — max 10 MB each</span></div>
          </div>
          <div id="appDocList" style="margin-top:8px;display:flex;flex-direction:column;gap:5px"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn-ghost" onclick="document.getElementById('applyModal').classList.remove('open')">Cancel</button>
        <button class="btn-primary" onclick="submitApplication()">Submit Application</button>
      </div>
    </div>
  </div>

  {{-- Vote Modal --}}
  <div class="modal-overlay" id="voteModal" onclick="if(event.target===this)this.classList.remove('open')">
    <div class="modal" style="width:560px">
      <div class="modal-head"><h3 id="voteModalTitle">Vote</h3><button class="modal-close" onclick="document.getElementById('voteModal').classList.remove('open')">×</button></div>
      <div class="modal-body">
        <div style="font-size:12px;color:var(--grey);margin-bottom:18px;line-height:1.65">Each member may vote <strong>once</strong>. Results announced at the Awards Ceremony on 28 June 2025.</div>
        <div class="vote-grid" id="voteGrid"></div>
        <div id="voteConfirm" style="display:none;margin-top:16px;padding:14px 16px;background:#d1fae5;border:1px solid rgba(6,95,70,.2);font-size:12px;color:#065f46;font-weight:600;text-align:center">✓ Your vote has been recorded. Thank you!</div>
      </div>
      <div class="modal-footer" id="voteFooter">
        <button class="btn-ghost" onclick="document.getElementById('voteModal').classList.remove('open')">Close</button>
        <button class="btn-primary" id="voteSubmitBtn" onclick="castVote()">Confirm Vote</button>
      </div>
    </div>
  </div>

  {{-- Award Detail Modal --}}
  <div class="modal-overlay" id="awardDetailModal" onclick="if(event.target===this)this.classList.remove('open')">
    <div class="modal" style="width:540px">
      <div class="modal-head"><h3 id="adTitle">Award Details</h3><button class="modal-close" onclick="document.getElementById('awardDetailModal').classList.remove('open')">×</button></div>
      <div class="modal-body" id="adBody"></div>
      <div class="modal-footer" id="adFoot"></div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
let starRating=0,selectedVote=null,hasVoted=false;
const catMap={'young-engineer':'Young Engineer Award','sdg':'SDG Leadership Award','leadership':'YES Leadership Award','event':'Event of the Year','best-branch':'Best Student Branch'};

function openNominate(cat){if(cat){const sel=document.getElementById('nom-cat');if(sel&&catMap[cat])sel.value=catMap[cat];}document.getElementById('nominateModal').classList.add('open');}
function openApply(cat){if(cat){const sel=document.getElementById('app-cat');if(sel&&catMap[cat])sel.value=catMap[cat];}document.getElementById('applyModal').classList.add('open');}

const voteData={
  'best-branch':[{id:1,name:'YES UTM Johor',initials:'JB',color:'#1d4ed8',votes:89,percent:36},{id:2,name:'YES UPM Serdang',initials:'UP',color:'#7c3aed',votes:74,percent:30},{id:3,name:'YES UTP Perak',initials:'UT',color:'#065f46',votes:52,percent:21},{id:4,name:'YES UITM Johor',initials:'UI',color:'#9d174d',votes:32,percent:13}],
  'young-engineer':[{id:5,name:'Nurul Ain Binti Zain',initials:'NA',color:'#4c1d95',votes:45,percent:42},{id:6,name:'Ahmad Razif Hakim',initials:'AR',color:'#003366',votes:38,percent:36},{id:7,name:'Lee Kai Xin',initials:'LK',color:'#9d174d',votes:23,percent:22}],
  'event':[{id:8,name:'Eng. Innovation Hackathon 2025',initials:'EH',color:'#5b21b6',votes:61,percent:48},{id:9,name:'STEM Career Fair 2025',initials:'CF',color:'#1d4ed8',votes:43,percent:34},{id:10,name:'Mangrove Restoration Drive',initials:'MR',color:'#065f46',votes:23,percent:18}]
};

function openVote(type){
  const titles={'best-branch':'Best Student Branch — Vote','young-engineer':'Young Engineer Award — Vote','event':'Event of the Year — Vote'};
  document.getElementById('voteModalTitle').textContent=titles[type]||'Vote';
  const candidates=voteData[type]||[];
  selectedVote=null;hasVoted=false;
  document.getElementById('voteGrid').innerHTML=candidates.map(c=>`<div class="vote-card" id="vc-${c.id}" onclick="selectVote(${c.id})"><div class="vote-av" style="background:${c.color}">${c.initials}</div><div class="vote-name">${c.name}</div><div class="vote-bar-wrap"><div class="vote-bar"><div class="vote-bar-fill" style="width:${c.percent}%"></div></div><div class="vote-pct">${c.percent}% (${c.votes} votes)</div></div></div>`).join('');
  document.getElementById('voteConfirm').style.display='none';
  document.getElementById('voteSubmitBtn').style.display='inline-flex';
  document.getElementById('voteModal').classList.add('open');
}
function selectVote(id){if(hasVoted)return;selectedVote=id;document.querySelectorAll('.vote-card').forEach(c=>c.classList.remove('voted'));document.getElementById('vc-'+id)?.classList.add('voted');}
function castVote(){if(!selectedVote){showToast('Please select a candidate','danger');return;}hasVoted=true;document.getElementById('voteConfirm').style.display='block';document.getElementById('voteSubmitBtn').style.display='none';showToast('Vote cast successfully!','success');}

const awardDetails={
  'young-engineer':{title:'Young Engineer Award',icon:'🏆',ribbon:'linear-gradient(90deg,var(--gold),var(--gold-light))',desc:'Recognises YES members with outstanding achievement in engineering practice, innovation, research, or professional development.',criteria:['Active YES member for min. 6 months','Demonstrated engineering achievement','Minimum 1 recommendation letter','Portfolio or project documentation','Interview with judging panel (finalists)']},
  'best-branch':{title:'Best Student Branch',icon:'🎓',ribbon:'linear-gradient(90deg,var(--blue),#3b82f6)',desc:'The Best Student Branch Award celebrates the YES student section with the highest overall performance — event impact, membership growth, sustainability engagement, and community outreach.',criteria:['Min. 6 events organised','Positive membership growth','Active sustainability pledge','Volunteer hours documented','HQ submission report required']},
  'sdg':{title:'SDG Leadership Award',icon:'🌿',ribbon:'linear-gradient(90deg,var(--green),var(--green-a))',desc:'Honours individuals or branches making a measurable impact in advancing UN Sustainable Development Goals through engineering projects, volunteer work, or community programmes.',criteria:['SDG-aligned events or projects','Quantifiable community impact','Collaboration with external partners','Sustainability pledge active','Progress report required']},
  'leadership':{title:'YES Leadership Award',icon:'👑',ribbon:'linear-gradient(90deg,var(--amber),#fbbf24)',desc:'Recognises branch officers who have shown exemplary leadership, resulting in tangible growth, member engagement, and a positive culture within their YES student section.',criteria:['Branch officer for min. 1 term','Evidence of membership growth','Event quality and quantity','Peer testimonials','Self-assessment submission']},
  'innovation':{title:'Innovation Excellence Award',icon:'💡',ribbon:'linear-gradient(90deg,#7c3aed,#a78bfa)',desc:'Recognises groundbreaking engineering projects, research contributions, or technological innovations. Opens July 2025.',criteria:['Open to all YES members','Documented innovation or research','Evidence of real-world impact','Panel review of submission','Finalist presentation required']},
  'event':{title:'Event of the Year',icon:'📅',ribbon:'linear-gradient(90deg,#0ea5e9,#38bdf8)',desc:'Celebrating the most impactful YES branch event of the academic year, judged on attendance, organisation quality, community benefit, and innovation in format.',criteria:['Min. 50 attendees','Post-event report submitted','Attendee feedback collected','Photos / documentation provided','Nominated by branch or HQ']},
};

function openAwardDetail(type){
  const d=awardDetails[type];if(!d)return;
  document.getElementById('adTitle').textContent=d.title;
  document.getElementById('adBody').innerHTML=`<div style="background:${d.ribbon};height:4px;margin:-28px -28px 20px"></div><div style="text-align:center;font-size:40px;margin-bottom:14px">${d.icon}</div><div style="font-size:13px;color:#444;line-height:1.75;margin-bottom:18px">${d.desc}</div><div class="form-section-lbl">Eligibility Criteria</div><ul style="list-style:none;display:flex;flex-direction:column;gap:7px">${d.criteria.map(c=>`<li style="display:flex;align-items:flex-start;gap:8px;font-size:12px;color:var(--navy)"><span style="color:var(--gold);font-weight:700;flex-shrink:0">✓</span>${c}</li>`).join('')}</ul>`;
  document.getElementById('adFoot').innerHTML=`<button class="btn-ghost" onclick="document.getElementById('awardDetailModal').classList.remove('open')">Close</button><button class="btn-primary" onclick="document.getElementById('awardDetailModal').classList.remove('open');openNominate('${type}')">Nominate</button><button class="btn-primary" style="background:var(--gold);color:var(--navy-dark)" onclick="document.getElementById('awardDetailModal').classList.remove('open');openApply('${type}')">Apply</button>`;
  document.getElementById('awardDetailModal').classList.add('open');
}

function setRating(n){starRating=n;document.querySelectorAll('#nomStars span').forEach((s,i)=>s.classList.toggle('active',i<n));}
function hoverStar(n){document.querySelectorAll('#nomStars span').forEach((s,i)=>s.classList.toggle('active',i<n));}
function resetStarHover(){document.querySelectorAll('#nomStars span').forEach((s,i)=>s.classList.toggle('active',i<starRating));}
function submitNomination(){const name=document.getElementById('nom-name')?.value.trim();const reason=document.getElementById('nom-reason')?.value.trim();if(!name){showToast('Nominee name is required','danger');return;}if(!reason||reason.length<50){showToast('Please provide a more detailed reason','danger');return;}document.getElementById('nominateModal').classList.remove('open');showToast('Nomination submitted successfully!','success');}
function submitApplication(){const name=document.getElementById('app-name')?.value.trim();const statement=document.getElementById('app-statement')?.value.trim();if(!name){showToast('Your name is required','danger');return;}if(!statement||statement.length<50){showToast('Please write a more complete personal statement','danger');return;}document.getElementById('applyModal').classList.remove('open');showToast('Application submitted! You will be notified by email.','success');}
function handleAppDocs(input){const list=document.getElementById('appDocList');Array.from(input.files).forEach(f=>{const div=document.createElement('div');div.style.cssText='display:flex;align-items:center;gap:8px;padding:6px 10px;background:var(--off);border:1px solid var(--light);font-size:11px;color:var(--navy)';div.innerHTML=`<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg><span style="flex:1">${f.name}</span><span style="color:var(--grey)">${(f.size/1024).toFixed(0)} KB</span>`;list.appendChild(div);});}
</script>
@endsection
