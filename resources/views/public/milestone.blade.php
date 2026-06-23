@extends('public.layouts.app')

@section('title', 'Milestones – YES Young Engineer Section | IEM Malaysia')

@push('styles')
<style>
.decade-filter { background: var(--offwhite); padding: 0 60px; display: flex; gap: 0; border-bottom: 2px solid var(--light-grey); overflow-x: auto; position: sticky; top: 72px; z-index: 900; }
.decade-btn { padding: 18px 28px; font-size: 13px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--grey); background: none; border: none; border-bottom: 3px solid transparent; cursor: pointer; transition: all .2s; white-space: nowrap; font-family: 'DM Sans', sans-serif; }
.decade-btn:hover { color: var(--navy); }
.decade-btn.active { color: var(--navy); border-bottom-color: var(--gold); }
.timeline-wrapper { padding: 80px 60px; max-width: 1100px; margin: 0 auto; }
.timeline { position: relative; }
.timeline::before { content: ''; position: absolute; left: 50%; top: 0; bottom: 0; width: 2px; background: linear-gradient(180deg,var(--gold) 0%,rgba(200,168,75,0.15) 100%); transform: translateX(-50%); }
.decade-group { margin-bottom: 72px; display: none; }
.decade-group.visible { display: block; }
.decade-heading { text-align: center; position: relative; margin-bottom: 52px; }
.decade-heading::before { content: ''; position: absolute; left: 50%; top: 50%; transform: translate(-50%,-50%); width: 120px; height: 1px; background: var(--gold); }
.decade-heading span { background: var(--white); position: relative; z-index: 1; font-family: 'Playfair Display', serif; font-size: 48px; font-weight: 900; color: var(--light-grey); padding: 0 16px; }
.milestone-item { display: grid; grid-template-columns: 1fr 60px 1fr; align-items: start; margin-bottom: 52px; }
.ms-content { padding: 0 36px; }
.ms-center { display: flex; flex-direction: column; align-items: center; padding-top: 8px; }
.ms-dot { width: 18px; height: 18px; background: var(--gold); border-radius: 50%; border: 3px solid var(--white); box-shadow: 0 0 0 3px var(--gold); flex-shrink: 0; position: relative; z-index: 2; transition: transform .3s; }
.milestone-item:hover .ms-dot { transform: scale(1.4); box-shadow: 0 0 0 5px rgba(200,168,75,0.3); }
.ms-card { background: var(--white); border: 1px solid var(--light-grey); padding: 28px; transition: all .35s; position: relative; overflow: hidden; }
.ms-card::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: var(--gold); transform: scaleX(0); transition: transform .35s; }
.milestone-item:hover .ms-card { box-shadow: 0 16px 48px rgba(0,31,69,0.1); transform: translateY(-4px); border-color: rgba(200,168,75,0.3); }
.milestone-item:hover .ms-card::after { transform: scaleX(1); }
.ms-card.featured { border-color: var(--gold); background: var(--navy); }
.ms-card.featured::after { transform: scaleX(1); background: var(--gold-light); }
.ms-year { font-family: 'Playfair Display', serif; font-size: 38px; font-weight: 900; color: var(--gold); line-height: 1; margin-bottom: 8px; display: block; }
.ms-card.featured .ms-year { color: var(--gold-light); }
.ms-tag { display: inline-block; font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 4px 10px; margin-bottom: 12px; }
.ms-tag.founding { background: var(--gold); color: var(--navy-dark); }
.ms-tag.achievement { background: var(--navy); color: var(--gold); }
.ms-tag.expansion { background: #1a6b3c; color: #a8e6c1; }
.ms-tag.event { background: #4a1a6b; color: #c4a8e6; }
.ms-tag.international { background: #6b1a1a; color: #e6a8a8; }
.ms-card.featured .ms-tag.founding { background: var(--gold-light); color: var(--navy-dark); }
.ms-card h3 { font-size: 18px; font-weight: 700; color: var(--navy); margin-bottom: 8px; line-height: 1.3; }
.ms-card.featured h3 { color: var(--white); }
.ms-card p { font-size: 13.5px; color: var(--grey); line-height: 1.75; }
.ms-card.featured p { color: rgba(255,255,255,0.7); }
.milestone-item:nth-child(odd) .ms-card { text-align: right; }
.milestone-item:nth-child(odd) .ms-tag { float: right; }
</style>
@endpush

@section('content')

<div class="page-hero">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a><span>›</span>
    <a href="{{ route('who-we-are') }}">About Us</a><span>›</span>
    <span class="current">Milestones</span>
  </div>
  <h1>Our <em>Milestones</em></h1>
  <p class="page-hero-sub">Over 38 years of shaping Malaysia's engineering landscape — a journey of growth, achievement, and enduring impact.</p>
</div>

<div class="decade-filter">
  <button class="decade-btn active" onclick="filterDecade('all', this)">All</button>
  <button class="decade-btn" onclick="filterDecade('2020s', this)">2020s</button>
  <button class="decade-btn" onclick="filterDecade('2010s', this)">2010s</button>
  <button class="decade-btn" onclick="filterDecade('2000s', this)">2000s</button>
  <button class="decade-btn" onclick="filterDecade('1990s', this)">1990s</button>
  <button class="decade-btn" onclick="filterDecade('1980s', this)">1980s</button>
</div>

<div class="timeline-wrapper">
  <div class="timeline">

    <div class="decade-group visible" data-decade="2020s">
      <div class="decade-heading"><span>2020s</span></div>
      <div class="milestone-item reveal">
        <div></div><div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-content"><div class="ms-card featured"><span class="ms-year">2024</span><span class="ms-tag founding">Present</span><h3>YES AI &amp; Sustainability Programme</h3><p>YES launched its most ambitious programme to date — an AI-integrated sustainability curriculum equipping young Malaysian engineers with tools to build a greener, smarter future.</p></div></div>
      </div>
      <div class="milestone-item reveal">
        <div class="ms-content"><div class="ms-card"><span class="ms-year">2022</span><span class="ms-tag expansion">Expansion</span><h3>26 Active Branches &amp; 12,000 Members</h3><p>YES reached its highest-ever membership of 12,000 active members and 26 operational state branches — the most expansive footprint in YES history.</p></div></div>
        <div class="ms-center"><div class="ms-dot"></div></div><div></div>
      </div>
      <div class="milestone-item reveal">
        <div></div><div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-content"><div class="ms-card"><span class="ms-year">2020</span><span class="ms-tag achievement">Achievement</span><h3>Digital Pivot — Virtual Programmes</h3><p>YES rapidly transformed its physical events into virtual formats, maintaining full engagement with over 8,000 online programme participants.</p></div></div>
      </div>
    </div>

    <div class="decade-group visible" data-decade="2010s">
      <div class="decade-heading"><span>2010s</span></div>
      <div class="milestone-item reveal">
        <div class="ms-content"><div class="ms-card"><span class="ms-year">2019</span><span class="ms-tag achievement">Achievement</span><h3>Industry 4.0 Taskforce Established</h3><p>YES formed a dedicated taskforce to prepare young engineers for the digital transformation era — AI, IoT, robotics, and smart manufacturing.</p></div></div>
        <div class="ms-center"><div class="ms-dot"></div></div><div></div>
      </div>
      <div class="milestone-item reveal">
        <div></div><div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-content"><div class="ms-card"><span class="ms-year">2017</span><span class="ms-tag event">Event</span><h3>30th Anniversary Gala</h3><p>YES celebrated its 30th anniversary with a national gala attended by over 1,500 members, alumni, industry leaders, and government representatives.</p></div></div>
      </div>
      <div class="milestone-item reveal">
        <div class="ms-content"><div class="ms-card"><span class="ms-year">2015</span><span class="ms-tag achievement">Achievement</span><h3>YES Green Engineering Initiative</h3><p>YES launched its sustainability arm, embedding environmental responsibility into its programmes — green engineering workshops, river rehabilitation drives, and outreach camps.</p></div></div>
        <div class="ms-center"><div class="ms-dot"></div></div><div></div>
      </div>
      <div class="milestone-item reveal">
        <div></div><div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-content"><div class="ms-card"><span class="ms-year">2012</span><span class="ms-tag expansion">Expansion</span><h3>University Student Chapters Launched</h3><p>YES formalised its university outreach through student chapters across 25 Malaysian universities.</p></div></div>
      </div>
    </div>

    <div class="decade-group visible" data-decade="2000s">
      <div class="decade-heading"><span>2000s</span></div>
      <div class="milestone-item reveal">
        <div class="ms-content"><div class="ms-card"><span class="ms-year">2009</span><span class="ms-tag international">International</span><h3>ASEAN Young Engineers Summit Co-Hosted</h3><p>Malaysia co-hosted the ASEAN Young Engineers Summit in Kuala Lumpur, bringing together young engineering leaders from 10 ASEAN nations.</p></div></div>
        <div class="ms-center"><div class="ms-dot"></div></div><div></div>
      </div>
      <div class="milestone-item reveal">
        <div></div><div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-content"><div class="ms-card"><span class="ms-year">2007</span><span class="ms-tag event">Event</span><h3>YES Excellence Awards Introduced</h3><p>The inaugural YES Excellence Awards recognised outstanding young engineers and student chapters for their contributions across Malaysia.</p></div></div>
      </div>
      <div class="milestone-item reveal">
        <div class="ms-content"><div class="ms-card"><span class="ms-year">2004</span><span class="ms-tag achievement">Achievement</span><h3>10,000 Members Milestone</h3><p>YES reached 10,000 registered members — the largest youth engineering organisation in Malaysia.</p></div></div>
        <div class="ms-center"><div class="ms-dot"></div></div><div></div>
      </div>
      <div class="milestone-item reveal">
        <div></div><div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-content"><div class="ms-card"><span class="ms-year">2001</span><span class="ms-tag expansion">Expansion</span><h3>East Malaysia Branches Established</h3><p>YES extended its reach to Sabah and Sarawak, completing the nationwide coverage with 18 active branches.</p></div></div>
      </div>
    </div>

    <div class="decade-group visible" data-decade="1990s">
      <div class="decade-heading"><span>1990s</span></div>
      <div class="milestone-item reveal">
        <div class="ms-content"><div class="ms-card"><span class="ms-year">1998</span><span class="ms-tag international">International</span><h3>First CAFEO Participation</h3><p>YES officially represented Malaysia at the Conference of ASEAN Federation of Engineering Organisations (CAFEO), marking YES's debut on the regional stage.</p></div></div>
        <div class="ms-center"><div class="ms-dot"></div></div><div></div>
      </div>
      <div class="milestone-item reveal">
        <div></div><div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-content"><div class="ms-card"><span class="ms-year">1995</span><span class="ms-tag event">Event</span><h3>NATSUM Launched</h3><p>The National Student Summit (NATSUM) was inaugurated as YES's flagship student event — connecting final-year engineering undergraduates with industry mentors at scale.</p></div></div>
      </div>
      <div class="milestone-item reveal">
        <div class="ms-content"><div class="ms-card"><span class="ms-year">1992</span><span class="ms-tag expansion">Expansion</span><h3>First State Branches Formed</h3><p>YES expanded beyond KL with the establishment of the first state branches in Penang, Johor, and Perak.</p></div></div>
        <div class="ms-center"><div class="ms-dot"></div></div><div></div>
      </div>
    </div>

    <div class="decade-group visible" data-decade="1980s">
      <div class="decade-heading"><span>1980s</span></div>
      <div class="milestone-item reveal">
        <div></div><div class="ms-center"><div class="ms-dot"></div></div>
        <div class="ms-content"><div class="ms-card"><span class="ms-year">1989</span><span class="ms-tag achievement">Achievement</span><h3>First National Convention</h3><p>YES held its inaugural National Young Engineers Convention in Kuala Lumpur, attracting over 400 participants.</p></div></div>
      </div>
      <div class="milestone-item reveal">
        <div class="ms-content"><div class="ms-card featured"><span class="ms-year">1987</span><span class="ms-tag founding">Founding</span><h3>YES – IEM Established</h3><p>The Young Engineer Section was officially established under the Institution of Engineers Malaysia (IEM), creating a dedicated platform for engineering professionals under 35.</p></div></div>
        <div class="ms-center"><div class="ms-dot"></div></div><div></div>
      </div>
    </div>

  </div>
</div>

@endsection

@push('scripts')
<script>
function filterDecade(decade, btn) {
  document.querySelectorAll('.decade-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('.decade-group').forEach(g => {
    g.classList.toggle('visible', decade === 'all' || g.dataset.decade === decade);
  });
}
</script>
@endpush
