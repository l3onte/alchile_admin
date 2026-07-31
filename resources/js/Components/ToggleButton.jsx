import React, { useState } from "react";

export function ToggleButton({ option1, option2, activeTab, onChange }) {
    return (
        <>
            <div className="flex justify-between items-center border rounded-full bg-gray-100 p-1 select-none">
                <div
                    onClick={() => onChange("supplies")}
                    className={`text-center py-2 px-4 rounded-full cursor-pointer transition-all duration-200 ${
                        activeTab === "supplies" 
                            ? "bg-green-500 font-medium shadow-sm" 
                            : "text-gray-600 hover:text-gray-900"
                    }`}
                >
                    {option1}
                </div>

                <div
                    onClick={() => onChange("products")}
                    className={`text-center py-2 px-4 rounded-full cursor-pointer transition-all duration-200 ${
                        activeTab === "products" 
                            ? "bg-green-600 font-medium shadow-sm" 
                            : "text-gray-600 hover:text-gray-900"
                    }`}
                >
                    {option2}
                </div>
            </div>
        </>
    )
}