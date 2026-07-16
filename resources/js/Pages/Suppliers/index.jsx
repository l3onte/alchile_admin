import React, { useState } from "react";
import HeaderSearch from "@/Components/HeaderSearch";
import InfoCard from "@/Components/InfoCard";
import Pagination from "@/Components/Pagination";
import FloatingActionButton from "@/Components/FloatingActionButton";
import { router, useForm } from "@inertiajs/react";


export default function Index({ suppliers }) {
    const [editMode, setEditMode] = useState(false);
    const [isOpen, setIsOpen] = useState(false);
    const [supplierSelected, setSupplierSelected] = useState(null);
    const [search, setSearch] = useState('');
    const [supplierInfo, setSupplierInfo] = useState(null);

    const { data, setData, post, put, errors, reset, processing } = useForm({
        id: '',
        contact_name: '',
        name: '',
        phone: '',
        email: '',
        is_active: true
    });

    const openCreateModal = () => {
        reset();
        setEditMode(false);
        setIsOpen(true);
    }

    const openEditModal = (supplier) => {
        setData({
            id: supplier.id,
            contact_name: supplier.contact_name,
            name: supplier.name,
            phone: supplier.phone,
            email: supplier.email,
            is_active: Boolean(supplier.is_active)
        });

        setEditMode(true);
        setIsOpen(true);
    }

    const handleSubmit = (e) => {
        e.preventDefault();
        if (editMode) {
            const payload = {
                _method: 'put',
                contact_name: data.contact_name,
                name: data.name,
                phone: data.phone,
                email: data.email,
                is_active: data.is_active
            }

            router.post(route('suppliers.update', data.id), payload, {
                onSuccess: () => {
                    setIsOpen(false);
                    Swal.fire({
                        title: '¡Actualizado!',
                        text: 'El Proveedors se actualizó con éxito.',
                        icon: 'success',
                        confirmButtonColor: '#262626', 
                        customClass: {
                            popup: 'rounded-3xl font-sans',
                            confirmButton: 'rounded-xl px-5 py-2.5 text-sm font-bold'
                        }
                    });
                }
            })
        } else {
            post(route('suppliers.store'), {
                onSuccess: () => {
                    reset();
                    setIsOpen(false);
                    Swal.fire({
                        title: '¡Creado!',
                        text: 'El Proveedor ha sido registrado con éxito.',
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
                    title={'Administracion de Proveedores'}
                    placeholder={'Buscar Proveedor'}
                    searchValue={search}
                    onSearchChange={(e) => setSearch(e.target.value)}
                />

                <div className="space-y-3">
                    {suppliers.data
                        .filter(supplier => supplier.contact_name.toLowerCase().includes(search.toLowerCase()) || 
                                supplier.name.toLowerCase().includes(search.toLowerCase()) ||
                                supplier.phone.toLowerCase().includes(search.toLowerCase()) ||
                                supplier.email.toLowerCase().includes(search.toLowerCase()) 
                        )
                        .map((supplier) => (
                            <InfoCard 
                                key={supplier.id}
                                title={supplier.name}
                                subtitle={supplier.contact_name ? supplier.contact_name + ' (Contacto)' : ''}
                                status={supplier.is_active ? 'active' : 'danger'}
                                extraSubtitle={supplier.phone}
                                image={supplier.avatar_url}
                                onClickOptions={() => setSupplierSelected(supplier)}
                            />
                        ))
                    }
                </div>

                <Pagination links={suppliers.links} />
            </div>

            <FloatingActionButton onClick={openCreateModal}/>

            {supplierSelected && (
                <div 
                    className="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-6"
                    onClick={() => setSupplierInfo(null)}
                >
                    <div 
                        className="w-full max-w-[260px] bg-[#555555]/95 backdrop-blur-md rounded-3xl p-5 text-white shadow-xl border border-white/10"
                        onClick={(e) => e.stopPropagation()}
                    >
                        <p className="text-[11px] font-bold text-gray-300 px-1 uppercase tracking-wider mb-3">Acciones</p>
                        
                        <div className="space-y-1">
                            {/* Botón Información */}
                            <button 
                                onClick={() => { setSupplierInfo(supplierSelected); setSupplierSelected(null); }}
                                className="w-full flex items-center justify-between py-2.5 px-3 hover:bg-white/10 rounded-xl transition-colors text-left text-sm font-medium"
                            >
                                <span>Informacion</span>
                                <span className="text-gray-400 text-xs">➔</span>
                            </button>

                            {/* Botón Editar */}
                            <button
                                onClick={() => {
                                    openEditModal(supplierSelected);
                                    setSupplierSelected(null);
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
                                {editMode ? 'Editar Usuario' : 'Nuevo Proveedor'}
                            </h3>
                            <button onClick={() => setIsOpen(false)} className="text-gray-400 text-sm">✕</button>
                        </div>

                        <form onSubmit={handleSubmit} className="space-y-4">
                            <div>
                                <label className="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre del Contacto</label>
                                <input type="text" value={data.contact_name} onChange={e => setData('contact_name', e.target.value)} className="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none" required />
                                {errors.contact_name && <span className="text-red-500 text-xs">{errors.contact_name}</span>}
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre Proveedor</label>
                                <input type="text" value={data.name} onChange={e => setData('name', e.target.value)} className="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none" required />
                                {errors.name && <span className="text-red-500 text-xs">{errors.name}</span>}
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-gray-500 uppercase mb-1">Telefono</label>
                                <input type="text" value={data.phone} onChange={e => setData('phone', e.target.value)} className="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none" required />
                                {errors.phone && <span className="text-red-500 text-xs">{errors.phone}</span>}
                            </div> 

                            <div>
                                <label className="block text-xs font-bold text-gray-500 uppercase mb-1">Email</label>
                                <input type="email" value={data.email} onChange={e => setData('email', e.target.value)} className="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none" required />
                                {errors.email && <span className="text-red-500 text-xs">{errors.email}</span>}
                            </div>                          

                            <div className="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <span className="text-xs font-bold text-gray-700">Estado del Proveedor</span>
                                <button type="button" onClick={() => setData('is_active', !data.is_active)} className={`w-11 h-6 flex items-center rounded-full p-1 transition-colors ${data.is_active ? 'bg-emerald-500' : 'bg-gray-300'}`}>
                                    <div className={`bg-white w-4 h-4 rounded-full shadow-md transform transition-transform ${data.is_active ? 'translate-x-5' : 'translate-x-0'}`} />
                                </button>
                            </div>

                            <button type="submit" disabled={processing} className="w-full bg-[#262626] text-white font-bold p-3 rounded-xl text-sm hover:bg-black transition-colors">
                                {editMode ? 'Guardar Cambios' : 'Registrar Proveedor'}
                            </button>
                        </form>
                    </div>
                </div>
            )}

            {supplierInfo && (
                <div 
                    className="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-6"
                    onClick={() => setSupplierInfo(null)} // Si hace clic fuera, se cierra
                >
                    <div 
                        className="w-full max-w-sm bg-white rounded-3xl p-6 shadow-2xl border border-gray-100 relative"
                        onClick={(e) => e.stopPropagation()} // Evita que se cierre al hacer clic dentro
                    >
                        {/* Botón de cerrar (X) */}
                        <button 
                            onClick={() => setSupplierInfo(null)} 
                            className="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors"
                        >
                            ✕
                        </button>

                        {/* Cabecera / Avatar */}
                        <div className="flex flex-col items-center text-center space-y-3 pb-4 border-b border-gray-100">
                            <div className="w-16 h-16 rounded-full bg-[#262626] text-white flex items-center justify-center text-2xl font-bold uppercase shadow-inner">
                                {supplierInfo.avatar_url ? (
                                    <img src={supplierInfo.avatar_url} alt={supplierInfo.name} className="w-full h-full rounded-full object-cover" />
                                ) : (
                                    supplierInfo.name.charAt(0)
                                )}
                            </div>
                            <div>
                                <h3 className="text-lg font-bold text-gray-800">{supplierInfo.name}</h3>
                                <p className="text-xs text-gray-400 font-medium">Contacto</p>
                                <span className="text-xs">{supplierInfo.contact_name}</span>
                            </div>
                        </div>

                        {/* Detalles del Usuario */}
                        <div className="py-4 space-y-3">
                            <div>
                                <span className="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Telefono</span>
                                <span className="text-sm text-gray-700 font-medium">{supplierInfo.phone}</span>
                            </div>
                            <div>
                                <span className="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Correo Electrónico</span>
                                <span className="text-sm text-gray-700 font-medium">{supplierInfo.email}</span>
                            </div>

                            <div>
                                <span className="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Estado del Proveedor</span>
                                <span className={`inline-flex items-center gap-1.5 mt-1 px-2.5 py-1 rounded-full text-xs font-bold ${
                                    supplierInfo.is_active 
                                        ? 'bg-emerald-100 text-emerald-700' 
                                        : 'bg-rose-100 text-rose-700'
                                }`}>
                                    <span className={`w-2 h-2 rounded-full ${supplierInfo.is_active ? 'bg-emerald-500' : 'bg-rose-500'}`} />
                                    {supplierInfo.is_active ? 'Activo' : 'Inactivo'}
                                </span>
                            </div>
                        </div>

                        {/* Botón de acción final para cerrar */}
                        <button 
                            onClick={() => setSupplierInfo(null)} 
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