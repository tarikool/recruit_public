<script type="text/javascript">
    $(document).ready(function () {
        "use strict";
        var is_touch_device = 'ontouchstart' in document.documentElement;

        if (!is_touch_device) {
            $('[data-toggle="tooltip"]').tooltip();
        }

    });
</script>
