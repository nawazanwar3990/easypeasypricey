<div class="modal fade" id="modal"
     data-bs-backdrop="static"
     data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title mb-0" id="exampleModalLabel">Order {{ $order['name'] }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card border-0">
                    <div class="card-body py-0 fs-13px">
                        @forelse($order['line_items'] as $orderItem)
                            <div class="row my-1 @if(!$loop->last) border-bottom pb-2 @endif ">
                                <div class="col-lg-5 col-xl-5 col-xxl-5 col-md-5 col-sm-5 col-4 align-self-center">
                                    <div class="row">
                                        <div class="col-2 align-self-center">
                                            <img src="{{ asset('images/no_avatar.png') }}" class="img-fluid img-thumbnail" alt="{{ $orderItem['variant_id'] }}"
                                                 style="width: 80px;">
                                        </div>
                                        <div class="col-10 align-self-center">
                                            <p class="mb-0 fs-13px">{{ $orderItem['title'] }}</p>
                                            <small><strong>SKU:</strong> {{ $orderItem['sku'] }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-2 col-sm-2 col-4  align-self-center">
                                    {!! Form::text('quantities['.$orderItem['id'].']',$orderItem['quantity'],['data-quantity'=>$orderItem['quantity'],'data-line-item'=>$orderItem['id'],'class'=>'form-control form-control-sm quantities','onkeyup'=>'updateQuantity(this);']) !!}
                                </div>
                                <div class="col-lg-1 col-xl-1 col-xxl-1 col-md-1 col-sm-1 col-4   align-self-center text-center">✕</div>
                                <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-2 col-sm-2 col-4  align-self-center">
                                    {!! Form::text('prices['.$orderItem['id'].']',$orderItem['price'],['class'=>'form-control form-control-sm prices','readonly']) !!}
                                </div>
                                <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-2 col-sm-2 col-4   align-self-center text-end">
                                    {{ $order['currency'] }} <span class="current_item_price">{{ $orderItem['price']*intval($orderItem['quantity']) }}</span>
                                </div>
                            </div>
                        @empty

                        @endforelse
                    </div>
                </div>
                <div class="card border-0 mt-2">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Payment Details</h6>
                    </div>
                    <div class="card-body fs-13px py-0">

                        <div class="row my-2 border-bottom pb-2">
                            <div class="col ">Subtotal</div>
                            <div class="col text-end">
                                {{$order['presentment_currency']}} <span
                                    class="sub_total_price">{{$order['subtotal_price']}}</span>
                            </div>
                        </div>

                        @if(isset($order['discount_codes']) AND count($order['discount_codes'])>0)
                            <div class="row my-2 border-bottom pb-2">
                                <div class="col align-self-center">Discount</div>
                                <div class="col align-self-center">{{$order['discount_codes'][0]['code']}}</div>
                                <div class="col align-self-center text-end">
                                    {{$order['presentment_currency']}} <span id="total_discount_price">{{$order['discount_codes'][0]['amount']}}</span>
                                </div>
                            </div>
                        @endif

                        @if(isset($order['shipping_lines']) AND count($order['shipping_lines'])>0)
                            <div class="row my-2 border-bottom pb-2">
                                <div class="col">Shipping</div>
                                <div class="col">{{$order['shipping_lines'][0]['code']}}</div>
                                <div class="col text-end">
                                    {{$order['presentment_currency']}} <span id="total_shipping_price">{{$order['shipping_lines'][0]['discounted_price']}}</span>
                                </div>
                            </div>
                        @endif

                        @if(isset($order['tax_lines']) AND count($order['tax_lines'])>0)
                            <div class="row my-2 border-bottom pb-2">
                                <div class="col">Tax</div>
                                <div class="col">
                                    {{$order['tax_lines'][0]['title']}} {{$order['tax_lines'][0]['rate']}}% (Included)
                                </div>
                                <div class="col text-end">
                                    {{$order['presentment_currency']}} <span id="total_tax_line_price">{{$order['tax_lines'][0]['price']}}</span>
                                </div>
                            </div>
                        @endif
                        <div class="row my-2 border-bottom pb-2">
                            <div class="col">Total</div>
                            <div class="col text-end">
                                {{$order['presentment_currency']}} <span
                                    class="total_price">{{$order['subtotal_price']}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">Paid By Customer</div>
                            <div class="col text-end">
                                {{$order['presentment_currency']}} <span
                                    class="total_customer_price">{{$order['total_price']}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-primary" onclick="updateOrderItem('{{$order['id']}}')">Update</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
