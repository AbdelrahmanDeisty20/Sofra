import React, { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { Mail, Lock, LogIn, UserPlus } from 'lucide-react';
import apiClient from '../api/axios';

const Login = () => {
  const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const [formData, setFormData] = useState({
    email: '',
    password: ''
  });

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    try {
      const response = await apiClient.post('/client/login', formData);
      localStorage.setItem('token', response.data.data.api_token);
      localStorage.setItem('user', JSON.stringify(response.data.data.client));
      navigate('/restaurants');
    } catch (error) {
      console.error("Login failed:", error);
      alert("بيانات الدخول غير صحيحة");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-gray-50 p-4">
      <motion.div 
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        className="bg-white p-8 md:p-12 rounded-[2.5rem] shadow-xl w-full max-w-md border border-gray-100"
      >
        <div className="text-center mb-10">
          <div className="w-20 h-20 bg-primary/10 text-primary rounded-3xl flex items-center justify-center mx-auto mb-6">
            <LogIn size={40} />
          </div>
          <h1 className="text-3xl font-extrabold text-gray-900 mb-2">تسجيل الدخول</h1>
          <p className="text-gray-500 font-medium">مرحباً بك مجدداً في سفرة</p>
        </div>

        <form onSubmit={handleSubmit} className="space-y-6">
          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2 mr-1">البريد الإلكتروني</label>
            <div className="relative">
              <Mail className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" size={20} />
              <input 
                type="email" 
                required
                value={formData.email}
                onChange={(e) => setFormData({...formData, email: e.target.value})}
                className="w-full pr-12 pl-4 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all text-right"
                placeholder="example@mail.com"
                dir="rtl"
              />
            </div>
          </div>

          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2 mr-1">كلمة المرور</label>
            <div className="relative">
              <Lock className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" size={20} />
              <input 
                type="password" 
                required
                value={formData.password}
                onChange={(e) => setFormData({...formData, password: e.target.value})}
                className="w-full pr-12 pl-4 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all text-right"
                placeholder="••••••••"
                dir="rtl"
              />
            </div>
          </div>

          <button 
            type="submit"
            disabled={loading}
            className="w-full py-4 bg-primary text-white rounded-2xl font-bold text-lg shadow-lg shadow-primary/20 hover:opacity-90 transition-all flex items-center justify-center gap-3 mt-4"
          >
            {loading ? (
              <div className="w-6 h-6 border-2 border-white border-t-transparent rounded-full animate-spin" />
            ) : (
              <>
                <span>دخول</span>
                <LogIn size={20} />
              </>
            )}
          </button>
        </form>

        <div className="mt-8 text-center pt-8 border-t border-gray-50">
          <p className="text-gray-500 font-medium mb-4">ليس لديك حساب؟</p>
          <Link 
            to="/register" 
            className="inline-flex items-center gap-2 text-primary font-bold hover:gap-3 transition-all"
          >
            <span>إنشاء حساب جديد</span>
            <UserPlus size={20} />
          </Link>
        </div>
      </motion.div>
    </div>
  );
};

export default Login;
