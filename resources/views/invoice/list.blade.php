<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/invoice.css">
    <title>御請求書</title>
</head>
<body>
    <section class="sheet">
        <div class="row_1">
            <h1 class="text-center">御請求書</h1>
        </div>
        <div class="row_2">
            <ul class="text-right">
                <li>{!! $paynumber !!}</li>
                <li>{!! $date !!}</li>
            </ul>
        </div>
        <div class="row_3">
            <div class="col_1">
                <ul>
                    <li>
                        <h2 class="customer_name">{!! $customer->customer_name !!} 御中</h2>
                    </li>
                    <li>〒{!! $customer->customer_postalcode !!}</li>
                    <li>{!! $customer->customer_address !!}</li>
                </ul>
            </div>
            <div class="col_2">
                <ul >
                    <li>
                        <h2>なかの商事株式会社</h2>
                    </li>
                    <li>〒000-0000</li>
                    <li>東京都千代田区〇〇〇〇〇〇</li>
                    <li>〇〇〇〇ビル〇Ｆ</li>
                    <li>TEL: 00-0000-0000</li>
                    <li>FAX: 00-0000-0000</li>
                </ul>
                <img class="stamp" src="stamp.png">
            </div>
            <div class="clear-element"></div>
        </div>

        <div class="row_4">
            <p>下記のとおりご請求申し上げます。</p>

            <table class="summary">
                <tbody>
                    <tr>
                        <th>合計金額</th>
                        <td>\{!! number_format(intval($total_price)) !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row_5">
            <table class="detail">
                <thead>
                    <tr>
                        <th class="item">品名</th>
                        <th class="unit_price">単価</th>
                        <th class="amount">数量</th>
                        <th class="subtotal">金額</th>
                    </tr>
                </thead>
                <tbody>　{{--デフォルトは１４回繰り返し－データのある分だけまず繰り返し、１４回に満たない部分は空で繰り返し。--}}
                @foreach($details as $detail)
                    <tr class="dataline">
                        <td class="text-left"> {!! $detail->item_name !!} </td>
                        <td> {!! number_format($detail->sell_price) !!} </td>
                        <td> {!! number_format($detail->sum) !!} </td>
                        <td> {!! number_format(intval($detail->sum)*intval($detail->sell_price)) !!} </td>
                    </tr>
                @endforeach
                @for($i = 0; $i+count($details) < 14; $i++)
                    <tr class="dataline">
                        <td class="text-left">  </td>
                        <td>  </td>
                        <td>  </td>
                        <td>  </td>
                    </tr>
                @endfor
                    <tr>
                        <td class="space" rowspan="3" colspan="2"> </td>
                        <th> 小計 </th>
                        <td> {!! number_format(intval($subtotal)) !!} </td>
                    </tr>
                    <tr>
                        <th> 消費税 </th>
                        <td> {!! number_format(intval($tax)) !!} </td>
                    </tr>
                    <tr>
                        <th> 合計 </th>
                        <td> {!! number_format(intval($total_price)) !!} </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <ul>
            <li>振込先</li>
            <li>名義：カ）ナカノショウジ</li>
            <li>〇〇銀行 〇〇支店 普通 00000000</li>
        </ul>
        <p>※お振込み手数料は御社ご負担にてお願い致します。</p>

    </section>
</body>

{{--必要あらば、使用
<table>
 <tr>
  <td class=xl7118044>期日:</td>
  <td class=xl7218044>{!! $paydate !!}</td>
 </tr>
</table>

        {!! Form::open(['route'=>['customer.PDF', 'id' => $id,],'method' =>'get' ]) !!}
        {!! Form::hidden('year',$year) !!}
        {!! Form::hidden('month',$month) !!}
        {!! Form::submit('PDF出力',['class'=>'btn btn-info btn-sm']) !!}
        {!! Form::close() !!}
--}}