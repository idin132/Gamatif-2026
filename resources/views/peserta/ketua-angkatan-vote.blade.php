@extends('layouts.peserta')

@section('content')
<div class="max-w-6xl mx-auto px-3 py-8 sm:px-5 md:py-14">
    <div class="mx-auto mb-10 max-w-3xl text-center reveal">
        <p class="section-label">Pemilihan Ketua Angkatan</p>
        <h1 class="mt-3 font-cinzel text-3xl font-black text-white sm:text-4xl md:text-5xl">Tentukan Pilihanmu</h1>
        <p class="mt-4 text-sm leading-relaxed text-zinc-400 md:text-base">Kenali setiap calon melalui visi dan misi mereka, lalu pilih satu pemimpin terbaik untuk angkatanmu.</p>
        <div class="mx-auto mt-6 flex w-fit items-center gap-2 rounded-full border border-gold-500/20 bg-gold-500/5 px-4 py-2 text-[10px] font-semibold uppercase tracking-[0.2em] text-gold-400">
            <span class="h-1.5 w-1.5 rounded-full bg-gold-400 shadow-[0_0_10px_rgba(201,168,76,0.8)]"></span>
            Satu suara untuk satu pilihan
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-md border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-md border border-rose-500/30 bg-rose-500/10 px-4 py-3 text-sm text-rose-300">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse($calonKetua as $calon)
            <div class="card-glass group flex flex-col rounded-2xl p-4 transition duration-300 hover:-translate-y-1 hover:border-gold-500/40 hover:shadow-[0_18px_45px_rgba(0,0,0,0.28)] sm:p-5 reveal" x-data="{ open: false }">
                <div class="flex items-center justify-between">
                    <span class="font-cinzel text-[0.6rem] uppercase tracking-[0.26em] text-gold-500">Calon {{ $loop->iteration }}</span>
                    <span class="rounded-full border border-white/10 bg-white/[0.03] px-2.5 py-1 text-[9px] uppercase tracking-[0.16em] text-zinc-500">{{ $calon->votes_count }} suara</span>
                </div>

                <div class="relative mt-4 overflow-hidden rounded-xl border border-gold-500/25 bg-black/30">
                    <img src="{{ $calon->foto ? asset('storage/' . $calon->foto) : asset('images/default-user.png') }}"
                         alt="{{ $calon->nama }}"
                         class="h-48 w-full object-cover transition duration-500 group-hover:scale-105 sm:aspect-square sm:h-auto">
                    <div class="pointer-events-none absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-black/70 to-transparent"></div>
                </div>

                <div class="mt-4">
                    <h2 class="font-cinzel text-xl text-white sm:text-2xl">{{ $calon->nama }}</h2>
                </div>

                <div class="mt-4 rounded-xl border border-white/10 bg-black/20 p-3.5 text-sm text-zinc-300">
                    <div class="grid grid-cols-3 gap-2 sm:gap-3">
                        <div>
                            <p class="font-cinzel text-[0.52rem] uppercase tracking-[0.2em] text-gold-500">NIM</p>
                            <p class="mt-1.5 break-words text-xs text-zinc-100">{{ $calon->nim }}</p>
                        </div>
                        <div>
                            <p class="font-cinzel text-[0.52rem] uppercase tracking-[0.2em] text-gold-500">House</p>
                            <p class="mt-1.5 truncate text-xs text-zinc-100">{{ $calon->kelompok?->nama_kelompok ?? 'Belum diatur' }}</p>
                        </div>
                        <div>
                            <p class="font-cinzel text-[0.52rem] uppercase tracking-[0.2em] text-gold-500">Kelas</p>
                            <p class="mt-1.5 truncate text-xs text-zinc-100">{{ $calon->kelas }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-5 flex flex-col gap-2.5 sm:flex-row">
                    <button type="button"
                            @click="open = true"
                            class="btn-glass-outline flex-1 rounded-lg px-4 py-2.5 text-center text-xs">
                        Lihat Visi &amp; Misi
                    </button>

                    @if($vote)
                        @if($vote->ketua_angkatan_id === $calon->id)
                            <span class="inline-flex flex-1 items-center justify-center rounded-lg border border-emerald-500/40 bg-emerald-500/10 px-4 py-2.5 text-[10px] font-semibold uppercase tracking-[0.16em] text-emerald-300">
                                Sudah pilih
                            </span>
                        @else
                            <span class="inline-flex flex-1 items-center justify-center rounded-lg border border-zinc-700 bg-zinc-900/40 px-4 py-2.5 text-[10px] font-semibold uppercase tracking-[0.16em] text-zinc-500">
                                Terpilih lain
                            </span>
                        @endif
                    @else
                        <form action="{{ route('peserta.voting_ketua_angkatan.store', $calon->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="btn-glass w-full rounded-lg px-4 py-2.5 text-xs font-semibold uppercase tracking-[0.18em]">
                                Pilih Calon Ini
                            </button>
                        </form>
                    @endif
                </div>

                <div x-show="open" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 px-4 py-8" x-cloak>
                    <div @click.away="open = false" class="w-full max-w-2xl rounded-2xl border border-gold-500/30 bg-[#120e0a] p-6 shadow-[0_20px_80px_rgba(0,0,0,0.7)]">
                        <div class="flex items-start justify-between gap-4">
                            <h3 class="font-cinzel text-3xl uppercase tracking-[0.12em] text-white">Visi &amp; Misi</h3>
                            <button type="button" @click="open = false" class="text-zinc-400 transition hover:text-white">✕</button>
                        </div>

                        <div class="mt-6 space-y-5">
                            <div class="rounded-xl border border-gold-500/20 bg-black/20 p-4">
                                <p class="font-cinzel text-[0.6rem] tracking-[0.28em] uppercase text-gold-500">Visi</p>
                                <p class="mt-3 leading-relaxed text-zinc-200">{{ $calon->visi }}</p>
                            </div>
                            <div class="rounded-xl border border-gold-500/20 bg-black/20 p-4">
                                <p class="font-cinzel text-[0.6rem] tracking-[0.28em] uppercase text-gold-500">Misi</p>
                                <p class="mt-3 leading-relaxed text-zinc-200">{{ $calon->misi }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl border border-gold-500/20 bg-black/20 p-8 text-center text-zinc-300">
                Belum ada calon ketua angkatan yang tersedia.
            </div>
        @endforelse
    </div>
</div>
@endsection
