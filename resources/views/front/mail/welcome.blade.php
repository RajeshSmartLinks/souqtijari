@include('front.mail.header')
@include('front.mail.content')
<table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
  <tr style="border-collapse:collapse">
    <td align="center" style="padding:0;Margin:0"><table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
        <tr style="border-collapse:collapse">
          <td style="Margin:0;padding-bottom:5px;padding-left:20px;padding-right:20px;padding-top:30px;background-color:#FFFFFF;background-repeat:no-repeat" bgcolor="#ffffff" align="left"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
              <tr style="border-collapse:collapse">
                <td valign="top" align="center" style="padding:0;Margin:0;width:560px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0"><h3 style="Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#3D5CA3">@lang('app.here_how_to_start'):</h3></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr style="border-collapse:collapse">
          <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px"><!--[if mso]><table style="width:560px" cellpadding="0" cellspacing="0"><tr><td style="width:265px" valign="top"><![endif]-->
            
            <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
              <tr style="border-collapse:collapse">
                <td class="es-m-p20b" align="left" style="padding:0;Margin:0;width:255px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-bottom:5px;padding-top:15px;font-size:0"><a target="_blank" href="{{ env('APP_URL')}}/{{ $maildetails['lang'] }}/userlogin" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#3D5CA3"><img src="{{ asset('images/mail/40281527675753663.png') }}" alt="@lang('app.register')" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" title="@lang('app.register')" width="39" height="40"></a></td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-top:5px;padding-bottom:5px"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;color:#333333">@lang('app.register')</h4></td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#333333"><span class="product-description">@lang('app.register_with')</span></p></td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-top:5px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#333333"> <a target="_blank" href="{{ env('APP_URL')}}/{{ $maildetails['lang'] }}/userlogin" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#3D5CA3">@lang('app.register_here') »</a></p></td>
                    </tr>
                  </table></td>
                <td class="es-hidden" style="padding:0;Margin:0;width:10px"></td>
              </tr>
            </table>
            
            <!--[if mso]></td><td style="width:30px" valign="top"><![endif]-->
            
            <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
              <tr class="es-hidden" style="border-collapse:collapse">
                <td class="es-m-p20b" align="left" style="padding:0;Margin:0;width:30px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;font-size:0"><img src="{{ asset('images/mail/47561527672335572.png') }}" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="30" height="200"></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            
            <!--[if mso]></td><td style="width:10px"></td><td style="width:255px" valign="top"><![endif]-->
            
            <table class="es-right" cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
              <tr style="border-collapse:collapse">
                <td class="es-m-p20b" align="left" style="padding:0;Margin:0;width:255px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-bottom:5px;padding-top:15px;font-size:0"><a target="_blank" href="{{ env('APP_URL')}}/{{ $maildetails['lang'] }}/userlogin" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#3D5CA3"><img src="{{ asset('images/mail/33081527675753787.png') }}" alt="@lang('app.update_profile')" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" title="@lang('app.update_profile')" width="39" height="40"></a></td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-top:5px;padding-bottom:5px"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;color:#333333">@lang('app.update_profile')</h4></td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#333333"><span class="product-description">@lang('app.update_your_profile')</span><br>
                        </p></td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-top:5px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#333333"> <a target="_blank" href="{{ env('APP_URL')}}/{{ $maildetails['lang'] }}/userlogin" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#3D5CA3">@lang('app.update_here') »</a></p></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            
            <!--[if mso]></td></tr></table><![endif]--></td>
        </tr>
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
          <td align="left" style="padding:0;Margin:0;padding-bottom:20px;padding-left:20px;padding-right:20px"><!--[if mso]><table style="width:560px" cellpadding="0" cellspacing="0"><tr><td style="width:265px" valign="top"><![endif]-->
            
            <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
              <tr style="border-collapse:collapse">
                <td class="es-m-p20b" align="left" style="padding:0;Margin:0;width:255px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-bottom:5px;padding-top:25px;font-size:0px"><a target="_blank" href="{{ env('APP_URL')}}/{{ $maildetails['lang'] }}/userlogin" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#3D5CA3"> <img src="{{ asset('images/mail/61671612253629184.png') }}" alt="@lang('app.post_your_ad')" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" title="@lang('app.post_your_ad')" width="39" height="39"></a></td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-top:5px;padding-bottom:5px"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;color:#333333">@lang('app.post_your_ad') </h4></td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#333333"><span class="product-description">@lang('app.post_a_free_ad')</span></p></td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-top:5px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#333333"><a target="_blank" href="{{ env('APP_URL')}}/{{ $maildetails['lang'] }}/userlogin" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#3D5CA3">@lang('app.post_here') »</a></p></td>
                    </tr>
                  </table></td>
                <td class="es-hidden" style="padding:0;Margin:0;width:10px"></td>
              </tr>
            </table>
            
            <!--[if mso]></td><td style="width:30px" valign="top"><![endif]-->
            
            <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
              <tr class="es-hidden" style="border-collapse:collapse">
                <td class="es-m-p20b" align="left" style="padding:0;Margin:0;width:30px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;font-size:0"><img src="{{ asset('images/mail/47561527672335572.png') }}" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="30" height="200"></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            
            <!--[if mso]></td><td style="width:10px"></td><td style="width:255px" valign="top"><![endif]-->
            
            <table class="es-right" cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
              <tr style="border-collapse:collapse">
                <td align="left" style="padding:0;Margin:0;width:255px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-bottom:5px;padding-top:25px;font-size:0px"><a target="_blank" href="{{ env('APP_URL')}}/{{ $maildetails['lang'] }}/home" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#3D5CA3"><img src="{{ asset('images/mail/73891612253666668.png') }}" alt="@lang('app.buy_sell')" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" title="@lang('app.buy_sell')" width="39" height="39"></a></td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-top:5px;padding-bottom:5px"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;color:#333333">@lang('app.buy_sell')</h4></td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#333333"><span class="product-description">@lang('app.buyers_sellers')</span></p></td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-top:5px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#333333"><a target="_blank" href="{{ env('APP_URL')}}/{{ $maildetails['lang'] }}/home" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#3D5CA3">@lang('app.search_here') »</a></p></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            
            <!--[if mso]></td></tr></table><![endif]--></td>
        </tr>
        <tr style="border-collapse:collapse">
          <td align="left" style="Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;padding-bottom:30px"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
              <tr style="border-collapse:collapse">
                <td valign="top" align="center" style="padding:0;Margin:0;width:560px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0"><span class="es-button-border" style="border-style:solid;border-color:#3D5CA3;background:#FFFFFF;border-width:2px;display:inline-block;border-radius:4px;width:auto"> <a href="{{ env('APP_URL')}}/{{ $maildetails['lang'] }}/home" class="es-button" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:16px;color:#3D5CA3;border-style:solid;border-color:#FFFFFF;border-width:10px 15px 10px 15px;display:inline-block;background:#FFFFFF;border-radius:4px;font-weight:normal;font-style:normal;line-height:19px;width:auto;text-align:center">@lang('app.lets_get_started') »</a></span></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
@include('front.mail.footer')