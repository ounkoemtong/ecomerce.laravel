import React from 'react'

export default function DiscountBadge({ discount, className = "" }) {
  if (!discount || discount <= 0) return null

  // Generate spiky starburst points
  const cx = 50
  const cy = 50
  const spikes = 22
  const outerRadius = 47
  const innerRadius = 39

  let points = []
  for (let i = 0; i < spikes * 2; i++) {
    const angle = (i * Math.PI) / spikes - Math.PI / 2
    const r = i % 2 === 0 ? outerRadius : innerRadius
    const x = cx + r * Math.cos(angle)
    const y = cy + r * Math.sin(angle)
    points.push(`${x.toFixed(1)},${y.toFixed(1)}`)
  }
  const pointsStr = points.join(' ')

  return (
    <div 
      className={`select-none pointer-events-none z-20 ${className}`} 
      style={{ filter: 'drop-shadow(2px 2px 0px rgba(0,0,0,0.35))' }}
    >
      <svg
        viewBox="0 0 100 100"
        className="w-11 h-11 sm:w-13 sm:h-13 md:w-15 md:h-15"
      >
        {/* Starburst Shape */}
        <polygon
          points={pointsStr}
          fill="#E11D48" // Tailwind Rose-600 or Red-600
        />
        
        {/* White Bold Text */}
        <text
          x="50"
          y="46"
          textAnchor="middle"
          fill="#FFFFFF"
          fontWeight="900"
          fontSize="22"
          fontFamily="'Arial Black', Impact, sans-serif"
          letterSpacing="-0.02em"
        >
          {discount}%
        </text>
        <text
          x="50"
          y="74"
          textAnchor="middle"
          fill="#FFFFFF"
          fontWeight="900"
          fontSize="20"
          fontFamily="'Arial Black', Impact, sans-serif"
          letterSpacing="0.02em"
        >
          OFF
        </text>
      </svg>
    </div>
  )
}
