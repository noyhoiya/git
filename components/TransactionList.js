function TransactionList({ transactions }) {
  try {
    return (
      <div className="card" data-name="transaction-list" data-file="components/TransactionList.js">
        <div className="flex items-center justify-between mb-6">
          <h3 className="text-lg font-semibold text-[var(--text-primary)]">ທຸລະກຳລ່າສຸດ</h3>
          <button className="text-[var(--primary-color)] hover:text-[var(--accent-color)] text-sm font-medium">
            ເບິ່ງທັງໝົດ
          </button>
        </div>
        
        <div className="space-y-4">
          {transactions.length === 0 ? (
            <div className="text-center py-8">
              <div className="icon-list text-4xl text-[var(--text-secondary)] mb-2"></div>
              <p className="text-[var(--text-secondary)]">ຍັງບໍ່ມີທຸລະກຳ</p>
            </div>
          ) : (
            transactions.map(transaction => (
              <div key={transaction.id} className="flex items-center justify-between p-3 hover:bg-[var(--background-light)] rounded-lg">
                <div className="flex items-center space-x-3">
                  <div className={`w-10 h-10 rounded-lg flex items-center justify-center ${
                    transaction.type === 'income' ? 'bg-[var(--success-color)]' : 'bg-[var(--danger-color)]'
                  }`}>
                    <div className={`icon-${transaction.type === 'income' ? 'plus' : 'minus'} text-lg text-white`}></div>
                  </div>
                  <div>
                    <p className="font-medium text-[var(--text-primary)]">{transaction.description}</p>
                    <p className="text-sm text-[var(--text-secondary)]">{transaction.category}</p>
                  </div>
                </div>
                <div className="text-right">
                  <p className={`font-semibold ${
                    transaction.type === 'income' ? 'text-[var(--success-color)]' : 'text-[var(--danger-color)]'
                  }`}>
                    {transaction.type === 'income' ? '+' : '-'}₭{transaction.amount.toFixed(2)}
                  </p>
                  <p className="text-sm text-[var(--text-secondary)]">
                    {new Date(transaction.date).toLocaleDateString()}
                  </p>
                </div>
              </div>
            ))
          )}
        </div>
      </div>
    );
  } catch (error) {
    console.error('TransactionList component error:', error);
    return null;
  }
}