import React, { useState } from "react";
import HeaderSearch from "@/Components/HeaderSearch";
import InfoCard from "@/Components/InfoCard";
import Pagination from "@/Components/Pagination";
import FloatingActionButton from "@/Components/FloatingActionButton";
import { ToggleButton } from "@/Components/ToggleButton";
import OptionsModal from "@/Components/OptionsModal";
import InventoryModal from "@/Components/InventoryModal";

export default function Index({ branches, supplies, products, units, suppliers, selectedBranch }) {
    const [activeTab, setActiveTab] = useState("supplies"); 
    const [moreInfo, setMoreInfo] = useState(null);
    const [itemSelected, setItemSelected] = useState(null);
    const [isOpen, setIsOpen] = useState(false);
    const [editItem, setEditItem] = useState(null);
    const [search, setSearch] = useState('');

    const handleOpenCreate = () => {
        setIsOpen(true);
        setEditItem(null);
    }

    const handleOpenEdit = (item) => {
        setIsOpen(true);
        setEditItem(item);
    }

    return (
        <>
            <div className="p-4 max-w-md mx-auto bg-gray-50 min-h-screen">
                <HeaderSearch 
                    title={'Inventario'}
                    placeholder={'Buscar en el Inventario'}
                    branches={branches}
                    selectedBranch={selectedBranch}
                    onSearchChange={(e) => setSearch(e.target.value)}
                />

                <ToggleButton 
                    option1={'Insumos'}
                    option2={'Bebidas / Productos'}
                    activeTab={activeTab}
                    onChange={setActiveTab}
                />

                <div className="space-y-3 mt-4">
                    {activeTab === "supplies" ? (
                        <>
                            {supplies.data
                                .filter(supply => supply.name.toLowerCase().includes(search.toLocaleLowerCase()))
                                .map((supply) => (
                                    <InfoCard 
                                        key={supply.id}
                                        title={supply.name}
                                        status={supply.status == 0 ? 'danger' : ' active'}
                                        subtitle={'Precio Unitario: ' + `${Number(supply.unit_cost)} C$ / ${supply.measurement_unit?.abbreviation?.toUpperCase() ?? ''}`}
                                        extraSubtitle={'Fecha de Ingreso: ' + new Date(supply.created_at).toLocaleDateString('es-Es')}
                                        badge={
                                        <span className={`px-2 py-1 rounded text-xs font-semibold ${
                                                Number(supply.current_stock) <= Number(supply.min_stock)
                                                    ? 'bg-red-100 text-red-800'  
                                                    : 'bg-green-100 text-green-800' 
                                            }`}>
                                                {Number(supply.current_stock).toFixed(2)} {supply.measurement_unit?.abbreviation?.toUpperCase() ?? ''}
                                            </span>
                                        }
                                        onClickOptions={() => setItemSelected(supply)}  
                                    />
                            ))}

                            <Pagination links={supplies.links}/>

                            <FloatingActionButton onClick={handleOpenCreate} />
                        </>  
                    ) : (
                        <>
                            {products.data
                                .filter(product => product.name.toLowerCase().includes(search.toLowerCase()))
                                .map((product) => (
                                <InfoCard 
                                    key={product.id}
                                    title={product.name}
                                    status={product.status == 0 ? 'danger' : ' active'}
                                    subtitle={'Precio Unitario: ' + `${Number(product.price)} C$ / ${product.measumeasurement_unit?.abbreviation?.toUpperCase() ?? ''}`}
                                    extraSubtitle={'Fecha de Ingreso: ' + new Date(product.created_at).toLocaleDateString('es-Es')}
                                    badge={
                                        <span className={`px-2 py-1 rounded text-xs font-semibold ${
                                            Number(product.current_stock) <= Number(product.min_stock)
                                                ? 'bg-red-100 text-red-800'  
                                                : 'bg-green-100 text-green-800' 
                                        }`}>
                                            {Number(product.current_stock).toFixed(2)} {product.measumeasurement_unit?.abbreviation?.toUpperCase() ?? ''}
                                        </span>
                                    }
                                    onClickOptions={() => setItemSelected(product)}
                                />
                            ))}

                            <Pagination links={products.links}/>

                            <FloatingActionButton onClick={handleOpenCreate} />
                        </>
                    )}
                </div>
                
                {itemSelected && (
                    <OptionsModal 
                        item={itemSelected}
                        onClose={() => setItemSelected(null)}
                        onShowInfo={(item) => setMoreInfo(item)}
                        onEdit={() => {
                            setEditItem(itemSelected); // Usamos el item que ya tenemos seleccionado
                            setIsOpen(true);
                            setItemSelected(null);
                        }}
                    />
                )}

                {isOpen && (
                    <InventoryModal 
                        type={activeTab}
                        item={editItem}
                        branches={branches}
                        suppliers={suppliers}
                        measurementUnits={units}
                        onClose={() => setIsOpen(false)}
                        itemsSelect={activeTab == 'supplies' ? supplies.data : products.data }
                    />
                )}

                {moreInfo && (
                    <div 
                        className="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-6"
                        onClick={() => setMoreInfo(null)} 
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
                                        {moreInfo.name}
                                    </h3>
                                </div>
                                <button 
                                    onClick={() => setMoreInfo(null)} 
                                    className="text-white/60 hover:text-white transition-colors text-lg"
                                >
                                    ✕
                                </button>
                            </div>

                            {/* Ilustración o Imagen del Producto si existe */}
                            <div className="flex justify-center my-4">
                                <div className="w-24 h-24 bg-white/10 rounded-2xl flex items-center justify-center overflow-hidden">
                                    {moreInfo.image_url ? (
                                        <img src={moreInfo.image_url} alt={moreInfo.name} className="w-full h-full object-cover" />
                                    ) : (
                                        <span className="text-3xl">📦</span>
                                    )}
                                </div>
                            </div>

                            {/* Grid de detalles técnicos */}
                            <div className="grid grid-cols-2 gap-y-4 gap-x-2 text-sm mt-2">
                                <div>
                                    <span className="block text-xs text-gray-300 font-medium">Estado:</span>
                                    <span className={`font-bold uppercase tracking-wide ${
                                        moreInfo.status === 1 || moreInfo.status ? 'text-emerald-400' : 'text-rose-400'
                                    }`}>
                                        {moreInfo.status === 1 || moreInfo.status ? 'Activo' : 'Inactivo'}
                                    </span>
                                </div>

                                <div>
                                    <span className="block text-xs text-gray-300 font-medium">Stock Actual:</span>
                                    <span className="font-bold">
                                        {Number(moreInfo.current_stock).toFixed(0)} {moreInfo.measurement_unit?.abbreviation?.toUpperCase() ?? 'UND'}
                                    </span>
                                </div>

                                <div>
                                    <span className="block text-xs text-gray-300 font-medium">Costo Unitario:</span>
                                    <span className="font-semibold text-gray-100">
                                        {Number(activeTab == 'supplies' ? moreInfo.unit_cost : moreInfo.price).toFixed(2)} C$ / {moreInfo.measurement_unit?.abbreviation?.toUpperCase() ?? 'UND'}
                                    </span>
                                </div>

                                <div>
                                    <span className="block text-xs text-gray-300 font-medium">Stock Mínimo:</span>
                                    <span className="font-semibold text-gray-100">
                                        {Number(moreInfo.min_stock ?? 0).toFixed(0)} {moreInfo.measurement_unit?.abbreviation?.toUpperCase() ?? 'UND'}
                                    </span>
                                </div>

                                <div className="col-span-1">
                                    <span className="block text-xs text-gray-300 font-medium">Inversión Total:</span>
                                    <span className="font-bold text-amber-300 block">
                                        {Number(((moreInfo.current_stock ?? 0) * (activeTab == 'supplies' ? moreInfo.unit_cost ?? 0 : moreInfo.price ?? 0))).toFixed(2)} C$
                                    </span>
                                </div>

                                <div>
                                    <span className="block text-xs text-gray-300 font-medium">Ingreso:</span>
                                    <span className="font-semibold text-gray-100 text-xs">
                                        {moreInfo.created_at ? new Date(moreInfo.created_at).toLocaleDateString('es-NI') : 'N/A'}
                                    </span>
                                </div>
                            </div>

                            {/* Botón Entendido */}
                            <button 
                                onClick={() => setMoreInfo(null)} 
                                className="w-full mt-5 bg-white/10 hover:bg-white/20 text-white font-bold py-2.5 rounded-xl text-sm transition-all border border-white/5"
                            >
                                Entendido
                            </button>
                        </div>
                    </div>
                )}
            </div>
        </>
    )
}