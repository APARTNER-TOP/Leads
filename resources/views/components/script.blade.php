<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>


@if(request()->routeIs('dashboard'))
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('#date-container input').datepicker({
        format: 'mm/dd/yyyy',
        // startDate: '-0d'
    });
</script>
@endif

<script>
    if($('.copyright .link').attr('href') != 'https://apartner.pro' || $('.copyright .link').is(':hidden') || $('.copyright .link').css('opacity') == 0 || $('.copyright').is(':hidden') || $('.copyright').css('opacity') == 0) {
        $('.copyright').remove();

        $('body').append(`
            <div class="copyright">
                <a href="https://apartner.pro" title="Development of sites on laravel, prestashop, wordpress and their support" class="link" target="_blank" rel="dofollow">
                        APARTNER.PRO
                    <strong class="description">Development of sites on Laravel, PrestaShop, Wordpress and their support</strong>
                </a>
            </div>
        `);
    }
</script>
