@extends('layouts.header')

@section('content')
    <div class="container">
        @include('layouts.menu-gameplay')

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Desc</th>
                                <th>IN</th>
                                <th>OUT</th>
                            </thead>
                            <tbody>
                                @foreach ($finances as $fin)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $fin->transaction_date }}</td>
                                        <td>{{ $fin->description }}</td>
                                        <td class="text-end">{{ $fin->type == 'in' ? '-' . cleanNumber($fin->amount) : '' }}
                                        </td>
                                        <td class="text-end">{{ $fin->type == 'out' ? cleanNumber($fin->amount) : '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customjs')
@endsection