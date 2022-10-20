var xValues = ["Fixos", "Variáveis", "Lazer", "Investimentos"];
//var yPlanValues = [gfixo, invest, 15];
var barColors = [
   "#a200ff",
   "#38a4fc",
   "#F27D52",
   "#04BF9D",
];

var fixo = document.getElementById("centfixo").value;
var variavel = document.getElementById("centvariavel").value;
var lazer = document.getElementById("centlazer").value;
var invest = document.getElementById("centinvestimento").value;



var yPlanValues = [25, 40, 15, 20];

var yRealValues = [fixo, variavel, lazer, invest];



new Chart("planejamento1", {
   type: "pie",
   data: {
      labels: xValues,
      datasets: [{
         backgroundColor: barColors,
         borderWidth: 2,
         scaleStepWidth: 1,
         data: yPlanValues
      }]
   },
   options: {
      legend: {
         labels: {
            fontColor: "#fff",
            fontSize: 12
         }
      },
      title: {
         display: true,
         text: "Planejamento",
         fontColor: "#fff",
         fontSize: 15

      }
   }
});


new Chart("realidade1", {
   type: "pie",
   data: {
      labels: xValues,
      datasets: [{
         backgroundColor: barColors,
         borderWidth: 2,
         scaleStepWidth: 1,
         data: yRealValues
      }]
   },
   options: {
      legend: {
         labels: {
            fontColor: "#fff",
            fontSize: 12
         }
      },
      title: {
         display: true,
         text: "Realidade",
         fontColor: "#fff",
         fontSize: 15
      }
   }
});


