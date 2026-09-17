import { Chart } from 'chart.js/auto';

function palette(index) {
    const colors = [
        'rgba(146, 64, 14, 0.7)',
        'rgba(180, 83, 9, 0.7)',
        'rgba(120, 53, 15, 0.7)',
        'rgba(153, 27, 27, 0.7)',
        'rgba(101, 163, 13, 0.7)',
        'rgba(30, 64, 175, 0.7)',
    ];

    return colors[index % colors.length];
}

function initCharts() {
    document.querySelectorAll('canvas[data-chart]').forEach((canvas) => {
        if (canvas.dataset.initialized === 'true') {
            return;
        }
        canvas.dataset.initialized = 'true';

        const type = canvas.dataset.chartType || 'bar';
        const labels = JSON.parse(canvas.dataset.chartLabels || '[]');
        const rawDatasets = JSON.parse(canvas.dataset.chartDatasets || '[]');

        const datasets = rawDatasets.map((dataset, index) => ({
            ...dataset,
            backgroundColor: dataset.backgroundColor ?? palette(index),
            borderColor: dataset.borderColor ?? palette(index).replace('0.7', '1'),
            borderWidth: dataset.borderWidth ?? 1,
        }));

        // eslint-disable-next-line no-new
        new Chart(canvas, {
            type,
            data: { labels, datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
                scales:
                    type === 'bar' || type === 'line'
                        ? { y: { beginAtZero: true, ticks: { precision: 0 } } }
                        : undefined,
            },
        });
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCharts);
} else {
    initCharts();
}
