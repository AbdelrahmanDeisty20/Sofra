import React from 'react';
import { ShoppingBag, Utensils, Search, MapPin } from 'lucide-react';
import { motion } from 'framer-motion';
import { useNavigate } from 'react-router-dom';

const Landing = () => {
  const navigate = useNavigate();
  return (
    <div className="relative overflow-hidden">
      {/* Hero Section */}
      <section className="relative min-h-screen flex items-center justify-center pt-20 pb-32 px-4">
        {/* Background Decorations */}
        <div className="absolute top-0 left-0 w-64 h-64 bg-primary-light/10 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl" />
        <div className="absolute bottom-0 right-0 w-96 h-96 bg-primary/5 rounded-full translate-x-1/3 translate-y-1/3 blur-3xl" />

        <div className="max-w-7xl mx-auto text-center z-10">
          <motion.div 
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
            className="mb-8"
          >
            <div className="inline-flex items-center bg-white border border-gray-100 px-4 py-2 rounded-full shadow-sm mb-6">
              <span className="flex h-2 w-2 rounded-full bg-primary mr-2 animate-pulse" />
              <span className="text-sm font-medium text-gray-600">اطلب طعامك المفضل الآن</span>
            </div>
            
            <h1 className="text-5xl md:text-7xl font-bold text-gray-900 mb-6 leading-tight">
              تجربة طعام <span className="text-primary italic">فاخرة</span> <br />
              تصلك أينما كنت
            </h1>
            
            <p className="text-lg md:text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
              اكتشف أفضل المطاعم في منطقتك، واستمتع بعروض حصرية، وخدمة توصيل سريعة وآمنة.
            </p>

            <div className="flex flex-col sm:flex-row items-center justify-center gap-4">
              <motion.button 
                whileHover={{ scale: 1.05 }}
                whileTap={{ scale: 0.95 }}
                onClick={() => navigate('/restaurants')}
                className="w-full sm:w-auto px-8 py-4 bg-primary text-white rounded-2xl font-bold text-lg shadow-xl shadow-primary/20 flex items-center justify-center gap-2"
              >
                <Utensils size={24} />
                أنا جائع (اطلب الآن)
              </motion.button>
              
              <motion.button 
                whileHover={{ scale: 1.05 }}
                whileTap={{ scale: 0.95 }}
                className="w-full sm:w-auto px-8 py-4 bg-white text-gray-900 border border-gray-200 rounded-2xl font-bold text-lg shadow-sm flex items-center justify-center gap-2"
              >
                <ShoppingBag size={24} />
                سجل مطعمك (انضم لنا)
              </motion.button>
            </div>
          </motion.div>

          {/* Search Bar Mockup */}
          <motion.div 
            initial={{ opacity: 0, scale: 0.95 }}
            animate={{ opacity: 1, scale: 1 }}
            transition={{ delay: 0.3, duration: 0.5 }}
            className="mt-16 bg-white p-2 rounded-3xl shadow-2xl max-w-4xl mx-auto flex flex-col md:row gap-2 border border-gray-100"
          >
            <div className="flex-1 flex items-center px-4 py-3 gap-3 border-b md:border-b-0 md:border-l border-gray-100">
              <MapPin className="text-primary" size={24} />
              <input 
                type="text" 
                placeholder="أين أنت؟ (المدينة، الحي)" 
                className="flex-1 bg-transparent border-none focus:ring-0 text-right font-medium" 
                dir="rtl"
              />
            </div>
            <div className="flex-1 flex items-center px-4 py-3 gap-3">
              <Search className="text-gray-400" size={24} />
              <input 
                type="text" 
                placeholder="ابحث عن مطعم أو وجبة..." 
                className="flex-1 bg-transparent border-none focus:ring-0 text-right font-medium" 
                dir="rtl"
              />
            </div>
            <button className="bg-gray-900 text-white px-8 py-4 rounded-2xl font-bold hover:bg-black transition-colors">
              بحث
            </button>
          </motion.div>
        </div>

        {/* Floating elements for visual flair */}
        <div className="hidden lg:block absolute top-1/4 left-10 animate-bounce cursor-default">
           <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=150" 
                className="w-24 h-24 rounded-full border-4 border-white shadow-xl" alt="food" />
        </div>
        <div className="hidden lg:block absolute bottom-1/4 right-10 animate-pulse cursor-default">
           <img src="https://images.unsplash.com/photo-1567620905732-2d1ec7bb7445?auto=format&fit=crop&q=80&w=150" 
                className="w-24 h-24 rounded-full border-4 border-white shadow-xl" alt="food" />
        </div>
      </section>

      {/* Featured Sections could go here */}
    </div>
  );
};

export default Landing;
