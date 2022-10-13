<?php
include_once 'php/protecao.php';
require_once 'php/conexao.php';
include_once 'php/crud_db.php';
include_once 'php/tables/tabelas.php';

$id = $_SESSION['id'];
$indexUsuario = new Usuario();
$indexGasto = new Gasto();
$indexEndereco = new Endereco();
$indexPlano = new Planejamento();
$indexProfissao = new Profissao();

$dados = $indexUsuario->find($id);

$tabela = $indexGasto->listaGasto();

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
    <h4>Olá, <?php echo $dados['nome'] ?></h4>
    <!--a href="#modal-L1" id="a">modal</!--a>
    <div-- id="modal-L1" class="modal">
        <div class="modal-content">
            <h3>Atenção!</h3>
            <p>Deseja excluir esse cliente?</p>
        </div>
        <div class="modal-footer">
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">
                <button type="submit" name="btn-deletar" class="btn red">Sim, quero deletar</button>
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
            </form>

        </div>
    </div-->
    <?php
    $dados['lazer'] = 21;
    $dados['investimento'] = 35;
    echo "<input type='hidden' id='lazerid' name='lazername' value='" . $dados['lazer'] . "'>";
    echo "<input type='hidden' id='investeid' name='investename' value='" . $dados['investimento'] . "'>";
    ?>
    <div class="preloader">
        <div class="loader"></div>
    </div>



    <!--div class="darkthemes">
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
    </div-->

    <?php
    $namepage = 'index';
    include_once 'php/header.php';
    ?>

    <!-- div onde estará os dois gráficos -->
    <div class="div_graficos">
        <!-- espaço gráfico 1 -->
        <canvas id="planejamento1"></canvas>

        <!-- espaço gráfico 2 -->
        <canvas id="realidade1"></canvas>


    </div>
    <!-- chama funçao que desenha os gráficos acima -->
    <br>
    <script src="js/graficos.js"></script>
    <br>


    <div class="listas">
        <!-- Gastos fixos, em azul -->
        <br>
        <div class="L1"><br>
            <h2>Fixo</h2>
            <ul>
                <li>Aluguel | 650,00</li>
                <li>Financiamento | 524,66</li>
                <li>Condomínio | 300,00</li>
                <li>Academia | 110,00</li>
                <li>Mensalidade escolar | 256,00</li>
                <li>Plano de saúde | 120,00</li>
                <button class="addLista"><ion-icon name="add"></ion-icon></button>
                <!--div-- class="divAddLista">
                    <div class="column">
                        <input type="text" value="Plano de saúde">
                        <input type="text" value="120,00">
                    </div>
                    <div class="row">
                        <button class="addLista">
                            <ion-icon name="checkmark"></ion-icon>
                        </button>
                    </div>
                </!--div-->
            </ul>


        </div>
        <br>
        <div class="L4"><br>
            <h2>Variável</h2>
            <ul>
                <li>Água | 145,12</li>
                <li>Energia | 341,29</li>
                <li>Alimentação | 231,84</li>
                <button class="addLista">+</button>
                <!--li></li-->
            </ul>
        </div>
        <!-- Gastos com lazer, em laranja -->
        <br>
        <div class="L2"><br>
            <h2>Lazer</h2>
            <ul>
                <li>Netflix | 45,90</li>
                <li>HBO Max | 27,90</li>
                <li>Lanches Ifood | 158,76</li>
                <li>Corridas Uber/99 | 212,37</li>
                <button class="addLista">+</button>
                <!--li></li-->
            </ul>
        </div>
        <!-- Investimento, em verde agua -->
        <br>
        <div class="L3"><br>
            <h2>Investimento</h2>
            <ul>
                <li>Ações | 520,64</li>
                <li>Fundo Imobiliários | 1.121,32</li>
                <li>Previdência Privada | 120,16</li>
                <li>Tesouro Direto | 250,24</li>
                <button class="addLista">+</button>
                <!--li>Ações | </li-->
            </ul>
        </div>
    </div>

    <script src="js/js.js"></script>
    <script src="js/graficos.js"></script>
    <script src="js/selecionador.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="js/load.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="js/materialize.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script>
        M.AutoInit();
    </script>

    <?php include_once 'php/footer.php'; ?>
</body>

</html>