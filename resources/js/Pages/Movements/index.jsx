import React, { useState } from "react";
import HeaderSearch from "@/Components/HeaderSearch.jsx";
import InfoCard from "@/Components/InfoCard.jsx";
import { ToggleButton } from "@/Components/ToggleButton.jsx";
import AlertSummary from "@/Components/AlertSummary.jsx";
import Pagination from "@/Components/Pagination.jsx";

export default function Index({ ProductMovements, SuppliesMovements, branches }) {
    const [activeTab, setActiveTab] = useState("supplies");
    const [activeTab2, setActiveTab2] = useState("movements");
    const [search, setSearch] = useState('');
    const [itemSelected, setItemSelected] = useState(null);

    const movementTypesMap = {
        input_purchase: 'Compra / Entrada',
        input_adjustment: 'Ajuste de Entrada',
        output_sale: 'Venta / Salida',
        output_waste: 'Merma / Desperdicio',
        output_adjustment: 'Ajuste de Salida'
    };

    const isSupply = activeTab === "supplies";
    const selectedItemData = itemSelected ? (isSupply ? itemSelected.supply : itemSelected.product) : null;

    return (
        <>
            <div className="p-4 max-w-md mx-auto bg-gray-50 min-h-screen">
                <HeaderSearch
                    title={'Movimientos'}
                    placeholder={'Buscar en los Movimientos'}
                    onSearchChange={(e) => setSearch(e.target.value)}
                />

                <ToggleButton
                    option1={'Insumos'}
                    value1={'supplies'}
                    option2={'Bebidas / Productos'}
                    value2={'products'}
                    activeTab={activeTab}
                    onChange={(tab) => {
                        setActiveTab(tab);
                        setItemSelected(null); // Limpiar selección al cambiar pestaña
                    }}
                />

                <div className="space-y-3 mt-4">
                    {isSupply ? (
                        <>
                            {SuppliesMovements.data
                                .filter(supply => supply.supply?.name.toLowerCase().includes(search.toLowerCase()))
                                .map((SupplyMovement) => (
                                    <InfoCard
                                        key={SupplyMovement.id}
                                        title={SupplyMovement.supply?.name}
                                        subtitle={'Motivo: ' + SupplyMovement.description}
                                        extraSubtitle={'Fecha: ' + new Date(SupplyMovement.created_at).toLocaleString()}
                                        movementType={SupplyMovement.movement_type}
                                        status={SupplyMovement.movement_type?.startsWith('input_') ? 'active' : 'danger'}
                                        badge={
                                            <span className={`px-2 py-1 rounded text-xs font-semibold ${
                                                SupplyMovement.movement_type?.startsWith('input_')
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-800'
                                            }`}>
                                                {SupplyMovement.movement_type?.startsWith('input_') ? '+ ' : '- '}
                                                {Number(SupplyMovement.quantity).toFixed(2)}
                                                {' ' + SupplyMovement.supply?.measurement_unit?.abbreviation?.toUpperCase()}
                                            </span>
                                        }
                                        onClickOptions={() => setItemSelected(SupplyMovement)}
                                    />
                                ))}

                            <Pagination links={SuppliesMovements.links} />
                        </>
                    ) : (
                        <>
                            {ProductMovements.data
                                .filter(productMovement => productMovement.product?.name.toLowerCase().includes(search.toLowerCase()))
                                .map((ProductMovement) => (
                                    <InfoCard
                                        key={ProductMovement.id}
                                        title={ProductMovement.product?.name}
                                        subtitle={'Motivo: ' + ProductMovement.description}
                                        extraSubtitle={'Hora: ' + new Date(ProductMovement.created_at).toLocaleTimeString()}
                                        movementType={ProductMovement.movement_type}
                                        status={ProductMovement.movement_type?.startsWith('input_') ? 'active' : 'danger'}
                                        badge={
                                            <span className={`px-2 py-1 rounded text-xs font-semibold ${
                                                ProductMovement.movement_type?.startsWith('input_')
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-800'
                                            }`}>
                                                {ProductMovement.movement_type?.startsWith('input_') ? '+ ' : '- '}
                                                {Number(ProductMovement.quantity).toFixed(2)}
                                                {' ' + ProductMovement.product?.measurement_unit?.abbreviation?.toUpperCase()}
                                            </span>
                                        }
                                        onClickOptions={() => setItemSelected(ProductMovement)}
                                    />
                                ))}

                            <Pagination links={ProductMovements.links} />
                        </>
                    )}
                </div>
            </div>

            {itemSelected && (
                <div
                    className="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-6"
                    onClick={() => setItemSelected(null)}
                >
                    <div
                        className="w-full max-w-[320px] bg-[#555555]/95 backdrop-blur-md rounded-3xl p-5 text-white shadow-xl border border-white/10 relative"
                        onClick={(e) => e.stopPropagation()}
                    >
                        {/* Cabecera con Icono de Información y Botón Cerrar */}
                        <div className="flex items-center justify-between mb-4">
                            <div className="flex items-center space-x-2">
                                <span className="text-xl">ⓘ</span>
                                <h3 className="text-xl font-bold tracking-tight truncate max-w-[200px]">
                                    {activeTab === 'supplies' ? itemSelected.supply?.name : itemSelected.product?.name}
                                </h3>
                            </div>
                            <button
                                onClick={() => setItemSelected(null)}
                                className="text-white/60 hover:text-white transition-colors text-lg"
                            >
                                ✕
                            </button>
                        </div>

                        {/* Tipo de movimiento / Badge central */}
                        <div className="flex justify-center my-3">
                <span className={`px-3 py-1 text-xs font-bold uppercase rounded-full tracking-wide border ${
                    itemSelected.movement_type?.startsWith('input_')
                        ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30'
                        : 'bg-rose-500/20 text-rose-300 border-rose-500/30'
                }`}>
                    {itemSelected.movement_type?.startsWith('input_') ? '▲ Entrada' : '▼ Salida'}
                </span>
                        </div>

                        {/* Grid de detalles del movimiento */}
                        <div className="grid grid-cols-2 gap-y-4 gap-x-2 text-sm mt-4">
                            <div>
                                <span className="block text-xs text-gray-300 font-medium">Cantidad:</span>
                                <span className={`font-bold ${
                                    itemSelected.movement_type?.startsWith('input_') ? 'text-emerald-400' : 'text-rose-400'
                                }`}>
                        {itemSelected.movement_type?.startsWith('input_') ? '+ ' : '- '}
                                    {Number(itemSelected.quantity).toFixed(2)}{' '}
                                    {activeTab === 'supplies'
                                        ? itemSelected.supply?.measurement_unit?.abbreviation?.toUpperCase() ?? 'UND'
                                        : itemSelected.product?.measurement_unit?.abbreviation?.toUpperCase() ?? 'UND'}
                    </span>
                            </div>

                            <div>
                                <span className="block text-xs text-gray-300 font-medium">Stock Restante:</span>
                                <span className="font-bold">
                        {Number(itemSelected.current_stock ?? 0).toFixed(2)}{' '}
                                    {activeTab === 'supplies'
                                        ? itemSelected.supply?.measurement_unit?.abbreviation?.toUpperCase() ?? 'UND'
                                        : itemSelected.product?.measurement_unit?.abbreviation?.toUpperCase() ?? 'UND'}
                    </span>
                            </div>

                            <div>
                                <span className="block text-xs text-gray-300 font-medium">Sucursal:</span>
                                <span className="font-semibold text-gray-100 truncate block">
                        {itemSelected.branch?.branch_name ?? 'General'}
                    </span>
                            </div>

                            <div>
                                <span className="block text-xs text-gray-300 font-medium">Usuario:</span>
                                <span className="font-semibold text-gray-100 truncate block">
                        {itemSelected.user?.name ?? 'Sistema'}
                    </span>
                            </div>

                            <div className="col-span-2">
                                <span className="block text-xs text-gray-300 font-medium">Fecha y Hora:</span>
                                <span className="font-semibold text-gray-100 text-xs">
                        {itemSelected.created_at ? new Date(itemSelected.created_at).toLocaleString('es-NI') : 'N/A'}
                    </span>
                            </div>

                            <div className="col-span-2 bg-white/5 p-2.5 rounded-xl border border-white/5">
                                <span className="block text-xs text-gray-300 font-medium mb-1">Motivo / Descripción:</span>
                                <p className="text-xs text-gray-200 italic">
                                    "{itemSelected.description || 'Sin motivo registrado'}"
                                </p>
                            </div>
                        </div>

                        {/* Botón Entendido */}
                        <button
                            onClick={() => setItemSelected(null)}
                            className="w-full mt-5 bg-white/10 hover:bg-white/20 text-white font-bold py-2.5 rounded-xl text-sm transition-all border border-white/5"
                        >
                            Entendido
                        </button>
                    </div>
                </div>
            )}
        </>
    );
}
