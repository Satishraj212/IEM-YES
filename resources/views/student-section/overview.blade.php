@extends('student-section.layouts.app')
@section('title', 'Student Section')

@section('content')
  <div class="sec-header">
    <div>
      <div class="sh-eyebrow">{{ $branch->name }} · Academic Year {{ $branch->academic_year ?? now()->year }}</div>
      <div class="sh-title">Student Section</div>
      <div class="sh-sub">Overview of {{ $branch->name }} student branch activity and engagement.</div>
    </div>
    <a href="{{ route('student.events') }}" class="btn-primary" style="white-space:nowrap">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Create Event
    </a>
  </div>

  @if(session('success'))
  <div style="padding:12px 16px;background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;font-size:12px;font-weight:600;margin-bottom:16px">
    {{ session('success') }}
  </div>
  @endif

  {{-- Quick-nav stat cards --}}
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:24px">
    <a href="{{ route('student.events') }}" style="text-decoration:none">
      <div class="sc">
        <div class="sc-bar" style="background:var(--navy)"></div>
        <div class="sc-lbl">My Events</div>
        <div class="sc-val">{{ $totalEvents }}</div>
        <div class="sc-sub">{{ $publishedEvents }} published</div>
      </div>
    </a>
    <a href="{{ route('student.events') }}" style="text-decoration:none">
      <div class="sc">
        <div class="sc-bar" style="background:var(--green-a)"></div>
        <div class="sc-lbl">SDG Events</div>
        <div class="sc-val">{{ $sdgEvents }}</div>
        <div class="sc-sub">Sustainability-aligned</div>
      </div>
    </a>
    <a href="{{ route('student.budget') }}" style="text-decoration:none">
      <div class="sc">
        <div class="sc-bar" style="background:var(--amber)"></div>
        <div class="sc-lbl">Budget Requests</div>
        <div class="sc-val">{{ $budgetPending }}</div>
        <div class="sc-sub">pending review</div>
      </div>
    </a>
  </div>

  {{-- Row 1: Upcoming Events | Budget Requests --}}
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;align-items:start">
    <div class="panel" style="margin-bottom:0">
      <div class="ph">
        <div class="pt">Upcoming <em>Events</em></div>
        <a href="{{ route('student.events') }}" class="pa">Manage All →</a>
      </div>
      <div class="pb" style="padding:0">
        @if($upcomingEvents->isEmpty())
        <div style="padding:32px;text-align:center;font-size:12px;color:var(--grey)">
          No upcoming events. <a href="{{ route('student.events') }}" style="color:var(--navy);font-weight:600">Create one →</a>
        </div>
        @else
        <table class="ev-table">
          <thead><tr><th>Event</th><th>Date</th><th>Status</th></tr></thead>
          <tbody>
            @foreach($upcomingEvents as $ev)
            @php
              $catClass = [
                'Hackathon'=>'b-hackathon','Career Fair'=>'b-career','Volunteer'=>'b-volunteer',
                'Workshop'=>'b-workshop','Webinar'=>'b-webinar','SDG Event'=>'b-sdg',
                'Competition'=>'b-competition',
              ][$ev->category] ?? 'b-workshop';
              $pillClass = ['open'=>'pill-open','upcoming'=>'pill-upcoming','approved'=>'pill-approved'][$ev->status] ?? 'pill-draft';
            @endphp
            <tr>
              <td>
                <div class="ev-title">{{ $ev->title }}</div>
                <span class="ev-cat {{ $catClass }}">{{ $ev->category }}</span>
              </td>
              <td style="font-size:12px;color:var(--grey);white-space:nowrap">{{ $ev->date_display }}</td>
              <td><span class="pill {{ $pillClass }}">{{ ucfirst($ev->status) }}</span></td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @endif
      </div>
    </div>

    {{-- Budget Requests (row 1, right) --}}
    <div class="panel" style="margin-bottom:0">
      <div class="ph">
        <div class="pt">Budget <em>Requests</em></div>
        <a href="{{ route('student.budget') }}" class="pa">Manage All →</a>
      </div>
      <div class="pb" style="padding:0">
        @if($recentBudgets->isEmpty())
        <div style="padding:32px;text-align:center;font-size:12px;color:var(--grey)">
          No budget requests yet. <a href="{{ route('student.budget') }}" style="color:var(--navy);font-weight:600">New request →</a>
        </div>
        @else
        <table class="ev-table">
          <thead><tr><th>Event</th><th>Requested</th><th>Status</th></tr></thead>
          <tbody>
            @foreach($recentBudgets as $budget)
            @php
              [$bLabel, $bPill] = [
                'draft'      => ['Draft', 'pill-draft'],
                'review'     => ['Under Review', 'pill-review'],
                'approved'   => ['Approved', 'pill-approved'],
                'reimbursed' => ['Reimbursed', 'pill-approved'],
                'rejected'   => ['Returned', 'pill-closed'],
              ][$budget->stage] ?? ['—', 'pill-draft'];
            @endphp
            <tr>
              <td><div class="ev-title">{{ $budget->event?->title ?? 'Budget Request' }}</div></td>
              <td style="font-size:12px;color:var(--grey);white-space:nowrap">RM {{ number_format($budget->total_requested, 0) }}</td>
              <td><span class="pill {{ $bPill }}">{{ $bLabel }}</span></td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @endif
      </div>
    </div>
  </div>

  {{-- Needs Attention (full width) --}}
  <div class="panel">
    <div class="ph">
      <div class="pt">Needs <em>Attention</em></div>
      <span style="font-size:11px;color:var(--grey)">Items awaiting HQ or needing your action</span>
    </div>
    <div class="pb" style="padding:0">
      @forelse($attention as $item)
      @php
        $tagColor = ['Event'=>'b-workshop','Budget'=>'b-career','Report'=>'b-sdg'][$item['tag']] ?? 'b-workshop';
        $toneColor = $item['tone'] === 'action' ? 'var(--red)' : 'var(--amber)';
      @endphp
      <a href="{{ $item['url'] }}" style="display:flex;align-items:center;gap:12px;padding:12px 20px;border-bottom:1px solid var(--light);text-decoration:none">
        <span style="width:7px;height:7px;border-radius:50%;background:{{ $toneColor }};flex-shrink:0"></span>
        <div style="flex:1;min-width:0">
          <div class="ev-title" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $item['title'] }}</div>
          <div style="font-size:11px;color:{{ $toneColor }};font-weight:600;margin-top:1px">{{ $item['meta'] }}</div>
        </div>
        <span class="ev-cat {{ $tagColor }}">{{ $item['tag'] }}</span>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--grey)" stroke-width="2" style="flex-shrink:0"><polyline points="9 18 15 12 9 6"/></svg>
      </a>
      @empty
      <div style="padding:36px;text-align:center;font-size:12px;color:var(--grey)">
        ✓ All caught up — nothing needs your attention right now.
      </div>
      @endforelse
    </div>
  </div>

  {{-- Organisation Chart (full width) — browsable by academic year --}}
  <div class="panel" id="org-chart">
    <div class="ph">
      <div class="pt">Organisation <em>Chart</em></div>
      <div class="ph-actions" style="display:flex;align-items:center;gap:8px">
        <span style="font-size:11px;color:var(--grey)">Academic Year</span>
        <select id="ocYearSel" onchange="ocShowYear(this.value)" style="border:1px solid var(--light);background:#fff;padding:6px 10px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--navy);outline:none">
          @foreach($orgYears as $y)<option value="{{ $y }}" {{ $y===$orgDefaultYear ? 'selected' : '' }}>AY {{ $y }}</option>@endforeach
        </select>
      </div>
    </div>
    <div class="pb">

      @if($orgChartRequestedAt && !$currentChart)
      <div style="padding:10px 14px;background:#fef3c7;border:1px solid rgba(217,119,6,.25);font-size:12px;color:var(--amber);line-height:1.5;margin-bottom:14px"><strong>HQ has requested your organisation chart</strong> ({{ $orgChartRequestedAt->format('j M Y') }}). Pick a year and upload below.</div>
      @endif

      @foreach($orgYears as $y)
      @php $chart = $chartsByYear[$y] ?? null; @endphp
      <div class="oc-year" data-year="{{ $y }}" style="display:{{ $y===$orgDefaultYear ? 'block' : 'none' }}">

        @if($chart)
        @php
          $stage  = $chart->stage; // review | approved | returned
          $sMeta  = ['review'=>['Under Review','var(--amber)'],'approved'=>['Approved','var(--green)'],'returned'=>['Returned','var(--red)']][$stage];
          $locked = $stage === 'approved';
        @endphp
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;flex-wrap:wrap;gap:10px">
          <div>
            <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:4px">Chart · AY {{ $y }}</div>
            <span style="color:{{ $sMeta[1] }};border:1px solid {{ $sMeta[1] }};font-size:10px;font-weight:700;padding:3px 9px;text-transform:uppercase;letter-spacing:.5px">{{ $sMeta[0] }}</span>
          </div>
          @if($user->isBranchAdmin() && !$locked)
          <div style="display:flex;gap:8px">
            <button type="button" class="btn-secondary" style="font-size:10px;padding:7px 14px" onclick="toggleOcForm('{{ $y }}')">{{ $stage==='returned' ? '↻ Reinstate' : 'Replace' }}</button>
            <form method="POST" action="{{ route('student.org-chart.remove') }}" onsubmit="return confirm('Remove the {{ $y }} org chart?')">
              @csrf @method('DELETE')
              <input type="hidden" name="academic_year" value="{{ $y }}">
              <button type="submit" class="btn-secondary" style="font-size:10px;padding:7px 14px;color:var(--red);border-color:var(--red)">Remove</button>
            </form>
          </div>
          @endif
        </div>

        @if($stage==='returned')
        <div style="padding:10px 14px;background:#fdecea;border:1px solid rgba(192,57,43,.2);font-size:12px;color:var(--red);line-height:1.6;margin-bottom:12px"><strong>Returned by HQ.</strong> {{ $chart->review_comment ?: 'Please revise and re-upload your organisation chart.' }} Click <strong>Reinstate</strong> to upload a new version.</div>
        @elseif($stage==='approved')
        <div style="padding:10px 14px;background:#dcfce7;border:1px solid #bbf7d0;font-size:12px;color:#166534;line-height:1.6;margin-bottom:12px"><strong>Approved by HQ.</strong>@if($chart->review_comment) {{ $chart->review_comment }}@endif This chart is locked — it can't be replaced or removed.</div>
        @else
        <div style="font-size:11px;color:var(--grey);margin-bottom:12px">Submitted {{ $chart->created_at->format('j M Y') }} — awaiting HQ review.</div>
        @endif

        <div style="border:1px solid var(--light);overflow:hidden;max-height:480px;text-align:center;background:#f9f9f9">
          @if($chart->is_pdf)
          <div style="padding:48px;text-align:center;font-size:13px;color:var(--grey)">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="1.5" style="display:block;margin:0 auto 12px"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            PDF organisation chart.
            <a href="{{ $chart->url }}" target="_blank" style="color:var(--navy);font-weight:600;display:block;margin-top:8px">Open PDF →</a>
          </div>
          @else
          <img src="{{ $chart->url }}" alt="Organisation Chart {{ $y }}" style="max-width:100%;max-height:480px;object-fit:contain"/>
          @endif
        </div>

        @if($user->isBranchAdmin() && !$locked)
        <div id="ocFormWrap-{{ $y }}" style="display:none;margin-top:14px;padding:14px 16px;background:var(--off);border:1px solid var(--light)">
          @include('student-section.partials.org-chart-form', ['year' => $y, 'heading' => $stage==='returned' ? 'Reinstate — upload a new chart for AY '.$y : 'Replace the AY '.$y.' chart'])
        </div>
        @endif

        @else
        {{-- No chart for this year → upload form (or empty notice) --}}
        @if($user->isBranchAdmin())
        @include('student-section.partials.org-chart-form', ['year' => $y, 'heading' => 'Upload Organisation Chart · AY '.$y])
        @else
        <div style="padding:32px;text-align:center;font-size:12px;color:var(--grey)">No organisation chart for AY {{ $y }}.</div>
        @endif
        @endif

      </div>
      @endforeach
    </div>
  </div>
@endsection

@section('scripts')
<script>
// Switch the visible org-chart year panel.
function ocShowYear(year) {
  document.querySelectorAll('#org-chart .oc-year').forEach(el => {
    el.style.display = el.dataset.year === year ? 'block' : 'none';
  });
}
// Reveal the file upload form when Replace / Reinstate is clicked (per year).
function toggleOcForm(year) {
  const f = document.getElementById('ocFormWrap-' + year);
  if (!f) return;
  f.style.display = f.style.display === 'none' ? 'block' : 'none';
  if (f.style.display === 'block') f.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}
</script>
@endsection
