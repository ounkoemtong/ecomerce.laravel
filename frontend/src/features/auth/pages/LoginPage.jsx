import googleLogo from '../../../assets/images/image.png'
import { Link } from 'react-router-dom'
function LoginPage() {
    return (

        <div className=" overflow-hidden flex bg-black text-white">
            {/* Left Side Image */}
            <div className="hidden lg:block lg:w-1/2 relative">
                <img
                    src="https://i.pinimg.com/736x/af/91/2c/af912ce2c52baca021b946d9a5631d23.jpg"
                    alt="Fashion"
                    className=" object-contain"
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
                        Timeless elegance crafted for modern lifestyles.
                    </p>
                </div>
            </div>

            {/* Right Side Login */}
            <div className="w-full lg:w-1/2 flex items-center justify-center px-8">
                <div className="w-full max-w-md">
                    <p className="text-sm uppercase tracking-[0.3em] text-gray-500 mb-3">
                        Welcome Back
                    </p>

                    <h2 className="text-5xl font-serif mb-10">
                        Sign In
                    </h2>

                    <form className="space-y-6">
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

                        <div>
                            <label className="block text-sm mb-2 text-gray-400">
                                Password
                            </label>

                            <input
                                type="password"
                                placeholder="Enter your password"
                                className="w-full bg-transparent border border-gray-700 px-4 py-4 outline-none focus:border-yellow-500 transition"
                            />
                        </div>

                        <div className="flex justify-between text-sm">
                            <label className="flex items-center gap-2 text-gray-400">
                                <input type="checkbox" />
                                Remember me
                            </label>

                            <a
                                href="#"
                                className="text-gray-400 hover:text-yellow-500 transition"
                            >
                                Forgot Password?
                            </a>
                        </div>

                        <button
                            type="submit"
                            className="w-full py-4 bg-yellow-600 hover:bg-yellow-500 text-black font-medium tracking-wider transition"
                        >
                            SIGN IN
                        </button>

                        <div>
                            <button
                                type="button"
                                className="w-full py-4 border border-gray-700 hover:border-yellow-500 transition flex items-center justify-center gap-3"
                            >
                                <img src={googleLogo} alt="Google" className="h-7 w-7  object-contain" />
                                <span>Continue with Google</span>
                            </button>
                        </div>
                    </form>

                    <p className="mt-8 text-center text-gray-500">
                        Don't have an account?{" "}
                        <Link to='/register' className="text-white hover:text-yellow-500 transition">

                            Create Account

                        </Link>
                    </p>
                </div>
            </div>
        </div>
    )
}

export default LoginPage
