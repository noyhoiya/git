function Sidebar({ activeView, onViewChange }) {
  try {
    const menuItems = [
      { id: 'dashboard', label: 'ໜ້າຫຼັກ', icon: 'layout-dashboard' },
      { id: 'transactions', label: 'ທຸລະກຳ', icon: 'list' },
      { id: 'accounts', label: 'ບັນຊີ', icon: 'credit-card' },
      { id: 'reports', label: 'ບົດລາຍງານ', icon: 'chart-bar' },
      { id: 'settings', label: 'ການຕັ້ງຄ່າ', icon: 'settings' }
    ];

    return (
      <aside className="w-64 bg-white border-r border-[var(--border-color)] min-h-screen" data-name="sidebar" data-file="components/Sidebar.js">
        <nav className="p-4 space-y-2">
          {menuItems.map(item => (
            <button
              key={item.id}
              onClick={() => onViewChange(item.id)}
              className={`w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-left transition-colors ${
                activeView === item.id
                  ? 'bg-[var(--secondary-color)] text-[var(--primary-color)]'
                  : 'text-[var(--text-secondary)] hover:bg-gray-50'
              }`}
            >
              <div className={`icon-${item.icon} text-xl`}></div>
              <span className="font-medium">{item.label}</span>
            </button>
          ))}
        </nav>
      </aside>
    );
  } catch (error) {
    console.error('Sidebar component error:', error);
    return null;
  }
}