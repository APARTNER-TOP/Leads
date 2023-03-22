<script src="//ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

@if(request()->routeIs('dashboard') || request()->routeIs('leads.lead1') || request()->routeIs('leads.lead2'))

<!-- datepicker -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('#lead1_date_container input').datepicker({
        format: 'mm/dd/yyyy',
        startDate: '-0d'
    });

    $('#lead2_date_container input').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '-0d'
    });
</script>

<!-- datetimepicker -->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"/>
<script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript">
    $(function () {
        dataTimePicker();

        $('#datetimepicker').on('click', function () {
            dataTimePicker();
        });
    });

    function dataTimePicker() {
        const now = new Date();
        const currentHours = now.getHours();
        const currentMinutes = now.getMinutes();
        const currentTime = currentHours + ':' + currentMinutes;

        $('#datetimepicker').datetimepicker({
            format: 'Y-m-d H:i',
            minDate: 0,
            minTime: currentTime,
            step: 1,
        });
    }
</script>

@endif
