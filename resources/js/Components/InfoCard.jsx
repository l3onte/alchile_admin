import React from "react";

export default function InfoCard({
    status = 'active',
    title,
    subtitle,
    extraSubtitle,
    movementType,
    image,
    badge,
    onClickOptions
}) {

    const statusColors = {
        active: 'bg-emerald-500',
        warning: 'bg-amber-500',
        danger: 'bg-rose-500',
        info: 'bg-indigo-500',
    };

    const movementTypes = {
        input_purchase: 'Compra',
        input_transfer: 'Transferencia',
        input_adjustment: 'Ajuste',

        output_sale: 'Salida',
        output_waste: 'Perdida',
        output_transfer: 'Transferencia',
        output_adjustment: 'Ajuste'
    }

    const barColor = statusColors[status] || statusColors.active;

    return (
        <div className="bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center relative overflow-hidden p-4 min-h-[88px]">
            <div className={`absolute left-0 top-0 bottom-0 w-2 ${barColor}`} />

            <div className="flex flex-col items-center mb-3 mr-3">
                {movementType && (
                    <span className={`px-3 py-1 mb-3 text-xs font-semibold tracking-wide ${
                        movementType.startsWith('input_') ? 'text-green-600' : 'text-red-600'
                    }`}>
                        {movementTypes[movementType]?.toUpperCase()}
                    </span>
                )}

                <div className="w-14 h-14 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center ring-2 ring-gray-100 shadow-sm flex-shrink-0">
                    {image ? (
                        <img
                            src={image}
                            alt={title}
                            className="w-full h-full object-cover"
                        />
                    ) : (
                        <span className="font-bold text-gray-600 text-base">
                            {title ? title.charAt(0).toUpperCase() : '?'}
                        </span>
                    )}
                </div>
            </div>

            <div className="flex-1 min-w-0 pr-2">
                <div className="flex items-center gap-2">
                    <h2 className="font-bold text-gray-800 text-sm truncate">
                        {title}
                    </h2>
                </div>

                {/* Primer subtítulo */}
                {subtitle && (
                    <p className="text-xs text-gray-400 truncate mt-0.5">
                        {subtitle}
                    </p>
                )}

                {/* Segundo subtítulo opcional (Ej: Teléfono o correo) */}
                {extraSubtitle && (
                    <p className="text-xs text-gray-400/90 font-medium truncate mt-0.5">
                        {extraSubtitle}
                    </p>
                )}
            </div>

            <div className="flex flex-col items-end justify-between self-stretch flex-shrink-0 pl-1">
                {badge && (
                    <div>
                        {badge}
                    </div>
                )}

                <button
                    onClick={onClickOptions}
                    className="p-1.5 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors flex-shrink-0"
                    aria-label="Opciones"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        strokeWidth={2.5}
                        stroke="currentColor"
                        className="w-5 h-5"
                    >
                        <path strokeLinecap="round" strokeLinejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5?" />
                    </svg>
                </button>
            </div>

        </div>
    );
}
