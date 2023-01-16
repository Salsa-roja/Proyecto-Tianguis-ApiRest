<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <style>
            body {
                font-family:'Open Sans',Helvetica,Arial,sans-serif!important;
                font-size: 13px;
            }
            .body-p{
                font-size:14px;
                color:#222222;
                line-height:1.6;
                margin:16px 0
            }
            .b-box{
                box-sizing:border-box
            }
            .w-100{
                width:100%;
            }
            .p-0{
                padding:0;
            }
            .t-center{
                text-align:center
            }
            .b-0{
                border:0;
            }
            .p-footer{
                font-family:'Open Sans',Helvetica,Arial,sans-serif!important;
                font-size:10px;
                color:#a7a7a7;
                line-height:1.6;
                text-align:center;
            }
            #footer{
               background: url('{{env("APP_URL")}}/assets/img/mail/pleca_gris_final.svg') no-repeat 0 0;
               background-position: center;
               height: 250px;
               margin-top: 15px;
               padding-top: 10px;
               padding-bottom: 0px;
            }
            #td_img_footer{
            }
            #footer_img{
               width: 150px;
               margin-top: 15px;
            }
        </style>
    </head>
    <body>
        <div style="margin:0;padding:0;background:#f4f4f4">
            <center>
                <table class="b-0" align="center" cellpadding="0" cellspacing="0" height="100%" width="100%" bgcolor="#f4f4f4">
                    <tbody>
                        <tr>
                            <td align="center" valign="top">
                                <table  class="w-100 b-0" cellpadding="0" cellspacing="0" valign="top"
                                        style="max-width:580px">
                                    <tbody>
                                        <tr>
                                            <td align="center">
                                                <p class="body-p" style="text-align:center">
                                                    <a style="font-size:inherit;color:#ffa200;text-decoration:none;margin:16px 0;display:block"
                                                        href="{{env('APP_PROD_URL')}}"
                                                        rel="noopener nofollow" target="_blank"
                                                        data-saferedirecturl="https://www.google.com/url?q={{env('APP_PROD_URL')}}&amp;source=mail">
                                                        <img  src="{{env('APP_URL')}}/assets/img/mail/desarrollo_economico.png"
                                                                style="max-width:100%;border:0;width:150px" alt="Logo.png">
                                                    </a>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="margin-top:16px">
                                            <td>
                                                <div class="b-box w-100 p-0">
                                                <div class="b-box w-100" style="padding:16px 32px;background:#fff;border-radius:8px">
                                                    <h3>{{isset($titulo)? $titulo : 'Notificación Automática'}}</h3>