import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Landing from '../pages/Landing';
import RestaurantList from '../pages/RestaurantList';
import RestaurantDetails from '../pages/RestaurantDetails';
import Checkout from '../pages/Checkout';
import Login from '../pages/Login';
import Register from '../pages/Register';
import Offers from '../pages/Offers';
import MyOrders from '../pages/MyOrders';
import Navbar from './Navbar';
import { CartProvider } from '../context/CartContext';

function App() {
  return (
    <CartProvider>
      <Router>
        <Navbar />
        <div className="min-h-screen bg-gray-50 pt-20">
          <Routes>
            <Route path="/" element={<Landing />} />
            <Route path="/restaurants" element={<RestaurantList />} />
            <Route path="/restaurant/:id" element={<RestaurantDetails />} />
            <Route path="/checkout" element={<Checkout />} />
            <Route path="/login" element={<Login />} />
            <Route path="/register" element={<Register />} />
            <Route path="/offers" element={<Offers />} />
            <Route path="/orders" element={<MyOrders />} />
            {/* Add more routes here as we build them */}
          </Routes>
        </div>
      </Router>
    </CartProvider>
  );
}

export default App;
