<?php

function ValidaString($string) {
   $string = str_replace("'", "", $string);

   return $string;
}

function ValidaValor($float) {
   $float = floatval($float);
   $float = number_format($float, 2, ",", ".");

   return $float;
}

function ValidaValorSql($float) {
   $float = round(floatval($float), 2);

   return $float;
}

function TrataInt($int) {
   if (empty($int)) {
      $int = 0;
   }

   $int = intval($int);

   return $int;
}

function TrataFloat($float) {
   if (empty($float)) {
      $float = 0;
   }

   $float = floatval($float);

   return $float;
}

function TrataString($string) {
   if (empty($string)) {
      $string = '';
   }
    
   return $string;
}

function TrataNulo($valor, $retorno) {

   if ($valor == null || $valor == false) {
      return $retorno;
   }

   else {

      if (empty($valor)) {
         return $retorno;
      }
    
      else {
         return $valor;
      }

   }

}

function salvaOrcamento($pdo, $contadorErro, $carrinho, $primeironome) {

    try {

        if (isset($_SESSION['carrinho']['produtos'][0]['statusExpedicao']) && !empty($_SESSION['carrinho']['produtos'][0]['dataExpedicao'])) {
        
            $pdo->beginTransaction();

            if (isset($_SESSION['carrinho']['dados']['numero'])) {

            $sql = $pdo->prepare("SELECT * FROM NumeroOrcamento ORDER BY Numero");
            $sql->execute();
            $lastIdOrcamento = $sql->fetch();

            $lastIdOrcamento = $lastIdOrcamento['Numero'];

            if (TrataInt($_SESSION['carrinho']['dados']['numero']) == 0) {
                if ($lastIdOrcamento == false) {
                    $sql = $pdo->prepare("INSERT INTO NumeroOrcamento (Numero) VALUES (1)");
                    $sql->execute();
                    $lastIdOrcamento = 1;
                }

                else {
                    if ($lastIdOrcamento == 0) {
                        $sql = $pdo->prepare("UPDATE NumeroOrcamento SET Numero = 1");
                        $sql->execute();
                        $lastIdOrcamento = 1;
                    }

                    else {
                        $lastIdOrcamento++;
                        $sql = $pdo->prepare("UPDATE NumeroOrcamento SET Numero = :numero");
                        $sql->bindValue(":numero", $lastIdOrcamento);
                        $sql->execute();
                    }
                }

                if ($sql->rowCount() <= 0) {
                    $_SESSION['openErrorModal'] = 'Ocorreu um erro ao obter a numeração do pedido, tente novamente.';
                    $pdo->rollback();
                    header("Location: http://solucaosistemasctdv.ddns.net:8081/pedidos");
                    exit;
                }

            }

            else {
                $sql = $pdo->prepare("SELECT Count(Id) as NroOrca FROM Orcamentos WHERE Numero = :numero");
                $sql->bindValue(":numero", TrataInt($_SESSION['carrinho']['dados']['numero']));
                $sql->execute();

                $countId = $sql->fetch();

                if ($countId != false) {
                    if($countId != null) {
                        if (TrataInt($countId) > 1) {
                        $_SESSION['openErrorModal'] = 'Já existe um orçamento com esse número, tente novamente.';
                        $pdo->rollback();
                        header("Location: http://solucaosistemasctdv.ddns.net:8081/pedidos");
                        exit;
                        }
                    }
                }

                $lastIdOrcamento = $_SESSION['carrinho']['dados']['numero'];
            }
            }

            else {
            $sql = $pdo->prepare("SELECT * FROM NumeroOrcamento ORDER BY Numero");
            $sql->execute();
            $lastIdOrcamento = $sql->fetch();

            $lastIdOrcamento = $lastIdOrcamento['Numero'];

            if ($lastIdOrcamento == false) {
                $sql = $pdo->prepare("INSERT INTO NumeroOrcamento (Numero) VALUES (1)");
                $sql->execute();
                $lastIdOrcamento = 1;
            }

            else {
                if ($lastIdOrcamento == 0) {
                    $sql = $pdo->prepare("UPDATE NumeroOrcamento SET Numero = 1");
                    $sql->execute();
                    $lastIdOrcamento = 1;
                }

                else {
                    $lastIdOrcamento = $lastIdOrcamento+1;
                    $sql = $pdo->prepare("UPDATE NumeroOrcamento SET Numero = :numero");
                    $sql->bindValue(":numero", $lastIdOrcamento);
                    $sql->execute();
                }
            }

            if ($sql->rowCount() <= 0) {
                $_SESSION['openErrorModal'] = 'Ocorreu um erro ao obter a numeração do pedido, tente novamente.';
                unset($_SESSION['carrinho']['dados']['numero']);
                $pdo->rollback();
                header("Location: http://solucaosistemasctdv.ddns.net:8081/pedidos");
                exit;
            }
            }

            $sql = $pdo->prepare("INSERT INTO LiberacoesPedido (Numero, Pedido, Faturado, Data, ParcelaMinima, LimitedeCredito, TituloemAtraso,
            SaldodeEstoque, AbaixodaMargemMinima, DescontoAcimadoPermitido, LoteMaior, SPCSerasaBloqueado) VALUES
            (:numero, 'N', '', :data, '', '', '', '', '', '', '', '')");
            $sql->bindValue(":numero", $lastIdOrcamento);
            $sql->bindValue(":data", date('Y/m/d'));
            $sql->execute();

            $sql = $pdo->prepare("INSERT INTO HistoricoOrcamentos (Numero, Data, Horas, Usuario, Situacao, Form, Observacao)
            VALUES (:numero , :data, :hora, :usuario, :novo, 'Portal', :obs)");
            $sql->bindValue(":numero", $lastIdOrcamento);
            $sql->bindValue(":data", date('Y/m/d'));
            $sql->bindValue(":hora", date('H:i'));
            $sql->bindValue(":usuario", $primeironome);

            if (isset($_SESSION['carrinho']['dados']['numero'])) {
            if (TrataInt($_SESSION['carrinho']['dados']['numero']) != 0) {
                $sql->bindValue(":novo", 'Alteracao');
            }

            else {
                $sql->bindValue(":novo", 'Novo');
            }
            }

            else {
            $sql->bindValue(":novo", 'Novo');
            }

            $sql->bindValue(":obs", 'Cliente: '.str_pad(TrataInt($_SESSION['carrinho']['dados']['cliente']), 6, 0).' '.TrataString($_SESSION['carrinho']['dados']['nomecliente']));
            $sql->execute();

            // SE FOR ALTERAÇÃO EU EXCLUO PRA DEPOIS INSERTAR

            if (isset($_SESSION['carrinho']['dados']['numero'])) {
            if (TrataInt($_SESSION['carrinho']['dados']['numero']) != 0) {
                $sql = $pdo->prepare("DELETE FROM orcamentos WHERE Numero = :numero");
                $sql->bindValue(":numero", $_SESSION['carrinho']['dados']['numero']);
                $sql->execute();

                $sql = $pdo->prepare("DELETE FROM orcamentositens WHERE Numero = :numero");
                $sql->bindValue(":numero", $_SESSION['carrinho']['dados']['numero']);
                $sql->execute();
            }
            }

            // COMEÇANDO A GERAR O ORÇAMENTO
            
            $sql = $pdo->prepare("SELECT MAX(Id) AS Ultimo FROM Orcamentos");
            $sql->execute();
            $ultimoIdOrcamentos = $sql->fetch();

            $ultimoIdOrcamentos = TrataInt($ultimoIdOrcamentos['Ultimo'])+1;

            if (isset($_SESSION['carrinho']['dados']['cliente']) && !empty($_SESSION['carrinho']['dados']['cliente']) && $_SESSION['carrinho']['dados']['cliente'] != 0) {
            $sql = $pdo->prepare("SELECT Telefone, InscricaoMunicipal, InscricaoProdutor FROM cliente where codigo = :codigo");
            $sql->bindValue(":codigo", $_SESSION['carrinho']['dados']['cliente']);
            $sql->execute();

            $dadosCliente = $sql->fetch();
            }

            else {
            $dadosCliente['Telefone'] = '';
            $dadosCliente['InscricaoMunicipal'] = '';
            $dadosCliente['InscricaoProdutor'] = '';
            }

            $_SESSION['carrinho']['dados']['tabela'] = 0;
            $_SESSION['carrinho']['dados']['totalprodutos'] = 0;
            
            for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) { 
            
            $_SESSION['carrinho']['dados']['tabela'] += $_SESSION['carrinho']['produtos'][$i]['tabela'];
            $_SESSION['carrinho']['dados']['totalprodutos'] += $_SESSION['carrinho']['produtos'][$i]['unitario'];
            
            }

            $aplicouDesconto = "N";

            if ($_SESSION['carrinho']['dados']['totalprodutos'] < $_SESSION['carrinho']['dados']['tabela']) {
            $aplicouDesconto = "S";
            }

            $cepCliente = "__.___-___";

            if (isset($_SESSION['carrinho']['dados']['cep']) && !empty($_SESSION['carrinho']['dados']['cep'])) {
            $cepCliente = $_SESSION['carrinho']['dados']['cep'];
            }

            $sql = $pdo->prepare("INSERT INTO Orcamentos (Id, Numero, Data, CodigoCliente, NomeCliente, EnderecoCliente, BairroCliente, CidadeCliente,
            NomeCidadeCliente, EstadoCliente, CepCliente, TelefoneCliente, CNPJCliente, InscricaoCliente, InscricaoMunicipal, InscricaoProdutor, Total,
            Vendedor, Frete, TipoFrete, Desconto, Tabela, TipoPagamento, Pedido, Usuario, CondicoesPagamento, ObservacaoOrcamento, Vendedor2, Opcoes, Transporte,
            PedidoOrcamento, Banco, Tipo, Horas, Comissao, ComissaoInterno, DataEntrega, DataOriginalOrcamento, PedVendedor, EnderecoEntrega,
            EnderecoCobranca, NomeObra, ContatoObra, IdTransportadora, IdRedespacho, FretePago, ProfissionalLiberal, ValorSubstituicao,
            DestacarSubstituicao, EnviaObsNotaFiscal, Troca, OutrasDespesas, ObsOrcamento, CentroDeCusto, Categoria, Departamento, Vendedor3, Comissao3,
            PedidoLiberado, Empresa, ComissMontagem, ComissMontagemRepres, StatusExpedicao, AplicouDesconto, Transportadora, Redespacho)
            VALUES (:id, :numero , :data , :codigocliente, :nomecliente, :endereco, :bairro, :codigocidade,
            :nomecidade, :estado, :cep, :telefone, :documento, :inscricao, :municipal, :produtor, :total, :vendedor, :frete, 'C', 0.00, :prazo,
            0, 0, :usuario, :prazo2, :observacoes, :interno, '', '', 'N', :banco, :tipo, :hora, :comissao, :comissaointerno, :dataentrega, :dataoriginal, '', '0', '0', '', '', 0, 0, 'S', 0,
            0.00, 'N', 'N', 'N', 0, ' ', '__.___.____.____.____.____', 0, 0, 0, 0, ' ', 1, 0, 0, ' ', :aplicoudesconto, 0, 0)");
            $sql->bindValue(":id", $ultimoIdOrcamentos);
            $sql->bindValue(":numero", $lastIdOrcamento);
            $sql->bindValue(":data", date('Y/m/d'));
            $sql->bindValue(":codigocliente", $_SESSION['carrinho']['dados']['cliente']);
            $sql->bindValue(":nomecliente", ValidaString($_SESSION['carrinho']['dados']['nomecliente']));
            $sql->bindValue(":endereco", ValidaString($_SESSION['carrinho']['dados']['endereco']));
            $sql->bindValue(":bairro", ValidaString($_SESSION['carrinho']['dados']['bairro']));
            $sql->bindValue(":codigocidade", ValidaString($_SESSION['carrinho']['dados']['cidade']));
            $sql->bindValue(":nomecidade", ValidaString($_SESSION['carrinho']['dados']['nomecidade']));
            $sql->bindValue(":estado", ValidaString($_SESSION['carrinho']['dados']['estado']));
            $sql->bindValue(":cep", ValidaString($cepCliente));
            $sql->bindValue(":telefone", ValidaString($dadosCliente['Telefone']));
            $sql->bindValue(":documento", ValidaString($_SESSION['carrinho']['dados']['documento']));
            $sql->bindValue(":inscricao", ValidaString($_SESSION['carrinho']['dados']['inscricao']));
            $sql->bindValue(":municipal", ValidaString($dadosCliente['InscricaoMunicipal']));
            $sql->bindValue(":produtor", ValidaString($dadosCliente['InscricaoProdutor']));
            $sql->bindValue(":total", ValidaValorSql($_SESSION['carrinho']['dados']['total']));
            $sql->bindValue(":vendedor", TrataInt($_SESSION['carrinho']['dados']['vendedor']));
            $sql->bindValue(":frete", ValidaValorSql($_SESSION['carrinho']['dados']['frete']));
            $sql->bindValue(":prazo", TrataInt($_SESSION['carrinho']['dados']['prazo']));
            $sql->bindValue(":usuario", $primeironome);
            $sql->bindValue(":prazo2", TrataInt($_SESSION['carrinho']['dados']['prazo']));

            if (isset($_SESSION['carrinho']['dados']['observacoesExpedicao']) && !empty($_SESSION['carrinho']['dados']['observacoesExpedicao'])) {
                if (isset($_SESSION['carrinho']['dados']['observacoes']) && !empty($_SESSION['carrinho']['dados']['observacoes'])) {

                    $sql->bindValue(":observacoes", ValidaString($_SESSION['carrinho']['dados']['observacoes'])." - ".ValidaString($_SESSION['carrinho']['dados']['observacoesExpedicao']));

                }

                else {

                    $sql->bindValue(":observacoes", ValidaString($_SESSION['carrinho']['dados']['observacoesExpedicao']));

                }
            }

            else {

                $sql->bindValue(":observacoes", ValidaString($_SESSION['carrinho']['dados']['observacoes']));

            }

            $sql->bindValue(":interno", TrataInt($_SESSION['carrinho']['dados']['interno']));
            $sql->bindValue(":banco", TrataInt($_SESSION['carrinho']['dados']['banco']));
            $sql->bindValue(":tipo", TrataInt($_SESSION['carrinho']['dados']['tipo']));
            $sql->bindValue(":hora", date('H:i'));
            $sql->bindValue(":comissao", ValidaValorSql($_SESSION['carrinho']['dados']['comissao']));
            $sql->bindValue(":comissaointerno", ValidaValorSql($_SESSION['carrinho']['dados']['comissaointerno']));
            $sql->bindValue(":dataentrega", date('Y/m/d'));
            $sql->bindValue(":dataoriginal", date('Y/m/d'));
            $sql->bindValue(":aplicoudesconto", $aplicouDesconto);
            $sql->execute();

            for ($i=0; $i < $_SESSION['carrinho']['contador']; $i++) {

                $sql = $pdo->prepare("INSERT INTO OrcamentosItens (Numero, CodigoProduto, Quantidade, Unitario, Total, Vendedor, Data, Descricao, Vendedor2,
                Tabela, PrecoTabela, TipoMaterial, NF, CodigoKit, Obs, Corte, Medida, CodigoServico, QtdeOriginal, QtdeFaturada, TabelaUnitario, CustoUnitario,
                CodigoBase, SeqBase, Item, UsouPromocao, PrecoPromocao, Lote, Local, DescontoUnitario, ComplementoFormula, QTDEExpedicao, DataExped1, ObsExped1,
                QTDEExpedicao2, DataExped2, ObsExped2, QTDEExpedicao3, DataExped3, ObsExped3, UsuarioExpediu, ReferenciaCredito, Ambiente)
                VALUES (:numero, :produto , :quantidade, :unitario, :total, :vendedor, :data, :nome,  0, 1, :unitario2, 0, ' ', 0, :observacoes,
                0, 0, 0, :quantidade2, :quantidade3, :unitario3, :custo, 0, 0, 0, :usoupromocao , :precopromocao, :lote, :local, 0, 0, :qtdexpedicao, :dataexpedicao, :obsexpedicao, ' ', ' ', ' ',
                ' ', ' ', ' ', ' ', 0, :ambiente)");
                $sql->bindValue(":numero", $lastIdOrcamento);
                $sql->bindValue(":produto", $_SESSION['carrinho']['produtos'][$i]['codigo']);
                $sql->bindValue(":quantidade", $_SESSION['carrinho']['produtos'][$i]['quantidade']);
                $sql->bindValue(":unitario", ValidaValorSql($_SESSION['carrinho']['produtos'][$i]['unitario']));
                $sql->bindValue(":total", ValidaValorSql($_SESSION['carrinho']['produtos'][$i]['total']));
                $sql->bindValue(":vendedor", TrataInt($_SESSION['carrinho']['dados']['vendedor']));
                $sql->bindValue(":data", date('Y/m/d'));
                $sql->bindValue(":nome", ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']));
                $sql->bindValue(":unitario2", ValidaValorSql($_SESSION['carrinho']['produtos'][$i]['unitario']));
                $sql->bindValue(":observacoes", ValidaString($_SESSION['carrinho']['dados']['observacoes']));
                $sql->bindValue(":quantidade2", $_SESSION['carrinho']['produtos'][$i]['quantidade']);
                $sql->bindValue(":quantidade3", $_SESSION['carrinho']['produtos'][$i]['quantidade']);
                $sql->bindValue(":unitario3", ValidaValorSql($_SESSION['carrinho']['produtos'][$i]['unitario']));
                $sql->bindValue(":custo", ValidaValorSql($_SESSION['carrinho']['produtos'][$i]['custo']));
                $sql->bindValue(":ambiente", TrataString(ValidaString($_SESSION['carrinho']['produtos'][$i]['ambiente'])));
                // POR ENQUANTO NAO TRATEI A PROMOÇÃO
                $sql->bindValue(":usoupromocao", 'N');
                $sql->bindValue(":precopromocao", ValidaValorSql($_SESSION['carrinho']['produtos'][$i]['unitario']));
                $sql->bindValue(":lote", TrataInt($_SESSION['carrinho']['produtos'][$i]['lote']));
                $sql->bindValue(":local", TrataInt($_SESSION['carrinho']['produtos'][$i]['local']));

                if (Trim($_SESSION['carrinho']['produtos'][$i]['dataExpedicao']) == "" Or Trim($_SESSION['carrinho']['produtos'][$i]['statusExpedicao']) == "") {

                    $sql->bindValue(":qtdexpedicao", 0);

                }

                else {

                    $sql->bindValue(":qtdexpedicao", ValidaValorSql($_SESSION['carrinho']['produtos'][$i]['quantidade']));

                }

                $sql->bindValue(":dataexpedicao", $_SESSION['carrinho']['produtos'][$i]['dataExpedicao']);
                $sql->bindValue(":obsexpedicao", $_SESSION['carrinho']['produtos'][$i]['statusExpedicao']);
                $sql->execute();

            }

            $sql = $pdo->prepare("SELECT Dias FROM condpagtoitens WHERE IdPagto = :id ORDER BY Dias ASC");
            $sql->bindValue(":id", TrataInt($_SESSION['carrinho']['dados']['prazo']));
            $sql->execute();

            $resultPrazo = $sql->fetchAll();

            $parcelas = $sql->rowCount();

            if ($resultPrazo != false) {

            foreach ($resultPrazo as $prazo) {

                $sql = $pdo->prepare("INSERT INTO orcamentosprazos (Data, Dias, Valor, Numero) VALUES (:data, :dias, :valor, :numero);");
                $sql->bindValue(":data", date('Y/m/d'));
                $sql->bindValue(":dias", $prazo['Dias']);
                $sql->bindValue(":valor", ValidaValorSql($_SESSION['carrinho']['dados']['total']/$parcelas));
                $sql->bindValue(":numero", $lastIdOrcamento);
                $sql->execute();

            }

            }

            $pdo->commit();

            header("Location: http://solucaosistemasctdv.ddns.net:8081/pedidos");

            $_SESSION['openSuccessModal2'] = 'Orçamento número '.$lastIdOrcamento.' salvo com sucesso.';

            unset($_SESSION['carrinho']);

            exit;

        }

        else {

            header("Location: http://solucaosistemasctdv.ddns.net:8081/pedidos");

            $_SESSION['openErrorModal'] = 'Expedição do pedido não encontrada, operação finalizada.';

        }

    }


    catch ( PDOException $e ) { 
        // Falha ao fazer algum insert, então fará o rollback
        $pdo->rollback();
        $contadorErro++;

        echo $e;
        die();

        if ($contadorErro <= 1) {
            salvaOrcamento($pdo, $contadorErro, $_SESSION['carrinho'], $primeironome);
        }

        else {
            $_SESSION['openErrorModal'] = 'Ocorreu um erro de transação, operação finalizada.';
        }
    }
}

?>