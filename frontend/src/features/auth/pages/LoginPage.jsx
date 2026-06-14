import googleLogo from '../../../assets/images/image.png'
import { Link } from 'react-router-dom'

function LoginPage() {
  return (
    <div className="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(212,175,55,0.18),_transparent_35%),linear-gradient(135deg,_#090909_0%,_#111111_45%,_#050505_100%)] text-stone-100">
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
            <div className="flex items-center gap-3">
              <div className="h-11 w-11 rounded-full border border-amber-300/40 bg-amber-300/10" />
              <div>
                <p className="text-[0.65rem] uppercase tracking-[0.45em] text-amber-200/70">
                  Atelier House
                </p>
                <p className="font-serif text-2xl tracking-[0.18em] text-white">ATELIER</p>
              </div>
            </div>

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
          <div className="w-full max-w-xl rounded-[2rem] border border-white/10 bg-white/5 p-6 shadow-[0_24px_80px_rgba(0,0,0,0.45)] backdrop-blur-xl sm:p-8 lg:p-10">
            <div className="mb-8 lg:hidden">
              <p className="text-[0.65rem] uppercase tracking-[0.45em] text-amber-200/70">
                Atelier House
              </p>
              <h1 className="mt-3 font-serif text-3xl text-white">ATELIER</h1>
            </div>

            <div className="mb-8 flex items-start justify-between gap-4">
              <div>
                <p className="text-xs uppercase tracking-[0.4em] text-stone-400">
                  Welcome Back
                </p>
                <h2 className="mt-3 font-serif text-4xl text-white sm:text-5xl">
                  Sign In
                </h2>
                <p className="mt-3 max-w-md text-sm leading-6 text-stone-400 sm:text-base">
                  Enter your details to continue shopping the latest collection.
                </p>
              </div>
              <div className="hidden rounded-full border border-amber-300/30 px-4 py-2 text-xs uppercase tracking-[0.3em] text-amber-100/80 sm:block">
                Members
              </div>
            </div>

            <form className="space-y-5">
              <div className="space-y-2">
                <label className="block text-xs uppercase tracking-[0.25em] text-stone-400">
                  Email Address
                </label>
                <input
                  type="email"
                  placeholder="Enter your email"
                  className="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white outline-none transition placeholder:text-stone-500 focus:border-amber-400/70 focus:bg-black/40"
                />
              </div>

              <div className="space-y-2">
                <label className="block text-xs uppercase tracking-[0.25em] text-stone-400">
                  Password
                </label>
                <input
                  type="password"
                  placeholder="Enter your password"
                  className="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white outline-none transition placeholder:text-stone-500 focus:border-amber-400/70 focus:bg-black/40"
                />
              </div>

              <div className="flex flex-col gap-3 text-sm text-stone-400 sm:flex-row sm:items-center sm:justify-between">
                <label className="flex items-center gap-3">
                  <input
                    type="checkbox"
                    className="h-4 w-4 rounded border-white/20 bg-transparent accent-amber-500"
                  />
                  Remember me
                </label>

                <a href="#" className="transition hover:text-amber-300">
                  Forgot Password?
                </a>
              </div>

              <button
                type="submit"
                className="w-full rounded-2xl bg-amber-500 px-4 py-4 text-sm font-semibold uppercase tracking-[0.35em] text-black transition hover:bg-amber-400"
              >
                Sign In
              </button>

              <div className="relative py-1">
                <div className="absolute inset-0 flex items-center">
                  <div className="w-full border-t border-white/10" />
                </div>
                <div className="relative flex justify-center">
                  <span className="bg-stone-950/80 px-4 text-xs uppercase tracking-[0.3em] text-stone-500">
                    Or continue with
                  </span>
                </div>
              </div>

              <button
                type="button"
                className="flex w-full items-center justify-center gap-3 rounded-2xl border border-white/10 bg-white/4 px-4 py-4 text-sm text-stone-200 transition hover:border-amber-300/40 hover:bg-white/8"
              >
                <img src={googleLogo} alt="Google" className="h-6 w-6 object-contain" />
                <span>Continue with Google</span>
              </button>
            </form>

            <p className="mt-8 text-center text-sm text-stone-400">
              Don&apos;t have an account?{' '}
              <Link to="/register" className="text-white transition hover:text-amber-300">
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
