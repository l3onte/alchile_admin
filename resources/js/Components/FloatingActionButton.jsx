import React from "react";

export default function FloatingActionButton({ onClick }) {
    return (
        <button
            type="button"
            onClick={onClick}
            className="fixed bottom-6 right-6 w-14 h-14 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 active:scale-95 z-40 group"
            title="Agregar nuevo"
        >
            <svg 
                xmlns="http://www.w3.org/2000/svg" 
                fill="none" 
                viewBox="0 0 24 24" 
                strokeWidth={3} 
                stroke="currentColor" 
                className="w-6 h-6 transition-transform group-hover:rotate-90"
            >
                <path strokeLinecap="round" strokeLinejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </button>
    )
}