function QuickActions({ onAddTransaction }) {
  const [showModal, setShowModal] = React.useState(false);
  const [formData, setFormData] = React.useState({
    type: 'income',
    amount: '',
    description: '',
    category: ''
  });

  try {
    const handleSubmit = (e) => {
      e.preventDefault();
      if (formData.amount && formData.description) {
        onAddTransaction({
          ...formData,
          amount: parseFloat(formData.amount)
        });
        setFormData({
          type: 'income',
          amount: '',
          description: '',
          category: ''
        });
        setShowModal(false);
      }
    };

    return (
      <div data-name="quick-actions" data-file="components/QuickActions.js">
        <button
          onClick={() => setShowModal(true)}
          className="btn-primary flex items-center space-x-2"
        >
          <div className="icon-plus text-lg"></div>
          <span>ເພີ່ມທຸລະກຳ</span>
        </button>

        {showModal && (
          <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div className="bg-white rounded-lg p-6 w-full max-w-md">
              <div className="flex items-center justify-between mb-4">
                <h2 className="text-xl font-semibold">ເພີ່ມທຸລະກຳ</h2>
                <button
                  onClick={() => setShowModal(false)}
                  className="p-1 hover:bg-gray-100 rounded"
                >
                  <div className="icon-x text-xl text-[var(--text-secondary)]"></div>
                </button>
              </div>

              <form onSubmit={handleSubmit} className="space-y-4">
                <div>
                  <label className="block text-sm font-medium text-[var(--text-primary)] mb-2">ປະເພດ</label>
                  <select
                    value={formData.type}
                    onChange={(e) => setFormData({...formData, type: e.target.value})}
                    className="input-field"
                  >
                    <option value="income">ລາຍຮັບ</option>
                    <option value="expense">ລາຍຈ່າຍ</option>
                  </select>
                </div>

                <div>
                  <label className="block text-sm font-medium text-[var(--text-primary)] mb-2">ຈຳນວນເງິນ</label>
                  <input
                    type="number"
                    step="0.01"
                    value={formData.amount}
                    onChange={(e) => setFormData({...formData, amount: e.target.value})}
                    className="input-field"
                    placeholder="0.00"
                    required
                  />
                </div>

                <div>
                  <label className="block text-sm font-medium text-[var(--text-primary)] mb-2">ລາຍລະອຽດ</label>
                  <input
                    type="text"
                    value={formData.description}
                    onChange={(e) => setFormData({...formData, description: e.target.value})}
                    className="input-field"
                    placeholder="ໃສ່ລາຍລະອຽດ"
                    required
                  />
                </div>

                <div>
                  <label className="block text-sm font-medium text-[var(--text-primary)] mb-2">ໝວດໝູ່</label>
                  <input
                    type="text"
                    value={formData.category}
                    onChange={(e) => setFormData({...formData, category: e.target.value})}
                    className="input-field"
                    placeholder="ໃສ່ໝວດໝູ່"
                  />
                </div>

                <div className="flex space-x-3 pt-4">
                  <button type="submit" className="btn-primary flex-1">
                    ເພີ່ມທຸລະກຳ
                  </button>
                  <button
                    type="button"
                    onClick={() => setShowModal(false)}
                    className="btn-secondary"
                  >
                    ຍົກເລີກ
                  </button>
                </div>
              </form>
            </div>
          </div>
        )}
      </div>
    );
  } catch (error) {
    console.error('QuickActions component error:', error);
    return null;
  }
}