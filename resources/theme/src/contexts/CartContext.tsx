import React, { createContext, useContext, useState, useEffect } from 'react';

interface CartPhoto {
  albumId: string;
  photoIndex: number;
  photoSrc: string;
  price: number;
}

interface CartContextType {
  cart: CartPhoto[];
  addToCart: (photo: CartPhoto) => void;
  removeFromCart: (albumId: string, photoIndex: number) => void;
  isInCart: (albumId: string, photoIndex: number) => boolean;
  clearCart: () => void;
  totalPrice: number;
}

const CartContext = createContext<CartContextType | undefined>(undefined);

const PRICE_PER_PHOTO = 10; // €10 por foto

export const CartProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [cart, setCart] = useState<CartPhoto[]>([]);

  useEffect(() => {
    const savedCart = localStorage.getItem('photoCart');
    if (savedCart) {
      setCart(JSON.parse(savedCart));
    }
  }, []);

  useEffect(() => {
    localStorage.setItem('photoCart', JSON.stringify(cart));
  }, [cart]);

  const addToCart = (photo: CartPhoto) => {
    setCart(prev => [...prev, { ...photo, price: PRICE_PER_PHOTO }]);
  };

  const removeFromCart = (albumId: string, photoIndex: number) => {
    setCart(prev => prev.filter(
      item => !(item.albumId === albumId && item.photoIndex === photoIndex)
    ));
  };

  const isInCart = (albumId: string, photoIndex: number) => {
    return cart.some(item => item.albumId === albumId && item.photoIndex === photoIndex);
  };

  const clearCart = () => {
    setCart([]);
  };

  const totalPrice = cart.reduce((sum, item) => sum + item.price, 0);

  return (
    <CartContext.Provider value={{ cart, addToCart, removeFromCart, isInCart, clearCart, totalPrice }}>
      {children}
    </CartContext.Provider>
  );
};

export const useCart = () => {
  const context = useContext(CartContext);
  if (!context) {
    throw new Error('useCart must be used within CartProvider');
  }
  return context;
};
