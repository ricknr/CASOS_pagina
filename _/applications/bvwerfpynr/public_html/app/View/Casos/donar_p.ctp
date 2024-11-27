
<div class="recent-cause-details">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 style="margin-top:90px;color:#4d4d4d">PASO 2 DE 2</h4>
                <h3 style="margin-top:30px;color:#4d4d4d">Detalle</h3>
            </div>

            <div class="col-md-12">
                <?php echo $this->Session->flash();?>
            </div>
        </div>

        <div style="display:none;" class="row pay">
            <div class="col-md-12">
                <br>
                <h4>Paypal</h4>
                <form style="display:block;" id="realizarPago" action="https://www.paypal.com/cgi-bin/webscr"
                    method="post">
                    <input name="cmd" type="" value="_cart" />
                    <input name="upload" type="" value="1" />
                    <input name="business" type="" value="paypal@caritas.org.mx" />
                    <input name="shopping_url" type="" value="" />
                    <input name="currency_code" type="" value="MXN" />
                    <input name="return" type=""
                    value="https://<?php echo $_SERVER['HTTP_HOST']?>/respuestapay/<?php echo $aportacion['Aportacion']['id'] ?>"/>
                    <input name="notify_url" type="" value="https://<?php echo $_SERVER['HTTP_HOST']?>/respuestapay/<?php echo $aportacion['Aportacion']['id'] ?>" />

                    <input name="rm" type="" value="2" />
                    <input name="item_number_1" type="" value="<?php echo date('ymdHis'); ?>" />
                    <input name="item_name_1" type=""
                        value="<?php echo 'Donacion a ' . $aportacion['Caso']['titulo']?>" />
                    <input name="amount_1" type="" value="<?php echo $aportacion['Aportacion']['importe'] ?>" />
                    <input name="quantity_1" type="" value="1" />

                    <div class="col-md-3">
                        <br>
                        <button id="btn_paypal" type="submit" class="tran3s ch-p-bg-color">Donar</button>

                    </div>

                </form>
                <script>
                $(document).ready(function() {
                        $("#realizarPago").submit();
                    $(document).on('click', '#btn_paypal', function() {

                        console.log('paypal');
                    });
                });
                </script>
            </div>
        </div>


        <br><br><br><br><br><br>
    </div>
</div> <!-- /.container -->
</div> <!-- /.recent-cause-details -->

<script type="text/javascript">
$(function() {

    $(document).on('click', '#credit-card', function(){
        console.log('tarjeta');
        $('#credit-card').css('filter', 'brightness(1.2)');
        $('#credit-card').css('filter', 'grayscale(.5)');
        $('#credit-card').css('filter', 'opacity(.9);');

        $('#paypal').css('filter', 'brightness(1.8)');
        $('#paypal').css('filter', 'grayscale(1)');
        $('#paypal').css('filter', 'opacity(.7);');

        $('.credit').css('display', 'block');
        $('.pay').css('display', 'none');
    });

    $(document).on('click', '#paypal', function(){
        console.log('paypal');
        $('#paypal').css('filter', 'brightness(1.2)');
        $('#paypal').css('filter', 'grayscale(.5)');
        $('#paypal').css('filter', 'opacity(.9);');

        $('#credit-card').css('filter', 'brightness(1.8)');
        $('#credit-card').css('filter', 'grayscale(1)');
        $('#credit-card').css('filter', 'opacity(.7);');

        $('.pay').css('display', 'block');
        $('.credit').css('display', 'none');
    });

    $('#form_donar').submit(function() {
        var fecha_vencimiento = $('#mes').val() + $('#anio').val();
        $('#fecha_vencimiento').val(fecha_vencimiento);
    })
})
</script>