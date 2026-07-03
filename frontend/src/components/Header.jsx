import { Link } from "react-router-dom"
import { FaRegHeart, FaRegUser, FaSun, FaMoon } from "react-icons/fa";
import { IoBagHandleOutline } from "react-icons/io5";
import { useTheme } from '../context/ThemeContext'
import { useCartWishlist } from '../context/CartWishlistContext'
import { useAuth } from '../features/auth/auth.hooks'

function Header() {
  const { isDark, toggleTheme } = useTheme()
  const { cartCount, wishlist } = useCartWishlist()
  const { isAuthenticated, user } = useAuth()

  return (
    <div>
       <header className={`fixed inset-x-[100px] top-5 z-50 border transition-all duration-300 px-6 py-4 backdrop-blur-md rounded-2xl sm:px-8 ${
         isDark 
           ? "border-white/10 bg-black/40 text-stone-300 shadow-[0_8px_32px_rgba(0,0,0,0.37)]" 
           : "border-black/10 bg-white/70 text-stone-700 shadow-[0_8px_32px_rgba(0,0,0,0.05)]"
       }`}>
                 <div className="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                   <div className="flex items-center justify-between gap-6">
                     <Link to="/" className={`font-serif text-2xl tracking-[0.22em] transition-colors ${
                       isDark ? "text-white hover:text-amber-300" : "text-stone-900 hover:text-amber-600"
                     }`}>
                       ATELIER
                     </Link>
                     <nav className="hidden items-center gap-6 text-sm md:flex">
                       <Link to="/women" className={`transition ${
                         isDark ? "hover:text-amber-300" : "hover:text-amber-600"
                       }`}>
                         Women
                       </Link>
                       <Link to="/men" className={`transition ${
                         isDark ? "hover:text-amber-300" : "hover:text-amber-600"
                       }`}>
                         Men
                       </Link>
                       <Link to="/accessories" className={`transition ${
                         isDark ? "hover:text-amber-300" : "hover:text-amber-600"
                       }`}>
                         Accessories
                       </Link>
                       <Link to="/shop" className={`transition ${
                         isDark ? "hover:text-amber-300" : "hover:text-amber-600"
                       }`}>
                         Shop All
                       </Link>
                     </nav>
                   </div>
       
                   <div className="flex items-center justify-between gap-4 text-sm md:justify-end">
                     <div className="flex items-center gap-4 text-lg">
                       <button
                         type="button"
                         onClick={toggleTheme}
                         className={`transition cursor-pointer p-1 rounded-md ${
                           isDark ? "hover:text-amber-300" : "hover:text-amber-600"
                         }`}
                         aria-label="Toggle theme"
                       >
                         {isDark ? <FaSun className="h-4 w-4" /> : <FaMoon className="h-4 w-4" />}
                       </button>
                       
                       <Link 
                         to="/wishlist" 
                         className={`transition p-1 relative flex items-center justify-center ${
                           isDark ? "hover:text-amber-300" : "hover:text-amber-600"
                         }`} 
                         aria-label="Wishlist"
                       >
                         <FaRegHeart className="h-4 w-4" />
                         {wishlist.length > 0 && (
                           <span className="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-amber-500 text-[9px] font-bold text-black">
                             {wishlist.length}
                           </span>
                         )}
                       </Link>
                       
                       <Link 
                         to="/bag" 
                         className={`transition p-1 relative flex items-center justify-center ${
                           isDark ? "hover:text-amber-300" : "hover:text-amber-600"
                         }`} 
                         aria-label="Bag"
                       >
                         <IoBagHandleOutline className="h-4 w-4" />
                         {cartCount > 0 && (
                           <span className="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-amber-500 text-[9px] font-bold text-black">
                             {cartCount}
                           </span>
                         )}
                       </Link>
                       {isAuthenticated && (
                         <Link 
                           to="/profile" 
                           className={`transition p-1 ${
                             isDark ? "hover:text-amber-300" : "hover:text-amber-600"
                           }`} 
                           aria-label="Profile"
                         >
                           <FaRegUser className="h-4 w-4" />
                         </Link>
                       )}
                     </div>
                     {!isAuthenticated && (
                       <div className="flex items-center gap-2">
                         <Link
                           to="/login"
                           className={`px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] transition rounded-lg border ${
                             isDark
                               ? "border-white/10 hover:border-amber-300 hover:text-amber-300 text-stone-300"
                               : "border-black/10 hover:border-amber-600 hover:text-amber-600 text-stone-700"
                           }`}
                         >
                           Login
                         </Link>
                         <Link
                           to="/register"
                           className="px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] transition rounded-lg border border-amber-500 bg-amber-500 text-black hover:bg-amber-400 hover:border-amber-400"
                         >
                           Join
                         </Link>
                       </div>
                     )}
                   </div>
                 </div>
               </header>
    </div>
  )
}

export default Header
