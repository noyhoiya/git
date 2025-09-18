function StatCard({ title, value, icon, color = 'primary' }) {
  try {
    const colorClasses = {
      primary: 'bg-[var(--primary-color)]',
      success: 'bg-[var(--success-color)]',
      danger: 'bg-[var(--danger-color)]',
      secondary: 'bg-[var(--text-secondary)]'
    };

    return (
      <div className="stat-card" data-name="stat-card" data-file="components/StatCard.js">
        <div className="flex items-center justify-between">
          <div>
            <p className="text-[var(--text-secondary)] text-sm font-medium">{title}</p>
            <p className="text-2xl font-bold text-[var(--text-primary)] mt-1">{value}</p>
          </div>
          <div className={`w-12 h-12 rounded-lg ${colorClasses[color]} flex items-center justify-center`}>
            <div className={`icon-${icon} text-xl text-white`}></div>
          </div>
        </div>
      </div>
    );
  } catch (error) {
    console.error('StatCard component error:', error);
    return null;
  }
}