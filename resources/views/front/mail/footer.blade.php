<table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
  <tr style="border-collapse:collapse">
    <td align="center" style="padding:0;Margin:0"><table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
        <tr style="border-collapse:collapse">
          <td style="Margin:0;padding-left:10px;padding-right:10px;padding-top:15px;padding-bottom:15px;background-color:#F7C052" bgcolor="#f7c052" align="left"><!--[if mso]><table style="width:580px" cellpadding="0" cellspacing="0"><tr><td style="width:200px" valign="top"><![endif]-->
            
            <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
              <tr style="border-collapse:collapse">
                <td class="es-m-p0r es-m-p20b" align="center" style="padding:0;Margin:0;width:180px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-bottom:5px;font-size:0"><a target="_blank" href="{{ env('APP_URL')}}/{{ $maildetails['lang'] }}/home" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#3D5CA3"><img src="{{ asset('images/mail/39911527588288171.png') }}" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="24" height="24"></a></td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-left:5px;padding-right:5px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:24px;color:#FFFFFF">{{ $settingsDetail->contact_address }}</p></td>
                    </tr>
                  </table></td>
                <td class="es-hidden" style="padding:0;Margin:0;width:20px"></td>
              </tr>
            </table>
            
            <!--[if mso]></td><td style="width:180px" valign="top"><![endif]-->
            
            <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
              <tr style="border-collapse:collapse">
                <td class="es-m-p20b" align="center" style="padding:0;Margin:0;width:180px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-bottom:5px;font-size:0"><img src="{{ asset('images/mail/35681527588356492.png') }}" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="24" height="24"></td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td esdev-links-color="#ffffff" align="center" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#FFFFFF"><a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:18px;text-decoration:underline;color:#FFFFFF" href="mailto:{{ $settingsDetail->contact_email }}">{{ $settingsDetail->contact_email }}</a></p></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            
            <!--[if mso]></td><td style="width:20px"></td>
<td style="width:180px" valign="top"><![endif]-->
            
            <table class="es-right" cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
              <tr style="border-collapse:collapse">
                <td align="center" style="padding:0;Margin:0;width:180px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-bottom:5px;font-size:0"><img src="{{ asset('images/mail/50681527588357616.png') }}" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="24" height="24"></td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:24px;color:#FFFFFF"><a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:16px;text-decoration:underline;color:#FFFFFF" href="tel:{{ $settingsDetail->contact_mobile }}">{{ $settingsDetail->contact_mobile }}</a></p></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            
            <!--[if mso]></td></tr></table><![endif]--></td>
        </tr>
      </table></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" class="es-footer" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
  <tr style="border-collapse:collapse">
    <td align="center" style="padding:0;Margin:0"><table class="es-footer-body" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px">
        <tr style="border-collapse:collapse">
          <td align="left" style="padding:0;Margin:0;padding-left:10px;padding-right:10px;padding-top:20px"><!--[if mso]><table style="width:580px" cellpadding="0" cellspacing="0"><tr><td style="width:190px" valign="top"><![endif]-->
            
            <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
              <tr style="border-collapse:collapse">
                <td class="es-m-p0r es-m-p20b" valign="top" align="center" style="padding:0;Margin:0;width:190px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tr style="border-collapse:collapse">
                      <td class="es-m-txt-c" esdev-links-color="#666666" align="right" style="padding:0;Margin:0;padding-top:5px"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;color:#666666">@lang('app.follow_us'):</h4></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            
            <!--[if mso]></td><td style="width:20px"></td><td style="width:370px" valign="top"><![endif]-->
            
            <table cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
              <tr style="border-collapse:collapse">
                <td align="left" style="padding:0;Margin:0;width:370px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tr style="border-collapse:collapse">
                      <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;font-size:0"><table class="es-table-not-adapt es-social" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                          <tr style="border-collapse:collapse">
							  @if($settingsDetail->facebook_url)
                            <td valign="top" align="center" style="padding:0;Margin:0;padding-right:15px"><a target="_blank" href="{{ $settingsDetail->facebook_url }}" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:12px;text-decoration:underline;color:#666666"> <img title="Facebook" src="{{ asset('images/mail/facebook-rounded-gray.png') }}" alt="Fb" width="32" height="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td>
							  @endif
							  @if($settingsDetail->twitter_url)
                            <td valign="top" align="center" style="padding:0;Margin:0;padding-right:15px"><a target="_blank" href="{{ $settingsDetail->twitter_url }}" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:12px;text-decoration:underline;color:#666666"><img title="Twitter" src="{{ asset('images/mail/twitter-rounded-gray.png') }}" alt="Tw" width="32" height="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td>
							  @endif
							  @if($settingsDetail->instagram_url)
                            <td valign="top" align="center" style="padding:0;Margin:0"><a target="_blank" href="{{ $settingsDetail->instagram_url }}" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:12px;text-decoration:underline;color:#666666"><img title="Instagram" src="{{ asset('images/mail/instagram-rounded-gray.png') }}" alt="Inst" width="32" height="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td>
							  @endif
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            
            <!--[if mso]></td></tr></table><![endif]--></td>
        </tr>
        <tr style="border-collapse:collapse">
          <td align="left" style="Margin:0;padding-top:5px;padding-bottom:10px;padding-left:10px;padding-right:10px"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
              <tr style="border-collapse:collapse">
                <td valign="top" align="center" style="padding:0;Margin:0;width:580px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0;padding-top:5px;padding-bottom:10px"><h5 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;color:#666666">@lang('app.contact_us'): <a target="_blank" href="tel:{{ $settingsDetail->contact_mobile }}" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:12px;text-decoration:underline;color:#666666">{{ $settingsDetail->contact_mobile }}</a> |&nbsp;<a target="_blank" href="mailto:{{ $settingsDetail->contact_email }}" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:12px;text-decoration:underline;color:#666666">{{ $settingsDetail->contact_email }}</a></h5></td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td align="center" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:12px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:18px;color:#666666">@lang('app.footer_line1')</p>
                        <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:12px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:18px;color:#666666">@lang('app.footer_line2') <a target="_blank" class="unsubscribe" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:12px;text-decoration:underline;color:#666666">@lang('app.unsubscribe_here')</a>.</p></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</td>
</tr>
</table>
</div>
</body></html>