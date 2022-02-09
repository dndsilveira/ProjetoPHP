<?php

session_start();

require '../../app/config.php';

// VERIFICAÇÕES INICIAIS 

require '../../app/verif.php';

// FORMULÁRIOS

require '../../app/forms.php';

// FUNCTIONS

include_once '../../app/functions.php';

$paginaOperacao = $_POST['paginaOperacao'];

switch ($paginaOperacao) {
    case 'incluirProdutoCarrinho':

$codigo = $_POST['codigoMaterial'];
$arrayMaterial = $_POST['arrayMaterial'];

$sql = $pdo->prepare("SELECT codigo FROM material WHERE codigo = :codigo AND Ativo = 'S'");
$sql->bindValue(":codigo", $codigo);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

    if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {
    
        for ($i=0; $i < $_SESSION['contador']; $i++) { 

            $sql = $pdo->prepare("SELECT codigo, nome, estoque, custov, vendav, unidade FROM material WHERE codigo = :codigo AND Ativo = 'S'");
            $sql->bindValue(":codigo", $_SESSION['arrayMaterial'][$i]['codigo']);
            $sql->execute();

            foreach ($sql->fetchAll() as $linha[$i]) {
                $linhaArray[$i] = array(
                'codigo' => $linha[$i]['codigo'],
                'nome' => $linha[$i]['nome']." (".$linha[$i]['unidade'].")",
                'quantidade' => $_SESSION['arrayMaterial'][$i]['quantidade'],
                'unitario' => ValidaValor($_SESSION['arrayMaterial'][$i]['unitario']),
                'custo' => ValidaValor($linha[$i]['custov']),
                'total' => ValidaValor(TrataFloat($_SESSION['arrayMaterial'][$i]['unitario']) * $_SESSION['arrayMaterial'][$i]['quantidade']),
                'lote' => $_SESSION['arrayMaterial'][$i]['lote'],
                'local' => $_SESSION['arrayMaterial'][$i]['local'],
                );

            }

        }

        $_SESSION['carrinho'] = $linhaArray;

        ?>

        <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        Toast.fire({
            icon: 'success',
            title: 'Este produto acaba de ser adicionado ao carrinho.'
        })
        </script>

        <?php

    }

    else {

        for ($i=0; $i < $_SESSION['contador']; $i++) { 

            $sql = $pdo->prepare("SELECT codigo, nome, estoque, custov, vendav, unidade FROM material WHERE codigo = :codigo AND Ativo = 'S'");
            $sql->bindValue(":codigo", $_SESSION['arrayMaterial'][$i]['codigo']);
            $sql->execute();

            foreach ($sql->fetchAll() as $linha[$i]) {
                $linhaArray[$i] = array(
                'codigo' => $linha[$i]['codigo'],
                'nome' => $linha[$i]['nome']." (".$linha[$i]['unidade'].")",
                'quantidade' => $_SESSION['arrayMaterial'][$i]['quantidade'],
                'unitario' => ValidaValor($_SESSION['arrayMaterial'][$i]['unitario']),
                'custo' => ValidaValor(".", ",", $linha[$i]['custov']),
                );

            }

        }

        $_SESSION['carrinho'] = $linhaArray;

        ?>

        <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        Toast.fire({
            icon: 'success',
            title: 'Este produto acaba de ser adicionado ao carrinho.'
        })
        </script>

        <?php

    }

}

else {

    array_pop($_SESSION['arrayMaterial']);

    $_SESSION['contador'] = $_SESSION['contador'] - 1;

    if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {

        for ($i=0; $i < $_SESSION['contador']; $i++) { 

            $sql = $pdo->prepare("SELECT codigo, nome, estoque, custov, vendav, unidade FROM material WHERE codigo = :codigo AND Ativo = 'S'");
            $sql->bindValue(":codigo", $_SESSION['arrayMaterial'][$i]['codigo']);
            $sql->execute();

            foreach ($sql->fetchAll() as $linha[$i]) {
                $linhaArray[$i] = array(
                'codigo' => $linha[$i]['codigo'],
                'nome' => $linha[$i]['nome']." (".$linha[$i]['unidade'].")",
                'quantidade' => $_SESSION['arrayMaterial'][$i]['quantidade'],
                'unitario' => ValidaValor($_SESSION['arrayMaterial'][$i]['unitario']),
                'custo' => ValidaValor($linha[$i]['custov']),
                'lote' => $_SESSION['arrayMaterial'][$i]['lote'],
                'local' => $_SESSION['arrayMaterial'][$i]['local'],
                );

            }

            $_SESSION['carrinho'] = $linhaArray;

        }

    }

    else {

        for ($i=0; $i < $_SESSION['contador']; $i++) { 

            $sql = $pdo->prepare("SELECT codigo, nome, estoque, custov, vendav, unidade FROM material WHERE codigo = :codigo AND Ativo = 'S'");
            $sql->bindValue(":codigo", $_SESSION['arrayMaterial'][$i]['codigo']);
            $sql->execute();

            foreach ($sql->fetchAll() as $linha[$i]) {
                $linhaArray[$i] = array(
                'codigo' => $linha[$i]['codigo'],
                'nome' => $linha[$i]['nome']." (".$linha[$i]['unidade'].")",
                'quantidade' => $_SESSION['arrayMaterial'][$i]['quantidade'],
                'unitario' => ValidaValor($_SESSION['arrayMaterial'][$i]['unitario']),
                'custo' => ValidaValor($linha[$i]['custov']),
                );

            }

        $_SESSION['carrinho'] = $linhaArray;

        }

    }

    ?>

<script>

arrayMaterial.pop();
contador--;

var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
Toast.fire({
    icon: 'error',
    title: 'O produto não foi encontrado ou está inativo.'
})

</script>

<?php

}

  break;

  case 'escolherLoteLocal':

unset($_SESSION['codigoMaterial']);
unset($_SESSION['unitarioMaterial']);

$_SESSION['codigoMaterial'] = $_POST['codigoMaterial'];
$_SESSION['unitarioMaterial'] = $_POST['unitarioMaterial'];

if (!empty($_SESSION['codigoMaterial'])) {

    $sql = $pdo->prepare("SELECT Codigo, Nome, Estoque, Reserva, Unidade FROM Material WHERE Codigo = :codigo AND Ativo = 'S'");
    $sql->bindValue(":codigo", $_SESSION['codigoMaterial']);
    $sql->execute();

    foreach ($sql->fetchAll() as $linha) {

        echo "
        <thead>
        <tr class='text-center'>
        <td colspan='4'>Cód. ".$linha['Codigo']." - ".$linha['Nome']." (".$linha['Unidade'].") - Estoque: ".$linha['Estoque']." - Reserva: ".$linha['Reserva']."</td>
        </tr>
        <tr class='text-center'>
            <th>Lote</th>
            <th>Local</th>
            <th>Estoque</th>
            <th style='width: 25%'>Ações</th>
        </tr>
        </thead>
        <tbody>
        ";

        if ($_SESSION['parametros']['usaLocalPorUsuario'] == 'S') {

            $sql = $pdo->prepare("SELECT CodigoProduto, CodigoLote, CodigoLocal, Estoque FROM LoteMaterial WHERE CodigoProduto = :codigo");
            $sql->bindValue(":codigo", $linha['Codigo']);
            $sql->execute();

            foreach ($sql->fetchAll() as $linhaLoteLocal) {

                if ($linhaLoteLocal['CodigoLocal'] == 999999) {
                    $nomeLocal['Descricao'] = 'PRINCIPAL';
                }

                else {
                    $sql = $pdo->prepare("SELECT Descricao FROM localestoque WHERE Codigo = :codigo");
                    $sql->bindValue(":codigo", $linhaLoteLocal['CodigoLocal']);
                    $sql->execute();
                    $nomeLocal = $sql->fetch();
                }

                if ($linhaLoteLocal['CodigoLote'] == 999999) {
                    $nomeLote['Descricao'] = 'PRINCIPAL';
                }

                else {
                    $sql = $pdo->prepare("SELECT Descricao FROM loteestoque WHERE Codigo = :codigo");
                    $sql->bindValue(":codigo", $linhaLoteLocal['CodigoLote']);
                    $sql->execute();
                    $nomeLote = $sql->fetch();
                }

                $qtdTotal = 0;

                $sql = $pdo->prepare("SELECT * FROM LocalEstoqueUsuarios WHERE CodLocal = :local AND codUsuario = :usuario");
                $sql->bindValue(":local", $linhaLoteLocal['CodigoLocal']);
                $sql->bindValue(":usuario", $info['Id']);
                $sql->execute();

                if ($sql->fetch() != false) {
                    $qtdTotal = $qtdTotal + $linhaLoteLocal['Estoque'];
                }

                else {
                    $qtdTotal = $linhaLoteLocal['Estoque'];
                }

                echo "<tr class='text-center'>";
                    echo "<td>".$nomeLote['Descricao']."</td>";
                    echo "<td>".$nomeLocal['Descricao']."</td>";
                    echo "<td>".$qtdTotal."</td>";
                    echo "<td class='project-actions text-center' style='width: 15%;'>
                            <a class='btn btn-info btn-sm desktop'
                            onclick='incluirProdutoCarrinho(".$linha['Codigo'].", ".floatval($_SESSION['unitarioMaterial']).")'>
                            <i class='fas fa-cart-plus'></i> Adicionar ao carrinho</a>

                            <a class='btn btn-info btn-sm mobile'
                            onclick='incluirProdutoCarrinho(".$linha['Codigo'].", ".floatval($_SESSION['unitarioMaterial']).")'>
                            <i class='fas fa-cart-plus'></i></a>
                        </td>";
                echo "</tr>";

            }
        }

        else {

        }

      echo "</tbody>";

    }
}

?>

<script>
$(function(){
    $('#escolherLoteLocalModal').modal();
});
</script>

<?php

  break;
  
  default:

  break;
}