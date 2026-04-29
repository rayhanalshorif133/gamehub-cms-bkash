@extends('layouts.web', ['type' => 'Points'])


@section('content')
    <section id="section_one">
        <div class="card mx-auto" style="max-width: 100%;background: #55c1ff2b;">
            @guest
                <div>
                    You are a GUEST user
                </div>
            @else
                <input type="hidden" id="auth_phone_number" value="{{ Auth::user()->phone }}" />
                <div class="card-body d-flex coin-container">
                    <a href="{{ route('home') }}" style="position: absolute;left: 0px;"><i class="fa-solid fa-arrow-left-long"></i></a>
                    <div class="coin">
                        <img src="{{ asset('/assets/images/coin.png') }}" alt="coin symbol">
                        <p>
                            {{ Auth::user()->point }}
                        </p>
                        <div class="buttons d-none">
                            <button class="btn custom_button mx-1">Exchange</button>
                            <button class="btn custom_button mx-1" data-bs-toggle="offcanvas" data-bs-target="#recharge-offcanvas">
                                Recharge
                            </button>
                            {{-- convert offcanvas open --}}
                        </div>
                    </div>
                </div>
            @endguest
        </div>
        <div class="col-12" style="margin-bottom: 4rem;">
            <h1 class="section-title">Point History</h1>
            <div class="card paymentHistory">
                <table class="table">
                    <thead>
                        <tr style="background-color: #F02941; color: white;">
                            <th scope="col">Date</th>
                            <th scope="col">Details</th>
                            <th scope="col">Status</th>
                            <th scope="col">Point</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($points as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item->date)->format('d M, Y') }}</td>
                                <td>{{ $item->message }}</td>
                                <td>
                                    @if ($item->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif ($item->status == 'success')
                                        <span class="badge bg-success text-white">success</span>
                                    @elseif ($item->status == 'rejected')
                                        <span class="badge bg-danger text-white">Rejected</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $item->point }}</td>
                            </tr>
                        @endforeach
                        @if (count($points) == 0)
                            <tr>
                                <td colspan="4" class="text-center">History is empty</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
    <script>
        $(() => {
            $("#coin-decrement").click(() => {
                var coin = parseInt($("#set-coin").val());
                coin = coin - 100;
                if (coin < 0) coin = 0;
                var taka = coin / 100;
                if (coin == 0) taka = 0;
                $("#set-coin").val(coin);
                $("#bKash_button").text(`Pay Now (${taka} tk)`);
                $("#bKash_button").attr('data-amount', taka);
            });
            $("#coin-increment").click(function() {
                var coin = parseInt($("#set-coin").val());
                coin = coin + 100;
                $("#set-coin").val(coin);
                var taka = coin / 100;
                $("#bKash_button").text(`Pay Now (${taka} tk)`);
                $("#bKash_button").attr('data-amount', taka);
            });


        });
    </script>
@endpush
