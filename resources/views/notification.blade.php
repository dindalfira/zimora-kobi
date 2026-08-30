@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-5xl px-6 py-8">

    <div class="mb-6 flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Notifikasi
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Pemberitahuan terkait pemeriksaan dan pemenuhan LKE.
            </p>
        </div>

        @if($notifications->where('dibaca', false)->count() > 0)

            <form action="{{ route('notifications.readAll') }}" method="POST">
                @csrf

                <button
                    type="submit"
                    class="text-sm font-medium text-blue-600 hover:text-blue-800"
                >
                    Tandai semua sudah dibaca
                </button>
            </form>

        @endif

    </div>


    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">

        @forelse($notifications as $notification)

            <a
                href="{{ route('notifications.read', $notification) }}"
                class="block border-b border-gray-100 px-6 py-5 transition hover:bg-gray-50
                    {{ !$notification->dibaca ? 'bg-blue-50/50' : '' }}"
            >

                <div class="flex gap-4">

                    {{-- Icon --}}
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full
                        {{ $notification->tipe === 'perbaikan_bukti'
                            ? 'bg-amber-100 text-amber-600'
                            : 'bg-blue-100 text-blue-600' }}">

                        @if($notification->tipe === 'perbaikan_bukti')
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        @else
                            <i class="fa-solid fa-file-circle-check"></i>
                        @endif

                    </div>


                    <div class="min-w-0 flex-1">

                        <div class="flex items-start justify-between gap-4">

                            <h3 class="font-semibold text-gray-800">
                                {{ $notification->judul }}
                            </h3>

                            @if(!$notification->dibaca)
                                <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-blue-600"></span>
                            @endif

                        </div>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ $notification->pesan }}
                        </p>

                        <p class="mt-2 text-xs text-gray-400">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>

                    </div>

                </div>

            </a>

        @empty

            <div class="px-6 py-16 text-center">

                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center
                    rounded-full bg-gray-100 text-gray-400">

                    <i class="fa-regular fa-bell text-xl"></i>

                </div>

                <h3 class="font-semibold text-gray-700">
                    Belum ada notifikasi
                </h3>

                <p class="mt-1 text-sm text-gray-400">
                    Notifikasi baru akan muncul di sini.
                </p>

            </div>

        @endforelse

    </div>

    <div class="mt-5">
        {{ $notifications->links() }}
    </div>

</div>

@endsection