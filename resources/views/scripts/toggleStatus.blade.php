<script>
    $(document).ready(function () {
        "use strict";
        $('.switch').on('click', function () {
            $(this).toggleClass('checked');
            $('input[name="status"]').not(':checked').prop("checked", true);
        });
    });
</script>
