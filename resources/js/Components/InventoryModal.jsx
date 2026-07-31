import React, { useEffect, useState } from "react";
import { useForm } from "@inertiajs/react";
import Swal from "sweetalert2";

export default function InventoryModal({ 
    type, 
    item, 
    suppliers = [], 
    measurementUnits = [], 
    onClose, 
    itemsSelect = [], 
    branches = [] 
}) {
    const editMode = Boolean(item);
    const isSupply = type === "supplies";
    const [nuevoClicked, setNuevoClicked] = useState(false);

    // CORRECCIÓN 1: Definición consistente de campos iniciales en useForm
    const { data, setData, post, put, processing, errors, reset } = useForm({
        name: item?.name ?? "",
        branch_id: item?.branch_id ?? "",
        product_selected_id: "",
        supply_selected_id: "",
        quantity: item?.quantity ?? item?.current_stock ?? "",
        supplier_id: item?.supplier_id ?? "",
        measurement_unit_id: item?.measurement_unit_id ?? "",
        unit_cost: item?.unit_cost ?? item?.price ?? "",
        min_stock: item?.min_stock ?? "",
        is_reventa: item?.is_reventa ?? false,
        status: item?.status ?? true,
    });

    useEffect(() => {
        if (item) {
            // CORRECCIÓN 2: Asegurar la conversión de datos (ej. IDs a String para select) al editar
            setData({
                name: item.name || "",
                branch_id: item.branch_id ? String(item.branch_id) : "",
                product_selected_id: "",
                supply_selected_id: "",
                quantity: item.quantity ?? item.current_stock ?? "",
                supplier_id: item.supplier_id ? String(item.supplier_id) : "",
                measurement_unit_id: item.measurement_unit_id ? String(item.measurement_unit_id) : "",
                unit_cost: item.unit_cost ?? item.price ?? "",
                min_stock: item.min_stock ?? "",
                is_reventa: Boolean(item.is_reventa),
                status: Boolean(item.status ?? item.is_active ?? true),
            });
            setNuevoClicked(false);
        } else {
            reset();
            setNuevoClicked(false);
        }
    }, [item]);

    // CORRECCIÓN 3: Reset explícito de valores no aplicables al alternar entre Seleccionar y Nuevo
    const handleToggleNuevo = () => {
        const nextState = !nuevoClicked;
        setNuevoClicked(nextState);
        
        setData((prev) => ({
            ...prev,
            product_selected_id: "",
            supply_selected_id: "",
            name: "",
            supplier_id: "",
            measurement_unit_id: "",
            unit_cost: "",
            min_stock: "",
        }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        const routeName = isSupply ? 'supplies' : 'products';

        const options = {
            onSuccess: () => {
                reset();
                onClose();
                Swal.fire({
                    title: editMode ? '¡Actualizado!' : '¡Registrado!',
                    text: editMode 
                        ? 'El registro se actualizó correctamente.' 
                        : 'El registro se agregó al inventario.',
                    icon: 'success',
                    confirmButtonColor: '#262626',
                    customClass: {
                        popup: 'rounded-3xl font-sans',
                        confirmButton: 'rounded-xl px-5 py-2.5 text-sm font-bold'
                    }
                });
            }
        };

        if (editMode) {
            put(route(`${routeName}.update`, item.id), options);
        } else {
            post(route(`${routeName}.store`), options);
        }
    };

    // CORRECCIÓN 4: Abstracción de estado para simplificar renderizado condicional
    const isCreatingNew = nuevoClicked || editMode;

    return (
        <div className="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-end sm:items-center justify-center">
            <div className="absolute inset-0" onClick={onClose} />
            {/* CORRECCIÓN 5: Agregado max-h-[90vh] overflow-y-auto para evitar cortes en pantallas pequeñas/móviles */}
            <div className="bg-white w-full max-w-md rounded-t-3xl sm:rounded-3xl p-6 shadow-xl relative z-10 space-y-4 max-h-[90vh] overflow-y-auto">
                
                <div className="flex items-center justify-between pb-2 border-b border-gray-100">
                    <h3 className="text-base font-bold text-gray-800">
                        {editMode ? `Editar ${isSupply ? 'Insumo' : 'Producto'}` : `Nuevo ${isSupply ? 'Insumo' : 'Producto'}`}
                    </h3>
                    <button onClick={onClose} className="text-gray-400 text-sm hover:text-gray-600">✕</button>
                </div>

                <form onSubmit={handleSubmit} className="space-y-4">
                    {/* Sucursal */}
                    <div>
                        <label className="block text-xs font-bold text-gray-500 uppercase mb-1">Sucursal</label>
                        <select 
                            value={data.branch_id}
                            onChange={e => setData('branch_id', e.target.value)}
                            className="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none"
                            required
                        >
                            <option value="">Seleccione una Sucursal</option>
                            {branches.map((branch) => (
                                <option value={branch.id} key={branch.id}>
                                    {branch.branch_name || branch.name}
                                </option>
                            ))}
                        </select>
                        {errors.branch_id && <span className="text-red-500 text-xs block mt-1">{errors.branch_id}</span>}
                    </div>

                    {/* Selector / Input Nombre */}
                    <div>
                        <label className="block text-xs font-bold text-gray-500 uppercase mb-1">
                            {isSupply ? "Insumo" : "Producto"}
                        </label>
                        <div className="grid grid-cols-[1fr_auto] gap-2 items-center">
                            <div>
                                {isCreatingNew ? (
                                    <input 
                                        type="text" 
                                        placeholder={isSupply ? "Ej. Harina de Trigo" : "Ej. Hamburguesa Doble"} 
                                        className="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none" 
                                        value={data.name}
                                        onChange={e => setData('name', e.target.value)}
                                        required
                                    />
                                ) : (
                                    <select 
                                        value={isSupply ? data.supply_selected_id : data.product_selected_id}
                                        // CORRECCIÓN 6: Al seleccionar, guardamos el ID en la clave correspondiente y actualizamos name
                                        onChange={e => {
                                            const selectedId = e.target.value;
                                            const foundItem = itemsSelect.find(i => String(i.id) === String(selectedId));
                                            
                                            setData((prev) => ({
                                                ...prev,
                                                [isSupply ? 'supply_selected_id' : 'product_selected_id']: selectedId,
                                                name: foundItem ? foundItem.name : ''
                                            }));
                                        }} 
                                        className="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none"
                                        required={!nuevoClicked}
                                    >
                                        <option value="">
                                            {isSupply ? "Selecciona el Insumo" : "Selecciona el Producto"}
                                        </option>
                                        {itemsSelect.map((selectItem) => (
                                            <option value={selectItem.id} key={selectItem.id}>
                                                {selectItem.name}
                                            </option>
                                        ))}
                                    </select>
                                )}
                                {errors.name && <span className="text-red-500 text-xs block mt-1">{errors.name}</span>}
                                {errors.supply_selected_id && <span className="text-red-500 text-xs block mt-1">{errors.supply_selected_id}</span>}
                                {errors.product_selected_id && <span className="text-red-500 text-xs block mt-1">{errors.product_selected_id}</span>}
                            </div>

                            {!editMode && (
                                <button 
                                    onClick={handleToggleNuevo}
                                    type="button"
                                    className="bg-emerald-500 hover:bg-emerald-600 text-white font-medium text-xs px-3 py-3 rounded-xl transition-colors whitespace-nowrap flex items-center justify-center gap-1 shadow-sm"
                                >
                                    {nuevoClicked ? "← Seleccionar" : "+ Nuevo"}
                                </button>
                            )}
                        </div>
                    </div>

                    {/* Proveedor (Solo Insumos y al Crear/Editar Nuevo) */}
                    {isSupply && isCreatingNew && (
                        <div>
                            <label className="block text-xs font-bold text-gray-500 uppercase mb-1">Proveedor</label>
                            <select 
                                value={data.supplier_id} 
                                onChange={e => setData('supplier_id', e.target.value)}
                                className="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none"
                                required
                            >
                                <option value="">Seleccionar Proveedor</option>
                                {suppliers.map(sup => (
                                    <option key={sup.id} value={sup.id}>{sup.name}</option>
                                ))}
                            </select>
                            {errors.supplier_id && <span className="text-red-500 text-xs block mt-1">{errors.supplier_id}</span>}
                        </div>
                    )}

                    {/* Fila 1: Cantidad Entrante/Stock y Precio/Costo Unitario lado a lado */}
                    <div className="grid grid-cols-2 gap-3">
                        <div>
                            <label className="block text-xs font-bold text-gray-500 uppercase mb-1">
                                {editMode ? "Stock Actual" : (nuevoClicked ? "Stock Inicial" : "Cantidad Entrante")}
                            </label>
                            <input 
                                type="number"
                                step="any"
                                placeholder="0.00" 
                                value={data.quantity}
                                onChange={e => setData('quantity', e.target.value)}
                                className="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none" 
                                required
                            />
                            {errors.quantity && <span className="text-red-500 text-xs block mt-1">{errors.quantity}</span>}
                        </div>

                        <div>
                            <label className="block text-xs font-bold text-gray-500 uppercase mb-1">
                                {isSupply ? "Costo Unitario" : "Precio / Costo"}
                            </label>
                            <input 
                                type="number"
                                step="any"
                                placeholder="0.00" 
                                value={data.unit_cost}
                                onChange={e => setData('unit_cost', e.target.value)}
                                className="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none" 
                            />
                            {errors.unit_cost && <span className="text-red-500 text-xs block mt-1">{errors.unit_cost}</span>}
                        </div>
                    </div>

                    {/* Fila 2: Solo si se está creando un nuevo producto/insumo */}
                    {isCreatingNew && (
                        <div className="grid grid-cols-2 gap-3">
                            <div>
                                <label className="block text-xs font-bold text-gray-500 uppercase mb-1">Stock Mínimo</label>
                                <input 
                                    type="number"
                                    step="any"
                                    placeholder="0.00" 
                                    value={data.min_stock}
                                    onChange={e => setData('min_stock', e.target.value)}
                                    className="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none" 
                                />
                                {errors.min_stock && <span className="text-red-500 text-xs block mt-1">{errors.min_stock}</span>}
                            </div>

                            <div>
                                <label className="block text-xs font-bold text-gray-500 uppercase mb-1">U. Medida</label>
                                <select 
                                    value={data.measurement_unit_id} 
                                    onChange={e => setData('measurement_unit_id', e.target.value)}
                                    className="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none"
                                    required
                                >
                                    <option value="">Seleccionar</option>
                                    {measurementUnits.map(unit => (
                                        <option key={unit.id} value={unit.id}>
                                            {unit.name} ({unit.abbreviation})
                                        </option>
                                    ))}
                                </select>
                                {errors.measurement_unit_id && <span className="text-red-500 text-xs block mt-1">{errors.measurement_unit_id}</span>}
                            </div>
                        </div>
                    )}

                    {/* Reventa (Exclusivo Productos) */}
                    {!isSupply && isCreatingNew && (
                        <div className="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <span className="text-xs font-bold text-gray-700">¿Es de Reventa?</span>
                            <button 
                                type="button" 
                                onClick={() => setData('is_reventa', !data.is_reventa)} 
                                className={`w-11 h-6 flex items-center rounded-full p-1 transition-colors ${data.is_reventa ? 'bg-emerald-500' : 'bg-gray-300'}`}
                            >
                                <div className={`bg-white w-4 h-4 rounded-full shadow-md transform transition-transform ${data.is_reventa ? 'translate-x-5' : 'translate-x-0'}`} />
                            </button>
                        </div>
                    )}

                    {/* Estado */}
                    <div className="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <span className="text-xs font-bold text-gray-700">Estado del Registro</span>
                        <button 
                            type="button" 
                            onClick={() => setData('status', !data.status)} 
                            className={`w-11 h-6 flex items-center rounded-full p-1 transition-colors ${data.status ? 'bg-emerald-500' : 'bg-gray-300'}`}
                        >
                            <div className={`bg-white w-4 h-4 rounded-full shadow-md transform transition-transform ${data.status ? 'translate-x-5' : 'translate-x-0'}`} />
                        </button>
                    </div>

                    {/* Submit Button */}
                    <button 
                        type="submit" 
                        disabled={processing} 
                        className="w-full bg-[#262626] text-white font-bold p-3 rounded-xl text-sm hover:bg-black transition-colors disabled:opacity-50"
                    >
                        {editMode ? 'Guardar Cambios' : `Registrar ${isSupply ? 'Insumo' : 'Producto'}`}
                    </button>
                </form>
            </div>
        </div>
    );
}