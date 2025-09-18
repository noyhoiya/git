function Header() {
  try {
    return (
     <header className="bg-white border-b border-[var(--border-color)] px-6 py-4" data-name="header" data-file="components/Header.js">
  
  <div className="flex items-center justify-between">
    
    {/* Left side: Logo + Title */}
    <div className="flex items-center space-x-3">
      
      {/* Full logo */}
      <div className="flex-shrink-0">
        <img 
          src="public\assets\image\logo.png"      // Put your logo in public/image/logo.png
          alt="SSB Logo" 
          className="h-12 w-auto"    // adjust height as needed
        />
      </div>

      {/* Text next to logo */}
      <div>
        <h1 className="text-xl font-bold text-[var(--text-primary)]">ສະຖາບັນຖານເງິນທີ່ຮັບຝາກເອສເອສບີ</h1>
        <p className="text-sm text-[var(--text-secondary)]">SSB Microfinance</p>
      </div>

    </div>

    {/* Right side: Notifications + User */}
    <div className="flex items-center space-x-4">
      <button className="p-2 hover:bg-gray-100 rounded-lg transition-colors">
        <div className="icon-bell text-xl text-[var(--text-secondary)]"></div>
      </button>
      <div className="w-8 h-8 rounded-full bg-[var(--secondary-color)] flex items-center justify-center">
        <div className="icon-user text-lg text-[var(--primary-color)]"></div>
      </div>
    </div>

  </div>
</header>

    );
  } catch (error) {
    console.error('Header component error:', error);
    return null;
  }
}
export default Header;
