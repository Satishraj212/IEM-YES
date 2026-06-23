@if(!empty($heading))
<div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:10px">{{ $heading }}</div>
@endif
<form method="POST" action="{{ route('student.org-chart.upload') }}" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="academic_year" value="{{ $year }}">
  <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end">
    <div>
      <label style="display:block;font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--grey);margin-bottom:5px">Chart File · AY {{ $year }}</label>
      <input type="file" name="org_chart" accept="image/*,.pdf" required style="font-size:12px;color:var(--navy)"/>
    </div>
    <button type="submit" class="btn-primary" style="font-size:11px">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
      Send for Review
    </button>
  </div>
  <div style="font-size:11px;color:var(--grey);margin-top:8px">PNG, JPG, or PDF — max 10 MB. Submitted to HQ for review.</div>
</form>
