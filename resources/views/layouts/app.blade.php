<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{ config('app.name',$pageTitle) }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/data-table.min.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/confirm.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css?v='.time()) }}">
</head>
<body class="bg-light" id="main-holder" style="width: 96%; margin: 27px auto;">
<main class="container-fluid">
    @yield('content')
</main>
<script src="{{ asset('js/jquery.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/popper.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/bootstrap.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/data-table.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/confirm.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/toast.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/script.js?v='.time()) }}"></script>
@yield('pageScript')
<script>
    let route = "{{ env('SHOPIFY_ABSOLUTE_URL') }}";

    function callPopUp(cElement, orderId) {
        const api = new Ajax(route);
        (async () => {
            try {
                const postData = {
                    orderId: orderId
                };
                const response = await api.post('orders/edit?shop={{ \App\Services\ShopService::getShopDomain() }}', postData);
                $('#modal_holder').empty().html(response);
                $("#modal").modal('show');
            } catch (error) {
                console.error('Error:', error.message);
            }
        })();
    }

    function calculateTotal() {
        //update sub total price
        let sub_total_price = 0;
        let total_price = 0;

        $('.current_item_price').each(function () {
            let elementValue = $(this).text();
            sub_total_price += parseFloat(elementValue);
        });
        $(".sub_total_price").empty().text(sub_total_price);

        let discount_element = $("#total_discount_price");
        if (discount_element.length > 0) {
            let total_discount_price = parseFloat(discount_element.val());
        }
        let shipping_element = $("#total_shipping_price");
        if (shipping_element.length > 0) {
            let total_discount_price = parseFloat(discount_element.val());
        }
        let tax_lines_element = $("#total_tax_line_price");
        if (tax_lines_element.length > 0) {
            let total_tax_line_price = parseFloat(tax_lines_element.val());
        }

        total_price = sub_total_price;
        total_price = total_price.toFixed(2);
        $(".total_price").empty().text(total_price);
        $(".total_customer_price").empty().text(total_price);
    }

    function updateQuantity(cElement) {
        let parentElement = $(cElement);
        let quantity = parseFloat(parentElement.val());
        console.log('current_quantity', quantity);
        if (quantity < 1) {
            showError('Value Reset to Original Value because negative values not allowed');
            quantity = parseFloat(parentElement.attr('data-quantity'));
            parentElement.val(quantity);
        }
        let parentRow = parentElement.closest('.row');
        let current_price = parentRow.find('.prices').val();
        current_price = parseFloat(current_price);
        console.log('current_price', current_price);
        let finalValue = quantity * current_price;
        parentRow.find('.current_item_price').empty().text(finalValue.toFixed(2));
        calculateTotal();
    }

    function updateOrderItem(orderId) {
        const data = {};
        $('.quantities').each(function () {
            let quantity = $(this).val();
            let itemId = $(this).attr('data-line-item');
            data[itemId] = quantity;
        });
        const api = new Ajax(route);
        (async () => {
            try {
                const response = await api.post('orders/update?orderId=' + orderId + '&shop={{ \App\Services\ShopService::getShopDomain() }}', data);
                if (response.success === true) {
                    showSuccess('Record has been updated Successfully');
                }
            } catch (error) {
                showError(error.message);
            }
        })();
    }
</script>
</body>
</html>

