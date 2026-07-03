import googleLogo from '../../../assets/images/image.png'
import { Link } from 'react-router-dom'
import { useAuth, useLoginForm } from '../auth.hooks'
import { useTheme } from '../../../context/ThemeContext'
import { FaSun, FaMoon } from 'react-icons/fa'

function LoginPage() {
  const { isAuthenticated, isReady, user, logout } = useAuth()
  const { values, updateField, handleSubmit, fieldErrors, formError, isSubmitting } =
    useLoginForm()
  const { isDark, toggleTheme } = useTheme()

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

  if (isAuthenticated) {
    return (
      <div className={`min-h-screen px-4 py-12 transition-all duration-300 ${
        isDark 
          ? "bg-[radial-gradient(circle_at_top,_rgba(212,175,55,0.18),_transparent_35%),linear-gradient(135deg,_#090909_0%,_#111111_45%,_#050505_100%)] text-stone-100" 
          : "bg-[radial-gradient(circle_at_top,_rgba(212,175,55,0.12),_transparent_35%),linear-gradient(135deg,_#fbf9f6_0%,_#f5f2eb_45%,_#ece7df_100%)] text-stone-900"
      }`}>
        {/* Floating Theme Toggle */}
        <div className="absolute top-5 right-5 z-50">
          <button
            type="button"
            onClick={toggleTheme}
            className={`flex h-10 w-10 items-center justify-center rounded-full border transition shadow-[0_8px_32px_rgba(0,0,0,0.15)] cursor-pointer ${
              isDark 
                ? "border-white/10 bg-stone-900 text-stone-300 hover:bg-stone-800 hover:text-amber-300" 
                : "border-black/10 bg-white text-stone-700 hover:bg-stone-50 hover:text-amber-600"
            }`}
            aria-label="Toggle theme"
          >
            {isDark ? <FaSun className="h-4 w-4" /> : <FaMoon className="h-4 w-4" />}
          </button>
        </div>

        <div className="mx-auto flex min-h-[calc(100vh-6rem)] max-w-2xl items-center justify-center">
          <div className={`w-full border p-8 text-center sm:p-10 transition duration-300 ${
            isDark 
              ? "border-white/10 bg-stone-900 text-stone-100 shadow-[0_24px_80px_rgba(0,0,0,0.45)]" 
              : "border-black/10 bg-white text-stone-900 shadow-[0_24px_80px_rgba(0,0,0,0.05)]"
          }`}>
            <p className={`text-xs uppercase tracking-[0.4em] ${isDark ? "text-amber-200/70" : "text-amber-600"}`}>
              Signed In
            </p>
            <h1 className={`mt-4 font-serif text-4xl sm:text-5xl ${isDark ? "text-white" : "text-stone-900"}`}>
              Welcome back, {user?.name ?? 'Member'}
            </h1>
            <p className={`mt-4 text-sm leading-6 sm:text-base ${isDark ? "text-stone-300" : "text-stone-700"}`}>
              Your account is connected to the backend API and authenticated with a
              secure cookie-based session.
            </p>
            <p className={`mt-2 text-sm ${isDark ? "text-stone-400" : "text-stone-500"}`}>{user?.email}</p>

            <button
              type="button"
              onClick={() => logout()}
              className={`mt-8 px-6 py-3 text-sm font-semibold uppercase tracking-[0.3em] transition ${
                isDark 
                  ? "bg-amber-500 text-black hover:bg-amber-400" 
                  : "bg-stone-900 text-white hover:bg-stone-800"
              }`}
            >
              Logout
            </button>
          </div>
        </div>
      </div>
    )
  }

  return (
    <div className={`min-h-screen transition-all duration-300 ${
      isDark 
        ? "bg-[radial-gradient(circle_at_top,_rgba(212,175,55,0.18),_transparent_35%),linear-gradient(135deg,_#090909_0%,_#111111_45%,_#050505_100%)] text-stone-100" 
        : "bg-[radial-gradient(circle_at_top,_rgba(212,175,55,0.12),_transparent_35%),linear-gradient(135deg,_#fbf9f6_0%,_#f5f2eb_45%,_#ece7df_100%)] text-stone-900"
    }`}>
      {/* Floating Theme Toggle */}
      <div className="absolute top-5 right-5 z-50 lg:right-10">
        <button
          type="button"
          onClick={toggleTheme}
          className={`flex h-10 w-10 items-center justify-center rounded-full border transition shadow-[0_8px_32px_rgba(0,0,0,0.15)] cursor-pointer ${
            isDark 
              ? "border-white/10 bg-stone-900 text-stone-300 hover:bg-stone-800 hover:text-amber-300" 
              : "border-black/10 bg-white text-stone-700 hover:bg-stone-50 hover:text-amber-600"
          }`}
          aria-label="Toggle theme"
        >
          {isDark ? <FaSun className="h-4 w-4" /> : <FaMoon className="h-4 w-4" />}
        </button>
      </div>

      <div className="grid min-h-screen lg:grid-cols-[1.05fr_0.95fr]">
        <section className="relative hidden overflow-hidden lg:flex">
          <img
            src="https://i.pinimg.com/736x/af/91/2c/af912ce2c52baca021b946d9a5631d23.jpg"
            alt="Fashion editorial"
            className="absolute inset-0 h-full w-full object-cover"
          />
          <div className="absolute inset-0 bg-gradient-to-br from-black/30 via-black/55 to-black/90" />
          <div className="absolute inset-0 bg-[linear-gradient(120deg,rgba(255,255,255,0.06)_0%,transparent_35%,transparent_100%)]" />

          <div className="relative z-10 flex h-full w-full flex-col justify-between p-10 xl:p-14">
            <Link to="/" className="flex items-center gap-3 group">
              <div className="h-11 w-11 rounded-full border border-amber-300/40 bg-amber-300/10 group-hover:border-amber-300 transition" />
              <div>
                <p className="text-[0.65rem] uppercase tracking-[0.45em] text-amber-200/70 group-hover:text-amber-200 transition">
                  Atelier House
                </p>
                <p className="font-serif text-2xl tracking-[0.18em] text-white">ATELIER</p>
              </div>
            </Link>

            <div className="max-w-lg">
              <p className="mb-5 text-xs uppercase tracking-[0.5em] text-stone-300/75">
                Modern Luxury Fashion
              </p>
              <h1 className="max-w-md font-serif text-5xl leading-tight text-white xl:text-7xl">
                Sign in to your curated wardrobe.
              </h1>
              <p className="mt-6 max-w-md text-base leading-7 text-stone-300">
                Access saved pieces, order history, and exclusive collections designed
                for a quieter kind of statement.
              </p>
            </div>

            <div className="flex items-center gap-8 text-sm text-stone-300/80">
              <div>
                <p className="font-serif text-3xl text-white">24h</p>
                <p className="mt-1 uppercase tracking-[0.3em]">Concierge</p>
              </div>
              <div className="h-10 w-px bg-white/15" />
              <div>
                <p className="font-serif text-3xl text-white">New</p>
                <p className="mt-1 uppercase tracking-[0.3em]">Season Edit</p>
              </div>
            </div>
          </div>
        </section>

        <section className="flex items-center justify-center px-4 py-8 sm:px-6 lg:px-10">
          <div className={`w-full max-w-xl border p-6 sm:p-8 lg:p-10 transition duration-300 ${
            isDark 
              ? "border-white/10 bg-stone-950 shadow-[0_24px_80px_rgba(0,0,0,0.45)]" 
              : "border-black/10 bg-white shadow-[0_24px_80px_rgba(0,0,0,0.05)]"
          }`}>
            <div className="mb-8 lg:hidden">
              <p className={`text-[0.65rem] uppercase tracking-[0.45em] ${isDark ? "text-amber-200/70" : "text-amber-600"}`}>
                Atelier House
              </p>
              <h1 className={`mt-3 font-serif text-3xl ${isDark ? "text-white" : "text-stone-900"}`}>ATELIER</h1>
            </div>

            <div className="mb-8 flex items-start justify-between gap-4">
              <div>
                <p className={`text-xs uppercase tracking-[0.4em] ${isDark ? "text-stone-400" : "text-stone-500"}`}>
                  Welcome Back
                </p>
                <h2 className={`mt-3 font-serif text-4xl sm:text-5xl ${isDark ? "text-white" : "text-stone-900"}`}>
                  Sign In
                </h2>
                <p className={`mt-3 max-w-md text-sm leading-6 sm:text-base ${isDark ? "text-stone-400" : "text-stone-600"}`}>
                  Enter your details to continue shopping the latest collection.
                </p>
              </div>
              <div className={`hidden rounded-full border px-4 py-2 text-xs uppercase tracking-[0.3em] sm:block ${
                isDark ? "border-amber-300/30 text-amber-100/80" : "border-stone-400 text-stone-800 font-medium"
              }`}>
                Members
              </div>
            </div>

            <form className="space-y-5" onSubmit={handleSubmit}>
              {formError ? (
                <div className={`border border-red-400/40 bg-red-500/10 px-4 py-3 text-sm ${
                  isDark ? "text-red-100" : "text-black"
                }`}>
                  {formError}
                </div>
              ) : null}

              <div className="space-y-2">
                <label className={`block text-xs uppercase tracking-[0.25em] ${isDark ? "text-stone-400" : "text-stone-600"}`}>
                  Email Address
                </label>
                <input
                  name="email"
                  type="email"
                  placeholder="Enter your email"
                  value={values.email}
                  onChange={updateField}
                  className={`w-full border px-4 py-4 text-sm outline-none transition placeholder:text-stone-500 focus:bg-transparent ${
                    isDark 
                      ? "border-white/10 bg-black/30 text-white focus:border-amber-400/70" 
                      : "border-black/10 bg-white/60 text-stone-900 focus:border-amber-600/70"
                  }`}
                />
                {fieldErrors.email ? (
                  <p className={`text-sm ${isDark ? "text-red-500" : "text-black"}`}>{fieldErrors.email}</p>
                ) : null}
              </div>

              <div className="space-y-2">
                <label className={`block text-xs uppercase tracking-[0.25em] ${isDark ? "text-stone-400" : "text-stone-600"}`}>
                  Password
                </label>
                <input
                  name="password"
                  type="password"
                  placeholder="Enter your password"
                  value={values.password}
                  onChange={updateField}
                  className={`w-full border px-4 py-4 text-sm outline-none transition placeholder:text-stone-500 focus:bg-transparent ${
                    isDark 
                      ? "border-white/10 bg-black/30 text-white focus:border-amber-400/70" 
                      : "border-black/10 bg-white/60 text-stone-900 focus:border-amber-600/70"
                  }`}
                />
                {fieldErrors.password ? (
                  <p className={`text-sm ${isDark ? "text-red-500" : "text-black"}`}>{fieldErrors.password}</p>
                ) : null}
              </div>

              <div className={`flex flex-col gap-3 text-sm sm:flex-row sm:items-center sm:justify-between ${isDark ? "text-stone-400" : "text-stone-600"}`}>
                <label className="flex items-center gap-3">
                  <input
                    type="checkbox"
                    className="h-4 w-4 rounded border-white/20 bg-transparent accent-amber-500"
                  />
                  Remember me
                </label>

                <a href="#" className={`transition ${isDark ? "hover:text-amber-300" : "hover:text-amber-600"}`}>
                  Forgot Password?
                </a>
              </div>

              <button
                type="submit"
                disabled={isSubmitting}
                className={`w-full px-4 py-4 text-sm font-semibold uppercase tracking-[0.35em] transition ${
                  isSubmitting ? 'opacity-70 cursor-not-allowed' : ''
                } ${
                  isDark 
                    ? "bg-amber-500 text-black hover:bg-amber-400" 
                    : "bg-stone-900 text-white hover:bg-stone-800"
                }`}
              >
                {isSubmitting ? 'Signing In...' : 'Sign In'}
              </button>

              <div className="relative py-1">
                <div className="absolute inset-0 flex items-center">
                  <div className={`w-full border-t ${isDark ? "border-white/10" : "border-black/10"}`} />
                </div>
                <div className="relative flex justify-center">
                  <span className={`px-4 text-xs uppercase tracking-[0.3em] ${
                    isDark ? "bg-stone-950/80 text-stone-500" : "bg-white/90 text-stone-400"
                  }`}>
                    Or continue with
                  </span>
                </div>
              </div>

              <button
                type="button"
                className={`flex w-full items-center justify-center gap-3 border px-4 py-4 text-sm transition ${
                  isDark 
                    ? "border-white/10 bg-white/4 text-stone-200 hover:border-amber-300/40 hover:bg-white/8" 
                    : "border-black/10 bg-white text-stone-700 hover:border-stone-900 hover:bg-stone-50"
                }`}
              >
                <img src={googleLogo} alt="Google" className="h-6 w-6 object-contain" />
                <span>Continue with Google</span>
              </button>
            </form>

            <p className={`mt-8 text-center text-sm ${isDark ? "text-stone-400" : "text-stone-600"}`}>
              Don&apos;t have an account?{' '}
              <Link to="/register" className={`transition font-semibold ${isDark ? "text-white hover:text-amber-300" : "text-stone-900 hover:text-amber-600"}`}>
                Create Account
              </Link>
            </p>
          </div>
        </section>
      </div>
    </div>
  )
}

export default LoginPage
