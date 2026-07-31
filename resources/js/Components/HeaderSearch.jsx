import { router } from '@inertiajs/react';
import React from 'react';

export default function HeaderSearch({ title, placeholder, searchValue, onSearchChange, onBackClick, onMenuClick, branches = [], selectedBranch = 'all' }) {

    const handleBranchChange = (e) => {
        const branchId = e.target.value;

        router.get(
            route(route().current()), 
            { branch_id: branchId }, 
            { 
                preserveState: false, 
                replace: true 
            }
        );
    };

    return (
        <div className="mb-6">
            <div className="flex justify-between items-center mb-5 pt-2">
                <button 
                    onClick={onBackClick || (() => window.history.back())}
                    className="p-2 text-gray-800 hover:bg-gray-100 rounded-xl transition-colors"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2.5} stroke="currentColor" className="w-6 h-6">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </button>

                <button 
                    onClick={onMenuClick}
                    className="p-2 text-gray-800 hover:bg-gray-100 rounded-xl transition-colors"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2.5} stroke="currentColor" className="w-6 h-6">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>

            <h1 className="text-2xl font-bold text-gray-900 mb-4 px-1">{title}</h1>

            {Array.isArray(branches) && branches.length > 0 && (
                <div className="mb-4">
                    <select 
                        value={selectedBranch}
                        onChange={handleBranchChange}
                        className="w-full bg-white border border-gray-200 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 outline-none focus:border-gray-400 focus:ring-0 shadow-sm"
                    >
                        <option value="all">Todas las sucursales</option>
                        {branches.map((branch) => (
                            <option key={branch.id} value={branch.id}>
                                {branch.branch_name}
                            </option>
                        ))}
                    </select>
                </div>
            )}

            <div className="flex items-center gap-3">
                <div className="relative flex-1">
                    <input
                        type="text"
                        value={searchValue}
                        onChange={onSearchChange}
                        placeholder={placeholder}
                        className="w-full bg-white border border-gray-200 pl-4 pr-10 py-3 rounded-2xl text-sm outline-none focus:border-gray-400 focus:ring-0 transition-colors shadow-sm"
                    />
                    {/* Ícono de Lupa */}
                    <div className="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2} stroke="currentColor" className="w-5 h-5">
                            <path strokeLinecap="round" strokeLinejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.603 10.602Z" />
                        </svg>
                    </div>
                </div>

                {/* Botón de Filtro */}
                <button className="p-3 bg-white border border-gray-200 rounded-2xl text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2} stroke="currentColor" className="w-5 h-5">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                    </svg>
                </button>
            </div>
        </div>
    );
}