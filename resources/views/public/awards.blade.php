@extends('public.layouts.app')

@section('title', 'Awards – YES Young Engineer Section | IEM Malaysia')

@push('styles')
<style>
:root {
  --off: var(--offwhite);
  --light: var(--light-grey);
  --gold-dim: rgba(200,168,75,0.12);
  --green: #22c55e;
  --green-a: #16a34a;
  --amber: #f59e0b;
  --amber-l: rgba(245,158,11,0.1);
  --navy-mid: #002a5c;
}
.hero { background: var(--navy-dark); padding: 52px 60px; display: flex; flex-direction: column; align-items: flex-start; position: relative; overflow: hidden; }
.hero::before { content: ''; position: absolute; top: -80px; right: -80px; width: 600px; height: 600px; border-radius: 50%; background: radial-gradient(circle, rgba(200,168,75,0.06) 0%, transparent 70%); pointer-events: none; }
.hero-eyebrow { font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); margin-bottom: 12px; }
.hero-title { font-family: 'Playfair Display', serif; font-size: clamp(32px, 4vw, 52px); font-weight: 900; color: var(--white); line-height: 1.1; margin-bottom: 12px; }
.hero-title em { color: var(--gold); font-style: normal; }
.hero-sub { font-size: 16px; color: rgba(255,255,255,0.65); line-height: 1.7; max-width: 560px; margin-bottom: 36px; }
.hero-stats { display: flex; gap: 36px; flex-wrap: wrap; }
.hs { }
.hs-val { font-family: 'Playfair Display', serif; font-size: 42px; font-weight: 900; color: var(--gold); line-height: 1; }
.hs-lbl { font-size: 11px; color: rgba(255,255,255,0.5); letter-spacing: 2px; text-transform: uppercase; margin-top: 4px; }
.breadcrumb-bar { padding: 12px 60px; background: var(--off); border-bottom: 1px solid var(--light); display: flex; align-items: center; gap: 8px; font-size: 12px; letter-spacing: .5px; }
.breadcrumb-bar a { color: var(--grey); text-decoration: none; transition: color .2s; }
.breadcrumb-bar a:hover { color: var(--navy); }
.breadcrumb-bar span { color: var(--light-grey); }
.anchor-nav { position: sticky; top: 72px; z-index: 800; background: var(--white); border-bottom: 1px solid var(--light); }
.anchor-inner { display: flex; gap: 0; padding: 0 60px; overflow-x: auto; }
.an-link { padding: 16px 20px; font-size: 12px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--grey); text-decoration: none; border-bottom: 3px solid transparent; white-space: nowrap; transition: all .2s; }
.an-link:hover { color: var(--navy); }
.an-link.active { color: var(--navy); border-bottom-color: var(--gold); }
.section { padding: 72px 0; background: var(--off); }
.section:nth-child(even) { background: var(--white); }
.container { max-width: 1140px; margin: 0 auto; padding: 0 60px; }
.section-eyebrow { font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); margin-bottom: 8px; }
.section-title { font-family: 'Playfair Display', serif; font-size: clamp(26px, 2.8vw, 38px); color: var(--navy); font-weight: 900; line-height: 1.15; margin-bottom: 12px; }
.section-title em { color: var(--gold); font-style: normal; }
.section-sub { font-size: 14px; color: var(--grey); line-height: 1.8; max-width: 580px; }
.announcement { background: var(--navy); padding: 20px 24px; display: flex; align-items: flex-start; gap: 16px; margin-bottom: 36px; }
.ann-icon { width: 36px; height: 36px; background: rgba(200,168,75,0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.ann-icon svg { width: 18px; height: 18px; stroke: var(--gold); fill: none; stroke-width: 2; }
.ann-label { font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--gold); margin-bottom: 4px; }
.ann-msg { font-size: 13.5px; color: rgba(255,255,255,0.85); line-height: 1.6; }
.ann-sub { font-size: 11px; color: rgba(255,255,255,0.4); margin-top: 4px; }
.leaderboard { border: 1px solid var(--light); }
.lb-head { display: grid; grid-template-columns: 80px 1fr 100px 200px 120px; gap: 0; padding: 10px 20px; background: var(--navy-dark); font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.45); }
.lb-row { display: grid; grid-template-columns: 80px 1fr 100px 200px 120px; gap: 0; padding: 16px 20px; border-bottom: 1px solid var(--light); align-items: center; background: var(--white); transition: background .15s; }
.lb-row:last-child { border-bottom: none; }
.lb-row:hover { background: var(--off); }
.lb-row.gold-row { background: linear-gradient(90deg, rgba(200,168,75,0.04) 0%, transparent 60%); }
.lb-rank { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 900; color: var(--light-grey); }
.lb-medal { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; }
.lb-pts { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 900; color: var(--gold); line-height: 1; }
.lb-pts-lbl { font-size: 9px; color: var(--grey); text-transform: uppercase; letter-spacing: 1px; }
.lb-chapter-name { font-size: 13px; font-weight: 700; color: var(--navy); }
.lb-chapter-uni { font-size: 11px; color: var(--grey); margin-top: 2px; }
.lb-awards-cell { display: flex; flex-wrap: wrap; gap: 4px; }
.lb-badge { font-size: 9px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; padding: 3px 9px; }
.lb-badge.badge-gold { background: var(--gold); color: var(--navy-dark); }
.lb-badge.badge-silver { background: #e5e7eb; color: #374151; }
.lb-badge.badge-cert { background: var(--navy-dark); color: var(--gold); }
.cat-tabs { display: flex; gap: 6px; flex-wrap: wrap; }
.ctab { padding: 7px 14px; font-size: 11px; font-weight: 600; letter-spacing: .5px; text-transform: uppercase; color: var(--grey); background: var(--off); border: 1px solid var(--light); cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; }
.ctab:hover { color: var(--navy); border-color: var(--navy); }
.ctab.active { background: var(--navy); color: var(--gold); border-color: var(--navy); }
.award-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 2px; }
.award-card { background: var(--white); border: 1px solid var(--light); padding: 28px; position: relative; overflow: hidden; transition: all .3s; }
.award-card:hover { box-shadow: 0 12px 40px rgba(0,31,69,0.1); transform: translateY(-3px); }
.award-card-bar { position: absolute; top: 0; left: 0; right: 0; height: 3px; }
.award-icon { width: 48px; height: 48px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; }
.award-icon svg { width: 22px; height: 22px; fill: none; stroke: currentColor; stroke-width: 2; }
.award-name { font-size: 16px; font-weight: 700; color: var(--navy); margin-bottom: 10px; }
.award-desc { font-size: 13px; color: var(--grey); line-height: 1.75; margin-bottom: 16px; }
.award-pts { display: inline-flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 700; color: var(--gold); letter-spacing: .5px; }
.winners-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; }
.winner-card { background: var(--white); border: 1px solid var(--light); display: flex; overflow: hidden; }
.winner-year { background: var(--navy); padding: 20px 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; width: 68px; }
.winner-year { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 900; color: var(--gold); writing-mode: vertical-rl; text-orientation: mixed; }
.winner-content { padding: 20px; }
.winner-award { font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--gold); margin-bottom: 6px; }
.winner-chapter { font-size: 14px; font-weight: 700; color: var(--navy); margin-bottom: 3px; }
.winner-uni { font-size: 12px; color: var(--grey); }
</style>
@endpush

@section('content')

<div class="hero">
  <div class="hero-eyebrow">Excellence &amp; Recognition</div>
  <h1 class="hero-title">Student Chapter <em>Awards</em></h1>
  <p class="hero-sub">Recognising the outstanding contributions of YES student chapters across Malaysian universities. Awards are announced annually at the National Student Summit (NATSUM).</p>
  <div class="hero-stats">
    <div class="hs"><div class="hs-val">{{ $categories->count() }}</div><div class="hs-lbl">Award Categories</div></div>
    <div class="hs"><div class="hs-val">{{ $categories->flatMap->nominations->count() }}</div><div class="hs-lbl">Total Nominees</div></div>
    <div class="hs"><div class="hs-val">{{ $categories->first()?->cycle_year ?? now()->year }}</div><div class="hs-lbl">Current Cycle</div></div>
    <div class="hs"><div class="hs-val">NATSUM</div><div class="hs-lbl">Announcement</div></div>
  </div>
</div>

<div class="breadcrumb-bar">
  <a href="{{ route('home') }}">Home</a><span>›</span><span>Awards</span>
</div>

<div class="anchor-nav">
  <div class="anchor-inner">
    <a href="#leaderboard" class="an-link active">Leaderboard</a>
    <a href="#categories" class="an-link">Award Categories</a>
    <a href="#past-winners" class="an-link">Past Winners</a>
    <a href="#how-points-work" class="an-link">How Points Work</a>
  </div>
</div>

{{-- LEADERBOARD --}}
<section id="leaderboard" class="section">
  <div class="container">
    <div class="announcement">
      <div class="ann-icon"><svg viewBox="0 0 24 24"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg></div>
      <div class="ann-text">
        <div class="ann-label">{{ now()->year }} Award Cycle — In Progress</div>
        <div class="ann-msg">Points are accumulating. Final results will be announced at NATSUM {{ now()->year }}.</div>
        <div class="ann-sub">Last updated: {{ now()->format('j F Y') }}</div>
      </div>
    </div>
    <div style="margin-bottom:20px">
      <div class="section-eyebrow">{{ now()->year - 1 }}/{{ now()->year }} Academic Year</div>
      <h2 class="section-title">Chapter <em>Leaderboard</em></h2>
      <p class="section-sub">Rankings based on accumulated points from events, community service, sustainability initiatives, and YES collaboration activities.</p>
    </div>
    <div class="cat-tabs" style="margin-bottom:20px">
      <button class="ctab active" onclick="filterRegion('all',this)">All Regions</button>
      <button class="ctab" onclick="filterRegion('klang',this)">Klang Valley</button>
      <button class="ctab" onclick="filterRegion('northern',this)">Northern</button>
      <button class="ctab" onclick="filterRegion('southern',this)">Southern</button>
      <button class="ctab" onclick="filterRegion('east',this)">East Coast</button>
      <button class="ctab" onclick="filterRegion('eastm',this)">East Malaysia</button>
    </div>
    <div class="leaderboard reveal">
      <div class="lb-head"><span>Rank</span><span>Chapter</span><span style="text-align:center">Points</span><span>Awards Earned</span><span style="text-align:right">Region</span></div>
      <div class="lb-row gold-row" data-region="klang">
        <div style="display:flex;align-items:center;gap:10px"><span class="lb-rank">1</span><div class="lb-medal">🥇</div></div>
        <div><div class="lb-chapter-name">YES UTM Kuala Lumpur</div><div class="lb-chapter-uni">Universiti Teknologi Malaysia, KL Campus</div></div>
        <div><div class="lb-pts">1,240</div><div class="lb-pts-lbl">pts</div></div>
        <div class="lb-awards-cell"><span class="lb-badge badge-gold">Best Chapter</span><span class="lb-badge badge-cert">SDG Champion</span></div>
        <div style="text-align:right;font-size:11px;color:var(--grey)">Klang Valley</div>
      </div>
      <div class="lb-row" data-region="northern">
        <div style="display:flex;align-items:center;gap:10px"><span class="lb-rank">2</span><div class="lb-medal">🥈</div></div>
        <div><div class="lb-chapter-name">YES USM Penang</div><div class="lb-chapter-uni">Universiti Sains Malaysia, Engineering Campus</div></div>
        <div><div class="lb-pts">1,105</div><div class="lb-pts-lbl">pts</div></div>
        <div class="lb-awards-cell"><span class="lb-badge badge-silver">Runner-Up</span><span class="lb-badge badge-cert">Best Event</span></div>
        <div style="text-align:right;font-size:11px;color:var(--grey)">Northern</div>
      </div>
      <div class="lb-row" data-region="southern">
        <div style="display:flex;align-items:center;gap:10px"><span class="lb-rank">3</span><div class="lb-medal">🥉</div></div>
        <div><div class="lb-chapter-name">YES UTM Johor</div><div class="lb-chapter-uni">Universiti Teknologi Malaysia, Skudai</div></div>
        <div><div class="lb-pts">980</div><div class="lb-pts-lbl">pts</div></div>
        <div class="lb-awards-cell"><span class="lb-badge badge-cert">Most Active</span></div>
        <div style="text-align:right;font-size:11px;color:var(--grey)">Southern</div>
      </div>
      @foreach([
        [4,'YES UTP Perak','Universiti Teknologi PETRONAS','855','klang','Klang Valley'],
        [5,'YES UNITEN KL','Universiti Tenaga Nasional, KL Campus','810','klang','Klang Valley'],
        [6,'YES UiTM Shah Alam','Universiti Teknologi MARA, Shah Alam','760','klang','Klang Valley'],
        [7,'YES UMP Gambang','Universiti Malaysia Pahang','680','east','East Coast'],
        [8,'YES UNIMAS Sarawak','Universiti Malaysia Sarawak','640','eastm','East Malaysia'],
      ] as [$rank,$name,$uni,$pts,$region,$regionLabel])
      <div class="lb-row" data-region="{{ $region }}">
        <div style="display:flex;align-items:center;gap:10px"><span class="lb-rank">{{ $rank }}</span><div style="font-size:11px;font-weight:700;color:var(--grey)">{{ $rank }}</div></div>
        <div><div class="lb-chapter-name">{{ $name }}</div><div class="lb-chapter-uni">{{ $uni }}</div></div>
        <div><div class="lb-pts">{{ $pts }}</div><div class="lb-pts-lbl">pts</div></div>
        <div class="lb-awards-cell" style="color:var(--grey);font-size:12px">—</div>
        <div style="text-align:right;font-size:11px;color:var(--grey)">{{ $regionLabel }}</div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- AWARD CATEGORIES --}}
<section id="categories" class="section" style="background:#fff">
  <div class="container">
    <div style="margin-bottom:32px" class="reveal">
      <div class="section-eyebrow">Recognition Framework</div>
      <h2 class="section-title">Award <em>Categories</em></h2>
      <p class="section-sub">Six distinct awards recognise different dimensions of student chapter excellence throughout the year.</p>
    </div>
    <div class="award-grid reveal">
      @foreach([
        ['Best Chapter Award','Awarded to the chapter with the highest overall performance across events, membership, collaboration, and sustainability.','var(--gold)','var(--gold-dim)','var(--gold)','<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>','500 pts bonus'],
        ['Best Event Award','Recognises the chapter that organised the most impactful and well-attended event in collaboration with YES.','var(--navy)','rgba(0,31,69,.06)','var(--navy)','<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>','300 pts bonus'],
        ['SDG Champion Award','Awarded to the chapter with the highest engagement in sustainability-aligned activities and UN SDG-linked events.','#16a34a','rgba(22,163,74,.1)','#16a34a','<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>','250 pts bonus'],
        ['Most Active Chapter','Recognises the chapter with the most events organised and strongest member participation rate throughout the year.','#f59e0b','rgba(245,158,11,0.1)','#f59e0b','<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>','200 pts bonus'],
        ['Rising Chapter Award','For newly established chapters that demonstrate significant growth and improvement in their first two years with YES.','#7c3aed','#ede9fe','#5b21b6','<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>','150 pts bonus'],
        ['International Engagement','Recognises chapters that actively participated in CAFEO delegations or international engineering exchange programmes.','#0891b2','#e0f2fe','#0369a1','<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/>','200 pts bonus'],
      ] as [$name,$desc,$barColor,$iconBg,$iconColor,$icon,$pts])
      <div class="award-card">
        <div class="award-card-bar" style="background:{{ $barColor }}"></div>
        <div class="award-icon" style="background:{{ $iconBg }};color:{{ $iconColor }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $icon !!}</svg></div>
        <div class="award-name">{{ $name }}</div>
        <div class="award-desc">{{ $desc }}</div>
        <span class="award-pts"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg> {{ $pts }}</span>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- PAST WINNERS --}}
<section id="past-winners" class="section">
  <div class="container">
    <div style="margin-bottom:32px" class="reveal">
      <div class="section-eyebrow">Award History</div>
      <h2 class="section-title">Past <em>Winners</em></h2>
      <p class="section-sub">Best Chapter Award recipients from previous academic years, announced at each annual NATSUM ceremony.</p>
    </div>
    <div class="winners-grid reveal">
      @forelse($winners as $winner)
      <div class="winner-card">
        <div class="winner-year">{{ $winner->created_at?->year ?? $winner->category?->cycle_year ?? now()->year }}</div>
        <div class="winner-content">
          <div class="winner-award">{{ $winner->category?->name ?? 'Award' }}</div>
          <div class="winner-chapter">{{ $winner->display_name }}</div>
          <div class="winner-uni">{{ $winner->display_branch }}</div>
        </div>
      </div>
      @empty
      <p style="grid-column:span 3;color:var(--grey);font-size:14px;padding:20px 0">Past winner records will appear here once the first award cycle concludes.</p>
      @endforelse
    </div>
  </div>
</section>

{{-- HOW POINTS WORK --}}
<section id="how-points-work" class="section" style="background:#fff">
  <div class="container">
    <div style="margin-bottom:32px" class="reveal">
      <div class="section-eyebrow">Scoring System</div>
      <h2 class="section-title">How <em>Points Work</em></h2>
      <p class="section-sub">Points are assigned by YES administrators based on verified activity type and quality.</p>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px" class="reveal">
      <div style="background:var(--off);border:1px solid var(--light);padding:24px">
        <div style="font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);margin-bottom:16px;border-bottom:1px solid var(--light);padding-bottom:10px">Activity Point Values</div>
        @foreach([
          ['YES Collaboration Event','100–200 pts','Per approved event with YES co-branding'],
          ['Sustainability / SDG Activity','50–150 pts','Volunteer work, green campaigns, outreach'],
          ['Annual Report Submission','50 pts','On-time, complete, approved submission'],
          ['Org Chart Approved','25 pts','Verified org structure submitted and approved'],
          ['NATSUM Participation','100 pts','Delegation registered and attended'],
          ['CAFEO Delegation','150 pts','International conference participation'],
          ['Industry Talk / Webinar','30–80 pts','Based on attendance and speaker quality'],
        ] as [$act,$pts,$note])
        <div style="display:grid;grid-template-columns:1fr 80px;gap:8px;padding:10px 0;border-bottom:1px solid var(--light);align-items:start">
          <div><div style="font-size:12px;font-weight:600;color:var(--navy)">{{ $act }}</div><div style="font-size:11px;color:var(--grey);margin-top:2px">{{ $note }}</div></div>
          <div style="text-align:right;font-family:'Playfair Display',serif;font-size:14px;font-weight:700;color:var(--gold)">{{ $pts }}</div>
        </div>
        @endforeach
      </div>
      <div style="background:var(--off);border:1px solid var(--light);padding:24px">
        <div style="font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--grey);margin-bottom:16px;border-bottom:1px solid var(--light);padding-bottom:10px">Evaluation Timeline</div>
        @foreach([
          ['1','Submit Activity','Chapter submits event/activity through the YES portal after completion.','var(--navy)'],
          ['2','Admin Review','YES admin reviews submission documents and verifies activity details.','var(--gold)'],
          ['3','Points Assigned','Admin assigns appropriate point value; chapter is notified.','#16a34a'],
          ['4','Leaderboard Updated','Points appear on the public leaderboard within 3 working days.','var(--navy)'],
          ['5','NATSUM Ceremony','Final rankings confirmed; awards presented at the annual ceremony.','var(--gold)'],
        ] as [$num,$title,$desc,$color])
        <div style="display:flex;gap:12px;padding:12px 0;border-bottom:1px solid var(--light)">
          <div style="width:26px;height:26px;border-radius:50%;background:{{ $color }};display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;flex-shrink:0">{{ $num }}</div>
          <div><div style="font-size:12px;font-weight:700;color:var(--navy);margin-bottom:2px">{{ $title }}</div><div style="font-size:11px;color:var(--grey);line-height:1.55">{{ $desc }}</div></div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
function filterRegion(region, btn) {
  document.querySelectorAll('.lb-row').forEach(row => {
    row.style.display = (region === 'all' || row.dataset.region === region) ? '' : 'none';
  });
  document.querySelectorAll('.ctab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}
const sections = ['leaderboard','categories','past-winners','how-points-work'];
const observer = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      document.querySelectorAll('.an-link').forEach(l => l.classList.remove('active'));
      const link = document.querySelector(`.an-link[href="#${e.target.id}"]`);
      if (link) link.classList.add('active');
    }
  });
}, { rootMargin: '-30% 0px -60% 0px' });
sections.forEach(id => { const el = document.getElementById(id); if (el) observer.observe(el); });
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const el = document.getElementById(a.getAttribute('href').slice(1));
    if (el) { e.preventDefault(); el.scrollIntoView({ behavior: 'smooth' }); }
  });
});
</script>
@endpush
