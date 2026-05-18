<div class="bg-white p-6 rounded-lg border border-green-border shadow-hover">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-text-primary">Stock Movement Trends</h3>
        <select wire:model.live="days" class="rounded-md border-gray-300 shadow-sm focus:border-green-primary text-sm">
            <option value="7">Last 7 Days</option>
            <option value="30">Last 30 Days</option>
            <option value="90">Last 90 Days</option>
        </select>
    </div>
    
    <div class="w-full" style="height: 300px;" wire:ignore>
        <canvas id="stockChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            const ctx = document.getElementById('stockChart');
            let chart;

            const initChart = (labels, inData, outData) => {
                if (chart) {
                    chart.destroy();
                }
                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Stock IN',
                                data: inData,
                                backgroundColor: 'rgba(46, 158, 91, 0.2)',
                                borderColor: 'rgba(46, 158, 91, 1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Stock OUT',
                                data: outData,
                                backgroundColor: 'rgba(239, 68, 68, 0.2)',
                                borderColor: 'rgba(239, 68, 68, 1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            };

            const labels = @json($labels);
            const inData = @json($inData);
            const outData = @json($outData);
            
            initChart(labels, inData, outData);
            
            Livewire.on('chart-updated', (data) => {
                 let payload = Array.isArray(data) ? data[0] : data;
                 initChart(payload.labels, payload.inData, payload.outData);
            });
        });
    </script>
</div>
