const ChartJS = window.Chart;

function CashFlowChart({ transactions }) {
  const chartRef = React.useRef(null);
  const chartInstanceRef = React.useRef(null);

  try {
    React.useEffect(() => {
      if (chartInstanceRef.current) {
        chartInstanceRef.current.destroy();
      }

      const ctx = chartRef.current.getContext('2d');
      const last7Days = dataManager.getLast7DaysData(transactions);

      chartInstanceRef.current = new ChartJS(ctx, {
        type: 'line',
        data: {
          labels: last7Days.map(d => d.date),
          datasets: [{
            label: 'Cash Flow',
            data: last7Days.map(d => d.balance),
            borderColor: 'var(--primary-color)',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            tension: 0.4,
            fill: true
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                color: 'var(--border-color)'
              }
            },
            x: {
              grid: {
                color: 'var(--border-color)'
              }
            }
          }
        }
      });

      return () => {
        if (chartInstanceRef.current) {
          chartInstanceRef.current.destroy();
        }
      };
    }, [transactions]);

    return (
      <div className="card" data-name="cash-flow-chart" data-file="components/CashFlowChart.js">
        <h3 className="text-lg font-semibold text-[var(--text-primary)] mb-6">ກະແສເງິນສົດ (7 ວັນທີ່ຜ່ານມາ)</h3>
        <div className="h-64">
          <canvas ref={chartRef}></canvas>
        </div>
      </div>
    );
  } catch (error) {
    console.error('CashFlowChart component error:', error);
    return null;
  }
}