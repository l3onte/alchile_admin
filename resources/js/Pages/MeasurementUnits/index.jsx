import React, { useState } from "react";
import HeaderSearch from "@/Components/HeaderSearch";
import InfoCard from "@/Components/InfoCard";
import Pagination from "@/Components/Pagination";
import FloatingActionButton from "@/Components/FloatingActionButton";
import { router, useForm } from "@inertiajs/react";
import Swal from "sweetalert2";

export default function Index({ units }) {
    const [search, setSearch] = useState('');
    const [isOpen, setIsOpen] = useState(false);
    const [editMode, setEditMode] = useState(false);
    const [unitInfo, setUnitInfo] = useState(null);
    const [unitSelected, setUnitSelected] = useState(null);

    const { data, setData, post, put, errors, reset, processing } = useForm({
        id: '',
        name: '',
        abbreviation: '',
        is_active: true
    });

    const openCreateModal = () => {
        reset();
        setEditMode(false);
        setIsOpen(true);
    }

    const openEditModal = (unit) => {
        setData({
            id: unit.id,
            name: unit.name,
            abbreviation: unit.abbreviation,
            is_active: Boolean(unit.is_active)
        });

        setEditMode(true);
        setIsOpen(true);
    }

    const handleSubmit = (e) => {
        e.preventDefault();
        if (editMode) {
            const payload = {
                _method: 'put',
                name: data.name,
                abbreviation: data.abbreviation,
                is_active: data.is_active
            };

            router.post(route('measurementunits.update', data.id), payload, {
                onSuccess: () => {
                    setIsOpen(false);
                    Swal.fire({
                        title: '¡Actualizado!',
                        text: 'La unidad se actualizó con éxito.',
                        icon: 'success',
                        confirmButtonColor: '#262626', 
                        customClass: {
                            popup: 'rounded-3xl font-sans',
                            confirmButton: 'rounded-xl px-5 py-2.5 text-sm font-bold'
                        }
                    });
                }
            });
        } else {
            post(route('measurementunits.store'), {
                onSuccess: () => {
                    reset();
                    setIsOpen(false);
                    Swal.fire({
                        title: '¡Creado!',
                        text: 'La unidad ha sido registrada con éxito.',
                        icon: 'success',
                        confirmButtonColor: '#262626',
                        customClass: {
                            popup: 'rounded-3xl font-sans',
                            confirmButton: 'rounded-xl px-5 py-2.5 text-sm font-bold'
                        }
                    });
                }
            })
        }
    }

    return (
        <>
            <div className="p-4 max-w-md mx-auto bg-gray-50 min-h-screen">
                <HeaderSearch 
                    title={'Administracion de Unidades'}
                    placeholder={'Buscar Unidad'}
                    searchValue={search}
                    onSearchChange={(e) => setSearch(e.target.value)}
                />

                <div className="space-y-3">
                    {units.data
                        .filter(unit => unit.name.toLowerCase().includes(search.toLowerCase()) ||
                            unit.abbreviation.toLowerCase().includes(search.toLowerCase())
                        ) 
                        .map((unit) => (
                            <InfoCard 
                                key={unit.id}
                                title={unit.name}
                                subtitle={unit.abbreviation.toUpperCase()}
                                status={unit.is_active ? 'active' : 'danger'}
                                image={unit.avatar_url}
                                onClickOptions={() => setUnitSelected(unit)}
                            />
                        ))
                    }
                </div>

                <Pagination links={units.links} />
            </div>

            <FloatingActionButton onClick={openCreateModal}/>

            {unitSelected && (
                <div 
                    className="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-6"
                    onClick={() => setUnitInfo(null)}
                >
                    <div 
                        className="w-full max-w-[260px] bg-[#555555]/95 backdrop-blur-md rounded-3xl p-5 text-white shadow-xl border border-white/10"
                        onClick={(e) => e.stopPropagation()}
                    >
                        <p className="text-[11px] font-bold text-gray-300 px-1 uppercase tracking-wider mb-3">Acciones</p>
                        
                        <div className="space-y-1">
                            {/* Botón Información */}
                            <button 
                                onClick={() => { 
                                    setUnitInfo(unitSelected); 
                                    setUnitSelected(null); 
                                }}
                                className="w-full flex items-center justify-between py-2.5 px-3 hover:bg-white/10 rounded-xl transition-colors text-left text-sm font-medium"
                            >
                                <span>Informacion</span>
                                <span className="text-gray-400 text-xs">➔</span>
                            </button>

                            {/* Botón Editar */}
                            <button
                                onClick={() => {
                                    openEditModal(unitSelected);
                                    setUnitSelected(null);
                                }}
                                className="w-full flex items-center justify-between py-2.5 px-3 hover:bg-white/10 rounded-xl transition-colors text-left text-sm font-medium"
                            >
                                <span>Editar</span>
                                <span className="text-gray-400 text-xs">➔</span>
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {isOpen && (
                <div className="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-end sm:items-center justify-center">
                    <div className="absolute inset-0" onClick={() => setIsOpen(false)} />
                    <div className="bg-white w-full max-w-md rounded-t-3xl sm:rounded-3xl p-6 shadow-xl relative z-10 space-y-4">
                        <div className="flex items-center justify-between pb-2 border-b border-gray-100">
                            <h3 className="text-base font-bold text-gray-800">
                                {editMode ? 'Editar Unidad' : 'Nueva Unidad'}
                            </h3>
                            <button onClick={() => setIsOpen(false)} className="text-gray-400 text-sm">✕</button>
                        </div>

                        <form onSubmit={handleSubmit} className="space-y-4">
                            <div>
                                <label className="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre de la Unidad</label>
                                <input type="text" value={data.name} onChange={e => setData('name', e.target.value)} className="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none" required />
                                {errors.name && <span className="text-red-500 text-xs">{errors.name}</span>}
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-gray-500 uppercase mb-1">Abreviacion</label>
                                <input type="text" value={data.abbreviation} onChange={e => setData('abbreviation', e.target.value)} className="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none" required />
                                {errors.abbreviation && <span className="text-red-500 text-xs">{errors.abbreviation}</span>}
                            </div>                       

                            <div className="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <span className="text-xs font-bold text-gray-700">Estado de la Unidad</span>
                                <button type="button" onClick={() => setData('is_active', !data.is_active)} className={`w-11 h-6 flex items-center rounded-full p-1 transition-colors ${data.is_active ? 'bg-emerald-500' : 'bg-gray-300'}`}>
                                    <div className={`bg-white w-4 h-4 rounded-full shadow-md transform transition-transform ${data.is_active ? 'translate-x-5' : 'translate-x-0'}`} />
                                </button>
                            </div>

                            <button type="submit" disabled={processing} className="w-full bg-[#262626] text-white font-bold p-3 rounded-xl text-sm hover:bg-black transition-colors">
                                {editMode ? 'Guardar Cambios' : 'Registrar Unidad'}
                            </button>
                        </form>
                    </div>
                </div>
            )}

            {unitInfo && (
                <div 
                    className="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-6"
                    onClick={() => setUnitInfo(null)} // Si hace clic fuera, se cierra
                >
                    <div 
                        className="w-full max-w-sm bg-white rounded-3xl p-6 shadow-2xl border border-gray-100 relative"
                        onClick={(e) => e.stopPropagation()} // Evita que se cierre al hacer clic dentro
                    >
                        {/* Botón de cerrar (X) */}
                        <button 
                            onClick={() => setUnitInfo(null)} 
                            className="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors"
                        >
                            ✕
                        </button>

                        {/* Cabecera / Avatar */}
                        <div className="flex flex-col items-center text-center space-y-3 pb-4 border-b border-gray-100">
                            <div className="w-16 h-16 rounded-full bg-[#262626] text-white flex items-center justify-center text-2xl font-bold uppercase shadow-inner">
                                {unitInfo.avatar_url ? (
                                    <img src={unitInfo.avatar_url} alt={unitInfo.name} className="w-full h-full rounded-full object-cover" />
                                ) : (
                                    unitInfo.name.charAt(0)
                                )}
                            </div>
                            <div>
                                <h3 className="text-lg font-bold text-gray-800">{unitInfo.name}</h3>
                                <p className="text-xs text-gray-400 font-medium">Abreviacion</p>
                                <span className="text-xs">{unitInfo.abbreviation.toUpperCase()}</span>
                            </div>
                        </div>

                        {/* Detalles del Usuario */}
                        <div className="py-4 space-y-3">
                            <div>
                                <span className="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Estado de la Unidad</span>
                                <span className={`inline-flex items-center gap-1.5 mt-1 px-2.5 py-1 rounded-full text-xs font-bold ${
                                    unitInfo.is_active 
                                        ? 'bg-emerald-100 text-emerald-700' 
                                        : 'bg-rose-100 text-rose-700'
                                }`}>
                                    <span className={`w-2 h-2 rounded-full ${unitInfo.is_active ? 'bg-emerald-500' : 'bg-rose-500'}`} />
                                    {unitInfo.is_active ? 'Activo' : 'Inactivo'}
                                </span>
                            </div>
                        </div>

                        {/* Botón de acción final para cerrar */}
                        <button 
                            onClick={() => setUnitInfo(null)} 
                            className="w-full mt-2 bg-[#262626] text-white font-bold p-3 rounded-xl text-sm hover:bg-black transition-colors"
                        >
                            Entendido
                        </button>
                    </div>
                </div>
            )}
        </>
    )
}