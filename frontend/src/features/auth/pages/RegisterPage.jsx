import googleLogo from '../../../assets/images/image.png'
import { Link } from 'react-router-dom'
function RegisterPage() {
  return (
    <div className="  flex bg-black text-white">
      {/* Left Side Image */}
      <div className="hidden lg:block lg:w-1/2 relative">
        <img
          src="https://i.pinimg.com/736x/af/91/2c/af912ce2c52baca021b946d9a5631d23.jpg"
          alt="Fashion"
          className=" object-cover"
        />

        <div className="absolute inset-0 bg-black/40"></div>

        <div className="absolute bottom-16 left-16">
          <p className="text-sm tracking-[0.4em] uppercase text-gray-300">
            Luxury Fashion
          </p>

          <h1 className="text-6xl font-serif mt-4">
            ATELIER
          </h1>

          <p className="mt-4 text-gray-300 max-w-sm">
            Join our world of timeless elegance and exclusive collections.
          </p>
        </div>
      </div>

      {/* Right Side Register */}
      <div className="w-full lg:w-1/2 flex h-[120vh] overflow-y-auto items-center justify-center px-8">
        <div className="w-full max-w-md">
          <p className="text-sm uppercase tracking-[0.3em] text-gray-500 mb-3">
            Create Your Account
          </p>

          <h2 className="text-5xl font-serif mb-10">
            Sign Up
          </h2>

          <form className="space-y-5">
            {/* Full Name */}
            <div>
              <label className="block text-sm mb-2 text-gray-400">
                Full Name
              </label>

              <input
                type="text"
                placeholder="Enter your full name"
                className="w-full bg-transparent border border-gray-700 px-4 py-4 outline-none focus:border-yellow-500 transition"
              />
            </div>

            {/* Email */}
            <div>
              <label className="block text-sm mb-2 text-gray-400">
                Email Address
              </label>

              <input
                type="email"
                placeholder="Enter your email"
                className="w-full bg-transparent border border-gray-700 px-4 py-4 outline-none focus:border-yellow-500 transition"
              />
            </div>

            {/* Password */}
            <div>
              <label className="block text-sm mb-2 text-gray-400">
                Password
              </label>

              <input
                type="password"
                placeholder="Create a password"
                className="w-full bg-transparent border border-gray-700 px-4 py-4 outline-none focus:border-yellow-500 transition"
              />
            </div>

            {/* Confirm Password */}
            <div>
              <label className="block text-sm mb-2 text-gray-400">
                Confirm Password
              </label>

              <input
                type="password"
                placeholder="Confirm your password"
                className="w-full bg-transparent border border-gray-700 px-4 py-4 outline-none focus:border-yellow-500 transition"
              />
            </div>

            {/* Terms */}
            <label className="flex items-start gap-3 text-sm text-gray-400">
              <input
                type="checkbox"
                className="mt-1 accent-yellow-500"
              />
              <span>
                I agree to the Terms & Conditions and Privacy Policy.
              </span>
            </label>

            {/* Register Button */}
            <button
              type="submit"
              className="w-full py-4 bg-yellow-600 hover:bg-yellow-500 text-black font-medium tracking-wider transition"
            >
              CREATE ACCOUNT
            </button>

            {/* Google Register */}
            <button
              type="button"
              className="w-full py-4 border border-gray-700 hover:border-yellow-500 transition flex items-center justify-center gap-3"
            >
              <img
                src={googleLogo}
                alt="Google"
                className="h-7 w-7 object-contain"
              />
              <span>Sign up with Google</span>
            </button>
          </form>

          <p className="mt-8 text-center text-gray-500">
            Already have an account?{" "}
            <Link to='/' className="text-white hover:text-yellow-500 transition">
             
                Sign In
    
            </Link>
          </p>
        </div>
      </div>
    </div>
  )
}

export default RegisterPage
