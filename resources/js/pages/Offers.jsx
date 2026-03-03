import React, { useEffect, useState } from 'react';
import { motion } from 'framer-motion';
import { Tag, Clock, Utensils, ChevronRight } from 'lucide-react';
import { useNavigate } from 'react-router-dom';
import apiClient from '../api/axios';

const Offers = () => {
  const [offers, setOffers] = useState([]);
  const [loading, setLoading] = useState(true);
  const navigate = useNavigate();

  useEffect(() => {
    const fetchOffers = async () => {
      try {
        const response = await apiClient.get('/offers');
        setOffers(response.data.data.data || []);
      } catch (error) {
        console.error("Error fetching offers:", error);
      } finally {
        setLoading(false);
      }
    };
    fetchOffers();
  }, []);

  if (loading) return (
    <div className="min-h-screen flex items-center justify-center bg-gray-50">
      <div className="w-12 h-12 border-4 border-primary border-t-transparent rounded-full animate-spin" />
    </div>
  );

  return (
    <div className="min-h-screen bg-gray-50 pb-20 px-4 md:px-8">
      <div className="max-w-7xl mx-auto pt-12">
        <div className="text-center mb-16">
          <motion.div 
            initial={{ scale: 0.9, opacity: 0 }}
            animate={{ scale: 1, opacity: 1 }}
            className="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-full font-bold mb-4"
          >
            <Tag size={18} />
            وفّر أكثر مع عروضنا
          </motion.div>
          <h1 className="text-4xl md:text-5xl font-black text-gray-900 mb-4 tracking-tight">أحدث العروض الحصرية</h1>
          <p className="text-gray-500 text-lg">استمتع بوجباتك المفضلة بأسعار لا تقبل المنافسة</p>
        </div>

        {offers.length === 0 ? (
          <div className="text-center py-20">
             <div className="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <Tag size={40} className="text-gray-300" />
             </div>
             <p className="text-gray-500 text-xl font-medium">لا توجد عروض متاحة حالياً. تفقدنا لاحقاً!</p>
          </div>
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {offers.map((offer, index) => (
              <motion.div 
                key={offer.id}
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: index * 0.1 }}
                onClick={() => navigate(`/restaurant/${offer.restaurant?.id}`)}
                className="group bg-white rounded-[2.5rem] overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all cursor-pointer relative"
              >
                <div className="relative h-60 overflow-hidden">
                  <img src={offer.photo_url} className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt={offer.name} />
                  <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent" />
                  
                  <div className="absolute bottom-6 left-6 right-6 text-white text-right">
                    <p className="text-xs font-bold opacity-80 mb-1">{offer.restaurant?.name}</p>
                    <h3 className="text-2xl font-black mb-2">{offer.name}</h3>
                  </div>

                  <div className="absolute top-6 right-6 px-4 py-2 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20">
                     خصم لفترة محدودة
                  </div>
                </div>

                <div className="p-8 text-right">
                  <p className="text-gray-500 mb-6 line-clamp-2 leading-relaxed">{offer.description}</p>
                  
                  <div className="flex items-center justify-between pt-6 border-t border-gray-50">
                    <div className="flex items-center gap-2 text-primary font-bold">
                       <span className="text-sm">اطلب الآن</span>
                       <ChevronRight size={18} />
                    </div>
                    <div className="flex items-center gap-2 text-gray-400 text-sm font-medium">
                       <Clock size={16} />
                       <span>ينتهي قريباً</span>
                    </div>
                  </div>
                </div>
              </motion.div>
            ))}
          </div>
        )}
      </div>
    </div>
  );
};

export default Offers;
