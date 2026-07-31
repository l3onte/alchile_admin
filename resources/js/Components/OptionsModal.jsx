import React from "react";

export default function OptionsModal({ item, onClose, onShowInfo, onEdit }) {
    if (!item) return null;

    return (
        <div 
            className="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-6"
            onClick={onClose}
        >
            <div 
                className="w-full max-w-[260px] bg-[#555555]/95 backdrop-blur-md rounded-3xl p-5 text-white shadow-xl border border-white/10"
                onClick={(e) => e.stopPropagation()}
            >
                <p className="text-[11px] font-bold text-gray-300 px-1 uppercase tracking-wider mb-3">Acciones</p>
                
                <div className="space-y-1">
                    <button 
                        onClick={() => { 
                            onShowInfo(item); 
                            onClose(); 
                        }}
                        className="w-full flex items-center justify-between py-2.5 px-3 hover:bg-white/10 rounded-xl transition-colors text-left text-sm font-medium"
                    >
                        <span>Informacion</span>
                        <span className="text-gray-400 text-xs">➔</span>
                    </button>
                    <button
                        onClick={() => {
                            onEdit(item);
                            onClose();
                        }}
                        className="w-full flex items-center justify-between py-2.5 px-3 hover:bg-white/10 rounded-xl transition-colors text-left text-sm font-medium"
                    >
                        <span>Editar</span>
                        <span className="text-gray-400 text-xs">➔</span>
                    </button>
                </div>
            </div>
        </div>
    )
}