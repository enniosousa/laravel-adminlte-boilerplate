<!-- Datatables -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/af-2.3.7/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/cr-1.5.4/date-1.1.0/fc-3.3.3/fh-3.1.9/kt-2.6.2/r-2.2.9/rg-1.1.3/rr-1.2.8/sc-2.0.4/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.js"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script>
$.extend(true, $.fn.dataTable.render, {
    cpf: function (data, type, full, meta) {
        if(!data){
            return data;
        }

        var cpf = data.replace(/[^\d]/g, "");

        if(cpf.length === 11){
            return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
        }
        else{
            return data;
        }
    },
    date: function (data, type, full, meta) {
        var date = new Date(data);
        if (date.toString() !== 'Invalid Date') {
            return date.toLocaleString({
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
            });
        }
        else {
            return data;
        }
    },
    datetime: function (data, type, full, meta) {
        if (
            // null
            data === null
            // empty string
            || (typeof data === 'string' && data.trim() === "")
            // zero
            || data === 0
        ) {
            return "";
        }
        var date = new Date(data);
        if (date.toString() !== 'Invalid Date') {
            return date.toLocaleString();
        }
        else {
            return data;
        }
    },
});
</script>