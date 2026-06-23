@extends('public.layouts.app')

@section('title', 'Sustainability – YES Young Engineer Section | IEM Malaysia')

@push('styles')
<style>
.section-nav { position: sticky; top: 72px; z-index: 800; background: var(--white); border-bottom: 1px solid var(--light-grey); display: flex; gap: 32px; padding: 0 60px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
.section-nav a { display: flex; align-items: center; gap: 8px; padding: 16px 0; font-size: 12px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--grey); text-decoration: none; border-bottom: 3px solid transparent; transition: all .2s; }
.section-nav a:hover { color: var(--navy); }
.section-nav a.active { color: var(--navy); border-bottom-color: var(--gold); }
.section-nav-dot { width: 6px; height: 6px; background: var(--light-grey); border-radius: 50%; transition: background .2s; }
.section-nav a.active .section-nav-dot { background: var(--gold); }
.section-divider { width: 48px; height: 4px; background: var(--gold); margin: 20px 0 32px; }
.lead-text { font-size: 17px; color: #555; line-height: 1.9; max-width: 680px; margin-bottom: 52px; }
.initiative-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 52px; }
.main-card { background: linear-gradient(135deg, #0d4a2b, #1a6b3c); padding: 44px; margin-bottom: 16px; }
.main-card .big-icon { font-size: 40px; display: block; margin-bottom: 16px; }
.main-card h3 { font-family: 'Playfair Display', serif; font-size: 24px; color: var(--white); font-weight: 900; margin-bottom: 12px; }
.main-card p { font-size: 14px; color: rgba(255,255,255,0.75); line-height: 1.8; }
.stat-row { display: flex; gap: 3px; }
.stat-box { flex: 1; background: var(--navy); padding: 20px; text-align: center; }
.stat-box .num { font-family: 'Playfair Display', serif; font-size: 30px; font-weight: 900; color: var(--gold); display: block; line-height: 1; }
.stat-box .lbl { font-size: 10px; color: rgba(255,255,255,0.5); letter-spacing: 2px; text-transform: uppercase; margin-top: 6px; display: block; }
.body-text { font-size: 15px; color: var(--grey); line-height: 1.8; margin-bottom: 28px; }
.pillar-list { list-style: none; display: flex; flex-direction: column; gap: 20px; }
.pillar-list li { display: flex; gap: 16px; align-items: flex-start; }
.pillar-num { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 900; color: var(--light-grey); flex-shrink: 0; line-height: 1; margin-top: 2px; }
.pillar-text h4 { font-size: 15px; font-weight: 700; color: var(--navy); margin-bottom: 4px; }
.pillar-text p { font-size: 13px; color: var(--grey); line-height: 1.7; }
.pledge-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; }
.pledge-document { background: var(--offwhite); border-left: 4px solid var(--gold); padding: 40px; }
.doc-label { font-size: 9px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); margin-bottom: 20px; }
.pledge-document p { font-size: 15px; color: #444; line-height: 1.9; margin-bottom: 16px; font-style: italic; }
.sig-line { display: flex; align-items: center; gap: 16px; margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--light-grey); }
.sig-mark { width: 52px; height: 52px; background: var(--navy); display: flex; align-items: center; justify-content: center; }
.sig-mark span { font-family: 'Playfair Display', serif; font-size: 14px; font-weight: 900; color: var(--gold); }
.sig-info small { font-size: 10px; color: var(--grey); display: block; }
.sig-info strong { font-size: 13px; color: var(--navy); }
.pledge-aside h3 { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 900; color: var(--navy); margin-bottom: 28px; }
.pledge-commitments { list-style: none; display: flex; flex-direction: column; gap: 18px; }
.pledge-commitments li { display: flex; gap: 14px; align-items: flex-start; }
.pledge-check { width: 24px; height: 24px; background: #d1fae5; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px; }
.pledge-check svg { width: 12px; height: 12px; stroke: #1a6b3c; fill: none; stroke-width: 2.5; }
.pledge-commitments p { font-size: 14px; color: var(--grey); line-height: 1.7; }
.pledge-cta { margin-top: 28px; }
.declaration-hero-bar { background: var(--navy); padding: 28px 32px; display: flex; align-items: center; justify-content: space-between; gap: 24px; margin-bottom: 48px; flex-wrap: wrap; }
.declaration-hero-bar h3 { font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 900; color: var(--white); margin-bottom: 4px; }
.declaration-hero-bar p { font-size: 13px; color: rgba(255,255,255,0.55); }
.btn-gold-solid { background: var(--gold); color: var(--navy-dark); padding: 12px 24px; font-weight: 700; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; white-space: nowrap; transition: all .2s; }
.btn-gold-solid:hover { opacity: .88; }
.btn-gold-outline { border: 2px solid var(--gold); color: var(--gold); padding: 12px 24px; font-weight: 700; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; margin-left: 12px; transition: all .2s; }
.btn-gold-outline:hover { background: var(--gold); color: var(--navy-dark); }
.declaration-body { display: grid; grid-template-columns: 1fr 1fr; gap: 52px; }
.statement-block { margin-bottom: 32px; }
.statement-block h4 { font-size: 15px; font-weight: 700; color: var(--navy); margin-bottom: 10px; letter-spacing: .3px; }
.statement-block p { font-size: 14px; color: var(--grey); line-height: 1.8; }
.declaration-date { font-size: 12px; color: var(--grey); margin-top: 32px; padding-top: 20px; border-top: 1px solid var(--light-grey); }
.declaration-date span { font-weight: 700; color: var(--navy); }
.declaration-endorsements h3 { font-family: 'Playfair Display', serif; font-size: 20px; color: var(--navy); margin-bottom: 20px; }
.endorsement-card { background: var(--offwhite); padding: 24px; margin-bottom: 14px; border-left: 3px solid var(--gold); }
.endorsement-card .who { font-weight: 700; color: var(--navy); font-size: 15px; }
.endorsement-card .role { font-size: 12px; color: var(--grey); margin-bottom: 10px; }
.endorsement-card .quote { font-style: italic; font-size: 13.5px; color: #555; line-height: 1.7; }
.page-cta { background: var(--navy-dark); padding: 60px; display: flex; align-items: center; justify-content: space-between; gap: 32px; flex-wrap: wrap; }
.page-cta h2 { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 900; color: var(--white); margin-bottom: 8px; }
.page-cta p { font-size: 15px; color: rgba(255,255,255,0.65); max-width: 480px; line-height: 1.7; }
.cta-buttons { display: flex; align-items: center; flex-wrap: wrap; gap: 12px; }
</style>
@endpush

@section('content')

<div class="page-hero">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a><span>›</span>
    <span class="current">Sustainability</span>
  </div>
  <h1>Our Sustainability <em>Commitments</em></h1>
  <p class="page-hero-sub">YES – IEM Malaysia's formal framework for sustainable engineering practice — from grassroots initiatives to a binding declaration.</p>
</div>

<nav class="section-nav" id="sectionNav">
  <a href="#initiative" class="active" data-section="initiative"><span class="section-nav-dot"></span> Initiative</a>
  <a href="#pledge" data-section="pledge"><span class="section-nav-dot"></span> Pledge</a>
  <a href="#declaration" data-section="declaration"><span class="section-nav-dot"></span> Declaration</a>
</nav>

<section class="content-section" id="initiative">
  <div class="section-label">Section 01</div>
  <h2 class="section-title">Sustainability <em>Initiative</em></h2>
  <div class="section-divider"></div>
  <p class="lead-text reveal">YES Malaysia's Sustainability Initiative is our structured, multi-year programme to embed environmental responsibility into every layer of engineering education, practice, and community engagement.</p>
  <div class="initiative-grid">
    <div class="reveal reveal-delay-1">
      <div class="main-card">
        <span class="big-icon">🌿</span>
        <h3>A Greener Engineering Future</h3>
        <p>Launched in 2023, the YES Sustainability Initiative covers five pillars: carbon literacy, green design, community engineering, renewable energy access, and policy advocacy.</p>
      </div>
      <div class="stat-row">
        <div class="stat-box"><div class="num">30+</div><span class="lbl">Projects</span></div>
        <div class="stat-box"><div class="num">2,400</div><span class="lbl">Volunteers</span></div>
        <div class="stat-box"><div class="num">26</div><span class="lbl">States</span></div>
      </div>
    </div>
    <div class="reveal reveal-delay-2">
      <p class="body-text">The initiative operates through five strategic pillars, each designed to build a generation of engineers who understand — and are empowered to address — the sustainability challenges of our time.</p>
      <ul class="pillar-list">
        <li><div class="pillar-num">01</div><div class="pillar-text"><h4>Carbon Literacy &amp; Education</h4><p>Workshops that equip YES members with knowledge to calculate, reduce, and offset their engineering footprint.</p></div></li>
        <li><div class="pillar-num">02</div><div class="pillar-text"><h4>Green Design Integration</h4><p>Encouraging engineers to incorporate sustainable design principles — LEED, BREEAM, MS1525 — into all professional projects.</p></div></li>
        <li><div class="pillar-num">03</div><div class="pillar-text"><h4>Community &amp; Rural Engineering</h4><p>Deploying engineering skills to build resilient, clean-energy infrastructure in underserved communities.</p></div></li>
        <li><div class="pillar-num">04</div><div class="pillar-text"><h4>Renewable Energy Access</h4><p>Partnering with agencies and NGOs to accelerate solar, hydro, and biomass energy deployment in off-grid areas.</p></div></li>
        <li><div class="pillar-num">05</div><div class="pillar-text"><h4>Policy Advocacy</h4><p>Representing the youth engineering voice in national sustainability forums, contributing to Malaysia's Energy Transition Roadmap.</p></div></li>
      </ul>
    </div>
  </div>
</section>

<section class="content-section alt" id="pledge">
  <div class="section-label">Section 02</div>
  <h2 class="section-title">Sustainability <em>Pledge</em></h2>
  <div class="section-divider"></div>
  <p class="lead-text reveal">The YES Sustainability Pledge is a voluntary commitment made by our members and chapters — an engineer's personal promise to the planet.</p>
  <div class="pledge-layout">
    <div class="pledge-document reveal reveal-delay-1">
      <div class="doc-label">The YES Sustainability Pledge</div>
      <p>I, as a member of the Young Engineer Section of the Institution of Engineers Malaysia, pledge to uphold the principles of sustainable engineering in all my professional and academic pursuits.</p>
      <p>I commit to designing, building, and advocating for solutions that respect environmental boundaries, serve communities equitably, and protect the planet for future generations.</p>
      <p>I recognise that engineers bear a unique responsibility to translate scientific knowledge into real-world action — and I accept this responsibility with humility, purpose, and resolve.</p>
      <div class="sig-line">
        <div class="sig-mark"><span>YES</span></div>
        <div class="sig-info"><small>Endorsed by</small><strong>YES – IEM National Board, 2024</strong></div>
      </div>
    </div>
    <div class="pledge-aside reveal reveal-delay-2">
      <h3>What the Pledge Commits You To</h3>
      <ul class="pledge-commitments">
        <li><div class="pledge-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><p>Apply sustainable design principles in all professional engineering work and student projects.</p></li>
        <li><div class="pledge-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><p>Participate in at least one YES sustainability programme or volunteer event per year.</p></li>
        <li><div class="pledge-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><p>Advocate for green engineering standards within your institution or workplace.</p></li>
        <li><div class="pledge-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><p>Commit to continuous learning in sustainability, climate science, and green technology.</p></li>
      </ul>
      <div class="pledge-cta"><a href="#" class="btn-navy">Sign the Pledge →</a></div>
    </div>
  </div>
</section>

<section class="content-section" id="declaration">
  <div class="section-label">Section 03</div>
  <h2 class="section-title">Sustainability <em>Declaration</em></h2>
  <div class="section-divider"></div>
  <p class="lead-text reveal">The YES Malaysia Sustainability Declaration is our formal institutional statement of intent — adopted by the YES National Board and endorsed by all 26 chapter leaders in 2024.</p>
  <div class="declaration-hero-bar reveal">
    <div><h3>YES Malaysia Sustainability Declaration 2024</h3><p>Formally adopted at the YES National Board Meeting, Putrajaya, 14 September 2024.</p></div>
    <a href="#" class="btn-gold-solid">Download Declaration (PDF) ↓</a>
  </div>
  <div class="declaration-body">
    <div class="reveal reveal-delay-1">
      <div class="statement-block"><h4>Preamble</h4><p>The Young Engineer Section of IEM Malaysia acknowledges that climate change, biodiversity loss, and resource depletion represent the defining engineering challenges of this generation. We accept our responsibility to act.</p></div>
      <div class="statement-block"><h4>Our Commitment to Net-Zero</h4><p>YES Malaysia commits to supporting Malaysia's national net-zero target by 2050 through engineering education, community programmes, and policy engagement.</p></div>
      <div class="statement-block"><h4>Our Commitment to Equity</h4><p>We recognise that the transition to a sustainable economy must be just and inclusive. YES will ensure that sustainability programmes prioritise underserved communities.</p></div>
      <div class="statement-block"><h4>Our Commitment to Collaboration</h4><p>YES Malaysia will actively partner with government, industry, universities, and civil society to amplify our impact.</p></div>
      <div class="declaration-date">Adopted: <span>14 September 2024</span> &nbsp;|&nbsp; Signatories: <span>26 Chapter Chairs</span></div>
    </div>
    <div class="reveal reveal-delay-2">
      <div class="declaration-endorsements">
        <h3>Endorsed By</h3>
        <div class="endorsement-card"><div class="who">Dr. Ahmad Faizal Ibrahim</div><div class="role">YES National Chairman 2024–2025</div><p class="quote">"This declaration is not just a document — it is our generation's promise to the engineers who will come after us."</p></div>
        <div class="endorsement-card"><div class="who">Ir. Nurul Ain Zainudin</div><div class="role">YES Sustainability Committee Chair</div><p class="quote">"We have the tools, the talent, and now the mandate. Malaysian engineers will lead the transition to a greener ASEAN."</p></div>
        <div class="endorsement-card"><div class="who">Ir. Mohd Hafiz Rashid</div><div class="role">YES Sabah &amp; Sarawak Representative</div><p class="quote">"For our forests, our rivers, and our communities — we stand together on this declaration."</p></div>
      </div>
    </div>
  </div>
</section>

<div class="page-cta">
  <div>
    <h2>Ready to Join the Movement?</h2>
    <p>Sign the pledge, volunteer at a YES green event, or contact us to partner on a sustainability programme in your community.</p>
  </div>
  <div class="cta-buttons">
    <a href="#pledge" class="btn-gold-solid">Sign the Pledge</a>
    <a href="{{ route('sustainability-events') }}" class="btn-gold-outline">View Green Events</a>
  </div>
</div>

@endsection

@push('scripts')
<script>
const sections = ['initiative', 'pledge', 'declaration'];
const navLinks  = document.querySelectorAll('.section-nav a');
function updateActiveNav() {
  let current = 'initiative';
  sections.forEach(id => {
    const el = document.getElementById(id);
    if (el && window.scrollY >= el.offsetTop - 200) current = id;
  });
  navLinks.forEach(a => a.classList.toggle('active', a.dataset.section === current));
}
window.addEventListener('scroll', updateActiveNav, { passive: true });
updateActiveNav();
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const el = document.getElementById(a.getAttribute('href').slice(1));
    if (el) { e.preventDefault(); el.scrollIntoView({ behavior: 'smooth' }); }
  });
});
</script>
@endpush
