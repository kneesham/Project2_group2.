let date = new Date().getFullYear();

const createChart = (username, data) => {
    // data will be the array from php.
    let myChart = null;
    let ctx = document.getElementById("myRaceChart").getContext('2d');

    
    let dateSelector = document.getElementById("dateSelector");

    for (let i = date; i >= 2000; i--) {
    
        var option = document.createElement("option");
        option.text = i ;
        dateSelector.add(option);
    }
    

   const generateChart = () => {

        let jan = 0; let feb = 0; let mar = 0; let apr = 0; let may = 0;
        let jun = 0; let jul = 0; let aug = 0; let sep = 0; let oct = 0;
        let nov = 0;let dec = 0;
        // date counters to increment for graphing the data.

        data.forEach(dateString => {
            if(dateString.substring(0,4) === dateSelector.options[dateSelector.selectedIndex].value) {
                // substring(0,4) just gets the year from the string.

                switch (dateString.substring(5,7)) {
                    // substring(5,7) is the month.
                    case '01': {
                        jan++;
                        break;
                    }
                    case '02': {
                        feb++;
                        break;
                    }
                    case '03': {
                        mar++;
                        break;
                    }
                    case '04': {
                        apr++;
                        break;
                    }
                    case '05': {
                        may++;
                        break;
                    }
                    case '06': {
                        jun++;
                        break;
                    }
                    case '07': {
                        jul++;
                        break;
                    }
                    case '08': {
                        aug++;
                        break;
                    }
                    case '09': {
                        sep++;
                        break;
                    }
                    case '10': {
                        oct++;
                        break;
                    }
                    case '11': {
                        nov++;
                        break;
                    }
                    case '12': {
                        dec++;
                        break;
                    }
                }
            }
        });

        
        const dateCounts = [jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec];
        
       if( myChart !== null){
            myChart.destroy();
        }

        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June',
                        'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: username + ' Races Completed in: ' + dateSelector.options[dateSelector.selectedIndex].value,
                    data: dateCounts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.4)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(253, 102, 255, 1)',
                        'rgba(133, 0, 255, 1)',
                        'rgba(153, 152, 255, 1)',
                        'rgba(153, 255, 255, 1)',
                        'rgba(001, 122, 255, 1)',
                        'rgba(125, 210, 20, 1)',
                        'rgba(0, 159, 64, 1)'
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        
                        ticks: {
                            beginAtZero: true,
                            suggestedMax: 7
                        }
                    }]
                }
            }
        });
    }

    generateChart();
    dateSelector.addEventListener("change", generateChart);
   
    // add the event listener so that when the date changes the values are updated.
}