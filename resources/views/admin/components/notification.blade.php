<div class="container-fluid rounded-2 shadow bordered overflow-hidden mb-2">
    <div class="row bg-primary bg-gradient text-light py-1">
        <div class="col-8">
            <strong class="me-auto">{{ $title ?? '' }}</strong>
        </div>
        <div class="col-4 text-end">
            @php
            $second = strtotime(strval(now())) - strtotime($created_at);
            $minute = $second / 60;
            $hour = $minute / 60;
            $day = $hour / 24;
            $week = $day / 7;
            $month = $day / 30;
            $year = $month / 12;
            @endphp
            @if ($year >= 1)
            <small>{{ floor($year) }} năm trước</small>
            @elseif ($month >= 1)
            <small>{{ floor($month)  }} tháng trước</small>
            @elseif ($week >= 1)
            <small>{{ floor($week) }} tuần trước</small>
            @elseif ($day >= 1)
            <small>{{ floor($day) }} ngày trước</small>
            @elseif ($hour >= 1)
            <small>{{ floor($hour) }} giờ trước</small>
            @elseif ($minute >= 1)
            <small>{{ floor($minute) }} phút trước</small>
            @else
            <small>{{ floor($second) }} giây trước</small>
            @endif
        </div>
    </div>
    <div class="row p-2">
        {{ $content ?? '' }}
    </div>
</div>