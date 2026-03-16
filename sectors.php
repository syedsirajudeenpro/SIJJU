<div class="card">
    <h3>Sector Analysis</h3>
    <p style="color:#94a3b8; font-size:14px; margin-bottom:20px;">Sector-wise market performance heatmap</p>
    
    <div style="height: 400px;">
        <canvas id="sectorChart"></canvas>
    </div>
</div>

<script>
    const sCtx = document.getElementById('sectorChart').getContext('2d');
    new Chart(sCtx, {
        type: 'bar', // Using horizontal bar chart
        data: {
            labels: ['Infrastructure', 'Materials', 'Consumer', 'Pharma', 'Banking', 'Telecom', 'FMCG'],
            datasets: [{
                label: 'Sector Performance %',
                data: [1.2, 0.9, 0.7, 0.4, 0.2, -0.3, -0.5], // Positive and negative growth
                backgroundColor: (context) => {
                    const value = context.dataset.data[context.dataIndex];
                    return value >= 0 ? '#00c076' : '#cf304a'; // Green for gain, Red for loss
                },
                borderRadius: 5
            }]
        },
        options: {
            indexAxis: 'y', // Makes the bars horizontal
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { grid: { color: '#334155' }, ticks: { color: '#eaecef' } },
                y: { grid: { display: false }, ticks: { color: '#eaecef' } }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>