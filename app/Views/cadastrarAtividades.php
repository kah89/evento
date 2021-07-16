<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">

<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

<style>
    h2 {
        color: #007BFF;
    }

    #cad {
        width: 200px;
        background-color: #008CBA;
        font-size: 12px;
        padding: 12px 28px;
        border-radius: 8px;
        border: 2px solid;
    }

    #cad:hover {
        box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
    }

    #hora {
        width: 100px;
        float: left;
        margin-top: -49px;
        margin-left: 220px;
    }

    .data {
        width: 200px;
    }

    .data1 {
        width: 200px;
        margin-top: -74px;
        margin-left: 420px;
    }

    #hora2 {
        width: 100px;
        float: right;
        margin-right: 340px;
        margin-top: -49px;
    }

    #certificado {
        width: 200px;
        float: right;
        margin-right: 50px;
        margin-top: -49px;
    }

    .eventos,
    #user {
        margin-left: 150px;
    }

    #navbarNav {
        font-size: 16px;
    }

    .inicio {
        margin-left: 40px;
    }

    h3 {
        margin-top: 50px;
        text-align: center;
        color: red;
    }

    #selectEvent {
        width: 900px;
    }

    #value {
        width: 150px;
        text-align: center;
        float: right;
        margin-top: -34px;
        /* display: none; */
    }

</style>

<script language='Javascript'>
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //Janeiro é 0, então somamos + 1 para trabalhar com calendário conhecido
    var yyyy = today.getFullYear();
    // Data de hoje mais 5 dias
    dd = dd + 5;
    //se for maior que dia 30 vai para o proximo mês
    if (dd > 30) {
        dd = dd - 30;
        mm = mm + 1;
    }
    //se for maior que 12 vai para o proximo ano
    if (mm > 12) {
        mm = 1;
        yyyy = yyyy + 1;
    }
    // Se for menor que 10 formatamos com um zero na frente Ex: de 9 para 09
    if (dd < 10) {
        dd = '0' + dd;
    }
    // Se for menor que 10 formatamos com um zero na frente Ex: de 9 para 09
    if (mm < 10) {
        mm = '0' + mm;
    }
    today = yyyy + '-' + mm + '-' + dd;
    document.getElementsByClassName("dtAgenda").setAttribute("min", today);
    today = dd + '/' + mm + '/' + yyyy;
    var div = document.getElementById("divDtFutura");
    div.innerText = today;
</script>
<main>
    <?php
    if (
        isset($_SESSION['id']) &&
        $_SESSION['type'] == 0
    ) {
    ?>
        <div class="container">


            <div>
                <?php
                if (session()->get("success")) {
                ?>
                    <h3><?= session()->get("success") ?></h3>
                <?php
                }
                if (session()->get("error")) {
                ?>
                    <h3><?= session()->get("error") ?></h3>
                <?php
                }
                ?>
                <div class="mx-auto">

                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title text-center">Cadastro de Atividade</h2>
                            <?php //var_dump($data); exit;
                            ?>
                            <form class="form-signin" method="post" name='form1'>
                                <div class="form-group">
                                <p id="resultado"></p>
                                    <div class="form-label-group" required>
                                        <select id="selectEvent" name="selectEvent" class="form-control" onChange="update()" required>
                                            <option selected disabled>Eventos</option>
                                            <?php
                                            foreach ($data as $key => $evento) {
                                                echo "<option value='" . $evento['id'] . "'>" .$evento['id'] . " - " . $evento['titulo'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <input type="text" id="value" name="value" class="form-control" disabled>
                                    </div>
                                </div>
                               

                                <div class="form-group">
                                    <div class="form-label-group">
                                        <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Titulo" maxlength="60" minilength="3" required autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <textarea type="text" name="atividade" id="summernote" class="form-control" placeholder="Atividade" autofocus></textarea>
                                    </div>
                                </div>
                                <div class="form-group  data" id="inicial">
                                    <div class="form-label-group">
                                        <label for="">Inicial :</label>
                                        <input type="date" name="datainicial" id="dtAgenda" min="<?php echo date_format(new DateTime($data[0]['dtInicio']), "Y-m-d"); ?>" max="<?php echo date_format(new DateTime($data[0]['dtFim']), "Y-m-d"); ?>" class="form-control" required />
                                                                                                                                          
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="form-label-group">
                                        <input type="time" name="hinicial" id="hora" class="form-control" required />
                                    </div>
                                </div>
                                <div class="form-group data1" id="final">
                                    <div class="form-label-group">
                                        <label for="">Final:</label>
                                        <input type="date" name="datafinal" id="dtAgenda1" min="<?php echo date_format(new DateTime($data[0]['dtInicio']), "Y-m-d"); ?>" max="<?php echo date_format(new DateTime($data[0]['dtFim']), "Y-m-d"); ?>" class="form-control" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <input type="time" name="hfinal" id="hora2" class="form-control" required />

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <select id="certificado" name="certificado" class="form-control">
                                            <option selected disabled>Certificado</option>
                                            <option value="1">Gera certificado</option>
                                            <option value="2">Não gera certificado</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php if (isset($validation)) : ?>
                                        <div class="alert alert-danger" roles="alert">
                                            <?= $validation->listErrors(); ?>
                                        </div>
                                    <?php endif; ?>
                                    <button class="btn btn-primary  text-uppercase" id="cad" type="submit">Cadastrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else {
        // return redirect()->to(base_url('eventos'));
        echo "<h3>Não tem permissão para acessar essa página!</h3>";
    }
    ?>
</main>
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });


    function myFunction() {
        var x = document.getElementById("myDate").min;
        document.getElementById("demo").innerHTML = x;
    }

    function update() {
        var select = document.getElementById('selectEvent');
        var option = select.options[select.selectedIndex];

        document.getElementById('value').value = option.value;
        // document.getElementById('text').value = option.text;
    }
    update();

    

 
</script>
