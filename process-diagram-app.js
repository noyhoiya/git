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
            <button onClick={() => window.location.reload()} className="bg-[var(--primary-color)] text-white px-6 py-3 rounded-lg">
              Reload Page
            </button>
          </div>
        </div>
      );
    }
    return this.props.children;
  }
}

function ProcessDiagramApp() {
  try {
    const [activeProcess, setActiveProcess] = React.useState('cash-request');

    return (
      <div className="min-h-screen bg-[var(--background-light)]" data-name="process-diagram-app" data-file="process-diagram-app.js">
        <Header />
        <main className="container mx-auto px-6 py-8">
          <div className="mb-8">
            <h1 className="text-3xl font-bold text-[var(--text-primary)] mb-4">Cash Center Process Diagrams</h1>
            <p className="text-[var(--text-secondary)]">Workflow visualizations for financial management processes</p>
          </div>
          
          <ProcessSelector activeProcess={activeProcess} onProcessChange={setActiveProcess} />
          
          {activeProcess === 'cash-request' && <CashRequestProcess />}
          {activeProcess === 'vault-movement' && <VaultMovementProcess />}
          {activeProcess === 'user-setup' && <UserSetupProcess />}
        </main>
      </div>
    );
  } catch (error) {
    console.error('ProcessDiagramApp component error:', error);
    return null;
  }
}

function Header() {
  try {
    return (
      <header className="bg-white border-b border-[var(--border-color)] px-6 py-4" data-name="header" data-file="process-diagram-app.js">
        <div className="flex items-center justify-between">
          <div className="flex items-center space-x-3">
            <div className="w-8 h-8 rounded-lg bg-[var(--primary-color)] flex items-center justify-center">
              <div className="icon-git-branch text-lg text-white"></div>
            </div>
            <div>
              <h1 className="text-xl font-bold text-[var(--text-primary)]">Cash Center Processes</h1>
              <p className="text-sm text-[var(--text-secondary)]">Workflow Diagrams</p>
            </div>
          </div>
          
          <a href="index.html" className="bg-[var(--primary-color)] text-white px-4 py-2 rounded-lg hover:bg-[var(--accent-color)] transition-colors">
            Back to App
          </a>
        </div>
      </header>
    );
  } catch (error) {
    console.error('Header component error:', error);
    return null;
  }
}

function ProcessSelector({ activeProcess, onProcessChange }) {
  try {
    const processes = [
      { id: 'cash-request', label: 'Cash Request Process', icon: 'hand-coins' },
      { id: 'vault-movement', label: 'Vault Movement Process', icon: 'arrow-left-right' },
      { id: 'user-setup', label: 'User Setup Process', icon: 'user-plus' }
    ];

    return (
      <div className="bg-white rounded-lg shadow-lg p-6 mb-8" data-name="process-selector" data-file="process-diagram-app.js">
        <h2 className="text-xl font-semibold text-[var(--text-primary)] mb-4">Select Process</h2>
        <div className="flex flex-wrap gap-4">
          {processes.map(process => (
            <button
              key={process.id}
              onClick={() => onProcessChange(process.id)}
              className={`flex items-center space-x-3 px-6 py-3 rounded-lg transition-colors ${
                activeProcess === process.id
                  ? 'bg-[var(--primary-color)] text-white'
                  : 'bg-gray-100 text-[var(--text-primary)] hover:bg-gray-200'
              }`}
            >
              <div className={`icon-${process.icon} text-lg`}></div>
              <span className="font-medium">{process.label}</span>
            </button>
          ))}
        </div>
      </div>
    );
  } catch (error) {
    console.error('ProcessSelector component error:', error);
    return null;
  }
}

function CashRequestProcess() {
  try {
    return (
      <div className="bg-white rounded-lg shadow-lg p-8" data-name="cash-request-process" data-file="process-diagram-app.js">
        <h2 className="text-2xl font-bold text-[var(--text-primary)] mb-6">Cash Request Process</h2>
        
        <div className="relative overflow-x-auto">
          <svg width="1000" height="600" className="mx-auto">
            {/* Start - Teller Needs Cash */}
            <g transform="translate(50, 50)">
              <ellipse cx="80" cy="30" rx="80" ry="30" fill="var(--secondary-color)" stroke="var(--primary-color)" strokeWidth="2"/>
              <text x="80" y="35" textAnchor="middle" fontSize="12" fontWeight="bold">Teller Needs Cash</text>
            </g>

            {/* Create Cash Request */}
            <g transform="translate(250, 50)">
              <rect width="120" height="60" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <text x="60" y="25" textAnchor="middle" fontSize="11" fontWeight="bold">Create Request</text>
              <text x="60" y="45" textAnchor="middle" fontSize="10">Enter amount & purpose</text>
            </g>

            {/* Specify Denominations */}
            <g transform="translate(450, 50)">
              <rect width="120" height="60" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <text x="60" y="25" textAnchor="middle" fontSize="11" fontWeight="bold">Specify Denoms</text>
              <text x="60" y="45" textAnchor="middle" fontSize="10">Bills & coins needed</text>
            </g>

            {/* Submit to Main Vault */}
            <g transform="translate(650, 50)">
              <rect width="120" height="60" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <text x="60" y="25" textAnchor="middle" fontSize="11" fontWeight="bold">Submit Request</text>
              <text x="60" y="45" textAnchor="middle" fontSize="10">Status: PENDING</text>
            </g>

            {/* Main Vault Review */}
            <g transform="translate(650, 180)">
              <rect width="120" height="60" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <text x="60" y="25" textAnchor="middle" fontSize="11" fontWeight="bold">Main Vault Review</text>
              <text x="60" y="45" textAnchor="middle" fontSize="10">Check request validity</text>
            </g>

            {/* Approval Decision */}
            <g transform="translate(630, 300)">
              <polygon points="60,10 110,40 60,70 10,40" fill="yellow" fillOpacity="0.3" stroke="orange" strokeWidth="2"/>
              <text x="60" y="35" textAnchor="middle" fontSize="10" fontWeight="bold">Approve?</text>
              <text x="60" y="48" textAnchor="middle" fontSize="9">Balance check</text>
            </g>

            {/* Approved Path - Create Movement */}
            <g transform="translate(450, 400)">
              <rect width="120" height="60" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <text x="60" y="25" textAnchor="middle" fontSize="11" fontWeight="bold">Create Movement</text>
              <text x="60" y="45" textAnchor="middle" fontSize="10">Main → Sub vault</text>
            </g>

            {/* Cash Handover */}
            <g transform="translate(250, 400)">
              <rect width="120" height="60" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <text x="60" y="25" textAnchor="middle" fontSize="11" fontWeight="bold">Cash Handover</text>
              <text x="60" y="45" textAnchor="middle" fontSize="10">Physical transfer</text>
            </g>

            {/* Complete */}
            <g transform="translate(250, 520)">
              <ellipse cx="60" cy="30" rx="60" ry="30" fill="var(--secondary-color)" stroke="var(--primary-color)" strokeWidth="2"/>
              <text x="60" y="35" textAnchor="middle" fontSize="11" fontWeight="bold">Request Complete</text>
            </g>

            {/* Rejected Path */}
            <g transform="translate(800, 400)">
              <rect width="100" height="60" fill="#fef2f2" stroke="red" strokeWidth="2" rx="8"/>
              <text x="50" y="25" textAnchor="middle" fontSize="11" fontWeight="bold" fill="red">Rejected</text>
              <text x="50" y="45" textAnchor="middle" fontSize="10" fill="red">Notify requester</text>
            </g>

            {/* Arrows */}
            <path d="M 130 80 L 240 80" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead1)"/>
            <path d="M 370 80 L 440 80" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead1)"/>
            <path d="M 570 80 L 640 80" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead1)"/>
            <path d="M 710 110 L 710 170" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead1)"/>
            <path d="M 710 240 L 690 290" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead1)"/>
            
            {/* Approved path */}
            <path d="M 630 340 L 570 390" stroke="green" strokeWidth="2" fill="none" markerEnd="url(#arrowhead1)"/>
            <path d="M 450 430 L 380 430" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead1)"/>
            <path d="M 310 460 L 310 510" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead1)"/>
            
            {/* Rejected path */}
            <path d="M 690 340 L 800 390" stroke="red" strokeWidth="2" fill="none" markerEnd="url(#arrowhead1)" strokeDasharray="5,5"/>

            {/* Labels */}
            <text x="580" y="375" fontSize="10" fill="green" fontWeight="bold">APPROVED</text>
            <text x="730" y="375" fontSize="10" fill="red" fontWeight="bold">REJECTED</text>

            <defs>
              <marker id="arrowhead1" markerWidth="10" markerHeight="7" refX="9" refY="3.5" orient="auto">
                <polygon points="0 0, 10 3.5, 0 7" fill="var(--text-secondary)"/>
              </marker>
            </defs>
          </svg>
        </div>
      </div>
    );
  } catch (error) {
    console.error('CashRequestProcess component error:', error);
    return null;
  }
}

function VaultMovementProcess() {
  try {
    return (
      <div className="bg-white rounded-lg shadow-lg p-8" data-name="vault-movement-process" data-file="process-diagram-app.js">
        <h2 className="text-2xl font-bold text-[var(--text-primary)] mb-6">Vault Movement Process</h2>
        
        <div className="relative overflow-x-auto">
          <svg width="900" height="500" className="mx-auto">
            {/* Start Movement */}
            <g transform="translate(50, 50)">
              <ellipse cx="70" cy="30" rx="70" ry="30" fill="var(--secondary-color)" stroke="var(--primary-color)" strokeWidth="2"/>
              <text x="70" y="35" textAnchor="middle" fontSize="12" fontWeight="bold">Initiate Movement</text>
            </g>

            {/* Select Movement Type */}
            <g transform="translate(200, 50)">
              <polygon points="60,10 110,40 60,70 10,40" fill="yellow" fillOpacity="0.3" stroke="orange" strokeWidth="2"/>
              <text x="60" y="35" textAnchor="middle" fontSize="10" fontWeight="bold">Movement</text>
              <text x="60" y="48" textAnchor="middle" fontSize="10" fontWeight="bold">Type?</text>
            </g>

            {/* Withdrawal Branch */}
            <g transform="translate(350, 50)">
              <rect width="120" height="60" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <text x="60" y="25" textAnchor="middle" fontSize="11" fontWeight="bold">WITHDRAWAL</text>
              <text x="60" y="45" textAnchor="middle" fontSize="10">Main → Sub vault</text>
            </g>

            {/* Handover Branch */}
            <g transform="translate(350, 200)">
              <rect width="120" height="60" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <text x="60" y="25" textAnchor="middle" fontSize="11" fontWeight="bold">HANDOVER</text>
              <text x="60" y="45" textAnchor="middle" fontSize="10">Sub → Main vault</text>
            </g>

            {/* Prepare Cash */}
            <g transform="translate(550, 125)">
              <rect width="120" height="60" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <text x="60" y="25" textAnchor="middle" fontSize="11" fontWeight="bold">Prepare Cash</text>
              <text x="60" y="45" textAnchor="middle" fontSize="10">Count denominations</text>
            </g>

            {/* Update Balances */}
            <g transform="translate(400, 350)">
              <rect width="120" height="60" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <text x="60" y="25" textAnchor="middle" fontSize="11" fontWeight="bold">Update Balances</text>
              <text x="60" y="45" textAnchor="middle" fontSize="10">Status: POSTED</text>
            </g>

            {/* Complete */}
            <g transform="translate(400, 450)">
              <ellipse cx="60" cy="25" rx="60" ry="25" fill="var(--secondary-color)" stroke="var(--primary-color)" strokeWidth="2"/>
              <text x="60" y="30" textAnchor="middle" fontSize="11" fontWeight="bold">Movement Complete</text>
            </g>

            {/* Arrows */}
            <path d="M 120 80 L 190 80" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead2)"/>
            <path d="M 270 60 L 340 70" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead2)"/>
            <path d="M 270 100 L 340 210" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead2)"/>
            <path d="M 470 80 L 540 140" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead2)"/>
            <path d="M 470 230 L 540 170" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead2)"/>
            <path d="M 610 185 L 460 340" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead2)"/>
            <path d="M 460 410 L 460 440" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead2)"/>

            {/* Labels */}
            <text x="280" y="45" fontSize="9" fill="var(--text-secondary)">Withdrawal</text>
            <text x="280" y="195" fontSize="9" fill="var(--text-secondary)">Handover</text>

            <defs>
              <marker id="arrowhead2" markerWidth="10" markerHeight="7" refX="9" refY="3.5" orient="auto">
                <polygon points="0 0, 10 3.5, 0 7" fill="var(--text-secondary)"/>
              </marker>
            </defs>
          </svg>
        </div>
      </div>
    );
  } catch (error) {
    console.error('VaultMovementProcess component error:', error);
    return null;
  }
}

function UserSetupProcess() {
  try {
    return (
      <div className="bg-white rounded-lg shadow-lg p-8" data-name="user-setup-process" data-file="process-diagram-app.js">
        <h2 className="text-2xl font-bold text-[var(--text-primary)] mb-6">User Setup Process</h2>
        
        <div className="relative overflow-x-auto">
          <svg width="800" height="400" className="mx-auto">
            {/* Start Registration */}
            <g transform="translate(50, 50)">
              <ellipse cx="60" cy="30" rx="60" ry="30" fill="var(--secondary-color)" stroke="var(--primary-color)" strokeWidth="2"/>
              <text x="60" y="35" textAnchor="middle" fontSize="12" fontWeight="bold">Admin Setup</text>
            </g>

            {/* Create User */}
            <g transform="translate(180, 50)">
              <rect width="100" height="60" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <text x="50" y="25" textAnchor="middle" fontSize="12" fontWeight="bold">Create User</text>
              <text x="50" y="45" textAnchor="middle" fontSize="11">Name & Username</text>
            </g>

            {/* Assign Role */}
            <g transform="translate(350, 50)">
              <rect width="100" height="60" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <text x="50" y="25" textAnchor="middle" fontSize="12" fontWeight="bold">Assign Role</text>
              <text x="50" y="45" textAnchor="middle" fontSize="11">Select permissions</text>
            </g>

            {/* Set Password */}
            <g transform="translate(520, 50)">
              <rect width="100" height="60" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <text x="50" y="25" textAnchor="middle" fontSize="12" fontWeight="bold">Set Password</text>
              <text x="50" y="45" textAnchor="middle" fontSize="11">Secure credentials</text>
            </g>

            {/* Activate Account */}
            <g transform="translate(350, 200)">
              <rect width="100" height="60" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <text x="50" y="25" textAnchor="middle" fontSize="12" fontWeight="bold">Activate</text>
              <text x="50" y="45" textAnchor="middle" fontSize="11">Enable access</text>
            </g>

            {/* User Ready */}
            <g transform="translate(350, 320)">
              <ellipse cx="50" cy="25" rx="50" ry="25" fill="var(--secondary-color)" stroke="var(--primary-color)" strokeWidth="2"/>
              <text x="50" y="30" textAnchor="middle" fontSize="12" fontWeight="bold">User Ready</text>
            </g>

            {/* Arrows */}
            <path d="M 120 80 L 170 80" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead3)"/>
            <path d="M 280 80 L 340 80" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead3)"/>
            <path d="M 450 80 L 510 80" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead3)"/>
            <path d="M 570 110 L 400 190" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead3)"/>
            <path d="M 400 260 L 400 310" stroke="var(--text-secondary)" strokeWidth="2" fill="none" markerEnd="url(#arrowhead3)"/>

            <defs>
              <marker id="arrowhead3" markerWidth="10" markerHeight="7" refX="9" refY="3.5" orient="auto">
                <polygon points="0 0, 10 3.5, 0 7" fill="var(--text-secondary)"/>
              </marker>
            </defs>
          </svg>
        </div>
        
        <div className="mt-8">
          <h3 className="text-lg font-semibold mb-3">User Roles</h3>
          <div className="grid md:grid-cols-5 gap-4">
            <div className="p-4 border border-[var(--border-color)] rounded-lg text-center">
              <div className="icon-shield text-2xl text-[var(--primary-color)] mb-2"></div>
              <h4 className="font-semibold text-sm">MAIN_VAULT</h4>
              <p className="text-xs text-[var(--text-secondary)]">Full access</p>
            </div>
            <div className="p-4 border border-[var(--border-color)] rounded-lg text-center">
              <div className="icon-users text-2xl text-[var(--primary-color)] mb-2"></div>
              <h4 className="font-semibold text-sm">TELLER</h4>
              <p className="text-xs text-[var(--text-secondary)]">Request cash</p>
            </div>
            <div className="p-4 border border-[var(--border-color)] rounded-lg text-center">
              <div className="icon-briefcase text-2xl text-[var(--primary-color)] mb-2"></div>
              <h4 className="font-semibold text-sm">ADMIN_VAULT</h4>
              <p className="text-xs text-[var(--text-secondary)]">Admin tasks</p>
            </div>
            <div className="p-4 border border-[var(--border-color)] rounded-lg text-center">
              <div className="icon-search text-2xl text-[var(--primary-color)] mb-2"></div>
              <h4 className="font-semibold text-sm">AUDITOR</h4>
              <p className="text-xs text-[var(--text-secondary)]">Review only</p>
            </div>
            <div className="p-4 border border-[var(--border-color)] rounded-lg text-center">
              <div className="icon-settings text-2xl text-[var(--primary-color)] mb-2"></div>
              <h4 className="font-semibold text-sm">ADMIN</h4>
              <p className="text-xs text-[var(--text-secondary)]">System admin</p>
            </div>
          </div>
        </div>
      </div>
    );
  } catch (error) {
    console.error('UserSetupProcess component error:', error);
    return null;
  }
}

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <ErrorBoundary>
    <ProcessDiagramApp />
  </ErrorBoundary>
);
