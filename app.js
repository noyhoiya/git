class ErrorBoundary extends React.Component {
  constructor(props) {
    super(props);
    this.state = { hasError: false, error: null };
  }

  static getDerivedStateFromError(error) {
    return { hasError: true, error };
  }

  componentDidCatch(error, errorInfo) {
    console.error('ErrorBoundary caught an error:', error, errorInfo.componentStack);
  }

  render() {
    if (this.state.hasError) {
      return (
        <div className="min-h-screen flex items-center justify-center bg-gray-50">
          <div className="text-center">
            <h1 className="text-2xl font-bold text-gray-900 mb-4">Something went wrong</h1>
            <p className="text-gray-600 mb-4">We're sorry, but something unexpected happened.</p>
            <button
              onClick={() => window.location.reload()}
              className="btn-primary"
            >
              Reload Page
            </button>
          </div>
        </div>
      );
    }

    return this.props.children;
  }
}

function App() {
  try {
    const [activeView, setActiveView] = React.useState('dashboard');
    const [transactions, setTransactions] = React.useState([]);
    const [balance, setBalance] = React.useState(0);

    React.useEffect(() => {
      const savedTransactions = dataManager.getTransactions();
      setTransactions(savedTransactions);
      setBalance(dataManager.calculateBalance(savedTransactions));
    }, []);

    const handleAddTransaction = (transaction) => {
      const newTransaction = {
        ...transaction,
        id: Date.now().toString(),
        date: new Date().toISOString()
      };
      const updatedTransactions = [...transactions, newTransaction];
      setTransactions(updatedTransactions);
      dataManager.saveTransactions(updatedTransactions);
      setBalance(dataManager.calculateBalance(updatedTransactions));
    };

    return (
      <div className="min-h-screen bg-[var(--background-light)]" data-name="app" data-file="app.js">
        <Header />
        <div className="flex">
          <Sidebar activeView={activeView} onViewChange={setActiveView} />
          <main className="flex-1 p-6">
            {activeView === 'dashboard' && (
              <Dashboard 
                transactions={transactions}
                balance={balance}
                onAddTransaction={handleAddTransaction}
              />
            )}
          </main>
        </div>
      </div>
    );
  } catch (error) {
    console.error('App component error:', error);
    return null;
  }
}

function Dashboard({ transactions, balance, onAddTransaction }) {
  try {
    const stats = dataManager.getStatistics(transactions);
    
    return (
      <div className="space-y-6" data-name="dashboard" data-file="app.js">
        <div className="flex justify-between items-center">
          <h1 className="text-3xl font-bold text-[var(--text-primary)]">ຄັງເງິນສົດ</h1>
          <QuickActions onAddTransaction={onAddTransaction} />
        </div>
        
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <StatCard
            title="ຍອດເງິນປັດຈຸບັນ"
            value={`₭${balance.toFixed(2)}`}
            icon="wallet"
            color="primary"
          />
          <StatCard
            title="ມອບເຂົ້າ"
            value={`₭${stats.totalIncome.toFixed(2)}`}
            icon="trending-up"
            color="success"
          />
          <StatCard
            title="ຖອນອອກ"
            value={`₭${stats.totalExpenses.toFixed(2)}`}
            icon="trending-down"
            color="danger"
          />
          <StatCard
            title="ທຸລະກຳ"
            value={transactions.length.toString()}
            icon="list"
            color="secondary"
          />
        </div>
        
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <CashFlowChart transactions={transactions} />
          <TransactionList transactions={transactions.slice(-10)} />
        </div>
      </div>
    );
  } catch (error) {
    console.error('Dashboard component error:', error);
    return null;
  }
}

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <ErrorBoundary>
    <App />
  </ErrorBoundary>
); 