@extends('admin.layouts.app')

@section('title', 'Activity Feed')

@section('content')

@php
    // Inline SVG set keyed by ActivityLog::$icon (rendered white inside the coloured dot).
    $icons = [
        'check'    => '<polyline points="20 6 9 17 4 12"/>',
        'x'        => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
        'calendar' => '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>',
        'trash'    => '<polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/>',
        'users'    => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>',
        'file'     => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>',
        'chart'    => '<rect x="9" y="3" width="6" height="5" rx="1"/><rect x="3" y="16" width="6" height="5" rx="1"/><rect x="15" y="16" width="6" height="5" rx="1"/><path d="M12 8v3M6 16v-2h12v2"/>',
        'upload'   => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>',
        'building' => '<path d="M3 21h18"/><path d="M5 21V7l8-4v18"/><path d="M19 21V11l-6-4"/>',
        'dollar'   => '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>',
        'award'    => '<circle cx="12" cy="8" r="6"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/>',
        'default'  => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>',
    ];
@endphp

<div class="panel">
    <div class="ph">
        <div class="pt">Activity <em>Feed</em></div>
        <form method="GET" id="filterForm" style="margin:0">
            @if($scopeBranch)<input type="hidden" name="branch" value="{{ $scopeBranch->id }}">@endif
            <select class="fsel" name="category" onchange="document.getElementById('filterForm').submit()">
                <option value="">All Types</option>
                @foreach(\App\Models\ActivityLog::CATEGORIES as $key => $label)
                    <option value="{{ $key }}" @selected($category === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </form>
    </div>

    @if($scopeBranch)
    <div class="audit-scope">
        <div>
            <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Audit trail for <strong>{{ $scopeBranch->name }}</strong>
        </div>
        <a href="{{ route('admin.activity') }}" class="audit-clear">Clear filter ✕</a>
    </div>
    @endif

    <div class="pb" style="padding:0 20px">
        <table class="etbl" style="margin-top:4px">
            <thead><tr>
                <th style="width:150px">When</th>
                <th>Activity</th>
                <th style="width:150px">By</th>
                <th style="width:150px">Branch</th>
            </tr></thead>
            <tbody>
            @forelse($logs as $log)
                <tr>
                    <td class="et-sm">
                        {{ $log->created_at->format('j M Y, H:i') }}
                        <div style="font-size:10px;color:var(--grey);margin-top:1px">{{ $log->created_at->diffForHumans() }}</div>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:9px">
                            <span class="audit-dot" style="background:{{ $log->dot_colour }}">
                                <svg viewBox="0 0 24 24">{!! $icons[$log->icon] ?? $icons['default'] !!}</svg>
                            </span>
                            <div style="min-width:0">
                                <div class="et-name">{{ $log->title }}</div>
                                <div class="audit-type" style="color:{{ $log->dot_colour }}">{{ $log->label }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="et-sm">{{ $log->user?->name ?? 'System' }}</td>
                    <td class="et-sm">
                        @if($log->branch)
                            {{ $log->branch->identity_name }}
                            @if($log->branch->identity_institution)
                            <div style="font-size:10px;color:var(--grey);margin-top:1px">{{ $log->branch->identity_institution }}</div>
                            @endif
                        @else — @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center;color:var(--grey);padding:40px 0;font-size:12px">
                    No activity recorded yet.
                </td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
    <div class="audit-pager">
        <span>Showing {{ $logs->firstItem() }}–{{ $logs->lastItem() }} of {{ $logs->total() }}</span>
        <div class="audit-pager-btns">
            @if($logs->onFirstPage())
                <span class="audit-pg disabled">← Prev</span>
            @else
                <a href="{{ $logs->previousPageUrl() }}" class="audit-pg">← Prev</a>
            @endif
            @if($logs->hasMorePages())
                <a href="{{ $logs->nextPageUrl() }}" class="audit-pg">Next →</a>
            @else
                <span class="audit-pg disabled">Next →</span>
            @endif
        </div>
    </div>
    @endif
</div>

@endsection

@section('styles')
<style>
.audit-scope{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:10px 20px;background:var(--blue-l);border-bottom:1px solid var(--light)}
.audit-scope > div{display:flex;align-items:center;gap:8px;font-size:12px;color:var(--navy)}
.audit-scope svg{width:14px;height:14px;stroke:var(--navy);fill:none;stroke-width:1.8}
.audit-scope strong{font-weight:700}
.audit-clear{font-size:11px;font-weight:600;color:var(--grey);text-decoration:none}
.audit-clear:hover{color:var(--red)}
.audit-dot{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.audit-dot svg{width:13px;height:13px;stroke:#fff;fill:none;stroke-width:2.2}
.audit-type{font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-top:2px}
.audit-pager{display:flex;align-items:center;justify-content:space-between;padding:13px 20px;border-top:1px solid var(--light);font-size:11px;color:var(--grey)}
.audit-pager-btns{display:flex;gap:8px}
.audit-pg{font-size:11px;font-weight:600;color:var(--navy);text-decoration:none;border:1px solid var(--light);padding:6px 12px;border-radius:3px;transition:border-color .15s}
.audit-pg:hover{border-color:var(--navy)}
.audit-pg.disabled{color:var(--light);border-color:var(--light);cursor:default}
</style>
@endsection
