import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { ShoppingBag, User, LogOut, Menu, X, LogIn } from 'lucide-react';
import { useCart } from '../context/CartContext';
import CartDrawer from './CartDrawer';

const Navbar = () => {
  const navigate = useNavigate();
  const { cartCount } = useCart();
  const [isCartOpen, setIsCartOpen] = useState(false);
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  
  const user = (() => {
    try {
      const savedUser = localStorage.getItem('user');
      return savedUser ? JSON.parse(savedUser) : null;
    } catch (e) {
      console.error("Error parsing user from localStorage:", e);
      return null;
    }
  })();

  const handleLogout = () => {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    navigate('/login');
  };

  return (
    <>
      <nav className="fixed top-0 left-0 right-0 bg-white/80 backdrop-blur-md z-40 border-b border-gray-100">
        <div className="max-w-7xl mx-auto px-4 md:px-8">
          <div className="flex justify-between items-center h-20">
            {/* Logo */}
            <Link to="/" className="flex items-center gap-2">
              <span className="text-2xl font-black text-primary tracking-tighter italic">SOFRA</span>
              <div className="w-2 h-2 bg-primary rounded-full animate-pulse" />
            </Link>

            {/* Desktop Navigation */}
            <div className="hidden md:flex items-center gap-8">
              <Link to="/" className="text-gray-600 font-bold hover:text-primary transition-colors">الرئيسية</Link>
              <Link to="/restaurants" className="text-gray-600 font-bold hover:text-primary transition-colors">المطاعم</Link>
              <Link to="/offers" className="text-gray-600 font-bold hover:text-primary transition-colors">العروض</Link>
            </div>

            {/* Actions */}
            <div className="flex items-center gap-4">
              <button 
                onClick={() => setIsCartOpen(true)}
                className="relative p-3 bg-gray-50 text-gray-700 rounded-2xl hover:bg-primary/10 hover:text-primary transition-all group"
              >
                <ShoppingBag size={24} />
                {cartCount > 0 && (
                  <span className="absolute -top-1 -right-1 w-6 h-6 bg-primary text-white text-xs font-bold rounded-full flex items-center justify-center border-2 border-white shadow-lg shadow-primary/20">
                    {cartCount}
                  </span>
                )}
              </button>

              {user ? (
                <div className="flex items-center gap-3">
                  <div className="hidden md:flex flex-col items-end">
                    <p className="text-sm font-bold text-gray-900 leading-none mb-1">{user.name}</p>
                    <div className="flex gap-2">
                       <button onClick={handleLogout} className="text-[10px] font-bold text-red-500 hover:opacity-70 transition-colors">خروج</button>
                       <span className="text-[10px] text-gray-300">|</span>
                       <Link to="/orders" className="text-[10px] font-bold text-gray-400 hover:text-primary transition-colors">طلباتي</Link>
                    </div>
                  </div>
                  <Link to="/orders" className="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary border border-primary/20 hover:scale-105 transition-transform">
                    <User size={24} />
                  </Link>
                </div>
              ) : (
                <Link 
                  to="/login" 
                  className="hidden md:flex items-center gap-2 px-6 py-3 bg-gray-900 text-white rounded-2xl font-bold hover:bg-black transition-all shadow-lg shadow-black/10"
                >
                  <LogIn size={20} />
                  دخول
                </Link>
              )}

              {/* Mobile Menu Toggle */}
              <button 
                onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
                className="md:hidden p-3 bg-gray-50 text-gray-700 rounded-2xl"
              >
                {isMobileMenuOpen ? <X size={24} /> : <Menu size={24} />}
              </button>
            </div>
          </div>
        </div>

        {/* Mobile Menu */}
        {isMobileMenuOpen && (
          <div className="md:hidden bg-white border-t border-gray-50 p-6 space-y-4 shadow-xl">
            <Link to="/" onClick={() => setIsMobileMenuOpen(false)} className="block text-lg font-bold py-2">الرئيسية</Link>
            <Link to="/restaurants" onClick={() => setIsMobileMenuOpen(false)} className="block text-lg font-bold py-2">المطاعم</Link>
            <Link to="/offers" onClick={() => setIsMobileMenuOpen(false)} className="block text-lg font-bold py-2">العروض</Link>
            {!user && (
              <Link to="/login" onClick={() => setIsMobileMenuOpen(false)} className="block w-full py-4 bg-primary text-white text-center rounded-2xl font-bold">تسجيل الدخول</Link>
            )}
            {user && (
               <>
                 <Link to="/orders" onClick={() => setIsMobileMenuOpen(false)} className="block text-lg font-bold py-2 text-primary">طلباتي</Link>
                 <button onClick={handleLogout} className="block w-full py-4 bg-red-50 text-red-600 rounded-2xl font-bold mt-4">تسجيل الخروج</button>
               </>
            )}
          </div>
        )}
      </nav>

      <CartDrawer isOpen={isCartOpen} onClose={() => setIsCartOpen(false)} />
    </>
  );
};

export default Navbar;
