import React from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { ShoppingBag, X, Plus, Minus, CreditCard } from 'lucide-react';
import { useCart } from '../context/CartContext';
import { useNavigate } from 'react-router-dom';

const CartDrawer = ({ isOpen, onClose }) => {
  const { cart, addToCart, removeFromCart, cartTotal, cartCount } = useCart();
  const navigate = useNavigate();

  const handleCheckout = () => {
    onClose();
    navigate('/checkout');
  };

  return (
    <AnimatePresence>
      {isOpen && (
        <>
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            onClick={onClose}
            className="fixed inset-0 bg-black/50 backdrop-blur-sm z-50"
          />
          <motion.div
            initial={{ x: '100%' }}
            animate={{ x: 0 }}
            exit={{ x: '100%' }}
            transition={{ type: 'spring', damping: 25, stiffness: 200 }}
            className="fixed top-0 right-0 h-full w-full max-w-md bg-white shadow-2xl z-50 flex flex-col"
          >
            <div className="p-6 border-b border-gray-100 flex items-center justify-between">
              <div className="flex items-center gap-3">
                <ShoppingBag className="text-primary" />
                <h2 className="text-xl font-bold">سلتك ({cartCount})</h2>
              </div>
              <button onClick={onClose} className="p-2 hover:bg-gray-100 rounded-full">
                <X size={24} />
              </button>
            </div>

            <div className="flex-1 overflow-y-auto p-6 space-y-6">
              {cart.length === 0 ? (
                <div className="h-full flex flex-col items-center justify-center text-center">
                  <ShoppingBag size={64} className="text-gray-200 mb-4" />
                  <p className="text-gray-500">سلتك فارغة حالياً</p>
                </div>
              ) : (
                cart.map((item) => (
                  <div key={item.id} className="flex gap-4">
                    <img src={item.photo_url} className="w-20 h-20 rounded-2xl object-cover" alt={item.name} />
                    <div className="flex-1 flex flex-col justify-between">
                      <div>
                        <h4 className="font-bold">{item.name}</h4>
                        <p className="text-primary font-bold text-sm">{item.price} ج.م</p>
                      </div>
                      <div className="flex items-center gap-4 bg-gray-50 self-start p-1 rounded-xl">
                        <button 
                          onClick={() => removeFromCart(item.id)}
                          className="bg-white p-1 rounded-lg shadow-sm hover:text-primary"
                        >
                          <Minus size={16} />
                        </button>
                        <span className="font-bold">{item.quantity}</span>
                        <button 
                          onClick={() => addToCart(item, item.restaurant_id)}
                          className="bg-white p-1 rounded-lg shadow-sm hover:text-primary"
                        >
                          <Plus size={16} />
                        </button>
                      </div>
                    </div>
                  </div>
                ))
              )}
            </div>

            {cart.length > 0 && (
              <div className="p-6 border-t border-gray-100 space-y-4">
                <div className="flex items-center justify-between text-xl font-bold">
                  <span>المجموع</span>
                  <span className="text-primary">{cartTotal} ج.م</span>
                </div>
                <button 
                  onClick={handleCheckout}
                  className="w-full py-4 bg-primary text-white rounded-2xl font-bold text-lg flex items-center justify-center gap-3 hover:opacity-90 transition-opacity"
                >
                  <CreditCard />
                  إتمام الطلب
                </button>
              </div>
            )}
          </motion.div>
        </>
      )}
    </AnimatePresence>
  );
};

export default CartDrawer;
