@extends('student-section.layouts.app')
@section('title', 'Reports & Analytics')

@section('content')
  <div class="sec-header">
    <div>
      <div class="sh-eyebrow">Branch Performance</div>
      <div class="sh-title">Reports &amp; <em>Analytics</em></div>
      <div class="sh-sub">Branch statistics for the {{ $branch->academic_year ?? 'current' }} academic year.</div>
    </div>
    <div style="display:flex;gap:9px;align-items:center;flex-wrap:wrap">
      <a class="btn-secondary" href="{{ route('student.reports.preview') }}">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Download Report
      </a>
    </div>
  </div>

  <div class="stat-row">
    <div class="sc"><div class="sc-bar" style="background:var(--gold)"></div><div class="sc-lbl">Events Organised</div><div class="sc-val">{{ $totalEvents }}</div><div class="sc-sub">All time</div></div>
    <div class="sc"><div class="sc-bar" style="background:var(--green-a)"></div><div class="sc-lbl">SDG Events</div><div class="sc-val">{{ $sdgEvents }}</div><div class="sc-sub">Sustainability-aligned</div></div>
    <div class="sc"><div class="sc-bar" style="background:var(--navy)"></div><div class="sc-lbl">Total Members</div><div class="sc-val">{{ $totalMembers }}</div><div class="sc-sub">Current register</div></div>
    <div class="sc"><div class="sc-bar" style="background:var(--amber)"></div><div class="sc-lbl">Published Events</div><div class="sc-val">{{ $eventsSummary['published'] }}</div><div class="sc-sub">Live on public site</div></div>
  </div>

  <div class="g2">
    <div class="panel">
      <div class="ph"><div class="pt">Events by <em>Category</em></div></div>
      <div class="pb">
        @php $palette = ['#5b21b6','#1d4ed8','#4caf7d','#d97706','#c0392b','#0891b2','#7c3aed','#be185d']; $maxCat = collect($byCategory)->max() ?: 1; @endphp
        <div style="display:flex;flex-direction:column;gap:14px">
          @forelse($byCategory as $cat => $count)
          <div>
            <div style="display:flex;justify-content:space-between;margin-bottom:5px"><span style="font-size:12px;color:var(--navy);font-weight:600">{{ $cat }}</span><span style="font-size:12px;color:var(--grey)">{{ $count }} {{ \Illuminate\Support\Str::plural('event', $count) }}</span></div>
            <div class="prog-bar" style="height:8px"><div class="prog-fill" style="width:{{ round($count / $maxCat * 100) }}%;background:{{ $palette[$loop->index % count($palette)] }}"></div></div>
          </div>
          @empty
          <div style="font-size:12px;color:var(--grey);padding:10px 0">No events recorded yet.</div>
          @endforelse
        </div>
      </div>
    </div>
    <div class="panel">
      <div class="ph"><div class="pt">Membership <em>Growth</em></div><span style="font-size:11px;color:var(--grey)">Manually tracked</span></div>
      <div class="pb">
        <div style="display:flex;flex-direction:column;gap:2px">
          @forelse($membershipGrowth as $m)
          <div style="display:flex;align-items:center;justify-content:space-between;padding:9px 0;border-bottom:1px solid var(--light)">
            <span style="font-size:12px;color:var(--grey)">{{ $m['label'] }}</span>
            <span style="font-size:14px;font-weight:700;color:var(--navy)">{{ $m['member_count'] }} members @if(!is_null($m['new_members']))<span style="font-size:11px;color:var(--green);font-weight:600">({{ $m['new_members'] >= 0 ? '+'.$m['new_members'] : $m['new_members'] }})</span>@endif</span>
          </div>
          @empty
          <div style="font-size:12px;color:var(--grey);padding:6px 0 12px">No membership figures yet — add the first month below.</div>
          @endforelse
        </div>
        {{-- Manual monthly entry --}}
        <form method="POST" action="{{ route('student.reports.membership') }}" style="margin-top:12px;display:flex;gap:6px;flex-wrap:wrap;align-items:flex-end">
          @csrf
          <div style="flex:1;min-width:110px"><label style="display:block;font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);margin-bottom:3px">Month</label><input type="date" name="as_of" required style="width:100%;border:1px solid var(--light);background:var(--off);padding:6px 8px;font-size:11px;color:var(--navy);outline:none"/></div>
          <div style="width:90px"><label style="display:block;font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);margin-bottom:3px">Members</label><input type="number" name="member_count" min="0" required placeholder="0" style="width:100%;border:1px solid var(--light);background:var(--off);padding:6px 8px;font-size:11px;color:var(--navy);outline:none"/></div>
          <div style="width:80px"><label style="display:block;font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);margin-bottom:3px">New</label><input type="number" name="new_members" placeholder="+0" style="width:100%;border:1px solid var(--light);background:var(--off);padding:6px 8px;font-size:11px;color:var(--navy);outline:none"/></div>
          <button type="submit" class="btn-secondary" style="font-size:10px;padding:7px 12px">Add</button>
        </form>
      </div>
    </div>
  </div>

  <div class="panel">
    <div class="ph"><div class="pt">SDG <em>Alignment</em> Breakdown</div></div>
    <div class="pb">
      @if(count($sdgBreakdown))
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:12px">
        @foreach($sdgBreakdown as $goal => $count)
        <div style="padding:16px;background:var(--off);border:1px solid var(--light);text-align:center">
          <div style="font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--grey);margin-bottom:4px">SDG {{ $goal }}</div>
          <div style="font-family:'Playfair Display',serif;font-size:22px;font-weight:900;color:var(--green)">{{ $count }}</div>
          <div style="font-size:11px;color:var(--grey)">{{ \Illuminate\Support\Str::plural('event', $count) }}</div>
        </div>
        @endforeach
      </div>
      @else
      <div style="font-size:12px;color:var(--grey);padding:10px 0">No SDG-aligned events recorded yet.</div>
      @endif
    </div>
  </div>

  {{-- Events Pipeline + Budget Summary (meeting-ready counters) --}}
  <div class="g2">
    <div class="panel">
      <div class="ph"><div class="pt">Events <em>Pipeline</em></div></div>
      <div class="pb">
        @php $eps = [['Approved',$eventsSummary['approved'],'var(--green)'],['Published',$eventsSummary['published'],'var(--navy)'],['Past Events',$eventsSummary['past'],'#1d4ed8'],['Rejected',$eventsSummary['rejected'],'var(--red)'],['Drafts',$eventsSummary['draft'],'var(--grey)'],['Total',$eventsSummary['total'],'var(--amber)']]; @endphp
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px">
          @foreach($eps as [$lbl,$val,$col])
          <div style="padding:12px;background:var(--off);border:1px solid var(--light);text-align:center">
            <div style="font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--grey)">{{ $lbl }}</div>
            <div style="font-family:'Playfair Display',serif;font-size:20px;font-weight:900;color:{{ $col }}">{{ $val }}</div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="panel">
      <div class="ph"><div class="pt">Budget <em>Summary</em></div></div>
      <div class="pb">
        @php $brow = fn($l,$v,$c='var(--navy)')=> '<tr><td style="padding:8px 0;border-bottom:1px solid var(--light);font-size:12px;color:#444">'.$l.'</td><td style="padding:8px 0;border-bottom:1px solid var(--light);text-align:right;font-weight:700;font-size:12px;color:'.$c.'">'.$v.'</td></tr>'; @endphp
        <table style="width:100%;border-collapse:collapse">
          {!! $brow('Requests', $budgetSummary['requests'].' total · '.$budgetSummary['pending'].' pending') !!}
          {!! $brow('Total Requested', 'RM '.number_format($budgetSummary['requested'],2)) !!}
          {!! $brow('Total Approved', 'RM '.number_format($budgetSummary['approved'],2), 'var(--green)') !!}
          {!! $brow('Reimbursed', 'RM '.number_format($budgetSummary['reimbursed'],2)) !!}
          {!! $brow('Unused (approved − reimbursed)', 'RM '.number_format($budgetSummary['unused'],2), 'var(--amber)') !!}
        </table>
      </div>
    </div>
  </div>

  {{-- Annual Report --}}
  @php
    $currentYear   = now()->year;
    $currentReport = $annualReports->firstWhere('year', $currentYear);
    $pastReports   = $annualReports->where('year', '!=', $currentYear);
  @endphp
  <div class="panel">
    <div class="ph"><div class="pt">Annual <em>Report</em></div><span style="font-size:11px;color:var(--grey)">Auto-generated · {{ $branch->academic_year ?? $currentYear }}</span></div>
    <div class="pb">
      <div style="font-size:12px;color:var(--grey);line-height:1.6;margin-bottom:14px">The annual report is built automatically from the tracked statistics above — preview it as a PDF or submit it to HQ for review.</div>

      @if($currentReport)
      @php
        $rstage = $currentReport->stage; // review | approved | returned
        $rmeta  = ['review'=>['Under Review','var(--amber)'],'approved'=>['Approved','var(--green)'],'returned'=>['Returned','var(--red)']][$rstage];
      @endphp
      <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;padding:12px 14px;background:var(--off);border:1px solid var(--light);margin-bottom:12px">
        <div style="flex:1;min-width:180px">
          <div style="font-size:13px;font-weight:700;color:var(--navy)">{{ $currentReport->title }}</div>
          <div style="font-size:11px;color:var(--grey)">Submitted {{ optional($currentReport->submitted_at ?? $currentReport->created_at)->format('j M Y') }}</div>
        </div>
        <span style="color:{{ $rmeta[1] }};border:1px solid {{ $rmeta[1] }};font-size:10px;font-weight:700;padding:4px 10px;text-transform:uppercase;letter-spacing:.5px">{{ $rmeta[0] }}</span>
        <a class="btn-secondary" href="{{ route('student.reports.document', $currentReport) }}" style="font-size:10px;padding:7px 12px">View Report</a>
      </div>
      @if($rstage==='returned')
      <div style="padding:10px 14px;background:#fdecea;border:1px solid rgba(192,57,43,.2);font-size:11px;color:var(--red);line-height:1.6;margin-bottom:12px"><strong>Returned by HQ.</strong> {{ $currentReport->notes ?: 'Please revise the underlying stats and resubmit.' }}</div>
      <form method="POST" action="{{ route('student.reports.submit') }}">@csrf<button type="submit" class="btn-primary" style="font-size:11px">↑ Regenerate &amp; Resubmit</button></form>
      @elseif($rstage==='approved')
      <div style="padding:10px 14px;background:#dcfce7;border:1px solid #bbf7d0;font-size:11px;color:#166534;line-height:1.6"><strong>Approved by HQ.</strong> {{ $currentReport->notes }}</div>
      @else
      <div style="font-size:11px;color:var(--grey)">Awaiting HQ review — you'll be notified once a decision is made.</div>
      @endif

      @else
      <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
        <a class="btn-secondary" href="{{ route('student.reports.preview') }}" style="font-size:11px">Preview / Download</a>
        <form method="POST" action="{{ route('student.reports.submit') }}">@csrf<button type="submit" class="btn-primary" style="font-size:11px">Generate &amp; Submit to HQ</button></form>
      </div>
      @endif

      @if($pastReports->count())
      <div style="margin-top:16px">
        <div style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:8px">Past Reports</div>
        @foreach($pastReports as $pr)
        <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--light)">
          <span style="font-size:12px;color:var(--navy)">{{ $pr->year }} · {{ ['pending'=>'Under Review','approved'=>'Approved','rejected'=>'Returned'][$pr->status] ?? ucfirst($pr->status) }}</span>
          <a href="{{ route('student.reports.document', $pr) }}" style="font-size:11px;color:var(--navy);font-weight:600">View →</a>
        </div>
        @endforeach
      </div>
      @endif
    </div>
  </div>

@endsection

