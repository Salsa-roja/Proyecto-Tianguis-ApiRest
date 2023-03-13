@include('mail.template.head',['titulo'=>$data['params']['titulo']])

<p class="body-p">
   Hola {{$data['params']['to_name']}}
</p>

{!! $data['params']['cuerpo'] !!}


<p class="body-p"> - Equipo de soporte <br> quierochamba.com</p>

@include('mail.template.footer')
