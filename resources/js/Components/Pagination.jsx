import React from 'react';
import { router } from '@inertiajs/react';

export default function Pagination({ links }) {
    if (!links || links.length <= 3) return null;

    return (
        <div className="flex justify-center items-center gap-2 mt-6 mb-4">
            {links.map((link, idx) => {
                let label = link.label;
                if (label.includes('Previous')) label = '«';
                if (label.includes('Next')) label = '»';

                return (
                    <button
                        key={idx}
                        disabled={!link.url}
                        onClick={() => {
                            if (link.url) {
                                router.get(link.url, {}, {
                                    preserveState: true,
                                    preserveScroll: true,
                                });
                            }
                        }}
                        className={`
                            min-w-[40px] h-10 px-3 flex items-center justify-center text-sm font-medium transition-all duration-200
                            ${link.active
                            ? 'bg-[#262626] text-white rounded-xl shadow-sm scale-105'
                            : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-xl'
                        }
                            ${!link.url ? 'opacity-30 cursor-not-allowed' : 'cursor-pointer'}
                        `}
                        dangerouslySetInnerHTML={{ __html: label }}
                    />
                );
            })}
        </div>
    );
}
