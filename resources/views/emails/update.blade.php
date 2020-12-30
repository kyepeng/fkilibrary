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
                                <img src="{{asset('/images/logo.png')}}" width="400" height="200" alt="FKI Library" style="display:block; border:0; margin:0;">
                            </a>
                              <br><br><br>
                                <p style="margin:0 0 36px; text-align:center; font-size:16px; line-height:22px; text-transform:uppercase; color:#626658;">
                                    FKILibrary Book {{$type}} Statement
                                </p>
                                <p style="margin:0 0 36px; text-align:center; font-size:16px; line-height:22px; color:#626658;">
                                </p>
                                    <table>
                                      <tr> 
                                        <td>Student :</td>
                                        <td style="font-weight: bold">{{$detail->name}}</td>
                                      </tr>
                                      <tr> 
                                        <td>Matric No :</td>
                                        <td style="font-weight: bold">{{$detail->matric}}</td>
                                      </tr>
                                      <tr>
                                        <td>Book Title : </td>
                                        <td style="font-weight: bold">{{$detail->bookName}}</td>
                                      </tr>
                                      <tr>
                                        <td>Book ISBN : </td>
                                        <td style="font-weight: bold">{{$detail->ISBN}}</td>
                                      </tr>
                                      <tr>
                                        <td>Borrow Date : </td>
                                        <td style="font-weight: bold">{{$detail->start_date}}</td>
                                      </tr>
                                      <tr>
                                        <td>Return Date : </td>
                                        <td style="font-weight: bold">{{$detail->end_date}}</td>
                                      </tr>
                                      @if($fine && $fine->fine > 0)
                                      <tr>
                                        <td>Fine Amount: </td>
                                        <td style="font-weight: bold">{{$fine->fine}}</td>
                                      </tr>
                                      @endif
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
