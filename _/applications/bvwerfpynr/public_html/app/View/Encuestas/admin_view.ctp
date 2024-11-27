<div class="row">
    <div class="col-md-9">
        <ol class="breadcrumb btn btn-default btn-rounded btn-outline" style="margin-top:10px;">
            <li class="active"><a href="/admin/encuestas">Encuestas</a></li>
        </ol>

        <h3 class="m-b-0" style="display:inline-block">
            <?php echo $encuesta['Aportacion']['Caso']['titulo']?> -
            <?php echo $encuesta['Aportacion']['Caso']['nombre']; ?>
        </h3>
    </div>
    <div class="col-md-12">
        <hr>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="white-box">

            <div class="row">
                <div class="col-md-12">

                    <div class="row text-center m-t-10">
                        <div class="col-md-6 b-r">
                            <strong>Caso</strong>
                            <p><?php echo $encuesta['Aportacion']['Caso']['titulo']?></p>
                        </div>

                        <div class="col-md-6">
                            <strong>Fecha</strong>
                            <p><?php echo $encuesta['Encuesta']['created'] ?></p>
                        </div>
                    </div>
                    <hr>

                    <div class="col-md-4 text-center">
                        <div class="col-md-4 b-r">
                            <strong><?php echo $encuesta['Pregunta_Encuesta'][0]['Pregunta']['pregunta'] ?></strong>
                            <div id="califica1" class="star-rating">
                                <span id="rating1" class="fa fa-star-o" data-rating="1"></span>
                                <span id="rating2" class="fa fa-star-o" data-rating="2"></span>
                                <span id="rating3" class="fa fa-star-o" data-rating="3"></span>
                                <span id="rating4" class="fa fa-star-o" data-rating="4"></span>
                                <span id="rating5" class="fa fa-star-o" data-rating="5"></span>
                                <input id="inputCalifica" type="hidden" name="whatever1" class="rating-value"
                                    value="<?php echo $encuesta['Pregunta_Encuesta'][0]['respuesta_numero']?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 b-r b-l">
                        <strong><?php echo $encuesta['Pregunta_Encuesta'][1]['Pregunta']['pregunta'] ?></strong>
                        <div id="califica2" class="star-rating">
                            <span id="rating1" class="fa fa-star-o" data-rating="1"></span>
                            <span id="rating2" class="fa fa-star-o" data-rating="2"></span>
                            <span id="rating3" class="fa fa-star-o" data-rating="3"></span>
                            <span id="rating4" class="fa fa-star-o" data-rating="4"></span>
                            <span id="rating5" class="fa fa-star-o" data-rating="5"></span>
                            <input id="inputCalifica" type="hidden" name="whatever1" class="rating-value"
                                value="<?php echo $encuesta['Pregunta_Encuesta'][1]['respuesta_numero']?>">
                        </div>
                    </div>

                    <div class="col-md-4 ">
                        <strong><?php echo $encuesta['Pregunta_Encuesta'][2]['Pregunta']['pregunta'] ?> </strong>
                        <div id="califica3" class="star-rating">
                            <span id="rating1" class="fa fa-star-o" data-rating="1"></span>
                            <span id="rating2" class="fa fa-star-o" data-rating="2"></span>
                            <span id="rating3" class="fa fa-star-o" data-rating="3"></span>
                            <span id="rating4" class="fa fa-star-o" data-rating="4"></span>
                            <span id="rating5" class="fa fa-star-o" data-rating="5"></span>

                            <input id="inputCalifica" type="hidden" name="whatever1" class="rating-value"
                                value="<?php echo $encuesta['Pregunta_Encuesta'][2]['respuesta_numero'] ?>">
                        </div>
                    </div>
                </div>
                <hr>
                <hr>

                <div class="row col-md-12 text-center m-t-10">
                    <div class="col-md-6 b-r">
                        <strong><?php echo $encuesta['Pregunta_Encuesta'][3]['Pregunta']['pregunta'] ?></strong>
                        <p>
                            <?php if($encuesta['Pregunta_Encuesta'][3]['respuesta_numero']){ ?>
                            Si
                            <?php }else{ ?>
                            no
                            <?php } ?>
                        </p>
                    </div>

                    <div class="col-md-6">
                        <strong><?php echo $encuesta['Pregunta_Encuesta'][4]['Pregunta']['pregunta'] ?></strong>
                        <p>
                            <?php if($encuesta['Pregunta_Encuesta'][4]['respuesta_numero']){ ?>
                            Si
                            <?php }else{ ?>
                            no
                            <?php } ?>
                        </p>
                    </div>
                </div>
                <hr>

                <div class="row col-md-12 text-center m-t-10">
                    <div class="col-md-12">
                        <strong><?php echo $encuesta['Pregunta_Encuesta'][5]['Pregunta']['pregunta'] ?></strong>
                        <p><?php echo $encuesta['Pregunta_Encuesta'][5]['respuesta_text'] ?></p>
                    </div>
                </div>
                <hr>

            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
$(function() {

    var star_rating = $('#califica1 .fa');
    var SetRatingStar = function() {
        return star_rating.each(function() {
            if (parseInt(star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data(
                    'rating'))) {
                return $(this).removeClass('fa-star-o').addClass('fa-star');
            } else {
                return $(this).removeClass('fa-star').addClass('fa-star-o');
            }
        });
    };
    star_rating.on('click', function() {
        star_rating.siblings('input.rating-value').val($(this).data('rating'));
        return SetRatingStar();
    });
    SetRatingStar();

    var star_rating2 = $('#califica2 .fa');
    var SetRatingStar2 = function() {
        return star_rating2.each(function() {
            if (parseInt(star_rating2.siblings('input.rating-value').val()) >= parseInt($(this)
                    .data(
                        'rating'))) {
                return $(this).removeClass('fa-star-o').addClass('fa-star');
            } else {
                return $(this).removeClass('fa-star').addClass('fa-star-o');
            }
        });
    };
    star_rating2.on('click', function() {
        star_rating2.siblings('input.rating-value').val($(this).data('rating'));
        return SetRatingStar2();
    });
    SetRatingStar2();

    var star_rating3 = $('#califica3 .fa');
    var SetRatingStar3 = function() {
        return star_rating3.each(function() {
            if (parseInt(star_rating3.siblings('input.rating-value').val()) >= parseInt($(this)
                    .data(
                        'rating'))) {
                return $(this).removeClass('fa-star-o').addClass('fa-star');
            } else {
                return $(this).removeClass('fa-star').addClass('fa-star-o');
            }
        });
    };
    star_rating3.on('click', function() {
        star_rating3.siblings('input.rating-value').val($(this).data('rating'));
        return SetRatingStar3();
    });
    SetRatingStar3();

})
</script>