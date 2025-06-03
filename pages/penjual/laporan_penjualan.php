<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <title>Weekly Sales Report</title>
</head>
<body class="min-h-screen flex flex-col">

  <?php include '../../partials/navbar-penjual.php'; ?>

  <main class="w-[90%] mx-auto mt-6 flex-grow max-w-6xl">
    <h2 class="text-2xl font-bold mb-4">Weekly Sales Report</h2>

    <!-- Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mb-6">
      <div class="bg-white shadow rounded p-4 border">
        <h3 class="text-sm text-black font-medium">Total Orders This Week</h3>
        <p class="text-xl font-bold text-kuning">38</p>
      </div>
      <div class="bg-white shadow rounded p-4 border">
        <h3 class="text-sm text-black font-medium">Total Income</h3>
        <p class="text-xl font-bold text-kuning">Rp 4,500,000</p>
      </div>
      <div class="bg-white shadow rounded p-4 border">
        <h3 class="text-sm text-black font-medium">Best Selling Day</h3>
        <p class="text-xl font-bold text-kuning">Friday</p>
      </div>
    </div>

    <!-- Chart -->
    <div class="bg-white p-4 rounded shadow border mb-6">
      <h3 class="text-lg font-semibold mb-4">Sales in the Last 7 Days</h3>
      <canvas id="weeklyChart" height="80"></canvas>
    </div>
</div>

  </main>

  <script>
    const isMobile = window.innerWidth < 768;
    const weeklyChart = new Chart(document.getElementById('weeklyChart'), {
    type: 'bar',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
        label: isMobile ? '' : 'Sales (Rp)',
        data: [600000, 500000, 750000, 900000, 1200000, 350000, 200000],
        borderColor: '#facc15',
        backgroundColor: '#fde68a',
        fill: true,
        tension: 0.4,
        pointRadius: 5,
        pointBackgroundColor: '#facc15'
        }]
    },
    options: {
        responsive: true,
        scales: {
        y: {
                display: !isMobile,
            beginAtZero: true,
            ticks: {
            callback: function(value) {
                return 'Rp ' + value.toLocaleString();
            }
            }
        }
        },
        plugins: {
        legend: {
            display: !isMobile // sembunyikan legend di mobile juga kalau mau
        }
        }
    }
    });

  </script>

</body>
</html>
