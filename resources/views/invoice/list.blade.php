@extends('layouts.app2')
@section('content')

<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.font518044
	{color:windowtext;
	font-size:6.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"�l�r �o�S�V�b�N", monospace;
	mso-font-charset:128;}
.xl6818044
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:#166A83;
	font-size:24.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	background:#DBF2F9;
	mso-pattern:black none;
	white-space:nowrap;}
.xl6918044
	{color:white;
	font-size:18.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:General;
	text-align:right;
	vertical-align:middle;
	background:#166A83;
	mso-pattern:black none;
	white-space:nowrap;
	padding-right:21px;
	mso-char-indent-count:1;}
.xl7018044
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:#166A83;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	background:#DBF2F9;
	mso-pattern:black none;
	white-space:normal;}
.xl7118044
	{color:white;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:General;
	text-align:right;
	vertical-align:middle;
	background:#166A83;
	mso-pattern:black none;
	white-space:nowrap;
	padding-right:21px;
	mso-char-indent-count:1;}
.xl7218044
	{color:white;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:"\[ENG\]\[$-F800\]dddd\\\,\\ mmmm\\ dd\\\,\\ yyyy";
	text-align:right;
	vertical-align:middle;
	background:#166A83;
	mso-pattern:black none;
	white-space:nowrap;
	padding-right:21px;
	mso-char-indent-count:1;}
.xl7318044
	{color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;
	padding-right:21px;
	mso-char-indent-count:1;}
.xl7418044
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:General;
	text-align:left;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7518044
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:General;
	text-align:general;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7618044
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:"\[<=99999999\]\#\#\#\#\\-\#\#\#\#\;\\\(00\\\)\\ \#\#\#\#\\-\#\#\#\#";
	text-align:left;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7718044
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7818044
	{color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:General;
	text-align:right;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;
	padding-right:42px;
	mso-char-indent-count:2;}
.xl7918044
	{color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:General;
	text-align:right;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;
	padding-right:21px;
	mso-char-indent-count:1;}
.xl8018044
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:#166A83;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:"\[<=99999999\]\#\#\#\#\\-\#\#\#\#\;\\\(00\\\)\\ \#\#\#\#\\-\#\#\#\#";
	text-align:left;
	vertical-align:middle;
	background:#DBF2F9;
	mso-pattern:black none;
	white-space:nowrap;}
.xl8118044
	{color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:"\0022\\0022\#\,\#\#0\.00\;\0022\\0022\\-\#\,\#\#0\.00";
	text-align:right;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;
	padding-right:42px;
	mso-char-indent-count:2;}
.xl8218044
	{color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:"\0022\\0022\#\,\#\#0\.00_\)\;\\\(\0022\\0022\#\,\#\#0\.00\\\)";
	text-align:right;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double #229FC4;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;
	padding-right:42px;
	mso-char-indent-count:2;}
.xl8318044
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:"\#\,\#\#0_\)\;\\\(\#\,\#\#0\\\)";
	text-align:left;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8418044
	{color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:"\0022\\0022\#\,\#\#0\;\0022\\0022\\-\#\,\#\#0";
	text-align:right;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;
	padding-right:42px;
	mso-char-indent-count:2;}
.xl8518044
	{color:#166A83;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;
	padding-left:21px;
	mso-char-indent-count:1;}
.xl8618044
	{color:black;
	font-size:12.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Meiryo UI", monospace;
	mso-font-charset:128;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;
	padding-left:21px;
	mso-char-indent-count:1;}
ruby
	{ruby-align:left;}
rt
	{color:windowtext;
	font-size:6.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"�l�r �o�S�V�b�N", monospace;
	mso-font-charset:128;
	mso-char-type:katakana;}
-->
</style>
</head>

<body>
<!--[if !excel]>�@�@<![endif]-->
<!--���̏��́AExcel �� Web �y�[�W�Ƃ��Ĕ��s�E�B�U�[�h�Ő�������܂����B-->
<!--�����A�C�e���� Excel ����Ĕ��s�����Ƃ��ADIV �^�O�Ԃ̂��ׂĂ̏�񂪒u���������܂��B-->
<!----------------------------->
<!--Excel �� Web �y�[�W�Ƃ��Ĕ��s �E�B�U�[�h�̃A�E�g�v�b�g�̎n�܂�-->
<!----------------------------->

<div id="tf00000041 (1)_18044" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=1240 class=xl6553518044
 style='border-collapse:collapse;table-layout:fixed;width:932pt'>
 <col class=xl6553518044 width=22 style='mso-width-source:userset;mso-width-alt:
 603;width:17pt'>
 <col class=xl6553518044 width=267 style='mso-width-source:userset;mso-width-alt:
 7332;width:201pt'>
 <col class=xl6553518044 width=443 style='mso-width-source:userset;mso-width-alt:
 12141;width:332pt'>
 <col class=xl6553518044 width=241 span=2 style='mso-width-source:userset;
 mso-width-alt:6601;width:181pt'>
 <col class=xl6553518044 width=26 style='mso-width-source:userset;mso-width-alt:
 713;width:20pt'>
 <tr height=70 style='mso-height-source:userset;height:52.5pt'>
  <td height=70 class=xl6553518044 width=22 style='height:52.5pt;width:17pt'></td>
  <td class=xl6818044 width=267 style='width:201pt'><a name="RANGE!B1">{!! $customer->customer_name !!}</a>　御中</td>
  <td class=xl6818044 width=443 style='width:332pt'></td>
  <td class=xl6918044 width=241 style='width:181pt'></td>
  <td class=xl6918044 width=241 style='width:181pt'>請求書</td>
  <td class=xl6553518044 width=26 style='width:20pt'></td>
 </tr>
 <tr height=25 style='mso-height-source:userset;height:18.75pt'>
  <td height=25 class=xl6553518044 width=22 style='height:18.75pt;width:17pt'></td>
  <td class=xl7018044 width=267 style='width:201pt'>〒{!! $customer->customer_postalcode !!}</td>
  <td class=xl7018044 width=443 style='width:332pt'><a
  href="mailto:"{!! $customer->customer_email !!}">{!! $customer->customer_email !!}</a></td>
  <td class=xl7118044><a name="RANGE!D2">請求書番号:</a></td>
  <td class=xl7118044>{!! $paynumber !!}</td>
  <td class=xl6553518044 width=26 style='width:20pt'></td>
 </tr>
 <tr height=25 style='mso-height-source:userset;height:18.75pt'>
  <td height=25 class=xl6553518044 width=22 style='height:18.75pt;width:17pt'></td>
  <td class=xl7018044 width=267 style='width:201pt'>{!! $customer->customer_address !!}</td>
  <td class=xl7018044 width=443 style='width:332pt'></td>
  <td class=xl7118044>請求日:</td>
  <td class=xl7218044>{!! $date !!}</td>
  <td class=xl6553518044 width=26 style='width:20pt'></td>
 </tr>
 <tr height=25 style='mso-height-source:userset;height:18.75pt'>
  <td height=25 class=xl6553518044 width=22 style='height:18.75pt;width:17pt'></td>
  <td class=xl8018044>TEL:{!! $customer->customer_phonenumber !!}</td>
  <td class=xl8018044>FAX:{!! $customer->customer_faxnumber !!}</td>
  <td class=xl7118044>期日:</td>
  <td class=xl7218044>{!! $paydate !!}</td>
  <td class=xl6553518044 width=26 style='width:20pt'></td>
 </tr>
 <tr height=40 style='mso-height-source:userset;height:30.0pt'>
  <td height=40 class=xl6553518044 width=22 style='height:30.0pt;width:17pt'></td>
  <td class=xl7318044></td>
  <td class=xl7418044 width=443 style='width:332pt'></td>
  <td class=xl7318044></td>
  <td class=xl7418044 width=241 style='width:181pt'></td>
  <td class=xl6553518044 width=26 style='width:20pt'></td>
 </tr>
 <tr height=60 style='height:45.0pt'>
  <td height=60 class=xl6553518044 width=22 style='height:45.0pt;width:17pt'></td>
  <td class=xl7518044></td>
  <td class=xl6553518044 width=443 style='width:332pt'></td>
  <td class=xl7318044></td>
  <td class=xl6553518044 width=241 style='width:181pt'></td>
  <td class=xl6553518044 width=26 style='width:20pt'></td>
 </tr>
 <tr height=40 style='mso-height-source:userset;height:30.0pt'>
  <td height=40 class=xl6553518044 width=22 style='height:30.0pt;width:17pt'></td>
  <td class=xl7518044></td>
  <td class=xl7618044></td>
  <td class=xl7318044></td>
  <td class=xl7618044></td>
  <td class=xl6553518044 width=26 style='width:20pt'></td>
 </tr>
 <tr height=40 style='mso-height-source:userset;height:30.0pt'>
  <td height=40 class=xl6553518044 width=22 style='height:30.0pt;width:17pt'></td>
  <td class=xl6553518044 width=267 style='width:201pt;font-size:11.0pt;
  color:#DBF2F9;font-weight:400;text-decoration:none;text-underline-style:none;
  text-line-through:none;font-family:"Meiryo UI", monospace;mso-font-charset:
  128;background:#166A83;mso-pattern:black none'>数量</td>
  <td class=xl7718044 style='font-size:11.0pt;color:#DBF2F9;font-weight:400;
  text-decoration:none;text-underline-style:none;text-line-through:none;
  font-family:"Meiryo UI", monospace;mso-font-charset:128;border:none;
  background:#166A83;mso-pattern:black none'>品目名称</td>
  <td class=xl7818044 style='font-size:11.0pt;color:#DBF2F9;font-weight:400;
  text-decoration:none;text-underline-style:none;text-line-through:none;
  font-family:"Meiryo UI", monospace;mso-font-charset:128;border:none;
  background:#166A83;mso-pattern:black none'>単価</td>
  <td class=xl7818044 style='font-size:11.0pt;color:#DBF2F9;font-weight:400;
  text-decoration:none;text-underline-style:none;text-line-through:none;
  font-family:"Meiryo UI", monospace;mso-font-charset:128;border:none;
  background:#166A83;mso-pattern:black none'>金額</td>
  <td class=xl6553518044 width=26 style='width:20pt'></td>
 </tr>
 @foreach($details as $detail)
 <tr height=40 style='mso-height-source:userset;height:30.0pt'>
  <td height=40 class=xl6553518044 width=22 style='height:30.0pt;width:17pt'></td>
  <td class=xl8318044 style='font-size:11.0pt;color:black;font-weight:400;
  text-decoration:none;text-underline-style:none;text-line-through:none;
  font-family:"Meiryo UI", monospace;mso-font-charset:128'>{!! number_format($detail->sum) !!}</td>
  <td class=xl6553518044 width=443 style='width:332pt;font-size:11.0pt;
  color:black;font-weight:400;text-decoration:none;text-underline-style:none;
  text-line-through:none;font-family:"Meiryo UI", monospace;mso-font-charset:
  128'>{!! $detail->item_name !!}</td>
  <td class=xl8418044 style='font-size:11.0pt;color:black;font-weight:400;
  text-decoration:none;text-underline-style:none;text-line-through:none;
  font-family:"Meiryo UI", monospace;mso-font-charset:128;border:none'>¥{!! number_format($detail->sell_price) !!}</td>
  <td class=xl8418044 style='font-size:11.0pt;color:black;font-weight:400;
  text-decoration:none;text-underline-style:none;text-line-through:none;
  font-family:"Meiryo UI", monospace;mso-font-charset:128;border:none'>¥{!! number_format(intval($detail->sum)*intval($detail->sell_price)) !!}</td>
  <td class=xl6553518044 width=26 style='width:20pt'></td>
 </tr>
 @endforeach
 
 <tr height=40 style='mso-height-source:userset;height:30.0pt'>
  <td height=40 class=xl6553518044 width=22 style='height:30.0pt;width:17pt'></td>
  <td colspan=2 class=xl8618044 width=710 style='width:533pt'></td>
  <td class=xl7918044><a name="RANGE!D22">消費税</td>
  <td class=xl8118044>¥{!! number_format(intval($tax)) !!}</td>
  <td class=xl6553518044 width=26 style='width:20pt'></td>
 </tr>
 <tr height=40 style='mso-height-source:userset;height:30.0pt'>
  <td height=40 class=xl6553518044 width=22 style='height:30.0pt;width:17pt'></td>
  <td colspan=2 class=xl8518044 width=710 style='width:533pt'>ご利用ありがとうございます。</td>
  <td class=xl7918044>合計</td>
  <td class=xl8218044>¥{!! number_format(intval($total_price)) !!}</td>
  <td class=xl6553518044 width=26 style='width:20pt'></td>
 </tr>
 <tr height=40 style='mso-height-source:userset;height:30.0pt'>
  <td height=40 class=xl6553518044 width=22 style='height:30.0pt;width:17pt'></td>
  <td class=xl6553518044 width=267 style='width:201pt'></td>
  <td class=xl6553518044 width=443 style='width:332pt'></td>
  <td class=xl6553518044 width=241 style='width:181pt'></td>
  <td class=xl6553518044 width=241 style='width:181pt'></td>
  <td class=xl6553518044 width=26 style='width:20pt'></td>
 </tr>
 <tr height=40 style='mso-height-source:userset;height:30.0pt'>
  <td height=40 class=xl6553518044 width=22 style='height:30.0pt;width:17pt'></td>
  <td class=xl6553518044 width=267 style='width:201pt'></td>
  <td class=xl6553518044 width=443 style='width:332pt'></td>
  <td class=xl6553518044 width=241 style='width:181pt'></td>
  <td class=xl6553518044 width=241 style='width:181pt'></td>
  <td class=xl6553518044 width=26 style='width:20pt'></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=22 style='width:17pt'></td>
  <td width=267 style='width:201pt'></td>
  <td width=443 style='width:332pt'></td>
  <td width=241 style='width:181pt'></td>
  <td width=241 style='width:181pt'></td>
  <td width=26 style='width:20pt'></td>
 </tr>
 <![endif]>
</table>

</div>


<!----------------------------->
<!--Excel �� Web �y�[�W�Ƃ��Ĕ��s �E�B�U�[�h�̃A�E�g�v�b�g�̏I���-->
<!----------------------------->
</body>



@endsection