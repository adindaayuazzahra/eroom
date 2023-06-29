{{-- @extends('index')
@section('bottom-asset') --}}
<!------------------------------------ JS ---------------->
<!-- jQuery JS -->
{{-- <script src="{{ asset('assets/js/vendor/jquery-1.12.4.min.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.2/datatables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.3.2/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>

{{-- button print datatables --}}
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" />

<script src="https://kit.fontawesome.com/82ef5747eb.js" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.4/dayjs.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#table_id').DataTable({
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'print'
            ]
            // fixedColumns: true
            // columnDefs: [{
            //     width: 500,
            //     targets: 0
            // }],
            // ordering: false
        });

       

    });




    // $(document).ready(function() {
    //     $('#table_id').DataTable({
    //         ordering: false,
    //     });

    // });

    // $('[data-toggle="buttons"] .btn').on('click', function() {
    //     // toggle style
    //     $(this).toggleClass('btn-success btn-danger active');

    //     // toggle checkbox
    //     var $chk = $(this).find('[type=checkbox]');
    //     $chk.prop('checked', !$chk.prop('checked'));

    //     return false;
    // });

    // $('form').on('submit', function(e) {
    //     // watch form values
    //     $('#formValues').html(($('form').serialize()));
    //     e.preventDefault();
    // });
</script>
{{-- <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script> --}}
{{-- <script type="text/javascript">
    var stepper1
    // var stepper2
    // var stepper3
    // var stepper4
    var stepperForm

    document.addEventListener('DOMContentLoaded', function() {
        stepper1 = new Stepper(document.querySelector('#stepper1'))
        // stepper2 = new Stepper(document.querySelector('#stepper2'), {
        //     linear: false
        // })
        // stepper3 = new Stepper(document.querySelector('#stepper3'), {
        //     linear: false,
        //     animation: true
        // })
        // stepper4 = new Stepper(document.querySelector('#stepper4'))

        var stepperFormEl = document.querySelector('#stepperForm')
        stepperForm = new Stepper(stepperFormEl, {
            animation: true
        })

        var btnNextList = [].slice.call(document.querySelectorAll('.btn-next-form'))
        var stepperPanList = [].slice.call(stepperFormEl.querySelectorAll('.bs-stepper-pane'))
        var inputMailForm = document.getElementById('inputMailForm')
        var inputPasswordForm = document.getElementById('inputPasswordForm')
        var form = stepperFormEl.querySelector('.bs-stepper-content form')

        btnNextList.forEach(function(btn) {
            btn.addEventListener('click', function() {
                stepperForm.next()
            })
        })

        stepperFormEl.addEventListener('show.bs-stepper', function(event) {
            form.classList.remove('was-validated')
            var nextStep = event.detail.indexStep
            var currentStep = nextStep

            if (currentStep > 0) {
                currentStep--
            }

            var stepperPan = stepperPanList[currentStep]

            if ((stepperPan.getAttribute('id') === 'test-form-1' && !inputMailForm.value.length) ||
                (stepperPan.getAttribute('id') === 'test-form-2' && !inputPasswordForm.value.length)) {
                event.preventDefault()
                form.classList.add('was-validated')
            }
        })
    })
</script> --}}

{{-- @endsection --}}
