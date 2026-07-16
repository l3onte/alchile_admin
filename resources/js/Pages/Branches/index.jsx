import React, { useState } from "react";
import Swal from "sweetalert2";
import HeaderSearch from "@/Components/HeaderSearch";
import InfoCard from "@/Components/InfoCard";
import Pagination from "@/Components/Pagination";
import FloatingActionButton from "@/Components/FloatingActionButton";
import { router, useForm } from "@inertiajs/react";

export default function Index({ branches, admins }) {
    const [isOpen, setIsOpen] = useState(false);
    const [branchInfo, setBracnInfo] = useState(null);
    const [search, setSearch] = useState('');
    const [editMode, setEditMode] = useState(false);
    const [selectedBranch, setSelectedBrach] = useState(null);

    const { data, setData, post, put, errors, reset, processing } = useForm({
        id: '',
        admin_id: '',
        branch_name: '',
        location: '',
        is_active: true
    });

    const openCreateModal = () => {
        reset();
        setEditMode(false);
        setIsOpen(true);
    }

    const openEditModal = (branch) => {
        setData({
            id: branch.id,
            admin_id: branch.admin_id,
            branch_name: branch.branch_name,
            location: branch.location,
            is_active: Boolean(branch.is_active),
        });
        setEditMode(true);
        setIsOpen(true);
    }

    const handleSubmit = (e) => {
        e.preventDefault();
        if (editMode) {
            const payload = {
                _method: 'put',
                admin_id: data.admin_id,
                branch_name: data.branch_name,
                location: data.location,
                is_active: Boolean(data.is_active)
            }

            router.post(route('branches.update', data.id), payload, {
                onSuccess: () => {
                    setIsOpen(false);
                    Swal.fire({
                        title: '¡Actualizado!',
                        text: 'La Sucursal se actualizó con éxito.',
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
            post(route('branches.store'), {
                onSuccess: () => {
                    reset();
                    setIsOpen(false);
                    Swal.fire({
                        title: '¡Creado!',
                        text: 'La Sucursal ha sido registrada con éxito.',
                        icon: 'success',
                        confirmButtonColor: '#262626',
                        customClass: {
                            popup: 'rounded-3xl font-sans',
                            confirmButton: 'rounded-xl px-5 py-2.5 text-sm font-bold'
                        }
                    });
                }
            });
        }
    }

    return (
        <>
            <div className="p-4 max-w-md mx-auto bg-gray-50 min-h-screen">
                <HeaderSearch 
                    title={'Administracion de Sucursales'}
                    placeholder={'Buscar Sucursal'}
                    searchValue={search}
                    onSearchChange={(e) => setSearch(e.target.value)}
                />
                
                <div className="space-y-3">
                    {branches.data
                        .filter(branch => branch.branch_name.toLowerCase().includes(search.toLowerCase()) || branch.location.toLowerCase().includes(search.toLowerCase()))
                        .map((branch) => {
                            return (
                                <InfoCard 
                                    key={branch.id}
                                    title={branch.branch_name}
                                    subtitle={branch.admin.name}
                                    status={branch.is_active ? "active" : "danger"}
                                    onClickOptions={() => setSelectedBrach(branch)}
                                />
                            );
                        })
                    }
                </div>

                <Pagination links={branches.links}/>
            </div>

            <FloatingActionButton onClick={openCreateModal}/>

            {selectedBranch && (
                <div 
                    className="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-6"
                    onClick={() => setSelectedBrach(null)}
                >
                    <div 
                        className="w-full max-w-[260px] bg-[#555555]/95 backdrop-blur-md rounded-3xl p-5 text-white shadow-xl border border-white/10"
                        onClick={(e) => e.stopPropagation()}
                    >
                        <p className="text-[11px] font-bold text-gray-300 px-1 uppercase tracking-wider mb-3">Acciones</p>
                        
                        <div className="space-y-1">
                            {/* Botón Información */}
                            <button 
                                onClick={() => { setBracnInfo(selectedBranch); setSelectedBrach(null); }}
                                className="w-full flex items-center justify-between py-2.5 px-3 hover:bg-white/10 rounded-xl transition-colors text-left text-sm font-medium"
                            >
                                <span>Informacion</span>
                                <span className="text-gray-400 text-xs">➔</span>
                            </button>

                            {/* Botón Editar */}
                            <button
                                onClick={() => {
                                    openEditModal(selectedBranch);
                                    setSelectedBrach(null);
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
                                {editMode ? 'Editar Sucursal' : 'Nueva Sucursal'}
                            </h3>
                            <button onClick={() => setIsOpen(false)} className="text-gray-400 text-sm">✕</button>
                        </div>

                        <form onSubmit={handleSubmit} className="space-y-4">
                            <div>
                                <label className="block text-xs font-bold text-gray-500 uppercase mb-1">
                                    Administrador Encargado
                                </label>
                                <div className="relative">
                                    <select 
                                        value={data.admin_id} 
                                        onChange={e => setData('admin_id', e.target.value)} 
                                        className="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none appearance-none pr-10" 
                                        required
                                    >
                                        <option value="" disabled>Seleccione un administrador</option>
                                        {admins && admins.map((admin) => (
                                            <option key={admin.id} value={admin.id}>
                                                {admin.name}
                                            </option>
                                        ))}
                                    </select>
                                    {/* Flechita decorativa para el select custom */}
                                    <div className="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                        <svg className="fill-current h-4 w-4" viewBox="0 0 20 20">
                                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                        </svg>
                                    </div>
                                </div>
                                {errors.admin_id && <span className="text-red-500 text-xs">{errors.admin_id}</span>}
                            </div>
                            <div>
                                <label className="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre Sucursal</label>
                                <input type="text" value={data.branch_name} onChange={e => setData('branch_name', e.target.value)} className="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none" required />
                                {errors.branch_name && <span className="text-red-500 text-xs">{errors.branch_name}</span>}
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-gray-500 uppercase mb-1">Locacion</label>
                                <input type="text" value={data.location} onChange={e => setData('location', e.target.value)} className="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none" required />
                                {errors.location && <span className="text-red-500 text-xs">{errors.location}</span>}
                            </div>

                            <div className="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <span className="text-xs font-bold text-gray-700">Estado de la Sucursal</span>
                                <button type="button" onClick={() => setData('is_active', !data.is_active)} className={`w-11 h-6 flex items-center rounded-full p-1 transition-colors ${data.is_active ? 'bg-emerald-500' : 'bg-gray-300'}`}>
                                    <div className={`bg-white w-4 h-4 rounded-full shadow-md transform transition-transform ${data.is_active ? 'translate-x-5' : 'translate-x-0'}`} />
                                </button>
                            </div>

                            <button type="submit" disabled={processing} className="w-full bg-[#262626] text-white font-bold p-3 rounded-xl text-sm hover:bg-black transition-colors">
                                {editMode ? 'Guardar Cambios' : 'Registrar Sucursal'}
                            </button>
                        </form>
                    </div>
                </div>
            )}

            {branchInfo && (
                <div 
                    className="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-6"
                    onClick={() => setBracnInfo(null)} // Si hace clic fuera, se cierra
                >
                    <div 
                        className="w-full max-w-sm bg-white rounded-3xl p-6 shadow-2xl border border-gray-100 relative"
                        onClick={(e) => e.stopPropagation()} // Evita que se cierre al hacer clic dentro
                    >
                        {/* Botón de cerrar (X) */}
                        <button 
                            onClick={() => setBracnInfo(null)} 
                            className="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors"
                        >
                            ✕
                        </button>

                        {/* Cabecera / Avatar */}
                        <div className="flex flex-col items-center text-center space-y-3 pb-4 border-b border-gray-100">
                            <div className="w-16 h-16 rounded-full bg-[#262626] text-white flex items-center justify-center text-2xl font-bold uppercase shadow-inner">
                                {branchInfo.branch_name.charAt(0)}
                            </div>
                            <div>
                                <h3 className="text-lg font-bold text-gray-800">{branchInfo.branch_name}</h3>
                                <p className="text-xs text-gray-400 font-medium">Administrador</p>
                                <span className="text-xs">{branchInfo.admin.name}</span>
                            </div>
                        </div>

                        {/* Detalles del Usuario */}
                        <div className="py-4 space-y-3">
                            <div>
                                <span className="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Localidad</span>
                                <span className="text-sm text-gray-700 font-medium">{branchInfo.location}</span>
                            </div>

                            <div>
                                <span className="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Estado de la cuenta</span>
                                <span className={`inline-flex items-center gap-1.5 mt-1 px-2.5 py-1 rounded-full text-xs font-bold ${
                                    branchInfo.is_active 
                                        ? 'bg-emerald-100 text-emerald-700' 
                                        : 'bg-rose-100 text-rose-700'
                                }`}>
                                    <span className={`w-2 h-2 rounded-full ${branchInfo.is_active ? 'bg-emerald-500' : 'bg-rose-500'}`} />
                                    {branchInfo.is_active ? 'Activo' : 'Inactivo'}
                                </span>
                            </div>
                        </div>

                        {/* Botón de acción final para cerrar */}
                        <button 
                            onClick={() => setBracnInfo(null)} 
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