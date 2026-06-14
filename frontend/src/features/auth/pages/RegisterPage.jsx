import googleLogo from '../../../assets/images/image.png'
import { Link } from 'react-router-dom'

function RegisterPage() {
  return (
    <div className="min-h-screen bg-[radial-gradient(circle_at_top_right,_rgba(212,175,55,0.15),_transparent_35%),linear-gradient(135deg,_#070707_0%,_#111111_45%,_#040404_100%)] text-stone-100">
      <div className="grid min-h-screen lg:grid-cols-[0.95fr_1.05fr]">
        <section className="flex items-center justify-center px-4 py-8 sm:px-6 lg:px-10">
          <div className="w-full max-w-2xl rounded-[2rem] border border-white/10 bg-white/5 p-6 shadow-[0_24px_80px_rgba(0,0,0,0.45)] backdrop-blur-xl sm:p-8 lg:p-10">
            <div className="mb-8 lg:hidden">
              <p className="text-[0.65rem] uppercase tracking-[0.45em] text-amber-200/70">
                Atelier House
              </p>
              <h1 className="mt-3 font-serif text-3xl text-white">ATELIER</h1>
            </div>

            <div className="mb-8">
              <p className="text-xs uppercase tracking-[0.4em] text-stone-400">
                Create Your Account
              </p>
              <h2 className="mt-3 font-serif text-4xl text-white sm:text-5xl">
                Sign Up
              </h2>
              <p className="mt-3 max-w-lg text-sm leading-6 text-stone-400 sm:text-base">
                Start your account to save favorites, track orders, and unlock
                exclusive drops.
              </p>
            </div>

            <form className="space-y-5">
              <div className="grid gap-5 sm:grid-cols-2">
                <div className="space-y-2 sm:col-span-2">
                  <label className="block text-xs uppercase tracking-[0.25em] text-stone-400">
                    Full Name
                  </label>
                  <input
                    type="text"
                    placeholder="Enter your full name"
                    className="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white outline-none transition placeholder:text-stone-500 focus:border-amber-400/70 focus:bg-black/40"
                  />
                </div>

                <div className="space-y-2 sm:col-span-2">
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
                    placeholder="Create a password"
                    className="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white outline-none transition placeholder:text-stone-500 focus:border-amber-400/70 focus:bg-black/40"
                  />
                </div>

                <div className="space-y-2">
                  <label className="block text-xs uppercase tracking-[0.25em] text-stone-400">
                    Confirm Password
                  </label>
                  <input
                    type="password"
                    placeholder="Confirm your password"
                    className="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white outline-none transition placeholder:text-stone-500 focus:border-amber-400/70 focus:bg-black/40"
                  />
                </div>
              </div>

              <label className="flex items-start gap-3 rounded-2xl border border-white/8 bg-black/20 px-4 py-4 text-sm leading-6 text-stone-400">
                <input type="checkbox" className="mt-1 h-4 w-4 accent-amber-500" />
                <span>
                  I agree to the Terms &amp; Conditions and Privacy Policy for
                  account creation and order updates.
                </span>
              </label>

              <button
                type="submit"
                className="w-full rounded-2xl bg-amber-500 px-4 py-4 text-sm font-semibold uppercase tracking-[0.35em] text-black transition hover:bg-amber-400"
              >
                Create Account
              </button>

              <div className="relative py-1">
                <div className="absolute inset-0 flex items-center">
                  <div className="w-full border-t border-white/10" />
                </div>
                <div className="relative flex justify-center">
                  <span className="bg-stone-950/80 px-4 text-xs uppercase tracking-[0.3em] text-stone-500">
                    Or sign up with
                  </span>
                </div>
              </div>

              <button
                type="button"
                className="flex w-full items-center justify-center gap-3 rounded-2xl border border-white/10 bg-white/4 px-4 py-4 text-sm text-stone-200 transition hover:border-amber-300/40 hover:bg-white/8"
              >
                <img
                  src={googleLogo}
                  alt="Google"
                  className="h-6 w-6 object-contain"
                />
                <span>Continue with Google</span>
              </button>
            </form>

            <p className="mt-8 text-center text-sm text-stone-400">
              Already have an account?{' '}
              <Link to="/login" className="text-white transition hover:text-amber-300">
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
              <div className="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur-sm">
                <p className="font-serif text-3xl text-white">Fast</p>
                <p className="mt-2 uppercase tracking-[0.3em]">Checkout</p>
              </div>
              <div className="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur-sm">
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
