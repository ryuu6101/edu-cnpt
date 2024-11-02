<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-{{ $icon ?? 'house' }} me-1"></i>
        {{ $title ?? '' }}
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>