<?php

$mesAtual = intval(date('m'));

if ($_SESSION['parametros']['verSomenteSuasVendas'] == 'N') {

$sql = $pdo->prepare("SELECT Janeiro.Janeiro, Fevereiro.Fevereiro, Marco.Marco, Abril.Abril, Maio.Maio, Junho.Junho,
Julho.Julho, Agosto.Agosto, Setembro.Setembro, Outubro.Outubro, Novembro.Novembro, Dezembro.Dezembro FROM (
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Janeiro FROM Movimento WHERE DataMovimento >= '2021-01-01' AND DataMovimento <= '2021-01-31')
      As Janeiro),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Fevereiro FROM Movimento WHERE DataMovimento >= '2021-02-01' AND DataMovimento <= '2021-02-31')
      As Fevereiro),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Marco FROM Movimento WHERE DataMovimento >= '2021-03-01' AND DataMovimento <= '2021-03-31')
      As Marco),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Abril FROM Movimento WHERE DataMovimento >= '2021-04-01' AND DataMovimento <= '2021-04-31')
      As Abril),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Maio FROM Movimento WHERE DataMovimento >= '2021-05-01' AND DataMovimento <= '2021-05-31')
      As Maio),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Junho FROM Movimento WHERE DataMovimento >= '2021-06-01' AND DataMovimento <= '2021-06-31')
      As Junho),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Julho FROM Movimento WHERE DataMovimento >= '2021-07-01' AND DataMovimento <= '2021-07-31')
      As Julho),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Agosto FROM Movimento WHERE DataMovimento >= '2021-08-01' AND DataMovimento <= '2021-08-31')
      As Agosto),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Setembro FROM Movimento WHERE DataMovimento >= '2021-09-01' AND DataMovimento <= '2021-09-31')
      As Setembro),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Outubro FROM Movimento WHERE DataMovimento >= '2021-10-01' AND DataMovimento <= '2021-10-31')
      As Outubro),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Novembro FROM Movimento WHERE DataMovimento >= '2021-11-01' AND DataMovimento <= '2021-11-31')
      As Novembro),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Dezembro FROM Movimento WHERE DataMovimento >= '2021-12-01' AND DataMovimento <= '2021-12-31')
      As Dezembro)
)");

}

else {

$sql = $pdo->prepare("SELECT Janeiro.Janeiro, Fevereiro.Fevereiro, Marco.Marco, Abril.Abril, Maio.Maio, Junho.Junho,
Julho.Julho, Agosto.Agosto, Setembro.Setembro, Outubro.Outubro, Novembro.Novembro, Dezembro.Dezembro FROM (
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Janeiro FROM Movimento WHERE DataMovimento >= '2021-01-01' AND DataMovimento <= '2021-01-31' AND Vendedor = :vendedor)
      As Janeiro),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Fevereiro FROM Movimento WHERE DataMovimento >= '2021-02-01' AND DataMovimento <= '2021-02-31' AND Vendedor = :vendedor)
      As Fevereiro),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Marco FROM Movimento WHERE DataMovimento >= '2021-03-01' AND DataMovimento <= '2021-03-31' AND Vendedor = :vendedor)
      As Marco),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Abril FROM Movimento WHERE DataMovimento >= '2021-04-01' AND DataMovimento <= '2021-04-31' AND Vendedor = :vendedor)
      As Abril),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Maio FROM Movimento WHERE DataMovimento >= '2021-05-01' AND DataMovimento <= '2021-05-31' AND Vendedor = :vendedor)
      As Maio),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Junho FROM Movimento WHERE DataMovimento >= '2021-06-01' AND DataMovimento <= '2021-06-31' AND Vendedor = :vendedor)
      As Junho),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Julho FROM Movimento WHERE DataMovimento >= '2021-07-01' AND DataMovimento <= '2021-07-31' AND Vendedor = :vendedor)
      As Julho),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Agosto FROM Movimento WHERE DataMovimento >= '2021-08-01' AND DataMovimento <= '2021-08-31' AND Vendedor = :vendedor)
      As Agosto),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Setembro FROM Movimento WHERE DataMovimento >= '2021-09-01' AND DataMovimento <= '2021-09-31' AND Vendedor = :vendedor)
      As Setembro),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Outubro FROM Movimento WHERE DataMovimento >= '2021-10-01' AND DataMovimento <= '2021-10-31' AND Vendedor = :vendedor)
      As Outubro),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Novembro FROM Movimento WHERE DataMovimento >= '2021-11-01' AND DataMovimento <= '2021-11-31' AND Vendedor = :vendedor)
      As Novembro),
   ((SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Dezembro FROM Movimento WHERE DataMovimento >= '2021-12-01' AND DataMovimento <= '2021-12-31' AND Vendedor = :vendedor)
      As Dezembro)
)");
$sql->bindValue(":vendedor", $_SESSION['vendedorLogado']['Codigo']);

}

$sql->execute();

$ticketMedioMes = $sql->fetch();

?>

<div class="content-wrapper">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0">Gráficos</h1>
         </div>
         </div>
      </div>
   </div>

   <section class="content">
   <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Gráfico de ticket médio</h5>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <!--<div class="btn-group">
                  <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-wrench"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" role="menu">
                    <a href="#" class="dropdown-item">Action</a>
                    <a href="#" class="dropdown-item">Another action</a>
                    <a href="#" class="dropdown-item">Something else here</a>
                    <a class="dropdown-divider"></a>
                    <a href="#" class="dropdown-item">Separated link</a>
                  </div>
                </div>-->
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <p class="text-center">
                    <strong>Ticket médio mês a mês</strong>
                  </p>

                  <div class="chart">
                    <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                  </div>
                </div>
                <!-- NÃO VAMOS USAR METAS POR ENQUANTO -->
                <!-- <div class="col-md-4">
                  <p class="text-center">
                    <strong>Goal Completion</strong>
                  </p>

                  <div class="progress-group">
                    Add Products to Cart
                    <span class="float-right"><b>160</b>/200</span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-primary" style="width: 80%"></div>
                    </div>
                  </div>

                  <div class="progress-group">
                    Complete Purchase
                    <span class="float-right"><b>310</b>/400</span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-danger" style="width: 75%"></div>
                    </div>
                  </div>

                  <div class="progress-group">
                    <span class="progress-text">Visit Premium Page</span>
                    <span class="float-right"><b>480</b>/800</span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-success" style="width: 60%"></div>
                    </div>
                  </div>

                  <div class="progress-group">
                    Send Inquiries
                    <span class="float-right"><b>250</b>/500</span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-warning" style="width: 50%"></div>
                    </div>
                  </div>
                </div>-->
              </div>
            </div>
            <!--<div class="card-footer">
               <div class="row">-->
                  <!--<div class="col-sm-12 col-6 text-center mt-5px">
                  <h5 class="description-header">Dados referente à data <?php // echo date('m/Y') ?></h5>
                  </div>-->
                  <!--<div class="col-sm-6 col-6">
                     <div class="description-block border-right">-->
                     <!--<span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> XX%</span>-->
                     <!--<h5 class="description-header text-danger">R$<?php // echo ValidaValor($contasPagarMesAtual); ?></h5>
                     <span class="description-text">CONTAS A PAGAR NO MÊS</span>
                     </div>
                  </div>
                  <div class="col-sm-6 col-6">
                     <div class="description-block">-->
                     <!--<span class="description-percentage text-success"><i class="fas fa-caret-up"></i> XX%</span>-->
                     <!--<h5 class="description-header text-success">R$<?php // echo ValidaValor($contasReceberMesAtual); ?></h5>
                     <span class="description-text">CONTAS A RECEBER NO MÊS</span>
                     </div>
                  </div>-->
                  <!-- NÃO VAMOS USAR POR ENQUANTO -->
                  <!-- <div class="col-sm-3 col-6">
                     <div class="description-block">
                     <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                     <h5 class="description-header">1200</h5>
                     <span class="description-text">GOAL COMPLETIONS</span>
                     </div>
                  </div>-->
                  <!--<div class="col-sm-12 col-6 text-center">
                     <small>Dados considerados a partir do vencimento dos títulos em aberto.</small>
                  </div>
               </div>
            </div>-->
          </div>
        </div>
      </div>
   </section>

<script>

$(function () {
   'use strict'

   /* ChartJS
      * -------
      * Here we will create a few charts using ChartJS
      */

   //-----------------------
   // - MONTHLY SALES CHART -
   //-----------------------

   // Get context with jQuery - using jQuery's .get() method.
   var salesChartCanvas = $('#salesChart').get(0).getContext('2d')

   var salesChartData = {
      labels: [
         <?php
         
         for ($i=0; $i <= ($mesAtual-1); $i++) { 
            switch ($i) {
            case 0: if($i == ($mesAtual-1)) { echo "'Janeiro'"; } else { echo "'Janeiro', "; } break;
            case 1: if($i == ($mesAtual-1)) { echo "'Fevereiro'"; } else { echo "'Fevereiro', "; } break;
            case 2: if($i == ($mesAtual-1)) { echo "'Março'"; } else { echo "'Março', "; } break;
            case 3: if($i == ($mesAtual-1)) { echo "'Abril'"; } else { echo "'Abril', "; } break;
            case 4: if($i == ($mesAtual-1)) { echo "'Maio'"; } else { echo "'Maio', "; } break;
            case 5: if($i == ($mesAtual-1)) { echo "'Junho'"; } else { echo "'Junho', "; } break;
            case 6: if($i == ($mesAtual-1)) { echo "'Julho'"; } else { echo "'Julho', "; } break;
            case 7: if($i == ($mesAtual-1)) { echo "'Agosto'"; } else { echo "'Agosto', "; } break;
            case 8: if($i == ($mesAtual-1)) { echo "'Setembro'"; } else { echo "'Setembro', "; } break;
            case 9: if($i == ($mesAtual-1)) { echo "'Outubro'"; } else { echo "'Outubro', "; } break;
            case 10: if($i == ($mesAtual-1)) { echo "'Novembro'"; } else { echo "'Novembro', "; } break;
            case 11: if($i == ($mesAtual-1)) { echo "'Dezembro'"; } else { echo "'Dezembro', "; } break;
            default: break;
            }
         }

         ?>
      ],
      datasets: [
         {
         label: 'Vendas',
         backgroundColor: 'rgba(40,167,69,0.7)',
         borderColor: 'rgba(40,167,69,1)',
         pointRadius: '3',
         pointBorderColor: 'rgba(40,167,69,1)',
         pointBackgroundColor: 'rgba(40,167,69,1)',
         pointHoverBorderWidth: '4',
         pointColor: '#28a745',
         pointStrokeColor: 'rgba(40,167,69,1)',
         pointHighlightFill: '#fff',
         pointHighlightStroke: 'rgba(40,167,69,1)',
         data: [
            <?php
         
            for ($i=0; $i <= ($mesAtual-1); $i++) { 
               switch ($i) {
                  case 0: if($i == ($mesAtual-1)) { echo TrataInt($ticketMedioMes['Janeiro']); } else { echo TrataInt($ticketMedioMes['Janeiro']).","; } break;
                  case 1: if($i == ($mesAtual-1)) { echo TrataInt($ticketMedioMes['Fevereiro']); } else { echo TrataInt($ticketMedioMes['Fevereiro']).","; } break;
                  case 2: if($i == ($mesAtual-1)) { echo TrataInt($ticketMedioMes['Marco']); } else { echo TrataInt($ticketMedioMes['Marco']).","; } break;
                  case 3: if($i == ($mesAtual-1)) { echo TrataInt($ticketMedioMes['Abril']); } else { echo TrataInt($ticketMedioMes['Abril']).","; } break;
                  case 4: if($i == ($mesAtual-1)) { echo TrataInt($ticketMedioMes['Maio']); } else { echo TrataInt($ticketMedioMes['Maio']).","; } break;
                  case 5: if($i == ($mesAtual-1)) { echo TrataInt($ticketMedioMes['Junho']); } else { echo TrataInt($ticketMedioMes['Junho']).","; } break;
                  case 6: if($i == ($mesAtual-1)) { echo TrataInt($ticketMedioMes['Julho']); } else { echo TrataInt($ticketMedioMes['Julho']).","; } break;
                  case 7: if($i == ($mesAtual-1)) { echo TrataInt($ticketMedioMes['Agosto']); } else { echo TrataInt($ticketMedioMes['Agosto']).","; } break;
                  case 8: if($i == ($mesAtual-1)) { echo TrataInt($ticketMedioMes['Setembro']); } else { echo TrataInt($ticketMedioMes['Setembro']).","; } break;
                  case 9: if($i == ($mesAtual-1)) { echo TrataInt($ticketMedioMes['Outubro']); } else { echo TrataInt($ticketMedioMes['Outubro']).","; } break;
                  case 10: if($i == ($mesAtual-1)) { echo TrataInt($ticketMedioMes['Novembro']); } else { echo TrataInt($ticketMedioMes['Novembro']).","; } break;
                  case 11: if($i == ($mesAtual-1)) { echo TrataInt($ticketMedioMes['Dezembro']); } else { echo TrataInt($ticketMedioMes['Dezembro']).","; } break;
                  default: break;
               }
            }

            ?>
            ]
         }
      ]
  }

   var salesChartOptions = {
   maintainAspectRatio: false,
   responsive: true,
   legend: {
   display: false
   },
   scales: {
   xAxes: [{
      gridLines: {
         display: false
      }
   }],
   yAxes: [{
      gridLines: {
         display: false
      },
      ticks: {
         beginAtZero: true
      }
   }]
   }
  }

  // This will get the first returned node in the jQuery collection.
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart(salesChartCanvas, {
    type: 'line',
    data: salesChartData,
    options: salesChartOptions
  }
  )

})

</script>