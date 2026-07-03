import { useEffect, useRef } from 'react'
import { Provider, useDispatch } from 'react-redux'
import { fetchCurrentUser } from '../features/auth/auth.store'
import { store } from './store'

import { ThemeProvider } from '../context/ThemeContext'
import { CartWishlistProvider } from '../context/CartWishlistContext'
import { ProductProvider } from '../context/ProductContext'

function AuthBootstrap({ children }) {
  const dispatch = useDispatch()
  const hasBootstrapped = useRef(false)

  useEffect(() => {
    if (hasBootstrapped.current) {
      return
    }

    hasBootstrapped.current = true
    dispatch(fetchCurrentUser())
  }, [dispatch])

  return children
}

export default function AppProvider({ children }) {
  return (
    <Provider store={store}>
      <ThemeProvider>
        <ProductProvider>
          <CartWishlistProvider>
            <AuthBootstrap>{children}</AuthBootstrap>
          </CartWishlistProvider>
        </ProductProvider>
      </ThemeProvider>
    </Provider>
  )
}
