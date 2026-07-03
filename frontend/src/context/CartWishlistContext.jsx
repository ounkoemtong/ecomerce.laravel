import { createContext, useContext, useState, useEffect } from 'react'

const CartWishlistContext = createContext()

export function CartWishlistProvider({ children }) {
  const [cart, setCart] = useState(() => {
    const storedCart = localStorage.getItem('atelier_cart')
    return storedCart ? JSON.parse(storedCart) : []
  })

  const [wishlist, setWishlist] = useState(() => {
    const storedWishlist = localStorage.getItem('atelier_wishlist')
    return storedWishlist ? JSON.parse(storedWishlist) : []
  })

  useEffect(() => {
    localStorage.setItem('atelier_cart', JSON.stringify(cart))
  }, [cart])

  useEffect(() => {
    localStorage.setItem('atelier_wishlist', JSON.stringify(wishlist))
  }, [wishlist])

  // Cart operations
  const addToCart = (product, size, color, quantity = 1) => {
    setCart((prevCart) => {
      const existingItemIndex = prevCart.findIndex(
        (item) => item.product.id === product.id && item.size === size && item.color === color
      )

      if (existingItemIndex > -1) {
        const newCart = [...prevCart]
        newCart[existingItemIndex].quantity += quantity
        return newCart
      }

      return [...prevCart, { product, size, color, quantity }]
    })
  };

  const removeFromCart = (productId, size, color) => {
    setCart((prevCart) =>
      prevCart.filter(
        (item) => !(item.product.id === productId && item.size === size && item.color === color)
      )
    )
  };

  const updateCartQuantity = (productId, size, color, quantity) => {
    if (quantity <= 0) {
      removeFromCart(productId, size, color)
      return
    }

    setCart((prevCart) =>
      prevCart.map((item) =>
        item.product.id === productId && item.size === size && item.color === color
          ? { ...item, quantity }
          : item
      )
    )
  };

  const clearCart = () => {
    setCart([])
  }

  // Wishlist operations
  const addToWishlist = (product) => {
    setWishlist((prevWishlist) => {
      if (prevWishlist.some((p) => p.id === product.id)) {
        return prevWishlist
      }
      return [...prevWishlist, product]
    })
  }

  const removeFromWishlist = (productId) => {
    setWishlist((prevWishlist) => prevWishlist.filter((p) => p.id !== productId))
  }

  const isInWishlist = (productId) => {
    return wishlist.some((p) => p.id === productId)
  }

  const cartCount = cart.reduce((sum, item) => sum + item.quantity, 0)

  return (
    <CartWishlistContext.Provider
      value={{
        cart,
        wishlist,
        cartCount,
        addToCart,
        removeFromCart,
        updateCartQuantity,
        clearCart,
        addToWishlist,
        removeFromWishlist,
        isInWishlist,
      }}
    >
      {children}
    </CartWishlistContext.Provider>
  )
}

export function useCartWishlist() {
  const context = useContext(CartWishlistContext)
  if (!context) {
    throw new Error('useCartWishlist must be used within a CartWishlistProvider')
  }
  return context
}
