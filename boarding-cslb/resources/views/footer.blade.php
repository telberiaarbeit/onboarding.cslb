

    </body>
</html>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous"></script>
<script type="text/javascript">
    jQuery(document).ready(function($){
        if($('#checklist-page')) {
            $( ".datetimepicker" ).datetimepicker({
                format: 'L',
                locale: 'ru'
            });
            $(document).on('click','.datetimepicker',function(){
                $(this).closest('.wrap-datetimepicker').addClass('show-name');
            })
            $(document).on('click','input[type="checkbox"]',function(){
                $(this).closest('.group-item').css({'pointer-events':'none','opacity':'0.8'});
            });
        }
    })
</script>
