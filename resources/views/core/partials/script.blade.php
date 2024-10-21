<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#faq1-btn").click(function() {
            $("#faq1-content").slideToggle();
            $(this).find("svg").toggleClass("rotate-180");
        });

        $("#faq2-btn").click(function() {
            $("#faq2-content").slideToggle();
            $(this).find("svg").toggleClass("rotate-180");
        });

        $("#faq3-btn").click(function() {
            $("#faq3-content").slideToggle();
            $(this).find("svg").toggleClass("rotate-180");
        });

        $("#faq4-btn").click(function() {
            $("#faq4-content").slideToggle();
            $(this).find("svg").toggleClass("rotate-180");
        });
    });
</script>
