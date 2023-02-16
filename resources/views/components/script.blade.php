<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

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
