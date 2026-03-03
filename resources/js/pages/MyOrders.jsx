import React, { useEffect, useState } from 'react';
import { motion } from 'react-router-dom';
import { Clock, Hash, MapPin, ShoppingBag, ChevronLeft } from 'lucide-react';
import apiClient from '../api/axios';

const MyOrders = () => {
  const [orders, setOrders] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchOrders = async () => {
      try {
        const response = await apiClient.get('/client/orders');
        setOrders(response.data.data.data || []);
      } catch (error) {
        console.error("Error fetching orders:", error);
      } finally {
        setLoading(false);
      }
    };
    fetchOrders();
  }, []);

  const getStatusColor = (status) => {
    switch (status) {
      case 'pending': return 'bg-yellow-100 text-yellow-600';
      case 'accepted': return 'bg-blue-100 text-blue-600';
      case 'delivered': return 'bg-green-100 text-green-600';
      case 'rejected': return 'bg-red-100 text-red-600';
      default: return 'bg-gray-100 text-gray-600';
    }
  };

  const getStatusLabel = (status) => {
    switch (status) {
      case 'pending': return 'قيد الانتظار';
      case 'accepted': return 'مقبول';
      case 'delivered': return 'تم التوصيل';
      case 'rejected': return 'مرفوض';
      case 'declined': return 'ملغى';
      default: return status;
    }
  };

  if (loading) return (
    <div className="min-h-screen flex items-center justify-center bg-gray-50">
      <div className="w-12 h-12 border-4 border-primary border-t-transparent rounded-full animate-spin" />
    </div>
  );

  return (
    <div className="min-h-screen bg-gray-50 pb-20 px-4 md:px-8">
      <div className="max-w-5xl mx-auto pt-12">
        <h1 className="text-3xl font-bold mb-12 text-right">طلباتي</h1>

        {orders.length === 0 ? (
          <div className="bg-white rounded-[2.5rem] p-16 text-center border border-gray-100 shadow-sm">
            <ShoppingBag size={64} className="text-gray-200 mx-auto mb-6" />
            <h2 className="text-2xl font-bold text-gray-400">لا توجد طلبات سابقة</h2>
            <button 
              onClick={() => window.location.href = '/restaurants'}
              className="mt-8 text-primary font-bold hover:underline"
            >
              اطلب الآن من أفضل المطاعم
            </button>
          </div>
        ) : (
          <div className="space-y-6">
            {orders.map((order) => (
              <div 
                key={order.id}
                className="bg-white rounded-[2rem] p-6 md:p-8 flex flex-col md:row items-center gap-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow"
              >
                <div className="w-20 h-20 bg-gray-50 rounded-2xl overflow-hidden flex-shrink-0">
                  <img 
                    src={order.restaurant?.image_url} 
                    className="w-full h-full object-cover" 
                    alt={order.restaurant?.name} 
                  />
                </div>

                <div className="flex-1 text-right w-full">
                  <div className="flex flex-col md:row justify-between items-start md:items-center mb-4 gap-4">
                    <div>
                      <h3 className="text-xl font-bold mb-1">{order.restaurant?.name}</h3>
                      <div className="flex items-center gap-4 text-gray-400 text-sm">
                        <span className="flex items-center gap-1 font-bold">
                           <Hash size={16} /> {order.id}
                        </span>
                        <span className="flex items-center gap-1">
                           <Clock size={16} /> {new Date(order.created_at).toLocaleDateString('ar-EG')}
                        </span>
                      </div>
                    </div>
                    <div className={`px-4 py-2 rounded-xl text-sm font-bold ${getStatusColor(order.state)}`}>
                      {getStatusLabel(order.state)}
                    </div>
                  </div>
                  
                  <div className="grid grid-cols-2 md:grid-cols-4 gap-4 pt-4 border-t border-gray-50 font-medium">
                     <div className="text-gray-500">
                        <p className="text-xs mb-1">الإجمالي</p>
                        <p className="text-gray-900 font-bold">{order.total} ج.م</p>
                     </div>
                     <div className="text-gray-500">
                        <p className="text-xs mb-1">الكمية</p>
                        <p className="text-gray-900">{order.items_count || order.items?.length} وجبات</p>
                     </div>
                     <div className="text-gray-500 col-span-2">
                        <p className="text-xs mb-1">العنوان</p>
                        <p className="text-gray-900 line-clamp-1">{order.address}</p>
                     </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        )}
      </div>
    </div>
  );
};

export default MyOrders;
