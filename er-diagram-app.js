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

function ERDiagramApp() {
  try {
    return (
      <div className="min-h-screen bg-[var(--background-light)]" data-name="er-diagram-app" data-file="er-diagram-app.js">
        <Header />
        <main className="container mx-auto px-6 py-8">
          <div className="mb-8">
            <h1 className="text-3xl font-bold text-[var(--text-primary)] mb-4">Cash Center Database Structure</h1>
            <p className="text-[var(--text-secondary)]">Entity Relationship Diagram for the Cash Center Application</p>
          </div>
          
          <ERDiagram />
          
          <DatabaseSchema />
        </main>
      </div>
    );
  } catch (error) {
    console.error('ERDiagramApp component error:', error);
    return null;
  }
}

function Header() {
  try {
    return (
      <header className="bg-white border-b border-[var(--border-color)] px-6 py-4" data-name="header" data-file="er-diagram-app.js">
        <div className="flex items-center justify-between">
          <div className="flex items-center space-x-3">
            <div className="w-8 h-8 rounded-lg bg-[var(--primary-color)] flex items-center justify-center">
              <div className="icon-database text-lg text-white"></div>
            </div>
            <div>
              <h1 className="text-xl font-bold text-[var(--text-primary)]">Cash Center ER Diagram(ຄວາມສຳພັນຂອງຂໍ້ມູນຄັງເງິນສົດ)</h1>
              <p className="text-sm text-[var(--text-secondary)]">ໂຄງສ້າງຖານຂໍ້ມູນ
              </p>
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

function ERDiagram() {
  try {
    return (
      <div className="bg-white rounded-lg shadow-lg p-8 mb-8" data-name="er-diagram" data-file="er-diagram-app.js">
        <h2 className="text-2xl font-bold text-[var(--text-primary)] mb-6">Entity Relationship Diagram</h2>
        
        <div className="relative min-h-96 overflow-x-auto">
          <svg width="1200" height="800" className="mx-auto">
            {/* Users Entity */}
            <g transform="translate(50, 50)">
              <rect width="160" height="140" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <rect width="160" height="25" fill="var(--primary-color)" rx="8 8 0 0"/>
              <text x="80" y="18" textAnchor="middle" fill="white" fontSize="12" fontWeight="bold">USERS</text>
              <text x="8" y="40" fontSize="10" fill="var(--primary-color)" fontWeight="bold">• user_id (PK)</text>
              <text x="8" y="55" fontSize="10" fill="var(--text-primary)">• full_name</text>
              <text x="8" y="70" fontSize="10" fill="var(--text-primary)">• username</text>
              <text x="8" y="85" fontSize="10" fill="var(--text-primary)">• password_hash</text>
              <text x="8" y="100" fontSize="10" fill="blue" fontWeight="bold">• role_id (FK)</text>
              <text x="8" y="115" fontSize="10" fill="var(--text-primary)">• is_active</text>
              <text x="8" y="130" fontSize="10" fill="var(--text-primary)">• created_at</text>
            </g>

            {/* Roles Entity */}
            <g transform="translate(300, 50)">
              <rect width="140" height="80" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <rect width="140" height="25" fill="var(--primary-color)" rx="8 8 0 0"/>
              <text x="70" y="18" textAnchor="middle" fill="white" fontSize="12" fontWeight="bold">ROLES</text>
              <text x="8" y="40" fontSize="10" fill="var(--primary-color)" fontWeight="bold">• role_id (PK)</text>
              <text x="8" y="55" fontSize="10" fill="var(--text-primary)">• role_name</text>
            </g>

            {/* Vaults Entity */}
            <g transform="translate(550, 50)">
              <rect width="180" height="140" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <rect width="180" height="25" fill="var(--primary-color)" rx="8 8 0 0"/>
              <text x="90" y="18" textAnchor="middle" fill="white" fontSize="12" fontWeight="bold">VAULTS</text>
              <text x="8" y="40" fontSize="10" fill="var(--primary-color)" fontWeight="bold">• vault_id (PK)</text>
              <text x="8" y="55" fontSize="10" fill="var(--text-primary)">• vault_name</text>
              <text x="8" y="70" fontSize="10" fill="var(--text-primary)">• vault_type</text>
              <text x="8" y="85" fontSize="10" fill="var(--text-primary)">• current_balance_cents</text>
              <text x="8" y="100" fontSize="10" fill="var(--text-primary)">• is_active</text>
              <text x="8" y="115" fontSize="10" fill="var(--text-primary)">• created_at</text>
            </g>

            {/* Cash Requests Entity */}
            <g transform="translate(50, 250)">
              <rect width="200" height="200" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <rect width="200" height="25" fill="var(--primary-color)" rx="8 8 0 0"/>
              <text x="100" y="18" textAnchor="middle" fill="white" fontSize="12" fontWeight="bold">CASH_REQUESTS</text>
              <text x="8" y="40" fontSize="10" fill="var(--primary-color)" fontWeight="bold">• request_id (PK)</text>
              <text x="8" y="55" fontSize="10" fill="blue" fontWeight="bold">• requester_vault_id (FK)</text>
              <text x="8" y="70" fontSize="10" fill="blue" fontWeight="bold">• requester_user_id (FK)</text>
              <text x="8" y="85" fontSize="10" fill="var(--text-primary)">• amount_cents</text>
              <text x="8" y="100" fontSize="10" fill="var(--text-primary)">• amount_in_words</text>
              <text x="8" y="115" fontSize="10" fill="blue" fontWeight="bold">• purpose_code (FK)</text>
              <text x="8" y="130" fontSize="10" fill="var(--text-primary)">• purpose_text</text>
              <text x="8" y="145" fontSize="10" fill="var(--text-primary)">• status</text>
              <text x="8" y="160" fontSize="10" fill="var(--text-primary)">• created_at</text>
              <text x="8" y="175" fontSize="10" fill="blue" fontWeight="bold">• approver_user_id (FK)</text>
              <text x="8" y="190" fontSize="10" fill="var(--text-primary)">• notes</text>
            </g>

            {/* Vault Movements Entity */}
            <g transform="translate(350, 250)">
              <rect width="220" height="220" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <rect width="220" height="25" fill="var(--primary-color)" rx="8 8 0 0"/>
              <text x="110" y="18" textAnchor="middle" fill="white" fontSize="12" fontWeight="bold">VAULT_MOVEMENTS</text>
              <text x="8" y="40" fontSize="10" fill="var(--primary-color)" fontWeight="bold">• movement_id (PK)</text>
              <text x="8" y="55" fontSize="10" fill="var(--text-primary)">• type</text>
              <text x="8" y="70" fontSize="10" fill="blue" fontWeight="bold">• from_vault_id (FK)</text>
              <text x="8" y="85" fontSize="10" fill="blue" fontWeight="bold">• to_vault_id (FK)</text>
              <text x="8" y="100" fontSize="10" fill="blue" fontWeight="bold">• request_id (FK)</text>
              <text x="8" y="115" fontSize="10" fill="var(--text-primary)">• amount_cents</text>
              <text x="8" y="130" fontSize="10" fill="var(--text-primary)">• amount_in_words</text>
              <text x="8" y="145" fontSize="10" fill="blue" fontWeight="bold">• purpose_code (FK)</text>
              <text x="8" y="160" fontSize="10" fill="var(--text-primary)">• purpose_text</text>
              <text x="8" y="175" fontSize="10" fill="var(--text-primary)">• status</text>
              <text x="8" y="190" fontSize="10" fill="blue" fontWeight="bold">• created_by_user_id (FK)</text>
              <text x="8" y="205" fontSize="10" fill="blue" fontWeight="bold">• released_by_user_id (FK)</text>
            </g>

            {/* Purposes Entity */}
            <g transform="translate(650, 250)">
              <rect width="160" height="80" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <rect width="160" height="25" fill="var(--primary-color)" rx="8 8 0 0"/>
              <text x="80" y="18" textAnchor="middle" fill="white" fontSize="12" fontWeight="bold">PURPOSES</text>
              <text x="8" y="40" fontSize="10" fill="var(--primary-color)" fontWeight="bold">• purpose_code (PK)</text>
              <text x="8" y="55" fontSize="10" fill="var(--text-primary)">• purpose_name</text>
            </g>

            {/* Request Denoms Entity */}
            <g transform="translate(50, 520)">
              <rect width="200" height="100" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <rect width="200" height="25" fill="var(--primary-color)" rx="8 8 0 0"/>
              <text x="100" y="18" textAnchor="middle" fill="white" fontSize="12" fontWeight="bold">CASH_REQUEST_DENOMS</text>
              <text x="8" y="40" fontSize="10" fill="var(--primary-color)" fontWeight="bold">• id (PK)</text>
              <text x="8" y="55" fontSize="10" fill="blue" fontWeight="bold">• request_id (FK)</text>
              <text x="8" y="70" fontSize="10" fill="var(--text-primary)">• denomination</text>
              <text x="8" y="85" fontSize="10" fill="var(--text-primary)">• quantity</text>
            </g>

            {/* Movement Denoms Entity */}
            <g transform="translate(350, 520)">
              <rect width="220" height="100" fill="white" stroke="var(--primary-color)" strokeWidth="2" rx="8"/>
              <rect width="220" height="25" fill="var(--primary-color)" rx="8 8 0 0"/>
              <text x="110" y="18" textAnchor="middle" fill="white" fontSize="12" fontWeight="bold">VAULT_MOVEMENT_DENOMS</text>
              <text x="8" y="40" fontSize="10" fill="var(--primary-color)" fontWeight="bold">• id (PK)</text>
              <text x="8" y="55" fontSize="10" fill="blue" fontWeight="bold">• movement_id (FK)</text>
              <text x="8" y="70" fontSize="10" fill="var(--text-primary)">• denomination</text>
              <text x="8" y="85" fontSize="10" fill="var(--text-primary)">• quantity</text>
            </g>

            {/* Relationship Lines */}
            <line x1="210" y1="120" x2="300" y2="120" stroke="var(--text-secondary)" strokeWidth="2"/>
            <line x1="150" y1="190" x2="150" y2="250" stroke="var(--text-secondary)" strokeWidth="2"/>
            <line x1="150" y1="450" x2="150" y2="520" stroke="var(--text-secondary)" strokeWidth="2"/>
            <line x1="460" y1="470" x2="460" y2="520" stroke="var(--text-secondary)" strokeWidth="2"/>
            <line x1="250" y1="350" x2="350" y2="350" stroke="var(--text-secondary)" strokeWidth="2"/>
            <line x1="570" y1="350" x2="650" y2="290" stroke="var(--text-secondary)" strokeWidth="2"/>
            <line x1="590" y1="190" x2="590" y2="250" stroke="var(--text-secondary)" strokeWidth="2"/>
            <line x1="100" y1="190" x2="100" y2="250" stroke="var(--text-secondary)" strokeWidth="2"/>

            {/* Relationship Labels */}
            <text x="255" y="115" fontSize="8" fill="var(--text-secondary)">1:N</text>
            <text x="155" y="220" fontSize="8" fill="var(--text-secondary)">1:N</text>
            <text x="155" y="485" fontSize="8" fill="var(--text-secondary)">1:N</text>
            <text x="465" y="495" fontSize="8" fill="var(--text-secondary)">1:N</text>
            <text x="300" y="345" fontSize="8" fill="var(--text-secondary)">1:N</text>
            <text x="600" y="280" fontSize="8" fill="var(--text-secondary)">N:1</text>
          </svg>
        </div>
      </div>
    );
  } catch (error) {
    console.error('ERDiagram component error:', error);
    return null;
  }
}

function DatabaseSchema() {
  try {
    const tables = [
      {
        name: 'roles',
        description: 'User role definitions for access control',
        fields: [
          { name: 'role_id', type: 'INT', constraint: 'PRIMARY KEY', description: 'Unique role identifier' },
          { name: 'role_name', type: 'VARCHAR(50)', constraint: 'UNIQUE', description: 'Role name (MAIN_VAULT, TELLER, etc.)' }
        ]
      },
      {
        name: 'users',
        description: 'System user accounts with role-based access',
        fields: [
          { name: 'user_id', type: 'INT', constraint: 'PRIMARY KEY', description: 'Unique user identifier' },
          { name: 'full_name', type: 'VARCHAR(120)', constraint: '', description: 'User full name' },
          { name: 'username', type: 'VARCHAR(60)', constraint: 'UNIQUE', description: 'Login username' },
          { name: 'password_hash', type: 'VARCHAR(255)', constraint: '', description: 'Encrypted password' },
          { name: 'role_id', type: 'INT', constraint: 'FOREIGN KEY', description: 'Reference to roles table' },
          { name: 'is_active', type: 'TINYINT(1)', constraint: '', description: 'Active status flag' },
          { name: 'created_at', type: 'DATETIME', constraint: '', description: 'Account creation timestamp' }
        ]
      },
      {
        name: 'vaults',
        description: 'Cash vault definitions (Main, Sub vaults)',
        fields: [
          { name: 'vault_id', type: 'INT', constraint: 'PRIMARY KEY', description: 'Unique vault identifier' },
          { name: 'vault_name', type: 'VARCHAR(80)', constraint: 'UNIQUE', description: 'Vault display name' },
          { name: 'vault_type', type: 'ENUM', constraint: '', description: 'MAIN or SUB vault type' },
          { name: 'current_balance_cents', type: 'BIGINT', constraint: '', description: 'Balance stored in cents' },
          { name: 'is_active', type: 'TINYINT(1)', constraint: '', description: 'Active status flag' },
          { name: 'created_at', type: 'DATETIME', constraint: '', description: 'Creation timestamp' }
        ]
      },
      {
        name: 'purposes',
        description: 'Pre-defined transaction purposes',
        fields: [
          { name: 'purpose_code', type: 'VARCHAR(32)', constraint: 'PRIMARY KEY', description: 'Purpose code identifier' },
          { name: 'purpose_name', type: 'VARCHAR(255)', constraint: '', description: 'Purpose description' }
        ]
      },
      {
        name: 'cash_requests',
        description: 'Cash withdrawal requests from sub-vaults',
        fields: [
          { name: 'request_id', type: 'BIGINT', constraint: 'PRIMARY KEY', description: 'Unique request identifier' },
          { name: 'requester_vault_id', type: 'INT', constraint: 'FOREIGN KEY', description: 'Requesting vault ID' },
          { name: 'requester_user_id', type: 'INT', constraint: 'FOREIGN KEY', description: 'Requesting user ID' },
          { name: 'amount_cents', type: 'BIGINT', constraint: 'CHECK > 0', description: 'Requested amount in cents' },
          { name: 'amount_in_words', type: 'VARCHAR(255)', constraint: '', description: 'Amount written in words' },
          { name: 'purpose_code', type: 'VARCHAR(32)', constraint: 'FOREIGN KEY', description: 'Purpose reference' },
          { name: 'purpose_text', type: 'VARCHAR(255)', constraint: '', description: 'Additional purpose details' },
          { name: 'status', type: 'ENUM', constraint: '', description: 'PENDING, APPROVED, REJECTED, CANCELLED' },
          { name: 'created_at', type: 'DATETIME', constraint: '', description: 'Request creation time' },
          { name: 'approver_user_id', type: 'INT', constraint: 'FOREIGN KEY', description: 'Approving user ID' },
          { name: 'notes', type: 'VARCHAR(255)', constraint: '', description: 'Additional notes' }
        ]
      },
      {
        name: 'vault_movements',
        description: 'Cash movements between vaults (withdrawals/handovers)',
        fields: [
          { name: 'movement_id', type: 'BIGINT', constraint: 'PRIMARY KEY', description: 'Unique movement identifier' },
          { name: 'type', type: 'ENUM', constraint: '', description: 'WITHDRAWAL or HANDOVER' },
          { name: 'from_vault_id', type: 'INT', constraint: 'FOREIGN KEY', description: 'Source vault ID' },
          { name: 'to_vault_id', type: 'INT', constraint: 'FOREIGN KEY', description: 'Destination vault ID' },
          { name: 'request_id', type: 'BIGINT', constraint: 'FOREIGN KEY', description: 'Related request ID' },
          { name: 'amount_cents', type: 'BIGINT', constraint: 'CHECK > 0', description: 'Movement amount in cents' },
          { name: 'amount_in_words', type: 'VARCHAR(255)', constraint: '', description: 'Amount in words' },
          { name: 'status', type: 'ENUM', constraint: '', description: 'DRAFT, POSTED, VOID' },
          { name: 'created_by_user_id', type: 'INT', constraint: 'FOREIGN KEY', description: 'Creating user ID' },
          { name: 'released_by_user_id', type: 'INT', constraint: 'FOREIGN KEY', description: 'Cash releasing user ID' },
          { name: 'received_by_user_id', type: 'INT', constraint: 'FOREIGN KEY', description: 'Cash receiving user ID' }
        ]
      },
      {
        name: 'cash_request_denoms',
        description: 'Denomination breakdown for cash requests',
        fields: [
          { name: 'id', type: 'BIGINT', constraint: 'PRIMARY KEY', description: 'Unique record identifier' },
          { name: 'request_id', type: 'BIGINT', constraint: 'FOREIGN KEY', description: 'Related request ID' },
          { name: 'denomination', type: 'INT', constraint: '', description: 'Currency denomination value' },
          { name: 'quantity', type: 'INT', constraint: 'CHECK >= 0', description: 'Number of notes/coins' }
        ]
      },
      {
        name: 'vault_movement_denoms',
        description: 'Denomination breakdown for vault movements',
        fields: [
          { name: 'id', type: 'BIGINT', constraint: 'PRIMARY KEY', description: 'Unique record identifier' },
          { name: 'movement_id', type: 'BIGINT', constraint: 'FOREIGN KEY', description: 'Related movement ID' },
          { name: 'denomination', type: 'INT', constraint: '', description: 'Currency denomination value' },
          { name: 'quantity', type: 'INT', constraint: 'CHECK >= 0', description: 'Number of notes/coins' }
        ]
      }
    ];

    return (
      <div className="bg-white rounded-lg shadow-lg p-8" data-name="database-schema" data-file="er-diagram-app.js">
        <h2 className="text-2xl font-bold text-[var(--text-primary)] mb-6">Database Schema Details</h2>
        
        <div className="grid gap-6">
          {tables.map(table => (
            <div key={table.name} className="border border-[var(--border-color)] rounded-lg">
              <div className="bg-[var(--secondary-color)] px-6 py-4 border-b border-[var(--border-color)]">
                <h3 className="text-lg font-bold text-[var(--text-primary)] capitalize">{table.name}</h3>
                <p className="text-[var(--text-secondary)] text-sm mt-1">{table.description}</p>
              </div>
              <div className="p-6">
                <div className="overflow-x-auto">
                  <table className="w-full text-sm">
                    <thead>
                      <tr className="border-b border-[var(--border-color)]">
                        <th className="text-left py-2 text-[var(--text-primary)] font-medium">Field</th>
                        <th className="text-left py-2 text-[var(--text-primary)] font-medium">Type</th>
                        <th className="text-left py-2 text-[var(--text-primary)] font-medium">Constraint</th>
                        <th className="text-left py-2 text-[var(--text-primary)] font-medium">Description</th>
                      </tr>
                    </thead>
                    <tbody>
                      {table.fields.map(field => (
                        <tr key={field.name} className="border-b border-gray-100 last:border-b-0">
                          <td className={`py-3 ${field.constraint.includes('PRIMARY') ? 'text-[var(--primary-color)] font-bold' : field.constraint.includes('FOREIGN') ? 'text-blue-600 font-medium' : ''}`}>
                            {field.name}
                          </td>
                          <td className="py-3 text-[var(--text-secondary)]">{field.type}</td>
                          <td className="py-3 text-[var(--text-secondary)]">{field.constraint}</td>
                          <td className="py-3 text-[var(--text-secondary)]">{field.description}</td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    );
  } catch (error) {
    console.error('DatabaseSchema component error:', error);
    return null;
  }
}

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <ErrorBoundary>
    <ERDiagramApp />
  </ErrorBoundary>
);
