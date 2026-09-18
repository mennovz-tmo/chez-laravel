@props(['id', 'type' => 'bar', 'labels' => [], 'datasets' => [], 'title' => null, 'height' => 280])

<div class="card card-custom h-100 shadow-sm">
    <div class="card-body d-flex flex-column">
        @if ($title)
            <h3 class="card-title h5">{{ $title }}</h3>
        @endif
        <div style="position: relative; height: {{ $height }}px;">
            <canvas
                id="{{ $id }}"
                data-chart
                data-chart-type="{{ $type }}"
                data-chart-labels='@json($labels)'
                data-chart-datasets='@json($datasets)'
            ></canvas>
        </div>
    </div>
</div>
