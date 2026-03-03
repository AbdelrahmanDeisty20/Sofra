import React, { createContext, useContext, useState, useEffect } from 'react';

const CartContext = createContext();

export const CartProvider = ({ children }) => {
  const [cart, setCart] = useState(() => {
    try {
      const savedCart = localStorage.getItem('sofra_cart');
      return savedCart ? JSON.parse(savedCart) : [];
    } catch (e) {
      console.error("Error parsing cart from localStorage:", e);
      return [];
    }
  });

  useEffect(() => {
    localStorage.setItem('sofra_cart', JSON.stringify(cart));
  }, [cart]);

  const addToCart = (product, restaurantId) => {
    setCart((prevCart) => {
      // Check if trying to add from a different restaurant
      if (prevCart.length > 0 && prevCart[0].restaurant_id !== restaurantId) {
        if (window.confirm('هل تريد مسح السلة والبدء بطلب جديد من هذا المطعم؟')) {
          return [{ ...product, quantity: 1, restaurant_id: restaurantId }];
        }
        return prevCart;
      }

      const existingItem = prevCart.find((item) => item.id === product.id);
      if (existingItem) {
        return prevCart.map((item) =>
          item.id === product.id ? { ...item, quantity: item.quantity + 1 } : item
        );
      }
      return [...prevCart, { ...product, quantity: 1, restaurant_id: restaurantId }];
    });
  };

  const removeFromCart = (productId) => {
    setCart((prevCart) =>
      prevCart
        .map((item) =>
          item.id === productId ? { ...item, quantity: item.quantity - 1 } : item
        )
        .filter((item) => item.quantity > 0)
    );
  };

  const clearCart = () => setCart([]);

  const cartTotal = cart.reduce((total, item) => total + item.price * item.quantity, 0);
  const cartCount = cart.reduce((total, item) => total + item.quantity, 0);

  return (
    <CartContext.Provider value={{ cart, addToCart, removeFromCart, clearCart, cartTotal, cartCount }}>
      {children}
    </CartContext.Provider>
  );
};

export const useCart = () => useContext(CartContext);
