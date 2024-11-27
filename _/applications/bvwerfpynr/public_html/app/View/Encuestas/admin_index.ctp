<div class="content-result">
    <div class="row">
        <div class="col-md-6">
            <h3>Encuesta</h3>
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col-md-12">
            <?php echo $this->Form->create('Encuesta',  array('novalidate' => true,'class'=>'row') );?>
            	<?php
		            echo $this->Form->input('Caso',array('class'=>'form-control','label'=>false,'placeholder'=>'Caso','style'=>'margin-top:25px','div'=>array('class'=>'col-sm-3')));	
		        ?>
            	<?php echo $this->Form->submit( 'Filtrar' , array('class'=>'btn btn-info pull-bottom','style'=>'margin-top:25px', 'div'=>array('class'=>'col-sm-2 ' ) ));?>
            <?php echo $this->Form->end();?>
            <br>
        </div>

        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="sorts">
                        <tr>
                            <th><?php echo $this->Paginator->sort('Donador'); ?></th>
                            <th><?php echo $this->Paginator->sort('Correo'); ?></th>
                            <th><?php echo $this->Paginator->sort('Fecha'); ?></th>
                            <th><?php echo $this->Paginator->sort('Caso'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($encuestas as $encuesta): ?>
                        <tr data-show="/admin/encuestas/view/<?php echo $encuesta['Encuesta']['id']?>">
                            <td><?php echo $encuesta['Aportacion']['nombre_donador']; ?></td>
                            <td><?php echo $encuesta['Aportacion']['mail_donador']?></td>
                            <td><?php echo $encuesta['Aportacion']['fecha']; ?></td>
                            <td><?php echo $encuesta['Aportacion']['Caso']['titulo']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <ul class="pagination">
                <?php
					echo $this->Paginator->prev('«', array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag'=>'a'));
					echo $this->Paginator->numbers(array('currentClass' => 'active', 'currentTag' => 'a', 'tag' => 'li', 'separator' => null));
					echo $this->Paginator->next('»', array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag'=>'a'));
					?>
            </ul>
            <div class="">
                    <?php echo $this->Paginator->counter(array('format' => __('Mostrando registros {:start} al {:end}, de {:count} totales'))); ?>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
$(function() {

    bindClickTd();
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        url = $(this).attr('href');
        getData(url);
        return false;
    });


    $(document).on('submit', 'form#EncuestaAdminIndexForm', function(event) {
        event.preventDefault();
        theurl = '<?php echo $this->Html->url(array("admin"=>true,"controller"=>"encuestas","action"=>"index")) ?>';
        getData(theurl);
    })

    function getData(url) {
        var caso = $('#EncuestaCaso').val();
		
        $.ajax({
            cache: false,
            type: "POST",
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url: url,
            data: {
                caso: caso,
            },
            success: function(data) {
                $('.content-result').html(data);
            },
            error: function(data) {
                //alert('error');
            }
        });
    }
})

function bindClickTd() {
    $("tbody").on('click', 'td', function(e) {
        if (!$(this).hasClass('actions')) {
            window.location.href = $(this).parent().data('show');
        }
    });
}
</script>