@extends('layout')


@section('page-title')

    <div class="jumbotron text-center">
        <h1>Notifikasi</h1>
    </div>

@endsection

@section('page-contents')

    @php
    $number = 0;
    @endphp
    <table class="table table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu</th>
                <th>Isi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notifications as $it)
                <tr>
                    <td>{{ $number += 1 }}</td>
                    <td>
                        @if ($it->read_at == null)
                            <b>
                                {{ $it->created_at }}
                            </b>
                        @else
                            {{ $it->created_at }}
                        @endif
                    </td>
                    <td>
                        @if ($it->type == 'App\\Notifications\\UserStatusTransactionChanged')
                            Status transaksi <b>{{ $trans->created_at ?? '' }}</b> berubah dari
                            {{ $it->data['old_status'] }} menjadi
                            {{ $it->data['new_status'] }}
                        @endif

                        @if ($it->type == 'App\\Notifications\\PaymentUploaded')
                            Transaksi <b>{{ $trans->created_at ?? '' }}</b> telah di upload bukti pembayarannya
                        @endif

                        @if ($it->type == 'App\\Notifications\\AdminResponseToReview')
                            Seorang admin menjawab reviewmu <b>{{ $it->data['content'] ?? ''}}</b>
                        @endif

                        @if ($it->type == 'App\\Notifications\\NewReview')
                            Sebuah review baru telah ditambahkan <b>{{ $it->data['review']['content'] ?? '' }}</b>
                        @endif

                        @if ($it->type == 'App\\Notifications\\NewTransaction')
                            Sebuah transaksi baru ditambahkan <b>{{ $it->data['trans']['created_at'] ?? '' }}</b>
                        @endif

                        {{-- {{ $it }} --}}
                    </td>
                </tr>
                
                {{ $it->markAsRead() }}
            @endforeach
        </tbody>
    </table>
@endsection
