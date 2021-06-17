<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cảm ơn quý khách đã đặt hàng tại eTechShop</title>

    <style>
        html * {
            font-family: Arial, Helvetica, sans-serif !important;
            font-weight: 300 !important;
        }

        td, th {
            text-align: center;
            border: none;
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        table {
            border: none;
        }

        .head {
            background-color: #02cfea;
        }

        tr {
            background-color: #86dae6;
        }
    </style>
</head>
<body>
<h4>THÔNG TIN ĐƠN HÀNG</h4>
<hr>
<h5>Thông tin thanh toán</h5>
Họ và Tên: {{$details['userInfo']->name}}
Địa chỉ email: {{$details['userInfo']->email}}
Số điện thoại: {{$details['userInfo']->phone}}
Địa chỉ giao hàng: {{$details['userInfo']->address}}
<h2>THÔNG TIN ĐƠN HÀNG</h2>
<hr>
<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
    <tr class="head">
        <th style="color: white;" class="left"><h4>Sản phẩm</h4></th>
        <th style="color: white;min-width: 5em;"><h4>Đơn giá</h4></th>
        <th style="color: white;min-width: 5em;"><h4>Số lượng</h4></th>
        <th style="color: white;min-width: 5em;" class="right"><h4>Tổng tạm</h4></th>
    </tr>
    @foreach($details['product'] as $item)
        <tr>
            <td class="left">{{$item->name}}</td>
            <td>{{$item->price}}</td>
            <td>{{$item->qty}}</td>
            <td class="right">{{$item->price*$item->qty}}</td>
        </tr>
    @endforeach
    <tr>
        <td class="right" colspan="3">Total</td>
        <td class="right">{{$details['total']}}</td>
    </tr>
</table>
</body>
</html>
