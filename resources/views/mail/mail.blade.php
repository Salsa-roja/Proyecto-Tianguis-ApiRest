@include('mail.template.head',['titulo'=>$data['params']['titulo']])

<p class="body-p">
   Hola {{$data['params']['to_name']}}
</p>
<p class="body-p">
   {{$data['params']['cuerpo']}}
</p>
{{-- <p class="body-p t-center">
   <a style="border:0;border-radius:25px;background:#ffa200;display:inline-block;color:#fff;font-weight:700;padding:12px 18px;line-height:1;letter-spacing:-0.5px;font-size:14px;text-decoration:none;text-transform:capitalize"
      href="https://quierochamba.com"
      target="_blank"
      data-saferedirecturl="https://www.google.com/url?q=https://quierochamba.com&amp;source=gmail">
      Confirmar Correo
   </a>
</p> --}}
<p class="body-p"> - Equipo de soporte <br> quierochamba.com</p>

@include('mail.template.footer')
