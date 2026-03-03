import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { motion, AnimatePresence } from 'framer-motion';
import { 
  Star, 
  Clock, 
  MapPin, 
  ChevronRight, 
  ShoppingBag, 
  Plus, 
  Minus,
  Info 
} from 'lucide-react';
import apiClient from '../api/axios';
import { useCart } from '../context/CartContext';
import CartDrawer from '../components/CartDrawer';

const RestaurantDetails = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const { cart, addToCart, removeFromCart, cartTotal, cartCount } = useCart();
  const [restaurant, setRestaurant] = useState(null);
  const [foods, setFoods] = useState([]);
  const [loading, setLoading] = useState(true);
  const [selectedCategory, setSelectedCategory] = useState('all');
  const [isCartOpen, setIsCartOpen] = useState(false);

  const getItemQuantity = (id) => {
    return cart.find(item => item.id === id)?.quantity || 0;
  };

  useEffect(() => {
    const fetchDetails = async () => {
      try {
        const [resDetails, resFoods] = await Promise.all([
          apiClient.get(`/restaurant?restaurant_id=${id}`),
          apiClient.get(`/foods?restaurant_id=${id}`)
        ]);
        setRestaurant(resDetails.data.data);
        setFoods(resFoods.data.data.data || []);
      } catch (error) {
        console.error("Error fetching details:", error);
      } finally {
        setLoading(false);
      }
    };
    fetchDetails();
  }, [id]);

  if (loading) return (
    <div className="min-h-screen flex items-center justify-center bg-gray-50">
      <div className="w-12 h-12 border-4 border-primary border-t-transparent rounded-full animate-spin" />
    </div>
  );

  if (!restaurant) return (
    <div className="min-h-screen flex flex-col items-center justify-center bg-gray-50 p-4">
      <h2 className="text-2xl font-bold mb-4">المطعم غير موجود</h2>
      <button onClick={() => navigate('/restaurants')} className="bg-primary text-white px-6 py-2 rounded-xl">عودة للقائمة</button>
    </div>
  );

  return (
    <div className="min-h-screen bg-gray-50 pb-20">
      {/* Header Banner */}
      <div className="relative h-64 md:h-80 w-full overflow-hidden">
        <img 
          src={restaurant.image_url || 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&q=80&w=1200'} 
          className="w-full h-full object-cover"
          alt={restaurant.name}
        />
        <div className="absolute inset-0 bg-black/40 backdrop-blur-sm" />
        
        <div className="absolute bottom-0 left-0 right-0 p-6 md:p-12 text-white">
          <div className="max-w-7xl mx-auto flex flex-col md:flex-row items-end md:items-center gap-6">
             <motion.img 
                initial={{ scale: 0.8, opacity: 0 }}
                animate={{ scale: 1, opacity: 1 }}
                src={restaurant.image_url} 
                className="w-24 h-24 md:w-32 md:h-32 rounded-3xl border-4 border-white shadow-2xl object-cover bg-white"
             />
             <div className="flex-1 text-right">
                <h1 className="text-3xl md:text-5xl font-extrabold mb-2">{restaurant.name}</h1>
                <div className="flex items-center justify-end gap-4 text-sm md:text-base opacity-90">
                   <div className="flex items-center gap-1"><MapPin size={18} /> {restaurant.region?.name}</div>
                   <div className="flex items-center gap-1"><Star size={18} className="text-yellow-400 fill-yellow-400" /> 4.8 (500+)</div>
                   <div className="flex items-center gap-1"><Clock size={18} /> 30-45 دقيقة</div>
                </div>
             </div>
          </div>
        </div>
      </div>

      <main className="max-w-7xl mx-auto px-4 md:px-8 mt-12 grid grid-cols-1 lg:grid-cols-3 gap-12">
        {/* Menu Section */}
        <div className="lg:col-span-2">
          <div className="flex items-center justify-between mb-8">
            <h2 className="text-2xl font-bold">قائمة الطعام</h2>
          </div>

          <div className="grid grid-cols-1 gap-6">
            {foods.map((food) => (
              <motion.div 
                key={food.id}
                initial={{ opacity: 0, x: -20 }}
                animate={{ opacity: 1, x: 0 }}
                className="bg-white rounded-3xl p-4 flex gap-4 border border-gray-100 shadow-sm hover:shadow-md transition-shadow group"
              >
                <div className="w-24 h-24 md:w-32 md:h-32 rounded-2xl overflow-hidden flex-shrink-0">
                  <img src={food.photo_url} className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt={food.name} />
                </div>
                <div className="flex-1 flex flex-col justify-between py-1 text-right">
                  <div>
                    <h3 className="text-xl font-bold mb-1">{food.name}</h3>
                    <p className="text-gray-500 text-sm line-clamp-2">{food.description}</p>
                  </div>
                  <div className="flex items-center justify-between mt-4">
                    <span className="text-xl font-bold text-primary">{food.price} ج.م</span>
                    <div className="flex items-center gap-3">
                       {getItemQuantity(food.id) > 0 && (
                         <div className="flex items-center gap-3 bg-gray-50 p-1 rounded-xl">
                            <button 
                              onClick={() => removeFromCart(food.id)}
                              className="bg-white p-2 rounded-lg shadow-sm hover:text-primary transition-colors"
                            >
                              <Minus size={20} />
                            </button>
                            <span className="font-bold min-w-[20px] text-center">{getItemQuantity(food.id)}</span>
                         </div>
                       )}
                       <button 
                        onClick={() => addToCart(food, restaurant.id)}
                        className="bg-primary text-white p-2 rounded-xl hover:scale-110 active:scale-95 transition-all"
                       >
                        <Plus size={24} />
                       </button>
                    </div>
                  </div>
                </div>
              </motion.div>
            ))}
          </div>
        </div>

        {/* Sidebar Info */}
        <div className="space-y-8">
           <div className="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
              <h3 className="text-lg font-bold mb-4 flex items-center gap-2">
                 <Info size={20} className="text-primary" />
                 معلومات المطعم
              </h3>
              <ul className="space-y-4 text-gray-600">
                 <li className="flex justify-between items-center bg-gray-50 p-3 rounded-2xl">
                    <span className="font-bold">{restaurant.minimum_order} ج.م</span>
                    <span>الحد الأدنى للطلب</span>
                 </li>
                 <li className="flex justify-between items-center bg-gray-50 p-3 rounded-2xl">
                    <span className="font-bold">{restaurant.delivery_charge} ج.م</span>
                    <span>رسوم التوصيل</span>
                 </li>
                 <li className="flex justify-between items-center bg-gray-50 p-3 rounded-2xl">
                    <span className="font-bold text-green-600">مفتوح الآن</span>
                    <span>حالة المطعم</span>
                 </li>
              </ul>
           </div>

           {/* Cart Sidebar */}
           <div className="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm sticky top-24">
              <div className="flex items-center gap-3 mb-6">
                <ShoppingBag className="text-primary" size={28} />
                <h3 className="text-xl font-bold">سلتك ({cartCount})</h3>
              </div>
              
              {cart.length === 0 ? (
                <p className="text-gray-400 mb-6 text-sm">السلة فارغة حالياً. ابدأ بإضافة بعض الوجبات اللذيذة!</p>
              ) : (
                <div className="space-y-4 mb-6 max-h-[300px] overflow-y-auto pr-2">
                  {cart.map(item => (
                    <div key={item.id} className="flex justify-between items-center text-sm">
                      <div className="flex items-center gap-2">
                         <span className="font-bold text-primary">{item.quantity}x</span>
                         <span className="text-gray-700 line-clamp-1">{item.name}</span>
                      </div>
                      <span className="font-bold">{item.price * item.quantity} ج.م</span>
                    </div>
                  ))}
                </div>
              )}

              <div className="pt-4 border-t border-gray-100 mb-6">
                 <div className="flex justify-between items-center text-lg font-bold">
                    <span>المجموع</span>
                    <span className="text-primary">{cartTotal} ج.م</span>
                 </div>
              </div>

              <button 
                onClick={() => setIsCartOpen(true)}
                disabled={cartCount === 0}
                className={`w-full py-4 rounded-2xl font-bold text-lg transition-all ${
                  cartCount > 0 
                  ? 'bg-primary text-white shadow-lg shadow-primary/20 hover:opacity-90' 
                  : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                }`}
              >
                 مراجعة الطلب
              </button>
           </div>
        </div>
      </main>

      <CartDrawer isOpen={isCartOpen} onClose={() => setIsCartOpen(false)} />
    </div>
  );
};

export default RestaurantDetails;
