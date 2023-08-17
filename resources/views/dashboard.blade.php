@extends('layouts.app')
@section('content')
    @include('components.messages')
@endsection
@section('pageScript')
    <div class="row row-container">
        <div class="col-12 px-0">
            <table class="table">
                <thead class="bg-light">
                <tr>
                    <th>Order</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Payment Status</th>
                    <th>Fulfillment Status</th>
                    <th>Items</th>
                    <th class="text-center no-sort">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            {{ $order['name'] }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($order['created_at'])->format('d M') }}
                            at {{ \Carbon\Carbon::parse($order['created_at'])->format('g:i A') }}
                        </td>
                        <td>
                            @isset($order['customer'])
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle bg-transparent px-0"
                                            type="button"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        {{ $order['customer']['first_name'] }} {{ $order['customer']['last_name'] }}
                                    </button>
                                    <div class="dropdown-menu fs-13px"
                                         style="width: 300px;">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item fs-13 font-weight-bold">
                                                {{ $order['customer']['first_name'] }} {{ $order['customer']['last_name'] }}
                                            </li>
                                            <li class="list-group-item fs-13">
                                                @isset($order['customer']['default_address'])
                                                    {{ $order['customer']['default_address']['address1'] }}
                                                @endisset
                                            </li>
                                            <li class="list-group-item fs-13">
                                                {{ $order['customer']['email'] }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endisset
                        </td>
                        <td>
                            {{ $order['currency'] }} {{ $order['subtotal_price'] }}
                        </td>
                        <td>
                            @if(!empty($order['financial_status']))
                                @if($order['financial_status']=='paid')
                                    <a class="btn btn-sm btn-success text-white text-capitalize">Paid</a>
                                @else
                                    <a class="btn btn-sm btn-warning text-white text-capitalize">{{$order['financial_status']}}</a>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if(!empty($order['fulfillment_status']))
                                @if($order['fulfillment_status']=='fulfilled')
                                    <a class="btn btn-sm btn-success text-white text-capitalize">Fulfilled
                                        ({{count($order['fulfillments'])}})</a>
                                @else
                                    <a class="btn btn-sm btn-warning text-white text-capitalize">{{$order['fulfillment_status']}}</a>
                                @endif
                            @else
                                <a class="btn btn-sm btn-warning text-white text-capitalize">Unfulfilled</a>
                            @endif
                        </td>
                        <td>
                            @isset($order['line_items'])
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle bg-transparent px-0"
                                            type="button"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        {{ count($order['line_items']) }} items
                                    </button>
                                    <div class="dropdown-menu fs-13px"
                                         style="width: 500px;">
                                        <ul class="list-group p-3">
                                            @foreach($order['line_items'] as $lineItem)
                                                <li class="list-group-item">
                                                    <div class="row text-sm-left">
                                                        <div class="col-10">
                                                            <a class="fs-13 text-primary">{{$lineItem['name']}}</a><br>
                                                            <small><strong>SKU</strong>
                                                                : {{ $lineItem['sku'] }}</small>
                                                        </div>
                                                        <div class="col-2">
                                                            <small>x{{$lineItem['quantity']}}</small>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endisset
                        </td>
                        <td class="text-center">
                            @if($order['fulfillment_status'] !=='fulfilled')
                                <button class="btn btn-sm btn-info text-white fs-13"
                                        onclick="callPopUp(this,'{{$order['id']}}');return false;">
                                    <i class="fa fa-edit"></i>
                                </button>
                            @else
                                <button class="btn btn-sm btn-danger text-white fs-13" disabled="disabled">Fulfilled</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">
                            No Order Found
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div id="modal_holder"></div>
@endsection
