import { useState } from 'react'
import { Link, Navigate } from 'react-router-dom'
import { useTheme } from '../../../context/ThemeContext'
import Header from '../../../components/Header'
import { useCartWishlist } from '../../../context/CartWishlistContext'
import { FaCheck } from 'react-icons/fa'
import { IoBagHandleOutline } from 'react-icons/io5'
import DiscountBadge from '../../../components/DiscountBadge'
import { useAuth } from '../../../features/auth/auth.hooks'

function ProfilePage() {
  const { isDark } = useTheme()
  const { wishlist, removeFromWishlist, addToCart } = useCartWishlist()
  const { isAuthenticated, isReady, user, logout } = useAuth()
  const [activeTab, setActiveTab] = useState('OUTFITS')

  if (!isReady) {
    return (
      <div className={`flex min-h-screen items-center justify-center px-4 transition-all duration-300 ${
        isDark 
          ? "bg-[radial-gradient(circle_at_top,_rgba(212,175,55,0.18),_transparent_35%),linear-gradient(135deg,_#090909_0%,_#111111_45%,_#050505_100%)] text-stone-200" 
          : "bg-[radial-gradient(circle_at_top,_rgba(212,175,55,0.12),_transparent_35%),linear-gradient(135deg,_#fbf9f6_0%,_#f5f2eb_45%,_#ece7df_100%)] text-stone-700"
      }`}>
        <p className="text-sm uppercase tracking-[0.35em]">
          Loading session...
        </p>
      </div>
    )
  }

  if (!isAuthenticated) {
    return <Navigate to="/login" replace />
  }

  // Bio state
  const username = user?.name ? `@${user.name.toLowerCase().replace(/\s+/g, '_')}` : '@clara_vogue'
  const title = user?.email || 'CREATIVE DIRECTOR & DIGITAL MUSE'
  const stats = {
    followers: '1.2M',
    posts: '842',
    wishlisted: '45k',
  }
  const bio = 'Curating the intersection of architectural minimalism and avant-garde luxury. Based in Paris. Sharing the evolution of the modern wardrobe through the lens of ATELIER.'
  const curationLink = 'atelier.luxury/curations/clara-vogue'

  // My Outfits photos from the mockup
  const outfits = [
    'https://images.unsplash.com/photo-1591369822096-ffd140ec948f?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1496747611176-843222e1e57c?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1509198397868-475647b2a1e5?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1568252542512-9fe8fe9c87bb?auto=format&fit=crop&w=600&q=80',
  ]

  // Mock Recent Orders
  const recentOrders = [
    {
      id: 'ATL-83921',
      date: 'May 12, 2026',
      total: '$240.00',
      items: 'Sculptural Wool Overcoat (1x)',
      status: 'Delivered',
      image: 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=200&q=80'
    },
    {
      id: 'ATL-83719',
      date: 'April 05, 2026',
      total: '$140.00',
      items: 'Ivory Slip Dress (1x)',
      status: 'Delivered',
      image: 'https://images.unsplash.com/photo-1568252542512-9fe8fe9c87bb?auto=format&fit=crop&w=200&q=80'
    }
  ]

  return (
    <div className={`min-h-screen transition-all duration-300 font-sans ${
      isDark 
        ? "bg-[radial-gradient(circle_at_top,_rgba(212,175,55,0.18),_transparent_35%),linear-gradient(135deg,_#090909_0%,_#111111_45%,_#050505_100%)] text-stone-100" 
        : "bg-[radial-gradient(circle_at_top,_rgba(212,175,55,0.12),_transparent_35%),linear-gradient(135deg,_#fbf9f6_0%,_#f5f2eb_45%,_#ece7df_100%)] text-stone-900"
    }`}>
      <Header />

      <main className="mx-auto max-w-5xl px-4 pb-24 pt-32 sm:px-6">
        
        {/* User Bio Header */}
        <div className="flex flex-col gap-8 md:flex-row md:items-start md:gap-12 pb-12 border-b border-black/10 dark:border-white/10">
          
          {/* Left: Avatar with Checkmark Badge */}
          <div className="relative mx-auto md:mx-0 h-36 w-36 flex-shrink-0">
            <img
              src="https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?auto=format&fit=crop&w=400&h=400&q=80"
              alt="Clara Vogue Profile"
              className="h-full w-full rounded-full object-cover border border-black/15 dark:border-white/15 shadow-md"
            />
            {/* Small Verification Badge */}
            <span className="absolute bottom-1 right-2 flex h-6 w-6 items-center justify-center rounded-full bg-black dark:bg-white text-white dark:text-black border border-white dark:border-black text-[10px]">
              <FaCheck className="h-2.5 w-2.5" />
            </span>
          </div>

          {/* Right: User details and CTAs */}
          <div className="flex-1 space-y-5 text-center md:text-left">
            <div className="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <h1 className={`font-serif text-3xl sm:text-4xl tracking-wide ${isDark ? 'text-white' : 'text-stone-900'}`}>
                  {username}
                </h1>
                <p className={`text-[0.68rem] uppercase tracking-[0.25em] font-semibold mt-1 ${
                  isDark ? 'text-amber-200/70' : 'text-amber-600'
                }`}>
                  {title}
                </p>
              </div>

              {/* Logout Button */}
              <div className="flex justify-center gap-3">
                <button
                  type="button"
                  onClick={logout}
                  className={`px-6 py-2.5 text-xs font-semibold uppercase tracking-widest transition cursor-pointer ${
                    isDark 
                      ? 'bg-amber-500 text-black hover:bg-amber-400' 
                      : 'bg-stone-900 text-white hover:bg-stone-800'
                  }`}
                >
                  Logout
                </button>
              </div>
            </div>

            {/* Stats Row */}
            <div className="flex justify-center md:justify-start gap-8 text-center border-y border-black/5 dark:border-white/5 py-4">
              <div>
                <p className={`text-xl font-serif font-bold ${isDark ? 'text-white' : 'text-stone-900'}`}>{stats.followers}</p>
                <p className="text-[0.65rem] uppercase tracking-widest text-stone-400">Followers</p>
              </div>
              <div className="h-8 w-px bg-black/10 dark:bg-white/10" />
              <div>
                <p className={`text-xl font-serif font-bold ${isDark ? 'text-white' : 'text-stone-900'}`}>{stats.posts}</p>
                <p className="text-[0.65rem] uppercase tracking-widest text-stone-400">Posts</p>
              </div>
              <div className="h-8 w-px bg-black/10 dark:bg-white/10" />
              <div>
                <p className={`text-xl font-serif font-bold ${isDark ? 'text-white' : 'text-stone-900'}`}>{stats.wishlisted}</p>
                <p className="text-[0.65rem] uppercase tracking-widest text-stone-400">Wishlisted</p>
              </div>
            </div>

            {/* Description & Link */}
            <div className="space-y-3 text-sm leading-6 text-stone-600 dark:text-stone-300">
              <p>{bio}</p>
              <a
                href="#"
                className={`inline-block text-xs uppercase tracking-wider font-semibold underline ${
                  isDark ? 'text-stone-200 hover:text-amber-300' : 'text-stone-800 hover:text-amber-600'
                }`}
              >
                {curationLink} &nearr;
              </a>
            </div>
          </div>
        </div>

        {/* Navigation Tabs */}
        <div className="flex justify-center border-b border-black/10 dark:border-white/10 mb-8 pt-4">
          <button
            onClick={() => setActiveTab('OUTFITS')}
            className={`px-6 py-4 text-xs font-semibold uppercase tracking-[0.25em] border-b-2 transition cursor-pointer ${
              activeTab === 'OUTFITS'
                ? isDark
                  ? 'border-amber-500 text-amber-400'
                  : 'border-stone-950 text-stone-950'
                : 'border-transparent text-stone-400 hover:text-stone-600 dark:hover:text-stone-200'
            }`}
          >
            My Outfits
          </button>
          
          <button
            onClick={() => setActiveTab('WISHLIST')}
            className={`px-6 py-4 text-xs font-semibold uppercase tracking-[0.25em] border-b-2 transition cursor-pointer ${
              activeTab === 'WISHLIST'
                ? isDark
                  ? 'border-amber-500 text-amber-400'
                  : 'border-stone-950 text-stone-950'
                : 'border-transparent text-stone-400 hover:text-stone-600 dark:hover:text-stone-200'
            }`}
          >
            Wishlist
          </button>
          
          <button
            onClick={() => setActiveTab('ORDERS')}
            className={`px-6 py-4 text-xs font-semibold uppercase tracking-[0.25em] border-b-2 transition cursor-pointer ${
              activeTab === 'ORDERS'
                ? isDark
                  ? 'border-amber-500 text-amber-400'
                  : 'border-stone-950 text-stone-950'
                : 'border-transparent text-stone-400 hover:text-stone-600 dark:hover:text-stone-200'
            }`}
          >
            Recent Orders
          </button>
        </div>

        {/* Tab Content Panels */}
        <div>
          {/* TAB 1: MY OUTFITS GRID */}
          {activeTab === 'OUTFITS' && (
            <div className="grid gap-4 grid-cols-2 md:grid-cols-3">
              {outfits.map((src, idx) => (
                <div key={idx} className="overflow-hidden aspect-[4/5] relative group border border-black/5 dark:border-white/5">
                  <img
                    src={src}
                    alt={`Curation outfit ${idx + 1}`}
                    className="w-full h-full object-cover transition duration-500 group-hover:scale-105"
                  />
                  <div className="absolute inset-0 bg-black/25 opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                    <p className="text-[0.65rem] uppercase tracking-wider text-white font-semibold">Atelier Wardrobe</p>
                  </div>
                </div>
              ))}
            </div>
          )}

          {/* TAB 2: LIVE WISHLIST ITEMS */}
          {activeTab === 'WISHLIST' && (
            <div>
              {wishlist.length === 0 ? (
                <div className="text-center py-12">
                  <p className="text-sm uppercase tracking-wider text-stone-400">No items in your wishlist</p>
                  <Link to="/" className="inline-block mt-4 text-xs font-semibold uppercase tracking-widest underline hover:text-amber-500">
                    Explore Collection
                  </Link>
                </div>
              ) : (
                <div className="grid gap-6 grid-cols-2 sm:grid-cols-3">
                  {wishlist.map((item) => {
                    const originalVal = item.originalPrice ? parseFloat(item.originalPrice.replace('$', '')) : 0;
                    const currentVal = item.price ? parseFloat(item.price.replace('$', '')) : 0;
                    const discountPercent = originalVal && currentVal && originalVal > currentVal
                      ? Math.round(((originalVal - currentVal) / originalVal) * 100)
                      : 0;

                    return (
                      <div
                        key={item.id}
                        className={`group relative border transition-all duration-300 ${
                          isDark 
                            ? "border-white/10 bg-stone-900/90 hover:border-amber-500/30" 
                            : "border-black/10 bg-white hover:border-amber-600/30"
                        }`}
                      >
                        {/* Top-Left: Discount Percentage Badge */}
                        <DiscountBadge
                          discount={discountPercent}
                          className="absolute top-2 left-2"
                        />

                        <button
                          type="button"
                          onClick={() => removeFromWishlist(item.id)}
                          className={`absolute right-2 top-2 z-20 flex h-7 w-7 items-center justify-center rounded-full border transition cursor-pointer shadow-sm ${
                            isDark
                              ? 'border-white/10 bg-black/80 text-stone-300 hover:bg-black/60 hover:text-white'
                              : 'border-black/10 bg-white/90 text-stone-700 hover:bg-white hover:text-black'
                          }`}
                          aria-label="Remove item"
                        >
                          &times;
                        </button>

                        {/* Bottom-Left: Quick Add to Bag hover button on the image container */}
                        <button
                          type="button"
                          onClick={(e) => {
                            e.preventDefault()
                            e.stopPropagation()
                            addToCart(item, 'S', item.colors?.[0] || 'Black', 1)
                          }}
                          className={`absolute left-2 bottom-2 z-20 flex h-7 w-7 items-center justify-center rounded-full border transition cursor-pointer shadow-sm opacity-0 group-hover:opacity-100 transition-all duration-300 ${
                            isDark
                              ? 'border-white/10 bg-black/80 text-stone-300 hover:bg-black hover:text-white'
                              : 'border-black/10 bg-white/90 text-stone-700 hover:bg-white hover:text-black'
                          }`}
                          aria-label="Add to Bag"
                        >
                          <IoBagHandleOutline className="h-3.5 w-3.5" />
                        </button>

                        <Link to={`/product/${item.id}`} className="block">
                          <div className="relative overflow-hidden aspect-[3/4]">
                            <img
                              src={item.image}
                              alt={item.name}
                              className="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                            />
                          </div>
                          <div className="p-4">
                            <h3 className={`text-xs uppercase tracking-[0.2em] font-medium transition ${
                              isDark ? 'text-stone-300 group-hover:text-amber-300' : 'text-stone-800 group-hover:text-amber-600'
                            }`}>
                              {item.name}
                            </h3>
                            {discountPercent > 0 ? (
                              <div className="mt-1.5 flex items-center gap-2">
                                <span className={`text-xs font-semibold ${isDark ? 'text-rose-400' : 'text-rose-600'}`}>
                                  {item.price}
                                </span>
                                <span className={`text-[10px] line-through opacity-60 ${isDark ? 'text-stone-400' : 'text-stone-500'}`}>
                                  {item.originalPrice}
                                </span>
                              </div>
                            ) : (
                              <p className={`mt-1.5 text-xs font-semibold ${isDark ? 'text-stone-300' : 'text-stone-705'}`}>
                                {item.price}
                              </p>
                            )}
                          </div>
                        </Link>
                      </div>
                    )
                  })}
                </div>
              )}
            </div>
          )}

          {/* TAB 3: RECENT ORDERS */}
          {activeTab === 'ORDERS' && (
            <div className="space-y-4">
              {recentOrders.map((order) => (
                <div
                  key={order.id}
                  className={`flex flex-col sm:flex-row sm:items-center justify-between p-6 border ${
                    isDark ? 'border-white/10 bg-stone-900/40' : 'border-black/10 bg-[#ece7df]/40'
                  }`}
                >
                  <div className="flex items-center gap-6">
                    <div className="h-16 w-14 flex-shrink-0 overflow-hidden border border-black/10">
                      <img src={order.image} alt={order.items} className="h-full w-full object-cover" />
                    </div>
                    <div>
                      <h3 className={`text-sm font-semibold uppercase tracking-wider ${isDark ? 'text-white' : 'text-stone-900'}`}>
                        Order #{order.id}
                      </h3>
                      <p className="text-xs text-stone-400 mt-1">Placed on {order.date}</p>
                      <p className="text-xs font-medium mt-1 text-stone-600 dark:text-stone-300">{order.items}</p>
                    </div>
                  </div>

                  <div className="flex items-center justify-between sm:justify-end gap-12 mt-4 sm:mt-0 text-right">
                    <div>
                      <p className={`text-sm font-semibold ${isDark ? 'text-amber-300' : 'text-amber-700'}`}>{order.total}</p>
                      <span className="inline-block px-2.5 py-0.5 rounded-full text-[10px] uppercase font-bold bg-emerald-600/10 text-emerald-600 border border-emerald-600/25 mt-1">
                        {order.status}
                      </span>
                    </div>
                    
                    <button
                      type="button"
                      className={`border px-4 py-2 text-[10px] font-semibold uppercase tracking-widest transition cursor-pointer ${
                        isDark
                          ? 'border-white/20 hover:border-amber-400 hover:bg-white/5'
                          : 'border-black/20 hover:border-stone-900 hover:bg-stone-50'
                      }`}
                    >
                      Track Order
                    </button>
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>

      </main>

      {/* Footer */}
      <footer className={`border-t transition-all duration-300 px-5 py-12 sm:px-6 lg:px-8 ${
        isDark ? "border-white/10 bg-[#070707]" : "border-black/10 bg-[#f4f1eb]"
      }`}>
        <div className="mx-auto max-w-7xl grid gap-8 md:grid-cols-[1.4fr_1fr_1fr_1fr]">
          <div>
            <p className={`font-serif text-2xl tracking-[0.22em] ${isDark ? "text-white" : "text-stone-900"}`}>ATELIER</p>
            <p className={`mt-3 max-w-xs text-sm leading-6 ${isDark ? "text-stone-400" : "text-stone-600"}`}>
              Refining the everyday through tailored silhouettes and purposeful texture.
            </p>
          </div>

          <div>
            <p className={`text-xs uppercase tracking-[0.28em] ${isDark ? "text-amber-200/70" : "text-amber-600"}`}>Customer Care</p>
            <div className={`mt-3 space-y-2 text-sm ${isDark ? "text-stone-400" : "text-stone-600"}`}>
              <p className={`hover:text-amber-500 cursor-pointer transition ${isDark ? "hover:text-amber-300" : "hover:text-amber-600"}`}>Store locator</p>
              <p className={`hover:text-amber-500 cursor-pointer transition ${isDark ? "hover:text-amber-300" : "hover:text-amber-600"}`}>Shipping &amp; Returns</p>
              <p className={`hover:text-amber-500 cursor-pointer transition ${isDark ? "hover:text-amber-300" : "hover:text-amber-600"}`}>Accessibility</p>
            </div>
          </div>

          <div>
            <p className={`text-xs uppercase tracking-[0.28em] ${isDark ? "text-amber-200/70" : "text-amber-600"}`}>About</p>
            <div className={`mt-3 space-y-2 text-sm ${isDark ? "text-stone-400" : "text-stone-600"}`}>
              <p className={`hover:text-amber-500 cursor-pointer transition ${isDark ? "hover:text-amber-300" : "hover:text-amber-600"}`}>Journal</p>
              <p className={`hover:text-amber-500 cursor-pointer transition ${isDark ? "hover:text-amber-300" : "hover:text-amber-600"}`}>Craftsmanship</p>
              <p className={`hover:text-amber-500 cursor-pointer transition ${isDark ? "hover:text-amber-300" : "hover:text-amber-600"}`}>Privacy Policy</p>
            </div>
          </div>

          <div>
            <p className={`text-xs uppercase tracking-[0.28em] ${isDark ? "text-amber-200/70" : "text-amber-600"}`}>Newsletter</p>
            <div className={`mt-3 flex items-center gap-3 border-b pb-3 text-sm ${
              isDark ? "border-white/20 text-stone-200" : "border-black/20 text-stone-800"
            }`}>
              <input
                type="email"
                placeholder="Enter email"
                className={`bg-transparent outline-none w-full text-sm ${
                  isDark ? "text-stone-200 placeholder:text-stone-600" : "text-stone-800 placeholder:text-stone-400"
                }`}
              />
              <button 
                type="button" 
                className={`transition ${isDark ? "text-amber-500 hover:text-amber-400" : "text-amber-600 hover:text-amber-500"}`} 
                aria-label="Subscribe"
              >
                &rarr;
              </button>
            </div>
          </div>
        </div>

        <div className={`mx-auto max-w-7xl mt-12 flex flex-col gap-3 border-t pt-5 text-xs uppercase tracking-[0.22em] sm:flex-row sm:items-center sm:justify-between ${
          isDark ? "border-white/10 text-stone-500" : "border-black/10 text-stone-400"
        }`}>
          <p>2026 Atelier. All rights reserved.</p>
          <p>Crafted for modern wardrobe rituals.</p>
        </div>
      </footer>
    </div>
  )
}

export default ProfilePage
