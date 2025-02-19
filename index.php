<?php
include_once 'php/protecao.php';
require_once 'php/database/conexao.php';
include_once 'php/crud_db.php';
include_once 'php/class/endereco.php';
include_once 'php/class/gasto.php';
include_once 'php/class/planejamento.php';
include_once 'php/class/profissao.php';
include_once 'php/class/usuario.php';

$id = $_SESSION['id'];
$indexUsuario = new Usuario();
$indexGasto = new Gasto();
$indexEndereco = new Endereco();
$indexPlano = new Planejamento();
$indexProfissao = new Profissao();

$dados = $indexUsuario->find($id);

// $tabela = $indexGasto->listaGasto();


$fixo = $indexGasto->findFix($id);
$variavel = $indexGasto->findVar($id);
$invest = $indexGasto->findInvest($id);
$lazer = $indexGasto->findLazer($id);

// $planfix = $indexPlano->findPlanfix($id);
// $planvar = $indexPlano->findPlanvar($id);
// $planinvest = $indexPlano->findPlaninvest($id);
// $planlazer = $indexPlano->findPlanlazer($id);

$sumf = $indexGasto->sumfindFix($id);
$sumv = $indexGasto->sumfindVar($id);
$sumi = $indexGasto->sumfindInvest($id);
$suml = $indexGasto->sumfindLazer($id);


$planejamento = $indexPlano->findPlano($id);

foreach ($planejamento as $plano) {
    $planfixo = $plano['porcentagem_fixo'];
    $planvariavel = $plano['porcentagem_variavel'];
    $planlazer = $plano['porcentagem_lazer'];
    $planinvestimento = $plano['porcentagem_investimento'];
}



foreach ($sumf as $sumfixo) {
    $somafixo = $sumfixo['sum'];
}
foreach ($sumv as $sumvariavel) {
    $somavariavel = $sumvariavel['sum'];
}
foreach ($sumi as $suminvest) {
    $somainvest = $suminvest['sum'];
}
foreach ($suml as $sumlazer) {
    $somalazer = $sumlazer['sum'];
}

$total = $somafixo +  $somavariavel +  $somainvest + $somalazer;
// $totalplano = $planofix + $planovar + $planolaz + $planoinvest;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | <?php echo $dados['nome'] ?></title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <!--link rel="stylesheet" href="css/materialize.min.css"-->
    <link rel="stylesheet" href="css/style.css">

</head>

<body class="index">
    <h4>Olá, <?php echo $dados['nome']; ?></h4>

    <?php

    if ($somafixo != 0 or $somavariavel != 0 or $somainvest != 0 or $somalazer != 0) {


        $centfixo = number_format(($somafixo / $total) * 100, 0, '.', ',');
        $centvariavel = number_format(($somavariavel / $total) * 100, 0, '.', ',');
        $centlazer = number_format(($somalazer / $total) * 100, 0, '.', ',');
        $centinvestimento = number_format(($somainvest / $total) * 100, 0, '.', ',');

        echo "<input type='hidden' id='centfixo' name='investename' value='" . $centfixo . "'>";
        echo "<input type='hidden' id='centvariavel' name='investename' value='" . $centvariavel . "'>";
        echo "<input type='hidden' id='centlazer' name='investename' value='" . $centlazer . "'>";
        echo "<input type='hidden' id='centinvestimento' name='investename' value='" . $centinvestimento . "'>";
    } else {

        echo "<input type='hidden' id='centfixo' name='investename' value='0'>";
        echo "<input type='hidden' id='centvariavel' name='investename' value='0'>";
        echo "<input type='hidden' id='centlazer' name='investename' value='0'>";
        echo "<input type='hidden' id='centinvestimento' name='investename' value='0'>";
    }

    // $planofixo = number_format(($planofix / $totalplano) * 100, 2, '.', ',');
    // $planovariavel = number_format(($planovar / $totalplano) * 100, 2, '.', ',');
    // $planolazer = number_format(($planolaz / $totalplano) * 100, 2, '.', ',');
    // $planoinvestimento = number_format(($planoinvest / $totalplano) * 100, 2, '.', ',');

    echo "<input type='hidden' id='planofixo' name='investename' value='" . $planfixo . "'>";
    echo "<input type='hidden' id='planovariavel' name='investename' value='" . $planvariavel . "'>";
    echo "<input type='hidden' id='planolazer' name='investename' value='" . $planlazer . "'>";
    echo "<input type='hidden' id='planoinvestimento' name='investename' value='" . $planinvestimento . "'>";

    ?>
    <div class="preloader">
        <div class="loader"></div>
    </div>



    <!-- <div class="darkthemes">
        <input type="checkbox" class="checkbox" id="chk">
        <label class="label" for="chk">
            <div class="lua">
                <ion-icon name="moon-sharp"></ion-icon>
            </div>
            <div class="sol">
                <ion-icon name="sunny"></ion-icon>
            </div>
            <div class="ball"></div>
        </label>
    </div> -->

    <?php
    $namepage = 'index';
    include_once 'php/header.php';
    ?>

    <!-- div onde estará os dois gráficos -->
    <div class="div_graficos">
        <!-- espaço gráfico 1 -->
        <canvas id="planejamento"></canvas>
        <!-- espaço gráfico 2 -->
        <canvas id="realidade"></canvas>

        <div class="modal fade" id="grafico_fixo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Fixo</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> -->
                    <div class="modal-body">
                        <canvas id="chart_fixo"></canvas>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="grafico_variavel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Fixo</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> -->
                    <div class="modal-body">
                        <canvas id="chart_variavel"></canvas>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="grafico_lazer" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Fixo</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> -->
                    <div class="modal-body">
                        <canvas id="chart_lazer"></canvas>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="grafico_investimento" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle black">Fixo</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> -->
                    <div class="modal-body">
                        <canvas id="chart_investimento"></canvas>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- chama funçao que desenha os gráficos acima -->
    <br>

    <script src="js/graficos.js"></script>
    <br>

    <div class="listas">
        <!-- Gastos fixos, em azul -->
        <br>
        <div class="L1"><br>
            <!-- Button trigger modal -->
            <button type="button" class="btnbotao fixo" data-toggle="modal" data-target="#grafico_fixo">
                <h2>Fixo<ion-icon name="information-circle"></ion-icon>
                </h2>
            </button>
            <ul id="fixo">
                <?php
                if (count($fixo) > 0) {
                    foreach ($fixo as $linha) {
                ?>
                        <form action="php/crud_delete.php" method="post">
                            <?php
                            echo "<li class='li'>" . $linha['gasto'] . " | " . number_format($linha['valor'], 2, ",", ".");
                            ?>
                            <button type="submit" class="deletagasto" value="<?php echo $linha['id']; ?>" name="deletagasto">
                                <ion-icon name="close-outline"></ion-icon>
                            </button></li>
                            <input type='hidden' class="gastofixo" value='<?php echo $linha['valor'] ?>'>
                            <input type='hidden' class="gastofixonome" value='<?php echo ucfirst($linha['gasto']); ?>'>
                        </form>
                <?php
                    }
                } else {
                    echo "<li>-</li>";
                }
                ?>
                <button class="addLista addFixo" id="addFixo" onclick="openFixo()">
                    <ion-icon name="add-outline"></ion-icon>
                </button>

                <!-- <ul id="menu">
                    <li class="item">HTML</li>
                    <li class="item">CSS</li>
                    <li class="item highlight">JavaScript</li>
                    <li class="item">TypeScript</li>
                </ul> -->

                <!-- <div data-full="true" class="n1 n2 n3 4">
                    <div class="n1 n2 n3">text</div>
                </div>
                <div class="n1 n2 n3">text</div>
                <div class="n1 n2 n3">text</div>
                <div data-full="true" class="n1 n2 n3 4">
                    <div class="n1 n2 n3">text</div>
                </div> -->

                <div class="adcGasto adcFixo" id="adcFixo" hidden>
                    <form action="php/crud_create.php" method="post">
                        <div class="lado">
                            <input type="text" name="gasto" placeholder="Gasto:">
                            <button type="reset" class="addLista subir" onclick="closeFixo()">
                                <ion-icon name="close-outline"></ion-icon>
                            </button>
                        </div>
                        <div class="lado">
                            <input type="text" name="valor" onkeyup="maskMoeda2()" id="dinheiro2" maxlength="14" placeholder="Valor (R$):">
                            <button type="submit" class="addLista subir" name="addFixo">
                                <ion-icon name="checkmark-done"></ion-icon>
                            </button>
                        </div>
                    </form>
                </div>
            </ul>
        </div>

        <br>
        <div class="L4"><br>
            <button type="button" class="btnbotao variavel" data-toggle="modal" data-target="#grafico_variavel">
                <h2>Variável<ion-icon name="information-circle"></ion-icon>
                </h2>
            </button>
            <ul>
                <?php
                if (count($variavel) > 0) {
                    foreach ($variavel as $linha) {
                ?>
                        <form action="php/crud_delete.php" method="post">
                            <?php
                            echo "<li class='li'>" . $linha['gasto'] . " | " . number_format($linha['valor'], 2, ",", "."); ?>
                            <button type="submit" class="deletagasto" value="<?php echo $linha['id']; ?>" name="deletagasto">
                                <ion-icon name="close-outline"></ion-icon>
                            </button></li>
                            <input type='hidden' class="gastovariavel" value='<?php echo $linha['valor'] ?>'>
                            <input type='hidden' class="gastovariavelnome" value='<?php echo ucfirst($linha['gasto']); ?>'>
                        </form>
                <?php
                    }
                } else {
                    echo "<li>-</li>";
                }
                ?>

                <button class="addLista addVariavel" id="addVariavel" onclick='openVariavel()'>
                    <ion-icon name="add"></ion-icon>
                </button>

                <div class="adcGasto adcVariavel" id="adcVariavel" hidden>
                    <form action="php/crud_create.php" method="post">
                        <div class="lado">
                            <input type="text" name="gasto" placeholder="Gasto:">
                            <button type="reset" class="addLista subir" onclick="closeVariavel()">
                                <ion-icon name="close-outline"></ion-icon>
                            </button>
                        </div>
                        <div class="lado">
                            <input type="text" name="valor" onkeyup="maskMoeda3()" id="dinheiro3" maxlength="14" placeholder="Valor (R$):">
                            <button type="submit" class="addLista subir" name="addVariavel">
                                <ion-icon name="checkmark-done"></ion-icon>
                            </button>
                        </div>
                    </form>
                </div>

            </ul>
        </div>
        <!-- Gastos com lazer, em laranja -->
        <br>
        <div class="L2"><br>

            <button type="button" class="btnbotao lazer" data-toggle="modal" data-target="#grafico_lazer">
                <h2>Lazer<ion-icon name="information-circle"></ion-icon>
                </h2>
            </button>
            <ul>
                <?php
                if (count($lazer) > 0) {
                    foreach ($lazer as $linha) {
                ?>
                        <form action="php/crud_delete.php" method="post">
                            <?php
                            echo "<li class='li'>" . $linha['gasto'] . " | " . number_format($linha['valor'], 2, ",", "."); ?>
                            <button type="submit" class="deletagasto" value="<?php echo $linha['id']; ?>" name="deletagasto">
                                <ion-icon name="close-outline"></ion-icon>
                            </button> </li>
                            <input type='hidden' class="gastolazer" value='<?php echo $linha['valor'] ?>'>
                            <input type='hidden' class="gastolazernome" value='<?php echo ucfirst($linha['gasto']); ?>'>
                        </form>
                <?php
                    }
                } else {
                    echo "<li>-</li>";
                }
                ?>

                <button class="addLista addLazer" id="addLazer" onclick="openLazer()">
                    <ion-icon name="add"></ion-icon>
                </button>
                <div class="adcGasto adcLazer" id="adcLazer" hidden>
                    <form action="php/crud_create.php" method="post">
                        <div class="lado">
                            <input type="text" name="gasto" placeholder="Gasto:">
                            <button type="reset" class="addLista subir" onclick="closeLazer()">
                                <ion-icon name="close-outline"></ion-icon>
                            </button>
                        </div>
                        <div class="lado">
                            <input type="text" name="valor" onkeyup="maskMoeda4()" id="dinheiro4" maxlength="14" placeholder="Valor (R$):">
                            <button type="submit" class="addLista subir" name="addLazer">
                                <ion-icon name="checkmark-done"></ion-icon>
                            </button>
                        </div>
                    </form>
                </div>
            </ul>
        </div>
        <!-- Investimento, em verde agua -->
        <br>
        <div class="L3"><br>
            <button type="button" class="btnbotao investimento" data-toggle="modal" data-target="#grafico_investimento">
                <h2>Investimento<ion-icon name="information-circle"></ion-icon>
                </h2>
            </button>
            <ul>
                <?php
                if (count($invest) > 0) {
                    foreach ($invest as $linha) {
                ?>
                        <form action="php/crud_delete.php" method="post">
                            <?php
                            echo "<li class='li'>" . $linha['gasto'] . " | " . number_format($linha['valor'], 2, ",", "."); ?>
                            <button type="submit" class="deletagasto" value="<?php echo $linha['id']; ?>" name="deletagasto">
                                <ion-icon name="close-outline"></ion-icon>
                            </button></li>
                            <input type='hidden' class="gastoinvestimentonome" value='<?php echo ucfirst($linha['gasto']); ?>'>
                            <input type='hidden' class="gastoinvestimento" value='<?php echo $linha['valor']; ?>'>
                        </form>
                <?php

                    }
                } else {
                    echo "<li>-</li>";
                }
                ?>

                <button class="addLista addInvestimento" id="addInvestimento" onclick="openInvestimento()">
                    <ion-icon name="add"></ion-icon>
                </button>
                <div class="adcGasto adcInvestimento" id="adcInvestimento" hidden>
                    <form action="php/crud_create.php" method="post">
                        <div class="lado">
                            <input type="text" name="gasto" placeholder="Gasto:">
                            <button type="reset" class="addLista subir" onclick="closeInvestimento()">
                                <ion-icon name="close-outline"></ion-icon>
                            </button>
                        </div>
                        <div class="lado">
                            <input type="text" name="valor" onkeyup="maskMoeda5()" id="dinheiro5" maxlength="14" placeholder="Valor (R$):">
                            <button type="submit" class="addLista subir" name="addInvestimento">
                                <ion-icon name="checkmark-done"></ion-icon>
                            </button>
                        </div>
                    </form>
                </div>
            </ul>
        </div>
    </div>

    <script src="js/js.js"></script>
    <script src="js/graficos.js"></script>
    <script src="js/mascaras.js"></script>
    <script src="js/selecionador.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="js/load.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="js/materialize.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        M.AutoInit();
        $("#grafico_fixo").modal(options);
    </script>


    <?php include_once 'php/footer.php'; ?>



</body>

</html>
