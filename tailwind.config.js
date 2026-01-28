/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  content: ["./app/Views/**/*.php", "./public/**/*.php", "./src/**/*.js"],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        slate: {
          50: '#f8fafc',  // Ultra-light background
          100: '#f1f5f9', // Subtle surface
          200: '#e2e8f0', // Borders
          300: '#cbd5e1', // Deeper borders
          400: '#94a3b8', // Icons/Muted text
          500: '#64748b', // Secondary text
          600: '#475569', // Primary text soft
          700: '#334155', // Primary text
          800: '#1e293b', // Headings
          900: '#0f172a', // Heavy contrast
        },
        indigo: {
          50: '#eef2ff',
          100: '#e0e7ff',
          500: '#6366f1',
          600: '#4f46e5', // Primary Brand (operon-blue)
          700: '#4338ca',
        },
        emerald: {
          50: '#ecfdf5',
          500: '#10b981',
          600: '#059669', // Success
        },
        amber: {
          50: '#fffbeb',
          500: '#f59e0b',
          600: '#d97706', // Warning/Pending
        }
      },
      boxShadow: {
        'sm': '0 1px 2px 0 rgb(0 0 0 / 0.05)',
        'DEFAULT': '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)',
        'md': '0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)',
        'lg': '0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)',
        'apple': '0 4px 24px rgba(0,0,0,0.06)', // Soft depth
        'float': '0 10px 40px rgba(0,0,0,0.08)', // Floating modals
      },
      animation: {
        'fade-in': 'fadeIn 0.4s ease-out forwards',
        'slide-up': 'slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards',
        'slide-in-right': 'slideInRight 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards',
        'scale-in': 'scaleIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards',
        'pulse-ring': 'pulseRing 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { opacity: '0', transform: 'translateY(12px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        slideInRight: {
          '0%': { transform: 'translateX(100%)' },
          '100%': { transform: 'translateX(0)' },
        },
        scaleIn: {
          '0%': { opacity: '0', transform: 'scale(0.96)' },
          '100%': { opacity: '1', transform: 'scale(1)' },
        },
        pulseRing: {
          '0%': { transform: 'scale(0.8)', opacity: '0.8', boxShadow: '0 0 0 0 rgba(79, 70, 229, 0.5)' },
          '70%': { transform: 'scale(1)', opacity: '0', boxShadow: '0 0 0 10px rgba(79, 70, 229, 0)' },
          '100%': { transform: 'scale(0.8)', opacity: '0' },
        } // Adjusted for a subtle ring effect
      }
    },
  },
  plugins: [],
}
