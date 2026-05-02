@extends('admin.layouts.app')

@section('title', 'Activity Feed')

@section('topbar-actions')
<form method="POST" action="{{ route('admin.activity.mark-all-read') }}" style="display:inline">
    @csrf
    <button type="submit" class="btn-primary">Mark All Read</button>
</form>
@endsection

@section('content')

<div class="panel">
    <div class="ph">
        <div class="pt">Activity <em>Feed</em></div>
        <div style="display:flex;gap:8px">
            <select class="fsel" onchange="location.href=this.value">
                <option value="{{ route('admin.activity') }}" {{ !request('type') ? 'selected' : '' }}>All Types</option>
                <option value="{{ route('admin.activity', ['type' => 'events']) }}" {{ request('type') === 'events' ? 'selected' : '' }}>Events</option>
                <option value="{{ route('admin.activity', ['type' => 'members']) }}" {{ request('type') === 'members' ? 'selected' : '' }}>Members</option>
                <option value="{{ route('admin.activity', ['type' => 'network']) }}" {{ request('type') === 'network' ? 'selected' : '' }}>Network</option>
            </select>
        </div>
    </div>
    <div class="pb">
        @forelse($logs as $log)
        <div class="act-item" id="log-{{ $log->id }}" style="{{ !$log->read_at ? 'background:#fffdf5;' : '' }}">
            <div class="act-dot" style="background:{{ $log->dot_color ?? 'var(--navy)' }}">
                <svg viewBox="0 0 24 24">{!! $log->dot_icon ?? '<circle cx="12" cy="12" r="3"/>' !!}</svg>
            </div>
            <div style="flex:1">
                <div class="act-txt">{!! $log->message !!}</div>
                <span class="act-time">{{ $log->created_at->diffForHumans() }} · {{ ucfirst($log->type ?? 'system') }}</span>
            </div>
            @if(!$log->read_at)
            <div style="width:6px;height:6px;border-radius:50%;background:var(--gold);flex-shrink:0;margin-top:6px"></div>
            @endif
        </div>
        @empty
        <div style="text-align:center;color:var(--grey);font-size:12px;padding:48px 0">
            <svg viewBox="0 0 24 24" style="width:32px;height:32px;stroke:var(--light);fill:none;stroke-width:1.5;margin:0 auto 10px;display:block"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            No activity logs found.
        </div>
        @endforelse

        @if($logs->hasPages())
        <div style="padding-top:16px;display:flex;justify-content:center">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>

@endsection