<?php

class PersonalEmail{
    public function personalEmailContent($title, $content, $fullname = ''){
    	
        $string = '
	<!DOCTYPE>
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--[if !mso]><!-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!--<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <title></title>
        <style type="text/css">
        body {
            Margin: 0;
            padding: 0;
            min-width: 100%;
            /*mso-line-height-rule: exactly;*/
        }
        table {
            border-spacing: 0;
            color: #333333;
        }
        img {
            border: 0;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
        }
        .webkit {
            max-width: 85%;
        }
        .outer {
            Margin: 0 auto;
            width: 100%;
            max-width: 85%;
        }
        .full-width-image img {
            width: 100%;
            max-width: 85%;
            height: auto;
        }
        .inner {
            padding: 10px;
        }
    
        .h1 {
            font-size: 21px;
            font-weight: bold;
            Margin-top: 15px;
            Margin-bottom: 5px;
            font-family: Verdana, Geneva, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .h2 {
            font-size: 18px;
            font-weight: bold;
            Margin-top: 10px;
            Margin-bottom: 5px;
            font-family: Verdana, Geneva, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .one-column .contents {
            text-align: left;
            font-family: Verdana, Geneva, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .one-column p {
	      margin: 0;
	      padding-bottom: 20px;
	      color: #4c4c4c;
	      font-weight: 400;
	      font-size: 16px;
	      line-height: 1.3;
	      margin-block-start: 1em;
	      margin-block-end: 1em;
	      margin-inline-start: 0px;
	      margin-inline-end: 0px;
	      text-align: justify;
	      font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;
		}
        .two-column {
            text-align: center;
            font-size: 0;
        }
        .two-column .column {
            width: 100%;
            max-width: 300px;
            display: inline-block;
            vertical-align: top;
        }
        .contents {
            width: 100%;
        }
        .two-column .contents {
            font-size: 14px;
            text-align: left;
        }
        .two-column img {
            width: 100%;
            max-width: 280px;
            height: auto;
        }
        .two-column .text {
            padding-top: 10px;
        }
        .three-column {
            text-align: center;
            font-size: 0;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        .three-column .column {
            width: 100%;
            max-width: 200px;
            display: inline-block;
            vertical-align: top;
        }
        .three-column .contents {
            font-size: 14px;
            text-align: center;
        }
        .three-column img {
            width: 100%;
            max-width: 180px;
            height: auto;
        }
        .three-column .text {
            padding-top: 10px;
        }
        .img-align-vertical img {
            display: inline-block;
            vertical-align: middle;
        }
    
      a {
        text-decoration:none;
        color: #db4c3f;
      }

      .grayscale { filter: grayscale(100%); }
        </style>

        </head>

        <body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#EDF0F3;">
        <center class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#EDF0F3;">
          <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#EDF0F3;" bgcolor="#EDF0F3;">
            <tr>
              <td width="100%"><table class="webkit" style="max-width:600px;Margin:0 auto;"> 
                  
                  
                  <!-- ======= start main body ======= -->
                  <table class="outer" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0;Margin:0 auto;width:100%;max-width:85%;">
                    <tr>
                      <td style="padding-top:0;padding-bottom:0;padding-right:0; padding-left:0;"><!-- ======= start header ======= -->
                        
                        <table border="0" width="100%" cellpadding="0" cellspacing="0" >
                          <tr>
                            <td><table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
                                <tbody>
                                  <tr>
                                    <td align="center"><center>
                                        <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" style="Margin: 0 auto;">
                                          <tbody>
                                            <tr>
                                              <td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0">
                                                  
                                                  <tr>
                                                    <td height="65" bgcolor="#F6F8FA" class="contents" style="width:100%; border-bottom: 1px solid #E1E1E1;">
                                                  <table style="width:100%">
                                                    <tr>
                                                      <td align ="left" style="padding:10px">
                                                        <a href="www.affiliatesgroup.net" target="_blank">
                                                          <img src="https://giftcornerng.com/admin/assets/media/logos/gift-corner-ng-logo.png" style="border-width:0; display:block; width: 50px; height: 34px" /></a>
                                                      </td>
                                                      <td align="right" style="padding:10px; color: rgb(76,76,76);     font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif; font-weight: 400; font-size: 14px; line-height: 1.429;">'.$fullname.'</td>
                                                      
                                                    </tr>
                                                  </table>
                                                </td>
                                                  </tr>
                                                </table></td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </center></td>
                                  </tr>
                                </tbody>
                              </table></td>
                          </tr>
                        </table>
                        
                        <!-- ======= end header ======= --> 

                        
                        <!-- ======= start hero article ======= -->
                        
                        <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0;" bgcolor="#FFFFFF">
                          <tr>
                            <td align="left" style="padding:10px 20px 40px 20px"><h2 style="color:##262626; text-align:left; font-family: Arial, Helvetica, sans-serif; font-weight: 700; font-size: 20px; line-height: 1.2;">'. $title .'</h2>

                              '. $content .'
                            </td>
                          </tr>
                        </table>
                        
                        <!-- ======= end hero article ======= --> 
                        
                         <!-- ======= start footer ======= -->
                        
                       <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:auto">
          <tr>
            <td><table width="100%" cellpadding="0" cellspacing="0" border="0"  bgcolor="#EDF0F3">
          <tr>
                <td height="20" align="center" bgcolor="#EDF0F3" class="one-column">&nbsp;</td>
              </tr>
              ';
              if($fullname) { 
                  $string .='
              <tr>
                <td align="center" bgcolor="#EDF0F3" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px; color: rgb(106,108,109); font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.333; text-align:center">This email was intended for '.$fullname.'.
              <p style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px; margin: 0px; color: rgb(106,108,109); font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.333; text-align:center"><a href="#" style="color: #6a6c6d; text-decoration: underline; display: inline-block;">Learn why we included this.</a></p>
            </td>
              </tr>
              <tr>
                <td height="5" align="center" bgcolor="#EDF0F3" class="one-column">&nbsp;</td>
              </tr>'; 
                }
              $string .='
              <tr>
                <td align="center" bgcolor="#EDF0F3" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px; color: #6a6c6d; font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif; font-weight: 400; font-size: 12px; line-height: 1.333; text-align:center">&copy; '.date("Y").' Giftcorner NG.</td>
              </tr>
              <tr>
                <td height="6" bgcolor="#EDF0F3" class="contents1" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
              </tr>
              </table></td>
          </tr>
        </table>

                       <!-- ======= end footer ======= --></td>
                    </tr>
                  </table>
                  <!--[if (gte mso 9)|(IE)]>
                            </td>
                        </tr>
                    </table>
                    <![endif]--> 
                </div></td>
            </tr>
          </table>
        </center>
        </body>
        </html>';

        return $string;
    }
}