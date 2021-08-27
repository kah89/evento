<script src="https://apis.google.com/_/scs/abc-static/_/js/k=gapi.gapi.en.2cdKFnNWjuc.O/m=auth/rt=j/sv=1/d=1/ed=1/rs=AHpOoo-rZMnae0kdWLu9CWmKEzOTJj_h7w/cb=gapi.loaded_0" nonce="suGVki+3mXoPhFFxRPvpGA" async=""></script>
<style>
    h2 {
        text-align: center;
        padding: 40px;
        color: #092e48;
    }

    p {
        font-size: 25px;
        margin: 20px;
    }

    @media only screen and (min-width: 700px) {
        .session {
            margin-left: 250px;
            text-transform: uppercase;
        }

        .menu {
            margin-left: 250px;
        }

        .nav2 {
            margin-left: 70px;
            margin-right: 70px;
        }

        .sessionUser {
            margin-left: 260px;
            text-transform: uppercase;
        }

    }
</style>
<main id="t3-content">
    <div class="container bg-white" style="padding-bottom: 10em;">
        <?php
        if (count($data) > 0) {
        ?>
            <div>

                <h2>Título: <?php echo " " . $data['titulo'] ?></h2>
            </div>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url("inicio") ?>">Eventos</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url("inicio/listaEvento") . '/' . $data['idEvento'] ?>">Lista-Atividades</a></li>
                    <li class="active breadcrumb-item">Atividade</li>
                </ol>
            </div>
            <div>
                <p> <?php
                    echo $data['atividade'] = htmlspecialchars_decode($data['atividade']);
                    ?></p>

            </div>
        <?php

        } else {
            echo "<h2>Nenhuma atividade cadastrada!</h2>";
        }

        ?>
    </div>
</main>