import googleLogo from '../../../assets/images/image.png'
import { Link } from 'react-router-dom'
import { useAuth, useRegisterForm } from '../auth.hooks'
import { useTheme } from '../../../context/ThemeContext'
import { FaSun, FaMoon } from 'react-icons/fa'

function RegisterPage() {
  const { isAuthenticated } = useAuth()
  const { values, updateField, handleSubmit, fieldErrors, formError, isSubmitting } =
    useRegisterForm()
  const { isDark, toggleTheme } = useTheme()

  if (isAuthenticated) {
    return (
      <div className={`min-h-screen px-4 py-12 transition-all duration-300 ${
        isDark 
          ? "bg-[radial-gradient(circle_at_top_right,_rgba(212,175,55,0.15),_transparent_35%),linear-gradient(135deg,_#070707_0%,_#111111_45%,_#040404_100%)] text-stone-100" 
          : "bg-[radial-gradient(circle_at_top_right,_rgba(212,175,55,0.1),_transparent_35%),linear-gradient(135deg,_#fbf9f6_0%,_#f5f2eb_45%,_#ece7df_100%)] text-stone-900"
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
              Account Ready
            </p>
            <h1 className={`mt-4 font-serif text-4xl sm:text-5xl ${isDark ? "text-white" : "text-stone-900"}`}>
              Registration completed successfully.
            </h1>
            <p className={`mt-4 text-sm leading-6 sm:text-base ${isDark ? "text-stone-300" : "text-stone-700"}`}>
              The new account is authenticated already, so you can continue from the
              signed-in screen on the main route.
            </p>
            <Link
              to="/"
              className={`mt-8 inline-block px-6 py-3 text-sm font-semibold uppercase tracking-[0.3em] transition ${
                isDark 
                  ? "bg-amber-500 text-black hover:bg-amber-400" 
                  : "bg-stone-900 text-white hover:bg-stone-800"
              }`}
            >
              Go To Account
            </Link>
          </div>
        </div>
      </div>
    )
  }

  return (
    <div className={`min-h-screen transition-all duration-300 ${
      isDark 
        ? "bg-[radial-gradient(circle_at_top_right,_rgba(212,175,55,0.15),_transparent_35%),linear-gradient(135deg,_#070707_0%,_#111111_45%,_#040404_100%)] text-stone-100" 
        : "bg-[radial-gradient(circle_at_top_right,_rgba(212,175,55,0.1),_transparent_35%),linear-gradient(135deg,_#fbf9f6_0%,_#f5f2eb_45%,_#ece7df_100%)] text-stone-900"
    }`}>
      {/* Floating Theme Toggle */}
      <div className="absolute top-5 left-5 z-50 lg:left-10">
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

      <div className="grid min-h-screen lg:grid-cols-[0.95fr_1.05fr]">
        <section className="flex items-center justify-center px-4 py-8 sm:px-6 lg:px-10">
          <div className={`w-full max-w-2xl border p-6 sm:p-8 lg:p-10 transition duration-300 ${
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

            <div className="mb-8">
              <p className={`text-xs uppercase tracking-[0.4em] ${isDark ? "text-stone-400" : "text-stone-500"}`}>
                Create Your Account
              </p>
              <h2 className={`mt-3 font-serif text-4xl sm:text-5xl ${isDark ? "text-white" : "text-stone-900"}`}>
                Sign Up
              </h2>
              <p className={`mt-3 max-w-lg text-sm leading-6 sm:text-base ${isDark ? "text-stone-400" : "text-stone-600"}`}>
                Start your account to save favorites, track orders, and unlock
                exclusive drops.
              </p>
            </div>

            <form className="space-y-5" onSubmit={handleSubmit}>
              {formError ? (
                <div className={`border border-red-400/40 bg-red-500/10 px-4 py-3 text-sm ${
                  isDark ? "text-red-100" : "text-black"
                }`}>
                  {formError}
                </div>
              ) : null}

              <div className="grid gap-5 sm:grid-cols-2">
                <div className="space-y-2 sm:col-span-2">
                  <label className={`block text-xs uppercase tracking-[0.25em] ${isDark ? "text-stone-400" : "text-stone-600"}`}>
                    Full Name
                  </label>
                  <input
                    name="name"
                    type="text"
                    placeholder="Enter your full name"
                    value={values.name}
                    onChange={updateField}
                    className={`w-full border px-4 py-4 text-sm outline-none transition placeholder:text-stone-500 focus:bg-transparent ${
                      isDark 
                        ? "border-white/10 bg-black/30 text-white focus:border-amber-400/70" 
                        : "border-black/10 bg-white/60 text-stone-900 focus:border-amber-600/70"
                    }`}
                  />
                  {fieldErrors.name ? (
                    <p className={`text-sm ${isDark ? "text-red-500" : "text-black"}`}>{fieldErrors.name}</p>
                  ) : null}
                </div>

                <div className="space-y-2 sm:col-span-2">
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

                <div className="space-y-2 sm:col-span-2">
                  <label className={`block text-xs uppercase tracking-[0.25em] ${isDark ? "text-stone-400" : "text-stone-600"}`}>
                    Phone Number
                  </label>
                  <input
                    name="phone"
                    type="text"
                    placeholder="Enter your phone number"
                    value={values.phone}
                    onChange={updateField}
                    className={`w-full border px-4 py-4 text-sm outline-none transition placeholder:text-stone-500 focus:bg-transparent ${
                      isDark 
                        ? "border-white/10 bg-black/30 text-white focus:border-amber-400/70" 
                        : "border-black/10 bg-white/60 text-stone-900 focus:border-amber-600/70"
                    }`}
                  />
                  {fieldErrors.phone ? (
                    <p className={`text-sm ${isDark ? "text-red-500" : "text-black"}`}>{fieldErrors.phone}</p>
                  ) : null}
                </div>

                <div className="space-y-2">
                  <label className={`block text-xs uppercase tracking-[0.25em] ${isDark ? "text-stone-400" : "text-stone-600"}`}>
                    Password
                  </label>
                  <input
                    name="password"
                    type="password"
                    placeholder="Create a password"
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

                <div className="space-y-2">
                  <label className={`block text-xs uppercase tracking-[0.25em] ${isDark ? "text-stone-400" : "text-stone-600"}`}>
                    Confirm Password
                  </label>
                  <input
                    name="confirmPassword"
                    type="password"
                    placeholder="Confirm your password"
                    value={values.confirmPassword}
                    onChange={updateField}
                    className={`w-full border px-4 py-4 text-sm outline-none transition placeholder:text-stone-500 focus:bg-transparent ${
                      isDark 
                        ? "border-white/10 bg-black/30 text-white focus:border-amber-400/70" 
                        : "border-black/10 bg-white/60 text-stone-900 focus:border-amber-600/70"
                    }`}
                  />
                  {fieldErrors.confirmPassword ? (
                    <p className={`text-sm ${isDark ? "text-red-500" : "text-black"}`}>{fieldErrors.confirmPassword}</p>
                  ) : null}
                </div>
              </div>

              <label className={`flex items-start gap-3 border px-4 py-4 text-sm leading-6 transition ${
                isDark 
                  ? "border-white/8 bg-black/20 text-stone-400" 
                  : "border-black/8 bg-white/40 text-stone-600"
              }`}>
                <input
                  name="acceptTerms"
                  type="checkbox"
                  checked={values.acceptTerms}
                  onChange={updateField}
                  className="mt-1 h-4 w-4 accent-amber-500"
                />
                <span>
                  I agree to the Terms &amp; Conditions and Privacy Policy for
                  account creation and order updates.
                </span>
              </label>
              {fieldErrors.acceptTerms ? (
                <p className={`text-sm ${isDark ? "text-red-500" : "text-black"}`}>{fieldErrors.acceptTerms}</p>
              ) : null}

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
                {isSubmitting ? 'Creating Account...' : 'Create Account'}
              </button>

              <div className="relative py-1">
                <div className="absolute inset-0 flex items-center">
                  <div className={`w-full border-t ${isDark ? "border-white/10" : "border-black/10"}`} />
                </div>
                <div className="relative flex justify-center">
                  <span className={`px-4 text-xs uppercase tracking-[0.3em] ${
                    isDark ? "bg-stone-950/80 text-stone-500" : "bg-white/90 text-stone-400"
                  }`}>
                    Or sign up with
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
                <img
                  src={googleLogo}
                  alt="Google"
                  className="h-6 w-6 object-contain"
                />
                <span>Continue with Google</span>
              </button>
            </form>

            <p className={`mt-8 text-center text-sm ${isDark ? "text-stone-400" : "text-stone-600"}`}>
              Already have an account?{' '}
              <Link to="/login" className={`transition font-semibold ${isDark ? "text-white hover:text-amber-300" : "text-stone-900 hover:text-amber-600"}`}>
                Sign In
              </Link>
            </p>
          </div>
        </section>

        <section className="relative hidden overflow-hidden lg:flex">
          <img
            src="https://i.pinimg.com/736x/af/91/2c/af912ce2c52baca021b946d9a5631d23.jpg"
            alt="Fashion editorial"
            className="absolute inset-0 h-full w-full object-cover"
          />
          <div className="absolute inset-0 bg-gradient-to-tl from-black/40 via-black/60 to-black/90" />
          <div className="absolute inset-0 bg-[linear-gradient(160deg,rgba(212,175,55,0.18)_0%,transparent_35%)]" />

          <div className="relative z-10 flex h-full w-full flex-col justify-between p-10 xl:p-14">
            <div className="ml-auto rounded-full border border-amber-300/30 px-4 py-2 text-xs uppercase tracking-[0.3em] text-amber-100/80">
              New Members
            </div>

            <div className="max-w-lg">
              <p className="mb-5 text-xs uppercase tracking-[0.5em] text-stone-300/75">
                Personal Style Access
              </p>
              <h1 className="max-w-md font-serif text-5xl leading-tight text-white xl:text-7xl">
                Create an account built for elegant shopping.
              </h1>
              <p className="mt-6 max-w-md text-base leading-7 text-stone-300">
                Save your measurements, wishlist signature pieces, and step into a
                smoother checkout experience each time you return.
              </p>
            </div>

            <div className="grid max-w-md grid-cols-2 gap-4 text-sm text-stone-300/85">
              <div className="rounded-3xl border border-white/10 bg-white/5 p-5">
                <p className="font-serif text-3xl text-white">Fast</p>
                <p className="mt-2 uppercase tracking-[0.3em]">Checkout</p>
              </div>
              <div className="rounded-3xl border border-white/10 bg-white/5 p-5">
                <p className="font-serif text-3xl text-white">Private</p>
                <p className="mt-2 uppercase tracking-[0.3em]">Profile</p>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  )
}

export default RegisterPage
