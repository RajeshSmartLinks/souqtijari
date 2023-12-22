@include('front.mail.header')
@include('front.mail.content')
<table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
  <tr style="border-collapse:collapse">
    <td align="center" style="padding:0;Margin:0"><table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
        <tr style="border-collapse:collapse">
          <td align="left" style="padding:0;Margin:0;padding-left:20px;padding-right:20px"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
              <tr style="border-collapse:collapse">
                <td valign="top" align="center" style="padding:0;Margin:0;width:560px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;font-size:0"><table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                          <tr style="border-collapse:collapse">
                            <td style="padding:0;Margin:0;border-bottom:1px solid #CCCCCC;background:none;height:1px;width:100%;margin:0px"></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr style="border-collapse:collapse">
          <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px"><table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
              <tr style="border-collapse:collapse">
                <td class="es-m-p20b" align="left" style="padding:0;Margin:0;width:560px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-bottom:5px;padding-top:15px;font-size:0px"><a target="_blank" href="{{ env('APP_URL')}}/en/userlogin" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#3D5CA3"> <img src="{{ asset('images/mail/47641612255033717.png') }}" alt="Register" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" title="Register" width="39" height="39"></a></td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-top:5px;padding-bottom:5px"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;color:#333333">{{ $maildetails['safety_title'] }}</h4></td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0"><ul>
						  @if($maildetails['safety_slug'] == 'safety-tips-for-buyers')
						  @foreach($maildetails['safety_description'] as $safetytips)
						  <li style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;Margin-bottom:15px;color:#333333;text-align:left"><span class="product-description">{!! $safetytips !!}</span></li>
						  @endforeach
						  @endif
                        </ul></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr style="border-collapse:collapse">
          <td align="left" style="Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;padding-bottom:30px"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
              <tr style="border-collapse:collapse">
                <td valign="top" align="center" style="padding:0;Margin:0;width:560px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0"><span class="es-button-border" style="border-style:solid;border-color:#3D5CA3;background:#FFFFFF;border-width:2px;display:inline-block;border-radius:4px;width:auto"><a href="{{ env('APP_URL')}}" class="es-button" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:16px;color:#3D5CA3;border-style:solid;border-color:#FFFFFF;border-width:10px 15px 10px 15px;display:inline-block;background:#FFFFFF;border-radius:4px;font-weight:normal;font-style:normal;line-height:19px;width:auto;text-align:center"> @lang('app.lets_get_back') »</a></span></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
@include('front.mail.footer')