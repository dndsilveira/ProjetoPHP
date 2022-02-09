// ADICIONAR PRODUTO AO CARRINHO
function escolherLoteLocal(intValue, floatValue) {

    var codigoMaterial = intValue;
    var unitarioMaterial = floatValue;

    document.getElementById('quantidadeMaterial').value = "1";
    document.getElementById('unitarioMaterial').value = floatValue.toString().replace(".", ",");
    document.getElementById('totalMaterial').value = floatValue.toString().replace(".", ",");

    var paginaOperacao = 'escolherLoteLocal';

    $.ajax
    ({
        //Configurações
        type: 'POST',//Método que está sendo utilizado.
        dataType: 'html',//É o tipo de dado que a página vai retornar.
        url: 'queryAjax/promocoes.php',//Indica a página que está sendo solicitada.
        //função que vai ser executada assim que a requisição for enviada
        data: {codigoMaterial: codigoMaterial,
        unitarioMaterial: unitarioMaterial,
        paginaOperacao: paginaOperacao,},//Dados para consulta
        //função que será executada quando a solicitação for finalizada.
        success: function (msg)
        {
            $("#lancamentosLoteLocal").html(msg);
        }
    });
}

function incluirProdutoCarrinho(intValue, floatValue, floatValue2, intValue2, intValue3) {


    var paginaOperacao = 'incluirProdutoCarrinho';

    var codigoMaterial = intValue;
    var unitarioMaterial = floatValue;
    var quantidadeMaterial = floatValue2;
    var loteMaterial = intValue2;
    var localMaterial = intValue3;

    if (!codigoMaterial | codigoMaterial <= 0) {
        Toast.fire({
        icon: 'error',
        title: 'Código do produto inválido, por favor insira um código.'
        })
    }

    else {
        if (!quantidadeMaterial | quantidadeMaterial <= 0) {
            Toast.fire({
            icon: 'error',
            title: 'Quantidade inválida, por favor insira uma quantidade.'
            })
        }
        
        else {
    
            if (!unitarioMaterial | unitarioMaterial <= 0) {
                Toast.fire({
                icon: 'error',
                title: 'Valor unitário inválido, por favor insira um valor.'
                })
            }
    
            else {
                for (var i = 0; i < contador; i++) {
                    if (arrayMaterial[i]['codigo'] == (parseInt(codigoMaterial))) {
                        Toast.fire({
                            icon: 'warning',
                            title: 'Atenção, este código já está inserido na lista.'
                        })
                    }
                }
        
                contador++;
            
                arrayMaterial.push({
                    codigo: parseInt(codigoMaterial),
                    quantidade: quantidadeMaterial,
                    unitario: unitarioMaterial,
                    lote: loteMaterial,
                    local: localMaterial,
                });
        
                $.ajax
                ({
                    //Configurações
                    type: 'POST',//Método que está sendo utilizado.
                    dataType: 'html',//É o tipo de dado que a página vai retornar.
                    url: 'queryAjax/promocoes.php',//Indica a página que está sendo solicitada.
                    //função que vai ser executada assim que a requisição for enviada
                    data: {codigoMaterial: codigoMaterial,
                    contador: contador,
                    arrayMaterial: arrayMaterial,
                    paginaOperacao: paginaOperacao,},//Dados para consulta
                    //função que será executada quando a solicitação for finalizada.
                    success: function (msg)
                    {
                        $("#lancamentos").html(msg);
                    }
                });
            }
        }
    }
}