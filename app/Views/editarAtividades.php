<?= $this->extend('default') ?>

<?= $this->section('content') ?>
<link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

<style>
    #cad {
        width: 200px;
        background-color: #008CBA;
        font-size: 12px;
        padding: 12px 28px;
        border-radius: 8px;
        border: 2px solid;
        margin-left: -630px;
    }

    #cad:hover {
        box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
    }

    h2 {
        color: #092e48;
    }

    #hora {
        width: 100px;
        margin-top: 45px;
    }

    .data {
        width: 200px;
    }

    .data1 {
        width: 200px;
        margin-left: 400px;
        margin-top: -72px;
    }

    #hora2 {
        width: 100px;
        float: right;
        margin-right: 380px;
        margin-top: -47px;
        /* margin-left: 620px;
        margin-top: -49px;  */
    }

    #certificado {
        width: 200px;
        float: right;
        margin-right: -400px;
        margin-top: -47px;
    }

    .session {
        margin-left: 250px;
        text-transform: uppercase;
    }



    @media only screen and (min-width: 1200px) {
        .menu {
            margin-left: 250px;
        }

        .nav2 {
            margin-left: 80px;
            margin-right: 80px;
        }

        #navbarNav {
            font-size: 16px;
        }
    }

    body {

        background-color: #F5F5F5;
    }
</style>

<main id="t3-content">
    <div class="container">
        <div>
            <div class=" mx-auto">
                <div class="card">
                    <div class="card-body">
                        <a href="<?= base_url('alterarAtividades') ?>">Voltar</a>
                        <h2 class="card-title text-center">Alteração de Atividade</h2>

                        <form class="form-signin" method="post">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <select id="selectEvent" name="selectEvent" class="form-control" required>
                                        <option selected disabled>Eventos</option>
                                        <?php
                                        foreach ($data as $key => $evento) {
                                            if ($evento['id'] == $idEvento) {
                                                echo "<option value='" . $evento['id'] . "' selected='selected' >" . $evento['id'] . " - " . $evento['titulo'] . "</option>";
                                            } else {
                                                echo "<option value='" . $evento['id'] .  "'>" . $evento['id'] . " - " . $evento['titulo'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Titulo" value="<?= $titulo ?>" required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <textarea type="text" name="atividade" id="summernote" class="form-control" placeholder="Atividade" autofocus> <?= $atividade ?> </textarea>
                                </div>
                            </div>
                            <div class="form-group col-sm-6 data" id="inicial">
                                <div class="form-label-group">
                                    <label for="">Inicial :</label>
                                    <input type="date" name="datainicial" id="dtAgenda" min="<?php foreach ($data as $key => $evento) {
                                                                                                    if ($evento['id'] == $idEvento) {
                                                                                                        echo date_format(new DateTime($evento['dtInicio']), "Y-m-d");
                                                                                                    }
                                                                                                } ?>" max="<?php foreach ($data as $key => $evento) {
                                                                                                                if ($evento['id'] == $idEvento) {
                                                                                                                    echo date_format(new DateTime($evento['dtFim']), "Y-m-d");
                                                                                                                }
                                                                                                            } ?>" class="form-control" value="<?php echo date_format(new DateTime($dtInicio), "Y-m-d"); ?>" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="time" name="hinicial" id="hora" class="form-control" value="<?php echo date_format(new DateTime($dtInicio), "H:i"); ?>" required />
                                </div>
                            </div>
                            <div class="form-group col-sm-6 data1" id="final">
                                <div class="form-label-group">
                                    <label for="">Final:</label>
                                    <input type="date" name="datafinal" id="dtAgenda1" min="<?php foreach ($data as $key => $evento) {
                                                                                                if ($evento['id'] == $idEvento) {
                                                                                                    echo date_format(new DateTime($evento['dtInicio']), "Y-m-d");
                                                                                                }
                                                                                            } ?>" max="<?php foreach ($data as $key => $evento) {
                                                                                                            if ($evento['id'] == $idEvento) {
                                                                                                                echo date_format(new DateTime($evento['dtFim']), "Y-m-d");
                                                                                                            }
                                                                                                        } ?>" class="form-control" value="<?php echo date_format(new DateTime($dtFim), "Y-m-d"); ?>" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="time" name="hfinal" id="hora2" class="form-control" value="<?php echo date_format(new DateTime($dtFim), "H:i"); ?>" required />

                                </div>
                            </div>
                            <div class="form-group col-sm-7">
                                <div class="form-label-group">

                                    <select id="certificado" name="certificado" class="form-control">
                                        <?php


                                        if ((int)$ativ['tipo'] == 1) {
                                            echo '<option value="1" id="1" selected="selected">Gera certificado</option>';
                                            echo '<option value="2" id="2">Não gera certificado</option>';
                                        } else {
                                            echo '<option value="1" id="1">Gera certificado</option>';
                                            echo '<option value="2" id="2" selected="selected">Não gera certificado</option>';
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-md btn-primary  text-uppercase edit" id="cad" type="submit">Alterar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
</script>
<?= $this->endSection() ?>