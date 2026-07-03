import { useEffect } from 'react'
import { Link } from 'react-router-dom'
import { useTheme } from '../../../context/ThemeContext'
import Header from '../../../components/Header'

const editorialSections = [
  {
    id: 1,
    title: "Motion Tailoring",
    subtitle: "Fluidity in Structure",
    text: "A masterclass in modern proportion. Sharp, architectural tailoring meets the softness of virgin wool and cashmere. Designed not just to be worn, but to move with intention. The new silhouette is commanding, yet effortless.",
    image: "https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=1200&q=80",
    reverse: false
  },
  {
    id: 2,
    title: "Quiet Layers",
    subtitle: "The Art of Restraint",
    text: "True luxury whispers. The foundation of the Atelier wardrobe relies on essential knitwear, tone-on-tone layering, and garments that feel as good as they look. Texture becomes the focal point when color is restrained.",
    image: "https://images.unsplash.com/photo-1496747611176-843222e1e57c?auto=format&fit=crop&w=1200&q=80",
    reverse: true
  },
  {
    id: 3,
    title: "Evening Form",
    subtitle: "After-Hours Elegance",
    text: "Transitioning into evening requires pieces that possess an inherent glow. Bias-cut silks, subtle sheen on leather accessories, and sculptural heels redefine nocturnal elegance.",
    image: "https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=1200&q=80",
    reverse: false
  }
]

export default function VisionPage() {
  const { isDark } = useTheme()

  useEffect(() => {
    window.scrollTo(0, 0)
  }, [])

  return (
    <div className={`min-h-screen font-sans transition-colors duration-300 ${
      isDark 
        ? "bg-stone-950 text-stone-100" 
        : "bg-stone-50 text-stone-900"
    }`}>
      <Header />

      <main className="pt-24 pb-20">
        {/* Hero Section */}
        <div className="mx-auto max-w-5xl px-6 text-center mb-24 mt-12">
          <p className={`text-xs uppercase tracking-[0.4em] mb-4 font-semibold ${isDark ? 'text-amber-500' : 'text-amber-700'}`}>
            Editorial
          </p>
          <h1 className="font-serif text-5xl md:text-7xl mb-8 leading-tight">
            Wear the Vision
          </h1>
          <p className={`max-w-2xl mx-auto text-sm md:text-base leading-relaxed ${isDark ? 'text-stone-400' : 'text-stone-600'}`}>
            Explore the intersection of architectural design and fluid movement. 
            Atelier’s latest curation focuses on the balance between commanding 
            silhouettes and the tactile warmth of premium materials.
          </p>
        </div>

        {/* Editorial Sections */}
        <div className="flex flex-col gap-y-32">
          {editorialSections.map((section) => (
            <section 
              key={section.id} 
              className={`flex flex-col gap-12 lg:gap-24 px-6 md:px-12 max-w-7xl mx-auto items-center ${
                section.reverse ? 'lg:flex-row-reverse' : 'lg:flex-row'
              }`}
            >
              {/* Image Block */}
              <div className="w-full lg:w-1/2 relative group">
                <div className={`absolute inset-0 -translate-x-4 translate-y-4 border transition-transform duration-500 group-hover:translate-x-0 group-hover:translate-y-0 ${
                  isDark ? 'border-amber-500/30' : 'border-amber-700/30'
                }`} />
                <img 
                  src={section.image} 
                  alt={section.title}
                  className="relative z-10 w-full h-[600px] object-cover shadow-2xl grayscale-[20%] group-hover:grayscale-0 transition-all duration-700"
                />
              </div>

              {/* Text Block */}
              <div className="w-full lg:w-1/2 flex flex-col justify-center max-w-lg">
                <span className={`text-[10px] uppercase tracking-[0.3em] font-bold mb-4 ${
                  isDark ? 'text-stone-500' : 'text-stone-400'
                }`}>
                  {section.subtitle}
                </span>
                <h2 className="font-serif text-4xl md:text-5xl mb-6">
                  {section.title}
                </h2>
                <p className={`text-sm leading-relaxed mb-10 ${
                  isDark ? 'text-stone-400' : 'text-stone-600'
                }`}>
                  {section.text}
                </p>
                <div>
                  <Link 
                    to="/shop" 
                    className={`inline-block px-8 py-3 text-xs uppercase tracking-widest font-bold transition border ${
                      isDark 
                        ? 'border-white text-white hover:bg-white hover:text-black' 
                        : 'border-black text-black hover:bg-black hover:text-white'
                    }`}
                  >
                    Shop the Look
                  </Link>
                </div>
              </div>
            </section>
          ))}
        </div>

        {/* Footer CTA */}
        <div className={`mt-40 border-t py-24 text-center ${isDark ? 'border-white/10' : 'border-black/10'}`}>
          <h3 className="font-serif text-3xl mb-6">Define Your Silhouette</h3>
          <Link 
            to="/shop" 
            className={`inline-block px-10 py-4 text-xs uppercase tracking-[0.2em] font-bold transition ${
              isDark 
                ? 'bg-amber-500 text-black hover:bg-amber-400' 
                : 'bg-stone-900 text-white hover:bg-stone-800'
            }`}
          >
            Explore the Collection
          </Link>
        </div>
      </main>
    </div>
  )
}
