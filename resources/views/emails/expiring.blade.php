<html>
<head>
<meta charset="utf-8">
<title></title>
</head>
<body style="font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color:#f0f2ea; margin:0; padding:0; color:#6d6969;">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tbody>
      <tr>
          <td style="padding:40px 0;">
              <table cellpadding="0" cellspacing="0" width="608" border="0" align="center">
                  <tbody>
                      <tr align="center">
                          <td>
                            <a href="" style="display:block; width:587px; height:122px; margin:0 auto 30px;">
                                <img src="{{asset('/images/logo.png')}}" width="400" height="200" alt="YH IT Solution Sdn. Bhd." style="display:block; border:0; margin:0;">
                            </a>
                              <br><br><br>
                                <p style="margin:0 0 36px; text-align:center; font-size:16px; line-height:22px; text-transform:uppercase; color:#626658;">
                                    FKILibrary Expiring Notice [{{$exp->name}}]
                                </p>
                                <p style="margin:0 0 36px; text-align:center; font-size:16px; line-height:22px; color:#626658;">
                                </p>
                                    <table>
                                      <tr>
                                        <td>Book Title : </td>
                                        <td style="font-weight: bold">{{$exp->bookName}}</td>
                                      </tr>
                                      <tr>
                                        <td>End Date : </td>
                                        <td style="font-weight: bold">{{$exp->end_date}}</td>
                                      </tr>
                                      <tr> <h4>Please Renew or Return Before {{$exp->end_date}}</h4></tr>
                                    </table>

                                <p style="margin:0; padding:34px 0 0; text-align:center; font-size:12px; line-height:13px; color:#333333;">
                                    Copyright © {{date('Y')}} FKI Library
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
</body>
</html>
