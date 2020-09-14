


$(document).ready(function() {

   $.getJSON( "/web/json/countdateproducts.json", function(json) {
       var sale   = json[new Date().getFullYear()]['Sale'];
       var rental = json[new Date().getFullYear()]['Rental'];

        /**
         * report sales and rentals for year 
         */
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'line',       
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],               
                datasets: [{
                    label: '# Sales', 
                    data: [
                        sale['January'] ? sale['January'] : '0', 
                        sale['February'] ? sale['February'] : '0',  
                        sale['March'] ? sale['March'] : '0', 
                        sale['April'] ? sale['April'] : '0',  
                        sale['May'] ? sale['May'] : '0', 
                        sale['June'] ? sale['June'] : '0', 
                        sale['July'] ? sale['July'] : '0', 
                        sale['August'] ? sale['August'] : '0', 
                        sale['September'] ? sale['September'] : '0', 
                        sale['October'] ? sale['October'] : '0', 
                        sale['November'] ? sale['November'] : '0', 
                        sale['December'] ? sale['December'] : '0', 
                    ], 
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    
                    borderWidth: 1
                
                }, 
                {
                    label: '# Rentals', 
                    data: [
                        rental['January'] ? rental['January'] : '0', 
                        rental['February'] ? rental['February'] : '0',  
                        rental['March'] ? rental['March'] : '0', 
                        rental['April'] ? rental['April'] : '0',  
                        rental['May'] ? rental['May'] : '0', 
                        rental['June'] ? rental['June'] : '0', 
                        rental['July'] ? rental['July'] : '0', 
                        rental['August'] ? rental['August'] : '0', 
                        rental['September'] ? rental['September'] : '0', 
                        rental['October'] ? rental['October'] : '0', 
                        rental['November'] ? rental['November'] : '0', 
                        rental['December'] ? rental['December'] : '0', 
                    ], 
                    backgroundColor: [
                        'rgba(78, 78, 222, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    
                    borderWidth: 1
                    
                }]
            }, 
                
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    })

   });

   /**
    * 
    */
   $.getJSON( "/web/json/toptenusers.json", function(json) { 

    var list = json;
    var userTop = [];
    var i = 0;
    var result;
    var top = [];
    var t = 0;
    var users = [];
    var userTopSort =[];

    keysSorted = Object.keys(list).sort(function(a,b){return list[a]-list[b]});
    users = keysSorted.reverse();
   

    for(key in json) {
        userTop[i] = json[key];
        i++;
    }

    function compareNumeric(a, b) {
        if (a > b) return 1;
        if (a < b) return -1;
    }

    userTop.sort(compareNumeric);
    result = userTop.reverse();

    while (t < 10) {
        
        userTopSort[t] = users[t];
        top[t] = result[t];
        t++;
    }
    

   /**
    * 
    */
   var ctx = document.getElementById("canvas").getContext('2d');;
   var myChart = new Chart(ctx, {
       type: 'bar',       
       data: {
           labels: userTopSort,               
           datasets: [{
               label: 'listings', 
               data: top, 
               backgroundColor: [
                   'rgba(255, 99, 132, 0.2)',
                   'rgba(54, 162, 235, 0.2)',
                   'rgba(255, 206, 86, 0.2)',
                   'rgba(75, 192, 192, 0.2)',
                   'rgba(153, 102, 255, 0.2)',
                   'rgba(255, 159, 64, 0.2)',
                   'rgba(102, 224, 36, 0.2)',
                   'rgba(245, 214, 61, 0.2)',
                   'rgba(194, 76, 145, 0.2)',
                   'rgba(65, 232, 224, 0.2)'
               ],
               borderColor: [
                   'rgba(255,99,132,1)',
                   'rgba(54, 162, 235, 1)',
                   'rgba(255, 206, 86, 1)',
                   'rgba(75, 192, 192, 1)',
                   'rgba(153, 102, 255,1)',
                   'rgba(255, 159, 64, 1)',
                   'rgba(102, 224, 36, 1)',
                   'rgba(245, 214, 61, 1)',
                   'rgba(194, 76, 145, 1)',
                   'rgba(65, 232, 224, 1)'
               ],
               
               borderWidth: 1
           
           }]
       }, 
           
       options: {
           scales: {
               yAxes: [{
                   ticks: {
                       beginAtZero:true
                   }
               }]
           },
            title: {
                display: true,
                text: 'Most listings by users'
            }
       }
   });

})

