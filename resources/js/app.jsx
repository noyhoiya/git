import React from 'react';
import ReactDOM from 'react-dom/client';
import './app.css';

function App() {
  const [dark, setDark] = React.useState(localStorage.getItem('theme') === 'dark');

  React.useEffect(() => {
    document.documentElement.classList.toggle('dark', dark);
    localStorage.setItem('theme', dark ? 'dark' : 'light');
  }, [dark]);

  return (
    <div className="min-h-screen bg-[var(--background-light)] text-[var(--text-primary)] flex flex-col items-center justify-center">
      <h1 className="text-3xl font-bold mb-4">Tailwind + React + Dark Mode</h1>
      <button
        className="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
        onClick={() => setDark(!dark)}
      >
        Toggle Theme
      </button>
    </div>
  );
}

const root = ReactDOM.createRoot(document.getElementById('root'));
console.log('resources/js/app.jsx loaded');
root.render(<App />);
