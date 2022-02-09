var arrayMaterial = [];

var inputQuantidadeMaterial = document.getElementById("quantidadeMaterial");

// TAB NO INPUT QUANTIDADE
inputQuantidadeMaterial.onblur = function(){
    var quantidadeMaterial = document.getElementById("quantidadeMaterial").value;
    var unitarioMaterial = document.getElementById("unitarioMaterial").value;

    document.getElementById('totalMaterial').value = (Math.round(
    (quantidadeMaterial.toString().replace(",", ".") * unitarioMaterial.toString().replace(",", "."))
    * 100) / 100).toString().replace(".", ",");

}

var inputUnitarioMaterial = document.getElementById("unitarioMaterial");

// TAB NO INPUT QUANTIDADE
inputUnitarioMaterial.onblur = function(){
    var quantidadeMaterial = document.getElementById("quantidadeMaterial").value;
    var unitarioMaterial = document.getElementById("unitarioMaterial").value;
    
    document.getElementById('totalMaterial').value = (Math.round(
    (quantidadeMaterial.toString().replace(",", ".") * unitarioMaterial.toString().replace(",", "."))
    * 100) / 100).toString().replace(".", ",");
    
}