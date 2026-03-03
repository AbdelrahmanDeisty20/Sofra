import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { motion } from 'framer-motion';
import { 
  CreditCard, 
  MapPin, 
  Phone, 
  User, 
  MessageSquare, 
  ChevronLeft,
  CheckCircle2
} from 'lucide-react';
import { useCart } from '../context/CartContext';
import apiClient from '../api/axios';

const Checkout = () => {
  const navigate = useNavigate();
  const { cart, cartTotal, clearCart } = useCart();
  const [loading, setLoading] = useState(false);
  const [orderSuccess, setOrderSuccess] = useState(false);
  const [formData, setFormData] = useState({
    address: '',
    phone: '',
    notes: '',
    payment_method: 'cash'
  });

  if (cart.length === 0 && !orderSuccess) {
    navigate('/restaurants');
    return null;
  }

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    try {
      const orderData = {
        restaurant_id: cart[0].restaurant_id,
        address: formData.address,
        phone: formData.phone,
        notes: formData.notes,
        payment_method_id: formData.payment_method === 'cash' ? 1 : 2, // Mock IDs
        items: cart.map(item => ({
          food_id: item.id,
          quantity: item.quantity,
          note: ''
        }))
      };

      await apiClient.post('/client/order/create', orderData);
      setOrderSuccess(true);
      clearCart();
    } catch (error) {
      console.error("Order failed:", error);
      alert("حدث خطأ أثناء إتمام الطلب. يرجى المحاولة مرة أخرى.");
    } finally {
      setLoading(false);
    }
  };

  if (orderSuccess) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gray-50 p-4">
        <motion.div 
          initial={{ scale: 0.9, opacity: 0 }}
          animate={{ scale: 1, opacity: 1 }}
          className="bg-white p-12 rounded-3xl shadow-xl text-center max-w-md w-full"
        >
          <div className="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <CheckCircle2 size={48} />
          </div>
          <h2 className="text-3xl font-bold mb-4">تم استلام طلبك!</h2>
          <p className="text-gray-600 mb-8">سيتم توصيل طلبك في أقرب وقت ممكن. يمكنك متابعة حالة الطلب من ملفك الشخصي.</p>
          <button 
            onClick={() => navigate('/restaurants')}
            className="w-full py-4 bg-primary text-white rounded-2xl font-bold text-lg"
          >
            العودة للمطاعم
          </button>
        </motion.div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-50 pt-24 pb-12 px-4 md:px-8">
      <div className="max-w-7xl mx-auto">
        <button 
          onClick={() => navigate(-1)}
          className="flex items-center gap-2 text-gray-500 hover:text-primary mb-8 transition-colors font-medium"
        >
          <ChevronLeft size={20} />
          العودة للمطعم
        </button>

        <h1 className="text-3xl font-bold mb-12">إتمام الطلب</h1>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
          {/* Form Section */}
          <div className="lg:col-span-2 space-y-8">
            <div className="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
              <h3 className="text-xl font-bold mb-8 flex items-center gap-3">
                <MapPin className="text-primary" />
                تفاصيل التوصيل
              </h3>
              
              <form onSubmit={handleSubmit} className="space-y-6">
                <div>
                  <label className="block text-sm font-bold text-gray-700 mb-2 mr-1">العنوان بالتفصيل</label>
                  <div className="relative">
                    <MapPin className="absolute right-4 top-4 text-gray-400" size={20} />
                    <textarea 
                      required
                      value={formData.address}
                      onChange={(e) => setFormData({...formData, address: e.target.value})}
                      className="w-full pr-12 pl-4 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all min-h-[100px] text-right"
                      placeholder="اسم الشارع، رقم العمارة، رقم الشقة..."
                      dir="rtl"
                    />
                  </div>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <label className="block text-sm font-bold text-gray-700 mb-2 mr-1">رقم الهاتف</label>
                    <div className="relative">
                      <Phone className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" size={20} />
                      <input 
                        type="tel" 
                        required
                        value={formData.phone}
                        onChange={(e) => setFormData({...formData, phone: e.target.value})}
                        className="w-full pr-12 pl-4 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all text-right"
                        placeholder="01xxxxxxxxx"
                        dir="rtl"
                      />
                    </div>
                  </div>
                  <div>
                    <label className="block text-sm font-bold text-gray-700 mb-2 mr-1">ملاحظات للطلب (اختياري)</label>
                    <div className="relative">
                      <MessageSquare className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" size={20} />
                      <input 
                        type="text" 
                        value={formData.notes}
                        onChange={(e) => setFormData({...formData, notes: e.target.value})}
                        className="w-full pr-12 pl-4 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all text-right"
                        placeholder="مثل: جرس الباب معطل..."
                        dir="rtl"
                      />
                    </div>
                  </div>
                </div>

                <div className="pt-8">
                  <h3 className="text-xl font-bold mb-6 flex items-center gap-3">
                    <CreditCard className="text-primary" />
                    طريقة الدفع
                  </h3>
                  <div className="grid grid-cols-2 gap-4">
                    <button 
                      type="button"
                      onClick={() => setFormData({...formData, payment_method: 'cash'})}
                      className={`p-4 rounded-2xl border-2 transition-all flex flex-col items-center gap-2 ${
                        formData.payment_method === 'cash' ? 'border-primary bg-primary/5 text-primary' : 'border-gray-100 hover:border-gray-200'
                      }`}
                    >
                      <CreditCard size={32} />
                      <span className="font-bold">كاش عند الاستلام</span>
                    </button>
                    <button 
                      type="button"
                      onClick={() => setFormData({...formData, payment_method: 'online'})}
                      className={`p-4 rounded-2xl border-2 transition-all flex flex-col items-center gap-2 ${
                        formData.payment_method === 'online' ? 'border-primary bg-primary/5 text-primary' : 'border-gray-100 hover:border-gray-200'
                      }`}
                    >
                      <CreditCard size={32} />
                      <span className="font-bold">أونلاين (قريباً)</span>
                    </button>
                  </div>
                </div>

                <button 
                  type="submit"
                  disabled={loading}
                  className="w-full py-5 bg-primary text-white rounded-2xl font-bold text-xl shadow-xl shadow-primary/20 hover:opacity-90 transition-all flex items-center justify-center gap-4 mt-8"
                >
                  {loading ? (
                    <div className="w-6 h-6 border-2 border-white border-t-transparent rounded-full animate-spin" />
                  ) : (
                    <>
                      <span>تأكيد طلب {cartTotal} ج.م</span>
                      <CheckCircle2 />
                    </>
                  )}
                </button>
              </form>
            </div>
          </div>

          {/* Summary Section */}
          <div className="space-y-8">
            <div className="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm sticky top-24">
              <h3 className="text-xl font-bold mb-6">ملخص الطلب</h3>
              <div className="space-y-4 mb-8">
                {cart.map(item => (
                  <div key={item.id} className="flex justify-between items-center bg-gray-50 p-4 rounded-2xl">
                    <div className="flex items-center gap-3">
                      <div className="w-10 h-10 bg-white rounded-lg flex items-center justify-center font-bold text-primary shadow-sm">
                        {item.quantity}
                      </div>
                      <span className="font-medium">{item.name}</span>
                    </div>
                    <span className="font-bold">{item.price * item.quantity} ج.م</span>
                  </div>
                ))}
              </div>

              <div className="space-y-4 pt-6 border-t border-gray-100">
                <div className="flex justify-between text-gray-500">
                  <span>المجموع الفرعي</span>
                  <span>{cartTotal} ج.م</span>
                </div>
                <div className="flex justify-between text-gray-500">
                  <span>رسوم التوصيل</span>
                  <span>10 ج.م</span>
                </div>
                <div className="flex justify-between items-center pt-4 text-2xl font-extrabold text-primary">
                  <span>الإجمالي</span>
                  <span>{cartTotal + 10} ج.م</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Checkout;
