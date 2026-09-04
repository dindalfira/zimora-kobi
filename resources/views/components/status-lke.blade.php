                        <div
                            id="status-pertanyaan-{{ $pertanyaan->id_pertanyaan }}"
                            data-status="{{ $pertanyaan->status_pertanyaan }}"
                        >
                            @if ($pertanyaan->status_pertanyaan === 'pemeriksaan')

                                <span class="inline-flex items-center gap-1.5 rounded-full
                                            border border-blue-100 px-2.5 py-1.5
                                            text-[10px] font-medium text-sky-700 bg-blue-50
                                            transition">

                                    <i data-lucide="loader"
                                        class="h-3.5 w-3.5"></i>

                                    Pemeriksaan
                                </span>

                            @elseif ($pertanyaan->status_pertanyaan === 'belum')

                                <span class="inline-flex items-center gap-1.5 rounded-full
                                            border border-slate-100 px-2.5 py-1.5
                                            text-[10px] font-medium text-slate-700 bg-slate-50
                                            transition">

                                    <i data-lucide="clock"
                                        class="h-3.5 w-3.5"></i>

                                    Belum
                                </span>

                            @elseif ($pertanyaan->status_pertanyaan === 'perbaikan')

                                <span class="inline-flex items-center gap-1.5 rounded-full
                                            border border-amber-100 px-2.5 py-1.5
                                            text-[10px] font-medium text-amber-700 bg-amber-50
                                            transition">

                                    <i data-lucide="square-pen"
                                        class="h-3.5 w-3.5"></i>

                                    Perbaikan
                                </span>

                            @elseif ($pertanyaan->status_pertanyaan === 'sesuai')

                                <span class="inline-flex items-center gap-1.5 rounded-full
                                            border border-indigo-100 px-2.5 py-1.5
                                            text-[10px] font-medium text-indigo-700 bg-indigo-50
                                            transition">

                                    <i data-lucide="circle-check"
                                        class="h-3.5 w-3.5"></i>

                                    Sesuai
                                </span>

                            @elseif ($pertanyaan->status_pertanyaan === 'dinilai')

                                <span class="inline-flex items-center gap-1.5 rounded-full
                                            border border-emerald-100 px-2.5 py-1.5
                                            text-[10px] font-medium text-emerald-700 bg-emerald-50
                                            transition">

                                    <i data-lucide="award"
                                        class="h-3.5 w-3.5"></i>

                                    Dinilai
                                </span>

                            @elseif ($pertanyaan->status_pertanyaan === 'terlambat')

                                <span class="inline-flex items-center gap-1.5 rounded-full
                                            border border-red-100 px-2.5 py-1.5
                                            text-[10px] font-medium text-red-700 bg-red-50
                                            transition">

                                    <i data-lucide="triangle-alert"
                                        class="h-3.5 w-3.5"></i>

                                    Terlambat
                                </span>

                            @else

                                <span class="inline-flex items-center gap-1.5 rounded-full
                                            border border-slate-100 px-2.5 py-1.5
                                            text-[10px] font-medium text-slate-500 bg-slate-50
                                            transition">

                                    <i data-lucide="circle-help"
                                        class="h-3.5 w-3.5"></i>

                                    Tidak diketahui
                                </span>

                            @endif
                         </div>
